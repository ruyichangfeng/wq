<?php

//添加用户

global $_GPC,$_W;
$name =$_GPC['name'];
$mobile =$_GPC['mobile'];
$result =pdo_get("gd_member",array("name"=>$name,'mobile'=>$mobile));
//如果不为空
if(!empty($result)){
    $this->msg['msg']="客户已经存在";
    $this->echoAjax();
}
$insert['uniacid']=$_W['uniacid'];
$insert['name']=$name;
$insert['mobile']=$mobile;
$insert['uid']=0;
$insert['open_id']="";
$insert['app_id']=0;
$insert['create_time']=time();
$insert['status']=1;
$insert['is_register']=0;
$ret=pdo_insert("gd_member",$insert);
$memberId =pdo_insertid();
if($ret){
    $this->msg['data']=$memberId;
    $this->msg['msg']="添加成功";
    $this->msg['code']=1;
    $this->echoAjax();
}
$this->msg['msg']="添加失败";
$this->echoAjax();