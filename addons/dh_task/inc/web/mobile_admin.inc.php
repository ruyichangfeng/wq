<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'mobile_admin';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $list = pdo_fetchall("SELECT ma.*,f.username,f.nickname FROM ". tablename($this->table_mobile_admin)  . " AS ma LEFT JOIN ". tablename($this->table_fans) . " AS f ON ma.fans_id = f.id WHERE ma.weid = :weid" . $limit, array(':weid'=>$weid));
    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_mobile_admin) . " AS ma LEFT JOIN ". tablename($this->table_fans) . " AS f ON ma.fans_id = f.id WHERE ma.weid = :weid", array(':weid' => $weid));
    $pager = pagination($total, $pindex, $psize);
} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit()){
        $data = array(
            'weid' => $weid,
            'fans_id' => intval($_GPC['fans_id']),
            'opera_auth' => !empty($_GPC['opera_auth'])?implode($_GPC['opera_auth'],","):"",
            'label_auth' => !empty($_GPC['label_auth'])?implode($_GPC['label_auth'],","):"",
            'task_scope' => intval($_GPC['task_scope']),
            'status' => intval($_GPC['status'])
        );
        $info = $info = pdo_fetch("SELECT * FROM ". tablename($this->table_mobile_admin)  . " WHERE weid = :weid AND fans_id=:fans_id", array(':weid'=>$weid,':fans_id'=>$data['fans_id']));
        if(($info && empty($id)) || ($info && !empty($id) && $id != $info['id'])){
            message('此会员已经是管理员，请更换！', "", 'error');
        }
        if(!empty($id)){
            pdo_update($this->table_mobile_admin, $data, array('id' => $id));
        }else{
            pdo_insert($this->table_mobile_admin, $data);
        }
        message('操作成功！', $this->createWebUrl('mobile_admin', array('op' => 'display')), 'success');
    }else{
        $catelist = pdo_fetchall("SELECT * FROM ". tablename($this->table_task_cate)  . " WHERE weid = :weid", array(':weid'=>$weid));
        $fanslist = pdo_fetchall("SELECT id,username,nickname FROM " . tablename($this->table_fans) . " WHERE weid = :weid", array(':weid'=>$weid));
        $operalist = array(array('id'=>1,'title'=>"任务管理"),array('id'=>2,'title'=>"任务审核"));
        if(!empty($id)){
            $info = pdo_fetch("SELECT * FROM ". tablename($this->table_mobile_admin)  . " WHERE weid = :weid AND id=:id", array(':weid'=>$weid,':id'=>$id));
            $info['opera_auth'] = explode(",", $info['opera_auth']);
            foreach ($operalist as $k1 => $v1) {
                $operalist[$k1]['checked'] = 0;
                foreach ($info['opera_auth'] as $k2 => $v2) {
                    if($v2 == $v1['id']){
                        $operalist[$k1]['checked'] = 1;
                        break;
                    }
                }
            }

            $info['label_auth'] = explode( ",", $info['label_auth']);
            foreach ($catelist as $k1 => $v1) {
                $catelist[$k1]['checked'] = 0;
                foreach ($info['label_auth'] as $k2 => $v2) {
                    if($v2 == $v1['id']){
                        $catelist[$k1]['checked'] = 1;
                        break;
                    }
                }
            }
        }
        
    }
}else if($operation == 'setstatus'){
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    pdo_query("UPDATE " . tablename($this->table_mobile_admin) . " SET status = abs(:status - 1) WHERE id=:id", array(':status' => $status, ':id' => $id));
    message('操作成功！', $this->createWebUrl('mobile_admin', array('op' => 'display')), 'success');
}
include $this->template('web/mobile_admin');