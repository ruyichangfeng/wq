<?php
global $_W, $_GPC;

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('list', 'add', 'addok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'list';

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

if($foo == 'list') {
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeaddress')." where weid=".$this->weid." and openid='".$openid."'");

	include $this->template('takeout/address');
}

if($foo == 'add'){
	$id      = intval($_GPC['id']);
	$orderid = intval($_GPC['orderid']);

	if(!empty($id)){
		$item = pdo_fetch("select * from ".tablename('xm_gohome_takeaddress')." where weid=".$this->weid." and id=".$id);
	}

	include $this->template('takeout/address-add');	
}

if($foo == 'addok'){
	$id      = intval($_GPC['id']);
	$orderid = intval($_GPC['orderid']);
	$type    = intval($_GPC['type']);

	$data['openid']   = $openid;
	$data['realname'] = $_GPC['realname'];
	$data['mobile']   = $_GPC['mobile'];
	$data['sex']      = $_GPC['sex'];
	$data['adr_city'] = $_GPC['adr_city'];
	$data['adr_room'] = $_GPC['adr_room'];
	$data['type']     = $_GPC['type'];
	if(empty($id)){
		$data['weid']  = $_W['uniacid'];
		$data['ctime'] = date('Y-m-d H:i:s');
		$res = pdo_insert('xm_gohome_takeaddress', $data);
		$newId = pdo_insertid();
		if($res){
			if($type == 1){
			pdo_query("update ".tablename('xm_gohome_takeaddress')." set type=2 where weid=".$_W['uniacid']." and id!=".$newId);
			}
			if(empty($orderid)){
				echo 1;
			}else{
				echo 2;
			}
		}else{
			echo 0;
		}
	}else{
		$res = pdo_update('xm_gohome_takeaddress', $data, array('id'=>$id));
		if($res){
			if($type == 1){
				pdo_query("update ".tablename('xm_gohome_takeaddress')." set type=2 where weid=".$_W['uniacid']." and id!=".$id);
			}
			echo 1;
		}else{
			echo 0;
		}
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	$res = pdo_delete('xm_gohome_takeaddress', array('id'=>$id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

?>