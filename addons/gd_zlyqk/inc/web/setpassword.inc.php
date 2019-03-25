<?php

global $_GPC;
if($this->isAjax){
    $password =$_GPC['password'];
    if(empty($password)|| strlen($password)<6){
        $this->msg['msg']="密码不合法";
        $this->echoAjax();
    }
    $adminId =$_GPC['m_id'];
    if(pdo_update("gd_admin",array("password"=>$password),array("id"=>$adminId))){
        $this->msg['code']=1;
        $this->msg['msg']="修改密码成功";
        $this->echoAjax();
    }
    $this->msg['msg']="修改密码失败";
    $this->echoAjax();
}
//处理数据
$mid =$_GPC['m_id'];
$adminInfo = pdo_get("gd_admin",array("id"=>$mid));
include $this->template("password");