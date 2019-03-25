<?php
global $_GPC, $_W;
$action = 'field';
$title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
if($operation == "display"){
    $operation = "fieldset_display";
}
if ($operation == 'fieldset_display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_fieldset) . "WHERE weid = :weid ORDER BY `id` DESC",array(':weid'=>$_W['uniacid']));
    include $this->template('web/fieldset');
} elseif ($operation == 'fieldset_post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $info = pdo_fetch("SELECT * FROM " . tablename($this->table_fieldset) . " WHERE id = :id and weid=:weid",array(':id'=>$id,':weid'=>$_W['uniacid']));
    }
    if (checksubmit('submit')) {
        $name = trim($_GPC['name']);
        if (empty($name)) {
            message('表单名称不能为空！');
        }
        $data = array(
            'weid' => $_W['uniacid'],
            'name' => $name
        );
        if (!empty($id)) {
            pdo_update($this->table_fieldset, $data, array('id' => $id,'weid'=>$_W['uniacid']));
        } else {
            $ct = pdo_fetch("SELECT * FROM " . tablename($this->table_fieldset) . " WHERE name = :name and weid=:weid",array(':name'=>$name,':weid'=>$_W['uniacid']));
            if(!empty($ct)){message('抱歉，名称已存在！');}
            pdo_insert($this->table_fieldset, $data);
            $id = pdo_insertid();
        }
        message('编辑成功！', $this->createWebUrl('field', array('field' => 'display')), 'success');
    }
    include $this->template('web/fieldset');
} elseif ($operation == 'fieldset_delete') {
    $id = intval($_GPC['id']);
    $info = pdo_fetch("SELECT id FROM " . tablename($this->table_fieldset) . " WHERE id = :id and weid=:weid",array(':id'=>$id,':weid'=>$_W['uniacid']));
    if (empty($info)) {
        message('内容不存在或已经被删除！', $this->createWebUrl('field', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_fieldset, array('id' => $id,'weid'=>$_W['uniacid']));
    message('删除成功！', $this->createWebUrl('field', array('op' => 'display')), 'success');

}elseif($operation == 'field_display') {
    $fieldset_id = intval($_GPC['fieldset_id']);
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_field) . "WHERE fieldset_id=:fieldset_id AND weid = :weid ORDER BY `id` DESC",array(':fieldset_id'=>$fieldset_id,':weid'=>$_W['uniacid']));
    include $this->template('web/field');
} elseif ($operation == 'field_post') {
    $id = intval($_GPC['id']);
    $fieldset_id = intval($_GPC['fieldset_id']);
    if (!empty($id)) {
        $info = pdo_fetch("SELECT * FROM " . tablename($this->table_field) . " WHERE id = :id and weid=:weid",array(':id'=>$id,':weid'=>$_W['uniacid']));
    }
    if (checksubmit('submit')) {
        $name = trim($_GPC['name']);
        $type = intval($_GPC['type']);
        if (empty($name)) {
            message('名称不能为空！');
        }
        if(empty($type)){
            message('请选择类型！');
        }
        $data = array(
            'weid' => $_W['uniacid'],
            'fieldset_id' => $fieldset_id,
            'name' => $name,
            'type' => $type,
            'config' => trim($_GPC['config']),
            'sorting' =>intval($_GPC['sorting']),
            'verify' => intval($_GPC['verify'])
        );

        if (!empty($id)) {
            pdo_update($this->table_field, $data, array('id' => $id,'weid'=>$_W['uniacid'],'fieldset_id'=>$fieldset_id));
        } else {
            $ct = pdo_fetch("SELECT * FROM " . tablename($this->table_field) . " WHERE name = :name and weid=:weid and fieldset_id=:fieldset_id",array(':name'=>$name,':weid'=>$_W['uniacid'],':fieldset_id'=>$fieldset_id));
            if(!empty($ct)){message('抱歉，该信息已存在！');}
            pdo_insert($this->table_field, $data);
            $id = pdo_insertid();
        }
        message('编辑成功！', $this->createWebUrl('field', array('op' => 'field_display','fieldset_id'=>$fieldset_id)), 'success');
    }
    include $this->template('web/field');
} elseif ($operation == 'field_delete') {
    $id = intval($_GPC['id']);
    $fieldset_id = intval($_GPC['fieldset_id']);
    $info = pdo_fetch("SELECT id FROM " . tablename($this->table_field) . " WHERE id = :id and weid=:weid",array(':id'=>$id,':weid'=>$_W['uniacid']));
    if (empty($info)) {
        message('内容不存在或已经被删除！', $this->createWebUrl('field', array('op' => 'field_display','fieldset_id'=>$fieldset_id)), 'error');
    }
    pdo_delete($this->table_field, array('id' => $id,'weid'=>$_W['uniacid']));
    message('删除成功！', $this->createWebUrl('field', array('op' => 'field_display','fieldset_id'=>$fieldset_id)), 'success');
}
