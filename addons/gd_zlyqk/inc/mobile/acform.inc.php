<?php
//操作表单获取

global $_GPC;

$payMoney=0;
$this->selectApps();
$nodeId =$_GPC['node_id'];
$lineId=$_GPC['line_id'];
$recorderId = $_GPC['rd'];
$isAdmin=$adminInfo = $this->isAdmin();

//配置设置
$baseConfig =$this->getLang();
$title = $subTitle="提交数据";
$nodeInfo=$this->getNodeInfo($nodeId);
$appId = isset($_GPC['app'])?intval($_GPC['app']):$_SESSION['app_id'];
$appInfo = $this->getAppInfo($appId);
$appInfo['cover']=strstr($appInfo['cover'],"http")?$appInfo['cover']:(empty($appInfo['cover'])?"":"/".$appInfo['cover']);
$memberInfo =$this->getMemberInfo();

$them = json_decode($appInfo['them'],true);

//获取上一个节点
$poolInfo=pdo_get("gd_pool",array("app_id"=>$appId,"recorder_id"=>$recorderId));
if(empty($poolInfo)){
    message("数据未找到",$this->createMobileUrl('member'),'info');
}
if(!empty($poolInfo['before_node'])){
    $lineInfo="";
    if(!empty($poolInfo['before_line'])){
        $lineInfo = pdo_get("gd_preline",array("line_id"=>$poolInfo['before_line'],'flow_id'=>$appInfo['flow_id']));
    }
    if(empty($lineInfo)){
        $lineInfo = $this->getNodeInfo($poolInfo['before_node']);
    }
    $formList=json_decode($lineInfo['form_list'],true);
    //查找支付字段
    foreach($formList as $key=>$vl){
        if($vl['type']=="price"){
            $colName = $vl['py'];
        }
    }
    //上一节点存在报价
    if(isset($colName)){
        //获取上一节点的报价金额
        $where['app_id']=$appInfo['id'];
        $where['node_id']=$poolInfo['before_node'];
        $where['recorder_id']=$recorderId;
        $preInfo=pdo_get("gd_deal",$where);
        if(!empty($preInfo)){
            $inInfo = json_decode($preInfo['deal_msg'],true);
            if(isset($inInfo[$colName])){
                $payMoney=$inInfo[$colName];
            }
        }
    }
}
//获取菜单
$menus = $this->getWxMenu();
$jsSign=$this->getSignPackage();
$html = $this->createFrom($memberInfo,$adminInfo,$nodeInfo['flow_id'],$nodeInfo['node_id'],$recorderId,$appId,$lineId,$nodeInfo,$payMoney);
include $this->template("ac_form");