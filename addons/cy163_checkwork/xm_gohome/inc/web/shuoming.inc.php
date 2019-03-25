<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'shuomingok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$item = pdo_fetch("select * from ".tablename('xm_gohome_shuoming')." where weid=".$_W['uniacid']);
	load()->func('tpl');
		
	include $this->template('shuoming');
}

if($foo == 'shuomingok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
		if(empty($_GPC['s_name'])){
			message('名称不能为空！');
		}
		if(empty($_GPC['shuoming'])){
			message('说明内容不能为空！');
		}
			
		$data['s_name'] = $_GPC['s_name'];
		$data['shuoming'] = htmlspecialchars_decode($_GPC['shuoming']);
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_shuoming',$data);
			if($result){
				message('添加数据成功！', $this->createWebUrl('shuoming', array('foo'=>'index')), 'success');
			}else{
				message('添加数据失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_shuoming', $data, array('id'=>$id));
			if($result){
				message('修改数据成功！', $this->createWebUrl('shuoming', array('foo'=>'index')), 'success');
			}else{
				message('修改数据失败！');
			}
		}
	}
}

?>