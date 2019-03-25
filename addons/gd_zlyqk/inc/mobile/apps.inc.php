<?php
//运用中心

$this->selectApps();
$title="表单中心";
$appInfo =$this->getAppInfo($_SESSION['app_id']);
$menu = $this->getMenus(false);
$appList =$this->getAppList();
include $this->template("apps");