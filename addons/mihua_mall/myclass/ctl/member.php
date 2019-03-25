<?php 
namespace myclass\ctl;

class member {
    //从微信端获取用户基本信息
	public function getUserInfo($openid){
        load()->classs('account');
        $accObj   		= \WeixinAccount::create($_W['acid']);
        $access_token 	= $accObj->fetch_token();
        $content  		= file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid} ");
        $con_arr 		= json_decode($content,true);
        return $con_arr;
	}    
}