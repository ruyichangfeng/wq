<?php
//员工端登录

global $_GPC,$_W;
$i=$_GPC['i'];
$url=$_W['siteroot']."app/index.php?i=".$i."&c=entry&do=login&m=gd_zlyqk";
$condition['group']=5;
$condition['uniacid']=$_W['uniacid'];
$config = $this->beforeSettingList($condition);
if($this->isAjax){
    $name=$_GPC['name'];
    $password=$_GPC["password"];
    if(empty($name)){
        $this->msg['type']=2;
        $this->msg['msg']="帐号不能为空";
        $this->echoAjax();
    }
    $isMob="/^1[3-8]{1}[0-9]{9}$/";
    if(!preg_match($isMob,$name)){
        $this->msg['type']=2;
        $this->msg['msg']="帐号非法";
        $this->echoAjax();
    }
    if(empty($password)){
        $this->msg['type']=3;
        $this->msg['msg']="密码不能为空";
        $this->echoAjax();
    }
    if(strlen($password)<6){
        $this->msg['type']=3;
        $this->msg['msg']="密码太短了";
        $this->echoAjax();
    }
    //登录验证
    $memberInfo = pdo_get("gd_admin",array("mobile"=>$name));
    if(empty($memberInfo)){
        $this->msg['msg']="帐号未注册";
        $this->echoAjax();
    }
    if($memberInfo['password']!=$password){
        $this->msg['type']=3;
        $this->msg['msg']="密码错误";
        $this->echoAjax();
    }
    $isLogin = $this->_login($memberInfo['mobile'],$memberInfo['password']);
    if(empty($isLogin)){
        $this->msg['msg']="登录失败";
        $this->echoAjax();
    }
    $this->msg['type']=1;
    $this->msg['code']=1;
    $this->msg['msg']="登录成功";
    $this->msg['data']="/web/index.php?c=site&a=entry&do=menus&m=gd_zlyqk";
    $this->echoAjax();
}
include $this->template("login");