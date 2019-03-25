<?php
function http_request($url,$data=array()){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	// 我们在POST数据哦！
	curl_setopt($ch, CURLOPT_POST, 1);
	// 把post的变量加上
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function file_get_contentwx($url) {

	if (function_exists('file_get_contents')) {
		$result = @file_get_contents($url);
	}
	if ($result =="") {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	return $result;
	
}

function moban($appid,$appsecret,$access_token_odl,$uniacid){
	
	//数据库查询无结果 获取access_token并存入
	$TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
	$json = file_get_contentwx($TOKEN_URL);
	$result = json_decode($json,true);
	$ACCESS_TOKEN_t = $result['access_token'];  
	
	if($ACCESS_TOKEN_t){
		$ACCESS_TOKEN = $ACCESS_TOKEN_t;
		pdo_update('account_wechats', array('access_token' => $ACCESS_TOKEN_t), array('uniacid' => $_W['uniacid']));
	}else{
		$ACCESS_TOKEN = $access_token_odl;
	}
	
	return $ACCESS_TOKEN;	
	
}

function send_template_message($data,$access_token){
	
	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
	$res = http_request($url,$data);
	return json_decode($res,true);
	
}
?>