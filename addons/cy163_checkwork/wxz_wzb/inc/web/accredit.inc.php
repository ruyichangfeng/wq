<?php
global $_W,$_GPC;
require_once '../framework/library/qrcode/phpqrcode.php';
$uniacid = $_W['uniacid'];
$rid = $_GPC['rid'];

load()->func('tpl');
$imgName = "wxz_wzb_accredit".$_W['uniacid'].$rid;
		
$linkUrl = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&m=wxz_wzb&do=accredit&rid=".$rid;
$imgUrl = "../addons/wxz_wzb/qrcode/".$imgName.".png";
load()->func('file');
mkdirs(MODULE_ROOT . '/qrcode');
$dir = $imgUrl;
$flag = file_exists($dir);
if($flag == false){
	//生成二维码图片
	$errorCorrectionLevel = "L";
	$matrixPointSize = "4";
	QRcode::png($linkUrl,$imgUrl,$errorCorrectionLevel,$matrixPointSize);
	//生成二维码图片
}
include $this->template('accredit');
?>