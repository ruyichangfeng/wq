<?php
/**
 * 活动报名模块微站定义
 *
 * @author 奔跑的蜗牛
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define("MODULE_NAME", "fx_activity");
require IA_ROOT . '/addons/' . MODULE_NAME . '/core/common/defines.php';
require FX_CORE . 'class/loader.class.php';
fx_load()->func('global');
fx_load()->func('pdo');
fx_load()->model('member');
class Fx_activityModuleSite extends WeModuleSite {
	function __construct(){
		global $_W,$_GPC;
		if($_GPC['c']== 'entry'){
			if (intval($_W['account']['level']) < 4 && $_W['account']['oauth']['acid']==$_W ['uniacid']) {
				message ('获取用户信息权限不足！请借用第三方权限即可。');
			}else{
				if (empty($_W['fans']['nickname'])){
					$_W['openid'] = getOpenid();
					$_W['fans'] = mc_oauth_userinfo();
				}else{
					$_W['openid'] = $_W['fans']['openid'];
				}
			}
		}
	}
	
	public function doWebActivity() {
		//这个操作被定义用来呈现 管理中心活动主题
		global $_W, $_GPC; 
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if (empty ( $_GPC ['op'] ) && pdo_count('fx_activity') == 0) { 	 	
			$operation = 'post';
		}
		
		if ($operation == 'post') {
			$activityid = intval ( $_GPC ['activityid'] );
			if (! empty ( $activityid )) {
				$activity = pdo_fetch ("SELECT * FROM " . tablename('fx_activity') . " WHERE id =" . $activityid);
				$activity['atlas'] = unserialize($activity['atlas']);
				$activity['prize'] = unserialize($activity['prize']);
				if (empty ( $activity )) {
					message ('抱歉，主题不存在或是已经删除！', '', 'error');
				}
			}
			
			if (checksubmit('submit')) {
				if (empty ( $_GPC ['title'] )) {
					message ('请输入活动主题名称');
				}
				if (empty ( $_GPC ['unit'] )) {
					message ('请输入主办方名称');
				}
				if(empty ( $_GPC ['activityTime']['start'] )){
					message ('请选择开始日期');
				}
				if(empty ( $_GPC ['activityTime']['end'] )){
					message ('请选择截止日期');
				}
				if(strtotime($_GPC ['begintime'])-strtotime($_GPC ['endtime'] ) >= 0 ){
					//message ('开始日期不能晚于截止日期');
				}

				$data = array (
						'uniacid' 	=> $_W ['uniacid'],
						'title' 	=> $_GPC ['title'],
						'unit' 		=> $_GPC ['unit'],
						'tel' 		=> $_GPC ['tel'],
						'detail' 	=> htmlspecialchars_decode($_GPC ['detail']),
						'starttime' => $_GPC ['activityTime']['start'],
						'endtime' 	=> $_GPC ['activityTime']['end'],
						'joinstime' => $_GPC ['joinTime']['start'],
						'joinetime' => $_GPC ['joinTime']['end'],
						'thumb' 	=> $_GPC ['thumb'],
						'atlas' 	=> serialize($_GPC ['img']),
						'personnum' => $_GPC ['personnum'],
						'lng' 		=> $_GPC ['map']['lng'],
						'lat' 		=> $_GPC ['map']['lat'],
						'address' 	=> $_GPC ['address'],
						'sharetitle'=> $_GPC ['share']['title'],
						'sharedesc' => $_GPC ['share']['desc'],
						'sharepic'  => $_GPC ['share']['pic'],
						'prize' 	=> serialize($_GPC ['prize'])
				);
				
				if (! empty ( $activityid )) {
					pdo_update ('fx_activity', $data, array (
							'id' => $activityid 
					) );
					if ($_GPC ['thumb']!=$_GPC['thumb_old']){
						load()->func('file');
						file_delete($_GPC['thumb_old']);
					}
				} else {
					pdo_insert ('fx_activity', $data );
					$activityid = pdo_insertid();
				}
				message ('更新成功！', $this->createWebUrl ('activity', array ('op' => 'display')), 'success');
			}
		} else if ($operation == 'delete') {
			$activityid = intval ( $_GPC ['activityid'] );
			$row = pdo_fetch ("SELECT id,thumb FROM " . tablename ('fx_activity') . " WHERE id = " . $activityid );
			if (empty ($row)) {
				message ('抱歉，主题不存在或是已经被删除！');
			}
			load()->func('file');
			file_delete($row['thumb']);
			pdo_delete ('fx_activity', array ('id' => $activityid));
			die(json_encode(array("errno" => 0,'message'=>'删除成功')));
			exit;
		} else if ($operation == 'display') {
			//活动排序 Start
			if(checksubmit()){
				$displayorder=$_GPC['displayorder'];
				$ids = $_GPC['ids'];
				for($i=0;$i<count($ids);$i++){
					pdo_update("fx_activity",array('displayorder'=>$displayorder[$i]),array('id'=>$ids[$i]));
				}
				message('活动排序保存成功', $this->createWebUrl ('activity', array ('op' => 'display')), 'success');
			}
			$pindex = max(1, intval($_GPC['page']));		
			//当前页码
			$psize = 10;
			//设置分页大小
			$condition = " uniacid = '{$_W['uniacid']}'";
			$list = pdo_fetchall ("SELECT * FROM " . tablename ('fx_activity') . " WHERE $condition ORDER BY displayorder DESC,id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity') . " WHERE $condition");
			//记录总数
			$pager = pagination($total, $pindex, $psize);
		}
		include $this->template ('activity');
	}
	
	public function doWebRecords() {
		//这个操作被定义用来呈现 管理中心报名记录
		global $_W, $_GPC; 
		$activityid = intval ( $_GPC ['activityid'] );
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));		
			//当前页码
			$psize = 10;
			//设置分页大小
			$condition = " uniacid = '{$_W['uniacid']}'";
			if (!empty($_GPC['activityid'])) {
				$condition .= " AND activityid = {$_GPC['activityid']}";
			}
			if (!empty($_GPC['keyword'])) {
				$condition .= " AND (username LIKE '%{$_GPC['keyword']}%' or mobile LIKE '%{$_GPC['keyword']}%' or nickname LIKE '%{$_GPC['keyword']}%')";
			}
			$activity = pdo_fetchall ("SELECT * FROM " . tablename ('fx_activity') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY id DESC");
			$records = pdo_fetchall ("SELECT * FROM " . tablename ('fx_activity_records') . " WHERE $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity_records') . " WHERE $condition");
			//记录总数
			$pager = pagination($total, $pindex, $psize);
		} elseif ($operation == 'status') {
			$id = $_GPC['id'];
			if (is_array($id)){
				foreach ($_GPC['id'] as $k => $bid) {
					$rid = intval($bid);
					if ($rid == 0)
					continue;			
					$result = pdo_update ('fx_activity_records', array('status' => 0), array ('id' => $rid));
				}
				die(json_encode(array("errno" => 0,'message' => '审核成功！')));
			}else{
				$status = $_GPC['status'];
				$result = pdo_update ('fx_activity_records', array('status' => $status), array ('id' => $id));
				die(json_encode(array("errno" => $result ? 0 : 1)));
			}
			exit;
		} elseif ($operation == 'delete') {
			load()->func('file');
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT id,pic FROM " . tablename('fx_activity_records') . " WHERE id = $id");
			if (empty($row)) {
				message('抱歉，用户不存在或是已经被删除！', $this->createWebUrl('records', array('op' => 'display')), 'error');
			}

			file_delete($row['pic']);
			pdo_delete('fx_activity_records', array('id' => $id));
			//message('删除成功！', referer(), 'success');系统提示
			die(json_encode(array("errno" => 0,'message'=>'删除成功')));
			exit;

		} elseif ($operation == 'deleteArr') {
			load()->func('file');
			if ($_GPC['id']==''){
				echo json_encode(array('code' => 300));
				exit;
			}
			foreach ($_GPC['id'] as $k => $bid) {
				$id = intval($bid);
				if ($id == 0)
				continue;			
				$row = pdo_fetch("SELECT id,pic FROM " . tablename('fx_activity_records') . " WHERE id = $id");
				if (empty($row)) {
					echo json_encode(array('code' => 300));
					exit;
				}
				file_delete($row['pic']);
				pdo_delete('fx_activity_records', array('id' => $id));
			}
			die(json_encode(array("errno" => 0,'message'=>'删除成功')));
			exit;
		}  
		include $this->template ('records');
	}
	
	public function doWebMap(){
		global $_W, $_GPC;
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($op =='tencent'){
			include $this->template ('map/map_tencent');
			exit;
		}
	}

	public function doMobileIndex() {
		//这个操作被定义用来呈现 手机端活动列表
		global $_W, $_GPC;
		$config = $this->module['config'];
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		
		$pindex = max(1, intval($_GPC['page']));		
		//当前页码
		$psize = max(1, intval($_GPC['psize']));
		//设置分页大小
		$pagetitle = "活动首页";	
		
		if ($operation=='getjoinnum'){
			$condition = "activityid = {$_GPC['activityid']} and status <> 5";
			$joinnum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity_records') . " WHERE $condition");
			die(json_encode(array("num" => $joinnum)));
			exit;
		}elseif ($operation=='ajax'){
			$condition = " uniacid = '{$_W['uniacid']}'";	
			$field = "id, title, personnum, joinstime, joinetime, starttime, endtime, thumb";
			$activity = pdo_fetchall ("SELECT $field FROM " . tablename ('fx_activity') . " WHERE $condition ORDER BY displayorder DESC,id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity') . " WHERE $condition");	
			//array_merge数组拼接
			$tmp['lists']=$activity;
			$tmp['tpage']=(empty($psize) || $psize < 0) ? 1 : ceil($total / $psize);
			die(json_encode($tmp));
			//include $this->template ('ajax_index');
		}else{
			if ($_W['openid']=='o7CHdvlvTW37Kg51Hmycd0y9EmUk'){
				include $this->template ('index');
			}else{
				include $this->template ('index');
				}
		}
	}
	
	public function doMobileUserlist() {
		//这个操作被定义用来呈现 手机端报名人数展示
		global $_W, $_GPC;
		$config = $this->module['config'];
		$condition = " uniacid = '{$_W['uniacid']}' and status = 0";
		if (!empty($_GPC['activityid'])) {
			$condition .= " AND activityid = {$_GPC['activityid']}";
		}
		$records = pdo_fetchall ("SELECT * FROM " . tablename ('fx_activity_records') . " WHERE $condition ORDER BY id DESC");	
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity_records') . " WHERE $condition");	
		include $this->template ('userlist');
	}
	
	public function doMobileDetail() {
		//这个操作被定义用来呈现 手机端活动详情
		global $_W, $_GPC;
		$activityid = intval ( $_GPC ['activityid'] );
		$config = $this->module['config'];
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		
		if ($operation == 'share') {
			$credit = intval ($_GPC ['credit']);//赠送积分额度
			$creditoff = intval ($_GPC ['creditoff']);//扣除积分额度
			$share_times = intval ($_GPC ['share_times']);//分享获取奖励次数
			$credit_type = $config['credit_type']?$config['credit_type']:1;
			$config['creditstatus'] == 1 ? true : exit;
			$log = pdo_fetch("SELECT COUNT(*) as nums FROM ".tablename('mc_credits_record')." WHERE uniacid=:uniacid and uid=:uid and module=:module and clerk_type=:clerk_type and to_days(FROM_UNIXTIME(createtime))=to_days(now())",array(':uniacid'=>$_W['uniacid'],':uid'=>$_W['member']['uid'],':module'=>MODULE_NAME,':clerk_type'=>1));
			if ($share_times > $log['nums']) {
				fx_load()->model('credit');
				$result = credit_update_credit1($_W['member']['uid'],$credit,$credit_type,"分享获取".$credit.'积分');
				$result ? die(json_encode(array("result" => 1, "data" => $credit))) : die(json_encode(array("result" => 0, "data" => '失败')));
			}else{
				die(json_encode(array("result" => 2, "data" => '您当天分享积分已送完，请明日再领取')));
			}
			exit;
		}elseif($operation == 'favorite') {
		    $data = intval($_GPC['data']) > 0 ? 0 : 1;
			if(!$data){
				$result = pdo_delete('fx_activity_favorite', array('activityid' => $activityid, 'openid' => $_W['openid']));
				die(json_encode(array("result" => $result, "data" => 0)));
				exit;
			}else{
				$result = pdo_insert ('fx_activity_favorite', array (
					'activityid' => $activityid,
					'uniacid' => $_W ['uniacid'],
					'openid' => $_W ['openid']
				) );
				die(json_encode(array("result" => $result, "data" => 1)));
				exit;
			}
		}else{
			$activity = pdo_fetch ("SELECT * FROM " . tablename ('fx_activity') . " WHERE id = " . $activityid );
			$activity['atlas'] = unserialize($activity['atlas']);
			$activity['prize'] = unserialize($activity['prize']);
			$condition = " activityid = $activityid and status = 0";
			$records = pdo_fetchall ("SELECT * FROM " . tablename ('fx_activity_records') . " WHERE $condition ORDER BY id DESC limit 12");
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity_records') . " WHERE $condition ");
			$jion  = pdo_get('fx_activity_records', array('activityid' => $activityid, 'status' => 0,'openid' =>$_W['openid']), array('id'));	
			$favorite  = pdo_get('fx_activity_favorite', array('activityid' => $activityid, 'openid' =>$_W['openid']), array('id'));
			$pagetitle = "活动报名入口";

			include $this->template ('detail');
		}
	}
	
	public function doMobileJoin(){
		//这个操作被定义用来呈现 手机端用户报名
		global $_W, $_GPC;
		$activityid = intval ( $_GPC ['activityid'] );
		$credit = intval ($_GPC ['credit']);//赠送积分额度
		$config = $this->module['config'];
		$pagetitle = "报名入口";	
		if ($config['guanzhu_join']==2 && empty($_W['fans']['follow']))message('您还未关注,不能报名.', $this->createMobileUrl('index'), 'warning');
		$activity = pdo_fetch ("SELECT prize FROM " . tablename ('fx_activity') . " WHERE id = " . $activityid );
		$activity['prize'] = unserialize($activity['prize']);
		if (checksubmit('submit')) {
			if (empty ( $_GPC ['username'] )) {
				//message ('请输入活动主题名称');
			}
			if (empty ( $_GPC ['mobile'] )) {
				//message ('请输入主办方名称');
			}
			$data = array (
					'activityid' => $activityid,
					'uniacid' => $_W['uniacid'],
					'openid' => $_W['fans']['openid'],
					'nickname' => $_W['fans']['nickname'],
					'headimgurl' => $_W['fans']['avatar'],
					'username' => $_GPC['username'],
					'mobile' => $_GPC['mobile'],
					'gender' => empty($_GPC['gender']) ? '保密' : $_GPC['gender'],
					'pic' => $_GPC['pic'],
					'msg' => htmlspecialchars_decode($_GPC ['msg']),
					'status' => $config['reviewstatus']==1 ? 8 : 0
			);
			$condition = "activityid = $activityid and status <> 5 and openid='{$_W ['openid']}'";
			$findUser = pdo_fetch("SELECT id FROM " . tablename ('fx_activity_records') . " WHERE $condition");
			if(!empty($findUser)){
				$_W['page']['title'] = '消息提醒';
				fx_message ('不能重复报名！', $this->createMobileUrl ('detail', array ('activityid' => $activityid)), 'warning');
			}else{
				$condition = "activityid = $activityid and status <> 5";
				$joinnum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('fx_activity_records') . " WHERE $condition");
				$getperson = pdo_get('fx_activity', array('id' => $activityid), array('personnum'));
				if ($joinnum == $getperson['personnum'] && $getperson['personnum'] > 0)message ('您手太慢了，名额已满，谢谢您的光临！', $this->createMobileUrl ('detail', array ('activityid' => $activityid)), 'warning');
				$result = pdo_insert ('fx_activity_records', $data );
				if ($result){
					$credit_type = $config['credit_type']?$config['credit_type']:1;
					if ($config['creditstatus'] == 1 && $activity['prize']['credit'] > 0){
						fx_load()->model('credit');
						$credit_result = credit_update_credit1($_W['member']['uid'],$activity['prize']['credit'],$credit_type,"报名获取".$activity['prize']['credit'].'积分',2);
						$prizedata = $credit_result ? '系统奖励您<font color=" color="#FF7B33">'.$activity['prize']['credit'].'</font>积分':0;
					}
					$_W['page']['title'] = '消息提醒';
					$msg = $config['reviewstatus'] == 1 ? '报名成功！审核通过后，请在我的活动列表中查看。' : '报名成功！';
					fx_message($msg.$prizedata, $this->createMobileUrl ('detail', array ('activityid' => $activityid)), 'success');
				}
			}
		}
		load()->func('tpl');
		include $this->template ('join');
	}
	
	public function doMobileMember(){
		//这个操作被定义用来呈现 手机端用户中心
		global $_W, $_GPC;
		$config = $this->module['config'];
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$pagetitle = "个人中心";	
		$activityid = intval ( $_GPC ['activityid'] );
		$pindex = max(1, intval($_GPC['page']));		
		//当前页码
		$psize = max(1, intval($_GPC['psize']));
		//设置分页大小		
		if ($operation == 'favorite') {
			$pagetitle .= "-我的收藏";	
			if ($_GPC['ac']=='cancel'){
				$result = pdo_delete('fx_activity_favorite', array('id' => $_GPC['fid']));
				die(json_encode(array("result" => $result)));
				exit;
			}elseif ($_GPC['ac']=='ajax'){
				$condition = " B.uniacid = '{$_W['uniacid']}' and A.id = activityid and openid = '{$_W['openid']}'";
				$field  = "B.id, activityid, title, unit, starttime, endtime, joinstime, joinetime, thumb";
				$inner  = tablename ('fx_activity') . " A, " . tablename ('fx_activity_favorite') . " B";
				$list = pdo_fetchall ("SELECT $field FROM " . $inner . " WHERE $condition ORDER BY B.id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . $inner . " WHERE $condition");	
				//array_merge数组拼接
				$tmp['lists']=$list;
				$tmp['tpage']=(empty($psize) || $psize < 0) ? 1 : ceil($total / $psize);
				die(json_encode($tmp));
			}
			include $this->template ('member/favorite_list');
		}elseif ($operation == 'activity') {
			$pagetitle .= "-我的活动";	
			if ($_GPC['ac']=='cancel'){//取消报名
				$result = pdo_update ('fx_activity_records', array ('status' => 5) , array ('id' => $_GPC['recordid']));
				$activity = pdo_get('fx_activity', array('id' => $activityid), array('prize'));
				$activity['prize'] = unserialize($activity['prize']);
				$credit = $activity['prize']['creditoff'];
				//积分变更，如果符合条件的话
				if ($result && $config['creditstatus'] == 1 && $credit > 0){
					fx_load()->model('credit');
					$credit_type = $config['credit_type']?$config['credit_type']:1;
					$prizedata = credit_update_credit1($_W['member']['uid'],-$credit,$credit_type,"取消报名".-$credit.'积分');
				}
				die(json_encode(array("result" => $result)));
				exit;
			}elseif ($_GPC['ac']=='ajax'){
				$condition = " status <> 8 and B.uniacid = '{$_W['uniacid']}' and A.id = activityid and openid = '{$_W['openid']}'";
				if($_GPC['status']==1){
					$condition .=" and status <> 5 and starttime > DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s')";
				}elseif($_GPC['status']==2){
					$condition .=" and status <> 5 and  endtime > DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') and DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') > starttime ";
				}elseif($_GPC['status']==3){
					$condition .=" and status <> 5 and  DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') >= endtime";
				}elseif($_GPC['status']==4){
					$condition .=" and status = 5";
				}
				
				$field  = "B.id, activityid, jointime, A.title, A.unit, starttime, endtime, joinstime, joinetime, thumb, status";
				$inner  = tablename ('fx_activity') . " A, " . tablename ('fx_activity_records') . " B";
				//echo $join;exit;
				$list = pdo_fetchall ("SELECT $field FROM " . $inner . " WHERE $condition ORDER BY jointime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . $inner . " WHERE $condition");	
				//array_merge数组拼接
				$tmp['lists']=$list;
				$tmp['tpage']=(empty($psize) || $psize < 0) ? 1 : ceil($total / $psize);
				die(json_encode($tmp));
			}
			include $this->template ('member/activity_list');
		}else{
			fx_load()->model('credit');
			$credits = credit_get_by_uid($_W['member']['uid'],1);
			include $this->template ('member/home');
		}
	}

}