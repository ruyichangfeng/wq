<?php
global $_GPC,$_W;
$id=$_GPC['id'];
if(empty($id)){
    $this->msg['msg']="非法数据";
    $this->echoAjax();
}
$poolInfo =pdo_get("gd_pool",array("id"=>$id));
$update['is_abort']=1;
$update['cancel_time']=time();
$update['recorder_status']=3;
$update['node_name_status']="已撤销";
if(pdo_update("gd_pool",$update,array("id"=>$id))){
    $memberInfo =$this->getMemberInfo();
    //修改记录表
    $up['status_name']="已撤销";
    $up['is_end']=1;
    $up['end_time']=time();
    $table = str_replace($this->getTablePre(),"",$poolInfo['table']);
    pdo_update($table,$up,array("id"=>$poolInfo['recorder_id']));

    //写入操作表
    $appInfo=$this->getAppInfo($poolInfo['app_id']);
    $deal['flow_id']=$appInfo['flow_id'];
    $deal['node_id']=$poolInfo['node_id'];
    $deal['deal_role']=2;
    $deal['recorder_id']=$poolInfo['recorder_id'];
    $deal['deal_time']=time();
    $deal['member_id']=$memberInfo['id'];
    $deal['member_name']=$memberInfo['name'];
    $deal['deal_msg']=json_encode(array("status_name"=>"已撤销"));
    $deal['status_id']=0;
    $deal['status_name']="已撤销";
    $deal['app_id']=$appInfo['id'];
    pdo_insert("gd_deal",$deal);

    //写入撤销记录
    $log['uniacid']=$_W['uniacid'];
    $log['app_id']=$poolInfo['app_id'];
    $log['pool_id']=$poolInfo['id'];
    $log['recorder_id']=$poolInfo['recorder_id'];
    $log['node_id']=$poolInfo['node_id'];
    $log['node_name']=$poolInfo['node_name'];
    $log['member_id']=$memberInfo['id'];
    $log['member_name']=$memberInfo['name'];
    $log['create_time']=time();
    $log['status']=1;
    pdo_insert("gd_cancel",$log);
    $this->msg['code']=1;
    $this->msg['msg']="撤销成功";
    $this->echoAjax();
}
$this->msg['msg']="撤销失败";
$this->echoAjax();