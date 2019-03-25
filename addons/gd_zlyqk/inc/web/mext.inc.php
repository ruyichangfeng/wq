<?php
global $_GPC,$_W;
$dataList =pdo_getall("gd_member_ext",array("uniacid"=>$_W['uniacid']));
include $this->template("member_ext");