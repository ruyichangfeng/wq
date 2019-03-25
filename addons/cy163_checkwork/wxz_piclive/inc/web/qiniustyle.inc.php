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
    $condition = " WHERE `uniacid` = '". $_W['uniacid'] ."'";

    if (!empty($_GPC['keyword'])) {
            $condition .= " AND `title` LIKE '%". trim($_GPC['title']) ."%'";
    }
    
    $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_qiniu_style') . $condition;
    $total = pdo_fetchcolumn($sql);
    if (!empty($total)) {
            $sql = 'SELECT * FROM ' . tablename('wxz_pic_qiniu_style') . $condition . ' ORDER BY `id` DESC
                            LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
            $list = pdo_fetchall($sql);

            $pager = pagination($total, $pindex, $psize);
    }
    
    include $this->template('qiniuStyle');
} elseif ($operation == 'post') {
    $sid = intval($_GPC['sid']);
    $style = array();
    if($sid){
        $style = pdo_fetch('SELECT * FROM ' . tablename('wxz_pic_qiniu_style') . ' WHERE `id` = :id ', array(':id' => $sid));
    }

    if (checksubmit('submit')) {
        if(!$_GPC['title'] || !$_GPC['styleText']){
            message('信息不完善！');
        }
        $data = array(
                'uniacid' => $_W['uniacid'],
                'title' => trim($_GPC['title']),
                'styleText' => trim($_GPC['styleText'])
        );
        if(empty($sid)){
            $data['addtime'] = time();
            pdo_insert('wxz_pic_qiniu_style', $data);
        }else{
            pdo_update('wxz_pic_qiniu_style', $data, array('id' => $sid));
        }
        
        message('提交成功！', $this->createWebUrl('qiniustyle', array('op' => 'display')), 'success');
    }
    
    include $this->template('qiniuStyle');
    
} elseif ($operation == 'delete') {
    $sid = intval($_GPC['sid']);
    $row = pdo_fetch("SELECT id  FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = :sid", array(':sid' => $sid));
    if (empty($row)) {
            message('抱歉，信息不存在或是已经被删除！');
    }
    pdo_delete('wxz_pic_qiniu_style', array('id' => $sid));
    
    message('删除成功！', referer(), 'success');

} else {
    message('请求方式不存在');
}
