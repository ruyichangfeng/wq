<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'points_record';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    if (!empty($_GPC['username'])) {
        $username = trim($_GPC['username']);
        $condition .= " AND (username LIKE '%{$_GPC['username']}%' OR nickname LIKE '%{$_GPC['username']}%')";
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $list = pdo_fetchall("SELECT p.id,p.points_income,p.points_desc,p.points_time,f.username,f.nickname FROM ".tablename($this->table_points)." AS p LEFT JOIN ".tablename($this->table_fans)." AS f ON p.user_id = f.id WHERE p.weid = :weid {$condition} ORDER BY p.id DESC " . $limit, array(':weid' => $weid));
    $total = pdo_fetchcolumn("SELECT count(1) FROM ".tablename($this->table_points)." AS p LEFT JOIN ".tablename($this->table_fans)." AS f ON f.id = p.user_id WHERE p.weid = :weid {$condition} ", array(':weid' => $weid));

    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND id = :id", array(':id' => $id, ':weid'=>$weid));

    if (checksubmit()) {
        $data = array(
            'weid' => $weid,
            'nickname' => trim($_GPC['nickname']),
            'username' => trim($_GPC['username']),
            'mobile' => trim($_GPC['mobile']),
            'address' => trim($_GPC['address']),
            'lat' => trim($_GPC['baidumap']['lat']),
            'lng' => trim($_GPC['baidumap']['lng']),
            'sex' => intval($_GPC['sex']),
            'dateline' => TIMESTAMP
        );
        if (!empty($_GPC['headimgurl'])) {
            $data['headimgurl'] = $_GPC['headimgurl'];
        }

        if (empty($item)) {
            pdo_insert($this->table_fans, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_fans, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功！', $this->createWebUrl('fans', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_fans) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('fans', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_fans, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('fans', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    pdo_query("UPDATE " . tablename($this->table_fans) . " SET status = abs(:status - 1) WHERE id=:id", array(':status' => $status, ':id' => $id));
    message('操作成功！', $this->createWebUrl('fans', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/points_record');