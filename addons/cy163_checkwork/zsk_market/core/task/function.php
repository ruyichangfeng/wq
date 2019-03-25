<?php    
function Model($name) {
	$model = new Model($name);
	return $model;
}  
function plog($log){ 
	if(IN_DEBUG==true){
		if(gettype($log)!="string"){
			var_dump($log);
		}else{
			echo "\r\n$log\r\n";
		}
	}
}
function getSetting($type="default",$fresh=false){
	global $_W,$_GPC;
	$uniacid=intval($_W['uniacid']);
	//存储session，减少数据库查询次数
	 
	 
	$fields="*"; 
	$model999=new Model("setting"); 
	$uniacid=intval($_W['uniacid']);
	
	$setting=$model999->where("uniacid=$uniacid")->get($fields); 
	$setting['wx_conf']=json_decode($setting['wx_conf'],true);	 
	$setting['wxapp_layout']=json_decode($setting['wxapp_layout'],true); 
	if(intval($setting['uniacid'])<1){//没有任何信息 
		$setting=array(
			"id"=>$_W['uniacid'],
			"uniacid"=>$_W['uniacid']  
		);
		$res=$model999->add($setting);
		 
	}  
	if(intval($setting['wx_auth_uniacid'])>0){
		$wechat=pdo_fetch("SELECT `key` as appid,secret FROM ".tablename("account_wechats")." WHERE uniacid=".$setting['wx_auth_uniacid']." LIMIT 1");
		if(!empty($wechat)){
			$setting['wx_appid']=$wechat['appid'];
			$setting['wx_secret']=$wechat['secret'];
		}
	}
	 
	if($type!="pay"){
		unset($setting['keypem']);
		unset($setting['certpem']); 
	} 
	  
	$setting['attachurl']=$_W['attachurl'];
	$setting['static']=$_W['siteroot']."/addons/".ZSK_MODULE."/static/";  
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
  
function getAgentGroupByID($agentgroup,$gid){
	foreach ($agentgroup as $key => $val) {
		if($val['id']==$gid){
			return $val;
		}
	}
	return null;
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
 * @param $list
 * @param $filename
 * @param $indexKey
 * @param int $startRow
 * @param bool $excel2007
 * @return bool
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Writer_Exception
 * 数据导出
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
