<?php

/**
 * 发布商品
 */

global $_GPC, $_W;
load()->model('mc');
$settings = $this->module['config'];
$fan = mc_fansinfo($_W['openid']);
if (!empty($fan) && !empty($fan['openid'])) {
    $userinfo = $fan;
} else {
    $userinfo = mc_oauth_userinfo();
}

//查询该用户是否权限操作
$isExist = pdo_fetchcolumn("SELECT COUNT(*) FROM ". tablename('wxz_pic_staff') . " WHERE openid = '{$userinfo['openid']}'");
if(empty($isExist) && $settings['is_pic_manage']=='on'){
    message('请联系管理员，添加权限！', $this->createMobileUrl('index', array('lid' => $lid)));
}

require_once "../addons/wxz_piclive/func/imageHash.php";
require_once "../addons/wxz_piclive/func/imgCompare.php";
require_once IA_ROOT."/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
require_once "../addons/wxz_piclive/func/common.func.php";
require_once "../addons/wxz_piclive/lib/JSSDK.php";
$oJssdk = new JSSDK($_W['account']['key'], $_W['account']['secret']);
$image = new ThinkImage();

load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$lid = intval($_GPC['lid']);
$addImageUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=addimage&op=getCat&m=wxz_piclive";
$actionUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=addimage&op=post&m=wxz_piclive";
$wxUploadUrl = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=addimage&op=wxupload&m=wxz_piclive";

if ($operation == 'getCat') {

    $live_type_list = $qiniuStyleList = array();
    //所属分类
    $sql = "SELECT id as value, name as text FROM " . tablename('wxz_pic_live_type') . " WHERE enabled = 1 AND uniacid = '". $_W['uniacid'] ."' AND lid='$lid'";
    $live_type_list = pdo_fetchall($sql);
    //七牛图片样式
    $sql = "SELECT id as value, title as text FROM " . tablename('wxz_pic_qiniu_style') . " WHERE uniacid = '". $_W['uniacid'] ."'";
    $qiniuStyleList = pdo_fetchall($sql);

    $data = array(
        'live_type_list' => $live_type_list,
        'qiniuStyleList' => $qiniuStyleList
    );

    echo json_encode($data);die;
    //jsonReturn($data, "获取成功");
} elseif ($operation == 'post') {
    $tid = isset($_GPC['tid']) ? intval($_GPC['tid']) : 0;
    $live_list = $this->live_list($item['lid']);//直播间列表

    $live = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id = $lid");
    if (empty($lid)) {
        message('请输入直播间编号！');
    }
    if(empty($_GPC['original_img'])){
        message('请选择上传图片！');
    }
    $water_img = tomedia($live['water_img']);
    $water_thumb = tomedia($live['water_thumb']);
    $data = array(
        'lid' => $lid,
        'uniacid' => intval($_W['uniacid']),
        'topic_name' => isset($_GPC['topic_name']) ? trim($_GPC['topic_name']) : '',
        'topic_type'=>$_GPC['topic_type'],
        'qiniu_sid' => isset($_GPC['qiniu_sid']) ? intval($_GPC['qiniu_sid']) : 0,
        'qiniu_sid_big' => isset($_GPC['qiniu_sid_big']) ? intval($_GPC['qiniu_sid_big']) : 0,
        'add_time' => time()
    );
    $thumbdir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/thumb/';
    !is_dir($thumbdir) && @mkdir($thumbdir, 0755, true);

    if (empty($tid)) {
        pdo_insert('wxz_pic_topic', $data);
        $tid = pdo_insertid();

        if(is_array($_GPC['original_img'])){
            $attach = array(
                'tid' => $tid,
                'lid' => $lid,
                'uniacid' => intval($_W['uniacid']),
                'typeid' => intval($_GPC['topic_type']),
                'qiniu_sid' => isset($_GPC['qiniu_sid']) ? intval($_GPC['qiniu_sid']) : 0,
                'qiniu_sid_big' => isset($_GPC['qiniu_sid_big']) ? intval($_GPC['qiniu_sid_big']) : 0,
                'size' => isset($_GPC['size']) ? trim($_GPC['size']) : '',
                'file_name' => isset($_GPC['file_name']) ? trim($_GPC['file_name']) : '',
                'add_time' => time()
            );
            foreach($_GPC['original_img'] as $val){
                $imginfo = pathinfo($val);
                if($_W['setting']['remote']['type'] != 3){
                    $thumbname = $imginfo['filename']."_150.".$imginfo['extension'];
                    $midthumbname = $imginfo['filename']."_1920.".$imginfo['extension'];
                    $thumbPath = $thumbdir.$thumbname;
                    $midthumbPath = $thumbdir.$midthumbname;
                    $sourceimagepath = $_W['siteroot']."attachment/".$val;
                    if(!file_exists($sourceimagepath)){
                        $sourceimagepath = $_W['attachurl'].$val;
                    }
                    if($live['water_thumb']){
                        $res = $image->open($sourceimagepath)->thumb(250, 250,THINKIMAGE_THUMB_CENTER)->water($water_thumb,THINKIMAGE_WATER_SOUTHEAST)->save($thumbPath);
                    }else{
                        $image->open($sourceimagepath)->thumb(250, 250,THINKIMAGE_THUMB_CENTER)->save($thumbPath);
                    }
                    $imagesize = @getimagesize($sourceimagepath);
                    $ori_rate = $imagesize[0]/$imagesize[1];
                    if(empty($setting['thumb_width'])){
                        $width = 800;
                    }else{
                        $width = $setting['thumb_width'];
                    }
                    $height = $width/$ori_rate;
                    if($live['water_img']){
                        $image->open($sourceimagepath)->thumb($width, $height,THINKIMAGE_THUMB_SCALING)->water($water_img,THINKIMAGE_WATER_SOUTHEAST)->save($midthumbPath);
                    }else{
                        $image->open($sourceimagepath)->thumb($width, $height,THINKIMAGE_THUMB_SCALING)->save($midthumbPath);
                    }

                    $attach['show_type'] = ($ori_rate < 1) ? 1: 0;
                    $attach['midthumb'] = "wxz_piclive/".date('Ymd')."/thumb/".$midthumbname;
                    $attach['thumbimg'] = "wxz_piclive/".date('Ymd')."/thumb/".$thumbname;
                }else{
                    $sourceimagepath = tomedia($val);
                    $imagesize = @getimagesize($sourceimagepath);
                    $ori_rate = $imagesize[0]/$imagesize[1];
                    $attach['show_type'] = ($ori_rate < 1) ? 1: 0;
                }
                $attach['picpath'] = $val;
                //文件大小
                $picpath = tomedia($val);
                $file = @file_get_contents($picpath);
                $length = strlen($file);
                $attach['bigimgsize'] = (getsize($length, 'mb') > 0) ? getsize($length, 'mb') : '0.01' ;
                //$attach['size'] = getsize($length, 'kb');
                $attach['file_name'] = $imginfo['basename'];

                pdo_insert('wxz_pic_attach', $attach);
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
            $sql = "UPDATE ".tablename('wxz_pic_topic') ." SET attach_id = '". $attach_id ."' WHERE tid = '$tid'";
            pdo_query($sql);
        }
    }

    message('提交成功！', $this->createMobileUrl('addimage', array('op' => 'display', 'lid' => $lid)), 'success');

} elseif ($operation == 'upload') {
    $data = array('err'=>0, 'msg'=>'', 'imgUrl'=>'');
    $filedata = trim($_GPC['filedata']);
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $filedata, $result)){
        $new_file = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/';
        !is_dir($new_file) && @mkdir($new_file, 0755, true);
        $type = $result[2];
        $filetype = ['jpg', 'jpeg', 'gif', 'png'];
        if (!in_array($type, $filetype)) {
            $data['err'] = 100;
            $data['msg'] = '图片格式不正确';
        }
        $new_file = $new_file.time().".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $filedata)))) {
            $data['imgUrl'] = $new_file;
        } else {
            $data['err'] = 1;
            $data['msg'] = '图片上传失败！';
        }
        echo json_encode($data);die;
    } else {
        $data['msg'] = '图片上传失败！';
        echo json_encode($data);die;
    }
}elseif($operation == 'wxupload') {
    $data = array('err'=>0, 'msg'=>'', 'imgUrl'=>'');
    //access_token
    $sAccessToken = $oJssdk->getAccessToken();
    $sMediaId = trim($_GPC['mediaId']);
    if ( ! $sMediaId) {
        $data['msg'] = '参数错误，请重新选择图片上传！';
        echo json_encode($data);die;
    }
    $sUrl = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=' . $sAccessToken . '&media_id=' . $sMediaId;

    //文件名称
    $folder = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . "/images/{$_W['uniacid']}" . '/'.date('Y/m/');
    $filepath = "images/{$_W['uniacid']}" . '/'.date('Y/m/');
    //$filename = date("ymdhis",time()).".jpg";
    !is_dir($folder) && @mkdir($folder, 0755, true);
    //$new_file = $filepath.$filename;
    $filename = random(30) . '.' . 'jpg';
    //$sImgPath = date('Y',time()).'/'.date('md',time()). '/'.time(). '.jpg';
    //$sImgName =  PHPCMS_ROOT.'/front/public/uploadfile/' .$sImgPath;

    $oFileInfo = downloadWeixinFile($sUrl);//downloadWeixinFile
    if ($oFileInfo['body']) {
        saveWechatFile($folder, $filename,$oFileInfo['body']);
        if (!empty($_W['setting']['remote']['type'])) {
            $original_img = $filepath . $filename;
            $remotestatus = file_remote_upload($original_img);
            if (is_error($remotestatus)) {
                //file_delete($pathname);
                $result['error'] = 0;
                $result['message'] = '远程附件上传失败，请检查配置并重新上传';
                die(json_encode($result));
            } else {
                //file_delete($pathname);
            }
        }
        $data['imgUrl'] = $filepath . $filename;
        echo json_encode($data);die;
    } else {
        $data['msg'] = '图片上传失败！';
        echo json_encode($data);die;
    }

}elseif ($operation == 'findme') {
    $data = array('err'=>0, 'msg'=>'', 'findedImg'=>array());
    $imgurl = trim($_GPC['meImgUrl']);
    if ($imgurl){
        //var_dump(ImageHash::run($new_file, IA_ROOT.'/attachment/wxz_piclive/20181111/1541925529.png'));
        $count = 0;
        $instance = ImgCompare::init();
        //获取附件信息
        $condition = " WHERE `uniacid` = ". $_W['uniacid'] ." AND lid='1' AND is_video=0 " ;
        $params = array(':uniacid' => $_W['uniacid']);

        $sql = "SELECT * FROM " . tablename('wxz_pic_attach') . $condition . " ORDER BY aid DESC";
        $List = pdo_fetchall($sql);
        foreach($List as $kk=>&$vv){
            if ($count > 30) {
                break;
            }
            //附件图片信息
            $row = pdo_fetch("SELECT * FROM ".tablename('wxz_pic_attach')." WHERE aid=".$vv['aid']);

            if(!file_exists($_W['siteroot'] . "attachment/" . $vv['picpath'])){
                $midpicpath = $_W['attachurl'].$vv['picpath'];
            }
            $picpath = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] .'/' .$vv['picpath'];
            $reuslt=$instance->checkIsSimilar($imgurl, $picpath);
            if ($result == '-1' || $result == '-2') {
                $data['err'] = 100;
                $data['msg'] = '图片不存在！';
                echo json_encode($data);die;
                break;
            }

            if ($reuslt <= 5) {
                if($_W['setting']['remote']['type'] == 3){
                    $qiniu_sid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$vv['qiniu_sid']}'");
                    $qiniu_sid_mid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$vv['qiniu_sid_big']}'");
                    $vv['smallUrl'] = tomedia($vv['picpath'])."?".$qiniu_sid_style;
                    $vv['midUrl'] = tomedia($vv['picpath'])."?".$qiniu_sid_mid_style;
                    $vv['bigUrl'] = tomedia($vv['picpath']);
                }else{
                    $vv['smallUrl'] = $_W['siteroot']."attachment/".$vv['thumbimg'];
                    $vv['midUrl'] = $_W['siteroot']."attachment/".$vv['midthumb'];
                    $vv['bigUrl'] = isset($midpicpath) ? $midpicpath : tomedia($vv['picpath']);
                }
                //文件大小
                $vv['bigImgSize'] = $vv['bigimgsize'] > 0 ? round($vv['bigimgsize']/1024,2) : round($vv['size']/1024,2);
                $vv['size'] = round($vv['size']/1024,3) . "M";
                $vv['picId'] = $vv['file_name'];
                $vv['bigPicUrl'] = tomedia($vv['picpath']);
                $vv['isLoadBigPiced'] = true;
                $vv['isPraise'] = IsGoodstar($vv['aid'],$_W['fans']['uid'],$vv['lid']);
                $vv['show_type'] = $vv['show_type'];
                $vv['praise'] = getStarNum($vv['aid']);
                $vv['userPic'] = str_replace('132132','132',$vv['avatar']);
                //评论
                $commentList = getComment($vv['aid']);
                $vv['commentList'] = $commentList;

                $data['findedImg']['list'][] = $vv;
                $count++;
                $data['findedImg']['count'] = $count;
            } else {
                continue;
            }
        }
        if ($count == 0) {
            $data['err'] = 100;
            $data['msg'] = '未找到相关图片';
        }
        echo json_encode($data);die;

    }else{
        $data['err'] = 1;
        $data['msg'] = '图片上传失败！';
        echo json_encode($data);die;
    }


}

function downloadWeixinFile($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);
    curl_close($ch);
    $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
    return $imageAll;
}

function saveWechatFile($newfolder,$filename, $filecontent)
{
    createFolder($newfolder);
    $local_file = fopen($newfolder."/".$filename, 'w');
    if (false !== $local_file){

        if (false !== fwrite($local_file, $filecontent)) {

            fclose($local_file);

        }
    }
}
function createFolder($path)
{
    if (!file_exists($path))
    {
        createFolder(dirname($path));
        mkdir($path, 0777);
    }
}

function file_remote_upload($filename, $auto_delete_local = true) {
    global $_W;
    if (empty($_W['setting']['remote']['type'])) {
        return false;
    }
    if ($_W['setting']['remote']['type'] == '1') {
        require_once(IA_ROOT . '/framework/library/ftp/ftp.php');
        $ftp_config = array(
            'hostname' => $_W['setting']['remote']['ftp']['host'],
            'username' => $_W['setting']['remote']['ftp']['username'],
            'password' => $_W['setting']['remote']['ftp']['password'],
            'port' => $_W['setting']['remote']['ftp']['port'],
            'ssl' => $_W['setting']['remote']['ftp']['ssl'],
            'passive' => $_W['setting']['remote']['ftp']['pasv'],
            'timeout' => $_W['setting']['remote']['ftp']['timeout'],
            'rootdir' => $_W['setting']['remote']['ftp']['dir'],
        );
        $ftp = new Ftp($ftp_config);
        if (true === $ftp->connect()) {
            $response = $ftp->upload(ATTACHMENT_ROOT . '/' . $filename, $filename);
            if ($auto_delete_local) {
                file_delete($filename);
            }
            if (!empty($response)) {
                return true;
            } else {
                return error(1, '远程附件上传失败，请检查配置并重新上传');
            }
        } else {
            return error(1, '远程附件上传失败，请检查配置并重新上传');
        }
    } elseif ($_W['setting']['remote']['type'] == '2') {
        require_once(IA_ROOT.'/framework/library/alioss/autoload.php');
        load()->model('attachment');
        $buckets = attachment_alioss_buctkets($_W['setting']['remote']['alioss']['key'], $_W['setting']['remote']['alioss']['secret']);
        $endpoint = 'http://'.$buckets[$_W['setting']['remote']['alioss']['bucket']]['location'].'.aliyuncs.com';
        try {
            $ossClient = new \OSS\OssClient($_W['setting']['remote']['alioss']['key'], $_W['setting']['remote']['alioss']['secret'], $endpoint);
            $ossClient->uploadFile($_W['setting']['remote']['alioss']['bucket'], $filename, ATTACHMENT_ROOT.$filename);
        } catch (\OSS\Core\OssException $e) {
            return error(1, $e->getMessage());
        }
        if ($auto_delete_local) {
            file_delete($filename);
        }
    }elseif ($_W['setting']['remote']['type'] == '3') {
        require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
        $auth = new Qiniu\Auth($_W['setting']['remote']['qiniu']['accesskey'],$_W['setting']['remote']['qiniu']['secretkey']);
        $config = new Qiniu\Config();
        $uploadmgr = new Qiniu\Storage\UploadManager($config);
        $putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array('scope' => $_W['setting']['remote']['qiniu']['bucket'].':'. $filename)));
        $uploadtoken = $auth->uploadToken($_W['setting']['remote']['qiniu']['bucket'], $filename, 3600, array($putpolicy));
        list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, ATTACHMENT_ROOT. '/'.$filename);
        if ($auto_delete_local) {
            //file_delete($filename);
        }
        if ($err !== null) {
            return error(1, '远程附件上传失败，请检查配置并重新上传');
        } else {
            return true;
        }
    } elseif ($_W['setting']['remote']['type'] == '4') {
        require(IA_ROOT.'/framework/library/cos/include.php');
        $uploadRet = \Qcloud_cos\Cosapi::upload($_W['setting']['remote']['cos']['bucket'], ATTACHMENT_ROOT .$filename,'/'.$filename,'',3 * 1024 * 1024, 0);
        if ($uploadRet['code'] != 0) {
            switch ($uploadRet['code']) {
                case -62:
                    $message = '输入的appid有误';
                    break;
                case -79:
                    $message = '输入的SecretID有误';
                    break;
                case -97:
                    $message = '输入的SecretKEY有误';
                    break;
                case -166:
                    $message = '输入的bucket有误';
                    break;
            }
            return error(-1, $message);
        }
    }
}

function file_delete($file) {
    if (empty($file)) {
        return FALSE;
    }
    if (file_exists($file)) {
        @unlink($file);
    }
    if (file_exists(ATTACHMENT_ROOT . '/' . $file)) {
        @unlink(ATTACHMENT_ROOT . '/' . $file);
    }
    return TRUE;
}



include $this->template('addimage');

