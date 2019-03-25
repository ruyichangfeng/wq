<?php
global $_W,$_GPC;
require MODULE_ROOT.'/model.php';
$handles = array('display'=>'显示','post'=>'编辑或添加','delete'=>'删除','ajax'=>'ajax请求');

$operation = (isset($_GPC['op']) && array_key_exists($_GPC['op'], $handles)) ? $_GPC['op'] : 'display';
load()->func('tpl');
if($operation == 'post'){

	if(checksubmit('add_new')){
		$category = $_GPC['category'];
		$res = Categories::add($category['title']);
		if($res){
			message('添加分类成功','refresh','success');
		}else{
			message('添加分类失败','','error');
		}

	}
	if(checksubmit('update')){
		$category = $_GPC['category'];
		$res = Categories::modify(array('title'=>$category['title']), $category['id']);
		if($res){
			message('更新分类成功','refresh','success');
		}else{
			message('更新分类失败','','error');
		}
	}

	if(isset($_GPC['id'])){
		$category = Categories::cat_id($_GPC['id']);
	}

}elseif($operation == 'display'){
	$catsObj_array = Categories::all_cat();
	$cur_cat_id = !empty($_GPC['cat']) ? $_GPC['cat'] : 0;
	if(!empty($_GPC['cat'])){
		$cur_catsObj = Categories::cat_id($_GPC['cat']);
	}else{
		
		$cur_catsObj = $catsObj_array[0];
		$_GPC['cat'] = $cur_catsObj->id;
	}

	
	if(!empty($cur_catsObj)){
		$cur_catsObj->mediaId = cat_media($cur_catsObj->id);
	}
}elseif ($operation == 'delete') {
	$id = $_GPC['id'];
	$res = Categories::rm($id);
	if($res){
		message('删除分类成功',$this->createWebUrl('category'),'success');
	}else{
		message('删除分类失败','','error');
	}
}

include $this->template('category');
