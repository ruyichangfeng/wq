<?php
global $_W,$_GPC;
require MODULE_ROOT.'/model.php';
$handles = array('display'=>'显示','post'=>'编辑或添加','delete'=>'删除','ajax'=>'ajax请求');

$operation = (isset($_GPC['op']) && array_key_exists($_GPC['op'], $handles)) ? $_GPC['op'] : 'display';
load()->func('tpl');
if($operation == 'post'){
	$slidesModel = new slidesModel();
	$slides = $slidesModel->all();

	$catsObj = Categories::all_cat();
	if(checksubmit('add_new')){
		$shelf = $_GPC['shelf'];
		$res = Shelfs::add($shelf['title'], $shelf['slides'], $shelf['cats']);
		if($res){
			message('添加书架成功','refresh','success');
		}else{
			message('添加书架失败','','error');
		}

	}
	if(checksubmit('update')){
		$shelf = $_GPC['shelf'];
		$res = Shelfs::modify(array('title'=>$shelf['title'], 'slides'=>$shelf['slides'], 'atl_cats'=>$shelf['cats']), $shelf['id']);
		if($res){
			message('更新书架成功','refresh','success');
		}else{
			message('更新书架失败','','error');
		}
	}

	if(isset($_GPC['id'])){
		$shelf = Shelfs::cat_id($_GPC['id']);
	}

}elseif($operation == 'display'){
	$shelfsObj = Shelfs::all_cat();
	
}elseif ($operation == 'delete') {
	$id = $_GPC['id'];
	$res = Shelfs::rm($id);
	if($res){
		message('删除书架成功',$this->createWebUrl('shelf'),'success');
	}else{
		message('删除书架失败','','error');
	}
}

include $this->template('shelfs');