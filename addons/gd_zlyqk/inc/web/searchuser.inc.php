<?php

//搜索用户

global $_GPC,$_W;
$where = " 1=1 ";
if(!empty($_GPC['keyword'])){
    $where .= " and name like '%{$_GPC['keyword']}%' or mobile like '%{$_GPC['keyword']}%' ";
}
$sql="select * from ".tablename("gd_member")." where ".$where." order by id desc limit 10";
$result = pdo_fetchall($sql);
include $this->template("search_member");