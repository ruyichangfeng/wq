<?php 

/*
	用户表类
*/
class model_user 
{	
	static $oauth;

	//初始化用户数据
	static function initUserInfo(){
		global $_W,$_GPC;
		
		if(empty($_W['openid'])) self::alertWechatLogin(); 

		$_W['settings'] = Util::getModuleConfig();
		
		$userinfo = self::getSingleUser($_W['openid']); //查询缓存
		return $userinfo;
	}


	//查询一条用户数据,传入openid
	static function getSingleUser($openid){
		global $_W;
		$cache = Util::getCache('u',$openid);

		if( empty( $cache['fanid'] ) ){
			$cache = pdo_get('mc_mapping_fans',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
			if( !empty( $cache ) ){
				$tag = iunserializer( base64_decode( $cache['tag'] ) );
				$cache['headimgurl'] = $tag['headimgurl'];
			}else{
				self::alertWechatLogin();
			}
			Util::setCache('u',$openid,$cache);
		}
		return $cache;
	}
	

	static function isSub($nickname){
		global $_W;
		if($_W['account']['level'] > 3 && $_W['account']['oauth']['key'] == $_W['account']['key'] ){ // 服务号
			$fans = pdo_get('mc_mapping_fans',array('openid'=>$_W['openid'],'uniacid'=>$_W['uniacid']));
			$folowflag = $fans['follow'];
		}else{
			$nowfans = pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE `uniacid` = :uniacid AND nickname = :nickname ORDER BY `followtime` DESC ",array(':uniacid'=>$_W['uniacid'],':nickname'=>$nickname));
			$folowflag = $nowfans['follow'];
		}
		return $folowflag;
	}

	//非微信端提示
	static function alertWechatLogin(){
		global $_W;
		$falg = '';
		
		$qrcode = tomedia('qrcode_'.$_W['acid'].'.jpg');
		die("<!DOCTYPE html>
            <html><head><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                <title>提示</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
            </head>
            <body>
            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请订阅公众号在微信内操作".$falg."</h4><br><img width='200px' src='".$qrcode."'></div></body></html></div></div></div>
            </body></html>");
	}
	
	
}
	
	
	
