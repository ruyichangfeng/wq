<?php
/**
 * 线下积分宝模块微站定义
 *
 * @author wenjing
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
ini_set('date.timezone','Asia/Shanghai');
define('OD_ROOT', IA_ROOT . '/addons/jlsh_jfb');
include IA_ROOT.'/framework/library/phpexcel/PHPExcel.php';
include IA_ROOT.'/framework/library/qrcode/phpqrcode.php';
	

class Jlsh_jfbModuleSite extends WeModuleSite {
	public $weid;
		
	public $imgs;
	
	public $acid;
	
	public $scene_id;
	
	public $ticketstr;
	
	public $urlstr;
	
	public $mdsyjifen;
	
	public $Showyue;
	
	public $yueimgs;
	
	public $yueStr;
	
	
	function __construct(){
	
		global $_W;
	
		$this->weid = $_W['uniacid'];
	}
	
	public function Get_openid_byindex(){
		global $_W,$_GPC;
	
		$sql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql,array(':weid'=>$_GPC['i']));
	
		if(empty($setting['appid'])){
			message('请到管理后台设置完整的 AppID 和AppSecret !');
			exit();
		}
	
		if(empty($_COOKIE['useropenid_Byzm'])){
				
			if (!isset($_GET['code'])){
				$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	
				$urlObj["appid"] = $setting['appid'];
				$urlObj["redirect_uri"] = $baseUrl;
				$urlObj["response_type"] = "code";
				$urlObj["scope"] = "snsapi_userinfo";
				$urlObj["state"] = "STATE"."#wechat_redirect";
	
				$bizString = $this->ToUrlParams($urlObj);
	
				$url =  "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
				Header("Location: $url");
				exit();
			} else {
				$urlObj["appid"] = $setting['appid'];
				$urlObj["secret"] = $setting['appsecret'];
				$urlObj["code"] = $_GET['code'];
				$urlObj["grant_type"] = "authorization_code";
					
				$biz1String = $this->ToUrlParams($urlObj);
				$url =  "https://api.weixin.qq.com/sns/oauth2/access_token?".$biz1String;
				$token_ary = $this->request_get($url);
				$token_ary = json_decode($token_ary,true);
	
	
				$userurl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token_ary['access_token'].'&openid='.$token_ary['openid'].'&lang=zh_CN';
	
	
				$usersinfo = $this->request_get($userurl);
				$user_obj = json_decode($usersinfo,true);
	
	
				setcookie("useropenid_Byzm", $user_obj['openid'], time()+3600*24*30);
				return $user_obj['openid'];
			}
		}else{
			return $_COOKIE['useropenid_Byzm'];
		}
	}		
	public function doMobileIndex(){
		global $_W,$_GPC;
	
		$openid = $this->Get_openid_byindex();
			
		$sql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql,array(':weid'=>$_GPC['i']));
				
		if(empty($_GPC['id'])){
			$dysql1 = "SELECT y.id as yid,m.id as mid,y.weixin FROM " . tablename('jfb_yuangong') . " as y left join " . tablename('jfb_mendian') . " as m on m.id = y.mendian WHERE y.weid = :weid ";
			$dylist1 = pdo_fetchall($dysql1,array(':weid'=>$_GPC['i']));
							
			foreach ($dylist1 as $key =>$value){
				if($value['weixin'] == $openid){
					$yid = $value['yid'];
					$mid = $value['mid'];
				}
			}			if(empty($mid)||empty($yid)){
				message('请联系商户绑定店员身份！');
				exit();
			}
		
			$url = "http://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$_GPC['i']."&id=".$yid."&mid=".$mid."&c=entry&do=index&m=jlsh_jfb";
		
			Header("Location: $url");
		
		}		
		$dysql = "SELECT y.weixin,y.addyue FROM " . tablename('jfb_yuangong') . " as y left join " . tablename('jfb_mendian') . " as m on m.id = y.mendian WHERE y.weid = :weid and y.id = :id";
		$dylist = pdo_fetch($dysql,array(':weid'=>$_GPC['i'],':id'=>$_GPC['id']));
					
		if($dylist['weixin'] != $openid){
			message('您不是店员！');
			exit();
		}
		
				/*
		$dysql = "SELECT weixin,addyue FROM " . tablename('jfb_yuangong') . " WHERE weid = :weid and id = :id";
		$dylist = pdo_fetch($dysql,array(':weid'=>$_GPC['i'],':id'=>$_GPC['id']));
		if(empty($dylist)){
			message('二维码已失效！');
			exit();
		}
			
		$sql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql,array(':weid'=>$_GPC['i']));
	
	
		if(!empty($setting['appid'])){
			if(!$this->Getopenid($dylist['weixin'], $setting['appid'], $setting['appsecret'])){
				message('您还不是店员！');
				exit();
			}
		}		*/

	
		$imgs = "";
		if(!empty($_GPC['show'])|| !empty($_GPC['type'])){
			$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$_GPC['ticket'];
		}
			
	
	
		
		$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and codetype = 0 and jftype = 0 and dianyuan = :dianyuan",array(":weid"=>$_GPC['i'],":dianyuan"=>$_GPC['id']));
				
		$yelist = pdo_fetchcolumn("select SUM(yuenum) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0  and codetype = 1 and jftype = 0 and dianyuan = :dianyuan",array(":weid"=>$_GPC['i'],":dianyuan"=>$_GPC['id']));
				
		if(!empty($jflist)){
			$jifencount = $jflist;
		}
		else {
			$jifencount = 0;
		}		if(!empty($yelist)){
			$yuecount = $yelist;
		}
		else {
			$yuecount = 0;
		}
	
		$syjifen = $this->Getsyjifen($_GPC['mid']);		
		$syyue = $this->Getsyyue($_GPC['mid']);
	
		if (checksubmit('submit')) {
							
		    if($_GPC['buttype'] == 0){
				if(!empty($_GPC['jifen'])){
					if(is_numeric($_GPC['jifen'])){
																			
					    if($_GPC['jftype']!=1){
							$dqjifen = $this->mendiannumber($_GPC['mid'],$_GPC['jifen']);
			
							
							if($dqjifen == 1){
								message('输入的积分超过限额或该门店积分已经达到限制！');
								exit();
							}elseif($dqjifen == 3){
							    message('请联系商家充值！');
							    exit();
							}							
					    }												
							
						
						$max = 50000;
							
						if (empty($max)) $max = 50000;
						load()->model('account');
						$acid = pdo_fetchcolumn('select acid from '.tablename('account')." where uniacid={$_GPC['i']}");
						$max = pdo_fetchcolumn('select qrcid from '.tablename("qrcode")." where acid = {$acid} and model=1 order by qrcid desc limit 1");
						
						$uniacccount = WeAccount::create($acid);
						$barcode['action_name'] = 'QR_SCENE';
						$barcode['expire_seconds'] = 30*24*3600;
						$time = $barcode['expire_seconds'];
						$max = intval($max) + 1;
						$barcode['action_info']['scene']['scene_id'] = $max;
						$result = $uniacccount->barCodeCreateDisposable($barcode);
						if(empty($result['url']))
							die('生成二维码失败!原因:'.json_encode($result));
							
							
						$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result['ticket'];
						$scene_id = $barcode['action_info']['scene']['scene_id'];
						$ticketstr = $result['ticket'];
						$urlstr = $result['url'];
		
						setcookie("acid", $acid, time()+3600*24*30);
						setcookie("scene_id", $scene_id, time()+3600*24*30);
						setcookie("ticketstr", $ticketstr, time()+3600*24*30);
						setcookie("urlstr", $urlstr, time()+3600*24*30);
		
						$this->createerweima($_GPC['jifen'],$_GPC['jftype'],$_GPC['content'],$acid,$scene_id,$ticketstr,$urlstr);
							
						$url = "http://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$_GPC['i']."&show=true&jifen=".$_GPC['jifen']."&jftype=".$_GPC['jftype']."&ticket=".$ticketstr."&id=".$_GPC['id']."&mid=".$_GPC['mid']."&c=entry&do=index&m=jlsh_jfb";
			
						Header("Location: $url");
							
					}else {
						message('请输入数字类型的积分！');
					}
				}else{
					message('请输入积分,才能生成二维码！');
				}		
		    }else{			
		        if($dylist['addyue'] == 0){					
		            message('当前店员没有开通充值权限');					
		            exit();				
		        }
								
				if(!empty($_GPC['jifen'])){
					if(is_numeric($_GPC['jifen'])){
					    
					    if($_GPC['jftype']!=1){
							$dqjifen = $this->mendiannumber1($_GPC['mid'],$_GPC['jifen']);
							
							
							if($dqjifen == 1){
								message('输入的余额超过限额或该门店余额已经达到限制！');
								exit();
							}elseif($dqjifen == 3){
							    message('请联系商家充值！');
							    exit();
							}							
										
						}
										
						$max = 50000;
				
						if (empty($max)) $max = 50000;
						load()->model('account');
						$acid = pdo_fetchcolumn('select acid from '.tablename('account')." where uniacid={$_GPC['i']}");
						$max = pdo_fetchcolumn('select qrcid from '.tablename("qrcode")." where acid = {$acid} and model=1 order by qrcid desc limit 1");
						
						$uniacccount = WeAccount::create($acid);
						$barcode['action_name'] = 'QR_SCENE';
						$barcode['expire_seconds'] = 30*24*3600;
						$time = $barcode['expire_seconds'];
						$max = intval($max) + 1;
						$barcode['action_info']['scene']['scene_id'] = $max;
						$result = $uniacccount->barCodeCreateDisposable($barcode);
						if(empty($result['url']))
							die('生成二维码失败!原因:'.json_encode($result));

						
				
						$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result['ticket'];
						$scene_id = $barcode['action_info']['scene']['scene_id'];
						$ticketstr = $result['ticket'];
						$urlstr = $result['url'];
				
						setcookie("acid_1", $acid, time()+3600*24*30);
						setcookie("scene_id_1", $scene_id, time()+3600*24*30);
						setcookie("ticketstr_1", $ticketstr, time()+3600*24*30);
						setcookie("urlstr_1", $urlstr, time()+3600*24*30);
										
						$this->createerweima1($_GPC['jifen'],$_GPC['jftype'],$acid,$scene_id,$ticketstr,$urlstr);
						$url = "http://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$_GPC['i']."&jifen=".$_GPC['jifen']."&show=true&jftype={$_GPC['jftype']}&ticket=".$ticketstr."&id=".$_GPC['id']."&mid=".$_GPC['mid']."&c=entry&type=1&do=index&m=jlsh_jfb";
				
							
						Header("Location: $url");
					}else {
						message('请输入数字类型的额度！');
					}
				}else{
					message('请输入额度,才能生成二维码！');
				}							}
		}
	
		if (checksubmit('submit1')) {
			
		}
		include $this->template('index');
	}
	
	public function doMobileUindex(){
	    global $_W,$_GPC;
	    
	    $sql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
	    $setting = pdo_fetch($sql,array(':weid'=>$_GPC['i']));
	    
	    
	    $openid = $this->Get_openid_byindex();
	    $topfans = pdo_fetch('select m.nickname,m.avatar,m.credit1,m.credit2 from '.tablename('mc_mapping_fans').' as f left join '.tablename('mc_members').' as m on f.uid = m.uid where f.openid = :openid  limit 1',array(":openid" => $openid));
	    
	    $avatar = $topfans['avatar'];
	    $nickname = $topfans['nickname'];
	    
	    $jifen_num = $topfans['credit1'];
	    $yue_num = $topfans['credit2'];
	    
	    
	    
	    include $this->template('uindex');
	}
	
	
	public function Getopenid($openid,$appid,$appSecret){
			
		if(empty($_COOKIE['useropenid'])){
			if($this->exists_tokenBytxt($appid)){
				if($this->exprise_tokenBytxt($appid)){
					$token = $this->getToken($appid, $appSecret);
	
					unlink($appid.'.txt');
	
					file_put_contents($appid.'.txt', $token);
				}else {
					$token = file_get_contents($appid.'.txt');
				}
			}else{
				$token = $this->getToken($appid, $appSecret);
				file_put_contents($appid.'.txt', $token);
			}
	
			$openidStr = $this->Get_Openid($appid,$appSecret);
			setcookie("useropenid", $openidStr, time()+3600*24*30);						
		}else{
			$openidStr = $_COOKIE['useropenid'];
		}		
	
		if($openidStr == $openid)
			return  true;
		else
			return  false;
	}
	public function Get_Openid($appid,$appsecret)
	{
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
			$url = $this->__CreateOauthUrlForCode($appid,$baseUrl);
			Header("Location: $url");
			exit();
		} else {
			//获取code码，以获取openid
			//print("2<br/>");
			//print('code:'.$_GET['code']);
			$code = $_GET['code'];
			$openid = $this->getOpenidFromMp($appid,$appsecret,$code);			
			return $openid;
		}
	}
	private function __CreateOauthUrlForCode($appid,$redirectUrl)
	{
		$urlObj["appid"] = $appid;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}
	public function GetOpenidFromMp($appid,$appsecret,$code)
	{
		$url = $this->__CreateOauthUrlForOpenid($appid,$appsecret,$code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		/*if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
		 && WxPayConfig::CURL_PROXY_PORT != 0){
		curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
		curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
		}*/
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
	
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}
	private function __CreateOauthUrlForOpenid($appid,$appsecret,$code)
	{
		$urlObj["appid"] = $appid;
		$urlObj["secret"] = $appsecret;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
	
		$buff = trim($buff, "&");
		return $buff;
	}
	
	
	public function mendiannumber($mdid,$jifen){
		global $_GPC;
	
	    $number = 0;
		$sql = "SELECT number,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$mdlist = pdo_fetch($sql,array(':weid'=>$_GPC['i'],':id'=>$mdid));
	
	
		if(!empty($mdlist)){
			if(!empty($mdlist['number'])){
			    
				if($mdlist['number'] == 0){
				    $number = 3;
				    exit();
				}
				    
				$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and from_unixtime(addtime,'%Y-%m-%d %H:%i')>=from_unixtime(:numtime, '%Y-%m-%d %H:%i') and mendian = :mendian and codetype=0",array(":weid"=>$_GPC['i'],":numtime"=>$mdlist['numtime'],":mendian"=>$mdid));
				$syjifen = $mdlist['number']-$jflist;					
	
				
				if( $mdlist['number'] == $jflist || $syjifen < $jifen){
					 $number = 1;
				     exit();
				}
					
			}else
				$number = 3;
		}else
			$number = 3;
		
		return $number;
		
	}
	
	public function mendiannumber1($mdid,$jifen){
		global $_GPC;
	
		$number = 0;
		$sql = "SELECT number1,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$mdlist = pdo_fetch($sql,array(':weid'=>$_GPC['i'],':id'=>$mdid));
	
	
		if(!empty($mdlist)){
			if(!empty($mdlist['number1'])){
			    
				if($mdlist['number1'] == 0){
			         $number = 3;
				     exit();
				 }
	
					$jflist = pdo_fetchcolumn("select SUM(yuenum) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and from_unixtime(addtime,'%Y-%m-%d %H:%i')>=from_unixtime(:numtime, '%Y-%m-%d %H:%i') and mendian = :mendian and codetype = 1",array(":weid"=>$_GPC['i'],":numtime"=>$mdlist['numtime'],":mendian"=>$mdid));
	
					$syjifen = $mdlist['number1']-$jflist;
	
					if( $mdlist['number1'] == $jflist || $syjifen < $jifen){
					    $number = 1;
					    exit();
					}
				
					
			}else
				$number = 3;
		}else
			$number = 3;
		
		return $number;
	}
	
	public function createerweima($jifen,$jftype,$content,$acid,$scene_id,$ticketstr,$urlstr){
		global $_W,$_GPC;
	
	
		$rule_data = array(
				'uniacid' => $_GPC['i'],
				'name' => "积分",
				'module' => "jlsh_jfb",
				'status' => 1,
				'displayorder' => 254,
		);
	
		pdo_insert('rule',$rule_data);
		$rid = pdo_insertid();
	
		$list_data =array(
				'weid' => $_GPC['i'],
				'mendian' => $_GPC['mid'],
				'dianyuan' => $_GPC['id'],
				'jifennumber' => $jifen,
				'ruleid' => $rid,
				'jftype' => $jftype,
				'content' => $content,
				'addtime' => TIMESTAMP,
		);
		pdo_insert('jfb_jifenlist',$list_data);
		$listid = pdo_insertid();
	
		$rule_key = array(
				'uniacid' => $_GPC['i'],
				'module' => 'jlsh_jfb',
				'content' => 'jlsh_jfb'.$listid,
				'type' => '1',
				'displayorder' => 254,
				'status' => 1
		);
	
		$rule_key['rid'] = $rid;
		pdo_insert('rule_keyword',$rule_key);
	
	
	
		$qrcode = array(
				'uniacid'=>$_GPC['i'],
				'acid'=>$acid,
				'qrcid'=>$scene_id,
				'name'=>'积分',
				'keyword'=>"jlsh_jfb".$listid,
				'model'=>1,
				'ticket'=>$ticketstr,
				'expire'=>30*24*3600,
				'createtime'=>time(),
				'status'=>1,
				'url'=>$urlstr,
		);
		pdo_insert('qrcode',$qrcode);
		pdo_insert('jfb_qrcode',array('weid'=>$_GPC['i'],'sceneid'=>$scene_id,'ticket'=>$ticketstr,'rid'=>$listid,'url'=>$urlstr));
	
	}
	
	public function createerweima1($jifen,$jftype,$acid,$scene_id,$ticketstr,$urlstr){
		global $_W,$_GPC;
	
	
		$rule_data = array(
				'uniacid' => $_GPC['i'],
				'name' => "积分宝充值",
				'module' => "jlsh_jfb",
				'status' => 1,
				'displayorder' => 254,
		);
	
		pdo_insert('rule',$rule_data);
		$rid = pdo_insertid();
	
	
	
		$list_data =array(
				'weid' => $_GPC['i'],
				'mendian' => $_GPC['mid'],
				'dianyuan' => $_GPC['id'],
				'jifennumber' => $jifen,
				'ruleid' => $rid,				
		    'jftype' => $jftype,
				'codetype' => 1,
				'addtime' => TIMESTAMP,
		);
		pdo_insert('jfb_jifenlist',$list_data);
		$listid = pdo_insertid();
	
	
		$rule_key = array(
				'uniacid' => $_GPC['i'],
				'module' => 'jlsh_jfb',
				'content' => 'xxjfb'.$listid,
				'type' => '1',
				'displayorder' => 254,
				'status' => 1
		);
		$rule_key['rid'] = $rid;
		pdo_insert('rule_keyword',$rule_key);
	
	
	
	
		$qrcode = array(
				'uniacid'=>$_GPC['i'],
				'acid'=>$acid,
				'qrcid'=>$scene_id,
				'name'=>'积分宝充值',
				'keyword'=>"xxjfb".$listid,
				'model'=>1,
				'ticket'=>$ticketstr,
				'expire'=>30*24*3600,
				'createtime'=>time(),
				'status'=>1,
				'url'=>$urlstr,
		);
		pdo_insert('qrcode',$qrcode);
		pdo_insert('jfb_qrcode',array('weid'=>$_GPC['i'] ,'sceneid'=>$scene_id,'ticket'=>$ticketstr,'rid'=>$listid,'url'=>$urlstr));
	
	}
	
		
	public function doWebJfbsetting(){
		global $_W,$_GPC;
			
	
		$kjsetting = pdo_fetch('select * from '.tablename('jfb_setting').'where weid = :weid',array(":weid" => $_W['uniacid']));
	
	
		if (checksubmit('submit')) {
	
			$data = array(
					'weid' => $_W['uniacid'],
						
					'title' => trim($_GPC['title']),
						
					'color' => trim($_GPC['color']),
	
					'headerimg' => trim($_GPC['image']),
	
					'tishi' =>$_GPC['tishi'],
						
					'footerimg' =>$_GPC['footerimg'],
						
					'footerCopyright' =>$_GPC['footerCopyright'],
						
					'appid' =>$_GPC['appid'],
	
					'appsecret' =>$_GPC['appsecret'],
						
					'addrepeat' =>$_GPC['addrepeat'],
			    
			    
			        'xiangqing' =>$_GPC['xiangqing'],
			    
    			    'gongzhonghao' =>$_GPC['gongzhonghao'],
    			    
    			    'mendian' =>$_GPC['mendian'],
    			    
    			    'jifenshop' =>$_GPC['jifenshop'],
    			    
    			    'gongzhonghao1' =>$_GPC['gongzhonghao1'],
    			    
    			    'mendian1' =>$_GPC['mendian1']
			    
			);
	
			if (!empty($kjsetting)) {
	
				pdo_update('jfb_setting',$data,array('id'=>$kjsetting[id]));
				
			} else {
	
				pdo_insert('jfb_setting',$data);
				
			}
	
			message('参数设置成功！', $this->createWebUrl('Jfbsetting', array('op' => 'display')), 'success');
	
		}
	
		include $this->template('jfb-setting');
	}
		
	public function doMobileJilu(){
		global $_W,$_GPC;
			
		$sql1 = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql1,array(':weid'=>$_GPC['i']));
	
		$tsql = 'select m.name as mendian,m.number1,d.name as yuangong from  '.tablename('jfb_mendian').' as m left join '.tablename('jfb_yuangong').' as d on d.mendian = m.id WHERE m.weid = :weid and m.id = :mendian ';
		$tlist = pdo_fetch($tsql,array(':weid'=>$_GPC['i'],':mendian'=>$_GPC['mid']));
	
	
		$mendian_name = $tlist['mendian'];
		$dianyuan_name = $tlist['yuangong'];
		$zfen_number = 0;
		$fen_number = 0;
		$taday_number = 0;		$zfen_number1 = 0;
		$fen_number1 = 0;
		$taday_number1 = 0;		if(empty($_GPC['tid']))$tid = 0;else $tid = $_GPC['tid'];				if($tid==0)		$syjifen = $this->Getsyjifen($_GPC['mid']);		else
		$syjifen = $this->Getsyyue($_GPC['mid']);
			if($tid == 0){
			$zong = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and codetype={$tid} and jftype = 0",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($zong))$zfen_number = $zong;else $zfen_number = 0;		}else{			$zong = pdo_fetchcolumn("SELECT SUM(yuenum) as jifen FROM ".tablename('jfb_jifenjilu')." where yuenum >0 and weid = :weid and dianyuan = :dianyuan and codetype={$tid} and jftype = 0",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($zong))$zfen_number = $zong;else $zfen_number = 0;		}
			if($tid == 0){
			$mouth = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) < 30 and codetype={$tid} and jftype = 0",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($mouth))$fen_number = $mouth;else $fen_number = 0;		}else{			$mouth = pdo_fetchcolumn("SELECT SUM(yuenum) as jifen FROM ".tablename('jfb_jifenjilu')." where yuenum >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime1,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) < 30 and codetype={$tid} and jftype = 0",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($mouth))$fen_number = $mouth;else $fen_number = 0;
					}
			if($tid == 0){
			$taday = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and codetype={$tid} and jftype = 0",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($taday))$taday_number = $taday;else $taday_number = 0;		}else{			$taday = pdo_fetchcolumn("SELECT SUM(yuenum) as jifen FROM ".tablename('jfb_jifenjilu')." where yuenum >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime1,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and codetype={$tid} and jftype = 0",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($taday))$taday_number = $taday;else $taday_number = 0;		}				if($tid == 0){			$zong1 = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and codetype={$tid} and jftype = 1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($zong1))$zfen_number1 = $zong1;else $zfen_number1 = 0;
		}else{			$zong1 = pdo_fetchcolumn("SELECT SUM(yuenum) as jifen FROM ".tablename('jfb_jifenjilu')." where yuenum >0 and weid = :weid and dianyuan = :dianyuan and codetype={$tid} and jftype = 1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($zong1))$zfen_number1 = $zong1;else $zfen_number1 = 0;		}		if($tid == 0){
			$mouth1 = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime1,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) < 30 and codetype={$tid}  and jftype = 1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($mouth1))$fen_number1 = $mouth1;else $fen_number1 = 0;		}else{			$mouth1 = pdo_fetchcolumn("SELECT SUM(yuenum) as jifen FROM ".tablename('jfb_jifenjilu')." where yuenum >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime1,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) < 30 and codetype={$tid}  and jftype = 1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($mouth1))$fen_number1 = $mouth1;else $fen_number1 = 0;		}
				if($tid == 0){
			$taday1 = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime1,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and codetype={$tid}  and jftype = 1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($taday1))$taday_number1 = $taday1;else $taday_number1 = 0;
		}else{			$taday1 = pdo_fetchcolumn("SELECT SUM(yuenum) as jifen FROM ".tablename('jfb_jifenjilu')." where yuenum >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime1,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) < 30 and codetype={$tid}  and jftype = 1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
			if(!empty($mouth1))$taday_number1 = $taday1;else $taday_number1 = 0;		}
			if($tid == 0){
			$sql2 = "select m.nickname,j.jifen as fenshu,j.addtime,j.jftype,d.name as dianyuan from ".tablename('jfb_jifenjilu')." as j left join ".tablename('jfb_yuangong')." as d on j.dianyuan = d.id left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE j.jifen >0 and j.weid = :weid and j.dianyuan = :dianyuan and codetype={$tid} ORDER BY j.addtime DESC LIMIT 0,5";
			$list = pdo_fetchall($sql2,array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
		}else{			$sql2 = "select m.nickname,j.yuenum as fenshu,j.addtime1 as addtime,j.jftype,d.name as dianyuan from ".tablename('jfb_jifenjilu')." as j left join ".tablename('jfb_yuangong')." as d on j.dianyuan = d.id left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE j.yuenum >0 and j.weid = :weid and j.dianyuan = :dianyuan and codetype={$tid} ORDER BY j.addtime1 DESC LIMIT 0,5";
			$list = pdo_fetchall($sql2,array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));		}
		
	
	
		include $this->template('jilu');
	}
	
	public function doMobileJiluitem(){
		global $_W,$_GPC;
	
		$pindex = max(1, intval($_GPC['page']));
	
		$pages = ($pindex - 1) * 5;
	
		if(empty($_GPC['tid']))$tid = 0;else $tid = $_GPC['tid'];
					if($_GPC['tid'] == 0){
			$sql2 = "select m.nickname,j.jifen as fenshu,j.addtime,j.jftype from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE j.weid = :weid and j.dianyuan = :dianyuan and codetype={$tid} ORDER BY j.addtime DESC LIMIT ".$pages.",5";
			$list = pdo_fetchall($sql2,array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
		}else{			$sql2 = "select m.nickname,j.yuenum as fenshu,j.addtime1 as addtime,j.jftype from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE j.weid = :weid and j.dianyuan = :dianyuan and codetype={$tid} ORDER BY j.addtime1 DESC LIMIT ".$pages.",5";
			$list = pdo_fetchall($sql2,array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));		}
		foreach ($list  as $key => $value) {
	
			foreach ($value as $k => $v) {
					
				if($k=='addtime'){
	
					$data[$key][$k]=date('Y-m-d H:i:s',$v);
	
				}
					
			}
	
		}
		if(empty($list)) {
	
			die("nodata");
	
		}
		include $this->template('jiluitem');
	}
	public function doMobileJilu3item(){
		global $_W,$_GPC;
	
		$pindex = max(1, intval($_GPC['page']));
	
		$pages = ($pindex - 1) * 5;
	
		if($_GPC['type']==0){
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and c.mendian = ".$_GPC['mid']." ORDER BY `numtime` DESC LIMIT ".$pages.",5";
	
			$list = pdo_fetchall($sql);
	
		}else{
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_yuecz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and c.mendian = ".$_GPC['mid']." ORDER BY `numtime` DESC LIMIT ".$pages.",5";
	
			$list = pdo_fetchall($sql);
	
		}
	
		if(empty($list)) {
	
			die("nodata");
	
		}
		include $this->template('jilu3item');
	}
	
	public function doMobileJilu1(){
		global $_W,$_GPC;
	
		$sql1 = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql1,array(':weid'=>$_GPC['i']));
	
	
		$tsql = 'select m.name as mendian,m.number1,d.name as yuangong from  '.tablename('jfb_mendian').' as m left join '.tablename('jfb_yuangong').' as d on d.mendian = m.id WHERE m.weid = :weid and m.id = :mendian ';
		$tlist = pdo_fetch($tsql,array(':weid'=>$_GPC['i'],':mendian'=>$_GPC['mid']));
	
	
		$mendian_name = $tlist['mendian'];
		$dianyuan_name = $tlist['yuangong'];
		$zfen_number = 0;
		$fen_number = 0;
		$taday_number = 0;
	
		$zong = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and codetype=1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
		$zfen_number = $zong;
	
		$mouth = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) < 30 and codetype=1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
		$fen_number = $mouth;
	
		$taday = pdo_fetchcolumn("SELECT SUM(jifen) as jifen FROM ".tablename('jfb_jifenjilu')." where jifen >0 and weid = :weid and dianyuan = :dianyuan and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and codetype=1",array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
		$taday_number = $taday;
			
		$sql2 = 'select m.nickname,j.jifen as fenshu,j.addtime,d.name as dianyuan from '.tablename('jfb_jifenjilu').' as j left join '.tablename('jfb_yuangong').' as d on j.dianyuan = d.id left join '.tablename('mc_members').' as m on m.uid = j.mcid WHERE j.jifen >0 and j.weid = :weid and j.dianyuan = :dianyuan and codetype=1 ORDER BY j.addtime DESC LIMIT 0,5';
		$list = pdo_fetchall($sql2,array(':weid'=>$_GPC['i'],':dianyuan'=>$_GPC['id']));
	
		include $this->template('jilu1');
	}
	
	public function doMobileJilu3(){
		global $_W,$_GPC;
	
		$sql1 = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql1,array(':weid'=>$_GPC['i']));
	
	
		$tsql = 'select m.name as mendian,m.number,m.number1,d.name as yuangong from  '.tablename('jfb_mendian').' as m left join '.tablename('jfb_yuangong').' as d on d.mendian = m.id WHERE m.weid = :weid and m.id = :mendian ';
		$tlist = pdo_fetch($tsql,array(':weid'=>$_GPC['i'],':mendian'=>$_GPC['mid']));
			
	
		if($_GPC['cate']==0){
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and c.mendian = ".$_GPC['mid']." ORDER BY `numtime` DESC LIMIT 0,5";
	
			$list = pdo_fetchall($sql);
	
			$jifen_number = $tlist['number'];
	
			$sy_jifen = $this->Getsyjifen($_GPC['mid']);
		}else{
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_yuecz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and c.mendian = ".$_GPC['mid']." ORDER BY `numtime` DESC LIMIT 0,5";
	
			$list = pdo_fetchall($sql);
	
			$jifen_number = $tlist['number1'];
	
			$sy_jifen = $this->Getsyyue($_GPC['mid']);
		}
	
	
		$mendian_name = $tlist['mendian'];
	
	
		include $this->template('jilu3');
	}
			public function doMobileGetCount(){		global $_W,$_GPC;
				$yg_id = $_GPC['id'];		$md_id = $_GPC['mid'];						$mdsql = "SELECT number,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";		$md_list = pdo_fetch($mdsql,array(':weid'=>$_W['uniacid'],':id'=>$md_id));		
		if(!empty($md_list)){
			if($md_list['number'] != '0'){//from_unixtime(addtime,'%Y-%m-%d %H:%i')>=from_unixtime(:numtime, '%Y-%m-%d %H:%i') and
				$jf_list = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and mendian = :mendian and codetype = 0 and jftype = 0",array(":weid"=>$_W['uniacid'],":mendian"=>$md_id));
		
				//if($_GPC['buttype']!=1&&$_GPC['jftype']!=1){
				$mdsyjifen = $md_list['number']-$jf_list;
				//}
		
		
			}else
				$mdsyjifen = 0;
		}else
			$mdsyjifen = 0;
		

		$mdsql = "SELECT number1,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$md_list = pdo_fetch($mdsql,array(':weid'=>$_W['uniacid'],':id'=>$md_id));
		
		
		if(!empty($md_list)){
			if($md_list['number1'] != '0'){
				$yelist = pdo_fetchcolumn("select SUM(yuenum) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and mendian = :mendian and codetype = 1 and jftype = 0",array(":weid"=>$_W['uniacid'],":mendian"=>$md_id));
		
				//if($_GPC['buttype']!=1&&$_GPC['jftype']!=1){
				$mdsyyue = $md_list['number1']-$yelist;
				//}
		
			}else
				$mdsyyue = 0;
		}else
			$mdsyyue = 0;
		

		$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and codetype = 0 and jftype = 0 and dianyuan = :dianyuan",array(":weid"=>$_GPC['i'],":dianyuan"=>$yg_id));
		
		$yelist = pdo_fetchcolumn("select SUM(yuenum) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0  and codetype = 1 and jftype = 0 and dianyuan = :dianyuan",array(":weid"=>$_GPC['i'],":dianyuan"=>$yg_id));
				if(empty($jflist))			$jflist = 0;		if(empty($yelist))
			$yelist = 0;
		
		echo json_encode(array('syjf'=>$mdsyjifen,'syyue'=>$mdsyyue,'jflist'=>$jflist,'yelist'=>$yelist));
			}
	
	public function Getsyjifen($mdid){
		global $_W,$_GPC;
	
		$sql = "SELECT number,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$mdlist = pdo_fetch($sql,array(':weid'=>$_W['uniacid'],':id'=>$mdid));
	
	
		if(!empty($mdlist)){
			if($mdlist['number'] != '0'){//from_unixtime(addtime,'%Y-%m-%d %H:%i')>=from_unixtime(:numtime, '%Y-%m-%d %H:%i') and
				$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and mendian = :mendian and codetype = 0 and jftype = 0",array(":weid"=>$_W['uniacid'],":mendian"=>$mdid));
								//if($_GPC['buttype']!=1&&$_GPC['jftype']!=1){
				$mdsyjifen = $mdlist['number']-$jflist;				//}
	
				return $mdsyjifen;
			}else
				return "";
		}else
			return "";
	}
	public function Getsyyue($mdid){
		global $_W,$_GPC;
	
		$sql = "SELECT number1,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$mdlist = pdo_fetch($sql,array(':weid'=>$_W['uniacid'],':id'=>$mdid));
	
	
		if(!empty($mdlist)){
			if($mdlist['number1'] != '0'){
				$jflist = pdo_fetchcolumn("select SUM(yuenum) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and mendian = :mendian and codetype = 1 and jftype = 0",array(":weid"=>$_W['uniacid'],":mendian"=>$mdid));
					//if($_GPC['buttype']!=1&&$_GPC['jftype']!=1){
					$mdsyjifen = $mdlist['number1']-$jflist;
				//}
				return $mdsyjifen;
			}else
				return "";
		}else
			return "";
	}
	
	
	public function doWebMendian() {
	
		global $_W, $_GPC;
	
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 20;
	
	
		if(empty($_GPC['name']))
			$list = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
		else
			$list = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' and name like '%".$_GPC['name']."%' ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
	
	
	
		if (!empty($list)) {
	
			if(empty($_GPC['name']))
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC");
			else
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' and name like '%".$_GPC['name']."%' ORDER BY id DESC");
				
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		include $this->template('mendian-list');
	}
	
	
	public function doWebMendianadd() {
	
		global $_W, $_GPC;
	
		$id = intval($_GPC['id']);
	
	
		if(!empty($id)){
	
			$item = pdo_fetch("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' AND id = '".$id."'");
	
		}
	
	
	
	
		include $this->template('mendian-add');
	}
	
	public function doWebMendianaddok(){
	
		global $_W,$_GPC;
	
		$id = intval($_GPC['id']);
	
	
		if(checksubmit('submit')){
	
			if(empty($_GPC['name'])){
					
				message("门店名称不能为空");
					
			}
	
			if(empty($_GPC['phone'])){
					
				message("门店电话不能为空");
					
			}
	
			$data = array(
	
					'weid' => $_W['uniacid'],
	
					'name' => $_GPC['name'],
	
					'addess' => $_GPC['addess'],
	
					'phone' => $_GPC['phone'],										'ifhui' => $_GPC['ifhui'],
	
					'addtime' => time()
	
			);
			
	
			if(empty($id)){
				pdo_insert('jfb_mendian', $data);
	
				message('数据添加成功！', $this->createWebUrl('mendian', array()), 'success');
			}else {
				pdo_update('jfb_mendian', $data, array('id'=>$id));
	
				message('数据修改成功！', $this->createWebUrl('mendian', array()), 'success');
			}
		}
	}
	
	public function doWebMendiandelete() {
		global $_W,$_GPC;
	
	
		$id = intval($_GPC['id']);
	
	
	
		pdo_delete('jfb_mendian', array('id' => $id));
	
	
	
		message('删除成功！', $this->createWebUrl('mendian', array()), 'success');
	}
		
	public function doWebDianyuan() {
		global $_W,$_GPC;
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 20;
	
	
		$sql = "SELECT yg.*,md.id as mid,md.name as mendianname FROM " . tablename('jfb_yuangong') . " as yg left join ". tablename('jfb_mendian') ." as md on yg.mendian = md.id  WHERE yg.weid = '".$_W['uniacid']."' ORDER BY `id` DESC ";
	
		$list = pdo_fetchall($sql);
	
		if (!empty($list)) {
	
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_yuangong')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC");
	
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		include $this->template('dianyuan-list');
	}
	
	
	public function doWebDianyuanadd() {
		global $_W,$_GPC;
	
	
		$id = intval($_GPC['id']);
	
	
		if(!empty($id)){
	
			$item = pdo_fetch("SELECT * FROM ".tablename('jfb_yuangong')." WHERE weid = '".$_W['uniacid']."' AND id = '".$id."'");
	
		}
	
		$sql = "SELECT id,name FROM " . tablename('jfb_mendian') . " WHERE weid = '".$_W['uniacid']."' ORDER BY `id` DESC ";
	
		$list = pdo_fetchall($sql);
	
	
	
	
		include $this->template('dianyuan-add');
	}
	
	
	public function doWebDianyuanaddok() {
		global $_W,$_GPC;
	
		$id = intval($_GPC['id']);
	
	
		if(checksubmit('submit')){
	
			if(empty($_GPC['name'])){
					
				message("店员姓名不能为空");
					
			}
			if(empty($_GPC['phone'])){
					
				message("店员电话不能为空");
					
			}
			if(empty($_GPC['weixin'])){
					
				message("店员微信不能为空");
					
			}
			if($_GPC['ddlmendian'] == "0"){
					
				message("请选择门店");
					
			}
	
			/*
			if(empty($id)){
					
				$random = $this->random(4);
	
				$random = $this->checkRandom($random);
					
			}else{
					
				$random = $_GPC['flag'];
					
			}			*/
	
			$data = array(
	
					'weid' => $_W['uniacid'],
	
					'name' => $_GPC['name'],
	
					'mendian' => $_GPC['ddlmendian'],
	
					'phone' => $_GPC['phone'],
	
					'weixin' => $_GPC['weixin'],
	
					'flag' => 1,
						
					'addyue' => $_GPC['addyue'],
	
					'addtime' => time()
	
			);
	
			if(empty($id)){
				pdo_insert('jfb_yuangong', $data);
	
				message('数据添加成功！', $this->createWebUrl('dianyuan', array()), 'success');
	
					
			}else {
				pdo_update('jfb_yuangong', $data, array('id'=>$id));
					
				message('数据修改成功！', $this->createWebUrl('dianyuan', array()), 'success');
			}
		}
	
	
	}
	
	
	public function doWebDianyuandelete() {
		global $_W,$_GPC;
	
		$id = intval($_GPC['id']);
	
	
	
		pdo_delete('jfb_yuangong', array('id' => $id));
		pdo_delete('jfb_yuangong', array('mendian' => $id));
		pdo_delete('jfb_jifenlist', array('mendian' => $id));
	
	
		message('删除成功！', $this->createWebUrl('dianyuan', array()), 'success');
	}
	
	
	public function doWebyewu(){
		global $_W,$_GPC;
	
	
		$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
	
		$dopost = $_GPC['dopost'];
		if($dopost=='save'){
	
			$id = $_GPC['id'];
	
			pdo_update('jfb_jifenjilu',array('content'=>$_GPC['mark']),array('id'=>$id));
	
			exit;
	
		}
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		if(!empty($_GPC['ddlmendian'])){
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.dianyuan left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.codetype = 0  ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
		}else{
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.dianyuan left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.codetype = 0 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}
	
	
	
		if (!empty($list)) {
	
			if(!empty($_GPC['ddlmendian'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." WHERE weid = :weid and mendian = :mendian and codetype = 0 ",array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." WHERE weid = :weid and codetype = 0",array(":weid" => $_W['uniacid']));
			}
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
	
		if($_GPC['op'] == 'ywexcel'){
			$name = '积分记录';
				
			$title = array(array('name'=>'门店','width'=>40),array('name'=>'店员','width'=>30),array('name'=>'昵称','width'=>50),array('name'=>'获得积分'),array('name'=>'获得时间','width'=>50));
			if(empty($_GPC['ddlmendian']) || $_GPC['ddlmendian'] == 0){
				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.jifen,j.jftype,FROM_UNIXTIME(j.addtime,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.dianyuan left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.codetype = 0 ORDER BY j.addtime DESC ";
				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid']));
			}else{
				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.jifen,j.jftype,FROM_UNIXTIME(j.addtime,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.dianyuan left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.codetype = 0 ORDER BY j.addtime DESC ";
				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}
				
				
			foreach ($list1 as $key => $value) {
					
				$i = 0;
				if($value['jftype'] == 1)
					$value['jifen'] = '-'.$value['jifen'];
				else
					$value['jifen'] = $value['jifen'];
	
				foreach ($value as $k => $v) {
						
					$data[$key][$i]= $v ;
						
					$i++;
						
				}
					
			}
				
			$this->_pushExcel($title,$data,$name);
				
		}
	
		include $this->template('yewu-jilu');
	}
	
	public function doWebyewujilu1(){
		global $_W,$_GPC;
	
	
		$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		if(!empty($_GPC['ddlmendian'])){
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.dianyuan left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.codetype = 1 ORDER BY j.addtime1 DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
		}else{
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.dianyuan left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.codetype = 1 ORDER BY j.addtime1 DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}
	
	
	
		if (!empty($list)) {
	
			if(!empty($_GPC['ddlmendian'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." WHERE weid = :weid and mendian = :mendian and codetype = 1",array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." WHERE weid = :weid and codetype = 1",array(":weid" => $_W['uniacid']));
			}
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		if($_GPC['op'] == 'czexcel'){
			$name = '余额记录';
				
				
			$title = array(array('name'=>'门店','width'=>40),array('name'=>'店员','width'=>30),array('name'=>'昵称','width'=>50),array('name'=>'获得余额'),array('name'=>'获得时间','width'=>50));
			if(!empty($_GPC['ddlmendian'])|| $_GPC['ddlmendian'] == 0){
				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.yuenum,FROM_UNIXTIME(j.addtime1,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.dianyuan left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.codetype = 1 ORDER BY j.addtime DESC";
				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.yuenum,FROM_UNIXTIME(j.addtime1,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.dianyuan left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.codetype = 1 ORDER BY j.addtime DESC LIMIT ";
				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid']));
			}
			foreach ($list1 as $key => $value) {
					
				$i = 0;
					
				foreach ($value as $k => $v) {
	
					$data[$key][$i]= $v ;
	
					$i++;
	
				}
					
			}
	
			$this->_pushExcel($title,$data,$name);
	
		}
	
	
		include $this->template('yewu-jilu1');
	}
	public function doWebRecover(){		global $_W,$_GPC;						$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
		
		
		$pindex = max(1, intval($_GPC['page']));
		
		$psize = 15;
		
		if(!empty($_GPC['ddlmendian'])){
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_recover').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.yuangong left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.type = 0 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
		}else{
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_recover').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.yuangong left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.type = 0 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}
		
		
		
		if (!empty($list)) {
		
			if(!empty($_GPC['ddlmendian'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_recover')." WHERE weid = :weid and mendian = :mendian and type = 0",array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_recover')." WHERE weid = :weid and type = 0",array(":weid" => $_W['uniacid']));
			}
			$pager = pagination($total, $pindex, $psize);
		
			unset($row);
		
		}
		
		if($_GPC['op'] == 'jfexcel'){
			$name = '积分回收记录';
		
		
			$title = array(array('name'=>'门店','width'=>40),array('name'=>'店员','width'=>30),array('name'=>'昵称','width'=>50),array('name'=>'回收积分'),array('name'=>'回收时间','width'=>50));
			if(!empty($_GPC['ddlmendian'])|| $_GPC['ddlmendian'] == 0){
				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.number,FROM_UNIXTIME(j.addtime,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_recover')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.yuangong left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.type = 0 ORDER BY j.addtime DESC";
				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.number,FROM_UNIXTIME(j.addtime,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_recover')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.yuangong left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.type = 0 ORDER BY j.addtime DESC LIMIT ";
				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid']));
			}
			foreach ($list1 as $key => $value) {
					
				$i = 0;
					
				foreach ($value as $k => $v) {
		
					$data[$key][$i]= $v ;
		
					$i++;
		
				}
					
			}
		
			$this->_pushExcel($title,$data,$name);
		
		}
						include $this->template('recoverlist');	}		public function doWebRecover1(){
		global $_W,$_GPC;
				$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");						$pindex = max(1, intval($_GPC['page']));				$psize = 15;				if(!empty($_GPC['ddlmendian'])){			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_recover').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.yuangong left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.type = 1 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));		}else{			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_recover').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.yuangong left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.type = 1 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));		}								if (!empty($list)) {					if(!empty($_GPC['ddlmendian'])){				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_recover')." WHERE weid = :weid and mendian = :mendian and type = 1",array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));			}else{				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_recover')." WHERE weid = :weid and type = 1",array(":weid" => $_W['uniacid']));			}			$pager = pagination($total, $pindex, $psize);					unset($row);				}				if($_GPC['op'] == 'jfexcel'){			$name = '余额回收记录';							$title = array(array('name'=>'门店','width'=>40),array('name'=>'店员','width'=>30),array('name'=>'昵称','width'=>50),array('name'=>'回收余额'),array('name'=>'回收时间','width'=>50));			if(!empty($_GPC['ddlmendian'])|| $_GPC['ddlmendian'] == 0){				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.number,FROM_UNIXTIME(j.addtime,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_recover')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.yuangong left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.type = 1 ORDER BY j.addtime DESC";				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));			}else{				$sql1 = "select d.name as mdname,y.name as ygname,m.nickname,j.number,FROM_UNIXTIME(j.addtime,'%Y-%m-%d %H:%i:%s') from ".tablename('jfb_recover')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.yuangong left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE j.weid = :weid and j.type = 1 ORDER BY j.addtime DESC LIMIT ";				$list1 = pdo_fetchall($sql1,array(":weid" => $_W['uniacid']));			}			foreach ($list1 as $key => $value) {									$i = 0;									foreach ($value as $k => $v) {							$data[$key][$i]= $v ;							$i++;						}								}					$this->_pushExcel($title,$data,$name);				}
	
		include $this->template('recoverlist1');
	}	
	public function doWebZqadd(){
		global $_W,$_GPC;
	
		$item = pdo_fetch('select * from '.tablename('jfb_zqsetting').'where weid = :weid',array(":weid" => $_W['uniacid']));
	
	
		include $this->template('zqadd');
	}
	
	public function doWebZqaddok(){
		global $_W,$_GPC;
	
		$setting = pdo_fetch('select * from '.tablename('jfb_zqsetting').'where weid = :weid',array(":weid" => $_W['uniacid']));
	
	
		if (checksubmit('submit')) {
	
			$data = array(
					'weid' => $_W['uniacid'],
	
					'template' => trim($_GPC['template']),
	
					'msgcon' => trim($_GPC['msgcon']),
	
					'turl' => trim($_GPC['turl']),
	
					'tbottom' => trim($_GPC['tbottom'])
			);
	
			if (!empty($setting)) {
	
				pdo_update('jfb_zqsetting',$data,array('id'=>$setting[id]));
				//DBUtil::updateById(DBUtil::$TABLE_WKJ_SETTING, $data, $kjsetting['id']);
	
			} else {
	
				pdo_insert('jfb_zqsetting',$data);
				//DBUtil::create(DBUtil::$TABLE_WKJ_SETTING, $data);
	
			}
	
			message('参数设置成功！', $this->createWebUrl('zqlist', array('op' => 'display')), 'success');
		}
	
	
	}
	
	public function doWebZqlist(){
		global $_W,$_GPC;
	
	
		$start = $_GPC['start'];
		$end = $_GPC['end'];
		if($start == 0)
			$start = TIMESTAMP;
		if($end == 0)
			$end  = TIMESTAMP;
		if($start != 0)
			$end = strtotime("-".$start." day");
		if($end != 0)
			$start = strtotime("-".$end." day");
	
		if(!empty($_GPC['start'])){
			$start = strtotime("-".$_GPC['start']." day");
		}
		if(!empty($_GPC['end'])){
			$end = strtotime("-".$_GPC['end']." day");
		}
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 10;
	
		if(empty($_GPC['start']) && empty($_GPC['end'])){
						$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid   WHERE j.weid = :weid group by m.uid ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
	
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}else{
			if(!empty($_GPC['start'])){
				$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from '.tablename('jfb_jifenjilu').'  as j left join '.tablename('mc_members').' as m on m.uid = j.mcid WHERE j.weid = :weid and addtime <=:start  group by m.uid ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
				$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":start" => $start));
			}
			if(!empty($_GPC['end'])){
				$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from '.tablename('jfb_jifenjilu').'  as j left join '.tablename('mc_members').' as m on m.uid = j.mcid WHERE j.weid = :weid  AND addtime >= :end  group by m.uid ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
				$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":end" => $end));
			}
						if(!empty($_GPC['start'])&&!empty($_GPC['end'])){
				$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from '.tablename('jfb_jifenjilu').'  as j left join '.tablename('mc_members').' as m on m.uid = j.mcid WHERE j.weid = :weid and addtime <=:start  group by m.uid AND addtime >= :end ORDER BY j.addtime DESC  LIMIT '.($pindex - 1) * $psize.",{$psize}";
				$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":start" => $start,":end" => $end));
			}
		}
	
	
		if (!empty($list)) {
	
			if(empty($_GPC['start']) && empty($_GPC['end'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE weid = :weid group by m.uid ",array(":weid" => $_W['uniacid']));
			}else{
				if(!empty($_GPC['start']))
					$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE weid = :weid and addtime <=:start group by m.uid ",array(":weid" => $_W['uniacid'],":start" => $start));
				if(!empty($_GPC['end']))
					$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE weid = :weid AND addtime >= :end group by m.uid ",array(":weid" => $_W['uniacid'],":end" => $end));
				if(!empty($_GPC['start'])&&!empty($_GPC['end']))
					$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE weid = :weid and addtime <=:start AND addtime >= :end group by m.uid ",array(":weid" => $_W['uniacid'],":start" => $start,":end" => $end));
			}
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		$dopost = $_GPC['dopost'];
	
		//$this->SendTemplate('324294','11');
	
		if($dopost=='save'){
	
			$id = $_GPC['id'];
	
			pdo_update('jfb_jifenjilu',array('bzcon'=>$_GPC['mark']),array('id'=>$id));
	
			exit;
	
		}
		if($dopost=='send'){
	
			$id = $_GPC['id'];
	
	
	
			$this->SendTemplate($id,$_GPC['mark']);
	
			exit;
	
		}
	
		include $this->template('zqlist');
	}
	
	public function doWebCzlist(){
		global $_W,$_GPC;
	
	
		$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		if(!empty($_GPC['ddlmendian'])){
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and m.id = ".$_GPC['ddlmendian']." ORDER BY `numtime` DESC ";
	
			$list = pdo_fetchall($sql);
		}else{
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' ORDER BY `numtime` DESC ";
				
			$list = pdo_fetchall($sql);
		}
	
		if (!empty($list)) {
	
			if(!empty($_GPC['ddlmendian'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifencz')." WHERE weid = :weid and mendian = :mendian ",array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifencz')." WHERE weid = :weid  ",array(":weid" => $_W['uniacid']));
			}
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
	
		if($_GPC['op'] == 'jfexcel'){
			$name = '积分记录';
	
			$title = array(array('name'=>'门店','width'=>40),array('name'=>'充值积分'),array('name'=>'获得时间','width'=>50));
			if(empty($_GPC['ddlmendian']) || $_GPC['ddlmendian'] == 0){
				$sql1 = "SELECT m.name,c.number,FROM_UNIXTIME(c.numtime,'%Y-%m-%d %H:%i:%s') FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' ORDER BY c.numtime DESC ";
					
				$list1 = pdo_fetchall($sql1);
	
			}else{
				$sql1 = "SELECT m.name,c.number,FROM_UNIXTIME(c.numtime,'%Y-%m-%d %H:%i:%s') FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and m.id = ".$_GPC['ddlmendian']." ORDER BY c.numtime DESC ";
	
				$list1 = pdo_fetchall($sql1);
			}
	
	
			foreach ($list1 as $key => $value) {
					
				$i = 0;
					
				foreach ($value as $k => $v) {
	
					$data[$key][$i]= $v ;
	
					$i++;
	
				}
					
			}
	
			$this->_pushExcel($title,$data,$name);
	
		}
	
	
	
	
		include $this->template('czlist');
	}
	
	public function doWebCzadd(){
		global $_W,$_GPC;
	
	
		$sql = "SELECT id,name FROM " . tablename('jfb_mendian') . " WHERE weid = '".$_W['uniacid']."' ORDER BY `id` DESC ";
	
		$list = pdo_fetchall($sql);
	
		include $this->template('czadd');
	}
	
	public function doWebCzaddok(){
		global $_W,$_GPC;
		$jifennum = 0;
		$jifennum = pdo_fetchcolumn('select number from '.tablename('jfb_mendian').' where weid = :weid and id = :id',array(':weid' => $_W['uniacid'],':id' => $_GPC['ddlmendian']));
	
	
		if($jifennum >= 0)
			$jifennum = $jifennum + $_GPC['number'];
	
		$data = array(
				'weid' => $_W['uniacid'],
	
				'mendian' => $_GPC['ddlmendian'],
	
				'number' => $_GPC['number'],
	
				'numtime' => TIMESTAMP
		);
	
		pdo_insert('jfb_jifencz',$data);
	
		pdo_update('jfb_mendian',array('number'=>$jifennum,'numtime'=>TIMESTAMP),array('id'=>$_GPC['ddlmendian']));
	
		message('积分设置成功！', $this->createWebUrl('czlist', array('op' => 'display')), 'success');
	}
			public function doWebCzlist1(){
		global $_W,$_GPC;
	
	
		$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		if(!empty($_GPC['ddlmendian'])){
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_yuecz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."'  and m.id = ".$_GPC['ddlmendian']." ORDER BY `numtime` DESC ";
	
			$list = pdo_fetchall($sql);
		}else{
			$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_yuecz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' ORDER BY `numtime` DESC ";
				
			$list = pdo_fetchall($sql);
		}
	
		if (!empty($list)) {
				
			if(!empty($_GPC['ddlmendian'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_yuecz')." WHERE weid = :weid and mendian = :mendian ",array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_yuecz')." WHERE weid = :weid ",array(":weid" => $_W['uniacid']));
			}
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		if($_GPC['op'] == 'yeexcel'){
			$name = '余额记录';
	
			$title = array(array('name'=>'门店','width'=>40),array('name'=>'充值余额'),array('name'=>'获得时间','width'=>50));
			if(empty($_GPC['ddlmendian']) || $_GPC['ddlmendian'] == 0){
				$sql1 = "SELECT m.name,c.number,FROM_UNIXTIME(c.numtime,'%Y-%m-%d %H:%i:%s') FROM " . tablename('jfb_yuecz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' ORDER BY c.numtime DESC ";
					
				$list1 = pdo_fetchall($sql1);
			}else{
				$sql1 = "SELECT m.name,c.number,FROM_UNIXTIME(c.numtime,'%Y-%m-%d %H:%i:%s') FROM " . tablename('jfb_yuecz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' and m.id = ".$_GPC['ddlmendian']." ORDER BY c.numtime DESC ";
	
				$list1 = pdo_fetchall($sql1);
			}
	
	
			foreach ($list1 as $key => $value) {
					
				$i = 0;
					
				foreach ($value as $k => $v) {
	
					$data[$key][$i]= $v ;
	
					$i++;
	
				}
					
			}
	
			$this->_pushExcel($title,$data,$name);
	
		}
	
	
		include $this->template('czlist1');
	}
	
	public function doWebCzadd1(){
		global $_W,$_GPC;
	
	
		$sql = "SELECT id,name FROM " . tablename('jfb_mendian') . " WHERE weid = '".$_W['uniacid']."' ORDER BY `id` DESC ";
	
		$list = pdo_fetchall($sql);
	
		include $this->template('czadd1');
	}
	
	public function doWebCzaddok1(){
		global $_W,$_GPC;
	
		$jifennum = 0;
		$jifennum = pdo_fetchcolumn('select number1 from '.tablename('jfb_mendian').' where weid = :weid and id = :id',array(':weid' => $_W['uniacid'],':id' => $_GPC['ddlmendian']));
	
		if($jifennum >= 0)
			$jifennum = $jifennum + $_GPC['number'];
	
		$data = array(
				'weid' => $_W['uniacid'],
	
				'mendian' => $_GPC['ddlmendian'],
	
				'number' => $_GPC['number'],
	
				'numtime' => TIMESTAMP
		);
	
		pdo_insert('jfb_yuecz',$data);
	
		pdo_update('jfb_mendian',array('number1'=>$jifennum,'numtime'=>TIMESTAMP),array('id'=>$_GPC['ddlmendian']));
	
		message('余额设置成功！', $this->createWebUrl('czlist1', array('op' => 'display')), 'success');
	}
			public function doWebhylist(){
		global $_W,$_GPC;
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		
		if(!empty($_GPC['hyname'])){
			$sql = 'select j.id, m.nickname,m.createtime,m.credit1,m.credit2 from '.tablename('mc_members').' as m left join '.tablename('jfb_jifenjilu').' as j on m.uid = j.mcid  WHERE j.weid = :weid  and m.nickname = :nickname GROUP BY m.nickname ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":nickname" => $_GPC['hyname']));
		}else{
			$sql = 'select j.id, m.nickname,m.createtime,m.credit1,m.credit2 from '.tablename('mc_members').' as m left join '.tablename('jfb_jifenjilu').' as j on m.uid = j.mcid  WHERE j.weid = :weid GROUP BY m.nickname ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}
	
		if (!empty($list)) {
				
			if(!empty($_GPC['hyname'])){
				$total = pdo_fetchcolumn("SELECT COUNT(distinct m.nickname) FROM ".tablename('mc_members')." as m left join ".tablename('jfb_jifenjilu')." as j on m.uid = j.mcid WHERE j.weid = :weid and m.nickname = :nickname ORDER BY j.addtime DESC ",array(":weid" => $_W['uniacid'],":nickname" => $_GPC['hyname']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(distinct m.nickname) FROM ".tablename('mc_members')." as m left join ".tablename('jfb_jifenjilu')." as j on m.uid = j.mcid WHERE j.weid = :weid  ORDER BY j.addtime DESC ",array(":weid" => $_W['uniacid']));
			}
				
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		include $this->template('hylist');
	}
	public function gethy_jfnum($id){
		global $_W,$_GPC;
	
		$jflist = pdo_fetchcolumn("select SUM(jifen) FROM ".tablename('jfb_jifenjilu')." where id =".$id." and jftype = 0 and weid = ".$_W['uniacid']."");
	
		$jflist1 = pdo_fetchcolumn("select SUM(jifen) FROM ".tablename('jfb_jifenjilu')." where id =".$id." and jftype = 1 and weid = ".$_W['uniacid']."");
	
		return $jflist - $jflist1;
	}
	
	public function doWebhylists(){
		global $_W,$_GPC;
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
	
		$sql = "select j.jifen,j.addtime,j.jftype,j.yuenum,j.addtime1,j.codetype,m.nickname,y.name as ygname,d.name as mdname from ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong')." as y on y.id = j.dianyuan left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE m.nickname = :nickname and  j.weid = :weid ORDER BY j.id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}";
		$list = pdo_fetchall($sql,array(":nickname" => $_GPC['nick'],":weid" => $_W['uniacid']));
	
	
	
		if (!empty($list)) {
	
				
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid left join ".tablename('jfb_yuangong')." as y on y.id = j.dianyuan left join ".tablename('jfb_mendian')." as d on d.id = j.mendian WHERE m.nickname = :nickname and j.weid = :weid",array(":nickname" => $_GPC['nick'],":weid" => $_W['uniacid']));
				
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
		}
	
		include $this->template('hylists');
	}
	
	public function getPreCode($mid){
		global $_W;
	
		$sql = 'select addtime from '.tablename('jfb_jifenjilu').' where weid = :weid and mcid = :mcid  ORDER BY addtime DESC LIMIT 1,1';
		$list = pdo_fetch($sql,array(":weid" => $_W['uniacid'],":mcid" => $mid));
		if(empty($list)){
			return "";
		}else{
			return date("Y-m-d H:i:s",$list['addtime']);
		}
	
	}
	
	
	public function SendTemplate($mcid,$day){
		global $_W;
	
		$sql = "SELECT appid,appsecret FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql,array(':weid'=>$_W['uniacid']));
	
		$sql1 = "SELECT template,msgcon FROM " . tablename('jfb_zqsetting') . " WHERE weid = :weid";
		$send = pdo_fetch($sql1,array(':weid'=>$_W['uniacid']));
	
		$sql2 = "SELECT f.openid,m.nickname FROM " . tablename('mc_mapping_fans') . " as f left join ".tablename('mc_members')." as m on f.uid = m.uid WHERE f.uniacid = :uniacid and f.uid =:uid";
		$user = pdo_fetch($sql2,array(':uniacid'=>$_W['uniacid'],':uid'=>$mcid));
	
		$str = str_replace('{num}',$day,$send['msgcon']);
	
		if(!empty($setting['appid'])){
				
			if($this->exists_tokenBytxt($setting['appid'])){
				if($this->exprise_tokenBytxt($setting['appid'])){
					$token = $this->getToken($setting['appid'], $setting['appsecret']);
	
					unlink($setting['appid'].'.txt');
	
					file_put_contents($setting['appid'].'.txt', $token);
				}else {
					$token = file_get_contents($setting['appid'].'.txt');
				}
			}else{
				$token = $this->getToken($setting['appid'], $setting['appsecret']);
				file_put_contents($setting['appid'].'.txt', $token);
			}
	
			//print('openid:'.$user['openid'].';token:'.$token);
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
			$message['touser'] = $user['openid'];
			$message['template_id'] = $send['template'];
			$message['url'] = '';
			$message['topcolor'] = '#ff0000';
	
			$message['data']['first'] = array(
					"value"=>"亲爱的".$user['nickname'].':'.$str,
					"color"=>"#173177"
			);
			$message['data']['keyword1'] = array(
					"value"=>'会员提醒',
					"color"=>"#173177"
			);
			$message['data']['keyword2'] = array(
					"value"=>date('Y-m-d H:i:s',TIMESTAMP),
					"color"=>"#173177"
			);
			$message['data']['remark'] = array(
					"value"=>"★祝您生活愉快,我们期待您的光临★",//
					"color"=>"#173177"
			);
			$json = json_encode($message,JSON_UNESCAPED_UNICODE);
			$xx_ret = $this->request_post($url,$json);
			$xx_ret = json_decode($xx_ret,true);
	
			print_r($xx_ret);
			if($xx_ret['errcode'] != 0){
				$tokens = $this->GetTokens($setting['appid'], $setting['appsecret']);
				$url2 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tokens;
	
				$json2 = json_encode($message,JSON_UNESCAPED_UNICODE);
				$ret2 = $this->request_post($url2,$json2);
	
				print($ret2);
			}
		}
	}
	
	
	//判断文件时否存在
	protected function exists_tokenBytxt($txtstr){
		if(file_exists($txtstr.'.txt')){
			return true;
		}else{
			return false;
		}
	}
	//获取token.txt的创建时间
	protected function exprise_tokenBytxt($txtstr){
		$ctime = filectime($txtstr.'.txt');
		if((time() - $ctime )>=5000){
			return true;
		}else{
			return false;
		}
	}
	protected function getToken($appid, $appsecret)
	{
		$curl = curl_init();
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		$res = curl_exec($curl);
		curl_close($curl);
		$obj = json_decode($res,true);
	
		return $obj['access_token'];
	
	}
	function request_post($url = '', $param = '')
	{
		if (empty($url) || empty($param)) {
			return false;
		}
		$postUrl = $url;
		$curlPost = $param;
		$ch = curl_init(); //初始化curl
		curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch); //运行curl
		curl_close($ch);
		return $data;
	}
	function request_get($url = '')
	{
		if (empty($url)) {
			return false;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	public function GetTokens($appid, $appsecret){
	
		$urls = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
		$ress = json_decode($this->httpGet($urls));
		$tokenss = $ress->access_token;
	
		return $tokenss;
	}
	
	
	public function _pushExcel($title=array(),$data=array(),$name){
	
		$ichar =  ord("A"); //初始节点头A
	
		$_file = $name."(编号:".time().").xls";//定义文件名
	
		$_file = iconv("utf-8", "gb2312", $_file);
	
	
	
		$objPHPExcel = new PHPExcel(); //实例化 phpexcel类
	
		$objProps = $objPHPExcel->getProperties();
	
		//设置表头
	
	
	
		foreach($title as $k => $v){
	
			$colum = chr($ichar);
	
			$objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v['name']);
	
			$v['width'] = empty($v['width'])?10:$v['width'];
	
			$objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth($v['width']); //设置宽度
	
			$ichar += 1;
	
		}
	
		//内容列表
	
		$column = 2;
	
		$objActSheet = $objPHPExcel->getActiveSheet();
	
		foreach($data as $key => $rows){ //行写入
	
			$span = ord("A");
	
			foreach($rows as $keyName=>$value){// 列写入
	
				$j = chr($span);
	
				$objActSheet->setCellValueExplicit($j.$column, $value, PHPExcel_Cell_DataType::TYPE_STRING);
	
				$span++;
	
			}
	
			$column++;
	
		}
	
		//重命名表
	
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
	
		//设置活动单指数到第一个表,所以Excel打开这是第一个表
	
		$objPHPExcel->setActiveSheetIndex(0);
	
		//将输出重定向到一个客户端web浏览器(Excel2007)
	
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	
		header("Content-Disposition: attachment; filename=\"$_file\"");
	
		header('Cache-Control: max-age=0');
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
		$objWriter->save('php://output');
	
		exit;
	
	
	
	}}