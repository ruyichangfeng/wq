<?php
date_default_timezone_set('Asia/Shanghai');
require MODULE_ROOT.'/model.php';
global $_GPC, $_W;
$operation = array('list'=>'默认形式显示','list_list'=>'列表形式显示','list_card'=>'卡片形式显示','post_news'=>'新增图文','del'=>'删除','post'=>'编辑','download'=>'下载','send'=>'群发','set_clock'=>'设置定时群发','send_clock'=>'定时群发','preview'=>'预览','keyword'=>'关键字设置','detail'=>'文章详情','modify_new'=>'编辑图文');
$media = array('news'=>'图文','thumb'=>'图片','voice'=>'声音','video'=>'视频');

$op = isset($_GPC['action']) && array_key_exists($_GPC['action'], $operation) ? $_GPC['action'] : 'list';
$type = isset($_GPC['type']) && array_key_exists($_GPC['type'], $media) ? $_GPC['type'] : 'news';
$recordModel = new recordModel();

if($op == 'del'){
	$id = $_GPC['id'];
	$result = $recordModel->remove($id);
	exit($result);
}

if($type == 'news' ){
	$records = $recordModel->record(array('news','mpnews'));

}elseif ($type == 'thumb') {
	$records = $recordModel->record(array('image'));
}elseif ($type == 'voice') {
	$records = $recordModel->record(array('voice'));
}elseif ($type == 'video') {
	$records = $recordModel->record(array('mpvideo','video'));
}


include $this->template('records');