<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid = $_W['uniacid'];
$modelName = 'book_max';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$modelName);
$schoolid = intval($_GPC['schoolid']);
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['ssort'])) {
        foreach ($_GPC['ssort'] as $id => $ssort) {
            pdo_update($this->table_bookmargin, array('ssort' => $ssort), array('id' => $id));
        }
        message('批量更新排序成功', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
    $book_max = pdo_fetchall("SELECT * FROM " . tablename($this->table_bookmargin) . " WHERE type = '{$modelName}'  ORDER BY id ASC");
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $book_max = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin) . " WHERE id = '$id'");
    } else {
        $book_max = array(
            'ssort' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['name'])) {
            message('抱歉，请输入名称！');
        }
        if (empty($_GPC['amount'])) {
            message('抱歉，请输入保证金额度！');
        }
        $data = array(
            'name' => $_GPC['name'],
            'amount' => floatval($_GPC['amount']),
            'type' => $modelName
        );

        if (!empty($id)) {
            pdo_update($this->table_bookmargin, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_bookmargin, $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $courseCats = pdo_fetch("SELECT id FROM " . tablename($this->table_bookmargin) . " WHERE id = '$id'");
    if (empty($courseCats)) {
        message('抱歉，类别不存在或是已经被删除！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'error');
    }
    pdo_delete($this->table_bookmargin, array('id' => $id), 'OR');
    message('删除成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}
include $this->template ( 'web/'.$modelName );
?>