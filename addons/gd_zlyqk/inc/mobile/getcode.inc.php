<?php
//获取验证马

global $_GPC,$_W;
$mobile = $_GPC['mobile'];
if(empty($mobile) || strlen($mobile)!=11){
    $this->msg['msg']="手机号码不合法";
    $this->echoAjax();
}
//检查验证码是否需要重现发送
$time=time();
$codeList=pdo_fetch("select * from ".tablename("gd_sms")." where mobile=$mobile and end_time>$time ");
if(!empty($codeList)){
    $this->msg['msg']="验证码5分钟有效,无需重复发送";
    $this->echoAjax();
}
//财务列表
if(!$this->sendSm($mobile)){
    $this->msg['msg']="验证码发送失败";
    $this->echoAjax();
}
$this->msg['code']=1;
$this->msg['msg']="发送成功";
$this->echoAjax();