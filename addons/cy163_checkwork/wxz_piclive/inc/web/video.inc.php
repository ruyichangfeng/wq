<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
load()->model('mc');
load()->func('compat.biz');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';


if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $condition = " WHERE `uniacid` = '". $_W['uniacid'] ."' AND `is_video` = 1";
    //$params = array(':uniacid' => $_W['uniacid'], ':is_video' => 1);
    if (!empty($_GPC['keyword'])) {
            $condition .= " AND `file_name` LIKE '%". trim($_GPC['keyword']) ."%'";
    }
    if (!empty($_GPC['lid'])) {
            $condition .= " AND `lid` = '". intval($_GPC['lid']) ."'";
    }
    $live_list = $this->live_list($_GPC['lid']);//直播间列表
    
    $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_attach') . $condition;
    $total = pdo_fetchcolumn($sql);
    if (!empty($total)) {
            $sql = 'SELECT * FROM ' . tablename('wxz_pic_attach') . $condition . ' ORDER BY `aid` DESC
                            LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
            $list = pdo_fetchall($sql);
            if($list){
                foreach($list as $kk=>$vv){
                    $list[$kk]['live_name'] = pdo_fetchcolumn("SELECT live_name FROM ".tablename('wxz_pic_live')." WHERE id='{$vv['lid']}'");
                }
            }
            $pager = pagination($total, $pindex, $psize);
    }
    
    include $this->template('video');
} elseif ($operation == 'post') {
    $aid = intval($_GPC['aid']);
    $attachInfo = array();
    if($aid){
        $attachInfo = pdo_fetch('SELECT * FROM ' . tablename('wxz_pic_attach') . ' WHERE `aid` = :aid ', array(':aid' => $aid));
    }
    $live_list = $this->live_list($attachInfo['lid']);//直播间列表
    $lid = $attachInfo['lid'];
    
    if (checksubmit('submit')) {
        $lid = intval($_GPC['lid']);
        if(!$lid){
            message('请选择直播间！');
        }
        $data = array(
                'uniacid' => $_W['uniacid'],
                'lid' => $lid,
                'is_video'=> 1,
                'video_url' => trim($_GPC['video_url']),
                'video_img' => trim($_GPC['video_img']),
                'video_thumb' => trim($_GPC['video_thumb']),
                'file_name' => trim($_GPC['file_name'])
        );
        if(empty($aid)){
            $data['add_time'] = time();
            pdo_insert('wxz_pic_attach', $data);
        }else{
            $data['update_time'] = time();
            pdo_update('wxz_pic_attach', $data, array('aid' => $aid));
        }
        
        message('提交成功！', $this->createWebUrl('video', array('op' => 'display')), 'success');
    }
    
    include $this->template('video');
    
} elseif ($operation == 'delete') {
    $aid = intval($_GPC['aid']);
    $row = pdo_fetch("SELECT aid  FROM " . tablename('wxz_pic_attach') . " WHERE aid = :aid", array(':aid' => $aid));
    if (empty($row)) {
            message('抱歉，信息不存在或是已经被删除！');
    }
    pdo_delete('wxz_pic_attach', array('aid' => $aid));
    
    message('删除成功！', referer(), 'success');

} else {
    message('请求方式不存在');
}
