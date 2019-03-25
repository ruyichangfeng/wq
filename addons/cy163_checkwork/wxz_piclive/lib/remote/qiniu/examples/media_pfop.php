<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

function getWxzQiniuConfig()
{
    global $_G,$_W;

    set_time_limit(0);
    $settingType = 7;
    //$tableSetting = new table_wxz_live_setting();
    //$config = $tableSetting->getByTypeFormat($settingType);
    $info = $_W['setting']['remote']['qiniu'];

    //需要填写你的 Access Key 和 Secret Key
    $accessKey = $info['accesskey'];
    $secretKey = $info['secretkey'];
    $bucket = $info['bucket'];
    $pipeline = '';//$info['pipeline'];

    $auth = new Auth($accessKey, $secretKey);
    $uploadMgr = new UploadManager();

    $pfop = "avthumb/m3u8/noDomain/1/segtime/15/vb/1.25m";
    $notifyUrl = "{$_G['siteurl']}/source/plugin/wxz_live/notify_qiniu.php";

    $policy = array(
        'persistentOps' => $pfop,
        'persistentNotifyUrl' => $notifyUrl,
    );
    //视频转码队列
    if ($pipeline) {
        $policy['persistentPipeline'] = $pipeline;
    }
    $token = $auth->uploadToken($bucket, null, 3600, $policy);
    return array(
        'token' => $token,
        'url' => 'http://' . $info['url'] . '/',
    );
}

function qiniuM3u8Upload($filePath, $fileName)
{
    global $_G;

    set_time_limit(0);
    $settingType = 7;
    $tableSetting = new table_wxz_live_setting();
    $config = $tableSetting->getByTypeFormat($settingType);
    $info = $config['desc'];

    //需要填写你的 Access Key 和 Secret Key
    $accessKey = $info['access_key'];
    $secretKey = $info['secret_key'];
    $bucket = $info['bucket'];
    $pipeline = $info['pipeline'];

    $auth = new Auth($accessKey, $secretKey);
    $uploadMgr = new UploadManager();

    $pfop = "avthumb/m3u8/noDomain/1/segtime/15/vb/240k";
    $notifyUrl = "{$_G['siteurl']}/source/plugin/wxz_live/notify_qiniu.php";

    $policy = array(
        'persistentOps' => $pfop,
        'persistentNotifyUrl' => $notifyUrl,
    );
    //视频转码队列
    if ($pipeline) {
        $policy['persistentPipeline'] = $pipeline;
    }
    $token = $auth->uploadToken($bucket, null, 3600, $policy);
//$token = $auth->uploadToken($bucket);
//$ret = $uploadMgr->putFile($token, null, $key);
    $ret = $uploadMgr->putFile($token, $fileName, $filePath);
    return $ret[0]['persistentId'];
}

//$accessKey = 'dyKKsz9dI1flXhcEZIJi4Hc9omQxkvBJXOeUB8Sh';
//$secretKey = 'Z2sNp63bLU_eB9BZY5LQUtmMbchln4a7IKNjUiJb';
//$bucket = 'weixin';
//$info['url'] = 'oqlmortv8.bkt.clouddn.com';
//$pipeline = 'lirui';
//
//
//
////上传视频，上传完成后进行m3u8的转码， 并给视频打水印
//$filePath = $key = "/www/web/dzgbk_hfxync_com/public_html/x34utf8/IMG_0075.MOV";
////$filePath = $key = "/www/web/dzgbk_hfxync_com/public_html/x34utf8/source/plugin/wxz_live/template/index/1/image/jidan.png";
////$wmImg = Qiniu\base64_urlSafeEncode('http://devtools.qiniudn.com/qiniu.png');
//$pfop = "avthumb/m3u8/noDomain/1/vb/500k/t/10";
//$pfop = "avthumb/m3u8/noDomain/1/segtime/15/vb/240k";
//$fileName = 'IMG_0075.MOV';
//
////转码完成后回调到业务服务器。（公网可以访问，并相应200 OK）
//$notifyUrl = 'http://dzgbk.hfxync.com/x34utf8/qiniu/notify.php';
//
////独立的转码队列：https://portal.qiniu.com/mps/pipeline
//
//$policy = array(
//    'persistentOps' => $pfop,
//    'persistentNotifyUrl' => $notifyUrl,
//);
////视频转码队列
//if($pipeline) {
//    $policy['persistentPipeline'] = $pipeline;
//}
//$token = $auth->uploadToken($bucket, null, 3600, $policy);
////$token = $auth->uploadToken($bucket);
////$ret = $uploadMgr->putFile($token, null, $key);
//$ret = $uploadMgr->putFile($token, $fileName, $filePath);
//var_dump($ret);
//die;
//
////// 触发持久化处理后返回的 Id
//$persistentId = 'z1.5acaa5cf856db843bcd1a88c';
////
//$config = new \Qiniu\Config();
//////$config->useHTTPS=true;
//$auth = new Auth($accessKey, $secretKey);
//$pfop = new PersistentFop($auth, $config);
//
////// 通过persistentId查询该 触发持久化处理的状态
//////$status = PersistentFop::status($persistentId);
//$status = $pfop->status($persistentId);
//var_dump($status);
//die;