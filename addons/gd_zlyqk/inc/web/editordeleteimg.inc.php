<?php
//删除图片

global $_GPC;
$id=$_GPC['id'];
pdo_delete("gd_images",array("id"=>$id));