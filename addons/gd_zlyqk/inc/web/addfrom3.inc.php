<?php

global $_GPC,$_W;
$flowId=$_GPC['flow_id'];
$lineId=$_GPC['line_id'];
$dataList=json_decode(htmlspecialchars_decode($_GPC['data']),true);
$formArr=$this->parseDesForm($dataList);

$preInfo =$this->getReLine($flowId,$lineId);
if(empty($preInfo)){
    $insert['create_time']=time();
    $insert['uniacid']=$_W['uniacid'];
    $insert['form_list']=json_encode($formArr);
    $insert['line_id']=$lineId;
    $insert['flow_id']=$flowId;
    $result=pdo_insert("gd_preline",$insert);
    $pre_id=pdo_insertid();
}else{
    $pre_id=$preInfo['id'];
    $update['form_list']=json_encode($formArr);
    $result=pdo_update("gd_preline",$update,array("id"=>$pre_id));
}
if($result){
    $this->msg['data']=$pre_id;
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    echo $this->echoAjax();
}
$this->msg['msg']="保存失败";
echo $this->echoAjax();