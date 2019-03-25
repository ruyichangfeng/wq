<?php
global $_W,$_GPC;
require MODULE_ROOT.'/model.php';
$slidesModel = new slidesModel();
$handles = array('display'=>'显示','post'=>'编辑或添加','delete'=>'删除','ajax'=>'ajax请求');

$operation = (isset($_GPC['op']) && array_key_exists($_GPC['op'], $handles)) ? $_GPC['op'] : 'display';
load()->func('tpl');
if($operation == 'post'){

	if(checksubmit()){
		$slides = $_GPC['slides'];
		if(isset($_GPC['id'])){
			$res = $slidesModel->modify($slides, $_GPC['id']);
			if($res){
				message('更新幻灯片成功','refresh','success');
			}else{
				message('更新幻灯片失败','','error');
			}

		}else{
			$res = $slidesModel->add($slides);
			if($res){
				message('添加幻灯片成功','refresh','success');
			}else{
				message('添加幻灯片失败','','error');
			}

		}
	}

	if(isset($_GPC['id'])){
		$slide = $slidesModel->item($_GPC['id']);
		// var_dump($slide);exit;
	}


}elseif($operation == 'display'){
	$slides = $slidesModel->all();
	
}elseif ($operation == 'delete') {
	$id = $_GPC['id'];
	$res = $slidesModel->del($id);
	if($res){
		message('删除幻灯片成功',$this->createWebUrl('slides',array('op'=>'display')),'success');
	}else{
		message('删除幻灯片失败','','error');
	}
}

include $this->template('slides');