<?php
//编辑表单

global $_GPC,$_W;
$dataList=json_decode(str_replace("&quot;",'"',$_GPC['data']),true);
$appId=isset($_GPC['app_id'])?$_GPC['app_id']:$_GPC['id'];

//获取信息
$appInfo = $this->getAppInfo($appId);
if(empty($appInfo['table'])){
    $this->msg['msg']="表单数据表不存在";
    $this->echoAjax();
}
$formArr=$this->parseDesForm($dataList);
//修改表字段
$cols= pdo_fetchallfields($appInfo['table']);
$fCols=array();
$addCols=array();
foreach($cols as $vl){
    $fCols[$vl]=$vl;
}
foreach($formArr as $val){
    if(!isset($fCols[$val['py']])){
        $addCols[]=$val;
    }
}
//添加新列
$this->addNewCol($addCols,$appInfo['table'],$fCols);
//修改原始记录
$update['source']=json_encode($formArr);
$update['update_time']=time();
if(pdo_update("gd_source_form",$update,array('app_id'=>$appId))){
    $this->msg['code']=1;
    $this->msg['msg']="修改表单成功";
    $this->echoAjax();
}
$this->msg['msg']="修改表单失败,请刷新重试";
$this->echoAjax();