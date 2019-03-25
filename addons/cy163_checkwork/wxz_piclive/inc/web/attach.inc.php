<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
load()->model('mc');
load()->func('compat.biz');

require_once IA_ROOT."/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
require_once "../addons/wxz_piclive/func/common.func.php";
$image = new ThinkImage(); 

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$live_list = $this->live_list();//直播间

if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $condition = " WHERE `uniacid` = '". $_W['uniacid'] ."'";

    if (!empty($_GPC['lid'])) {
            $condition .= " AND `lid` = '". intval($_GPC['lid']) ."'";
    }
    
    $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_attach') . $condition;
    $total = pdo_fetchcolumn($sql);
    if (!empty($total)) {
            $sql = 'SELECT * FROM ' . tablename('wxz_pic_attach') . $condition . ' ORDER BY `aid` DESC
                            LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
            $list = pdo_fetchall($sql);
            foreach($list as $key=>$val){
                $sql = 'SELECT name FROM ' . tablename('wxz_pic_live_type') . " WHERE id = '{$val['typeid']}'";
                $catName = pdo_fetchcolumn($sql);
                $list[$key]['type_name'] = $catName;
                $list[$key]['picpath'] = tomedia($val['picpath']);
                $list[$key]['add_time'] = date("Y-m-d H:i:s", $val['add_time']);
            }

            $pager = pagination($total, $pindex, $psize);
    }
    
    include $this->template('attach');
} elseif ($operation == 'post') {
    $attachRow = array();
    $remoteType = $_W['setting']['remote']['type'];
    $setting = $this->module['config'];//配置项
    $aid = intval($_GPC['aid']);
    
    $attachRow = pdo_fetch('SELECT * FROM ' . tablename('wxz_pic_attach') . ' WHERE `aid` = :aid ', array(':aid' => $aid));
    if(!$attachRow){
        message('没有该信息！');
    }
    //直播间信息
    $live = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id = '{$attachRow['lid']}'");
    $water_img = tomedia($live['water_img']);
    $water_thumb = tomedia($live['water_thumb']);
    
    $qiniuStyleList = $this->getQiniuStyleList($attachRow['qiniu_sid']);//七牛样式列表
    $qiniuStyleList2 = $this->getQiniuStyleList($attachRow['qiniu_sid_big']);//七牛样式列表
    $attachRow['picpath'] = tomedia($attachRow['picpath']);

    if (checksubmit('submit')) {
        $original_img = $_GPC['original_img'];
        if(!$original_img){
            message('请选择上传图片！');
        }
        $attach = array(
                'qiniu_sid' => isset($_GPC['qiniu_sid']) ? intval($_GPC['qiniu_sid']) : 0,
                'qiniu_sid_big' => isset($_GPC['qiniu_sid_big']) ? intval($_GPC['qiniu_sid_big']) : 0
        );
        
        $imginfo = pathinfo($original_img);
        if($remoteType != 3){
            $thumbname = $imginfo['filename']."_150.".$imginfo['extension'];
            $midthumbname = $imginfo['filename']."_1920.".$imginfo['extension'];
            $thumbPath = $thumbdir.$thumbname;
            $midthumbPath = $thumbdir.$midthumbname;
            $sourceimagepath = $original_img;
            if(!preg_match('/attachment/',$original_img )){
                $sourceimagepath = $_W['siteroot']."attachment/".$original_img;
            }
            
            if($live['water_thumb']){
                    $image->open($sourceimagepath)->thumb(250, 250,THINKIMAGE_THUMB_CENTER)->water($water_thumb,THINKIMAGE_WATER_SOUTHEAST)->save($thumbPath);              
            }else{
                    $image->open($sourceimagepath)->thumb(250, 250,THINKIMAGE_THUMB_CENTER)->save($thumbPath);              
            }
            $imagesize = getimagesize($sourceimagepath);
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
            $attach['midthumb'] = "wxz_piclive/".date('Ymd')."/".$midthumbname;
            $attach['thumbimg'] = "wxz_piclive/".date('Ymd')."/".$thumbname;
        }
        $attach['picpath'] = strstr($original_img,'images');

        //文件大小
        $picpath = tomedia($original_img);
        $file = @file_get_contents($picpath);
        $length = strlen($file);
        $attach['size'] = getsize($length, 'kb');
        $attach['file_name'] = $imginfo['basename'];
        
        pdo_update('wxz_pic_attach', $attach, array('aid' => $aid));
        
        message('提交成功！', $this->createWebUrl('attach', array('op' => 'display')), 'success');
    }
    
    include $this->template('attach');
    
} elseif ($operation == 'delete') {
    $aid = intval($_GPC['aid']);
    $row = pdo_fetch("SELECT aid,tid FROM " . tablename('wxz_pic_attach') . " WHERE aid = :aid", array(':aid' => $aid));
    if (empty($row)) {
            message('抱歉，信息不存在或是已经被删除！');
    }
    
    $tid = $row['tid'];
    $res = pdo_delete('wxz_pic_attach', array('aid' => $aid));
    if($res){
        //同步删除wxz_pic_topic表数据
        $topicRow = pdo_fetch("SELECT tid, attach_id FROM " . tablename('wxz_pic_topic') . " WHERE tid = :tid", array(':tid' => $tid));
        if($topicRow['attach_id']){
            $ids = unserialize($topicRow['attach_id']);
            foreach($ids as $kk=>$vv){
                if($vv == $aid){
                    unset($ids[$kk]);
                }
            }
            if(empty($ids)){
                pdo_delete('wxz_pic_topic', array('tid' => $tid));
            }else{
                pdo_update('wxz_pic_topic', array('attach_id' => serialize($ids)), array('tid' => $tid));
            }
        }
        
    }
    message('删除成功！', referer(), 'success');

} else {
    message('请求方式不存在');
}
