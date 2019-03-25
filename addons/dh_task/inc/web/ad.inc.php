<?php
global $_GPC, $_W;
$action = 'ad';
$title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_ad) . "WHERE weid = :weid ORDER BY `id` DESC",array(':weid'=>$_W['uniacid']));
} elseif ($operation == 'post') {

    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $info = pdo_fetch("SELECT * FROM " . tablename($this->table_ad) . " WHERE id = :id and weid=:weid",array(':id'=>$id,':weid'=>$_W['uniacid']));
    }
    if (checksubmit('submit')) {
        $title = trim($_GPC['title']);
        $image = trim($_GPC['image']);
        $type = intval($_GPC['type']);
        if (empty($title) || empty($image)) {
            message('标题或图片不能为空！');
        }
        if(empty($type)){
            message('请选择类型！');
        }
        $data = array(
            'weid' => $_W['uniacid'],
            'title' => $title,
            'image' => $image,
            'type' => $type,
            'mark' =>trim($_GPC['mark']),
            'link' =>trim($_GPC['link']),
            'sorting' =>intval($_GPC['sorting'])
        );


        if (!empty($id)) {
            pdo_update($this->table_ad, $data, array('id' => $id,'weid'=>$_W['uniacid']));
        } else {
            $ct = pdo_fetch("SELECT * FROM " . tablename($this->table_ad) . " WHERE title = :title and weid=:weid",array(':title'=>$title,':weid'=>$_W['uniacid']));
            if(!empty($ct)){message('抱歉，该信息已存在！');}
            pdo_insert($this->table_ad, $data);
            $id = pdo_insertid();
        }
        message('页面编辑成功！', $this->createWebUrl('ad', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $info = pdo_fetch("SELECT id FROM " . tablename($this->table_ad) . " WHERE id = :id and weid=:weid",array(':id'=>$id,':weid'=>$_W['uniacid']));
    if (empty($info)) {
        message('内容不存在或已经被删除！', $this->createWebUrl('ad', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_ad, array('id' => $id,'weid'=>$_W['uniacid']));
    message('删除成功！', $this->createWebUrl('ad', array('op' => 'display')), 'success');
}
include $this->template('web/ad');