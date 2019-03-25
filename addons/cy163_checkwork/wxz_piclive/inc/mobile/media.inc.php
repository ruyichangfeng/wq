<?php

global $_GPC, $_W;
load()->model('mc');
$fan = mc_fansinfo($_W['openid']);
if (!empty($fan) && !empty($fan['openid'])) {
    $userinfo = $fan;
} else {
    $userinfo = mc_oauth_userinfo();
}

load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$lid = isset($_GPC['lid']) ? intval($_GPC['lid']) : 1;
//直播间信息
 $live = pdo_fetch("SELECT * FROM ".tablename('wxz_pic_live')." WHERE id='$lid'");
 
if($operation == 'getMediaInfo'){
   
    $aid = intval($_GPC['aid']);
    $info = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_attach') . " WHERE aid = :aid", array(':aid' => $aid));
    $info['video_url'] = tomedia($info['video_url']);
    $info['video_img'] = tomedia($info['video_img']);
    
    echo json_encode($info);die;
}elseif($operation == 'mediaList'){
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $condition = " WHERE `uniacid` = ". $_W['uniacid'] ." AND lid='{$lid}' AND is_video=1 " ;

    $params = array(':uniacid' => $_W['uniacid']);

    $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_attach') . $condition;
    $total = pdo_fetchcolumn($sql);
    if (!empty($total)) {
            $sql = "SELECT * FROM " . tablename('wxz_pic_attach') . $condition . " ORDER BY aid DESC
                            LIMIT " . ($pindex - 1) * $psize . "," . $psize;
            $List = pdo_fetchall($sql);
            foreach($List as $kk=>$vv){
                $List[$kk]['video_thumb'] = tomedia($vv['video_thumb']);
            }
            $pager = pagination($total, $pindex, $psize);
    }
    
    $arr['list'] = $List;
    $arr['page'] = $pindex;
    $arr['pageTotal'] = ceil($total/15);
    echo json_encode($arr);die;
}

include $this->template('media');

