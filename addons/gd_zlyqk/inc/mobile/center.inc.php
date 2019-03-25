<?php
//消息中心,员工处理的消息

global $_GPC,$_W;
$type="center";
if(empty($_GPC['id'])){
    $_GPC['id']=0;
}
$this->selectApps();
$do=isset($_GPC['do'])?$_GPC['do']:"index";
$baseConfig =$this->getLang();
$title=$subTitle=$baseConfig['msg_center'];
$isAdmin = $this->isAdmin();
if(empty($isAdmin)){
    $memberUrl=$this->createMobileUrl("category",array("id"=>$_GPC['id']));
    header("location:$memberUrl");
}

$menu =$this->getMenus(false);
//获取运用状态
$appInfo = $this->getAppInfo($_SESSION['app_id']);
$nodeList =$this->getNodeList($appInfo['flow_id']);
$mnLen=count($nodeList)+1;
$mnLen = ($mnLen<4)?(100/4):(100/$mnLen);

//获取配置文件
$cWhere['group']=3;
$setting = $this->beforeSettingList($cWhere);
$memberInfo =$this->getMemberInfo();

//获取消息列表
$group='"'.$isAdmin['department'].'"';
if($_GPC['id']==0){
    $sql=" select DISTINCT rtb.id,rtb.* from ".$appInfo['table']." as rtb left join ".tablename("gd_deal")." as dtb on rtb.id=dtb.recorder_id where dtb.member_id={$memberInfo['id']} or rtb.next_act like '%{$group}%' order by rtb.id desc ";
}else{
    $sql=" select DISTINCT rtb.id,rtb.* from ".$appInfo['table']." as rtb left join ".tablename("gd_deal")." as dtb on rtb.id=dtb.recorder_id where (dtb.member_id={$memberInfo['id']} and dtb.node_id={$_GPC['id']}) or (rtb.next_act like '%{$group}%' and rtb.node_id={$_GPC['id']})  order by rtb.id desc ";
}
$msgList = pdo_fetchall($sql);
$formList =$this->parseForm($msgList,$appInfo);
foreach($formList as $key=>$val){
    $$key=$val;
}
//获取菜单
$menus = $this->getWxMenu();
$jsSign=$this->getSignPackage();
include $this->template("center");