<?php
$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_configs'));

class ADConf {
	//const	AccessId = "513912147905";		//把...替换成自己的AccessId
	//const	AccessKey = "0Cfg7J1og06IN95YFv0EC9EN5Og825G7";		//把...替换成自己的AccessKey
	//const 	TisId = "5f58dc6c9f90ed6399ed62ac44b33fa6";			//把...替换成自己的TisId
}
$accessId = $list['accessid'];
$accessKey = $list['accesskey'];
if(!empty($_REQUEST["tisId"])){
	$tisId = $_REQUEST["tisId"];
} else {
	$tisId = $list['tisid'];
}
?>