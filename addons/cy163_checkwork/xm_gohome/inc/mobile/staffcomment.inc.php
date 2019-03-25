<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'gscomment');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}
	$item = pdo_fetch("select good,center,bad from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and staff_id=".$id);
		
	$page = 'my';
	include $this->template('staff/comment/s_staffcomment');
}

if($foo == "gscomment"){
	$id = intval($_GPC['id']);
	
	$openid = $_GPC['openid'];
	$list1 = pdo_fetchall("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and company_flag=1 and company_mge=0 and delstate=1");
	$idStr = '';
	foreach($list1 as $value){
		$idStr .= $value['id'].',';
	}
	$idStr = rtrim($idStr,',');
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and find_in_set(staff_id,'".$idStr."') order by addtime desc limit 0,150");
	
	$item1 = pdo_fetchcolumn("select sum(good) as good from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(id,'".$idStr."')");
	$item2 = pdo_fetchcolumn("select sum(center) as center from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(id,'".$idStr."')");
	$item3 = pdo_fetchcolumn("select sum(bad) as bad from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(id,'".$idStr."')");

		
	$page = 'my';
	include $this->template('staff/comment/s_gscomment');
}

?>