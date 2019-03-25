<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid = $_W['uniacid'];
$modelName = 'navBar';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$modelName);
$schoolid = intval($_GPC['schoolid']);
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['ssort'])) {
        foreach ($_GPC['ssort'] as $sid => $ssort) {
            pdo_update($this->table_classify, array('ssort' => $ssort), array('sid' => $sid));
        }
        message('批量更新排序成功', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
    $children = array();
    $result = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And type = '{$modelName}' And schoolid = {$schoolid} ORDER BY sid ASC, ssort DESC");
    $menus = array();
    foreach ($result as $index => $row) {
        if (!empty($row['parentid'])) {
            $children[$row['parentid']][] = $row;
        }
        $menus[$index] = $row;
    }
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $sid = intval($_GPC['sid']);
    if (!empty($sid)) {
        $menus = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
    } else {
        $menus = array(
            'ssort' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['menuName'])) {
            message('抱歉，请输入名称！');
        }
        $data = array(
            'weid' => $weid,
            'schoolid' => $_GPC['schoolid'],
            'sname' => $_GPC['menuName'],
            'ssort' => intval($_GPC['ssort']),
            'type' => $modelName,
            'parentid' => intval($parentid),
        );

        if (!empty($sid)) {
            unset($data['parentid']);
            pdo_update($this->table_classify, $data, array('sid' => $sid));
        } else {
            pdo_insert($this->table_classify, $data);
            $sid = pdo_insertid();
        }
        message('更新菜单成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
} elseif ($operation == 'delete') {
    $sid = intval($_GPC['sid']);
    $courseCats = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
    if (empty($courseCats)) {
        message('抱歉，菜单不存在或是已经被删除！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'error');
    }
    pdo_delete($this->table_classify, array('sid' => $sid), 'OR');
    message('菜单删除成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}
include $this->template ( 'web/'.$modelName );
?>