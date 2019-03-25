<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
define("AID",$cfg['aid']);
define("APPID",$cfg['appid']);
$appid =  $cfg['appid'];
$appsecret =  $cfg['appsecrect'];




	if($op == 'index') {
		if(!isset($_GET['code']) || empty($openid)){	
					$redirect_uri = urlencode($_W['siteurl']);
					$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
					header("location:$author_url");
		}else{
			$code = $_GET['code'];				
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";		
			$auth_token_data = curl_request($token_url);	
			$Token_arr =  json_decode($auth_token_data,true); //转数组								
			$openid =  $Token_arr['openid'];
		if(!empty($openid)){
		//逻辑代码开始
		//判断当前用户是否管理员
		$user_info = pdo_get('xc_user',array('openid'=>$openid,'aid'=>$_GPC['aid']));
		if($user_info['isadmin'] != 1){
			message("您还不是系统管理员!",$this->createMobileurl('mindex',array('aid'=>$_GPC['aid'])),'error');
			exit;
		}
		
		
		
		
		$id = intval($_GPC['id']);
		$wheres = [
			'id' => $id,
			'openid' => $_GPC['openid'],
			'uniacid' => $_W['uniacid'],
			'aid' => $cfg['aid'],
			'appid' => $cfg['appid']
		];
	
	$rs = pdo_get('xc_user',$wheres);
	//逻辑代码结束
	}else{
				$redirect_uri = urlencode($_W['siteurl']);
				$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
					header("location:$author_url");
			}
	
		}
	
	}
	include $this->template('user_info');




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



