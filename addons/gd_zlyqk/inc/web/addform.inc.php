<?php
//设计表单
global $_W,$_GPC;
//配置参数
$appId=$_GPC['id'];
$postUrl =$this->createWebUrl("createFm",array("app_id"=>$appId));

//获取表单元素
$extCols = $this->extList();
$eleList=$this->getElement();
$baseConfig =$this->getLang();
include $this->template("design_form");