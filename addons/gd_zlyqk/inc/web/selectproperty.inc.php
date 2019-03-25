<?php
//选择属性

global $_GPC,$_W;
$id =$_GPC['id'];
//获取节点信息
$appInfo =$this->getAppInfo($id);
$dpList = json_decode($appInfo['property'],true);
$nDpList =array();
foreach($dpList as $val){
    $nDpList[$val]=$val;
}
$dpList = $this->getPropertyList();
include $this->template("select_property");