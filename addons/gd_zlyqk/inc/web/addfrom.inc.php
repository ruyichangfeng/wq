<?php
//添加表单

global $_GPC;
$dataList=json_decode(str_replace("&quot;",'"',$_GPC['data']),true);
$formArr=$this->parseDesForm($dataList);;

$result = pdo_update("gd_node",array("form_list"=>json_encode($formArr)),array("id"=>$_GPC['node_id']));
if($result){
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    echo $this->echoAjax();
}
$this->msg['msg']="保存失败";
echo $this->echoAjax();