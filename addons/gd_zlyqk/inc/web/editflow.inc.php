<?php
//编辑流程

global $_GPC,$_W;
$sep = isset($_GPC['sep'])?$_GPC['sep']:0;
//获取流信息
$flowInfo = pdo_get("gd_flow",array("id"=>$_GPC['id']));
//获取节点
$nodeList = $this->getNodeList($_GPC['id']);

$nodeId =$_GPC['node'];
if(empty($nodeId)){
    $nodeId =  isset($nodeList[0]['id'])?$nodeList[0]['id']:0;
}
$nodeInfo = pdo_get("gd_node",array("id"=>$nodeId));
$admin=json_decode($nodeInfo['who_list'],true);

$statusArr=json_decode($nodeInfo['status_list'],true);
$dpList=array();
foreach($admin as $val){
    $adminInfo = pdo_get("gd_department",array("id"=>$val));
    $dpList[]=$adminInfo;
}
$formArr=json_decode($nodeInfo['form_list'],true);

//配置参数
$where['group']=4;
$where['uniacid']=$_W['uniacid'];
$config=$this->beforeSettingList($where);
if(empty($config['max_status'])){
    $config['max_status']=4;
}
if(empty($config['max_form'])){
    $config['max_form']=8;
}
for($i=0;$i<$config['max_status'];$i++){
    $statusList[]=$i;
}
for($i=0;$i<$config['max_form'];$i++){
    $formList[]=$i;
}
//获取表单元素
$eleList=$this->getElement();
include $this->template("flow_add");