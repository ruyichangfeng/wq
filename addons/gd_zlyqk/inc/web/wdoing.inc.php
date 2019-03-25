<?php
//处理流程

global $_W,$_GPC;
$payMoney=0;
$id =$_GPC['id'];
$poolInfo = pdo_get("gd_pool",array("id"=>$id));
$recorderId =$poolInfo['recorder_id'];
$table=str_replace($this->getTablePre(),"",$poolInfo['table']);
$recorderInfo = pdo_get($table,array("id"=>$recorderId));

$nodeId =$recorderInfo['node_id'];
$appId=$poolInfo['app_id'];
$lineId =isset($_GPC['line_id'])?$_GPC['line_id']:"";
$statusId = $poolInfo['node_status'];
$statusName=$poolInfo['node_name_status'];

$nodeInfo=$this->getNodeInfo($nodeId);
$appInfo = $this->getAppInfo($poolInfo['app_id']);
$nodeList=$this->getNodeList($appInfo['flow_id']);

if(!empty($appInfo['flow_id'])){
    $flowInfo = $this->getFlowInfo($appInfo['flow_id']);
    $lines = json_decode($flowInfo['line'],true);
    $tasks = json_decode($flowInfo['task'],true);
    if(!isset($tasks[$nodeInfo['xml_id']])){
        message("节点信息不完善",$this->createMobileUrl('index'),'info');
    }
    $task = $tasks[$nodeInfo['xml_id']];
    if(empty($task['outgoing'])){
        message("请添加节点状态线",$this->createMobileUrl('index'),'info');
    }
    $this->parseNode($task['outgoing'],$tasks,$lines,$nodeId);
    $nodeStatus =$this->statusLine;
}
$html = $this->__createFrom($nodeInfo['flow_id'],$nodeInfo['node_id'],$recorderId,$appInfo['id'],$lineId,$nodeInfo,$payMoney);
include $this->template("web_form");