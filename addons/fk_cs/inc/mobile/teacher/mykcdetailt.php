<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W ['uniacid'];
$openid = $_W['openid'];
$id = intval($_GPC['id']);
$schoolid = intval($_GPC['schoolid']);
$item = pdo_fetch("SELECT * FROM " . tablename($this->table_kcbiao) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $id));
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $item['schoolid']));

$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));

if(!empty($it)){
    //查询流程
    $flow = pdo_fetchall("SELECT * FROM " . tablename($this->table_flow) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} AND flowType = 'flowlist' ORDER BY id ASC, ssort ASC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
    $flows = array();
    $lastFlow = '';
    foreach($flow as $k => $v){
        $checkLog = pdo_fetch("SELECT * FROM " . tablename($this->table_newchecklog) . " where flowid = :flowid And schoolid = :schoolid And weid = :weid And kbid = :kbid", array(':flowid' => $v['id'],':schoolid' => $schoolid,':weid' => $weid,':kbid' => $item['id']));
        $v['isDone']    = false;
        if($checkLog){
            $v['isDone'] = true;
            if($v['nodeType'] == 3){
                $lastFlow = $v;
            }
        }
        $flows[$k] = $v;
    }
    include $this->template(''.$school['style3'].'/mykcdetailt');
}else{
    session_destroy();
    include $this->template('bangding');
}

?>