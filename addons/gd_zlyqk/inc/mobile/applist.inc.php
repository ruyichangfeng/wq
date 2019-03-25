<?php
global $_W;
$this->selectApps();
$ads =pdo_fetchall("select * from ".tablename("gd_ad")." where uniacid={$_W['uniacid']} and status=1 order by sorter desc");
//获取默认文章
$notice = pdo_get("gd_article",array("uniacid"=>$_W['uniacid'],'is_default'=>1));
//获取分类
$categorys =pdo_fetchall("select * from ".tablename("gd_mu")." where uniacid={$_W['uniacid']} and status=1 order by sorter desc");
//获取应用
$isAdmin = $this->isAdmin();
if($isAdmin && $isAdmin['department']>0){
    $lk =$isAdmin['department'].',';
    $where = " and ( priv=0 or priv like '%$lk%' ) ";
}else {
    $where = " and priv =0 ";
}
$where .= " and icon!='' ";
$appList = pdo_fetchall("select * from ".tablename('gd_app')." where status=1 and uniacid={$_W['uniacid']} and  is_show=1  $where order by sorter desc ");
foreach($appList as $key=>$val){
    $appList[$key]['icon']=strstr($val['icon'],"http")?$val['icon']:"/".$val['icon'];
}
//获取菜单
$menus = $this->getWxMenu();
$baseConfig =$this->getLang();
$title=empty($baseConfig['wx_index'])?"首页":$baseConfig['wx_index'];
include $this->template("app_index");