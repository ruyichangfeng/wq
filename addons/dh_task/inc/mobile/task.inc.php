<?php //
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
 
global $_W,$_GPC;
$webinfo['tabbar'] = "index";

include_once dirname(__FILE__).'/public/public_header.php';

$op = $_GPC['op']?$_GPC['op']:'tasklist';

if($_W['isajax']){
	if($op == 'taskreceive'){
		if(empty($fans['status'])){
			$info = array('status'=>0,'info'=>'你已经被禁止访问');
			exit(json_encode($info));
		}
		if($fans['legalize'] != 1 && $setting['user_legalize'] != 0){
			$info = array('status'=>0,'info'=>'你还没有完成认证，请先认证','par'=>1);
			exit(json_encode($info));
		}
		$id = intval($_GPC['id']);
		if(empty($id)){
			$info = array('status'=>0,'info'=>'参数错误');
			exit(json_encode($info));
		}
		if($setting['follow_task'] == 0 && $_W['fans']['follow'] == 0){
			$info = array('status'=>0,'info'=>'您还没有关注公众号，请关注后再领取任务');
			exit(json_encode($info));
		}
		$where = "";
		$level = $fans['level'];
		$cateid = $fans['cateid'];
		//用户等级匹配
		$where .= " AND ((t.where_type = 1 AND t.where_con LIKE '%|$level|%' ) OR (t.where_type = 2 AND t.where_con < $level) OR (t.where_type = 3 AND t.where_con > $level) OR t.where_type = 0)";
		//用户分类匹配,后台关闭用户认证后不需要进行分类验证
		if($setting['user_legalize'] != 0){
			$where .= " AND (t.cateid = $cateid OR t.is_open = 1)";
		}
		//是否被领完
		$where .= " AND (t.receive < t.task_receive OR t.task_receive = 0)";
		//大于开始时间
		$where .= " AND t.starttime < ".time();
		//小于结束时间
		$where .= " AND t.endtime > ".time();
		$taskinfo = pdo_fetch("SELECT t.*,c.title AS catetitle FROM " . tablename($this->table_task) . "AS t Left Join " . tablename($this->table_task_cate) . " AS c ON t.cateid=c.id WHERE t.weid=:weid AND t.id=:id AND t.status=1".$where, array(':weid' => $weid,':id'=>$id));
		if($taskinfo){
			$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_receive) . " WHERE weid = :weid AND user_id = :userid AND task_id=:taskid AND status!=4", array(':weid' => $weid,':userid'=>$fans['id'],':taskid'=>$id));
			if($total >= $taskinfo['user_receive'] && $taskinfo['user_receive'] != 0){
				$info = array('status'=>'0','info'=>'已达到领取上限');
				exit(json_encode($info));
			}

			if($taskinfo['task_exp']>0){
				if($taskinfo['task_exp'] <= $fans['points']){
					$task_exp = $taskinfo['task_exp'];
					if(!($this->changePoints($fans['id'],-$task_exp,"购买-".$taskinfo['task_title']))){
						$info = array('status'=>0,'info'=>'执行扣除失败');
						exit(json_encode($info));
					}
				}else{
					$info = array('status'=>'0','info'=>$setting['points_name'].'不足');
					exit(json_encode($info));
				}
			}
			$insert = array(
				'weid'=>$weid,
				'user_id'=>$fans['id'],
				'task_id'=>$taskinfo['id'],
				'receive_time'=>time(),
			);
			//如果是第三类型的任务，直接提交审核
			if($taskinfo['auto_review'] == 1 && $taskinfo['is_review'] == 1 && !empty($taskinfo['review_userid'])){
				$this->sendTaskTempMsgToAdmin($taskinfo['review_userid'],$taskinfo['id'],$fans['id'],2);
				$insert['status'] = 3;
			}
			//如果任务不需要审核直接通过
			if($taskinfo['is_review'] == 0 || empty($taskinfo['review_userid'])){
				$insert['status'] = 1;
				if($taskinfo['user_level']>0){
					$level = intval($taskinfo['user_level']);
					pdo_query("update " . tablename($this->table_fans) . " set level=level+{$level} WHERE id = :id",array(":id"=>$fans['id']));
				}
				if($taskinfo['task_points'] > 0){
					if(!($this->changePoints($fans['id'],$taskinfo['task_points'],"任务奖励-".$taskinfo['task_title']))){
						$info = array('status'=>1,'info'=>'任务领取成功，发放奖励失败');
						exit(json_encode($info));
					}
				}
				//不需要审核的任务给用户分配推广奖励
				if($setting['share_taskid'] == 0 || $setting['share_taskid'] == $taskinfo['id']){
					$userinfo = pdo_fetch("SELECT uid,username,nickname FROM ".tablename($this->table_fans)." WHERE id=:id AND weid=:weid",array(':id'=>$taskinfo['user_id'],':weid'=>$weid));
					if($userinfo['uid'] && $setting['is_commission']){
						$where = "";
	                    if($setting['share_taskid'] != 0){
	                        $where .= " AND task_id={$setting['share_taskid']}";
	                    }
						$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_receive) . " WHERE weid=:weid AND user_id=:userid AND status=1".$where, array(':weid' => $weid,':userid'=>$taskinfo['user_id']));
						if($total == 1){
							$username = $userinfo['username']?$userinfo['username']:$userinfo['nickname'];
							$this->changePoints($userinfo['uid'],$setting['share_point'],"推广奖励-".$username);
							pdo_query("update " . tablename($this->table_fans) . " set is_commission=1 WHERE id = :id",array(":id"=>$taskinfo['user_id']));
						}
					}
				}
			}
			//处理用户提交的自定义表单数据
			$fieldsub = $_POST;
			if(!empty($fieldsub) && !empty($taskinfo['fieldset_id'])){
				$filed = pdo_fetchall("SELECT name,type FROM " . tablename($this->table_field) . "WHERE weid = :weid AND fieldset_id=:fieldset_id ORDER BY `sorting` ASC,`id` DESC",array(':weid'=>$weid,':fieldset_id'=>$taskinfo['fieldset_id']));
				$i = 0;
				foreach ($fieldsub as $k3 => $v3) {
					$insert['field'][$i]['type'] = $filed[$i]['type'];
					$insert['field'][$i]['name'] = $filed[$i]['name'];
					$insert['field'][$i]['value'] = $v3;
					$i++;
				}
				$insert['field'] = json_encode($insert['field']);
			}
			if(pdo_insert($this->table_receive, $insert)){
				pdo_query("update " . tablename($this->table_task) . " set receive=receive+1 WHERE id = :id",array(":id"=>$taskinfo['id']));
				$this->sendTaskTempMsgToUser($from_user,$taskinfo['id']);
				if($taskinfo['review_userid'] && $taskinfo['is_review']){
					$this->sendTaskTempMsgToAdmin($taskinfo['review_userid'],$taskinfo['id'],$fans['id']);
				}
				$task_temp_user = $this->getSetting('task_temp_user');
				if(!empty($task_temp_user)){
					$task_temp_user = explode("|",$task_temp_user);
					foreach ($task_temp_user as $key => $value) {
						$this->sendTaskTempMsgToAdmin($value,$taskinfo['id'],$fans['id']);
					}
				}
				$info = array('status'=>'1','info'=>'领取成功');
			}else{
				$info = array('status'=>'0','info'=>'领取失败');
			}
			exit(json_encode($info));
		}else{
			$info = array('status'=>0,'info'=>'无法领取该任务');
			exit(json_encode($info));
		}
	}elseif($op == "taskreceivehis"){//任务领取记录
		$id = intval($_GPC['id']);
		$page = intval($_GPC['page'])>0?intval($_GPC['page']):1;
		$size = intval($_GPC['size'])>0?intval($_GPC['size']):10;
		$limit = " LIMIT ".($page-1)*$size.",".$size;
		$receives = pdo_fetchall("SELECT r.receive_time,f.headimgurl,f.username,f.nickname FROM " . tablename($this->table_receive) . "AS r LEFT JOIN ".tablename($this->table_fans)." AS f ON r.user_id = f.id WHERE r.weid=:weid AND r.task_id=:taskid ORDER BY r.id desc".$limit, array(':weid' => $weid,':taskid'=>$id));
		foreach ($receives as $key => $value) {
			$receives[$key]['receive_time'] = date('Y',$value['receive_time'])!=date("Y",time())?date('Y-m-d H:i',$value['receive_time']):date('m-d H:i',$value['receive_time']);
			$receives[$key]['username'] = $value['username']?$value['username']:$value['nickname'];
		}
		exit(json_encode($receives));
	}
}
if(empty($fans['status'])){
	$info = array('status'=>'error','msg'=>'你已经被禁止访问,请联系管理员');
	include $this->template($this->mobile_tpl . '/info');
	exit;
}
if($fans['legalize'] != 1 && $setting['user_legalize'] == 1){
	header("Location:".$this->createMobileUrl('legalize', array(), true));
	exit;
}
//以上是判断用户状态
if($op == "tasklist"){
	$level = $fans['level'];
	$cateid = $fans['cateid'];
	$nav_id = intval($_GPC['nav_id']);
	$key = trim($_GPC['key']);
	$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
	$size = $setting['page_size'] ? $setting['page_size'] : 10;
	$where = "";
	if($setting['user_level']){//用户等级匹配
		$where .= " AND ((t.where_type = 1 AND t.where_con LIKE '%|$level|%' ) OR (t.where_type = 2 AND t.where_con < $level) OR (t.where_type = 3 AND t.where_con > $level) OR t.where_type = 0)";
	}
	if($setting['user_cate'] && !empty($cateid) && $setting['user_legalize']!=0){//用户分类匹配
		$where .= " AND (t.cateid = $cateid OR t.is_open = 1)";
	}
	if($nav_id){
		$where .= " AND t.nav_id = $nav_id";
	}
	if(!empty($key)){
		$where .= " AND (t.task_title LIKE '%$key%' OR t.task_desc LIKE '%$key%')";
	}
	//以上是条件
	$limit = " LIMIT ".($page - 1) * $size .",".$size;
	//以上是分页
	$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_task) . " AS t WHERE t.weid = :weid AND t.status=1".$where, array(':weid' => $weid));
	$allpage = ceil($total/$size);
	//上一页和下一页
	if($page > 1){
		$prevPage = $this->createMobileUrl('task', array("page"=>($page-1),"key"=>$key),true);
	}
	if($page < $allpage){
		$nextPage = $this->createMobileUrl('task', array("page"=>($page+1),"key"=>$key),true);
	}
	$tasklist = pdo_fetchall("SELECT t.*,c.title AS catetitle,n.title AS navtitle FROM " . tablename($this->table_task) . "AS t Left Join " . tablename($this->table_task_cate) . " AS c ON t.cateid=c.id LEFT JOIN ". tablename($this->table_task_nav) . " AS n ON t.nav_id=n.id WHERE t.weid=:weid AND t.status=1".$where." ORDER BY t.is_top DESC,t.sorting ASC,t.id desc".$limit, array(':weid' => $weid));
	//判断是否可以领取
	foreach ($tasklist as $key => $value) {
		$is_cate = 0;
		if(($fans['cateid'] == $value['cateid']) || $value['is_open'] == 1 || empty($fans['cateid'])){$is_cate = 1;}
		if($setting['user_legalize'] == 0){$is_cate = 1;}
		$is_level = 0;
		if($value['where_type'] == 0){$is_level = 1;}
		if($value['where_type'] == 2 && $value['where_con']<$fans['level']){$is_level = 1;}
		if($value['where_type'] == 3 && $value['where_con']>$fans['level']){$is_level = 1;}
		if($value['where_type'] == 1){
			$where_con = ltrim(rtrim($value['where_con'],'|'),'|');
			$where_con = explode("|",$where_con);
			foreach ($where_con as $k1 => $v1) {
				if($v1 == $fans['level']){
					$is_level = 1;
					break;
				}
			}
		}
		
		if($is_cate && $is_level){
			$tasklist[$key]['is_receive'] = 1;
		}else{
			$tasklist[$key]['is_receive'] = 0;
		}
	}
	$navlist = pdo_fetchall("SELECT id,title FROM " . tablename($this->table_task_nav)  . " WHERE weid = :weid ORDER BY sorting ASC,id DESC", array(':weid'=>$weid));
	$adlist = $this->getAd(1,5);
	include $this->template($this->mobile_tpl . '/tasklist');
}elseif($op == "taskinfo"){
	
	$id = intval($_GPC['id']);
	if(empty($id)){
		$info = array('status'=>'error','msg'=>'参数错误','url'=>'javascript:history.go(-1)');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
	$where = "";
	$level = $fans['level'];
	$cateid = $fans['cateid'];
	if($setting['user_level']){//用户等级匹配
		$where .= " AND ((t.where_type = 1 AND t.where_con LIKE '%|$level|%' ) OR (t.where_type = 2 AND t.where_con < $level) OR (t.where_type = 3 AND t.where_con > $level) OR t.where_type = 0)";
	}
	if($setting['user_cate'] && !empty($cateid)){//用户分类匹配
		$where .= " AND (t.cateid = $cateid OR t.is_open = 1)";
	}
	$taskinfo = pdo_fetch("SELECT t.*,c.title AS catetitle,n.title AS navtitle FROM " . tablename($this->table_task) . " AS t Left Join " . tablename($this->table_task_cate) . " AS c ON t.cateid=c.id LEFT JOIN ". tablename($this->table_task_nav) . " AS n ON t.nav_id=n.id WHERE t.weid=:weid AND t.id=:id AND t.status=1".$where, array(':weid' => $weid,':id'=>$id));
	
	if($taskinfo){
		//处理任务的分享
		$setting['share_title'] = $taskinfo['task_title'];
		$setting['share_desc'] = $taskinfo['task_desc'];
		$setting['share_image'] = $taskinfo['task_image']?$taskinfo['task_image']:$setting['share_image'];
		if($setting['is_commission']){//如果开启分享功能则加上uid
			$setting['share_link'] = $_W["siteroot"]."app/".$this->createMobileUrl("task", array("op"=>"taskinfo","id"=>$id,"uid"=>$fans["id"]), true);
		}else{
			$setting['share_link'] = $_W["siteroot"]."app/".$this->createMobileUrl("task", array("op"=>"taskinfo","id"=>$id), true);
		}
		$webinfo['title']= $taskinfo['task_title'];
		$taskinfo['task_content'] = htmlspecialchars_decode(htmlspecialchars_decode($taskinfo['task_content']));
		$taskinfo['hide_content'] = htmlspecialchars_decode(htmlspecialchars_decode($taskinfo['hide_content']));
		//判断审核人
		if($taskinfo['is_review'] && $taskinfo['review_userid']){
			$reviewuser = pdo_fetch("SELECT username,nickname FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND id=:id", array(':weid' => $weid,':id'=>$taskinfo['review_userid']));
			if($reviewuser){
				$taskinfo['reviewuser'] = $reviewuser['username'] ? $reviewuser['username'] : $reviewuser['nickname'];
			}
		}
		//领取记录
		$receivelist = pdo_fetchall("SELECT r.id,f.headimgurl FROM " . tablename($this->table_receive) . "AS r Left Join " . tablename($this->table_fans) . " AS f ON r.user_id=f.id WHERE r.weid=:weid AND r.task_id=:taskid GROUP BY r.user_id ORDER BY r.id desc LIMIT 7", array(':weid' => $weid,':taskid'=>$taskinfo['id']));
		//判断任务是否可以被领取
		if($fans['cateid'] == $taskinfo['cateid'] || $taskinfo['is_open'] == 1 || empty($fans['cateid'])){$is_cate = 1;}
		if($setting['user_legalize'] == 0){$is_cate = 1;}
		if($taskinfo['where_type'] == 0){
			$is_level = 1;
			$receive_level = "不限制等级";
		}elseif($taskinfo['where_type'] == 2){
			if($taskinfo['where_con']<$fans['level']){
				$is_level = 1;
			}
			$receive_level = "大于".$taskinfo['where_con']."级";
		}elseif($taskinfo['where_type'] == 3){
			if($taskinfo['where_con']>$fans['level']){
				$is_level = 1;
			}
			$receive_level = "小于".$taskinfo['where_con']."级";
		}elseif($taskinfo['where_type'] == 1){
			$where_con = ltrim(rtrim($taskinfo['where_con'],'|'),'|');
			$where_con = explode("|",$where_con);
			foreach ($where_con as $k1 => $v1) {
				if($v1 == $fans['level']){
					$is_level = 1;
					break;
				}
			}
			$receive_level = implode(",",$where_con);
		}
		$receiveinfo="无法领取";
		$is_total=$is_task_receive=$is_starttime=$is_endtime=1;
		$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_receive) . " WHERE weid = :weid AND user_id = :userid AND task_id=:taskid AND status!=4", array(':weid' => $weid,':userid'=>$fans['id'],':taskid'=>$id));
		if($total >= $taskinfo['user_receive'] && $taskinfo['user_receive'] != 0){
			$is_total = 0;
			$receiveinfo="达到上限";
		}
		if($taskinfo['receive'] >= $taskinfo['task_receive'] && $taskinfo['task_receive'] != 0){
			$is_task_receive = 0;
			$receiveinfo="已领完";
		}
		if($taskinfo['starttime'] > time()){
			$is_starttime = 0;
			$receiveinfo="未开始";
		}
		if($taskinfo['endtime'] < time()){
			$is_endtime = 0;
			$receiveinfo="已结束";
		}
		if($is_cate && $is_level && $is_total && $is_task_receive && $is_starttime && $is_endtime){
			$is_receive = 1;//代表可以领取任务
			$receiveinfo = "领取任务";
		}else{
			$is_receive = 0;
		}
		if(!empty($taskinfo['fieldset_id'])){
			$filed = pdo_fetchall("SELECT * FROM " . tablename($this->table_field) . "WHERE weid = :weid AND fieldset_id=:fieldset_id ORDER BY `sorting` ASC,`id` DESC",array(':weid'=>$weid,':fieldset_id'=>$taskinfo['fieldset_id']));
			foreach ($filed as $k2 => $v2) {
				if($v2['type'] == 2){
					$filed[$k2]['list'] = explode("|",$v2['config']);
				}
			}
		}
		include $this->template($this->mobile_tpl . '/taskinfo');
	}else{
		$info = array('status'=>'error','msg'=>'没有该任务或者没有浏览权限','url'=>'javascript:history.go(-1)');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
}elseif($op == "taskreceive"){
	$webinfo['title'] = "任务领取记录";
	$id = intval($_GPC['id']);
	if(empty($id)){
		$info = array('status'=>'error','msg'=>'参数错误','url'=>'javascript:history.go(-1)');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
	include $this->template($this->mobile_tpl . '/taskreceive');
}else{
	$info = array('status'=>'error','msg'=>'你要访问的页面不存在','url'=>'javascript:history.go(-1)');
	include $this->template($this->mobile_tpl . '/info');
	exit;
}
