<?php
//分配人员

global $_W,$_GPC;
$adminId=$_GPC['admin'];
$id=$_GPC['id'];
$adminInfo=$this->getAdminInfo($adminId);
if(empty($adminInfo)){
    $this->msg['msg']="员工未找到";
    $this->echoAjax();
}
//获取标记状态
$poolInfo =pdo_get("gd_pool",array("id"=>$id));
$appInfo=$this->getAppInfo($poolInfo['app_id']);
if(!empty($poolInfo) && $poolInfo['is_remark']==1){
    $this->msg['msg']="消息已被其他员工处理";
    $this->echoAjax();
}
$update['is_mark']=1;
$update['mark_admin']=$adminInfo['id'];
$update['staff_name']=$adminInfo['name'];
$update['mark_time']=time();
$update['node_status']=2;

$table =str_replace($this->getTablePre(),"",$appInfo['table']);
$recorderInfo = pdo_get($table,array("id"=>$poolInfo['recorder_id']));
$statusStr=empty($recorderInfo['status_name'])?"":"({$recorderInfo['status_name']})";
$node_name=$recorderInfo['node_name'];
if(pdo_update("gd_pool",$update,array("id"=>$id))){
    $data = array(
        "first" => array(
            "value" => "分配通知",
        ),
        "keyword1" => array(
            "value" => $node_name.$statusStr
        ),
        "keyword2" => array(
            "value" => $appInfo['name']."\n提交:  ".$poolInfo['name']."\n单号:  ".$poolInfo['gd_sn']."\n提交时间:  ".date("Y-m-d H:i:s",$poolInfo['create_time'])
        ),
        "keyword3" => array(
            "value" => date("Y-m-d H:i:s",time())
        ),
        "remark" => array(
            "value" => "查看详情"
        )
    );
    $url = $_W['siteroot']."/".$this->createMobileUrl('detail',array("id"=>$poolInfo['recorder_id'],'app_id'=>$appInfo['id']));
    $this->sendMsg($adminInfo['open_id'],$data,$url);

    $this->msg['code']=1;
    $this->msg['msg']="分配成功";
    $this->echoAjax();
}
$this->msg['msg']="分配失败";
$this->echoAjax();