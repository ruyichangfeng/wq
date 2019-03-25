<?php 
if(!defined('IN_IA')) {
	exit('Access Denied');
}  
$appid ="wx7838c8a8ffc14918";
$url = alinuma_getCurrentUrl();
$redirect_uri = urlencode($url);   
$openid="";
$oauth_url = "http://www.nbwaka.com/authorize.html?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
 if(isset($_GET['code']) && !empty($_GET['code'])){ 
	    $code = $_GET['code'];
	    $openid_access_token = alinuma_getOauthAccessToken($code,$appid);
	    $openid = $openid_access_token['openid'];
	    $access_token = $openid_access_token['access_token']; 
	     
	    if(!empty($openid) && !empty($access_token)){
		        $oauth2_snsapi_userinfo = alinuma_getOauthUserinfo($access_token,$openid);
		        if($oauth2_snsapi_userinfo && isset($oauth2_snsapi_userinfo['nickname'])){
		            	$_SESSION[$openid_key] = $oauth2_snsapi_userinfo; 
		        }else{
					header('location:'.$oauth_url);
					exit;
				}
		    }else{
		        header('location:'.$oauth_url);
		            exit;
	        } 
 }else{
        header('location:'.$oauth_url);
        exit;
 }   