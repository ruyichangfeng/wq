<?php
//获取节点状态

global $_GPC;
$id = $_GPC['id'];
$nodeList = $this->getNodeInfo($id);
$this->msg['code']=1;
$this->msg['data']=$nodeList;
$this->echoAjax();