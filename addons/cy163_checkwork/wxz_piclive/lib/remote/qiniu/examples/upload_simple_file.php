<?php

require_once __DIR__ . '/../autoload.php';

// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;


function qiniuSimpleUpload($filePath, $fileName)
{
    set_time_limit(0);
    $settingType = 7;
    $tableSetting = new table_wxz_live_setting();
    $config = $tableSetting->getByTypeFormat($settingType);
    $info = $config['desc'];

// 需要填写你的 Access Key 和 Secret Key
    $accessKey = $info['access_key'];
    $secretKey = $info['secret_key'];
    $bucket = $info['bucket'];

// 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);

// 生成上传 Token
    $token = $auth->uploadToken($bucket);
// 要上传文件的本地路径

// 上传到七牛后保存的文件名
    $key = 'my-php-logo111.png';

// 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传。
    $ret = $uploadMgr->putFile($token, $fileName, $filePath);
    $url = "http://" . $info['url'] . '/' . $ret[0]['key'];
    return $url;
}

