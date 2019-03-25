<?php
//获取地图坐标

global $_GPC;
$lat=$_GPC['lat'];
$lnt =$_GPC['lnt'];
include $this->template("view_map");