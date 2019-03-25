<?php
global $_GPC;
$where=" 1=1 ";
if(!isset($_GPC['start'])){
    $start = strtotime(date("Y-m-d",time()));
    $end = strtotime("+1 day",$start);
}else{
    $start = strtotime($_GPC['start']);
    $end = strtotime($_GPC['end']);
}
$_GPC['start']=date("Y-m-d",$start);
$_GPC['end']=date("Y-m-d",$end);
$where .= " and create_time>$start and create_time<$end ";
if($_GPC['app']){
    $where .= " and app_id={$_GPC['app']} ";
}
if($_GPC['title']){
    $where .= " and member_name like '%{$_GPC['title']}%' ";
}
if(isset($_GPC['node_id']) && $_GPC['node_id']!=-2){
    $where .= " and node_id={$_GPC['node_id']} ";
}
if(isset($_GPC['status_id']) && $_GPC['status_id']!=-2){
    $where .= " and status_id={$_GPC['status_id']} ";
}
//获取app列表
$appList=$this->getAppList();
$apps=$appList;

if(empty($_GPC['app'])){
    $appInfo = $this->getDefaultApp();
    $_GPC['app']=$appInfo['id'];
}else{
    $appInfo = $this->getDefaultApp(array("id"=>$_GPC['app']));
}

$listRow =$this->listRow;
$page =$this->page;
$total = pdo_fetchcolumn("select count(*) from ".$appInfo['table']." where $where");
$totalPage=ceil($total/$listRow);
$sql = "select * from ".$appInfo['table']. " where ".$where." order by id desc limit ".($this->page-1)*10 ." , ".$this->listRow;
$dataList =pdo_fetchall($sql);

//获取表结构描述
$filed=pdo_get("gd_source_form",array('app_id'=>$appInfo['id']));
$filed =json_decode($filed['source'],true);
$notTab=array("textarea","photo","voice");
foreach($filed as $key=>$val){
    if(in_array($val['type'],$notTab)){
        unset($filed[$key]);
        continue;
    }
    if(!empty($val['pl']) && $val['type']=="select"){
        $filed[$key]['pl']=explode(",",$val['pl']);
    }
}
//获取nodeList 如果存在id
if($_GPC['app']){
    $appInfo = $this->getAppInfo($_GPC['app']);
    $nodeList =$this->getNodeList($appInfo['flow_id']);
    $data['nodeList']=$nodeList;
}
//获取statusList
if(isset($_GPC['node_id']) && $_GPC['node_id']>-2){
    $nodeInfo=$this->getNodeInfo($_GPC['node_id']);
    $data['statusList']=$nodeInfo['status_list'];
}
include $this->template("recorder_list");