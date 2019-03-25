<?php
//消息详情查看

global $_GPC;
$id =$_GPC['id'];
$appId=$_GPC['app_id'];

//获取配置文件
$cWhere['group']=3;
$setting = $this->beforeSettingList($cWhere);

$appInfo = $this->getAppInfo($appId);
$flowInfo = $this->getFlowInfo($appInfo['flow_id']);

$tableName=str_replace($this->getTablePre(),"",$appInfo['table']);
$msgList=pdo_getall($tableName,array('id'=>$id));
if(!isset($msgList[0])){
    $this->wMessage("信息没找到");
}
$property =$this->getProperty(true);
foreach($msgList as $key=>$val){
    $poolInfo = pdo_get("gd_pool",array("recorder_id"=>$val['id'],'table'=>$appInfo['table']));
    $gdSn=$poolInfo['gd_sn'];
    $msgList[$key]['pool_id']=$poolInfo['id'];
    $msgList[$key]['need_pay']=$poolInfo['need_pay'];
    $msgList[$key]['is_remark']=$poolInfo['is_mark'];
    $msgList[$key]['mark_admin']=$poolInfo['mark_admin'];
    $msgList[$key]['is_abort']=$poolInfo['is_abort'];
    $msgList[$key]['who']=$poolInfo['who'];
    $prop=isset($property[$poolInfo['property']])?"(".$property[$poolInfo['property']].")":"";
    $poolId=$poolInfo['id'];
}
$formList =$this->parseForm($msgList,$appInfo);

foreach($formList as $key=>$val){
    $$key=$val;
}

$nodeId = $msgList[0]['node_id'];
//获取处理记录
$notice=array();
$noticeList = pdo_getall("gd_deal",array("recorder_id"=>$id,'from'=>0,'app_id'=>$appId));
$acMsg = $this->parseAcForm($noticeList,$nodeId);
foreach($acMsg as $key=>$val){
    $$key=$val;
}
//当前的记录的处理状态
$recorder=isset($msgList[0])?$msgList[0]:0;
$nodeInfo = $this->getNodeInfo($recorder['node_id']);
include $this->template("recorder_add");