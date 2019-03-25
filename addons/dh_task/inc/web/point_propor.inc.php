<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'point_propor';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    if (!empty($_GPC['username'])) {
        $username = trim($_GPC['username']);
        $condition .= " AND (f.username LIKE '%{$username}%' OR f.nickname LIKE '%{$username}%')";
    }
    if(!empty($_GPC['mark'])){
        $mark = trim($_GPC['mark']);
        $condition .= " AND r.mark LIKE '%{$mark}%'";
    }
    if($_GPC['status'] != ""){
        $status = intval($_GPC['status']);
        $condition .= " AND r.status={$status}";
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $list = pdo_fetchall("SELECT r.*,f.username,f.nickname,f.account_type,f.account FROM ".tablename($this->table_recharge)." AS r LEFT JOIN ".tablename($this->table_fans)." AS f ON r.user_id=f.id WHERE r.weid=:weid ".$condition." ORDER BY r.id desc".$limit,array(':weid' => $weid));
    $total = pdo_fetchcolumn("SELECT count(1) FROM ".tablename($this->table_recharge)." AS r LEFT JOIN ".tablename($this->table_fans)." AS f ON r.user_id=f.id WHERE r.weid=:weid ".$condition, array(':weid' => $weid));

    $pager = pagination($total, $pindex, $psize);
} elseif ($operation == 'status') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status'])==1?intval($_GPC['status']):2;;
    $pointsinfo = pdo_fetch("SELECT r.*,f.username,f.nickname,f.account_type,f.account FROM ".tablename($this->table_recharge)." AS r LEFT JOIN ".tablename($this->table_fans)." AS f ON r.user_id=f.id WHERE r.weid=:weid AND r.id=:id AND r.status=0",array(':weid' => $weid,'id'=>$id));
    if(empty($pointsinfo)){
        message('无法执行操作', $this->createWebUrl('point_propor', array('op' => 'display')), 'error');
        exit;
    }
    if($status == 1){//如果通过则扣除积分
        if(!($this->changePoints($pointsinfo['user_id'],-$pointsinfo['points'],"提现到:".$pointsinfo['account_type']."-".$pointsinfo['account']))){
            message('执行积分扣除失败', $this->createWebUrl('point_propor', array('op' => 'display')), 'error');
            exit;
        }
        $data['mark'] = "提现到:".$pointsinfo['account_type']."-".$pointsinfo['account'];
    }
    $data['status'] = $status;
    pdo_update($this->table_recharge,$data,array('id'=>$id));
    message('操作成功！', $this->createWebUrl('point_propor', array('op' => 'display')), 'success');
}
include $this->template('web/point_propor');