<?php
//分配人员处理

global $_W,$_GPC;
$where =" where status=1 and uniacid={$_W['uniacid']} ";
if($_GPC['name']){
    $where .= " and name like '%{$_GPC['name']}%' ";
}
if($_GPC['mobile']){
    $where .= " and mobile like '%{$_GPC['mobile']}%' ";
}
$dataList = pdo_fetchall("select * from ".tablename("gd_admin").$where);
$departments = $this->getDepartment(true);
//获取员工部门信息
foreach($dataList as $key=>$val){
    $dataList[$key]['dp_name']="待分配";
    if(isset($departments[$val['department']])){
        $dataList[$key]['dp_name']=$departments[$val['department']];
    }
}
if(isset($_GPC['flow_id'])){
    $flowId=$_GPC['flow_id'];
    $nodeId=$_GPC['id'];
    //获取记录
    $nodeInfo =$this->getReNode($flowId,$nodeId);
    $admList =json_decode($nodeInfo['adm_list'],true);
    foreach($dataList as $key=>$val){
        if(in_array($val['id'],$admList)){
            $dataList[$key]['check']=1;
        }else{
            $dataList[$key]['check']=0;
        }
    }
    include $this->template("select_admin");
}else{
    include $this->template("give_admin");
}
