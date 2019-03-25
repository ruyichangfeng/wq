<?php

/**
 * 发布商品
 */
global $_GPC, $_W;
load()->model('mc');
$fan = mc_fansinfo($_W['openid']);
if (!empty($fan) && !empty($fan['openid'])) {
    $userinfo = $fan;
} else {
    $userinfo = mc_oauth_userinfo();
}

require_once IA_ROOT."/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
require_once "../addons/wxz_piclive/func/common.func.php";
$image = new ThinkImage(); 

load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$lid = intval($_GPC['lid']);
$addImageUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=addimage&op=getCat&m=wxz_piclive";
$actionUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=addimage&op=post&m=wxz_piclive";

 //七牛云jssdk上传
include_once IA_ROOT."/addons/wxz_piclive/lib/remote/qiniu/examples/media_pfop.php";
$qiniuConfig = getWxzQiniuConfig();


include $this->template('addMedia');

