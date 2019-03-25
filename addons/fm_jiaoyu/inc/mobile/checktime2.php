<?php
/**
 * By 高贵血迹
 */
;
$leixing = 3;
if($ckmac['type'] ==1){
	$leixing = 1;
	$lx = "进校";	
}else{
	$leixing = 2;
	$lx = "离校";
}
$type = "异常".$lx;
if ($school['jxstart'] < $nowtime & $nowtime < $school['jxend']){
    $type = "早上".$lx;
}

if ($school['lxstart'] < $nowtime & $nowtime < $school['lxend']){
    $type = "下午".$lx;
}

if ($school['jxstart1'] < $nowtime & $nowtime < $school['jxend1']){
    $type = "午间".$lx;
}

if ($school['lxstart1'] < $nowtime & $nowtime < $school['lxend1']){
    $type = "午间".$lx;
}

if ($school['jxstart2'] < $nowtime & $nowtime < $school['jxend2']){
    $type = "晚间".$lx;
}

if ($school['lxstart2'] < $nowtime & $nowtime < $school['lxend2']){
    $type = "晚间".$lx;
}
?>