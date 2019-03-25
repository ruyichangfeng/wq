<?php

//获取子分类

global $_GPC;
$parentId=$_GPC['parent_id'];
if(empty($parentId)){
    $this->msg['msg']="数据不能为空";
    $this->echoAjax();
}
//获取下级分类
//获取名称
$pInfo = pdo_get("gd_ld",array("id"=>$parentId));
$childList=pdo_getall("gd_ld",array("parent_id"=>$parentId));
$this->msg['code']=1;
$this->msg['msg']="获取成功";
$this->msg['data']=$childList;
$this->msg['name']=$pInfo['name'];
$this->echoAjax();