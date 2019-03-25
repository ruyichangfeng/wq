<?php
global $_W,$_GPC;
require MODULE_ROOT.'/model.php';
$cur_shelf = $_GPC['id'];
$shelf = Shelfs::cat_id($cur_shelf);
$slide_ids = $shelf->slides;
$cat_ids = $shelf->atl_cats;


$slide_array = array();
if(!empty($slide_ids)){
	$slidesModel = new slidesModel();
	foreach ($slide_ids as $key => $id) {
		$slide_array[] = $slidesModel->item($id);
	}
}

$cats_obj = array();
if(!empty($cat_ids)){
	foreach ($cat_ids as $key => $id) {
		$cat = Categories::cat_id($id);
		if(!empty($cat->id)){
			$cats_obj[] = $cat;
		}
		
	}
}
$cur_cat = empty($_GPC['cat']) ? $cats_obj[0]->id : $_GPC['cat'];
$cur_catObj = Categories::cat_id($cur_cat);
$articles = array();
if(!empty($cur_catObj)){
	$articles = cat_media($cur_catObj->id);
}
// var_dump($articles);exit;
// $articles = $cur_catObj->article;

include $this->template('shelf');