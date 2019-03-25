<?php

global $_GPC;
$id = $_GPC['id'];
//获取流程信息
$appInfo =$this->getDefaultApp(array("id"=>$id));
$nodeList = $this->getNodeList($appInfo['flow_id']);
$this->msg['code']=1;
$this->msg['data']=$nodeList;
$this->echoAjax();