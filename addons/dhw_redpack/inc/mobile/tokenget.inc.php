<?php
/**
 * Created by PhpStorm.
 * User: Homva
 * Date: 16-5-9
 * Time: 上午10:10
 */
include(IA_ROOT.'addons/dhw_redpack/qiniu_sdk/src/autoload.php');
// 引入鉴权类
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
global $_W,$_GPC;
load()->func("logging");
logging_run("#######tokenGet######");
// 需要填写你的 Access Key 和 Secret Key
$accessKey = '3sDnF7m4K5LKsClYJ4waAhKeUn6duOteaVe4fLJr';
$secretKey = 'eSG1kPMJSV-Aux5VwkmJkY6foi0SysorzR_oTTGB';
logging_run("#######secretKey######");
// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);
logging_run("#######auth######");
// 要上传的空间
$bucket = 'zwt-resource';
// 生成上传 Token
$token = $auth->uploadToken($bucket);
logging_run("#######token######");

// 上传到七牛后保存的文件名
$key = $this->guid();

$qiniuToken['token'] = $token;
$qiniuToken['key'] = $key;

logging_run('qiniutoken为：'.json_encode($qiniuToken));

echo json_encode($qiniuToken);