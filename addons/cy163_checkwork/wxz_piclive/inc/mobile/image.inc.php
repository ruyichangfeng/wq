<?php

/**
 * 图片信息
 */

global $_GPC, $_W;
load()->model('mc');
$fan = mc_fansinfo($_W['openid']);
if (!empty($fan) && !empty($fan['openid'])) {
    $userinfo = $fan;
} else {
    $userinfo = mc_oauth_userinfo();
}

require_once IA_ROOT."/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
require_once "../addons/wxz_piclive/func/common.func.php";
$image = new ThinkImage(); 

//load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$aid = intval($_GPC['aid']);
$flag = isset($_GPC['flag']) ? intval($_GPC['flag']) : 0;
$res = array('err'=>0, 'msg'=>'', 'data'=>array());

if ($operation == 'info') {
    $attachRow = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_attach') . " WHERE aid = $aid");
    
    if($attachRow){
        if($_W['setting']['remote']['type'] == 3){
            $qiniu_sid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$attachRow['qiniu_sid']}'");
            $qiniu_sid_mid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$attachRow['qiniu_sid_big']}'");
            $attachRow['smallUrl'] = tomedia($attachRow['picpath'])."?".$qiniu_sid_style;
            $attachRow['midUrl'] = tomedia($attachRow['picpath'])."?".$qiniu_sid_mid_style;
            $attachRow['bigUrl'] = tomedia($attachRow['picpath']);
        }else{
            $attachRow['smallUrl'] = $_W['siteroot']."attachment/".$attachRow['thumbimg'];
            $attachRow['midUrl'] = $_W['siteroot']."attachment/".$attachRow['midthumb'];
            $attachRow['bigUrl'] = isset($midpicpath) ? $midpicpath : tomedia($attachRow['picpath']);
        }
        $file = @file_get_contents($attachRow['midUrl']);
        $length = strlen($file);
        $attachRow['size'] = getsize($length, 'kb');

        $res['data'] = $attachRow;

    }
    
    echo json_encode($res);die;
    //jsonReturn($data, "获取成功");
} else{
    $res['err'] = 1;
    $res['msg'] = '参数错误';
    echo json_encode($res);die;

}




