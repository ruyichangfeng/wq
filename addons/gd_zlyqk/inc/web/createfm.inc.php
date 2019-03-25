<?php
//创建表单

global $_GPC,$_W;
$fresh=isset($_GPC['fresh'])?1:0;
$dataList=json_decode(str_replace("&quot;",'"',$_GPC['data']),true);
$appId=isset($_GPC['app_id'])?$_GPC['app_id']:$_GPC['id'];
$formArr=$this->parseDesForm($dataList);
//创建表
$table = $this->createTable($formArr);
//修改app应用表
$changeApp=pdo_update("gd_app",array("table"=>$table),array('id'=>$appId));
if(!$changeApp){
    $this->msg['msg']="创建表单失败,请刷新重试";
    $this->echoAjax();
}
//创建原始记录
$insert['table']=$table;
$insert['app_id']=$appId;
$insert['source']=json_encode($formArr);
$insert['create_time']=time();
if(pdo_insert("gd_source_form",$insert)){
    $this->msg['code']=1;
    $this->msg['msg']="创建表单成功";
    $this->echoAjax();
}
$this->msg['msg']="创建表单失败,请刷新重试";
$this->echoAjax();