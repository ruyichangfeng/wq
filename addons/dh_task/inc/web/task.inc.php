<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'task';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    if (!empty($_GPC['keyword']) && !empty($_GPC['colname'])) {
        $colname = trim($_GPC['colname']);
        $condition .= " AND t.{$colname} LIKE '%{$_GPC['keyword']}%'";
    }
    if (!empty($_GPC['nav_id'])) {
        $condition .= " AND t.nav_id={$_GPC['nav_id']} ";
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $tasklist = pdo_fetchall("SELECT t.*,c.title as catetitle,n.title as navtitle FROM " . tablename($this->table_task) . " AS t LEFT JOIN " . tablename($this->table_task_cate) . " AS c ON t.cateid=c.id LEFT JOIN ". tablename($this->table_task_nav) . " AS n ON t.nav_id=n.id WHERE t.weid = :weid {$condition} ORDER BY t.id DESC " . $limit, array(':weid' => $weid));
    
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_task) . " AS t WHERE t.weid = :weid {$condition} ", array(':weid' => $weid));
    $pager = pagination($total, $pindex, $psize);
    $navlist = pdo_fetchall("SELECT id,title FROM " . tablename($this->table_task_nav)  . " WHERE weid = :weid", array(':weid'=>$weid));

} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_task) . " WHERE id = :id", array(':id' => $id));
    
    if (checksubmit()) {
        $data = array(
            'weid' => $weid,
            'task_type' => trim($_GPC['task_type']),
            'where_type' => trim($_GPC['where_type']),
            'where_con' => trim($_GPC['where_con']),
            'task_points' => intval($_GPC['task_points']),
            'task_exp' => intval($_GPC['task_exp']),
            'user_receive' => intval($_GPC['user_receive']),
            'task_receive' => intval($_GPC['task_receive']),
            'task_title' => trim($_GPC['task_title']),
            'task_desc' => trim($_GPC['task_desc']),
            'task_image' => trim($_GPC['task_image']),
            'task_content' => htmlspecialchars($_GPC['task_content']),
            'hide_content' => htmlspecialchars($_GPC['hide_content']),
            'starttime' => strtotime(trim($_GPC['starttime'])),
            'endtime' => strtotime(trim($_GPC['endtime'])),
            'task_do_time' => trim($_GPC['task_do_time']),
            'review_userid' => intval($_GPC['agentid']),
            'is_review' => intval($_GPC['is_review']),
            'is_open' => intval($_GPC['is_open']),
            'cateid' => intval($_GPC['cateid']),
            'fieldset_id' => intval($_GPC['fieldset_id']),
            'auto_review' => intval($_GPC['auto_review']),
            'user_level' => intval($_GPC['user_level']),
            'nav_id' => intval($_GPC['nav_id']),
            'is_top' => intval($_GPC['is_top']),
            'sorting' => intval($_GPC['sorting'])
        );
        if (empty($id)) {
            $data['task_time'] = TIMESTAMP;
        }
        if (empty($item)) {
            pdo_insert($this->table_task, $data);
        } else {
            pdo_update($this->table_task, $data, array('id' => $id, 'weid' => $weid));
        }
        message('操作成功！', $this->createWebUrl('task', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
    $admins = pdo_fetchall("SELECT id,username,nickname FROM " . tablename($this->table_fans)  . " WHERE weid = :weid", array(':weid'=>$weid));
    $categorys = pdo_fetchall("SELECT * FROM " . tablename($this->table_task_cate)  . " WHERE weid = :weid", array(':weid'=>$weid));
    $filedset = pdo_fetchall("SELECT * FROM " . tablename($this->table_fieldset) . "WHERE weid = :weid ORDER BY `id` DESC",array(':weid'=>$_W['uniacid']));
    $navlist = pdo_fetchall("SELECT id,title FROM " . tablename($this->table_task_nav)  . " WHERE weid = :weid", array(':weid'=>$weid));
    $review_user = pdo_fetch("SELECT id,username,nickname,headimgurl FROM " . tablename($this->table_fans)  . " WHERE weid = :weid AND id=:id", array(':weid'=>$weid,":id"=>$item['review_userid']));
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_task) . " WHERE id = :id AND weid=:weid", array(':id' => $id, ':weid' => $weid));
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('task', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_task, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('task', array('op' => 'display', 'storeid' => $storeid)), 'success');
} else if ($operation == 'setstatus') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status'])?1:0;
    pdo_query("UPDATE " . tablename($this->table_task) . " SET status = :status WHERE id=:id", array(':status' => $status, ':id' => $id));

    message('操作成功！', $this->createWebUrl('task', array('op' => 'display'), 'success'));
}
include $this->template('web/task');