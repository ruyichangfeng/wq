<?php
//应用入口二维码

global $_GPC,$_W;
$id=$_GPC['app_id'];
$url = $_W['siteroot']."app/".$this->createMobileUrl('index',array("app_id"=>$id));
require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
$errorCorrectionLevel = "L";
$matrixPointSize = "9";
QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
exit();