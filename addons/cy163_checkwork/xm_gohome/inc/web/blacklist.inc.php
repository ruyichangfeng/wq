<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'del');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_blacklist')." WHERE 1=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_blacklist')." WHERE 1=1");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/user/blacklist');
}

if($foo == 'del'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误！");
		exit();
	}
	$res = pdo_delete('xm_gohome_blacklist', array('id'=>$id));
	if($res){
		message('解除黑名单成功！',$this->createWebUrl('blacklist',array('foo'=>'index')), 'success');
	}else{
		message('解除黑名单失败！');
	}
}
?>