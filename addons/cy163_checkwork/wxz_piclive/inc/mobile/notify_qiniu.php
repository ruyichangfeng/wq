<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require dirname(__FILE__) . '/../../class/class_core.php';
$wxpayPath = DISCUZ_ROOT . "source/plugin/wxz_live/lib/wxpay/";
include_once DISCUZ_ROOT . "source/plugin/wxz_live/function/global.func.php";

$discuz = C::app();
$discuz->init_cron = false;
$discuz->init();

$callbackBody = file_get_contents('php://input');
$res = json_decode($callbackBody, true);

$persistentId = $res['id'];//文件 key
$url = $res['items'][0]['key'];//文件 key

$settingType = 7;
$tableSetting = new table_wxz_live_setting();
$config = $tableSetting->getByTypeFormat($settingType);
$info = $config['desc'];
//更新
$tableVideo = new table_wxz_live_video();
$insertData = array(
    'persistent_id' => $persistentId,
    'key' => $url,
    'url' => "http://{$info['url']}/{$url}",
);

$ret = $tableVideo->updateVideo($insertData);
