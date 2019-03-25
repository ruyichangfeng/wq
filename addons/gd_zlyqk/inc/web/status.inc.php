<?php

global $_GPC;
$id =$_GPC['id'];
$statusList =$_GPC['status'];
$doList =$_GPC['doe'];
$nextList = $_GPC['next'];
$flowId =$_GPC['flow'];
$nodeList = $this->getNodeList($flowId,true);
$statusArr=array();
foreach($statusList as $key=>$val){
    if(empty($val)){
        continue;
    }
    $item['status']=$val;
    $item['do']=isset($doList[$key])?$doList[$key]:1;
    if(isset($nextList[$key]) && $nextList[$key]!=""){
        $item['next']=$nextList[$key];
    }else{
        if($item['do']==1){
            $item['next']=isset($nodeList[$id+1])?($id+1):0;
        }else{
            $item['next']=0;
        }
    }
    $statusArr[]=$item;
}
$result = pdo_update("gd_node",array("status_list"=>json_encode($statusArr)),array("id"=>$id));
if($result){
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    echo $this->echoAjax();
}
$this->msg['msg']="保存失败";
echo $this->echoAjax();