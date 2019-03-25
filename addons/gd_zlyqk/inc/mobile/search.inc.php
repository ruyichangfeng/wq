<?php
//用户搜索

global $_GPC,$_W;
$searchKey=$_GPC['keyword'];
$where['uniacid']=$_W['uniacid'];
$where['is_sys']=0;
if($searchKey){
    $where['name like']='%'.$searchKey.'%';
}
if(!empty($_GPC['group'])){
    $in = explode(",",$_GPC['group']);
    $where['department in']=$in;
}
$adminList = pdo_getall("gd_admin",$where);
foreach($adminList as $key=>$val){
    //获取部门了信息
    $dpInfo=array();
    if($val['department']>0){
        $dpInfo =pdo_get("gd_department",array("id"=>$val['department']));
    }
    $adminList[$key]['organize']=isset($dpInfo['name'])?$dpInfo['name']:"-";
}
$this->msg['data']=$adminList;
$this->echoAjax();