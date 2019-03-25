<?php
global $_GPC,$_W;
$id=$_GPC['id'];
$adminInfo =$this->isAdmin();

if(empty($adminInfo)){
    $this->msg['msg']="请绑定员工";
    $this->echoAjax();
}
if(empty($id)){
    $this->msg['msg']="非法数据";
    $this->echoAjax();
}
//获取标记状态
$poolInfo =pdo_get("gd_pool",array("id"=>$id));
if(!empty($poolInfo) && $poolInfo['is_remark']==1){
    $this->msg['msg']="消息已被其他员工处理";
    $this->echoAjax();
}
$baseConfig =$this->getLang();
$jd = empty($baseConfig['jd'])?"接单":$baseConfig['jd'];
$update['is_mark']=1;
$update['mark_admin']=$adminInfo['id'];
$update['staff_name']=$adminInfo['name'];
$update['mark_time']=time();
$update['node_status']=2;
if(pdo_update("gd_pool",$update,array("id"=>$id))){
    //更新提醒消息
    pdo_update("gd_remind",array('status'=>2),array("pool_id"=>$poolInfo['id'],'node_id'=>$poolInfo['node_id']));
    $this->msg['code']=1;
    $this->msg['msg']=$jd."成功";
    $this->echoAjax();
}
$this->msg['msg']=$jd."失败";
$this->echoAjax();