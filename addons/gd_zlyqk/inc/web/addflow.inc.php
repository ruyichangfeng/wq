<?php
//编辑工作流

global $_GPC,$_W;
if(pdo_get("gd_flow",array("name"=>$_GPC['name'],'uniacid'=>$_W['uniacid']))){
    $this->msg['msg']="流程名已存在";
    $this->echoAjax();
}
//添加
if(empty($_GPC['id'])){
    $insert['name']=$_GPC['name'];
    $insert['uniacid']=$_W['uniacid'];
    $insert['app_id']=0;
    $insert['create_time']=time();
    $insert['status']=1;
    pdo_insert("gd_flow",$insert);
    $this->msg['data']=pdo_insertid();
}else{
    $update['name']=$_GPC['name'];
    pdo_update("gd_flow",$update,array("id"=>$_GPC['id']));
    $this->msg['data']=$_GPC['id'];
}
$this->msg['code']=1;
$this->msg['msg']="保存成功";
$this->echoAjax();