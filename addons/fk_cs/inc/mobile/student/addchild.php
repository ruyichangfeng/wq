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

//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$signset = unserialize($school['signset']);
$parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND schoolid = :schoolid And openid=:openid", array(':weid' => $weid, ':schoolid' => $schoolid,':openid' => $openid));
if(!empty($parents['area_addr_location'])){
    $parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
}
include $this->template(''.$school['style2'].'/addchild');
?>