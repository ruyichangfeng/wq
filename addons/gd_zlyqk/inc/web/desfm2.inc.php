<?php

global $_GPC;
$nodeId =$_GPC['id'];
$flowId =$_GPC['flow_id'];
$extCols = $this->extList();
$preInfo =$this->getReNode($flowId,$nodeId);
$formArr=json_decode($preInfo['form_list'],true);
foreach($formArr as $key=>$val){
    if($val['type']=='select' || $val['type']=='radio' || $val['type']=='checkbox'){
        $formArr[$key]['pl']=explode(",",$val['pl']);
    }
}
$postUrl=$this->createWebUrl('addFrom2',array("node_id"=>$nodeId,"flow_id"=>$flowId));
$baseConfig =$this->getLang();
include $this->template("design_form");