<?php
//添加表单

global $_GPC,$_W;
$flowId=$_GPC['flow_id'];
$nodeId=$_GPC['node_id'];
$dataList=json_decode(str_replace("&quot;",'"',$_GPC['data']),true);
$formArr=$this->parseDesForm($dataList);

$preInfo =$this->getReNode($flowId,$nodeId);
if(empty($preInfo)){
    $insert['create_time']=time();
    $insert['uniacid']=$_W['uniacid'];
    $insert['form_list']=json_encode($formArr);
    $insert['node_sid']=$nodeId;
    $insert['flow_id']=$flowId;
    $result=pdo_insert("gd_prenode",$insert);
    $pre_id=pdo_insertid();
}else{
    $pre_id=$preInfo['id'];
    $update['form_list']=json_encode($formArr);
    $result=pdo_update("gd_prenode",$update,array("node_sid"=>$nodeId,"flow_id"=>$flowId));
}
if($result){
    $this->msg['data']=$pre_id;
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    echo $this->echoAjax();
}
$this->msg['msg']="保存失败";
echo $this->echoAjax();