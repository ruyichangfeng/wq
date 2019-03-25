<?php

global $_GPC,$_W;
$flowId=$_GPC['flow_id'];
$nodeId=$_GPC['id'];
//获取节点信息
$dpList=array();
$preInfo = pdo_get("gd_prenode",array("flow_id"=>$flowId,'node_sid'=>$nodeId));
if(!empty($preInfo)){
    $dpList = json_decode($preInfo['who_list'],true);
}
$nDpList =array();
foreach($dpList as $val){
    $nDpList[$val]=$val;
}
$dpList = $this->getDepartment();
include $this->template("select_dp");