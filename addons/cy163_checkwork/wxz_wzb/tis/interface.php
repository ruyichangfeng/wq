<?php 
require IA_ROOT . '/addons/wxz_wzb/tis/conf.php';
require IA_ROOT . '/addons/wxz_wzb/tis/tis.php';

$api = new TisApi($accessId,$accessKey);
$method = $_REQUEST['method'];

$rst = $api->$method($_REQUEST,$tisId);
echo json_encode($rst);
?>