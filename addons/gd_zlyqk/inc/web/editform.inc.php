<?php
//编辑表单

global $_W,$_GPC;
//配置参数
$appId=$_GPC['id'];
//获取原始配置参数
$extCols = $this->extList();
$tableCnf=pdo_get('gd_source_form',array("app_id"=>$appId));
$formArr = json_decode($tableCnf['source'],true);
foreach($formArr as $key=>$val){
    if($val['type']=='select' || $val['type']=='radio'  || $val['type']=='checkbox' || $val['type']=='radio_zh'){
        $formArr[$key]['pl']=explode(",",$val['pl']);
    }
}
$postUrl = $this->createWebUrl("editFm",array("app_id"=>$appId));
$baseConfig =$this->getLang();
//获取表单元素
$eleList=$this->getElement();
include $this->template("design_form");