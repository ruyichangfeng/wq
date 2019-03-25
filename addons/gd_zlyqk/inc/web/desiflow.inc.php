<?php
//保存节点信息

global $_GPC,$_W;

$flowId =$_GPC['flow_id'];
$sXml=$xml = htmlspecialchars_decode($_GPC['xml']);
$xml = simplexml_load_string($xml);
$arrXml=json_decode(json_encode($xml),true);
$process = isset($arrXml['process']) ?$arrXml['process']:array();

//开始节点
$startEvent=isset($process['startEvent'])?$process['startEvent']:array();
if(empty($startEvent)){
    $this->msg['msg']="请添加开始节点";
    $this->echoAjax();
}
$newStart=array();
$item=$startEvent['@attributes'];
$newStart['id']=$item['id'];
$newStart['name']=isset($item['name'])?$item['name']:"";
$newStart['outgoing']=$startEvent['outgoing'];
$startEvent=$newStart;
$this->updateNodeInfo($startEvent,$flowId,1);

//结束节点
$endEvent =isset($process['endEvent'])?$process['endEvent']:array();
if(empty($endEvent)){
    $this->msg['msg']="请添加结束节点";
    $this->echoAjax();
}
$newEnd=array();
$item=$endEvent['@attributes'];
$newEnd['id']=$item['id'];
$newEnd['name']=isset($item['name'])?$item['name']:"";
$newEnd['incoming']=$endEvent['incoming'];
$endEvent=$newEnd;
$this->updateNodeInfo($endEvent,$flowId,0);

//任务节点
$taskEvent=isset($process['task'])?$process['task']:array();
if(empty($taskEvent)){
    $this->msg['msg']="请添任务节点";
    $this->echoAjax();
}
$newTask=array();
if(isset($taskEvent['@attributes'])){
    $item=$taskEvent['@attributes'];
    $info['id']=$item['id'];
    $info['name']=isset($item['name'])?$item['name']:"";
    $info['default']=isset($item['default'])?$item['default']:"";
    $info['incoming']=$taskEvent['incoming'];
    $info['outgoing']=$taskEvent['outgoing'];
    $newTask[$item['id']]=$info;
}else{
    foreach($taskEvent as $key=>$val){
        $item=$val['@attributes'];
        $info['id']=$item['id'];
        $info['name']=isset($item['name'])?$item['name']:"";
        $info['default']=isset($item['default'])?$item['default']:"";
        $info['incoming']=$val['incoming'];
        $info['outgoing']=$val['outgoing'];
        $newTask[$item['id']]=$info;
    }
}
$taskEvent =$newTask;
foreach($taskEvent as $task){
    $this->updateNodeInfo($task,$flowId,2);
}

//条件节点
$info=array();
$branchEvent=isset($process['exclusiveGateway'])?$process['exclusiveGateway']:array();
$newBranch =array();
if(isset($branchEvent['@attributes'])){
    $item=$branchEvent['@attributes'];
    $info['id']=$item['id'];
    $info['default']=isset($item['default'])?$item['default']:"";
    $info['incoming']=$branchEvent['incoming'];
    $info['outgoing']=$branchEvent['outgoing'];
    $newBranch[$item['id']]=$info;
}else{
    foreach($branchEvent as $val){
        $item=$val['@attributes'];
        $info['id']=$item['id'];
        $info['default']=isset($item['default'])?$item['default']:"";
        $info['incoming']=$val['incoming'];
        $info['outgoing']=$val['outgoing'];
        $newBranch[$item['id']]=$info;
    }
}
$branchEvent = $newBranch;
foreach($branchEvent as $branch){
    $this->updateNodeInfo($branch,$flowId,3);
}

//线条节点
$lineEvent=isset($process['sequenceFlow'])?$process['sequenceFlow']:array();
if(empty($lineEvent)){
    $this->msg['msg']="流程里没连接线";
    $this->echoAjax();
}
$newLine=array();
foreach($lineEvent as $key=>$val){
    $item = $val['@attributes'];
    $info ['id']=$item['id'];
    $info['name']=isset($item['name'])?$item['name']:"";
    $info['sourceRef']=$item['sourceRef'];
    $info['targetRef']=$item['targetRef'];
    $newLine[$item['id']]=$info;
}

$lineEvent=$newLine;
//节点列表
$tStart[$startEvent['id']]=$startEvent;
$tStart[$endEvent['id']]=$endEvent;
$taskList=array_merge($tStart,$tStart,$taskEvent,$branchEvent);
pdo_update("gd_flow",array("line"=>json_encode($lineEvent),'task'=>json_encode($taskList)),array("id"=>$flowId));

//保存xml文件
$xmlInfo = pdo_get("gd_xml",array("flow_id"=>$flowId,'is_delete'=>0));
if(empty($xmlInfo)){
    $xml =array();
    $xml['uniacid']=$_W['uniacid'];
    $xml['flow_id']=$flowId;
    $xml['xml']=$sXml;
    $xml['create_time']=time();
    pdo_insert("gd_xml",$xml);
}else{
    $xmlUp['xml']=$sXml;
    $xmlUp['old_xml']=$xmlInfo['xml'];
    pdo_update("gd_xml",$xmlUp,array("flow_id"=>$flowId));
}
//修改订单状态
$this->msg['code']=1;
$this->msg['msg']="保存成功";
$this->echoAjax();