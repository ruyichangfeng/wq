<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'settings';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $item = pdo_fetch("SELECT * FROM ". tablename($this->table_setting) . " WHERE weid = :weid", array('weid' => $weid));
    $tasklist = pdo_fetchall("SELECT id,task_title FROM ". tablename($this->table_task) . " WHERE weid = :weid AND status = 1 AND starttime<:time AND endtime>:time", array('weid' => $weid,':time' => time()));
    if (checksubmit()) {
        $data = array(
            'weid' => $weid,
            'user_points' => intval($_GPC['user_points']),
            'mobile_tpl' => trim($_GPC['mobile_tpl']),
            'user_legalize' => intval($_GPC['user_legalize']),
            'user_level' => intval($_GPC['user_level']),
            'user_cate' => intval($_GPC['user_cate']),
            'points_name' => trim($_GPC['points_name']),
            'web_name' => trim($_GPC['web_name']),
            'review_user' => trim($_GPC['review_user']),
            'isneedfollow' => intval($_GPC['isneedfollow']),
            'follow_image' => trim($_GPC['follow_image']),
            'weblogo' => trim($_GPC['weblogo']),
            'is_propor' => trim($_GPC['is_propor']),
            'point_propor' => trim($_GPC['point_propor']),
            'min_point' => trim($_GPC['min_point']),
            'is_commission' => intval($_GPC['is_commission']),
            'share_title' => trim($_GPC['share_title']),
            'share_desc' => trim($_GPC['share_desc']),
            'share_image' => trim($_GPC['share_image']),
            'share_point' => intval($_GPC['share_point']),
            'follow_task' => intval($_GPC['follow_task']),
            'share_taskid' => intval($_GPC['share_taskid']),
            'task_tempid1' => trim($_GPC['task_tempid1']),
            'task_temp_user' => trim($_GPC['task_temp_user']),
            'manner' => intval($_GPC['manner'])
        );
        if (!empty($_GPC['task_image'])) {
            $data['task_image'] = $_GPC['task_image'];
        }

        if (empty($item)) {
            pdo_insert($this->table_setting, $data, $replace = false);
            message('操作成功!', $this->createWebUrl('settings', array('op' => 'display', 'storeid' => $storeid)), 'success');
        } else {
            pdo_update($this->table_setting, $data, array('id' => $item['id'], 'weid' => $item['weid']));
            message('操作成功!', $this->createWebUrl('settings', array('op' => 'display', 'storeid' => $storeid)), 'success');
        }
    }
}
include $this->template('web/settings');