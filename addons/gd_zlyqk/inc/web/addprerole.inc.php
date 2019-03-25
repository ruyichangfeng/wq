<?php
//添加角色

global $_GPC,$_W;
$nodeId =$_GPC['id'];
$flowId =$_GPC['flow_id'];

$role =$_GPC['role'];
$adminList =$_GPC['admin'];
$adm_list =$_GPC['auser'];
$result = $this->getReNode($flowId,$nodeId);
if(empty($result)){
    $insert['uniacid']=$_W['uniacid'];
    $insert['who']=$role;
    $insert['who_list']=json_encode($adminList);
    $insert['adm_list']=json_encode($adm_list);
    $insert['create_time']=time();
    $insert['node_sid']=$nodeId;
    $insert['flow_id']=$flowId;
    $result=pdo_insert("gd_prenode",$insert);
    $pre_id=pdo_insertid();
}else{
    $pre_id=$result['id'];
    $update['who']=$role;
    $update['adm_list']=json_encode($adm_list);
    $update['who_list']=json_encode($adminList);
    $result=pdo_update("gd_prenode",$update,array("flow_id"=>$flowId,'node_sid'=>$nodeId));
}
if($result){
    $this->msg['data']=$pre_id;
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    $this->echoAjax();
}
$this->msg['msg']="保存失败";
$this->echoAjax();