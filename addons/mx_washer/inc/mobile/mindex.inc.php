<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
$bgcolor = $cfg['bgcolor'];
define("APPID",$cfg['appid']);
define("AID",$_GPC['aid']);
if($op == 'index') {	
	//获取tick调取微信系统扫一扫
	$appid =  $cfg['appid'];
	$appsecret =  $cfg['appsecrect'];
	$access_token =  get_local_acc($appid,$appsecret);
	$ticket = get_local_ticket($access_token);
	$getSign = getSignPackage($ticket,$appid);
	
		if(!isset($_GET['code'])){	
			//snsapi_userinfo /  snsapi_base
			$redirect_uri = urlencode($_W['siteurl']);
			$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
			header("location:$author_url");
		}else{				
			$code = $_GET['code'];			
			//echo $code."-----";
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";			
			$auth_token_data = curl_request($token_url);
			//echo $auth_token_data;
			$Token_arr =  json_decode($auth_token_data,true); //转数组		
			$openid =  $Token_arr['openid'];
			
			
			
			//获取用户信息
			$url2="https://api.weixin.qq.com/sns/userinfo?access_token=".$Token_arr['access_token']."&openid=".$openid."&lang=zh_CN";        
			$resutl = curl_request($url2);
			$resutl_array = json_decode($resutl, true);
			
			
			
			if(!empty($openid)){
					
					//查询用户信息
					$wheres = [
						'openid' => $openid,
						'uniacid' => $_W['uniacid']
					];	
					$user = pdo_get('xc_user',$wheres);
					if(!$user){
						$data = [
							'nickname'=>$resutl_array['nickname'],
							'avatar' => $resutl_array['headimgurl'],
							'uniacid' => $cfg['uniacid'],
							'appid' => $cfg['appid'],
							'openid' => $openid,
							'regtime' => time(),	
							'aid' => AID				
						];	
						
						$result = pdo_insert('xc_user',$data);
						$nickname = $resutl_array['nickname'];
						$avatar = $resutl_array['headimgurl'];
						$isvip = 0;
					}else{
						$nickname = $user['nickname'];
						$avatar = $user['avatar'];
						$isvip = $user['isvip'];
						
					}
			}else{
				$redirect_uri = urlencode($_W['siteurl']);
				$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
				header("location:$author_url");
			}
			$count_money = pdo_fetchcolumn("SELECT SUM(pay_money) FROM ".tablename('xc_financial')." where openid='".$openid."'  and aid=".$cfg['aid']." and pay_type in(2,5)");
	
	/*测试部分结束*/
	}
	
	
	
	


		
}

include $this->template('mindex');


//在线获取ticket
function get_online_ticket($access_token){
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$access_token;
	    $data = curl_request($url); //json 字符串
		$arr =  json_decode($data,true); //转数组
	     return $arr['ticket'];  //单独获取ticket
}
//本地保存获取ticket
function get_local_ticket($access_token){
		$ticket_data = @file_get_contents(dirname(__FILE__).'/'. APPID .'_ticket.json');
		if(!$ticket_data){ //如果不存在
			$acc['ticket'] = get_online_ticket($access_token); //acc_token
			$acc['lifetime'] = time() +7200;  //过期时间
			@file_put_contents(dirname(__FILE__).'/'. APPID .'_ticket.json',json_encode($acc)); //数组转json存入				
			return $acc['ticket'];
		}else{ //存在
			$file_Data_arr = json_decode($ticket_data,true);  //json转数组
			if(time() > $file_Data_arr['lifetime']){ //当前时间超过存储的过期时间
					//获取最新token
				$acc['ticket'] = get_online_ticket($access_token);
				$acc['lifetime'] = time() + 7200;
				@file_put_contents(dirname(__FILE__).'/'. APPID .'_ticket.json',json_encode($acc)); //数组转json存入
				return $acc['ticket']; 					
				}else{ //正常
					return $file_Data_arr ['ticket'];
				}	
		} 
}
 //得到签名
function getSignPackage($jsapiTicket,$appid) {
		//$jsapiTicket = $this->get_local_ticket();
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time();
		$nonceStr = createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

		$signature = sha1($string);
		$signPackage = array(
		  "appId"     => $appid ,
		  "nonceStr"  => $nonceStr,
		  "timestamp" => $timestamp,
		  "url"       => $url,
		  "signature" => $signature,
		  "rawString" => $string
		);
		return $signPackage; 
	  }		
//签名规则
function createNonceStr($length = 16) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$str = "";
			for ($i = 0; $i < $length; $i++) {
			  $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			}
			return $str;
}

//acc写入本地缓存及本地调用
function get_local_acc($appid,$appsecret){	
	$token_data = @file_get_contents(dirname(__FILE__).'/'. APPID .'_access_token.json');			
	if(!$token_data){ //如果不存在
		$acc['acc_token'] = get_online_acc($appid,$appsecret); //acc_token
		$acc['acc_tiems'] = time() +7200;  //过期时间
		@file_put_contents(dirname(__FILE__).'/'. APPID .'_access_token.json',json_encode($acc)); //数组转json存入				
	    return $acc['acc_token'];
	}else{ //存在
		$file_Data_arr = json_decode($token_data,true);  //json转数组
		if(time() > $file_Data_arr['acc_tiems']){ //当前时间超过存储的过期时间
			//获取最新token
			$acc['acc_token'] = get_online_acc($appid,$appsecret);
			$acc['acc_tiems'] = time() +7200;
			@file_put_contents(dirname(__FILE__).'/'. APPID .'_access_token.json',json_encode($acc)); //数组转json存入
			return $acc['acc_token']; 					
		}else{ //正常
			return $file_Data_arr ['acc_token'];
		}	
	}			
}
//在线获取acc
 function  get_online_acc($appid,$appsecret){
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
		$data = curl_request($url); //json 字符串
		$arr =  json_decode($data,true); //转数组		
		return $arr['access_token'];  //单独获取acc_token
}



//CURL
 function curl_request($url,$data = null){			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			if (!empty($data)){
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($curl);
			curl_close($curl);
			return $output;
}		



