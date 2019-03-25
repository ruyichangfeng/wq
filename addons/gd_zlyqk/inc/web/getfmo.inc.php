<?php

//获取表单结构

global $_GPC;
$appId =$_GPC['app_id'];
$html=$this->__createAForm($appId);
echo $html;