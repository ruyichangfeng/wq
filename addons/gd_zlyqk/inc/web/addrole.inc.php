<?php
//添加据色

global $_GPC,$_W;
$id =$_GPC['id'];
$role =$_GPC['role'];
$adminList =$_GPC['admin'];
$result = pdo_update("gd_node",array("who"=>$role,'who_list'=>json_encode($adminList)),array("id"=>$id));
if($result){
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    $this->echoAjax();
}
$this->msg['msg']="保存失败";
$this->echoAjax();