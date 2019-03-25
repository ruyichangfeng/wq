<?php
session_start();
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
define("AID",$_GPC['aid']);
$appid =  $cfg['appid'];
$appsecret =  $cfg['appsecrect'];
if($op == 'index') {
	if(!isset($_GET['code'])){
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
			//逻辑代码
			$wheres = [
				'openid' => $openid,
				'uniacid' => $_W['uniacid'],
				'aid' => AID
			];	
			$user = pdo_get('xc_user',$wheres);			
			
		
		}else{
				$redirect_uri = urlencode($_W['siteurl']);
				$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
				header("location:$author_url");
			}
		
	}
	

}else if($op == 'msave') {
	$data['true_name'] = $_GPC['true_name'];
	$data['mobile'] = $_GPC['mobile'];	
	$data['address'] = $_GPC['address'];
	pdo_update('xc_user',$data,array('openid'=>$_GPC['openid'],'aid'=>$cfg['aid'])); 
	message("资料编辑成功！!",$this->createMobileurl('mindex',array("op"=>'index',"aid"=>AID)),'success');
}
include $this->template('muserinfo');
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

