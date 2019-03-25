<?php

global $_W,$_GPC;
$memberInfo =$this->getMemberInfo();
$extInfo = pdo_get("gd_member_ext",array("uniacid"=>$_W['uniacid'],'sort'=>$_GPC['sort']));
$xml = json_decode($extInfo['xml'],true);
//获取数据
$where=array("uniacid"=>$_W['uniacid'],'member_id'=>$memberInfo['id']);
$table= str_replace($this->getTablePre(),"",$extInfo['table']);
$memberIf = pdo_get($table,$where);
$outData=array();
foreach($xml as $xl){
    $outData[$xl['py']]=isset($memberIf[$xl['py']])?$memberIf[$xl['py']]:"";
}
$this->msg['data']=$outData;
$this->echoAjax();