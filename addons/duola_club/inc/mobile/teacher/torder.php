<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];
$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where openid = :openid And tid > 0 ", array(':openid' => $openid));
$it['tid'] = 10;
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
if(!empty($it)){
    if($op == 'jiesuan'){
       if(empty($_GPC['orderId'])){
            message('非法操作!');
       }
        $torderIds = explode(',',$_GPC['orderId']);
        foreach($torderIds as $torderId){
            //查询订单
            $torder = pdo_fetch("SELECT * FROM " . tablename($this->table_torder) . " where :schoolid = schoolid And :weid = weid And id = {$torderId} And orderStatus = '1' ", array(
                ':weid' => $weid,
                ':schoolid' => $schoolid
            ));
            if(!empty($torder)){
                //更新教师端订单
                pdo_update($this->table_torder,array('orderStatus' => 2),array('id' => $torderId));
                //更新家长订单
                pdo_update($this->table_order,array('status' => 2),array('id' => $torder['orderId']));
            }

        }
        die(json_encode(
            array(
                'result' => true,
                'msg'    => '支付成功!'
            )
        ));

    }else{
        $rest = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_torder)." WHERE tid = {$it['tid']} And orderStatus = '1'  and weid = {$weid} and schoolid={$schoolid}");

        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['tid']));

        $listData = pdo_fetchall("SELECT * FROM " . tablename($this->table_torder) . " where :schoolid = schoolid And :weid = weid And  tid = {$it['tid']} And orderStatus = '1' ORDER BY createDate DESC", array(
            ':weid' => $weid,
            ':schoolid' => $schoolid
        ));
        $list = array();
        $totalCost = 0;
        foreach($listData as $key => $row){
            $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And id = '{$row['orderId']}'  ORDER BY createtime DESC", array(
                ':weid' => $weid,
                ':schoolid' => $schoolid
            ));
            $kc = pdo_fetch("SELECT * FROM ".tablename($this->table_tcourse)." WHERE id = '{$order['kcid']}'");//课程
            //获取下单人信息
            $orderOwner = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0  Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $row['orderOwnerOpenid']), 'id');
            $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $orderOwner['uid'], ':uniacid' => $weid));
            $row['userImg']  = $mcInfo['avatar'];
            $row['nickname'] = $mcInfo['nickname'];
            $row['kc'] = $kc;
            $row['order'] = $order;
            $list[] = $row;
            $totalCost += $order['cose'];
        }
        include $this->template(''.$school['style3'].'/torder');
    }
}else{
    $bdTeacher = true;
    include $this->template('bangding');
}
?>