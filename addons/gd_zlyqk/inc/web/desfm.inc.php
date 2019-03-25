<?php
//设计表单获取

global $_GPC;
$id =$_GPC['id'];
$extCols = $this->extList();
$nodeInfo = $this->getNodeInfo($id);
$formArr=json_decode($nodeInfo['form_list'],true);
foreach($formArr as $key=>$val){
    if($val['type']=='select' || $val['type']=='radio'  || $val['type']=='checkbox'){
        $formArr[$key]['pl']=explode(",",$val['pl']);
    }
}
$postUrl =$this->createWebUrl('addFrom',array("node_id"=>$id));
$baseConfig =$this->getLang();
include $this->template("design_form");
