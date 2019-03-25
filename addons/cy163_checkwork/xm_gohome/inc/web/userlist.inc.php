<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'examineok', 'examineno', 'edit', 'editok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
	if (!empty($_GPC['nickname'])) {
		$condition .= " AND nickname LIKE :nickname";
		$params[':nickname'] = "%{$_GPC['nickname']}%";
	}
	if (!empty($_GPC['mobile'])) {
		$condition .= " AND mobile =".$_GPC['mobile'];
		//$params[':staff_name'] = "%{$_GPC['staff_name']}%";
	}
		
	$sqllist = "SELECT fanid,uid,openid,nickname FROM ".tablename('mc_mapping_fans')." WHERE `uniacid` = ".$this->weid." $condition ORDER BY uid DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
		//echo $sqllist;
	$list = pdo_fetchall($sqllist, $params);
	$sql='SELECT COUNT(*) FROM ' . tablename('mc_mapping_fans') . " WHERE uniacid = ".$this->weid."  $condition ";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
		
	include $this->template('web/user/user-list');
}

if($foo == 'examineok'){
	$openid = $_GPC['openid'];
	$data['weid'] = $this->weid;
	$data['openid'] = $openid;
	$data['adminname'] = $_W['username'];
	$data['addtime'] = date('Y-m-d H:i:s');
	$res = pdo_insert('xm_gohome_examine', $data);
	if($res){
		message('审核通过成功！', $this->createWebUrl('userlist', array('foo'=>'index')), 'success');
	}else{
		message('审核通过失败！');
	}
}

if($foo == 'examineno'){
	$openid = $_GPC['openid'];
	$res = pdo_query("delete from ".tablename('xm_gohome_examine')." where openid='".$openid."'");
	if($res){
		message('取消审核成功！', $this->createWebUrl('userlist', array('foo'=>'index')), 'success');
	}else{
		message('取消审核失败！');
	}
}

if($foo == 'edit'){
	$uid    = intval($_GPC['uid']);
	$openid = $_GPC['openid'];
	$item = pdo_fetch("select * from ".tablename('xm_gohome_members')." where weid=".$this->weid." and openid='".$openid."'");
	if(empty($item)){
		$data['weid'] = $this->weid;
		$data['openid'] = $openid;
		$data['nickname'] = $this->getFansInfo($uid, 'nickname');
		$data['realname'] = $this->getFansInfo($uid, 'realname');
		$data['mobile'] = $this->getFansInfo($uid, 'mobile');
		$res = pdo_insert('xm_gohome_members', $data);
		$item = pdo_fetch("select * from ".tablename('xm_gohome_members')." where weid=".$this->weid." and openid='".$openid."'");

		include $this->template('web/user/user-edit');
	}else{

		include $this->template('web/user/user-edit');
	}
}

if($foo == 'editok'){
	$id = intval($_GPC['id']);
	$data['realname'] = $_GPC['realname'];
	$data['mobile'] = $_GPC['mobile'];
	$data['title'] = $_GPC['title'];
	$res = pdo_update('xm_gohome_members', $data, array('id'=>$id));
	if($res){
		message('修改成功！',$this->createWebUrl('userlist',array('foo'=>'index')), 'success');
	}else{
		message('修改失败！');
	}
}
?>