<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'fans';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    if (!empty($_GPC['keyword'])) {
        $types = trim($_GPC['types']);
        $condition .= " AND f.{$types} LIKE '%{$_GPC['keyword']}%'";
    }
    if (isset($_GPC['task_type']) && $_GPC['task_type'] != '') {
        $condition .= " AND f.task_type={$_GPC['task_type']} ";
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $list = pdo_fetchall("SELECT f.*,c.title FROM " . tablename($this->table_fans) . "AS f LEFT JOIN ". tablename($this->table_task_cate). " AS c ON f.cateid = c.id WHERE f.weid = :weid {$condition} ORDER BY id DESC " . $limit, array(':weid' => $weid));
    //计算下线人数
    foreach ($list as $key => $value) {
        $list[$key]['commission_num'] = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND uid=:uid", array(':weid' => $weid,':uid'=>$value['id']));
        $list[$key]['commission_num_result'] = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " WHERE weid=:weid AND uid=:uid AND is_commission=1", array(':weid' => $weid,':uid'=>$value['id']));
        $uidinfo = pdo_fetch("SELECT username,nickname,headimgurl FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $value['uid']));
        $list[$key]['uid_nickname'] = $uidinfo['username']?$uidinfo['username']:$uidinfo['nickname'];
        $list[$key]['uid_headimgurl'] = $uidinfo['headimgurl'];
        $list[$key]['dateline'] = date("Y-m-d H:i",$value['dateline']);

    }
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_fans) . " AS f WHERE weid = :weid {$condition} ", array(':weid' => $weid));
	
    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id = :id", array(':id' => $id));
	$catelist = pdo_fetchall("SELECT * FROM ". tablename($this->table_task_cate)  . " WHERE weid = :weid", array(':weid'=>$weid));
	
    if (checksubmit()) {
        $data = array(
			'id' => $id,
            'nickname' => trim($_GPC['nickname']),
            'username' => trim($_GPC['username']),
            'mobile' => trim($_GPC['mobile']),
            'cateid' => trim($_GPC['cateid']),
            'status' => trim($_GPC['status']),
            'legalize' => trim($_GPC['legalize']),
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
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    pdo_query("UPDATE " . tablename($this->table_fans) . " SET status = abs(:status - 1) WHERE id=:id", array(':status' => $status, ':id' => $id));
    message('操作成功！', $this->createWebUrl('fans', array('op' => 'display', 'storeid' => $storeid)), 'success');
}elseif($operation == 'change_points'){
    $id = abs(intval($_GPC['userid']));
    $point = intval($_GPC['point']);
    if($point === 0){
        message('充值金额不能为0', $this->createWebUrl('fans', array('op' => 'display')), 'error');
    }elseif($point>0){
        $title = "增加金额";
    }else{
        $title = "减少金额";
    }
    if($this->changePoints($id, $point, "系统充值-".$title)){
        message('充值成功', $this->createWebUrl('fans', array('op' => 'display')), 'success');
    }else{
        message('充值失败', $this->createWebUrl('fans', array('op' => 'display')), 'error');
    }
}
include $this->template('web/fans');