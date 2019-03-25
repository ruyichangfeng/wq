<?php
global $_W,$_GPC;
$ky=$_W['config']['cookie']['pre']."__api";
$isApi=isset($_COOKIE[$ky])?1:0;
if($_GPC['is_sys']==0){
    $url=$_W['siteroot']."app".str_replace("./index","/index",$this->createMobileUrl("login"));
}else{
    $url="./index.php?c=user&a=logout&";
}
isetcookie('__session', '', -10000);
isetcookie('__api', '', -10000);
isetcookie('m_name', '', -10000);
isetcookie('m_id', '', -10000);
isetcookie('m_avatar', '', -10000);
isetcookie('is_sys', '', -10000);
header("location:".$url);