<?php
//首页
global $_W,$_GPC;
$uniacid=$_W['uniacid'];
$title="首页";
//初始化登录信息
$member = $this->selectApps();
$isIndex=true;

//$member = $this->initUser();
$do=isset($_GPC['do'])?$_GPC['do']:"index";
$isAdmin = $this->isAdmin();
//配置设置
$baseConfig =$this->getLang();
$where['group']=1;
$setting = $this->beforeSettingList($where);

//获取运用表单
$appInfo = $this->getAppInfo($_SESSION['app_id']);
if(!empty($appInfo['cover'])){
    $appInfo['cover']=strstr($appInfo['cover'],"http")?$appInfo['cover']:"/".$appInfo['cover'];
}
$them = json_decode($appInfo['them'],true);
$html=$this->createMobileForm($_SESSION['app_id'],$member,$isAdmin);
$title=$appInfo['name'];
//获取菜单
$menus = $this->getWxMenu();
$jsSign=$this->getSignPackage();
$adminInfo=$this->isAdmin();
if(empty($appInfo['tpl'])){
    include $this->template("index");
}else{
    include $this->template($appInfo['tpl']);
}
