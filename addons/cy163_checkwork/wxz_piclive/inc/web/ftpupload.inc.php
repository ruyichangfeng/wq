<?php
header('Access-Control-Allow-Origin:*');
error_reporting(0);
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
load()->model('mc');
load()->func('compat.biz');

require_once IA_ROOT."/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
require_once "../addons/wxz_piclive/func/common.func.php";

$json = array('err'=>0, 'msg'=>'', 'data'=>array());
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$setting = $this->module['config'];//配置项
$remote_type = $_W['setting']['remote']['type'];

if ($operation == 'display') {
	//pdo_query("delete from ims_wxz_pic_ftpimage where fid<10");

  $lid = intval($_GPC['lid']);
    
   include $this->template('ftpupload');
} elseif($operation == 'setImageList') {
  $lid = intval($_GPC['lid']);
  $imagefilepath = trim($_GPC['imagepath']);
  $newpath = $imagefilepath.'/'; //图片路径
  $mydir=@dir($newpath);
  if(!$mydir) {
    message('图片路径填写错误！');
  }

  $sourcedir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/';
   !is_dir($sourcedir) && @mkdir($sourcedir, 0755, true);

  $imageIds = array();
  $data = array(
      'lid' => $lid,
      'add_time' => time()
    );

  while (($file = $mydir->read()) !== false){
      if(count($imageIds)==10) {
        break;
      }

      $imagesize = @getimagesize($newpath.$file);
      if(!$imagesize) {
        continue;
      }
      
      if(is_file($newpath.$file)) {
      	$pathinfo = pathinfo($newpath.$file);
        $extension = strtolower($pathinfo['extension']);
      	if(!in_array($extension, array('jpg', 'jpeg', 'png'))) {
      		continue;
      	}
      	copy($newpath.$file, $sourcedir . $file);
      	$data['picpath'] = $sourcedir . $file;
        $row = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_ftpimage') . " WHERE picpath = '{$data['picpath']}'");
        if(!$row) {
          pdo_insert('wxz_pic_ftpimage', $data);
          $fid = pdo_insertid();
          array_push($imageIds, $fid);
        }
      }
    }
    $mydir->close();

    $ftpimageRows = pdo_fetchAll("SELECT * FROM " . tablename('wxz_pic_ftpimage') . " WHERE lid = '{$lid}' and is_deal=0");
    $ftpImageNum = count($ftpimageRows);

    include $this->template('ftpupload2');

}elseif ($operation == 'dealImage') {
    $lid = intval($_GPC['lid']);
    $qiniu_sid = isset($_GPC['qiniu_sid']) ? intval($_GPC['qiniu_sid']) : 0;//七牛小图样式
    $qiniu_sid_big = isset($_GPC['qiniu_sid_big']) ? intval($_GPC['qiniu_sid_big']) : 0;//七牛大图样式

    $live = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id = $lid");
    if (empty($live)) {
      $json['err'] = 1;
      $json['msg'] = '请输入直播间编号！';
      die(json_encode($json));
    }

    $ftpimageRows = pdo_fetchAll("SELECT * FROM " . tablename('wxz_pic_ftpimage') . " WHERE lid = {$lid} and is_deal=0");
    if(!$ftpimageRows) {
      $json['err'] = 1;
      $json['msg'] = '没有图片需要处理！';
      die(json_encode($json));
    }

    $water_img = tomedia($live['water_img']);
    $water_thumb = tomedia($live['water_thumb']);
    $data = array(
      'lid' => $lid,
      'uniacid' => intval($_W['uniacid']),
      'topic_type' => 0,
      'qiniu_sid' => $qiniu_sid,
      'qiniu_sid_big' => $qiniu_sid_big,
      'add_time' => time()
    );
    $thumbdir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/thumb/';
    !is_dir($thumbdir) && @mkdir($thumbdir, 0755, true);
                         
    //写入主题
    pdo_insert('wxz_pic_topic', $data);
    $tid = pdo_insertid();
    
    //循环文件图片，写入附件表
    $attach = array(
      'tid' => $tid,
      'lid' => $lid,
      'uniacid' => intval($_W['uniacid']),
      'qiniu_sid' => $qiniu_sid,
      'qiniu_sid_big' => $qiniu_sid_big,
      'add_time' => time()
    );

    foreach ($ftpimageRows as $key => $value) {
    	if(!file_exists($value['picpath'])) {
    		continue;
    	}
    	try {
          $attachExtra = dealImageAttachment($value['picpath'], $thumbdir, $live);
      		$attachTotal = array_merge($attach, $attachExtra);
        } catch (Exception $e) {
            continue;
        }
      
      $result = pdo_insert('wxz_pic_attach', $attachTotal);
      if($result) {
        //更新已处理
        $ftpimageData = array('is_deal'=>1, 'update_time'=>time());
        pdo_update('wxz_pic_ftpimage', $ftpimageData, array('fid' => $value['fid']));
      }
    }
    
    //获取attench_id
    $attach_id = array();
    $attach = pdo_fetchall("SELECT aid FROM " . tablename('wxz_pic_attach') . " WHERE tid = $tid");
    if($attach){
      foreach($attach as $vv){
        $attach_id[] = $vv['aid'];
      }
    }
    $attach_id = serialize($attach_id);
    //更新主题数据
    pdo_update('wxz_pic_topic', array('attach_id' => $attach_id), array('tid' => $tid));

    $json['msg'] = '处理完成';
    $json['data'] = $ftpimageRow;
    die(json_encode($json));
}

function dealImageAttachment($imagefile, $thumbdir, $live) {
  global $_W,$_GPC;
  $image = new ThinkImage(); 
  $water_img = tomedia($live['water_img']);
  $water_thumb = tomedia($live['water_thumb']);
  $imginfo = pathinfo($imagefile);
  if($_W['setting']['remote']['type'] != 3){
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
    }
    
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

function tree($directory)
{
	$dir = trim($directory, '/');
	$newpath = '/'.$dir.'/';
	  $mydir=dir($newpath);
	  if(!$mydir) {
	  	return false;
	  }

		while (($file = $mydir->read()) !== false){
			if(is_file($newpath.$file)) {
				echo $newpath.$file."<br/>";
			}
		  //echo "filename: " . $file . "<br>";
		}
		$mydir->close();
  
}
//tree("C:\phpStudy\WWW\imooc");