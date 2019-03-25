<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid = $_W['uniacid'];
$modelName = 'book_distance';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$modelName);
$schoolid = intval($_GPC['schoolid']);
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $children = array();
    $result = pdo_fetchall("SELECT * FROM " . tablename($this->table_bookmargin) . " WHERE  type = '{$modelName}'  ORDER BY amount ASC");
    $book_distance = array();
    foreach ($result as $index => $row) {
        if (!empty($row['parentid'])) {
            $children[$row['parentid']][] = $row;
        }
        $book_distance[$index] = $row;
    }
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $sid = intval($_GPC['sid']);
    if (!empty($sid)) {
        $book_distance = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin) . " WHERE id = '$sid'");
    } else {
        $book_distance = array(
            'ssort' => 0,
        );
    }
    if (checksubmit('submit')) {
        if (empty($_GPC['sname'])) {
            message('抱歉，请输入名称！');
        }
        $data = array(
            'name' => $_GPC['sname'],
            'amount' => $_GPC['amount'],
            'maxAmount' => $_GPC['maxAmount'] > 0 ? $_GPC['maxAmount'] : 0,
            'type' => $modelName,
            'classify' => $_GPC['classify'],
        );

        if (!empty($sid)) {
            pdo_update($this->table_bookmargin, $data, array('id' => $sid));
        } else {
            pdo_insert($this->table_bookmargin, $data);
            $sid = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
} elseif ($operation == 'delete') {
    $sid = intval($_GPC['sid']);
    $courseCats = pdo_fetch("SELECT sid FROM " . tablename($this->table_bookmargin) . " WHERE id = '$sid'");
    if (empty($courseCats)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'error');
    }
    pdo_delete($this->table_bookmargin, array('id' => $sid), 'OR');
    message('删除成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}
include $this->template ( 'web/'.$modelName );
?>