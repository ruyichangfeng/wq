<?php
//获取员工二维码

global $_W,$_GPC;
$adminId=$_GPC['id'];
$url = $_W['siteroot'].$this->createMobileUrl('bind',array("id"=>$adminId));
require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
$errorCorrectionLevel = "L";
$matrixPointSize = "9";
QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
exit();