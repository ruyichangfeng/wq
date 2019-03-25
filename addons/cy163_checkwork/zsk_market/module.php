<?php
/**
 * 掌上客小程序商城模块定义
 *
 * @author zskcms
 * @url 
 */
$url = $_SERVER['REQUEST_URI'];
if(strpos($url,"web/index.php")!==false){

	defined('IN_IA') or exit('Access Denied');
	require_once IA_ROOT.'/addons/zsk_market/defines.php';
	require_once ZSK_PATH."/libs/model.class.php";
	require_once ZSK_PATH."/libs/function.php"; 

	class Zsk_marketModule extends WeModule { 
		public function welcomeDisplay($menus = array()) {
			//这里来展示DIY管理界面
			// var_dump($menus); 
			$setting=getSetting();//初始化设置
			global $_W,$_GPC;  
			session_start();
			unset($_SESSION['currentShop']);
			$uniacid=intval($_W['uniacid']);
			$_SESSION['logingusername'] = $_W['username'];
			$shopid=getShopID(); 
			//******   初始化默认店铺   ******//
		 	$shopM=Model("shop");
		 	$first=Model("shop")->exist("uniacid=$uniacid");
		 	if(!$first){//第一次进入小程序没有默认店铺，那就加一个呗
		 		$shop=array(
		 			"isdefault"=>1,
		 			"account"=>$_W['username'],
			 		"name"=>$_W['uniaccount']['name'], 
			 		"joindate"=>date("Y-m-d",time()),
			 		"limitdate"=>date("Y-m-d",time()+86400*365*50),
			 		"status"=>1,
			 		"uniacid"=>$uniacid,
			 	);
		 		$shopM->add($shop);
		 	}else{
		 		$shop=array( 
			 		"limitdate"=>date("Y-m-d",time()+86400*365*50)
			 	);
			 	$shopM->where("limitdate<'2018-05-01' and isdefault=1 and uniacid=$uniacid")->limit(1)->save($shop);
		 	}
		   if($_W['role']=="owner"||$_W['role']=='founder'|| $_W['role']=='manager'){
		   		$_SESSION['judgeid'] = "owner";
		   }else if($_W['role']=="operator"){
		   		$_SESSION['judgeid'] = "operator";
		   }
			if(empty($shop9982)){
				 $shop9982=getShopInfo();
			} 
			include $this->template('index');
			
		}
		 
	}
}else{
	$IASTRURL =  str_replace("\\", '/', dirname(__FILE__));
	if(is_dir($IASTRURL."/zsk_market")){
	    define('IA_ROOT', str_replace("\\", '/', dirname(__FILE__))."/zsk_market");
	}else{
	    define('IA_ROOT', str_replace("\\", '/', dirname(__FILE__)));
	}
	include IA_ROOT.'/defines.php';
	require_once ZSK_PATH."core/task/pdo.class.php";
	require_once ZSK_PATH."libs/function.php";



	class Module extends WeModuleSite{
		public function welcomeDisplay($menus = array()) {
			$setting=getSetting();//初始化设置
			global $_W,$_GPC;
	        if (!session_id()) session_start();
			unset($_SESSION['currentShop']);
			$uniacid=intval($_W['uniacid']);
			$shopid=getShopID(); 
			//******   初始化默认店铺   ******//
		 	$shopM=Model("shop");
		 	$first=Model("shop")->exist("uniacid=$uniacid");
		 	if(!$first){//第一次进入小程序没有默认店铺，那就加一个呗
		 		$shop=array(
		 			"isdefault"=>1,
		 			"account"=>$_W['username'],
			 		"name"=>$_W['uniaccount']['name'], 
			 		"joindate"=>date("Y-m-d",time()),
			 		"limitdate"=>date("Y-m-d",time()+86400*365*50),
			 		"status"=>1,
			 		"uniacid"=>$uniacid,
			 	);
		 		$shopM->add($shop);
		 	}else{
		 		$shop=array( 
			 		"limitdate"=>date("Y-m-d",time()+86400*365*50)
			 	);
			 	$shopM->where("limitdate<'2018-05-01' and isdefault=1 and uniacid=$uniacid")->limit(1)->save($shop);
		 	}
		   
			if(empty($shop9982)){
				$shop9982=getShopInfo();
			} 
			include $this->template('index');
			
		} 
	}
	$module = new Module();
	$module->welcomeDisplay();
}