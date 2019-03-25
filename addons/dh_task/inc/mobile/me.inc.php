<?php //
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */

global $_W,$_GPC;
$webinfo['tabbar'] = "me";
include_once dirname(__FILE__).'/public/public_header.php';

$op = $_GPC['op']?$_GPC['op']:'me';

if($_W['isajax']){
	if($op == "get_points"){//获取积分记录
		$page = intval($_GPC['page'])>0?intval($_GPC['page']):1;
		$size = intval($_GPC['size'])>0?intval($_GPC['size']):10;
		$limit = " LIMIT ".($page-1)*$size.",".$size;
		$points = pdo_fetchall("SELECT points_income,points_desc,points_time FROM " . tablename($this->table_points) . " WHERE weid=:weid AND user_id=:userid ORDER BY id desc".$limit, array(':weid' => $weid,':userid'=>$fans['id']));
		foreach ($points as $key => $value) {
			$points[$key]['points_time'] = date('Y',$value['points_time'])!=date("Y",time())?date('Y-m-d H:i',$value['points_time']):date('m-d H:i',$value['points_time']);
		}
		exit(json_encode($points));
	}elseif($op == "getreview"){//用户审核
		$data["legalize"] = intval($_GPC['type'])?1:0;
		$id = intval($_GPC['id']);
		if(empty($id)){
			$info = array("status"=>0,"info"=>"参数错误");
			exit(json_encode($info));
		}
		$result = pdo_update($this->table_fans, $data, array('id' => $id,'legalize' => 2,'weid'=>$weid));
		if (!empty($result) && !empty($setting['user_points'])) {
			$userinfo = pdo_fetch("SELECT point_gift FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
			if($data["legalize"] && $userinfo['point_gift'] == 0){
				if(!($this->changePoints($id,$setting['user_points'],"新用户赠送"))){
					$info = array('status'=>0,'info'=>$setting['points_name'].'赠送失败');
					exit(json_encode($info));
				}
				pdo_query("update". tablename($this->table_fans) . " set point_gift=1 WHERE id = :id",array(":id"=>$id));		
			}
			$info = array('status'=>1);
			exit(json_encode($info));
		}else{
			$info = array("status"=>0,"info"=>"不存在的用户，或用户状态无法更新");
			exit(json_encode($info));
		}
	}elseif($op == "subreview"){//用户提交任务审核
		$id = intval($_GPC['id']);
		$data['prove'] = htmlspecialchars(trim($_GPC['prove']));
		if(!empty($_GPC['image'])){
			$data['image'] = json_encode($_GPC['image']);
		}
		$data['status'] = 3;
		if(empty($id)){
			$info = array("status"=>0,"info"=>"参数错误");
			exit(json_encode($info));
		}
		$result = pdo_update($this->table_receive, $data, array('id' => $id,'status'=>0,'weid'=>$weid,'user_id'=>$fans['id']));
		if(empty($result)){
			$result = pdo_update($this->table_receive, $data, array('id' => $id,'status'=>2,'weid'=>$weid,'user_id'=>$fans['id']));
		}
		if (!empty($result)) {
			$task_review = pdo_fetch("SELECT t.id,t.review_userid FROM ".tablename($this->table_receive)." AS r LEFT JOIN ".tablename($this->table_task)." AS t ON r.task_id=t.id WHERE r.id=:id AND r.weid=:weid",array(':id'=>$id,'weid'=>$weid));
			$this->sendTaskTempMsgToAdmin($task_review['review_userid'],$task_review['id'],$fans['id'],2);
			$info = array("status"=>1,"info"=>"成功");
		}else{
			$info = array("status"=>0,"info"=>"提交失败");
		}
		exit(json_encode($info));
	}elseif($op == "getreviewtask"){//任务审核
		$data["status"] = intval($_GPC['type'])?1:2;
		$data["evaluate"] = htmlspecialchars(trim($_GPC['evaluate']));
		$data["points"] = intval($_GPC['points']);
		$id = intval($_GPC['id']);
		if(empty($id)){
			$info = array("status"=>0,"info"=>"参数错误");
			exit(json_encode($info));
		}
		//任务提交后不论任务是否需要审核都可以审核
		$task = pdo_fetch("SELECT r.user_id,t.task_points,t.id,t.task_title,t.nav_id,t.user_level FROM ".tablename($this->table_receive)." AS r LEFT JOIN" . tablename($this->table_task) . " AS t ON r.task_id = t.id WHERE r.status=3 AND r.weid=:weid AND r.id=:id AND t.review_userid=:userid", array(':weid' => $weid,':id'=>$id,':userid'=>$fans['id']));
		if(empty($task)){
			$info = array("status"=>0,"info"=>"无法审核此任务");
			exit(json_encode($info));
		}
		if(pdo_update($this->table_receive,$data,array("id"=>$id))){
			$userinfo = pdo_fetch("SELECT uid,username,nickname,from_user FROM ".tablename($this->table_fans)." WHERE id=:id AND weid=:weid",array(':id'=>$task['user_id'],':weid'=>$weid));
			if($data["status"] == 1){//审核通过
				//处理任务积分
				if(!empty($task['task_points'])){
					$this->changePoints($task['user_id'],$task['task_points'],"完成任务-".$task['task_title']);
				}
				//处理积分奖励或扣除
				if(!empty($data["points"])){
					$this->changePoints($task['user_id'],$data["points"],"审核-".$task['task_title']);
				}
				//处理升级任务
				if($task['user_level']>0){
					$level = intval($task['user_level']);
					pdo_query("update " . tablename($this->table_fans) . " set level=level+{$level} WHERE id = :id",array(":id"=>$task['user_id']));
				}
				//给用户分配推广奖励
				
				if($setting['share_taskid'] == 0 || $setting['share_taskid'] == $task['id']){
					if($userinfo['uid'] && $setting['is_commission'] && $setting['manner'] == 2 && $setting['share_point']>0){
						$where = "";
	                    if($setting['share_taskid'] != 0){
	                        $where .= " AND task_id={$setting['share_taskid']}";
	                    }
						$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_receive) . " WHERE weid=:weid AND user_id=:userid AND status=1".$where, array(':weid' => $weid,':userid'=>$task['user_id']));
						if($total == 1){
							$username = $userinfo['username']?$userinfo['username']:$userinfo['nickname'];
							$this->changePoints($userinfo['uid'],$setting['share_point'],"推广奖励-".$username);
							pdo_query("update " . tablename($this->table_fans) . " set is_commission=1 WHERE id = :id",array(":id"=>$task['user_id']));
						}
					}
				}
				$this->sendTaskTempMsgToUser($userinfo['from_user'],$task['id'],2);
			}else{
				$this->sendTaskTempMsgToUser($userinfo['from_user'],$task['id'],3);
			}
			$info = array("status"=>1,"info"=>"审核成功");
			exit(json_encode($info));
		}else{
			$info = array("status"=>0,"info"=>"审核失败");
			exit(json_encode($info));
		}
	}elseif($op == "exittask"){//用户放弃任务
		$id = intval($_GPC['id']);
		if(empty($id)){
			$info = array("status"=>0,"info"=>"参数错误");
			exit(json_encode($info));
		}
		$sta = pdo_query("update " . tablename($this->table_receive) . " set status=4 WHERE weid=:weid AND id=:id AND user_id=:userid AND status=0",array(":weid"=>$weid,":id"=>$id,":userid"=>$fans['id']));
		if($sta){
			$receive = pdo_fetch("SELECT task_id FROM " . tablename($this->table_receive) . " WHERE id=:id AND weid=:weid",array(':id'=>$id,':weid'=>$weid));
			pdo_query("update " . tablename($this->table_task) . " set receive=receive-1 WHERE id = :id",array(":id"=>$receive['task_id']));
			$info = array("status"=>1,"info"=>"成功");
		}else{
			$info = array("status"=>0,"info"=>"放弃失败");
		}
		exit(json_encode($info));
	}elseif($op == "upimage"){//处理图片上传
		global $_W, $_GPC;
        //$access_token = WeAccount::token();
        $media_id = $_GPC['media_id'];
        $account_api = WeAccount::create();
		$token = $account_api->getAccessToken();
		if(is_error($token)){
		    $resarr['status'] = 0;
            $resarr['info'] = '获取accessToken失败';
		    echo json_encode($resarr, true);
        	die;
		}
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=" . $token . "&media_id=" . $media_id;
        $updir = "../attachment/images/" . $_W['uniacid'] . "/" . date("Y", time()) . "/" . date("m", time()) . "/";
        if (!file_exists($updir)) {
            mkdir($updir, 511, true);//创建一个目录
        }
        $randimgurl = "images/" . $_W['uniacid'] . "/" . date("Y", time()) . "/" . date("m", time()) . "/" . date('YmdHis') . rand(1000, 9999) . '.jpg';
        $targetName = "../attachment/" . $randimgurl;
        $ch = curl_init($url);
        $fp = fopen($targetName, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        if (file_exists($targetName)) {
            $resarr['status'] = 1;
            //$this->mkThumbnail($targetName, 640, 0, $targetName);
            if (!empty($_W['setting']['remote']['type'])) {
                load()->func('file');
                $remotestatus = file_remote_upload($randimgurl, true);
                if (is_error($remotestatus)) {
                    $resarr['status'] = 0;
                    $resarr['info'] = '远程附件上传失败，请检查配置并重新上传';
                    file_delete($randimgurl);
                    die(json_encode($resarr));
                } else {
                    file_delete($randimgurl);
                    $resarr['realimgurl'] = $randimgurl;
                    $resarr['imgurl'] = tomedia($randimgurl);
                    $resarr['info'] = '上传成功';
                    die(json_encode($resarr));
                }
            }
            $resarr['realimgurl'] = $randimgurl;
            $resarr['imgurl'] = tomedia($randimgurl);
            $resarr['info'] = '上传成功';
        } else {
            $resarr['status'] = 0;
            $resarr['info'] = '上传失败';
        }
        echo json_encode($resarr, true);
        die;
	}elseif($op == "get_point_propor"){//申请提现
		$account_type = trim($_GPC['account_type']);
		$account = trim($_GPC['account']);
		$point = abs(intval($_GPC['point']));
		if($setting['is_propor'] == 0){
			$info = array('status'=>0,'info'=>'管理员已经关闭提现功能');
		}else{
			if(empty($account_type) || empty($account)){
				$info = array('status'=>0,'info'=>'提现账户不能为空');
			}else{
				if($point>$fans['points']){
					$info = array('status'=>0,'info'=>'超出提现金额');
				}elseif($point<$setting['min_point']){
					$info = array('status'=>0,'info'=>'提现金额小于最小提现金额');
				}else{
					//检查用户是否有在申请中的提现
					$recharge = pdo_fetch("SELECT id,points FROM ".tablename($this->table_recharge)." WHERE weid=:weid AND user_id=:userid AND status=0 ",array(':weid'=>$weid,':userid'=>$fans['id']));
					if($recharge){
						$info = array('status'=>0,'info'=>'你还有申请中的提现，不能提现');
					}else{
						$data = array();
						$data['weid'] = $weid;
						$data['user_id'] = $fans['id'];
						$data['points'] = $point;
						$data['price'] = $point/$setting['point_propor'];
						$data['status'] = 0;//审核中
						$data['time'] = time();
						if(pdo_insert($this->table_recharge,$data)){
							$info = array('status'=>1,'info'=>'提交成功');
							$data = array();
							$data['account_type'] = $account_type;
							$data['account'] = $account;
							pdo_update($this->table_fans,$data,array('id'=>$fans['id']));
						}else{
							$info = array('status'=>0,'info'=>'提交失败');
						}
					}
				}
			}
		}
		exit(json_encode($info));
	}elseif($op == "get_point_propors"){//获取提现记录
		$page = intval($_GPC['page'])>0?intval($_GPC['page']):1;
		$size = intval($_GPC['size'])>0?intval($_GPC['size']):10;
		$limit = " LIMIT ".($page-1)*$size.",".$size;
		$points = pdo_fetchall("SELECT points,price,status,time FROM " . tablename($this->table_recharge) . " WHERE weid=:weid AND user_id=:userid ORDER BY id desc".$limit, array(':weid' => $weid,':userid'=>$fans['id']));
		foreach ($points as $key => $value) {
			$points[$key]['time'] = date('Y',$value['time'])!=date("Y",time())?date('Y-m-d H:i',$value['time']):date('m-d H:i',$value['time']);
		}
		exit(json_encode($points));
	}elseif($op == "get_commission_user"){//获取推广下线
		$page = intval($_GPC['page'])>0?intval($_GPC['page']):1;
		$size = intval($_GPC['size'])>0?intval($_GPC['size']):10;
		$limit = " LIMIT ".($page-1)*$size.",".$size;
		$userlist = pdo_fetchall("SELECT username,nickname,is_commission,dateline FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND uid=:uid ORDER BY id desc".$limit, array(':weid' => $weid,':uid'=>$fans['id']));
		foreach ($userlist as $key => $value) {
			$userlist[$key]['dateline'] = date("Y-m-d H:i",$value['dateline']);
		}
		exit(json_encode($userlist));
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
if($op == "me"){//个人中心
	$is_review_task = pdo_fetch("SELECT id FROM " . tablename($this->table_task) . " WHERE review_userid=:userid AND weid=:weid LIMIT 1", array(':userid' => $fans['id'], ':weid' => $weid));
	$userid = explode("|", $setting['review_user']);
	$is_review_user = 0;
	foreach ($userid as $key => $value) {
		if($value == $fans['id']){
			$is_review_user = 1;
			break;
		}
	}
	$commission_num =  pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND uid=:uid", array(':weid' => $weid,':uid'=>$fans['id']));
	$commission_num_result =  pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND uid=:uid AND is_commission=1", array(':weid' => $weid,':uid'=>$fans['id']));
	include $this->template($this->mobile_tpl . '/me');
}elseif($op == "points"){//收支记录
	$webinfo['title'] = "收支记录";
	
	include $this->template($this->mobile_tpl . '/me_points');
}elseif($op == "userinfo"){//用户信息
	if($fans['legalize'] != 1 && $setting['user_legalize'] != 0){
		header("Location:".$this->createMobileUrl('legalize', array(), true));
		exit;
	}
	$catetitle = pdo_fetch("SELECT title FROM ".tablename($this->table_task_cate)."WHERE id=:id LIMIT 1",array(":id"=>$fans['cateid']));
	include $this->template($this->mobile_tpl . '/me_userinfo');
}elseif($op == "reviewuser"){//用户审核
	$webinfo['title']= "用户审核";
	$where = "";
	$key = trim($_GPC['key']);
	if($key){
		$where .=" AND (f.username LIKE '%$key%' OR f.nickname LIKE '%$key%' OR f.mobile LIKE '%$key%')";
	}
	$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
	$size = 10;
	$limit = " LIMIT ".($page - 1) * $size .",".$size;
	$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " AS f LEFT JOIN ." . tablename($this->table_task_cate) . " AS c ON f.cateid = c.id WHERE f.legalize=2 AND f.weid=:weid".$where, array(':weid' => $weid));
	$allpage = ceil($total/$size);
	//上一页和下一页
	if($page > 1){
		$prevPage = $this->createMobileUrl('me', array('op'=>'reviewuser',"page"=>($page-1),"key"=>$key), true);
	}
	if($page < $allpage){
		$nextPage = $this->createMobileUrl('me', array('op'=>'reviewuser',"page"=>($page+1),"key"=>$key), true);
	}
	$fanslist = pdo_fetchall("SELECT f.id,f.username,f.nickname,f.sex,f.mobile,c.title FROM " . tablename($this->table_fans) . " AS f LEFT JOIN ." . tablename($this->table_task_cate) . " AS c ON f.cateid = c.id WHERE f.legalize=2 AND f.weid=:weid".$where." ORDER BY id desc".$limit, array(':weid' => $weid));
	include $this->template($this->mobile_tpl . '/me_review_user');
}elseif($op == "metask"){//我的任务列表
	//$webinfo['tabbar'] = "task";
	$webinfo['title'] = "我的任务";
	$where = "";
	$key = trim($_GPC['key']);
	if($key){
		$where .=" AND t.task_title LIKE '%$key%'";
	}
	$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
	$size = 10;
	$limit = " LIMIT ".($page - 1) * $size .",".$size;
	$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_receive)."AS r LEFT JOIN ".tablename($this->table_task)." AS t ON r.task_id = t.id WHERE r.weid=:weid AND r.user_id=:userid".$where,array(':weid'=>$weid,':userid'=>$fans['id']));
	$allpage = ceil($total/$size);
	//上一页和下一页
	if($page > 1){
		$prevPage = $this->createMobileUrl('me', array('op'=>'metask',"page"=>($page-1),"key"=>$key), true);
	}
	if($page < $allpage){
		$nextPage = $this->createMobileUrl('me', array('op'=>'metask',"page"=>($page+1),"key"=>$key), true);
	}
	$tasklist = pdo_fetchall("SELECT r.id as rid,r.status,r.receive_time,t.nav_id,r.points,t.task_points,t.task_title,t.task_do_time,n.title AS navtitle FROM ".tablename($this->table_receive)."AS r LEFT JOIN ".tablename($this->table_task)." AS t ON r.task_id = t.id LEFT JOIN ".tablename($this->table_task_nav)." AS n ON t.nav_id = n.id WHERE r.weid=:weid AND r.user_id=:userid".$where." ORDER BY r.id desc".$limit,array(':weid'=>$weid,':userid'=>$fans['id']));
	
	include $this->template($this->mobile_tpl . '/me_task_list');
}elseif($op == "metaskinfo"){//我的任务详情
	$id = intval($_GPC['id']);
	if(empty($id)){
		$info = array('status'=>'error','msg'=>'参数错误','url'=>'javascript:history.go(-1)');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
	$taskinfo = pdo_fetch("SELECT r.id as rid,r.status as r_status,r.receive_time,r.prove,r.evaluate,r.points,r.image,r.field,t.*,c.title,n.title AS navtitle FROM ".tablename($this->table_receive)."AS r LEFT JOIN ".tablename($this->table_task)." AS t ON r.task_id = t.id LEFT JOIN ".tablename($this->table_task_cate)." AS c ON t.cateid=c.id LEFT JOIN ".tablename($this->table_task_nav)." AS n ON t.nav_id = n.id WHERE r.weid=:weid AND r.user_id=:userid AND r.id = :id",array(':weid'=>$weid,':userid'=>$fans['id'],':id'=>$id));
	if($taskinfo){
		$webinfo['title']= "任务详情";
		$taskinfo['hide_content'] = htmlspecialchars_decode(htmlspecialchars_decode($taskinfo['hide_content']));
		$taskinfo['task_content'] = htmlspecialchars_decode(htmlspecialchars_decode($taskinfo['task_content']));
		//判断审核人
		if($taskinfo['is_review'] && $taskinfo['review_userid']){
			$reviewuser = pdo_fetch("SELECT username,nickname FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND id=:id", array(':weid' => $weid,':id'=>$taskinfo['review_userid']));
			if($reviewuser){
				$taskinfo['reviewuser'] = $reviewuser['username'] ? $reviewuser['username'] : $reviewuser['nickname'];
			}
		}
		if($taskinfo['field']){
			$taskinfo['field'] = json_decode($taskinfo['field'],ture);
		}
		if($taskinfo['image']){
			//对image字段处理前后的兼容处理
			if(strstr($taskinfo['image'],"[") && strstr($taskinfo['image'],"]")){
				$taskinfo['image'] = json_decode($taskinfo['image'],ture);
			}else{
				$taskinfo['image'] = array(0=>$taskinfo['image']);
			}
		}
		include $this->template($this->mobile_tpl . '/me_task_info');
	}else{
		$info = array('status'=>'error','msg'=>'没有该任务或者没有浏览权限','url'=>'javascript:history.go(-1)');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
}elseif($op == "reviewtask"){//任务审核
	$webinfo['title']= "任务审核";
	$where = "";
	$key = trim($_GPC['key']);
	if($key){
		$where .=" AND (f.username LIKE '%$key%' OR f.nickname LIKE '%$key%' OR f.mobile LIKE '%$key%' OR t.task_title LIKE '%$key%')";
	}
	$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
	$size = 10;
	$limit = " LIMIT ".($page - 1) * $size .",".$size;
	$total = pdo_fetchcolumn("SELECT count(1) FROM ".tablename($this->table_receive)." AS r LEFT JOIN" . tablename($this->table_fans) . " AS f ON r.user_id = f.id LEFT JOIN ." . tablename($this->table_task) . " AS t ON r.task_id = t.id WHERE r.status=3 AND r.weid=:weid AND t.review_userid=:userid AND t.is_review = 1".$where, array(':weid' => $weid,':userid'=>$fans['id']));
	$allpage = ceil($total/$size);
	//上一页和下一页
	if($page > 1){
		$prevPage = $this->createMobileUrl('me', array('op'=>'reviewtask',"page"=>($page-1),"key"=>$key), true);
	}
	if($page < $allpage){
		$nextPage = $this->createMobileUrl('me', array('op'=>'reviewtask',"page"=>($page+1),"key"=>$key), true);
	}
	$tasklist = pdo_fetchall("SELECT f.username,f.nickname,f.mobile,t.task_title,t.nav_id,t.task_points,r.id,r.prove,r.receive_time,r.image,r.field,n.title AS navtitle FROM ".tablename($this->table_receive)." AS r LEFT JOIN" . tablename($this->table_fans) . " AS f ON r.user_id = f.id LEFT JOIN ." . tablename($this->table_task) . " AS t ON r.task_id = t.id LEFT JOIN ".tablename($this->table_task_nav)." AS n ON t.nav_id = n.id WHERE r.status=3 AND r.weid=:weid AND t.review_userid=:userid".$where." ORDER BY id desc".$limit, array(':weid' => $weid,':userid'=>$fans['id']));
	foreach ($tasklist as $key => $value) {
		$tasklist[$key]['field'] = json_decode($value['field'],true);
		$tasklist[$key]['username'] = $value['username']?$value['username']:$value['nickname'];
		if($tasklist[$key]['image']){
			//对image字段处理前后的兼容处理
			if(strstr($value['image'],"[") && strstr($value['image'],"]")){
				$tasklist[$key]['image'] = json_decode($value['image'],ture);
			}else{
				$tasklist[$key]['image'] = array(0=>$value['image']);
			}
		}
	}
	$taskjson = json_encode($tasklist);
	include $this->template($this->mobile_tpl . '/me_review_task');
}elseif($op == "point_propor"){//积分提现
	$webinfo['title']= "提现中心";
	if($setting['is_propor'] == 0){
		$info = array('status'=>'error','msg'=>'管理员已经关闭提现功能，无法访问');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
	include $this->template($this->mobile_tpl . '/me_point_propor');
}elseif($op == "commission"){//推广链接
	if($setting['is_commission']){
		$webinfo['title']= "我的推广链接";
		if($fans['qrcode'] && @fopen( $fans['qrcode'], 'r' )){

		}else{
			$image = $this->fm_qrcode($_W['siteroot']."app/".$this->createMobileUrl('task', array('uid'=>$fans['id']), true));
			$data = array();
			$data['qrcode'] = $image;
			pdo_update($this->table_fans,$data,array('id'=>$fans['id']));
			$fans['qrcode'] = $image;
		}
		include $this->template($this->mobile_tpl . '/me_commission');
	}else{
		$info = array('status'=>'error','msg'=>'管理员关闭了分销功能，无法访问');
		include $this->template($this->mobile_tpl . '/info');
		exit;
	}
	
}elseif($op = "commission_result"){//推广成果
	$webinfo['title'] = "推广成果";
	
	include $this->template($this->mobile_tpl . '/me_commission_result');
}else{
	$info = array('status'=>'error','msg'=>'你要访问的页面不存在','url'=>'javascript:history.go(-1)');
	include $this->template($this->mobile_tpl . '/info');
	exit;
}