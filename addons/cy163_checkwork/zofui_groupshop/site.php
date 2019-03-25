<?php
/**
 * 众惠团购商城商城模块微站定义
 *
 * @author 众惠科技 QQ273734268
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('ZOFUI_GROUPSHOP',IA_ROOT.'/addons/zofui_groupshop/');
require ZOFUI_GROUPSHOP . 'class/autoload.php';
//header("Content-Type:text/html;charset=utf-8");
//error_reporting(E_ALL ^ E_NOTICE);

class Zofui_groupshopModuleSite extends WeModuleSite {
	
	
	
	
	//支付
	function payResult($params){
		payResult::fshopPayResult($params,$this);
	}
	
	
	
}