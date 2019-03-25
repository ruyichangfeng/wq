<?php
$url = $_SERVER['REQUEST_URI'];
if(strpos($url,"web/index.php")!==false||strpos($url,"app/index.php")!==false){ 
	defined('IN_IA') or exit('Access Denied');
	!defined('ZSK_VERSION') && define('ZSK_VERSION',"6.0.14");
	!defined('ZSK_MODULE') && define('ZSK_MODULE',"zsk_market");
	!defined('ZSK_PATH') && define('ZSK_PATH',IA_ROOT.'/addons/zsk_market');
	!defined('ZSK_CERTPATH') && define('ZSK_CERTPATH',IA_ROOT.'/addons/zsk_market/core/cert/');
	!defined('ZSK_PREFIX') && define('ZSK_PREFIX','azsk_shop');
	!defined('ACT_WEB') && define('ACT_WEB',ZSK_PATH.'/core/web/');
	!defined('ACT_MOB') && define('ACT_MOB',ZSK_PATH.'/core/mob/');
	!defined('ACT_APP') && define('ACT_APP',ZSK_PATH.'/core/wxapp/');
	!defined('ZSK_STATIC') && define('ZSK_STATIC','../addons/zsk_market/static/');
	!defined('ZSK_PUBLIC') && define('TPL_PUBLIC','../addons/zsk_market/template/public/');
	!defined('TPL_JS') && define('TPL_JS','../addons/zsk_market/template/public/js/');
	!defined('TPL_CSS') && define('TPL_CSS','../addons/zsk_market/template/public/css/');
	!defined('TPL_WEB') && define('TPL_WEB','../addons/zsk_market/template/web/');
	!defined('ZSK_CERTPATH') && define('ZSK_CERTPATH',IA_ROOT.'/addons/zsk_market/core/cert/');
}else{
	!defined('ZSK_VERSION') && define('ZSK_VERSION',"6.0.14");
	!defined('ZSK_MODULE') && define('ZSK_MODULE',"zsk_market");
	$IASTRURL =  str_replace("\\", '/', dirname(__FILE__));
	if(is_dir($IASTRURL."/zsk_market")){
	    !define('ZSK_PATH', str_replace("\\", '/', dirname(__FILE__))."/zsk_market/");
	}else{
	    !define('ZSK_PATH', str_replace("\\", '/', dirname(__FILE__))."/");  	
	}
	!defined('ZSK_CERTPATH') && define('ZSK_CERTPATH',ZSK_PATH.'/core/cert/');
	!defined('ZSK_PREFIX') && define('ZSK_PREFIX','azsk_shop');
	!defined('ACT_WEB') && define('ACT_WEB',ZSK_PATH.'core/web/');
	!defined('ACT_MOB') && define('ACT_MOB',ZSK_PATH.'core/mob/');
	!defined('ACT_APP') && define('ACT_APP',ZSK_PATH.'core/wxapp/');
	!defined('ZSK_STATIC') && define('ZSK_STATIC','./static/');
	!defined('ZSK_PUBLIC') && define('TPL_PUBLIC',ZSK_PATH.'template/public/');
	!defined('TPL_JS') && define('TPL_JS',ZSK_PATH.'template/public/js/');
	!defined('TPL_CSS') && define('TPL_CSS',ZSK_PATH.'template/public/css/');
	!defined('TPL_WEB') && define('TPL_WEB',ZSK_PATH.'template/web/');
	!defined('ZSK_CERTPATH') && define('ZSK_CERTPATH',ZSK_PATH.'core/cert/');
}



 