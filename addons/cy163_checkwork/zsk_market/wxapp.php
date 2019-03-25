<?php
/**
 * v1.0.0模块微站定义小程序商城模块小程序接口定义
 * @author zskcms
 * @url 
 */
defined('IN_IA') or exit('Access Denied'); 
ini_set("display_errors", "off");
require_once IA_ROOT.'/addons/zsk_market/defines.php';
require_once ZSK_PATH."/libs/function.php";  
//require_once ZSK_PATH."/libs/checkdb.php"; 
require_once ZSK_PATH."/libs/wechat.class.php"; 
require_once ZSK_PATH."/libs/wxpay/wxpay.class.php"; 
require_once ZSK_PATH."/libs/model.class.php";  
require_once ZSK_PATH."/libs/wxpush.func.php";  

class Zsk_marketModuleWxapp extends WeModuleWxapp {
	public function doPageRoute(){
		 route();
	}   
	 
}