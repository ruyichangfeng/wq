<?php
//选择部门

global $_GPC,$_W;
$id =$_GPC['id'];
$func = isset($_GPC['func'])?$_GPC['func']:"";
$gp = isset($_GPC['gp'])?$_GPC['gp']:"";
//获取节点信息
$nodeInfo =pdo_get("gd_node",array("id"=>$id));
$dpList = json_decode($nodeInfo['who_list'],true);
$nDpList =array();
foreach($dpList as $val){
    $nDpList[$val]=$val;
}
$dpList = $this->getDepartment();
include $this->template("select_dp");