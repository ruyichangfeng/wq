<?php

global $_W;
$appId =isset($_GPC['app_id'])?$_GPC['app_id']:$_SESSION['app_id'];
$appInfo =$this->getAppInfo($appId);
$submit = $this->getMenus(false);
$baseConfig = $this->getLang();
$title=$baseConfig['notice_list'];
//获取文章列表
$isAdmin =$this->isAdmin();
if($isAdmin){
    $where = " where (is_admin=0 or is_admin=2) and status=1 and uniacid={$_W['uniacid']} ";
}else{
    $where = " where (is_admin=0 or is_admin=1) and status=1 and uniacid={$_W['uniacid']} ";
}
$sql =" select id,`title` ,`public` ,`from`,`desc`,`is_default`,`icon`,create_time,gone_time from ".tablename("gd_article").$where." order by id desc ";
$articles=pdo_fetchall($sql);
$default =array();
foreach($articles as $key=>$article){
    if($article['is_default']){
        $default =$article;
        unset($articles[$key]);
    }
}
//获取菜单
$menus = $this->getWxMenu();
include $this->template('articles');