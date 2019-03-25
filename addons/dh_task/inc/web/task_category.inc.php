<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'task_category';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;
    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $catelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_task_cate) . " WHERE weid = :weid" . $limit, array(':weid' => $weid));
	$total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_task_cate) . " WHERE weid = :weid", array(':weid' => $weid));
    $pager = pagination($total, $pindex, $psize);
	
}  else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_task_cate) . " WHERE id = :id AND weid=:weid", array(':id' => $id,':weid'=>$weid));
    if (checksubmit()) {
        $data = array(
            'weid' => $weid,
            'title' => trim($_GPC['title'])
        );
        if (empty($item)) {
            pdo_insert($this->table_task_cate, $data);
        } else {
            pdo_update($this->table_task_cate, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功！', $this->createWebUrl('task_category', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_task_cate) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('task_category', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    $task = pdo_fetch("SELECT id FROM " . tablename($this->table_task) . " WHERE cateid = :cateid AND weid=:weid", array(':cateid' => $id, ':weid' => $weid));
    if($task){
        message('该标签下还有任务，请先转移标签下的任务', $this->createWebUrl('task_category', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_task_cate, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('task_category', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/task_category');