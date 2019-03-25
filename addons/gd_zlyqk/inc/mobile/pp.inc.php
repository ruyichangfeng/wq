<?php
//手机端分配

global $_GPC,$_W;
$admin=$_GPC['admin'];
$poolId=$_GPC['pool'];
if(empty($admin)){
    $this->msg['msg']="选择员工";
    $this->echoAjax();
}
$adminInfo = $this->getAdminInfo($admin);
$poolInfo =pdo_get("gd_pool",array("id"=>$poolId));
$update['is_mark']=1;
$update['node_status']=2;
$update['mark_admin']=$admin;
$update['mark_time']=time();
if(pdo_update("gd_pool",$update,array("id"=>$poolId))){
    //发送模板消息通知
    $status=empty($poolInfo['node_name_status'])?"":$poolInfo['node_name_status'];
    $data = array(
        "first" => array(
            "value" => "派单通知",
        ),
        "keyword1" => array(
            "value" => $poolInfo['node_name'].$status
        ),
        "keyword2" => array(
            "value" => $poolInfo['app_name']."\n提交:  ".$poolInfo['name']."\n单号:  ".$poolInfo['gd_sn']
        ),
        "keyword3" => array(
            "value" => date("Y-m-d H:i:s",time())
        ),
        "remark" => array(
            "value" => "查看详情"
        )
    );
    $url = $_W['siteroot']."/".$this->createMobileUrl('detail',array("id"=>$poolInfo['recorder_id'],'app_id'=>$poolInfo['app_id']));
    $this->sendMsg($adminInfo['open_id'],$data,$url);
    $this->msg['code']=1;
    $this->msg['msg']="分配成功";
    $this->echoAjax();
}
$this->msg['msg']="选择员工";
$this->echoAjax();