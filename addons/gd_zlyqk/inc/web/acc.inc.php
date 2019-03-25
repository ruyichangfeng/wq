<?php
//页面授权管理

global $_GPC;
$accList= $this->getAccArr();
if($this->isAjax){
    $accArr=array();
    foreach($accList as $key=>$val){
        $accArr[$key]=0;
        foreach($val as $ky=>$vl){
            if($ky!="name"){
                $accArr[$ky]=0;
                foreach($vl as $k=>$v){
                    if($k!="name"){
                        $accArr[$ky."-".$k]=0;
                    }
                }
            }

        }
    }
    //匹配权限是否已经
    $groupId=$_GPC['group_id'];
    $acc=$_GPC['in'];
    foreach($acc as $key=>$val){
        if(isset($accArr[$key])){
            $accArr[$key]=1;
        }
    }
    if(pdo_update("gd_acc",array("acc"=>json_encode($accArr)),array("id"=>$groupId))){
        $this->msg['code']=1;
        $this->msg['msg']="权限修改成功";
        $this->echoAjax();
    }
    $this->msg['msg']="权限修改失败";
    $this->echoAjax();
}
$groupId =$_GPC['id'];
$accInfo = pdo_get("gd_acc",array("id"=>$groupId));
$accLs=empty($accInfo['acc'])?array():json_decode($accInfo['acc'],true);
include $this->template("acc");