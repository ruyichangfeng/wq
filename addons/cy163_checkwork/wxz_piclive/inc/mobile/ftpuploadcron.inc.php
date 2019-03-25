<?php

/**
 * 批量处理图片每次10张
 */
error_reporting(0);
global $_GPC, $_W;
load()->model('mc');
$fan = mc_fansinfo($_W['openid']);
if (!empty($fan) && !empty($fan['openid'])) {
    $userinfo = $fan;
} else {
    $userinfo = mc_oauth_userinfo();
}

require_once "../addons/wxz_piclive/func/imageHash.php";
require_once "../addons/wxz_piclive/func/imgCompare.php";
require_once IA_ROOT."/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
require_once "../addons/wxz_piclive/func/common.func.php";
$image = new ThinkImage(); 

load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$lid = intval($_GPC['lid']);
$getLiveUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&c=entry&do=ftpupload&op=getLiveInfo&m=wxz_piclive";
$actionUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=ftpupload&op=setImageList&m=wxz_piclive";

//查询该用户是否权限操作
$isExist = pdo_fetchcolumn("SELECT COUNT(*) FROM ". tablename('wxz_pic_staff') . " WHERE openid = '{$userinfo['openid']}'");
if(empty($isExist)){
    //message('请联系管理员，添加权限！', $this->createMobileUrl('index', array('lid' => $lid)));
}
//新建模块图片存档
$sourcedir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/';
   !is_dir($sourcedir) && @mkdir($sourcedir, 0755, true);
$thumbdir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/thumb/';
!is_dir($thumbdir) && @mkdir($thumbdir, 0755, true);

//当前直播间
$liveRow = array();
if($lid) {
    $liveRow = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id = {$lid}");
}
if($liveRow['cron'] == 'off'){
  exit;
}

$allowFiles = 'png|jpg|jpeg|gif';
/* 获取文件列表 */
$files = getfiles($liveRow['cron_imgdir'], $allowFiles, $lid);
foreach($files as $key=>$val){
  //图片操作
  try {
    //备份图片
      $newpath = $sourcedir . $val['file_name'];
      $res = copy('/'.$val['url'], $newpath);
    //写入表中wxz_pic_ftpimage
      $dataFtpImage = array(
        'lid' => $lid,
        'file_name' => $val['file_name'],
        'picpath' => $newpath,
        'is_deal' => 1,
        'add_time' => time()
      );
      $res = pdo_insert('wxz_pic_ftpimage', $dataFtpImage);

      //循环文件图片，写入附件表
      $attach = array(
        'lid' => $lid,
        'uniacid' => intval($_W['uniacid']),
        'add_time' => time()
      );
      $attachExtra = dealImageAttachment($newpath, $thumbdir, $live);
      $attachTotal = array_merge($attach, $attachExtra);
      $result = pdo_insert('wxz_pic_attach', $attachTotal);
    } catch (Exception $e) {
        continue;
    }
  
}

/*
* 遍历获取目录下的指定类型的文件
* @param $path
* @param array $files
* @return array
*/
function getFiles($path,$allowFiles,$lid,&$files = array()){
  if(!is_dir($path)) return null;
  if(substr($path,strlen($path)-1) != '/') $path .= '/';
  $handle = opendir($path);

  while(false !== ($file = readdir($handle))){
    if($file != '.' && $file != '..'){
      $path2 = $path.$file;
      if(is_dir($path2)){
        getFiles($path2,$allowFiles,$files);
      }else{
        if(preg_match("/\.(".$allowFiles.")$/i",$file)){
          //查询是否数据存在
          $isExit = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_ftpimage') . " WHERE lid = {$lid} and file_name='{$file}'");
          if($isExit){
            continue;
          }
          //一次处理10张
          $files[] = array(
            'url' => substr($path2,1),
            'file_name' => $file,
            'mtime' => filemtime($path2)
          );
        }
        if(count($files) == 10){
          break;
        }
      }
    }
  }   
  return $files;
}



function dealImageAttachment($imagefile, $thumbdir, $live) {
  global $_W,$_GPC;
  $image = new ThinkImage(); 
  $water_img = tomedia($live['water_img']);
  $water_thumb = tomedia($live['water_thumb']);
  $imginfo = pathinfo($imagefile);
  //if($_W['setting']['remote']['type'] != 3){
      $thumbname = $imginfo['filename']."_150.".$imginfo['extension'];
      $midthumbname = $imginfo['filename']."_1920.".$imginfo['extension'];
      $thumbPath = $thumbdir.$thumbname;
      $midthumbPath = $thumbdir.$midthumbname;
      //$sourceimagepath = $_W['siteroot']."attachment/".$val;
      // if(!file_exists($sourceimagepath)){
      //   $sourceimagepath = $_W['attachurl'].$val;
      // }
      if($live['water_thumb']){
        $image->open($imagefile)->thumb(250, 250,THINKIMAGE_THUMB_CENTER)->water($water_thumb,THINKIMAGE_WATER_SOUTHEAST)->save($thumbPath);              
      }else{
        $image->open($imagefile)->thumb(250, 250,THINKIMAGE_THUMB_CENTER)->save($thumbPath);              
      }

      $imagesize = @getimagesize($imagefile);
      $ori_rate = $imagesize[0]/$imagesize[1];
      if(empty($setting['thumb_width'])){
          $width = 800;
      }else{
          $width = $setting['thumb_width'];
      }
      $height = $width/$ori_rate;
      if($live['water_img']){
        $image->open($imagefile)->thumb($width, $height,THINKIMAGE_THUMB_SCALING)->water($water_img,THINKIMAGE_WATER_SOUTHEAST)->save($midthumbPath);
      }else{
        $image->open($imagefile)->thumb($width, $height,THINKIMAGE_THUMB_SCALING)->save($midthumbPath);
      }
      $attach['show_type'] = ($ori_rate < 1) ? 1: 0;
      $attach['midthumb'] = "wxz_piclive/".date('Ymd')."/thumb/".$midthumbname;
      $attach['thumbimg'] = "wxz_piclive/".date('Ymd')."/thumb/".$thumbname;
    //}
    
    $attachstr= strstr($imagefile, 'attachment');
    $attach['picpath'] = str_replace('attachment/', '', $attachstr);
    //$attach['midthumb'] = isset($midthumbname) ? "wxz_piclive/".date('Ymd')."/".$midthumbname : '';
    //$attach['thumbimg'] = isset($thumbname) ? "wxz_piclive/".date('Ymd')."/".$thumbname : '';
    //文件大小
    //$picpath = strstr($imagefile, 'wxz_piclive');
    $file = @file_get_contents($imagefile);
    $length = strlen($file);
    $attach['bigimgsize'] = (getsize($length, 'mb') > 0) ? getsize($length, 'mb') : '0.01' ;
    $attach['file_name'] = $imginfo['basename'];
    return $attach;
}

