<?php 
$url = $_SERVER['REQUEST_URI'];
if($_SERVER['HTTPS']=="on"){
$serverhost='https:';
}
else{
$serverhost='http:';
}
if(strpos($url,"web/index.php")!==false||strpos($url,"app/index.php")!==false){ 
	$_W['attachurl']= $serverhost.'//'.$_SERVER['SERVER_NAME']."/attachment/";
	$_W['rootdirectory']= $serverhost.'//'.$_SERVER['SERVER_NAME']."/addons/zsk_market/";
	$_W['wxpaycallbackurl']= $serverhost.'//'.$_SERVER['SERVER_NAME']."/addons/zsk_market/core/task/wxpay_callback.php";
	
}else{
	 $_W['attachurl']=$serverhost.'//'.$_SERVER['SERVER_NAME']."/attachment/";
	 $_W['rootdirectory']= $serverhost.'//'.$_SERVER['SERVER_NAME']."/";
	 $_W['wxpaycallbackurl']= $serverhost.'//'.$_SERVER['SERVER_NAME']."/core/task/wxpay_callback.php";
	define('MODELFILE_ROOT', str_replace("\\", '/', dirname(dirname(__FILE__))));
	$modelfile = MODELFILE_ROOT.'/model/model.php';
	if(file_exists($modelfile)) {
		include $modelfile;
	}else{
	  $modelfile = MODELFILE_ROOT.'/zsk_market/model/model.php';
	  if($modelfile){
	  	include $modelfile;
	  }
	}
}
function debug_log($log=""){
	if(gettype($log)!="string"){$log=json_encode($log);}
	pdo_insert("azsk_shop_errorlog",array("log"=>$log));
} 
function isManager($no=false){
	global $_W;
	if($_W['role']=='operator'||$_W['role']=="clerk"){
		if($no){
			message("不是管理者，没有权限操作");
			exit;
		}else{
			
			return false;
		}
	}else{
		return true;
	}
}
// function compaireVersion($v0,$v1){//如果v1>v0返回1，v1<=v2返回0
// 	$vr1=explode(".", $v1);
// 	$vr0=explode(".", $v0);
// 	if(intval($vr1[0])>intval($vr0[0])){
// 		return 1;
// 	}else if(intval($vr1[0])<intval($vr0[0])){
// 		return 0;
// 	}else{
// 		if(intval($vr1[1])>intval($vr0[1])){
// 			return 1;
// 		}else if(intval($vr1[1])<intval($vr0[1])){
// 			return 0;
// 		}else{
// 			if(intval($vr1[2])>intval($vr0[2])){
// 				return 1;
// 			}else if(intval($vr1[2])<intval($vr0[2])){
// 				return 0;
// 			}else{
// 				return 0;
// 			}
// 		}
// 	}
// } 
if (!function_exists('route')) {
	function route(){
		global $_GPC,$_W; 
		$act=$_GPC['act'];   
		$from=0;
		if(intval($_W['uid'])||!$_GPC['from']){ 
			$path=ZSK_PATH.'/core/web/'; 
		}else if($_GPC['from']=="wxapp"||$_GPC['a']=="wxapp"){
			$from="wxapp";
			$path=ZSK_PATH.'/core/wxapp/';
		}else if(strpos($_W['siteurl'],'/app/index.php')!==false){
			$path=ZSK_PATH.'/core/mob/';
		}  
		if(strtolower($_GPC['do'])=='route'){
			$acts=explode(".", $act); 
			if(count($acts)>2){
				for($i=0;$i<(count($acts)-1);$i++){
					$file.=$acts[$i]."/";
				} 
				$file=$path.substr($file,0,strlen($file)-1).".ctrl.php"; 
				$class=$acts[count($acts)-2]; 
				$func=$acts[count($acts)-1];
			}else if(count($acts)==2){
				$file=$path.$acts[0].".ctrl.php"; 
				$class=$acts[0];
				$func=$acts[1];
			}      
		}else{
			$acts=explode(".", $act); 

			if(count($acts)>1){
				for($i=0;$i<(count($acts)-1);$i++){
					$file.=$acts[$i]."/";
				}
				$file=$path.$_GPC['do']."/".substr($file,0,strlen($acts[0])-1).".ctrl.php"; 
			 	$class=$acts[count($acts)-2]; 
				$func=$acts[count($acts)-1];
			}else if(count($acts)==1){
				$file=$path.$_GPC['do'].".ctrl.php"; 
				$class=$_GPC['do'];
				$func=$acts[0];
			}else{
				$file=$path.$_GPC['do'].".ctrl.php"; 
				$class=$_GPC['do'];
				if (!is_file($file)) { 
					$file=$path.$_GPC['do']."/".$_GPC['do'].".ctrl.php"; 
				}  
				$func=$acts[0];
			}  
			 
		} 
		if(empty($func)){
			$func="index";
		}  
	 
		if (!is_file($file)) {  //xxx.php
			exit(' 控制器 ' . $class . ' 不存在!'); 
		}else{ 
			require_once $file; 

			$class_name = ucfirst($class); 

			$controller = new $class_name(); 
			if($from=="wxapp"){
				$controller->__define=ZSK_PATH."/wxapp.php";
			}else{ 
				$controller->__define=ZSK_PATH."/site.php";
			}
			
			$controller->uniacid=$_W['uniacid'];
			$controller->module=ZSK_MODULE;
			
			if(!method_exists($controller,$func)){
			    die('方法 '.$class_name.'->'.$func.'()不存在');
			} 
			$controller->$func(); 
		}
		
		exit;
	}
} 
if (!function_exists('M')) {
	function M($name) {
		$model = new Model($name);
		return $model;
	} 
}
if (!function_exists('Model')) { 
	function Model($name) {
		$model = new Model($name);
		return $model;
	} 
}
if (!function_exists('pdo_insert')) {
	function pdo_insert($tab,$data){
		$model = new Model("x");
		$model->table($tab);
		return $model->add($data); 
	}
}
if (!function_exists('pdo_fetch')) {
	function pdo_fetch($sql){
		$model = new Model("x");
		return $model->fetch($sql);
	}; 
}
if (!function_exists('pdo_fetchall')) {
	function pdo_fetchall($sql){
		$model = new Model("x");
		return $model->query($sql);
	}; 
}
if (!function_exists('pdo_query')) {
	function pdo_query($sql){
		$model = new Model("x");
		return $model->query($sql);
	}; 
}
if (!function_exists('tablename')) {
	function tablename($tab){
		$model = new Model("x");
		return $model->tablename($tab);
	}
}
if (!function_exists('pdo_fetchcolumn')) {
	function pdo_fetchcolumn($sql){
		$model = new Model("x");
		return $model->fetchcolumn($sql);
	}
}
function getSetting($type="default",$fresh=false){
	global $_W,$_GPC;
	$uniacid=intval($_W['uniacid']);
	//存储session，减少数据库查询次数
	session_start();
	 
	$fields="*";
	if($fresh){
		$_SESSION[ZSK_MODULE."_setting_".$uniacid]=NULL; 
	} 
	if(!empty($_SESSION[ZSK_MODULE."_setting_".$uniacid])){
		return $_SESSION[ZSK_MODULE."_setting_".$uniacid];
	} 

	$model999=new Model("setting"); 
	$uniacid=intval($_W['uniacid']);
	
	$setting=$model999->where("uniacid=$uniacid")->get($fields); 
	$setting['wx_conf']=json_decode($setting['wx_conf'],true);
	$setting['wxpay']=json_decode($setting['wxpay'],true);	 
	$setting['wxapp_layout']=json_decode($setting['wxapp_layout'],true); 
	$setting['kdniao']=json_decode($setting['kdniao'],true); 
	$setting['wxapp_conf']=json_decode($setting['wxapp_conf'],true); 
	$setting['agent']=json_decode($setting['agent'],true); 
	if(intval($setting['uniacid'])<1){//没有任何信息
		$setting=array(
			"name"=>$_W['uniaccount']['name'],
			"id"=>$_W['uniacid'],
			"uniacid"=>$_W['uniacid'],
			"agent"=>json_encode(['auto_sign'=>"on",'auto_levelup'=>"on"])
		);
		$res=$model999->add($setting);
		if($res){
			$setting=$model999->where("uniacid=$uniacid")->get($fields);
		}
	}
	 

	if(intval($setting['wx_auth_uniacid'])>0){
		$sql = "SELECT key as appid,secret FROM ims_account_wechats WHERE uniacid =".$setting['wx_auth_uniacid']." LIMIT 1";
		$we = Model("shop")->query($sql);
		// $wechat=pdo_fetch("SELECT `key` as appid,secret FROM ".tablename("account_wechats")." WHERE uniacid=".$setting['wx_auth_uniacid']." LIMIT 1");
		$wechat = $we[0];
		if(!empty($wechat)){
			$setting['wx_conf']['appid']=$wechat['appid'];
			$setting['wx_conf']['secret']=$wechat['secret'];
		}
	}
	
	if($type!="pay"){
		unset($setting['keypem']);
		unset($setting['certpem']); 
		unset($setting['wxpay_key']);
		unset($setting['wxpay']['secret']);
	} 
	
	$setting['site']=$_W['siteroot'];
	$setting['siteroot']=$_W['siteroot']."app/index.php";
	$setting['attachurl']=$_W['attachurl'];
	$setting['static']=$_W['siteroot']."addons/".ZSK_MODULE."/static/"; 

	//兼容老数据
	$setting['wxpay_mchid']=$setting['wxpay']['mchid'];
	$setting['wxpay_key']=$setting['wxpay']['key'];
	$setting['payway_wx']=$setting['wxpay']['payway_wx'];
	$setting['payway_daofu']=$setting['wxpay']['payway_daofu'];
	$setting['sendway_self']=$setting['wxpay']['sendway_self'];	
	 
	$setting['wx_appid']=$setting['wx_conf']['appid']; 
	$setting['wx_secret']=$setting['wx_conf']['secret']; 
	$setting['kdniao_id']=$setting['kdniao']['userid'];
	$setting['kdniao_key']=$setting['kdniao']['apikey'];

	$_SESSION[ZSK_MODULE."_setting_".$uniacid]=$setting;
	return $setting;
 
}
function sendOrderMail($mailStr,$order){
	global $_W;
	$uniacid=intval($_W['uniacid']);
	$m2=Model("pusher");
	$shopid=intval($order['shopid']);
	$mailpusher=$m2->where("uniacid=$uniacid and type=1 and shopid=$shopid")->get("*"); 
	$title='新订单！';
	if(strlen(trim($num))){
		$title.=" [单号：$num]";
	}
	$message = $mailStr;
	$res=sendMail($mailpusher['email'],$title,$message);
	
	return $res; 
}
function sendMail($to,$title,$content,$sender="小程序商城"){
	global $_W;
	$setting=getSetting("all");  
	if(strlen(trim($setting['mail_sender']))<5||strlen(trim($setting['mail_code']))<2){
		return false;
	}
	$conf0=array(
		"username"=>$setting['mail_sender'],
		"password"=>$setting['mail_code'],
		"sender"=>$sender,
		"smtp"=>array(
			"type"=>"qq",
			"authmode"=>true
		)
	); 
	$_W['setting']['mail']=$conf0;
 	include ZSK_PATH."libs/communication.func.php"; 
  	$response = ihttp_email($to,$title,$content);
  	return $response;
}
 
function routeUrl($act){ 
	global $_GPC;
	$module0=strlen($_GPC['m'])>0?$_GPC['m']:ZSK_MODULE;
	$url0=url('site/entry/route',array("m"=>$module0));
	$url0.="&version_id=".intval($_GPC['version_id'])."&act=$act"; 
	if(isset($_GPC['mactpid'])){
		$url0.="&mactpid=".$_GPC['mactpid'];
	}
	if(isset($_GPC['mactid'])){
		$url0.="&mactid=".$_GPC['mactid'];
	}
	return  $url0;
}
function wxappUrl($act,$siteroot=false){
	global $_GPC,$_W; 
	$url0="app/index.php?m=".ZSK_MODULE."&do=route&c=entry&a=wxapp&i=".intval($_W['uniacid'])."&act=$act&from=wxapp&t=0&sign=xxx";   
	if($siteroot){
		$url0=$_W['siteroot'].$url0;
	}
	return  $url0;
}
function URL_ENCODE($d){
//递归将多为数组urlencode
	$json= EACHARR($d,"urlencode");
	return $json;
}
function URL_DECODE($d){
//递归将多为数组urldecode
	$json= EACHARR($d,"urldecode");
	return $json;
}
function JSON_OUT($d,$replace=false){ 
//递归将数组json_encode; 

	$json= EACHARR($d,"urlencode",$replace);
	return urldecode(json_encode($json)); 
 
}

/**
 * 获取返回结果
 * @param type $code
 * @param type $msg
 * @param type $data
 * @return type
 */
function getInfo($code = null, $msg = null, $data = null) {
    return json_encode(['code' => $code, 'msg' => $msg, 'data' => $data]);
}
function EACHARR($arr,$act=false,$repSts=false){ 
//递归数组，方便其他函数应用
	switch (gettype($arr)) {
		case 'array': 
			foreach ($arr as $key => $val) {
				$arr[$key] = EACHARR($val,$act,$repSts);// 
			}
			break;  
		default: 
			if($repSts){
				$find = array("\r\n", "\n", "\r");  
				$replace = " "; 
				$arr=str_replace($find, $replace, $arr);  
				$find = array("\\");  
				$replace = "/"; 
				$arr=str_replace($find, $replace, $arr);  
			} 
			switch($act){
				case 'urlencode':
					 $arr=urlencode($arr); 
					break;
				case 'urldecode':
					 $arr=urldecode($arr); 
					break;
				default: 
					break;
			}   
		break;
	}
	return $arr;
}
function __childtree($father,$son,$level=0){//找孩子函数
	//var_dump($father);
		//echo "<br/>找：".$val['text'];
	$father['children']=array();
	foreach ($son as $k => $v) {
		if(intval($v['pid'])==intval($father['id'])){ 
			//echo "<br/>找到了：".$v['text'];
			$sons=__childtree($v,$son,$level+1);//递归，把一个系先全部找完。
			array_push($father['children'],$sons);
			unset($son[$k]);
		}
	}
	$father['slevel']=$level;
	return $father;
}
function childtree($son,$alone=false){//  
	$father=array();
	foreach ($son as $key => $val) {
		if(intval($val['pid'])==0){//获取第一代
			array_push($father, $val);
			unset($son[$key]); 
		}
	}
	foreach ($father as $key => $val) {
		$father[$key]=__childtree($val,$son,0);
	}
	if($alone){//保留没有父级的孤儿
		foreach ($son as $key => $val) { 
			array_push($father, $val); 
		}
	}
	return $father;
}
function __childrank($res,$father){
	array_push($res,$father);
	if(count($father['children'])){
		foreach ($father['children'] as $key => $val) {
			$res=__childrank($res,$val);
		}
	} 
	return $res;
}
function childrank($son,$alone=false){//返回级别
	$datas=childtree($son,$alone);
	 
	$res=array();
	foreach ($datas as $key => $val) { 
		$res=__childrank($res,$val); 
	}
	return $res;
}
function CURL_get($url){ 		
	$curl = curl_init(); // 启动一个CURL会话      
	curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                  
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT,15);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	// curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file); // 读取上面所储存的Cookie信息      
	curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环      
	curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容      
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回      
	$tmpInfo = curl_exec($curl); // 执行操作   
	if (curl_errno($curl)) {      
		return array("errcode"=>60,"msg"=>"CURL：".curl_error($ch));
	}else{
		 $arr = json_decode($tmpInfo,true);
		return $arr; // 返回数据   
	}   
}
function CURL_send($url,$data=array(),$timeout=20){
//发送curl，返回arr。debug为true，直接输出放回页面的输出信息
 	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type:text/html;charset=utf-8');	
	if(!empty($data)){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	// curl_setopt($ch, CURLOPT_SSLVERSION, 1);
	// if (defined('CURL_SSLVERSION_TLSv1')) {
	// 	curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
	// }
	 curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);
	$rs=curl_exec($ch);
	if(curl_errno($ch)){//出错则显示错误信息
       return array("errcode"=>60,"msg"=>"CURL：".curl_error($ch));
    }else{
		curl_close($ch);  

		$arr = json_decode($rs,true);    
	 	return $arr;
		 
	}
} 
function CURL_qr($url,$data=array()){ 		
	/*$curl = curl_init(); // 启动一个CURL会话      
	curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                  
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,15);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if(!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}    
	curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环      
	curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容      
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回      
	$res = curl_exec($curl); // 执行操作  
	 
	if (curl_errno($res)) {      
		return array("code"=>500,"error"=>"请求出错");     
	}else{
		curl_close($curl); 
		if(is_null(json_decode($res))){ 
			base64_encode($res);
			if(!(strpos($res, "data:image/jpeg;base64,")===false||strpos($res, "data:image/png;base64,"))===false){
				$res="data:image/png;base64,".;
			} 
			return array("errcode"=>0,"base64"=>$res);
		}else{

		  	$arr = json_decode($res,true);
		  	$arr['url']=$url;
		  	return $arr; // 返回数据 
		}
		  
	}   */
}

function CURL_image($url,$data,$format=false){
//发送curl，返回arr。debug为true，直接输出放回页面的输出信息
	$debug=false;	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type:image/png');	
	if(!empty($data)){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	 
	$rs=curl_exec($ch); 
	 
	if(curl_errno($ch)){//出错则显示错误信息 
        return array("errcode"=>curl_errno($ch),"res"=>$rs,"errmsg"=>"curl请求错误");
    }else{
		curl_close($ch);  
		if(is_null(json_decode($rs))){  

		 
			if($format){
				$res=base64_encode($rs);
				if(!(strpos($res, "data:image/jpeg;base64,")===false||strpos($res, "data:image/png;base64,"))===false){
					$res="data:image/jpeg;base64,".$res;
				}  
				return array("errcode"=>0,"base64"=>$res);
			}else{
				//header("Content-Type:image/jpeg");
				return $rs;
			}
			
		}else{
			curl_close($ch);
		  	$arr = json_decode($rs,true);
		  	$arr['url']=$url;
		  	return $arr; // 返回数据 
		}
		return 0;
	}
} 
function randChar($length){
	$str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$tmp="";
	for($i=0;$i<$length;$i++){
		$tmp.=$str[mt_rand(0,52)];
	}  
	return $tmp;
}
function randCharNumber($length){
	$str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$tmp="";
	for($i=0;$i<$length;$i++){
		$tmp.=$str[mt_rand(0,62)];
	}  
	return $tmp;
} 
//$array 要排序的数组
//$row  排序依据列
//$type 排序类型[asc or desc]
//return 排好序的数组
function Array_Sort($array,$row,$type){//二位数组排序
  $array_temp = array();
  foreach($array as $v){
  	if(intval($v[$row])){
  		$array_temp[intval($v[$row])] = $v;	
  	}else{
  		$array_temp[$v[$row]] = $v;	
  	}
    
  }
  if($type == 'asc'){
    ksort($array_temp);
  }elseif($type='desc'){
    krsort($array_temp);
  }
  $arr=array();
  foreach ($array_temp as $key => $val) {
  	array_push($arr, $val);
  }
  return $arr;
}
function matchweek($time){
	$week="0";
	if(intval($time)>10){
		$week=date("w",$time);
	}else{
		$week=$time;
	}
	switch ($week) {
	 	case '0':
	 		$w="日";
	 		break; 
	 	case '1':
	 		$w="一";
	 		break; 
	 	case '2':
	 		$w="二";
	 		break; 
	 	case '3':
	 		$w="三";
	 		break; 
	 	case '4':
	 		$w="四";
	 		break; 
	 	case '5':
	 		$w="五";
	 		break; 
	 	case '6':
	 		$w="六";
	 		break; 
	 	default:
	 		# code...
	 		break;
	 }
	 return $w;
}
//$array 返回一堆中的最低价
function getPriceLow($cases,$price0=0,$field="price"){//二位数组排序
  $price_min=99999999999;
  foreach($cases as $k=> $v){ 
	if(floatval($v[$field])<$price_min){
		$price_min=floatval($v[$field]);
	} 
    
  }
  if($price_min==99999999999){
  	$price_min=$price0;
  }
  
  return $price_min;
}
function formatDay30($starttime,$hf=false){
	$time=time();
	if(intval($starttime)<10000)$starttime=$time;
	
	$today=date("Y-m-d",$time); 
	$day30=array();
    for($i=0;$i<30;$i++){
    	$data=array(
    		"date"=>date("Y-m-d",$starttime),
    		"datetime"=>date("Y-m-d H:i:s",$starttime),
    		"day"=>date("m-d",$starttime),
    		"day_cn"=>date("m月d日",$starttime),
    		"timestamp"=>$starttime,
    		"week"=>matchweek($starttime)
    	);
    	array_push($day30, $data);
    	$starttime+=86400;
    } 

    if($hf){
    	//制作日历头部
		$firstday=intval($day30[0]['timestamp']);
		$weekday=date("w",$firstday);
		$header=array();
		if($weekday!=0){//第一天不是星期天
			for($i=$weekday;$i>0;$i--){
				$timestamp0=$firstday-86400*$i;
				$day=array(
					'timestamp'=>$timestamp0,
					'first'=>$firstday,
					'date'=>date("Y-m-d",$timestamp0),
					'day'=>date("m-d",$timestamp0),
					"week"=>matchweek($timestamp0),
					"day_cn"=>date("m月d日",$timestamp0),
				);
				array_push($header,$day);
			} 
		}
		//制作日历尾部
		$lasttday=intval($day30[count($day30)-1]['timestamp']);
		$weekday=date("w",$lasttday);
		$footer=array();
		if($weekday!=6){//第一天不是星期天
			for($i=$weekday+1;$i<=6;$i++){
				$timestamp0=$lasttday+86400*$i;
				$day=array(
					'timestamp'=>$timestamp0,
					'first'=>$lasttday,
					'date'=>date("Y-m-d",$timestamp0),
					'day'=>date("m-d",$timestamp0),
					"day_cn"=>date("m月d日",$timestamp0),
						"week"=>matchweek($timestamp0)
				);
				array_push($footer,$day);
			} 
		} 
		return array("header"=>$header,"data"=>$day30,"footer"=>$footer);
    }else{
    	return $day30;
    } 
}
//---------------------------------------------
 
/**
 * 电商Sign签名生成
 * @param data 内容   
 * @param appkey Appkey
 * @return DataSign签名
 */
function encrypt($data, $appkey) {
    return urlencode(base64_encode(md5($data.$appkey)));
}
/**
 * Json方式 查询订单物流轨迹
 */
function expressInfo($AppId,$AppKey, $ship,$logis){
	 
	$requestData= "{'OrderCode':'','ShipperCode':'".$ship."','LogisticCode':'".$logis."'}";
	 //$ReqURL='http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
	 $ReqURL='http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
	$datas = array(
        'EBusinessID' => intval($AppId),
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = encrypt($requestData, $AppKey);
	$result=CURL_send($ReqURL, $datas);	
	
	//根据公司业务处理返回的信息...... 
	return $result;
}
 

//---------------------------------------------

function getShopInfo($type='default'){
	global $_W,$_GPC;
	session_start(); 
	if(!empty($_SESSION['currentShop'])){
	 	return $_SESSION['currentShop'];
	}
	$model999=new Model("shop");
	$acc=$_W['username'];
	$uniacid=intval($_W['uniacid']);
	//$fields="id,name,uniacid,phone,sort,address,date,joindate,limitdate,status,logo,express_limit,express_default,express_defaultn";
	$shop=$model999->where("uniacid=$uniacid and account='$acc' ") ->get();
	if(intval($shop['uniacid'])<1){//没有任何店铺信息
		$shop=$model999->where("uniacid=$uniacid")->order("id asc")->get("*");
		if(empty($shop)){//
			$shop=array(
				"id"=>$_W['uniacid'],
				"uniacid"=>$_W['uniacid'], 
				"date"=>time(),
				"account"=>$_W['username'], 
				"status"=>1
			);
			$res=$model999->add($shop);
			if($res){
				$shop=$model999->where("uniacid=$uniacid and account='$acc'")->get("*");
			} 
		}
	}  
	$shop['express']=json_decode($shop['express'],true);
	$_SESSION['currentShop']=$shop;
	return $shop;
}
function getShopID(){
	$shop=getShopInfo();
	return intval($shop['id']);
}

//封装
class ZskPage extends WeModuleSite
{ 	
	function __construct(){
		//parent::__construct();
		global $_GPC;
		if(intval($_GPC['reloadShop'])>0){ 
			session_start();
			$_SESSION['currentShop']=null;
			unset($_SESSION['currentShop']); 
		} 
	}
	function createWebUrl($do,$param=array()){
		  
		 $module0=strlen($_GET['m'])>0?$_GET['m']:ZSK_MODULE;
		 $url0=url('site/entry/'.$do,array("m"=>$module0));
		 $url0.="&version_id=".intval($gets['version_id']);
		 if(count($param)){
		 	 foreach ($param as $key => $val) {
		 		$url0.="&$key=$val";
			 }
		 } 
		 return  $url0;
	}
	function routeUrl($route){
		return  routeUrl($route);
	}
	function model($name){
		$model = new Model($name);
		return $model;
	}
	function tablename($tab){
		$model = new Model($name);
		return $model->tablename($tab);
	}
	 
	 
}
class ZskWxapp extends WeModuleWxapp
{ 
	 
	function model($name){
		$model = new Model($name);
		return $model;
	}
	function tablename($tab){
		$model = new Model($name);
		return $model->tablename($tab);
	}
	function getShopByID($id,$clear=true){
		global $_W; 
		$uniacid=intval($_W['uniacid']);
		$model999=Model("shop");  
		$id=intval($id);
		$fields="*";
	 
		$shop=$model999->where("uniacid=$uniacid and id=$id")->get($fields);
		$shop['express']=json_decode($shop['express'],true);
		  
		return $shop;
	} 

}

function getGoodsSimpleInfo($goodslist){
 	$where="";
 	$namestr="";
 	foreach ($goodslist as $key => $val) {
		$gids.=$val['id'].",";
		$namestr.=$val['name'].",";
	}
	 
	
	if(strlen($gids)>1){
		$gids=substr($gids, 0,strlen($gids)-1);
		$where="goodsid in ($gids)";
	}else{
		foreach ($goodslist as $key => $val) {
			$gids.=$val['number'].",";
		}
		$where="number in ($gids)";
	}
	if(strlen($namestr)<2){
		$goodslist=Model("goods")->where($where)->group("id")->getall("id,number,name,price,price as pricelow,picture,picture_wide,status,sort,SUM(sellCount + sellCount0 ) AS sell");
	}
	$mod=Model("discount");
	$time=date("Y-m-d H:i:s",time());
	$where.=" and starttime<='".$time."' and stoptime>='".$time."'";
	$discs=$mod->where($where." and status>0 ")->getall("goodsid,tag,type");
	//var_dump($mod->lastSql());
	// $cases=Model("goodscase")->where("$where and status>0")->getall("id,price,status,isopt,goodsid");
	 
	foreach ($goodslist as $k => $v) {
		$pricelow=0;
		$goodslist[$k]['casejson']=json_decode($v['casejson'],true);
		// foreach($cases as $key=>$val){
		// 	if((intval($val['isopt'])==1&& intval($val['goodsid'])==intval($v['id']))&& intval($val['status'])>0){//有自定义规格
		// 		if($pricelow==0){
		// 			$pricelow=floatval($val['price']);
		// 		}else{
		// 			if(floatval($val['price'])<$pricelow){
		// 				$pricelow=floatval($val['price']);
		// 			} 
		// 		}
		// 	}
		// }
		
		foreach($discs as $key=>$val){
			$goods[$k]['discount_type']=$val['type'];
			if(intval($val['goodsid'])==intval($v['id'])){
				$goodslist[$k]['tag']=$val['tag'];
			 
			}
			
		} 
		// if(floatval($pricelow)==0){//默认价格
		// 	$pricelow=floatval($v['price']);
		// }
		// if(floatval($pricelow)>floatval($v['price'])){//默认价格
		// 	$pricelow=floatval($v['price']);
		// }
		$goodslist[$k]['pricelow']=floatval($v['price']);
	} 
	return $goodslist;
 }
 function getGoodsSimpleInfo_bak($goodslist){
 	$where="";
 	$namestr="";
 	foreach ($goodslist as $key => $val) {
		$gids.=$val['id'].",";
		$namestr.=$val['name'].",";
	}
	 
	
	if(strlen($gids)>1){
		$gids=substr($gids, 0,strlen($gids)-1);
		$where="goodsid in ($gids)";
	}else{
		foreach ($goodslist as $key => $val) {
			$gids.=$val['number'].",";
		}
		$where="number in ($gids)";
	}
	if(strlen($namestr)<2){
		$goodslist=Model("goods")->where($where)->group("id")->getall("id,number,name,price,picture,picture_wide,status,sort,SUM(sellCount + sellCount0 ) AS sell");
	}
	$mod=Model("discount");
	$discs=$mod->where($where." and status>0")->getall("goodsid,tag,type");
	$cases=Model("goodscase")->where("$where and status>0")->getall("id,price,status,isopt,goodsid");
	 
	foreach ($goodslist as $k => $v) {
		$pricelow=0;
		foreach($cases as $key=>$val){
			if((intval($val['isopt'])==1&&intval($val['goodsid'])==intval($v['id']))&&intval($val['status'])>0){//有自定义规格
				if($pricelow==0){
					$pricelow=floatval($val['price']);
				}else{
					if(floatval($val['price'])<$pricelow){
						$pricelow=floatval($val['price']);
					} 
				}
			}
		}
		
		foreach($discs as $key=>$val){
			$goods[$k]['discount_type']=$val['type'];
			if(intval($val['goodsid'])==intval($v['id'])){
				$goodslist[$k]['tag']=$val['tag'];
				$cases2=json_decode($val['casejson'],true); 
				$goodslist[$k]['casejson']=$cases2;
				foreach ($cases2 as $k2 => $v2) {
				 	if(floatval($v2['price'])<$pricelow){
						$pricelow=$v2['price'];
					} 
				} 
			}
			
		} 
		if(floatval($pricelow)==0){//默认价格
			$pricelow=floatval($v['price']);
		}
		$goodslist[$k]['pricelow']=floatval($pricelow);
	} 
	return $goodslist;
 }
 function getGoods($id,$idfield="id"){//'id/number'
 	global $_W;
 	$uniacid=intval($_W['uniacid']);
 	$model=Model("goods");
 	$goods=$model->where($idfield."=".$id." and uniacid=".$uniacid)->get("id,`number`,cateid,name,price,price0,sellCount,sellCount0,shopid,uniacid,sort,status,picture,picture_wide,video,opt1,opt2");
 	return $goods;
 }
 function getKanjiaGoodsInfo($goodslist){
 	$where=""; 
 	$timekanjia=time();
 	if(count($goodslist)<1)return [];
 	foreach ($goodslist as $key => $val) {
		$gids.="'".$val["goodsid"]."',";  
	} 
	if(strlen($gids)>1){
		$gids=substr($gids, 0,strlen($gids)-1);
		$where="goodsid in ($gids)";
	}  
	$model=Model("goodscase");
	$cases=$model->where("$where and status>0")->order("isopt asc")->getall("id,price,status,isopt,goodsid");
	 
	foreach ($goodslist as $k => $v) {
		$goodslist[$k]['stock_case']=0;
		$goodslist[$k]['stock_discount']=0;
		$goodslist[$k]['pricelow_case']=0;
		$goodslist[$k]['pricelow_discount']=0;
		$pricelow=0;
		if(gettype($v['casejson'])=="string"){
			$goodslist[$k]['casejson']=$v['casejson']=json_decode($v['casejson'],true);
		}
		$price0=0; $stock0=0; 
		foreach($cases as $key=>$val){
			if($val['goodsid']==$v["goodsid"]){
				$goodslist[$k]['goodscases'][]=$val;
				 
				if($goodslist[$k]['pricelow_case']==0){
					$goodslist[$k]['pricelow_case']=floatval($val['price']);
					$stock0=$val['stock'];
					$price0=$val['price'];
				}else{ 
					if(floatval($val['price'])<$goodslist[$k]['pricelow_case']){
						$goodslist[$k]['pricelow_case']=floatval($val['price']);
						$goodslist[$k]['stock_discount']+=floatval($val['stock']);
					} 
				} 
			} 
		}  
		if(count($goodslist[$k]['goodscases'])==1){
			$goodslist[$k]['stock_discount']=$stock0;
			$goodslist[$k]['pricelow_discount']=$price0;
		}
		$goodslist[$k]['pricelow_discount']=floatval($goodslist[$k]['pricelow_case'])-floatval($v['price_kanjia']);
		if($goodslist[$k]['pricelow_discount']<0){$goodslist[$k]['pricelow_discount']=0;}
		$kanjiastarttime=strtotime($goodslist[$k]['starttime']);
		$kanjiastoptime=strtotime($goodslist[$k]['stoptime']);
		if($timekanjia>=$kanjiastarttime&&$timekanjia<=$kanjiastoptime){
			$goodslist[$k]['is_stop']=0;
		}
		else{
			if($timekanjia<$kanjiastarttime){
				$goodslist[$k]['is_stop']=2;
			}
			if($timekanjia>$kanjiastoptime){
				$goodslist[$k]['is_stop']=3;
			}
		}
	}  
	return $goodslist;
 }
 //获取活动商品的商品名称
  function getDiscountGoodsInfo($goodslist,$idfield="id"){//$idfield="id/goodsid"
 	$where=""; 
 	foreach ($goodslist as $key => $val) {
		$gids.="'".$val[$idfield]."',";  
	} 
	if(strlen($gids)>1){
		$gids=substr($gids, 0,strlen($gids)-1);
		$where="goodsid in ($gids)";
	}  
	$model=Model("goodscase");
	$cases=$model->where("$where and status>0")->getall("id,price,status,isopt,goodsid");
	 
	foreach ($goodslist as $k => $v) {
		$goodslist[$k]['stock_case']=0;
		$goodslist[$k]['stock_discount']=0;
		$goodslist[$k]['pricelow_case']=0;
		$goodslist[$k]['pricelow_discount']=0;
		$pricelow=0;
		if(gettype($v['casejson'])=="string"){
			$goodslist[$k]['casejson']=$v['casejson']=json_decode($v['casejson'],true);
		}

		foreach($cases as $key=>$val){
			if($val['goodsid']==$v[$idfield]){
				$goodslist[$k]['stock_case']+=intval($val['stock']);
				if($goodslist[$k]['pricelow_case']==0){
					$goodslist[$k]['pricelow_case']=floatval($val['price']);
				}else{
					if(floatval($val['price'])<$goodslist[$k]['pricelow_case']){
						$goodslist[$k]['pricelow_case']=floatval($val['price']);
					} 
				} 
			} 
		} 
		foreach($v['casejson'] as $key2=>$val2){
			$goodslist[$k]['stock_discount']+=intval($val2['stock']);
			if($goodslist[$k]['pricelow_discount']==0){
				$goodslist[$k]['pricelow_discount']=floatval($val2['price']);
			}else{
				if(floatval($val2['price'])<$goodslist[$k]['pricelow_discount'])
					$goodslist[$k]['pricelow_discount']=floatval($val2['price']);
			}
			
		}   
	}  
	return $goodslist;
 }
 //获取未过期且正常的店铺
 function getShops($list=array(),$field="shopid"){
 	global $_W;
 	$uniacid=intval($_W['uniacid']);
 	$date=date("Y-m-d",time());
 	$where.="uniacid=".$uniacid." and  ( limitdate>='".$date."' or limitdate is null)";
 	if(count($list)){
 		$ids=array();
 		foreach ($list as $key => $val) {
 			array_push($ids, intval($val[$field]));
 		}
 		$idstr=implode(",",array_unique($ids)); 
 		 
 		$where.=" and id in (".$idstr.")";
 	} 
 	$m2=Model("shop");
	$shops=$m2->where($where)->order("sort desc")->getall("DISTINCT id,uniacid,name,address,phone,latitude,longitude,logo,joindate,limitdate,status,sort,isdefault");
 	 
	return $shops;
 }
 function remove_shop_account($uid){
 	global $_W,$_GPC;
 	$model = Model("shop");
 	$uniacid = $_W['uniacid'];
 	$sql = "DELETE FROM ims_users_permission WHERE uid=$uid and uniacid = $uniacid";
 	$model->query($sql);
 	$sql = "DELETE FROM ims_uni_account_users WHERE uid=$uid and uniacid=$uniacid";
 	$model->query($sql);
 	// pdo_delete("users_permission",array("uid"=>$uid,"uniacid"=>intval($_W['uniacid'])));
 	// pdo_delete("uni_account_users",array("uid"=>$uid,"uniacid"=>intval($_W['uniacid']))); 
 }
 function regist_shop_account($endtime=null){
 	//注册一个店铺微擎店员账号
 	global $_W,$_GPC;
 	$uid = intval($_GPC['uid']);
 	$user = user_single($uid);
	if (!empty($uid)) {
		$have_permission = permission_account_user_menu($uid, $_W['uniacid'], ZSK_MODULE);
		if (is_error($have_permission)) {
			message($have_permission['message']);
		}
	} 
	$insert_user = array(
		'username' => trim($_GPC['username']),
		'remark' => trim($_GPC['remark']),
		'password' => trim($_GPC['password']),
		'repassword' => trim($_GPC['password']),
		'type' => 2
	);
	if (empty($insert_user['username'])) {
		message('必须输入用户名，格式为 1-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
	} 
	$operator = array(); 
	if (user_check(array('username' => $insert_user['username']))) {
		message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
	}
	if (empty($insert_user['password']) || istrlen($insert_user['password']) < 8) {
		message('必须输入密码，且密码长度不得低于8位。');
	}
	if ($insert_user['repassword'] != $insert_user['password']) {
		message('两次输入密码不一致');
	}
	unset($insert_user['repassword']);
	$uid = user_register($insert_user);
	if (!$uid) {
		message('注册账号失败', '', '');
	}
	Model("acount")->where('uid='.$uid)->add(['uid'=>$uid,'uniacid'=>$_W['uniacid'],'judge'=>0]);
	update_shop_account($uid,$endtime);
 	return $uid;
	
 }

 function update_shop_account($uid,$limittime){
 	//赋予一个现有账号小程序权限，并更新账号有效时间
 	global $_W,$_GPC;
 	user_update(array("uid"=>$uid,"endtime"=>$limittime));
	$permission = $_GPC['module_permission'];
	if (!empty($permission) && is_array($permission)) {
		$permission = implode('|', array_unique($permission));
	} else {
		$permission = 'all';
	}
	$model = Model('shop');
	$uniacid = $_W['uniacid'];
	$zsk_market = ZSK_MODULE;
	if (empty($have_permission)) {
		$sql = "INSERT INTO ims_users_permission (uniacid,uid,type,permission) VALUES($uniacid,$uid,'$zsk_market','$permission')";
		$model->query($sql);
	} else {
		$sql = "UPDATE ims_users_permission SET permission=$permission WHERE uniacid=$uniacid and uid=$uid and type='$zsk_market'";
		$model->query($sql);
	} 
	
	$role = permission_account_user_role($uid, $_W['uniacid']);
	if (empty($role)) {
		$sql = "INSERT INTO ims_uni_account_users (uniacid,uid,role) values($uniacid,$uid,'operator')";
		$model->query($sql);
	} else {
		$sql = "UPDATE SET ims_uni_account_users role='operator' WHERE unaicid=$uniacid and uid = $uid";
		$model->query($sql);
	}  
	Model("acount")->where('uid='.$uid)->save(['judge'=>0]); 
 }
/**
 *  数据导入
 * @param string $file excel文件
 * @param string $sheet
 * @return string   返回解析数据
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 */

function importExecl($file='', $sheet=0){
    $file = iconv("utf-8", "gb2312", $file);   //转码
    if(empty($file) OR !file_exists($file)) {
        die('file not exists!');
    }
    include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel.php');
    include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
    $objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象
    if(!$objRead->canRead($file)){
        $objRead = new PHPExcel_Reader_Excel5();
        if(!$objRead->canRead($file)){
            die('No Excel!');
        }
    }

    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
    $obj = $objRead->load($file);  //建立excel对象
    $currSheet = $obj->getSheet($sheet);   //获取指定的sheet表
    $columnH = $currSheet->getHighestColumn();   //取得最大的列号
    $columnCnt = array_search($columnH, $cellName);
    $rowCnt = $currSheet->getHighestRow();   //获取总行数
    $data = array();
    for($_row=1; $_row<=$rowCnt; $_row++){  //读取内容
        for($_column=0; $_column<=$columnCnt; $_column++){
            $cellId = $cellName[$_column].$_row;
            $cellValue = $currSheet->getCell($cellId)->getValue();
            //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值
            if($cellValue instanceof PHPExcel_RichText){   //富文本转换字符串
                $cellValue = $cellValue->__toString();
            }
            $data[$_row][$cellName[$_column]] = $cellValue;
        }
    }
    return $data;
}

/**
 * @param $list
 * @param $filename
 * @param $indexKey
 * @param int $startRow
 * @param bool $excel2007
 * @return bool
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Writer_Exception
 * 导出excel
 */
function toExcel($list,$filename,$indexKey,$startRow=1,$excel2007=false){
    //文件引入
    // echo $pe['host_root'].'include/class/PHPExcel.php';die;
    include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel.php');
    include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
    // require("/include/class/PHPExcel.php");
    // include("/include/class/PHPExcel/Writer/Excel2007.php");
    ob_end_clean();
    if(empty($filename)) $filename = time();
    if( !is_array($indexKey)) return false;

    $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    //初始化PHPExcel()
    $objPHPExcel = new PHPExcel();

    //设置保存版本格式
    if($excel2007){
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $filename = $filename.'.xlsx';
    }else{
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $filename = $filename.'.xls';
    }

    //接下来就是写数据到表格里面去
    $objActSheet = $objPHPExcel->getActiveSheet();
    //$startRow = 1;
    foreach ($list as $row) {
        foreach ($indexKey as $key => $value){
            //这里是设置单元格的内容
            $objActSheet->setCellValue($header_arr[$key].$startRow,$row[$value]);
        }
        $startRow++;
    }

    // 下载这个表格，在浏览器输出
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");;
    header('Content-Disposition:attachment;filename='.$filename.'');
    header("Content-Transfer-Encoding:binary");
    $objWriter->save('php://output');
}


/**
 * @param string $id 图片ID 方便获取图片的SRC
 * @param string $name  点击上传ID
 * @param null $url 上传图片地址
 * @param null $route  路径
 * @param null $imgUrl  图片名称
 *singleImage
 */
function singleImage($id = 'demo1', $name = 'test1', $url = null, $route = ZSK_STATIC, $imgUrl = '/images/diel.png'){
    $us =   '
            <button type="button" class="layui-btn dileo" style="margin-left: 2%;width: 120px;" id="'.$name.'">上传图片</button>
            <input type="hidden" name="'.$name.'" value="'.$imgUrl.'"/>
            <div class="layui-input-block dile">
                <img class="layui-upload-img  img-name"  id="'.$id.'" src="'.$route.$imgUrl.'" style="width: 115px;height: 100px;margin-top: 5px;">
                <p id="demoText"></p>
            </div>
            <script type="text/javascript" src="../addons/zsk_market/static/layui/layui.all.js"></script>
            <script type="text/javascript">
            layui.use([\'form\', \'layedit\', \'upload\',\'laydate\',\'element\'], function() {
                var form = layui.form,
                    layer = layui.layer,
                    upload = layui.upload,
                    layedit = layui.layedit,
                    element = layui.element;
                form.render();
                form.on(\'checkbox(vtl)\', function (data) {
                    var a = data.elem.checked;
                    console.log(data);
                    if (a == true) {
                        $(".itus").prop("checked", true);
                        form.render(\'checkbox\');
                    } else {
                        $(".itus").prop("checked", false);
                        form.render(\'checkbox\');
                    }
                })
        
                var uploadInst = upload.render({
                    elem: "#'.$name.'",
                    url: "'.$url.'",
                    accept: \'images\',
                    number:1,           //控制每一次上传图片的数量
                    method: \'post\' ,    //可选项。HTTP类型，默认post
                    multiple: true,
                    before: function(obj){
                        //预读本地文件示例，不支持ie8
                        obj.preview(function(index, file, result){
                            $(".img-name").attr(\'src\', result); //图片链接（base64）
                        });
                    },
                    
                    done: function(res){
                        if(res.code == true){
                            var demoText = $(\'#demoText\');
                            demoText.html(\'<span style="color: #FF5722;">上传成功</span>\');
                            $("input[name='.$name.']").val(res.data);
                        }else{
                            layer.msg(res.msg);
                        }
                        
                    },
                    error: function(){
                        //演示失败状态，并实现重传
                        var demoText = $(\'#demoText\');
                        demoText.html(\'<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>\');
                        demoText.find(\'.demo-reload\').on(\'click\', function(){
                            uploadInst.upload();
                        });
                    }
                });
            })
            </script>';
    echo $us;
}

    /**
     * @return mixed
     * 判断提交方式 POST 或者 GET
     */

    function is_mode(){
        return $_SERVER['REQUEST_METHOD'];
    }

/**
 * @param $string 字符串安全过滤
 * @return array|string 传入的是数组
 */
function add_slashes($string) {
    if (is_array($string)) {
        foreach ($string as $key => $value) {
            $string[$key] = add_slashes($value);
        }
    } else {
        $string = addslashes($string);
    }
    return $string;
}



//php防注入函数,字符过滤函数
//解码
function htmldecode($str)
{
    if(empty($str)) return;
    if($str=="") return $str;
    $str=str_replace("select","select",$str);
    $str=str_replace("join","join",$str);
    $str=str_replace("union","union",$str);
    $str=str_replace("where","where",$str);
    $str=str_replace("insert","insert",$str);
    $str=str_replace("delete","delete",$str);
    $str=str_replace("update","update",$str);
    $str=str_replace("like","like",$str);
    $str=str_replace("drop","drop",$str);
    $str=str_replace("create","create",$str);
    $str=str_replace("modify","modify",$str);
    $str=str_replace("rename","rename",$str);
    $str=str_replace("alter","alter",$str);
    $str=str_replace("cas","cast",$str);
    $str=str_replace("&","&",$str);
    $str=str_replace(">",">",$str);
    $str=str_replace("<","<",$str);
    $str=str_replace(" ",chr(32),$str);
    $str=str_replace(" ",chr(9),$str);
    // $str=str_replace("    ",chr(9),$str);
    $str=str_replace("&",chr(34),$str);
    $str=str_replace("'",chr(39),$str);
    $str=str_replace("<br />",chr(13),$str);
    $str=str_replace("''","'",$str);
    return $str;
}

/**
 * @param string $url
 * @param array $post_data
 * @return bool|string
 */
function request_post($url = '', $post_data=null) {
    if (empty($url) || empty($post_data)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $post_data;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return $data;
}
/**
 * 图片上传
 * @param         $name input字段名
 * @param string  $value input值  单图时为字符串多图时为数组
 * @param string  $fileNumLimit 1为单图上传 不填为多图上传
 * @param string  $default 默认图片路径为 statics/  开始
 * @return string
 */
function tpl_form_field_images($name, $value = '',$fileNumLimit="",$default="",$options = array()) {
	global $_W,$_GPC;
//     $url = $_SERVER['REQUEST_URI'];
//     $getpath = "/";
//     $fileNumLimit=1;
//     if(strpos($url,"addons")!==false){
//         $getpath = substr($_SERVER['REQUEST_URI'],0,stripos($_SERVER['REQUEST_URI'],"index.php"));
//     }
    if($default){
        $default = $getpath.$default;
    }else{
        $default = ZSK_STATIC.'images/nopic.jpg';
    }
//     if(empty($fileNumLimit)){
//         $fileNumLimit = "300";

//     }else{
//         $fileNumLimit = "1";
//     }
//     if(empty($value)){//判断是否有图片
//         $multiple_img = "1";
//     }
    if(is_array($value)){
        $filenum = count($value);
    }   
    // $val = $default;
    // if (!empty($value)) {
    //     $val = $value;
    // }
    // $difference = rand("100","999");
    // $s  = '<link rel="stylesheet" type="text/css" href="'.ZSK_STATIC.'uploadpicture/css/upload.css"/>';
    // $s .= '<link rel="stylesheet" type="text/css" href="'.ZSK_STATIC.'uploadpicture/css/style.css"/>';
    $s .='<link rel="stylesheet" type="text/css" href="'.ZSK_STATIC.'uploadpicture/css/webuploader.css"/>';
    $s .='<script src="'.ZSK_STATIC.'uploadpicture/js/webuploader.js"></script>';
    $s .='<script src="'.ZSK_STATIC.'uploadpicture/js/unlink.js"></script>';
//     $s .='<div class="modal fade" id="myimgModal'.$difference.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
//     <div class="modal-dialog" style="width:690px;">
//         <div class="modal-content">
//             <div class="modal-header">
//                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
//                     &times;
//                 </button>
//                 <h4 class="modal-title" id="myModalLabel">
//                     图片上传
//                 </h4>
//             </div>
//             <div class="modal-body modal-body'.$difference.'" style="padding:0px"></div>
//         </div><!-- /.modal-content -->
//     </div><!-- /.modal -->
// </div>
// 		';
//     $s .='<input type="hidden" value="'.$fileNumLimit.'" class="fileNumLimit'.$difference.'">';
if($fileNumLimit>1){//多图上传
    $s .='
        <div class="input-group" '.$options['extras']['colm'].'>
            <input type="text" class="form-control" readonly="readonly" placeholder="批量上传图片" onclick="public_imgclick()" autocomplete="off">
            <span class="input-group-btn">
                <input hidden value="'.$difference.'">
                <button class="btn btn-default myimgModal'.$difference.' '.$options['extras']['bootstrap'].'" type="button" data-toggle="modal" data-target="#myimgModal'.$difference.'" onclick="public_imgclick(\''.$name.'\',\''.$fileNumLimit.'\');">选择图片</button>
            </span>
        </div>
        <div class="input-group" style="margin-top:.5em;"></div>
        <div class="input-group multi-img-details'.$name.'">';
if($filenum>=1){
    for($i=0;$i<$filenum;$i++){
        $s.='<div class="multi-item" style="float:left;margin-right:3px">
            <img src="' .$_W['attachurl']. $value[$i] . '" onerror="this.src=\'' . $default . '\'; this.title="\'图片未找到.\'" class="img-responsive img-thumbnail" width="150" />
            <input type="hidden" name="' . $name . '[]" value="' . $value[$i] . '">
            <em class="close" title="删除这张图片" onclick="deleteImagemore(this)">×</em>
        </div>';
     }
}else{
	// $s.='<div class="multi-item" style="float:left;margin-right:3px">
 //            <img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title="\'图片未找到.\'" class="img-responsive img-thumbnail" width="150" />
 //            <input type="hidden" name="' . $name . '[]" value="' . $value . '">
 //            <em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
 //        </div>';
}
    $s.='</div>';
}else{//单图上传
     $s .= '
		<div class="input-group" '.$options['extras']['first'].'>
			<input type="text" id="' . $name . '" name="' . $name . '" value="' . $value . '" '.$options['extras']['inputstyle'].' class="form-control public-single-img'.$difference.'" autocomplete="off">
			<span class="input-group-btn">
                <input hidden value="'.$difference.'">
				<button class="btn btn-default " type="button" style="'.$options['button']['style'].'"  onclick="public_imgclick(\''.$name.'\',\''.$fileNumLimit.'\');">选择图片</button>
			</span>
		</div>
         <div class="input-group" style="margin-top:.5em;">
            <img src="'.$_W['attachurl']. $value . '"  name="' . $name . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail mult-figure-img'.$name.'" width="150" />
            <em '.$options['extras']['em'].' class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
       </div>
        ';
   }
        $s .= '
		<div we7-resource-image-dialog class="uploader-modal modal fade image ng-scope ng-isolate-scope in" id="materialModalr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;overflow-x:hidden;overflow-y:scroll">
		<div class="modal-dialog modal-lg ng-scope" ng-controller="we7resource-image-controller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="public_imgclickclose()">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel1">图片</h4>
			</div>
			<div class="modal-body material-content clearfix">
				<div class="material-nav">
					
					 <a href="javascript:;" ng-click="setIndex(1)" ng-show="showLocal()"  class="active">本地服务器</a>
					 
					</div>
					<div class="material-head" style="height:55px">
					
						<div class="input-group filter">
							
						
						<span class="input-group-btn pull-left" ng-show="index==1" ng-click="search()">
							
						</span>
					</div>
					<div class="pull-right btn-uploader form-inline" style="z-index: 10" ng-show="index<2">
						<div onclick="deleteMultiImage()" class="btn btn-danger" style="float:left;border-radius:0px;padding:3px 20px">删除</div>
							 <we7-uploader-btn upload-url="uploadurl" on-uploaded="public_imgclick()" on-upload-error="uploaderror(mes)" multiple="" name="uploadname" accept="accept" class="ng-isolate-scope" style="float:left;margin-left:15px">
							   <div id="picker" >选择文件</div>
							 </we7-uploader-btn>
							</div>
						
					</div>
					<div id="image" class="material-body" >
						<div >
							<div class="category">
								<div class="add">
									<a onclick="public_upload_addgroup();" class="color-default">
										<i class="glyphicon glyphicon-plus-sign"></i>添加分组
									</a>
								</div>
								<div class="category-menu panel-group" id="category-menu" role="tablist" aria-multiselectable="true">
									<ul>
										<li onclick="public_upload_classification(this,0)"  class="active">
											<div class="name">
												<i class="wi wi-file"></i>全部
											</div>
											<a class="edit"></a>
										</li>
										<li ng-repeat="(key, value) in groups | filter : {deleted : false}"  class="ng-scope category-menu-group" style="background-color:#F4F5F9 " >
											<div class="name ng-binding ct-groupchild" onclick="public_upload_classification(this)">
												<span class="wi wi-file"></span>
												<span class="namecaty">未命名</span>
												<input type="text"  value="未命名" style="display:none;height:25px" onBlur="public_upload_doaddgroup(this)"> 
												<span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doDeletGroup(this)">
													<i class="glyphicon glyphicon-trash" style="line-height:44px"></i>
												</span> 
												<span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doEditGroup(this)">
													<i class="glyphicon glyphicon-cog" style="line-height:44px"></i>
												</span>
											</div>
											<div class="edit" >
												<a class="color-default" ng-show="!value.editing" ng-click="editing(value)">
													<i class="wi wi-text"></i>编辑
												</a> 
												<a class="color-red" ng-show="!value.editing" ng-click="delGroup(value)">
													<i class="wi wi-delete2"></i>删除
												</a>
												 <a class="color-default ng-hide" ng-show="value.editing" ng-click="edited(value)">
												 	<i class="wi wi-right-sign">确定</i>
												 </a> 
												 <a class="color-default ng-hide" ng-show="value.editing" ng-click="cancelEditing(value)">
												 	<i class="wi wi-error-sign"></i>取消
												 </a>
											</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="we7-form form-inline selected-all">
									<input type="checkbox" id="selected-all" ng-model="selectedAllImage" onclick="public_upload_selected(this)" class="ng-pristine ng-untouched ng-valid ng-empty">
									<label for="selected-all">全选</label>
								</div>
								<div class="img-container we7-flex">
								</div>
							</div>
						</div>
						<div class="material-pager text-right ng-binding" ng-bind-html="pager" ng-show="index!=2">
						   <div>
						   <ul class="pagination pagination-centered">
						   <li><a href="javascript:;" page="1" class="pager-nav">首页</a></li>
						   <li><a href="javascript:;" page="1" class="pager-nav">«上一页</a></li>
						   <li class="active"><a href="javascript:;" page="1">1</a></li>
						   <li><a href="javascript:;" page="2">2</a></li>
						   <li><a href="javascript:;" page="3">3</a></li>
						   <li><a href="javascript:;" page="2" class="pager-nav">下一页»</a></li>
						   <li><a href="javascript:;" page="3" class="pager-nav">尾页</a></li>
						   </ul>
						   </div>
								
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" onclick="public_upload_success()">确定</button>
							 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="public_imgclickclose()">取消</button>
							</div>
						</div>
					</div>
					</div>
				</div>';
  
    $s .='<script src="'.ZSK_STATIC.'uploadpicture/js/upload.js"></script>';
    return $s;
    
}
/**
    * @param $apikey https://www.yunpian.com登录官网后获取
    */
    function getuser($apikey){
        header("Content-Type:text/html;charset=utf-8");
        $ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 取得用户信息
        $json_data = get_user($ch,$apikey);
        $array = json_decode($json_data,true);
        return $array;
    }
    /**
     * @param $apikey https://www.yunpian.com登录官网后获取
     * @param $signature 签名 单条必填
     * @param $text string 发送的内容
     * @param $mobile string  注:发送多个手机号请以逗号分隔，一次不要超过1000个
     * @param $type Boolean true为单条 false 为群发
     * @param $template boolean true 非模板 false 模板
     * @param $data array  $template 为false时必填
     * @param $data['tpl_id'] array 模板id $template 为false时必填
     * @param $data['name'] array 姓名 $template 为false时必填
     * @param $data['code'] array 发送信息 $template 为false时必填
     * @return 
     */
    if (!function_exists('sendsms')) {
    function sendsms($apikey, $signature="",$text="感谢您关注公众号", $mobile="18708323516",$type=true,$template=true,$data=array()){
        header("Content-Type:text/html;charset=utf-8");
        $ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $text="【".$signature."】".$text;
        // $apikey = "13b6b1245537cef4c487ed94e50f1463"; 
        if($type==true){
            // 发送单条
            if($template==true){
                $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
                $json_data = send($ch,$data);
                $array = json_decode($json_data,true);
            }else{
            	// 发送模板短信
                // 需要对value进行编码
            	$tpdata = "";
            	$count = count($data)-1;
            	foreach ($data as $k=>$v){
            		if ($k!="tpl_id") {
            			$i++;
            			$tpdata .= ('#'.$k.'#')."=".urlencode("".$v."");
            			if($i!=$count){
            				$tpdata .= "&";
            			}
            		}
            	}
            	$data = array('tpl_id' => $data['tpl_id'], 'tpl_value' => $tpdata, 'apikey' => $apikey, 'mobile' => $mobile);
                $json_data = tpl_send($ch,$data);
                $array = json_decode($json_data,true);
            }
            return $array;
        }else{
        //群发短信
            if($template==true){
                //非模板
                $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
                $json_data = batch_send($ch,$data);
                $array = json_decode($json_data,true);
            }else{
            	// 发送模板短信
                // 需要对value进行编码
            	$tpdata = "";
            	$count = count($data)-1;
            	foreach ($data as $k=>$v){
            		if ($k!="tpl_id") {
            			$i++;
            			$tpdata .= ('#'.$k.'#')."=".urlencode("".$v."");
            			if($i!=$count){
            				$tpdata .= "&";
            			}
            		}
            	}
            	$data = array('tpl_id' => $data['tpl_id'], 'tpl_value' => $tpdata, 'apikey' => $apikey, 'mobile' => $mobile);
                $json_data =tpl_batch_send($ch,$data);
                $array = json_decode($json_data,true);
            }
            return $array;
        }
    }
    }
    /************************************************************************************/
    //获得账户
    function get_user($ch,$apikey){
        curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    // 添加模板
    function add_tpl($ch,$apikey,$tpl_content){
    	curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/tpl/add.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey,"tpl_content"=>$tpl_content)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    // 修改模板
    function edit_tpl($ch,$apikey,$tpl_id,$tpl_content){
    	curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/tpl/update.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey,"tpl_id"=>$tpl_id,"tpl_content"=>$tpl_content)));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    //发送单条短信
    function send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    //执行发送模板短信单条
    function tpl_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    //执行发送模板短信群发
    function tpl_batch_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/sms/tpl_batch_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    //群发短信
    function batch_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL,'https://sms.yunpian.com/v2/sms/batch_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);
        checkErr($result,$error);
        return $result;
    }
    function checkErr($result,$error) {
        if($result === false)
        {
            echo 'Curl error: ' . $error;
        }
        else
        {
            //echo '操作完成没有任何错误';
        }
    }

function tpl_form_field_images1($name, $value = '',$fileNumLimit="",$default="",$options = array()) {
    if($default){
       // $default = $getpath.$default;
    }else{
        $default = ZSK_STATIC.'images/nopic.jpg';
    }
    
    $s .='<link rel="stylesheet" type="text/css" href="'.ZSK_STATIC.'uploadpicture/css/webuploader.css"/>';
    $s .='<script src="'.ZSK_STATIC.'uploadpicture/js/webuploader.js"></script>';
    $s .='<script src="'.ZSK_STATIC.'uploadpicture/js/unlink.js"></script>';
  //   $s .= '
		// <div class="input-group" >
		// 	<input   hidden id="' . $name . '" name="' . $name . '" value="' . $value . '">
		// </div>
  //       ';
  $s .= '
		<div we7-resource-image-dialog class="uploader-modal modal fade image ng-scope ng-isolate-scope in" id="materialModalr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;overflow-x:hidden;overflow-y:scroll">
		<div class="modal-dialog modal-lg ng-scope" ng-controller="we7resource-image-controller">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="public_imgclickclose()">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel1">图片</h4>
			</div>
			<div class="modal-body material-content clearfix">
				<div class="material-nav">
					
					 <a href="javascript:;" ng-click="setIndex(1)" ng-show="showLocal()"  class="active">本地服务器</a>
					 
					</div>
					<div class="material-head" style="height:55px">
					
						<div class="input-group filter">
							
						
						<span class="input-group-btn pull-left" ng-show="index==1" ng-click="search()">
							
						</span>
					</div>
					<div class="pull-right btn-uploader form-inline" style="z-index: 10" ng-show="index<2">
						<div onclick="deleteMultiImage()" class="btn btn-danger" style="float:left;border-radius:0px;padding:3px 20px">删除</div>
							 <we7-uploader-btn upload-url="uploadurl" on-uploaded="public_imgclick()" on-upload-error="uploaderror(mes)" multiple="" name="uploadname" accept="accept" class="ng-isolate-scope" style="float:left;margin-left:15px">
							   <div id="picker" >选择文件</div>
							 </we7-uploader-btn>
							</div>
						
					</div>
					<div id="image" class="material-body" >
						<div >
							<div class="category">
								<div class="add">
									<a onclick="public_upload_addgroup();" class="color-default">
										<i class="glyphicon glyphicon-plus-sign"></i>添加分组
									</a>
								</div>
								<div class="category-menu panel-group" id="category-menu" role="tablist" aria-multiselectable="true">
									<ul>
										<li onclick="public_upload_classification(this,0)"  class="active">
											<div class="name">
												<i class="wi wi-file"></i>全部
											</div>
											<a class="edit"></a>
										</li>
										<li ng-repeat="(key, value) in groups | filter : {deleted : false}"  class="ng-scope category-menu-group" style="background-color:#F4F5F9 " >
											<div class="name ng-binding ct-groupchild" onclick="public_upload_classification(this)">
												<span class="wi wi-file"></span>
												<span class="namecaty">未命名</span>
												<input type="text"  value="未命名" style="display:none;height:25px" onBlur="public_upload_doaddgroup(this)"> 
												<span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doDeletGroup(this)">
													<i class="glyphicon glyphicon-trash" style="line-height:44px"></i>
												</span> 
												<span class="setting" v-show="!value.editable &amp;&amp; !value.editing" onclick="doEditGroup(this)">
													<i class="glyphicon glyphicon-cog" style="line-height:44px"></i>
												</span>
											</div>
											<div class="edit" >
												<a class="color-default" ng-show="!value.editing" ng-click="editing(value)">
													<i class="wi wi-text"></i>编辑
												</a> 
												<a class="color-red" ng-show="!value.editing" ng-click="delGroup(value)">
													<i class="wi wi-delete2"></i>删除
												</a>
												 <a class="color-default ng-hide" ng-show="value.editing" ng-click="edited(value)">
												 	<i class="wi wi-right-sign">确定</i>
												 </a> 
												 <a class="color-default ng-hide" ng-show="value.editing" ng-click="cancelEditing(value)">
												 	<i class="wi wi-error-sign"></i>取消
												 </a>
											</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="we7-form form-inline selected-all">
									<input type="checkbox" id="selected-all" ng-model="selectedAllImage" onclick="public_upload_selected(this)" class="ng-pristine ng-untouched ng-valid ng-empty">
									<label for="selected-all">全选</label>
								</div>
								<div class="img-container we7-flex">
								</div>
							</div>
						</div>
						<div class="material-pager text-right ng-binding" ng-bind-html="pager" ng-show="index!=2">
						   <div>
						   <ul class="pagination pagination-centered">
						   <li><a href="javascript:;" page="1" class="pager-nav">首页</a></li>
						   <li><a href="javascript:;" page="1" class="pager-nav">«上一页</a></li>
						   <li class="active"><a href="javascript:;" page="1">1</a></li>
						   <li><a href="javascript:;" page="2">2</a></li>
						   <li><a href="javascript:;" page="3">3</a></li>
						   <li><a href="javascript:;" page="2" class="pager-nav">下一页»</a></li>
						   <li><a href="javascript:;" page="3" class="pager-nav">尾页</a></li>
						   </ul>
						   </div>
								
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary pbpicturesc" onclick="public_upload_success()">确定</button>
							 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="public_imgclickclose()">取消</button>
							</div>
						</div>
					</div>
					</div>
				</div>';
    $s .='<script src="'.ZSK_STATIC.'uploadpicture/js/upload.js"></script>';
    return $s;

}
