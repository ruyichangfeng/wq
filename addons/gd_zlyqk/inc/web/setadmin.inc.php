<?php
//选择客户

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
include $this->template("set_admin");