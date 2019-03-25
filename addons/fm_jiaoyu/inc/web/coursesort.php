<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;
$weid = $_W['uniacid'];
$action = 'courseSort';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
$schoolid = intval($_GPC['schoolid']);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
if ($operation == 'display') {
    // 排序selection
    if (!empty($_GPC['ssort'])) {
        foreach ($_GPC['ssort'] as $sid => $ssort) {
            pdo_update($this->table_classify, array('ssort' => $ssort), array('sid' => $sid));
        }
        message('批量更新排序成功', $this->createWebUrl('week', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }

    $allCourse = array();
    $allCourse = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse));
    $length = count($allCourse);
    for ($i = 0; $i < $length; $i++) {
        if (empty($allCourse[$i]['schoolName'])) {
            unset($allCourse[$i]);
        }
    }
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);//0
    $sid = intval($_GPC['sid']);//0
    if (!empty($sid)) {
        $week = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
    } else {
        $week = array(
            'ssort' => 0,//here
        );
    }
    if (checksubmit('submit')) {
        if (empty($_GPC['schoolName']) || empty($_GPC['semesterName']) || empty($_GPC['weekNum']) || empty($_GPC['shangwuNum']) || empty($_GPC['xiawuNum']) || empty($_GPC['nightNum'])) {
            message('抱歉, 请输入完整, 或者还有其它选项为空！');
            return false;
        }

        $data = array(
            'weid' => $weid,
            'schoolid' => $schoolid,
            'ssort' => intval($_GPC['ssort']),
            'schoolName' => $_GPC['schoolName'],
            'semesterName' => $_GPC['semesterName'],
            'weekNum' => intval($_GPC['weekNum']),
            'shangwuNum' => intval($_GPC['shangwuNum']),
            'xiawuNum' => intval($_GPC['xiawuNum']),
            'nightNum' => intval($_GPC['nightNum']),
            'type' => 'courseSort'
        );

        // sid=0
        if (!empty($sid)) {
            unset($data['parentid']);
            pdo_update($this->table_tcourse, $data, array('sid' => $sid));
        } else {
            pdo_insert($this->table_tcourse, $data);
            $sid = pdo_insertid();
            if ($sid > 0) {
                message('添加基本信息成功！', $this->createWebUrl('coursesort', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
            } else {
                message('添加基本信息失败！', $this->createWebUrl('coursesort', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
            }
        }
    }
} elseif ($operation == 'delete') {
    $sid = intval($_GPC['sid']);
    $week = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
    if (empty($week)) {
        message('抱歉，星期不存在或是已经被删除！', $this->createWebUrl('week', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
    }
    pdo_delete($this->table_classify, array('sid' => $sid), 'OR');
    message('星期删除成功！', $this->createWebUrl('week', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}
include $this->template ( 'web/coursesort' );
?>