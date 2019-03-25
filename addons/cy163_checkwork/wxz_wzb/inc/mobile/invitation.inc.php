<?php
global $_W,$_GPC;
require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
load()->func('communication');

$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_invitation')." WHERE uniacid=:uniacid AND rid=:rid",array(':uniacid'=>$_W['uniacid'],':rid'=>$rid));
$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$setting = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_setting') . ' WHERE `uniacid` = :uniacid and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':rid' => $rid));

$B = ihttp_request(tomedia($user['headimgurl']));

$img = base64_encode(($B['content']));

$weekarray=array("日","一","二","三","四","五","六");


$link_url = $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('index2',array('share_uid' => $uid,'rid'=>$rid)));
$imgUrl = "../addons/wxz_wzb/qrcodes/wxz_wzb".$uid.$rid.".png";
load()->func('file');
mkdirs(MODULE_ROOT . '/qrcodes');
$dir = $imgUrl;
$flag = file_exists($dir);
//生成二维码图片
$errorCorrectionLevel = "L";
$matrixPointSize = "4";
QRcode::png($link_url,$imgUrl,$errorCorrectionLevel,$matrixPointSize);
//生成二维码图片
include $this->template('2/invitation');
?>