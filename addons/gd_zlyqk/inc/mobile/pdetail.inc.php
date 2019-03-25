<?php

global $_GPC,$_W;
$gdSn="";
$prop="";
$isDetail=true;
$this->selectApps();
$uid=$_W['member']['uid'];
$baseConfig =$this->getLang();
$title=$baseConfig['msg_detail'];

$do=isset($_GPC['do'])?$_GPC['do']:"index";
$jsSign=$this->getSignPackage();
$isAdmin = $this->isAdmin();

//获取管理员
$canFp=0;
$depart=pdo_get("gd_department",array("id"=>$isAdmin['department']));
if(!empty($depart)){
    $acc =pdo_get("gd_acc",array("id"=>$depart['acc_id']));
    if(!empty($acc)){
        $accList=json_decode($acc['acc'],true);
        $canFp = ($accList['wait_plan-sep']==1) ? 1 :0;
    }
}
//获取配置文件
$cWhere['group']=3;
$setting = $this->beforeSettingList($cWhere);

$appId=isset($_GPC['app_id'])?$_GPC['app_id']:$_SESSION['app_id'];
$appInfo = $this->getAppInfo($appId);
$tableName=str_replace($this->getTablePre(),"",$appInfo['table']);
$msgList=pdo_getall($tableName,array('id'=>$_GPC['id']));

$property =$this->getProperty(true);
foreach($msgList as $key=>$val){
    $poolInfo = pdo_get("gd_pool",array("recorder_id"=>$val['id'],'table'=>$appInfo['table']));
    $gdSn=$poolInfo['gd_sn'];
    $msgList[$key]['pool_id']=$poolInfo['id'];
    $msgList[$key]['is_remark']=$poolInfo['is_mark'];
    $msgList[$key]['mark_admin']=$poolInfo['mark_admin'];
    $msgList[$key]['is_abort']=$poolInfo['is_abort'];
    $msgList[$key]['who']=$poolInfo['who'];
    $prop=isset($property[$poolInfo['property']])?"(".$property[$poolInfo['property']].")":"";
    $poolId=$poolInfo['id'];
}
if(!isset($msgList[0])){
    message("信息没找到",$this->createMobileUrl('member'),'info');
}
$formList =$this->parseForm($msgList,$appInfo);
foreach($formList as $key=>$val){
    $$key=$val;
}
$nodeId = $msgList[0]['node_id'];
//获取处理记录
$noticeList = pdo_getall("gd_deal",array("recorder_id"=>$_GPC['id'],'from'=>0,'app_id'=>$appId));
rsort($noticeList);
$acMsg = $this->parseAcForm($noticeList,$nodeId);
foreach($acMsg as $key=>$val){
    $$key=$val;
}
//获取菜单
$menu=$this->getMenus(false);
//当前的记录的处理状态
$recorder=isset($msgList[0])?$msgList[0]:0;
$nodeInfo = $this->getNodeInfo($recorder['node_id']);

//解析操作状态
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
//节点信息
$memberInfo = $this->getMemberInfo();
if($nodeInfo['who']==1){
    //员工处理
    $groupList=json_decode($nodeInfo['who_list'],true);
    $show=in_array($isAdmin['department'],$groupList) ? 1:0;
    $isCancel=($msgList[0]['member_id']==$memberInfo['id'])?1:0;
}else{
    //客人处理
    $isCancel=$show =($msgList[0]['member_id']==$memberInfo['id'])?1:0;
    if($poolInfo['need_pay']==1){
        $show=0;
    }
}
$isCancel = $appInfo['cancel']?$isCancel:0;
//获取菜单
$menus = $this->getWxMenu();
//获取管理员列表
$adminList = $this->getAdminList();
include $this->template("p_detail");