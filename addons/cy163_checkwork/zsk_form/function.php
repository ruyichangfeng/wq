<?php 

 
 
function mobile($mobile){
	if(strlen($mobile)>10){
		$mobile=substr($mobile,0,3)."****".substr($mobile,strlen($mobile)-4,4);
	}else{
		$mobile=substr($mobile,0,3)."****".substr($mobile,strlen($mobile)-2,2);
	}
	return $mobile;
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
function JSON_OUT($d){ 
//递归将数组json_encode; 
	$json= EACHARR($d,"urlencode");
	return urldecode(json_encode($json)); 
 
}
function EACHARR($arr,$act=false){ 
//递归数组，方便其他函数应用
	switch (gettype($arr)) {
		case 'array': 
			foreach ($arr as $key => $val) {
				$arr[$key] = EACHARR($val,$act);// 
			}
			break; 
		default: 
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
 
function CURL_get($url){ 		
	$curl = curl_init(); // 启动一个CURL会话      
	curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                  
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	// curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file); // 读取上面所储存的Cookie信息      
	curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环      
	curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容      
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回      
	$tmpInfo = curl_exec($curl); // 执行操作   
	if (curl_errno($curl)) {      
		echo 'Errno'.curl_error($curl);      
	}else{
		 $arr = json_decode($tmpInfo,true);
		return $arr; // 返回数据   
	}   
}
function CURL_send($url,$data){
//发送curl，返回arr。debug为true，直接输出放回页面的输出信息
	$debug=false;	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type:text/html;charset=utf-8');	
	if(!empty($data)){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	 
	$rs=curl_exec($ch);
	if(curl_errno($ch)){//出错则显示错误信息
       $s = "{\"success\": false,\"msg\":\"".curl_error($ch)."\" }";
       return $s;
    }else{
		curl_close($ch);   
		if($debug===true){
			 echo "<br/>".$rs."<br/>";
		}else{
			$arr = json_decode( $rs,true);   
		 	return $arr;
		} 
	}
} 
 


