<?php
/**
 * 永久图文
 * */
require MODULE_ROOT.'/model.php';
global $_GPC, $_W;
$operation = array('list'=>'默认形式显示','list_list'=>'列表形式显示','list_card'=>'卡片形式显示','post_news'=>'新增图文','del'=>'删除','post'=>'编辑','download'=>'下载','send'=>'群发','set_clock'=>'设置定时群发','send_clock'=>'定时群发','preview'=>'预览','keyword'=>'关键字设置');
$media = array('news'=>'图文','thumb'=>'图片','voice'=>'声音','video'=>'视频');

$op = isset($_GPC['action']) && array_key_exists($_GPC['action'], $operation) ? $_GPC['action'] : 'list';
$type = isset($_GPC['type']) && array_key_exists($_GPC['type'], $media) ? $_GPC['type'] : 'news';
load()->func('communication');
$Upload = new uploadModel();
$acid = pdo_fetchcolumn("SELECT `acid` FROM ".tablename('account_wechats')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
if ($op == 'send_clock') {
	print_r(send_clock());
}
exit;