<?php
global $_W,$_GPC;
require MODULE_ROOT.'/model.php';
$handles = array('ajax_cats_of_media'=>'文章包含的分类','ajax_media_of_cat'=>'分类包含的文章', 'post'=>'更新');

$operation = (isset($_GPC['action']) && array_key_exists($_GPC['action'], $handles)) ? $_GPC['action'] : '';
if($operation == 'ajax_cats_of_media'){
	/*获取文章的分类*/
	$media_id = $_GPC['media_id'];
	$cats = media_cats($media_id);
	
	exit(json_encode($cats));

}elseif($operation == 'post'){
	/*编辑文章的分类*/
	$media_id = $_GPC['media_id'];
	$_GPC['cats'] = html_entity_decode($_GPC['cats']);
	$cats = empty($_GPC['cats']) ? array() : json_decode($_GPC['cats'], true);
	pdo_delete('article_shelf_relation', array('uniacid'=>$_W['uniacid'], 'media_id'=>$media_id));
	foreach ($cats as $key => $cat_id) {
		$params = array('cat_id'=>$cat_id, 'media_id'=>$media_id, 'uniacid'=>$_W['uniacid']);
		$res = pdo_insert('article_shelf_relation', $params);
	}
	exit('success');
}