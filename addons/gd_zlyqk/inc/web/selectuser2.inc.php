<?php
//选择处理人员组

global $_GPC,$_W;
$flowId=$_GPC['flow_id'];
$nodeId=$_GPC['node_id'];
//获取记录
$nodeInfo = $preInfo =$this->getReNode($flowId,$nodeId);
$dpSelect=array();
if(!empty($preInfo)){
    $dpSelect=$preInfo['who_list']=json_decode($preInfo['who_list'],true);
}
$dpSelectN=array();
foreach($dpSelect as $val){
    $dpSelectN[$val]=$val;
}
//获取员工列表
$adminList =array();
$uList =$preInfo['adm_list'];
if(!empty($uList)){
    $uList=json_decode($uList,true);
    $uList = implode(",",$uList);
    $adminList =pdo_fetchall("select * from ".tablename("gd_admin")." where id in($uList)");
}
$dpList = $this->getDepartment(true);
include $this->template("select_user2");