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
if(empty($_GPC['schoolid']) || empty($_GPC['orderId'])){
    message('非法操作!');
}
$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where openid = :openid And tid = 0 ", array(':openid' => $openid));
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
if(!empty($it)){
    $order   = pdo_fetch("SELECT * FROM ".tablename($this->table_order)." WHERE id = {$_GPC['orderId']} And status = '1'");

    $kc = pdo_fetch("SELECT * FROM ".tablename($this->table_tcourse)." WHERE id = '{$order['kcid']}'");//课程

    $teacher = pdo_fetch("SELECT * FROM ".tablename($this->table_teachers)." WHERE id = {$kc['tid']}");

    //查询是否教师定单已经生成
    $torder = pdo_fetch("SELECT * FROM ".tablename($this->table_torder)." WHERE tid = {$kc['tid']} And orderOwnerOpenid = '{$openid}' And orderId = '{$_GPC['orderId']}'");
    if(empty($torder)){
        //教师订单新增数据
        $temp = array(
            'weid'             => $weid,
            'schoolid'         => $schoolid,
            'orderId'          => $_GPC['orderId'],
            'orderOwnerOpenid' => $openid,
            'tid'              => $teacher['id']
        );
        $res = pdo_insert($this->table_torder,$temp);
        if(!$res){
            message('网络异常,请重试!');
        }
    }else{
        if($torder['orderStatus'] == 2){
            message('您已支付过该订单,无需重复支付!');
        }
    }
    include $this->template(''.$school['style2'].'/payorder');
}else{
//			session_destroy();
    include $this->template(''.$school['style2'].'/addchild');
}
?>