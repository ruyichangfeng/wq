<?php
/**
 * 众筹模块定义
 */
defined('IN_IA') or exit('Access Denied');
class HC_ChipsModuleSite extends WeModuleSite {
	
	public function doMobileIndex(){
		$this->__mobile(__FUNCTION__);
	}
	
	public function doMobileRule(){
		$this->__mobile(__FUNCTION__);
	}
	
	public function doMobileChip(){
		$this->__mobile(__FUNCTION__);
	}
	
	public function doMobileHome(){
		$this->__mobile(__FUNCTION__);
	}
	
	public function doMobileAward(){
		$this->__mobile(__FUNCTION__);
	}
	
//以下为后台管理＝＝＝＝＝＝＝＝＝＝＝＝＝＝
	
	public function doWebChip(){
		$this->__web(__FUNCTION__);
	}
	
	public function doWebRule(){
		$this->__web(__FUNCTION__);
	}
	
	public function doWebChipManager(){
		$this->__web(__FUNCTION__);
	}
	
	public function doWebMember(){
		$this->__web(__FUNCTION__);
	}
	
	public function doWebAward(){
		$this->__web(__FUNCTION__);
	}
	
	public function __mobile($f_name){
		global $_W,$_GPC;
		$uniacid = $_W['uniacid'];
		$op = $_GPC['op']?$_GPC['op']:'display';
		
		include_once  'mobile/'.strtolower(substr($f_name,8)).'.php';
	}
	
	public function __web($f_name){
		global $_W,$_GPC;
		checklogin();
		$uniacid = $_W['uniacid'];
		load()->func('tpl');
		$op = $operation = $_GPC['op']?$_GPC['op']:'display';
		include_once  'web/'.strtolower(substr($f_name,5)).'.php';
	}
	
	public function doMobileUserinfo() {
		global $_GPC,$_W;
		$weid = $_W['uniacid'];//当前公众号ID
		load()->func('communication');
		$time = $_GPC['time'];
		//用户不授权返回提示说明
		if ($_GPC['code']=="authdeny"){
		    $url = $_W['siteroot'].$this->createMobileUrl('index');
			header("location:$url");
			exit('authdeny');
		}
		//高级接口取未关注用户Openid
		if (isset($_GPC['code'])){
		    //第二步：获得到了OpenID
		    $appid = $_W['account']['key'];
		    $secret = $_W['account']['secret'];
			$serverapp = $_W['account']['level'];
			if ($serverapp!=4) {
				//不给设置
				$cfg = $this->module['config'];
			    $appid = $cfg['appid'];
			    $secret = $cfg['secret'];
			}//借用的
			$state = $_GPC['state'];
			//1为关注用户, 0为未关注用户
			
			//查询活动时间
			$code = $_GPC['code'];
		    $oauth2_code = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
		    //exit($oauth2_code);
			$content = ihttp_get($oauth2_code);
		    $token = @json_decode($content['content'], true);
			if(empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['openid'])) {
				echo '<h1>获取微信公众号授权'.$code.'失败[无法取得token以及openid], 请稍后重试！ 公众平台返回原始数据为: <br />' . $content['meta'].'<h1>';
				exit;
			}
		    $from_user = $token['openid'];
			//再次查询是否为关注用户
			//$profile  = fans_search($from_user, array('follow'));
			
			$profile = pdo_fetch("select * from ".tablename('mc_mapping_fans')." where uniacid = ".$_W['uniacid']." and openid = '".$_W['openid']."'");
			
			//关注用户直接获取信息
			if ($profile['follow']==1){
			    $state = 1;
			}else{
				//未关注用户跳转到授权页
				$url = $_W['siteroot'].$this->createMobileUrl('userinfo', array('time'=>$time), true);
				$oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect";				
				header("location:$oauth2_code");
			}
			//未关注用户和关注用户取全局access_token值的方式不一样
			if ($state==1){
			    $oauth2_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
			    $content = ihttp_get($oauth2_url);
			    $token_all = @json_decode($content['content'], true);
			    if(empty($token_all) || !is_array($token_all) || empty($token_all['access_token'])) {
				    echo '<h1>获取微信公众号授权失败[无法取得access_token], 请稍后重试！ 公众平台返回原始数据为: <br />' . $content['meta'].'<h1>';
				    exit;
			    }
				$access_token = $token_all['access_token'];
				$oauth2_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$from_user."&lang=zh_CN";
			}else{
			    $access_token = $token['access_token'];
				$oauth2_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$from_user."&lang=zh_CN";
			}
			
			//使用全局ACCESS_TOKEN获取OpenID的详细信息			
			$content = ihttp_get($oauth2_url);
			$info = @json_decode($content['content'], true);
			if(empty($info) || !is_array($info) || empty($info['openid'])  || empty($info['nickname']) ) {
				echo '<h1>获取微信公众号授权失败[无法取得info], 请稍后重试！<h1>';
				exit;
			}
			$member = pdo_fetch("select * from ".tablename('hc_chips_member')." where uniacid = ".$_W['uniacid']." and openid = '".$_W['openid']."'");
			if(!empty($_W['member']['uid'])){
				$mobile = mc_fetch($_W['member']['uid'], array('mobile'));
			}
			if(empty($member)){
				$row = array(
					'uniacid'=>$_W['uniacid'],
					'openid'=>$_W['openid'],
					'realname'=>base64_encode($info['nickname']),
					'headimgurl'=>$info['headimgurl'],
					'mobile'=>$mobile['mobile'],
					'status'=>0,
					'createtime'=>time()
				);
				pdo_insert('hc_chips_member', $row);	
			}
			
			setcookie($time."chips_openid".$_W['uniacid'], $info['openid'], time()+3600*240);
			$urlcookie = "hc_chips_url".$_W['uniacid'];
			if(empty($_COOKIE[$urlcookie])){
				$url = $this->createMobileUrl('index');
			} else {
				$url = $_COOKIE[$urlcookie];
			}
			header("location:$url");
			exit;
		}else{
			echo '<h1>网页授权域名设置出错!</h1>';
			exit;		
		}
	}
	
	private function CheckCookie($time = 0) {
		global $_W;
		//return ;
		$oauth_openid = $time."chips_openid".$_W['uniacid'];
		if (empty($_COOKIE[$oauth_openid])) {
			$appid = $_W['account']['key'];
			$secret = $_W['account']['secret'];
			//是否为高级号
			$serverapp = $_W['account']['level'];	
			if ($serverapp!=4) {
				$cfg = $this->module['config'];
				//借用的
				$appid = $cfg['appid'];
			    $secret = $cfg['secret'];
				if(empty($appid) || empty($secret)){
					return ;
				}
			}
			$url = $_W['siteroot'].'app/'.$this->createMobileUrl('userinfo', array('time'=>$time), true);
			$oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect";				
			//exit($oauth2_code);
			header("location:$oauth2_code");
			exit;
		}
	}
	
	public function payResult($params) {
		$data = array('status' => $params['result'] == 'success' ? 1 : 0);
		if($data['status']==1){
			pdo_update('hc_chips_takechip', array('joinmoney'=> $params['fee'], 'status'=>1), array('id'=>$params['tid']));
			message('支付成功！', '../../app/'.$this->createMobileUrl('index'), 'success');
		} else {
			message('支付失败！', '../../app/'.$this->createMobileUrl('index'), 'error');
		}
	}
}

function haha($hehe){
	$mphone = substr($hehe,3,5);
	$lphone = str_replace($mphone,"*****",$hehe);
	return $lphone;
}

function allJoinMoney($chipid = 0){
	global $_W;
	$takechips = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where status = 1 and uniacid = ".$_W['uniacid']." and chipid = ".$chipid." order by joinmoney desc, createtime asc");
	$alljoinmoney = 0;
	foreach($takechips as $t){
		$alljoinmoney = $alljoinmoney + $t['joinmoney'];
	}
	return $alljoinmoney;
}