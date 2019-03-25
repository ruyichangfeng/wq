<?php

global $_W,$_GPC;
$this->initUser();
$appId=isset($_GPC['app_id'])?$_GPC['app_id']:$_SESSION['app_id'];
$appInfo =$this->getAppInfo($appId);
$submit = $this->getMenus();
$baseConfig =$this->getLang();
$title=$baseConfig['wx_info'];
$memberInfo =$this->getMemberInfo();
//获取组列表
$groupList=$this->getLabelList();
//应以列表
$appList = $this->getAppList();
$config = $this->beforeSettingList(array("group"=>8));        //获取配置参数

//获取注册需要的额外表单
$needStep=false;
$sortList="";
if(isset($config['ext_member']) && $config['ext_member']==1){
    if(isset($config['member_step']) && $config['member_step']==0){
        $extInfo =$this->parseRegisterInfo();
        //获取扩转数据列
        $dotList = pdo_getall("gd_member_ext",array("uniacid"=>$_W['uniacid']));
        foreach($dotList as $val){
            $sortList .=empty($sortList)?$val['sort']:",".$val['sort'];
        }
    }else{
        $needStep=true;
        $stepList = pdo_fetchall("select * from ".tablename("gd_member_ext")." where uniacid={$_W['uniacid']} order by sort asc ");
    }
}
$_url="";
if(!empty($_GPC['_url'])){
    $_url = base64_decode($_GPC['_url']);
}
$jsSign=$this->getSignPackage();
//获取菜单
$menus = $this->getWxMenu();
include $this->template("member_info");