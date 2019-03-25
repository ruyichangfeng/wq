<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *选手信息
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
 defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl');
$operation = trim($_GPC['op']);
if(empty($operation)) $operation=='display';
if($operation=="map"){
	 $mapjwd = trim($_GPC['jwd'])?trim($_GPC['jwd']):'map_jwd';
	 $address= trim($_GPC['addr'])?trim($_GPC['addr']):'address';
	 include $this->template("map");
}elseif($operation=='option'){//设置多选项
     $vals = trim($_GPC['vals']);
     $rowid = intval($_GPC['rowid']);
     $options = array();
     if($vals!=""){
     		$options_temp = explode("|",$vals);
     		foreach($options_temp as $optionval){
     				$temp = explode(",",$optionval);
     				$options[$temp[0]] = $temp[1];
     		}
     }
	 include $this->template("option");
}
?>
