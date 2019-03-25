<?php
//文章详情

global $_GPC;
$id = $_GPC['id'];
$appId =isset($_GPC['app_id'])?$_GPC['app_id']:$_SESSION['app_id'];
$appInfo =$this->getAppInfo($appId);
$article = pdo_get("gd_article",array("id"=>$id));
$baseConfig = $this->getLang();
$title=$baseConfig['notice_detail'];
$article['content']=htmlspecialchars_decode($article['content']);
//获取菜单
$menus = $this->getWxMenu();
include $this->template('article');