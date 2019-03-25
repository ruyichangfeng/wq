<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid = $_W['uniacid'];
$modelName = 'flowlist';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$modelName);
$schoolid = intval($_GPC['schoolid']);
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$sid = intval($_GPC['sid']);
if ($operation == 'display') {
    if (!empty($_GPC['ssort'])) {
        foreach ($_GPC['ssort'] as $sid => $ssort) {
            pdo_update($this->table_flow, array('ssort' => $ssort), array('id' => $sid));
        }
        message('批量更新排序成功', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
    $children = array();
    $condition = '';
    if(!empty($_GPC['keyword'])){
        $condition .= 'AND name like "%'.$_GPC['keyword'].'%"';
    }

    $result = pdo_fetchall("SELECT * FROM " . tablename($this->table_flow) . " WHERE weid = '{$weid}' And flowType = '{$modelName}' And schoolid = {$schoolid}  $condition ORDER BY id ASC, ssort DESC");
    $list = array();
    foreach ($result as $index => $row) {
        if (!empty($row['parentid'])) {
            $children[$row['parentid']][] = $row;
        }
        $list[$index] = $row;
    }
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $sid = intval($_GPC['sid']);
    if (!empty($sid)) {
        $list = pdo_fetch("SELECT * FROM " . tablename($this->table_flow) . " WHERE id = '$sid'");
    } else {
        $list = array(
            'ssort' => 0,
        );
    }
    if(!empty($sid)){
        $flowLists = pdo_fetchall("SELECT * FROM " . tablename($this->table_flow) . " WHERE weid = '{$weid}' And flowType = '{$modelName}' And schoolid = {$schoolid}  And id <> {$sid} ORDER BY id ASC, ssort DESC");
    }else{
        $flowLists = pdo_fetchall("SELECT * FROM " . tablename($this->table_flow) . " WHERE weid = '{$weid}' And flowType = '{$modelName}' And schoolid = {$schoolid}   ORDER BY id ASC, ssort DESC");
    }
    if (checksubmit('submit')) {
        if (empty($_GPC['flowName'])) {
            message('抱歉，请输入名称！');
        }
        $data = array(
            'weid' => $weid,
            'schoolid' => $_GPC['schoolid'],
            'name' => $_GPC['flowName'],
            'ssort' => intval($_GPC['ssort']),
            'flowType' => $modelName,
            'nodeType' => intval($_GPC['nodeType']),
            'parentid' => intval($parentid),
            'needPic'  => intval($_GPC['needPic']) > 0 ? $_GPC['needPic'] : 1,
            'picType'  => (intval($_GPC['needPic']) == 2 && intval($_GPC['picType']) > 0) ? intval($_GPC['picType']) : 0
        );

        if (!empty($sid)) {
//            unset($data['parentid']);
            pdo_update($this->table_flow, $data, array('id' => $sid));
        } else {
            pdo_insert($this->table_flow, $data);
            $sid = pdo_insertid();
        }
        message('更新考勤流程成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
} elseif ($operation == 'delete') {
    $sid = intval($_GPC['sid']);
    $courseCats = pdo_fetch("SELECT id FROM " . tablename($this->table_flow) . " WHERE id = '$sid'");
    if (empty($courseCats)) {
        message('抱歉，考勤流程不存在或是已经被删除！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'error');
    }
    pdo_delete($this->table_flow, array('id' => $sid), 'OR');
    message('考勤流程删除成功！', $this->createWebUrl($modelName, array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}
include $this->template ( 'web/'.$modelName );
?>