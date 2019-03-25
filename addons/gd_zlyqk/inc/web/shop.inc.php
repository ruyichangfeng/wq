<?php
//市场下载

global $_GPC,$_W;
$category =isset($_GPC['category'])?$_GPC['category']:0;
$data['category']="$category";
//提交数据到api接口
$url =$this->apiUrl."api/share/shop";
$post=$this->createSign($data);
$result = $this->post($url,$post);
$data =$result['data'];
$category = isset($data['category'])?$data['category']:array();
$appList = isset($data['list'])?$data['list']:array();
include $this->template("shop");