<?php
//标注处理

global $_W,$_GPC;
$appId=$_GPC['app'];
$id=$_GPC['id'];
$adminInfo=$this->getAdminInfo($_GPC['m_id']);
//获取标记状态
$poolInfo =pdo_get("gd_pool",array("id"=>$id));
if(!empty($poolInfo) && $poolInfo['is_remark']==1){
    $this->msg['msg']="消息已被其他员工处理";
    $this->echoAjax();
}
$update['is_mark']=1;
$update['mark_admin']=$adminInfo['id'];
$update['staff_name']=$adminInfo['name'];
$update['mark_time']=time();
$update['node_status']=2;

if(pdo_update("gd_pool",$update,array("id"=>$id))){
    $this->msg['code']=1;
    $this->msg['msg']="标记成功";
    $this->echoAjax();
}
$this->msg['msg']="标记失败";
$this->echoAjax();