<?php
//添加消息木板

global $_GPC;
$id =$_GPC['id'];
$update['member_msg']=isset($_GPC['member'])?1:0;
$update['admin_msg']=isset($_GPC['admin'])?1:0;
$result = pdo_update("gd_node",$update,array("id"=>$id));
if($result){
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    $this->echoAjax();
}
$this->msg['msg']="保存失败";
$this->echoAjax();