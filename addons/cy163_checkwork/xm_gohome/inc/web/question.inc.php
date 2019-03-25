<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'questionok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$item = pdo_fetch("select * from ".tablename('xm_gohome_question')." where weid=".$_W['uniacid']);
	load()->func('tpl');
		
	include $this->template('question');
}

if($foo == 'questionok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['q_name'])){
			message('名称不能为空！');
		}
		if(empty($_GPC['question'])){
			message('常见问题不能为空！');
		}
			
		$data['q_name'] = $_GPC['q_name'];
		$data['question'] = htmlspecialchars_decode($_GPC['question']);
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_question',$data);
			if($result){
				message('添加数据成功！', $this->createWebUrl('question', array('foo'=>'index')), 'success');
			}else{
				message('添加数据失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_question', $data, array('id'=>$id));
			if($result){
				message('修改数据成功！', $this->createWebUrl('question', array('foo'=>'index')), 'success');
			}else{
				message('修改数据失败！');
			}
		}
	}
}
?>