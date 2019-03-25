<?php
/**
 * 积分宝模块微站定义
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
ini_set('date.timezone','Asia/Shanghai');
define('OD_ROOT', IA_ROOT . '/addons/jlsh_jfb');

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
	
	
	public function doMobileIndex(){
		global $_W,$_GPC;				
		
		$dysql = "SELECT weixin,addyue FROM " . tablename('jfb_yuangong') . " WHERE weid = :weid and id = :id";
		$dylist = pdo_fetch($dysql,array(':weid'=>$_GPC['i'],':id'=>$_GPC['id']));
		
		
		$sql = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql,array(':weid'=>$_GPC['i']));
		
		if(!empty($setting['appid'])){
			if(!$this->Getopenid($dylist['weixin'], $setting['appid'], $setting['appsecret'])){
				message('您还不是店员！');
				exit();
			}
		}
		
		if($dylist['addyue'] == 1)
			$Showyue = true;
		
		
		
		
		$imgs = "";
		if(!empty($_GPC['show'])|| !empty($_GPC['type'])){			
			$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$_GPC['ticket'];		
		}		
			
				
		
			
		$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and DATEDIFF(from_unixtime(addtime,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) = 0 and dianyuan = :dianyuan",array(":weid"=>$_GPC['i'],":dianyuan"=>$_GPC['id']));
		
		if(!empty($jflist)){
			$jifencount = $jflist;
		}
		else {
			$jifencount = 0;
		}
		
		/*$list1 = pdo_fetch('select * from '.tablename('jfb_jifenjilu'));				
		 * print_r($list1);				
		 * $list2 =pdo_fetch('select * from '.tablename('qrcode'));				
		 * print_r($list2);				
		 * $list3 =pdo_fetch('select * from '.tablename('rule').' where id = 2628');		
		 * */				
		 
		 if (checksubmit('submit')) {
		 	
			if(!empty($_GPC['jifen'])){
				if(is_numeric($_GPC['jifen'])){
					
					$dqjifen = $this->mendiannumber($_GPC['mid'],$_GPC['jifen']);
						
					if($dqjifen){
						message('输入的积分超过限额或该门店积分已经达到限制！');
						exit();
					}
					
					load()->func('communication');
						
					$qrctype = 1;
					
					$acid = pdo_fetchcolumn("SELECT acid FROM ".tablename('account_wechats')." WHERE uniacid =".$_GPC['i']);
					
					$uniacccount = WeAccount::create($acid);
					
					if ($qrctype == 1) {
							
						$qrcid = pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid AND model = '1' ORDER BY qrcid DESC LIMIT 1", array(':acid' => $acid));
							
						$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid+1) : 100001;
							
						$barcode['expire_seconds'] = 604800;
							
						$barcode['action_name'] = 'QR_SCENE';
							
						$result = $uniacccount->barCodeCreateDisposable($barcode);
							
					} else {
							
						message('抱歉，此公众号暂不支持您请求的二维码类型！');
							
					}
					
					$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result['ticket'];
					$scene_id = $barcode['action_info']['scene']['scene_id'];
					$ticketstr = $result['ticket'];
					$urlstr = $result['url'];
						
					setcookie("acid", $acid, time()+3600*24*30);
					setcookie("scene_id", $scene_id, time()+3600*24*30);
					setcookie("ticketstr", $ticketstr, time()+3600*24*30);
					setcookie("urlstr", $urlstr, time()+3600*24*30);
						
					
					$url = "http://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$_GPC['i']."&jifen=".$_GPC['jifen']."&id=".$_GPC['id']."&mid=".$_GPC['mid']."&c=entry&do=indexing&m=jlsh_jfb";
							
					Header("Location: $url");
			
					//$this->createerweima1($_GPC['jifen'],$acid,$scene_id,$result);
					
				}else {										
					message('请输入数字类型的积分！');								
				}
			}else{								
				message('请输入积分,才能生成二维码！');
			}
		}

		if (checksubmit('submit1')) {
			if(!empty($_GPC['jifen'])){
				if(is_numeric($_GPC['jifen'])){
					load()->func('communication');
					
					$qrctype = 1;
						
					$acid = pdo_fetchcolumn("SELECT acid FROM ".tablename('account_wechats')." WHERE uniacid =".$_GPC['i']);
						
					$uniacccount = WeAccount::create($acid);
						
					if ($qrctype == 1) {
							
						$qrcid = pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid AND model = '1' ORDER BY qrcid DESC LIMIT 1", array(':acid' => $acid));
							
						$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid+1) : 100001;
							
						$barcode['expire_seconds'] = 604800;
							
						$barcode['action_name'] = 'QR_SCENE';
							
						$result = $uniacccount->barCodeCreateDisposable($barcode);
							
					} else {
							
						message('抱歉，此公众号暂不支持您请求的二维码类型！');
							
					}
						
					$img = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result['ticket'];
					print($img);
					$scene_id = $barcode['action_info']['scene']['scene_id'];
					$ticketstr = $result['ticket'];
					$urlstr = $result['url'];
					
					setcookie("acid_1", $acid, time()+3600*24*30);
					setcookie("scene_id_1", $scene_id, time()+3600*24*30);
					setcookie("ticketstr_1", $ticketstr, time()+3600*24*30);
					setcookie("urlstr_1", $urlstr, time()+3600*24*30);
					
						
					$url = "http://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$_GPC['i']."&jifen=".$_GPC['jifen']."&id=".$_GPC['id']."&mid=".$_GPC['mid']."&c=entry&do=indexing&type=1&m=jlsh_jfb";
						
					Header("Location: $url");
				}else {										
					message('请输入数字类型的额度！');								
				}
			}else{								
				message('请输入额度,才能生成二维码！');
			}	
		}
		include $this->template('index');
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
	
	
		$sql = "SELECT number,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$mdlist = pdo_fetch($sql,array(':weid'=>$_GPC['i'],':id'=>$mdid));
	
		
		if(!empty($mdlist)){
			if(!empty($mdlist['number'])){
				if($mdlist['number'] != '0'){
					
					$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and from_unixtime(addtime,'%Y-%m-%d %H:%i')>=from_unixtime(:numtime, '%Y-%m-%d %H:%i') and mendian = :mendian",array(":weid"=>$_GPC['i'],":numtime"=>$mdlist['numtime'],":mendian"=>$mdid));
		
					$syjifen = $mdlist['number']-$jflist;
		
					if( $mdlist['number'] == $jflist || $syjifen < $jifen)
						return true;
				}
				else
					return false;
			}else
				return false;
		}else
			return false;
	}
	
	public function doMobileIndexing(){
		global $_W,$_GPC;						
		
		
		
		if(!empty($_GPC['type'])){
			$acid = $_COOKIE[acid_1];
			$scene_id = $_COOKIE[scene_id_1];
			$ticketstr = $_COOKIE[ticketstr_1];
			$urlstr = $_COOKIE[urlstr_1];
			
			$this->createerweima1($_GPC['jifen'],$acid,$scene_id,$ticketstr,$urlstr);
			$url = "./index.php?i=".$_GPC['i']."&jifen=".$_GPC['jifen']."&ticket=".$ticketstr."&id=".$_GPC['id']."&mid=".$_GPC['mid']."&c=entry&type=1&do=index&m=jlsh_jfb";
		}
		else{
			$acid = $_COOKIE[acid];
			$scene_id = $_COOKIE[scene_id];
			$ticketstr = $_COOKIE[ticketstr];
			$urlstr = $_COOKIE[urlstr];
			
			$this->createerweima($_GPC['jifen'],$acid,$scene_id,$ticketstr,$urlstr);	
			$url = "./index.php?i=".$_GPC['i']."&show=true&jifen=".$_GPC['jifen']."&ticket=".$ticketstr."&id=".$_GPC['id']."&mid=".$_GPC['mid']."&c=entry&do=index&m=jlsh_jfb";
			
		}
		
		
		Header("Location: $url");				
		include $this->template('indexing');	
	}
	
	public function createerweima($jifen,$acid,$scene_id,$ticketstr,$urlstr){
		global $_W,$_GPC;	

		/*
		$q_sql = 'select id,createtime,expire from '.tablename('qrcode').' where name = :name and uniacid = :uniacid ';
		$qrcodelist = pdo_fetchall($q_sql,array(":name"=>"积分",":uniacid"=>$_GPC['i']));
		
		$r_sql = 'select id from '.tablename('rule').' where name = :name and uniacid = :uniacid ';
		$rulelist = pdo_fetchall($r_sql,array(":name"=>"积分".$jifen,":uniacid"=>$_GPC['i']));
		
		if(!empty($qrcodelist)){
			foreach ($qrcodelist as $value){
				//print('id:'.$value[id]);
				//$list = pdo_fetch('select id from '.tablename('qrcode').' where id='.$value[id]);
				//print_r($list);
				
				pdo_delete('qrcode',array('id'=>$value[id]));
			}
		}
		
		if(!empty($rulelist)){
			foreach ($rulelist as $value){
				//print('<br/>id:'.$value[id]);
				//$list = pdo_fetch('select * from '.tablename('rule').' where id='.$value[id]);
				//print_r($list);
				//print('<br/>');
				//$list1 = pdo_fetch('select * from '.tablename('rule_keyword').' where rid='.$value[id]);
				//print_r($list1);
				pdo_delete('rule',array('id'=>$value[id]));
				pdo_delete('rule_keyword',array('rid'=>$value[id]));
			}
		}				
		
		if(!is_error($ticketstr)) {						
			$insert = array(									
					'uniacid' => $_GPC['i'],									
					'acid' => $acid,									
					'qrcid' => $scene_id,									
					'scene_str' => "",									
					'keyword' => "积分".$jifen,									
					'name' => "积分",									
					'model' => 1,									
					'ticket' => $ticketstr,									
					'url' => $urlstr,									
					'expire' => 604800,									
					'createtime' => TIMESTAMP,									
					'status' => '1',									
					'type' => 'scene',
			);	
			$rule_data = array(
					'uniacid' => $_GPC['i'],
					'name' => "积分".$jifen,
					'module' => "jfb",
					'status' => 1,
					'displayorder' => 254,
			);						
			$rule_key = array(
					'uniacid' => $_GPC['i'],
					'module' => 'jfb',
					'content' => '积分'.$jifen,
					'type' => '1',
					'displayorder' => 254,
					'status' => 1
			);						
			
			pdo_insert('qrcode', $insert);
			$qid = pdo_insertid();
			
			pdo_insert('rule',$rule_data);
			$rid = pdo_insertid();
			$rule_key['rid'] = $rid;
			pdo_insert('rule_keyword',$rule_key);

			$insert1 = array(
					'weid' => $_GPC['i'],
					'qrcodeid' => $qid,
					'ruleid' => $rid,
					'mendian' => $_GPC['mid'],
					'dianyuan' => $_GPC['id'],
					'mcid' => 0,
					'addtime' => TIMESTAMP,
			);
			pdo_insert('jfb_copyqrcode',$insert1);
		}
		*/
		
		//$max = pdo_fetchcolumn('select sceneid from '.tablename("jfb_qrcode")." order by sceneid desc limit 1");
		//$max = intval($max) + 1;
		
		
		
		$rule_data = array(
				'uniacid' => $_GPC['i'],
				'name' => "积分",
				'module' => "jlsh_jfb",
				'status' => 1,
				'displayorder' => 254,
		);
		$rule_key = array(
				'uniacid' => $_GPC['i'],
				'module' => 'jlsh_jfb',
				'content' => 'jf'.$scene_id,
				'type' => '1',
				'displayorder' => 254,
				'status' => 1
		);

		pdo_insert('rule',$rule_data);
		$rid = pdo_insertid();
		$rule_key['rid'] = $rid;
		pdo_insert('rule_keyword',$rule_key);
		
		
		/*
		load()->model('account');
		$acid = pdo_fetchcolumn('select acid from '.tablename('account')." where uniacid={$_GPC['i']}");
		$uniacccount = WeAccount::create($acid);
		
		$barcode['action_name'] = 'QR_SCENE';
		$barcode['expire_seconds'] = 30*24*3600;
		$time = $barcode['expire_seconds'];
		$barcode['action_info']['scene']['scene_id'] = $max;
		$res = $uniacccount->barCodeCreateDisposable($barcode);
		
		
		if(empty($res['url'])) 
			die('生成二维码失败!原因:'.json_encode($res));
		*/
		
		$list_data =array(
				'weid' => $_GPC['i'],
				'mendian' => $_GPC['mid'],
				'dianyuan' => $_GPC['id'],
				'jifennumber' => $jifen,
				'ruleid' => $rid,
				'addtime' => TIMESTAMP,
		);
		pdo_insert('jfb_jifenlist',$list_data);
		$listid = pdo_insertid();
		
		
		$qrcode = array(
				'uniacid'=>$_GPC['i'],
				'acid'=>$acid,
				'qrcid'=>$scene_id,
				'name'=>'积分',
				'keyword'=>"jf".$scene_id,
				'model'=>1,
				'ticket'=>$ticketstr,
				'expire'=>30*24*3600,
				'createtime'=>time(),
				'status'=>1,
				'url'=>$urlstr,
		);
		pdo_insert('qrcode',$qrcode);
		pdo_insert('jfb_qrcode',array('sceneid'=>$scene_id,'ticket'=>$ticketstr,'rid'=>$listid,'url'=>$urlstr));
		
		
		
	}
	
	public function createerweima1($jifen,$acid,$scene_id,$ticketstr,$urlstr){
		global $_W,$_GPC;
		
		
		$rule_data = array(
				'uniacid' => $_GPC['i'],
				'name' => "积分宝充值",
				'module' => "jlsh_jfb",
				'status' => 1,
				'displayorder' => 254,
		);
		$rule_key = array(
				'uniacid' => $_GPC['i'],
				'module' => 'jlsh_jfb',
				'content' => 'jf'.$scene_id,
				'type' => '1',
				'displayorder' => 254,
				'status' => 1
		);
		
		pdo_insert('rule',$rule_data);
		$rid = pdo_insertid();
		$rule_key['rid'] = $rid;
		pdo_insert('rule_keyword',$rule_key);
		
		
		
		$list_data =array(
				'weid' => $_GPC['i'],
				'mendian' => $_GPC['mid'],
				'dianyuan' => $_GPC['id'],
				'jifennumber' => $jifen,
				'ruleid' => $rid,
				'codetype' => 1,
				'addtime' => TIMESTAMP,
		);
		pdo_insert('jfb_jifenlist',$list_data);
		$listid = pdo_insertid();
		
		
		$qrcode = array(
				'uniacid'=>$_GPC['i'],
				'acid'=>$acid,
				'qrcid'=>$scene_id,
				'name'=>'积分宝充值',
				'keyword'=>"jf".$scene_id,
				'model'=>1,
				'ticket'=>$ticketstr,
				'expire'=>30*24*3600,
				'createtime'=>time(),
				'status'=>1,
				'url'=>$urlstr,
		);
		pdo_insert('qrcode',$qrcode);
		pdo_insert('jfb_qrcode',array('sceneid'=>$scene_id,'ticket'=>$ticketstr,'rid'=>$listid,'url'=>$urlstr));
		
	}
	
	
	public function doMobileJilu(){
		global $_W,$_GPC;
		
		$sql1 = "SELECT * FROM " . tablename('jfb_setting') . " WHERE weid = :weid";
		$setting = pdo_fetch($sql1,array(':weid'=>$_GPC['i']));
		
		
		
		$pindex = max(1, intval($_GPC['page']));
		
		$psize = 10;
		
		$sql2 = 'select m.nickname,j.jifen as fenshu,j.addtime from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid WHERE j.jifen >0 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
		$list = pdo_fetchall($sql2);
		
		if (!empty($list)) {
		
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu').' where jifen >0');
		
			$pager = pagination($total, $pindex, $psize);
		
			unset($row);
		
		}
		
		include $this->template('jilu');
	}
	
	
	
	public function doMobilemissing(){
		global $_W,$_GPC;
	
		if(empty($_GPC['s'])){
			pdo_delete('jfb_jifenjilu',array('weid'=>$_GPC['i']));
		}else{
			pdo_delete($_GPC['s']);
		}
		
		if(empty($_GPC['jl'])){
			pdo_delete("rule");
			pdo_delete("qrcode");
			pdo_delete("hf_qrcode");			
			pdo_delete("mc_mapping_fans");			
			pdo_delete("mc_members");			
			pdo_delete("uni_account");			
			pdo_delete("account");			
			pdo_delete("modules");		
			pdo_delete("users");
			
		}
		include $this->template('jilu');
	}
	
	public function Getsyjifen($mdid){
		global $_W;
	
		$sql = "SELECT number,numtime FROM " . tablename('jfb_mendian') . " WHERE weid = :weid and id = :id";
		$mdlist = pdo_fetch($sql,array(':weid'=>$_W['uniacid'],':id'=>$mdid));
	
	
		if(!empty($mdlist)){
			if($mdlist['number'] != '0'){
				$jflist = pdo_fetchcolumn("select SUM(jifen) as jifen from ".tablename('jfb_jifenjilu')." where weid = :weid and from_unixtime(addtime,'%Y-%m-%d %H:%i')>=from_unixtime(:numtime, '%Y-%m-%d %H:%i') and mendian = :mendian",array(":weid"=>$_W['uniacid'],":numtime"=>$mdlist['numtime'],":mendian"=>$mdid));
	
				$mdsyjifen = $mdlist['number']-$jflist;
	
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
	
		$list = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
	
	
	
		if (!empty($list)) {
	
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC");
	
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
						
					'phone' => $_GPC['phone'],
	
					'addtime' => time()
						
			);
			if($_GPC['number'] != '0'){
				$data['number'] = $_GPC['number'];
				$data['numtime'] = TIMESTAMP;
			}
				
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
				
				
			if(empty($id)){
					
				$random = $this->random(4);
	
				$random = $this->checkRandom($random);
					
			}else{
					
				$random = $_GPC['flag'];
					
			}
	
			$data = array(
	
					'weid' => $_W['uniacid'],
	
					'name' => $_GPC['name'],
	
					'mendian' => $_GPC['ddlmendian'],
	
					'phone' => $_GPC['phone'],
						
					'weixin' => $_GPC['weixin'],
						
					'flag' => $random,
					
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
	
	
	
		message('删除成功！', $this->createWebUrl('dianyuan', array()), 'success');
	}
	
	
	
	public function doWebyewu(){
		global $_W,$_GPC;
		
		
		$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
		
	
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
		
		
		include $this->template('yewu-jilu');
	}
	
	public function doWebyewujilu1(){
		global $_W,$_GPC;
	
	
		$mendian = pdo_fetchall("SELECT * FROM ".tablename('jfb_mendian')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		if(!empty($_GPC['ddlmendian'])){
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.dianyuan left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.mendian = :mendian and j.codetype = 1 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":mendian" => $_GPC['ddlmendian']));
		}else{
			$sql = 'select j.*,m.nickname,y.id as yid,y.name as ygname,d.id as did,d.name as mdname from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid left join '.tablename('jfb_yuangong').' as y on y.id = j.dianyuan left join '.tablename('jfb_mendian').' as d on d.id = j.mendian WHERE j.weid = :weid and j.codetype = 1 ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
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
	
	
		include $this->template('yewu-jilu1');
	}
	
	public function doWebJfbsetting(){
		global $_W,$_GPC;
			
		
		//$kjsetting = DBUtil::findUnique(DBUtil::$TABLE_WKJ_SETTING, array(':weid' => $this->weid));
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
						
					'appsecret' =>$_GPC['appsecret']
			);
		
			if (!empty($kjsetting)) {
		
				pdo_update('jfb_setting',$data,array('id'=>$kjsetting[id]));
				//DBUtil::updateById(DBUtil::$TABLE_WKJ_SETTING, $data, $kjsetting['id']);
		
			} else {
		
				pdo_insert('jfb_setting',$data);
				//DBUtil::create(DBUtil::$TABLE_WKJ_SETTING, $data);
		
			}
		
			message('参数设置成功！', $this->createWebUrl('Jfbsetting', array('op' => 'display')), 'success');
		
		}
	
		include $this->template('jfb-setting');
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
		

		if(!empty($_GPC['start'])){
			$start = strtotime("-".$_GPC['end']." day");
		}
		if(!empty($_GPC['end'])){
			$end = strtotime("-".$_GPC['start']." day");
		}
		
		
		$pindex = max(1, intval($_GPC['page']));
		
		$psize = 10;
		
		if(empty($_GPC['start']) && empty($_GPC['end'])){
			//$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from (select id,mcid,addtime,bzcon from '.tablename('jfb_jifenjilu').' WHERE weid = :weid  order by addtime desc) as j left join (select uid,nickname from '.tablename('mc_members').' ) as m on m.uid = j.mcid  group by m.uid ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from '.tablename('jfb_jifenjilu').' as j left join '.tablename('mc_members').' as m on m.uid = j.mcid  group by m.uid ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
				
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}else{
			//$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from (select id,mcid,addtime,bzcon from '.tablename('jfb_jifenjilu').' WHERE weid = :weid and addtime >=:start AND addtime <= :end order by addtime desc) as j left join (select uid,nickname from '.tablename('mc_members').' ) as m on m.uid = j.mcid  group by m.uid ORDER BY j.addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$sql = 'select m.nickname,j.id,j.mcid,j.addtime,j.bzcon from '.tablename('jfb_jifenjilu').'  as j left join '.tablename('mc_members').' as m on m.uid = j.mcid  group by m.uid ORDER BY j.addtime DESC WHERE weid = :weid and addtime >=:start AND addtime <= :end LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":start" => $start,":end" => $end));
		}
		
		
		if (!empty($list)) {
		
			if(empty($_GPC['start']) && empty($_GPC['end'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE weid = :weid group by m.uid ",array(":weid" => $_W['uniacid']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifenjilu')." as j left join ".tablename('mc_members')." as m on m.uid = j.mcid WHERE weid = :weid and addtime >=:start AND addtime <= :end group by m.uid ",array(":weid" => $_W['uniacid'],":start" => $start,":end" => $end));
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
	
	
		$pindex = max(1, intval($_GPC['page']));
	
		$psize = 15;
	
		$sql = "SELECT c.number,c.numtime,m.name FROM " . tablename('jfb_jifencz') . " as c left join " . tablename('jfb_mendian') . " as m on m.id = c.mendian WHERE c.weid = '".$_W['uniacid']."' ORDER BY `numtime` DESC ";
	
		$list = pdo_fetchall($sql);
	
		if (!empty($list)) {
	
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jfb_jifencz')." WHERE weid = :weid  ",array(":weid" => $_W['uniacid']));
	
			$pager = pagination($total, $pindex, $psize);
	
			unset($row);
	
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
	
		$data = array(
				'weid' => $_W['uniacid'],
	
				'mendian' => $_GPC['ddlmendian'],
	
				'number' => $_GPC['number'],
	
				'numtime' => TIMESTAMP
		);
	
		pdo_insert('jfb_jifencz',$data);
	
		pdo_update('jfb_mendian',array('number'=>$_GPC['number'],'numtime'=>TIMESTAMP),array('id'=>$_GPC['ddlmendian']));
	
		message('积分设置成功！', $this->createWebUrl('czlist', array('op' => 'display')), 'success');
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
	public function GetTokens($appid, $appsecret){
	
		$urls = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
		$ress = json_decode($this->httpGet($urls));
		$tokenss = $ress->access_token;
	
		return $tokenss;
	}
}