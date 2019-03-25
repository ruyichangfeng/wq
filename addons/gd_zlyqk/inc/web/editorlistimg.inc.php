<?php
//列出图片

global $_W;
$images = pdo_fetchall("select * from ".tablename("gd_images")." where uniacid={$_W['uniacid']} and `type`='image' order by id desc limit 50");
$fmImages=array();
foreach($images as $key=> $image){
    $item['id']=$image['id'];
    $item['name']=$image['name'];
    $item['url']="/".$image['url'];
    $item['thumb']="/".$image['url'];
    $fmImages[]=$item;
}
echo json_encode($fmImages);