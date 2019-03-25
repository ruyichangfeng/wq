<?php 

/*
	用户表类
*/
class model_user 
{	
	
	//查询会员余额和积分
	static function getUserCredit($openid){	
		global $_W;	
		load() -> model('mc');
		$uid = mc_openid2uid($openid);
		$setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
		$credtis =  mc_credit_fetch($uid);
		
		return array('uid'=>$uid,'credit1'=>$credtis[$setting['creditbehaviors']['activity']],'credit2'=>$credtis[$setting['creditbehaviors']['currency']]);
	}
	
	//变动会员积分 $type 是类型 1是兑换优惠券消耗，2是抵扣 3是抵扣退还   4是购物奖励
	static function updateUserCredit($openid,$value,$type){
		global $_W;
		load() -> model('mc');
		$uid = mc_openid2uid($openid);
		$setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
		$result = mc_credit_update($uid, $setting['creditbehaviors']['activity'], $value,array($uid,'众惠团购商城模块变动会员积分','zofui_groupshop',$type));
		return $result;
	}
	
	//变动会员余额  1是退款 
	static function updateUserMoney($openid,$value,$type){
		global $_W;
		load() -> model('mc');
		$uid = mc_openid2uid($openid);
		$setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
		$result = mc_credit_update($uid, $setting['creditbehaviors']['currency'], $value,array($uid,'众惠团购商城模块订单退款','zofui_groupshop',$type));
		return $result;
	}	
	
	//初始化用户数据
	static function initUserInfo(){
		global $_W;
		
		if(empty($_W['openid'])) self::alertWechatLogin(); //生产环境必须打开这个
		
		
		//必须关注
		$settings = Util::getModuleConfig();
		if($settings['ismustfollow'] == 1){
			$isfollow = Util::getSingelDataInSingleTable('mc_mapping_fans',array('openid'=>$_W['openid']),' follow ');			
			if($isfollow['follow'] == 0) self::alertWechatLogin();
		}
		
		$userinfo = self::getSingleUser($_W['openid']); //查询缓存
	
		if(!empty($userinfo)){
			if($userinfo['status'] == 1) die('您的账号已被禁用'); //被拉黑的账户
			
			if($userinfo['logintime'] < time()-24*3600){ //每24小时更新一次登录时间，用户头像，昵称
				load() -> model('mc');
				$oauthinfo = mc_oauth_userinfo($_W['uniacid']);	
				if(!empty($oauthinfo['nickname'])){
					$data = array('logintime' => time(),'nickname' => $oauthinfo['nickname'],'headimgurl' => $oauthinfo['headimgurl']);
					pdo_update('zofui_groupshop_user', $data, array('id' => $userinfo['id']));
					Util::deleteCache('fsuser',$_W['openid']);					
				}
			}
		}else{
			$userinfo = Util::getSingelDataInSingleTable('zofui_groupshop_user',array('openid'=>$_W['openid']));				
			if (empty($userinfo['logintime']) && !empty($_W['openid'])) {
				load() -> model('mc');				
				$oauthinfo = mc_oauth_userinfo($_W['uniacid']);
				$data = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $_W['openid'],
					'nickname' => $oauthinfo['nickname'],
					'headimgurl' => $oauthinfo['headimgurl'],
					'logintime' => time()
				);
				pdo_insert('zofui_groupshop_user', $data);
			}
			$userinfo = self::getSingleUser($_W['openid']);
		}
		
		return $userinfo;
	}
	
	
	//查询一条用户数据,传入openid
	static function getSingleUser($openid){
		return Util::getDataByCacheFirst('fsuser',$openid,array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_user',array('openid'=>$openid)));
		//需删除缓存
	}	
	
	
	//非微信端提示
	static function alertWechatLogin(){
		global $_W;
		$qrcode = tomedia('qrcode_'.$_W['acid'].'.jpg');
		die("<!DOCTYPE html>
            <html><head><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                <title>提示</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
            </head>
            <body>
            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请先用微信扫二维码关注我们</h4><br><img width='200px' src='".$qrcode."'></div></body></html></div></div></div>
            </body></html>");
	}
	
	
}
	
	
	
?>