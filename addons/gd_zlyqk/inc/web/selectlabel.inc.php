<?php
global $_W,$_GPC;
$where = " uniacid={$_W['uniacid']} ";
if($_GPC['name']){
    $where .= " and name like '%{$_GPC['name']}%' ";
}
$sql=" select * from ".tablename("gd_code_label")." where $where and status=1 ";
$dataList =pdo_fetchall($sql);
include $this->template("select_label");