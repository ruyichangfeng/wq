<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;
// checkauth();
$uniacid = $_W['uniacid'];
load()->model("mc");
$settings = pdo_fetchcolumn("SELECT settings FROM".tablename('uni_account_modules')."WHERE uniacid='$uniacid' and module='qw_microedu'");
$set =iunserializer($settings);

if($_W['openid']=="")
{
    $wx_user_info = mc_oauth_userinfo();
}

    $sql = "SELECT * FROM " . tablename('qw_microedu_users') . " WHERE openid = '{$_W['openid']}' AND uniacid='$uniacid'";
    $user = pdo_fetch($sql);

    if (!empty($user))
    {
        header("Location: " . $this->createMobileUrl('parent', array('page' => 'settings')));
    }