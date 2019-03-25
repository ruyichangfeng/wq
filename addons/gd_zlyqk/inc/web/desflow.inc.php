<?php
//设计流程

global $_GPC;
$id=$_GPC['id'];
$xmlInfo = pdo_get("gd_xml",array("flow_id"=>$id,'is_delete'=>0));
$xml =empty($xmlInfo)?"":$xmlInfo['xml'];
if($xml){
    $order=array("\r\n","\n","\r");
    $xml = str_replace($order, '', $xml);
}
//获取已有配置
$confList=pdo_getall("gd_prenode",array("flow_id"=>$id));
include $this->template("des_flow");