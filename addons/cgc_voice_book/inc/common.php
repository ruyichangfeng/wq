<?php

  function getFromUserTest() 
{ 
  $obj=array("openid"=>"test1",
  "nickname"=>"test1","headimgurl"=>
  "http://wx.qlogo.cn/mmopen/bHACibrA8hAhnlNYETmRhdPTJiaKDCr7OvwoQ5y3oJKuDFD7iafDGWsmpVXCibjia30kc0bibkTU4xHKdrqXP1iaWkYxMmaOmFicHLza/0");
  return json_encode($obj);
}

     function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

 
  function getCardTicket($access_token){
 	    global $_W;
 	    $acid=$_W['acid'];
		$cachekey = "wx_card_jsticket:$acid";
		$cache = cache_load($cachekey);
		if(!empty($cache) && !empty($cache['ticket']) && $cache['expire'] > TIMESTAMP) {
			return $cache['ticket'];
		}
	
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=wx_card";
		$content = ihttp_get($url);
		if(is_error($content)) {
			return error(-1, '调用接口获取微信公众号 jsapi_ticket 失败, 错误信息: ' . $content['message']);
		}
		$result = @json_decode($content['content'], true);
		if(empty($result) || intval(($result['errcode'])) != 0 || $result['errmsg'] != 'ok') {
			return error(-1, '获取微信公众号 jsapi_ticket 结果错误, 错误信息: ' . $result['errmsg']);
		}
		$record = array();
		$record['ticket'] = $result['ticket'];
		$record['expire'] = TIMESTAMP + $result['expires_in'] - 200;
		
		cache_write($cachekey, $record);
		return $record['ticket'];
	}

 function getAppInfo() {
  global $_W;	

  $appId =$_W['account']['key'];
  $appSecret =$_W['account']['secret'];
  return array("appid"=>$appId,"secret"=>$appSecret);
 }


//授权获取用户信息。	
 function getFromUser($settings,$modulename) 
{
  global $_W,$_GPC;	
  $uniacid = $_W['uniacid'];
  
  if ($_W['container']!="wechat" && (!empty($settings['debug_mode']) || !empty($settings['app_mode']))){
  	return getFromUserTest();
  }
 
  load()->model('mc');
  $userinfo = mc_oauth_userinfo();
  return json_encode($userinfo);
 
  
  
  /* if ($_W['container']!="wechat"){
    return getFromUserTest();
  }	
  */
  
 


  if(empty($_COOKIE[$modulename."_user_".$uniacid])){
     $url = $_W['siteroot'] . "app/index.php?i=".$_W['uniacid']."&j=".$_W['acid']."&c=entry&m=$modulename&do=xoauth";
     $xoauthURL="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
     setcookie("xoauthURL",$xoauthURL, time()+3600*(24*5));
     $oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$settings['appid']."&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect";
     header("location:$oauth2_code");
     exit;                  
  } else { 	
  	return $_COOKIE[$modulename."_user_".$uniacid];
  } 
}
 
 



function sendTemplateMsgAward($templateid,$openid,$obj){
       global $_W;   
      	$weid = $_W['acid'];  
        load()->classs('weixin.account');
        $accObj= WeixinAccount::create($weid);
        $access_token=$accObj->fetch_token();
        
         $template_mess= <<<EOF
        {
							           "touser":"$openid",
							           "template_id":"$templateid",
							           "url":"{$obj['url']}",         
							           "data":{
							                   "first": {
							                       "value":"{$obj['first']}"
							                   },
							                   "keyword1":{
							                       "value":"{$obj['keyword1']}"
							                   },
							                   "keyword2": {
							                       "value":"{$obj['keyword2']}"
							                   },
		                                      "keyword3":{
							                       "value":"{$obj['keyword3']}"
							                   },
							                   "keyword4": {
							                       "value":"{$obj['keyword4']}"
							                   },
							                   "remark": {
							                       "value":"{$obj['remark']}"
							                   }
							             
							            }
						       		}
EOF;

	  return send_template_message($template_mess,$access_token);
  	 
   }


	 function send_template_message($data,$access_token){
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		load()->func('communication');
  	    $res=ihttp_request($url, $data);
	    
	    if (is_error($res)){
	      return array("code"=>"-4","msg"=>json_encode($res));
	    }
		
		$res=json_decode($res['content'],true);	
		
		if ($res['errcode'] == '0') {
			return array("code"=>"1","msg"=>json_encode($res));
		} else {
			return array("code"=>"-3","msg"=>json_encode($res));
		}
	
	 }
	 
	 function sendTemplate_common($touser,$template_id,$url,$data){
	 	global $_W;
	 	$acid=!empty($_W['acid'])?$_W['acid']:$_W['uniacid'];
	 	load()->classs('weixin.account');
	 	$accObj= WeixinAccount::create($acid);
	 	$ret=$accObj->sendTplNotice($touser, $template_id, $data, $url);
	 	return $ret;
	 
	 }

  //是否关注
  function sfgz_user($fromuser){
  	global $_W;
  	$uniacid=$_W['uniacid'];
   	$follow=pdo_fetchcolumn("SELECT follow FROM " . tablename('mc_mapping_fans').
          " where uniacid=$uniacid and openid='$fromuser'"); 
   	return $follow;
  }

  
  //查看会员
  function select_member($user){
  	global $_W;
  	$uniacid=$_W['uniacid'];
   	$follow=pdo_fetchcolumn("SELECT follow FROM " . tablename('mc_mapping_fans').
          " where uniacid=$uniacid and openid='$fromuser'"); 
   	return $follow;
  }
  
  
  
  
  


   

    
     
    function valid_post($param = array()) {  
    	
       $yzm=$param['yzm'];
       $tel=$param['tel'];      
       if ($_SESSION["yzm"]!=$yzm){
           return (array("code"=>-1,"msg"=>"验证码不对"));	
       }      
       if ($_SESSION["tel"]!=$tel){
         return (array("code"=>-2,"msg"=>"发验证码的手机号不对"));		
       }       
       return (array("code"=>1,"msg"=>"正确"));
    } 
    

    
  



  

    function wechat_duizhang($out_trade_no,$settings){
     global $_W, $_GPC;
    load()->func('communication');  
    $uniacid=$_W["uniacid"];

    $password=$settings['password'];
    $appid=$settings['appid'];
    $mch_id=$settings['mchid'];

    $package = array();
    $package['appid'] =$appid;
    $package['mch_id'] = $mch_id;
    $package['nonce_str'] = random(8);
    $package['out_trade_no'] = $out_trade_no;

    ksort($package, SORT_STRING);
    $string1 = '';
    foreach($package as $key => $v) {
      $string1 .= "{$key}={$v}&";
    }
    $string1 .= "key={$password}";
    $package['sign'] = strtoupper(md5($string1));
    $dat = array2xml($package);
    
    $response = ihttp_request('https://api.mch.weixin.qq.com/pay/orderquery', $dat);
    if (is_error($response)) {
      return $response;
    }
    $xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
    

    if(($xml->trade_state)=='SUCCESS'){
     $output = json_decode(json_encode($xml), true);
     return $output;
    }
    else{
      return false;
    }
    
   } 
  
 

 //现金红包接口
   function send_xjhb($settings,$fromUser,$amount,$desc) {
   	  $Hour = date('G'); 	
   	  if (intval($Hour)<8){
   	    return send_qyfk($settings,$fromUser,$amount,$desc);
   	   }
   	   $ret=array();
       $ret['code']=0;
       $ret['message']="success";     
       //return $ret;
      	$amount=$amount*100;
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $pars = array();
        $pars['nonce_str'] = random(32);
        $pars['mch_billno'] =random(10). date('Ymd') . random(3);
        $pars['mch_id'] = $settings['mchid'];
        $pars['wxappid'] = $settings['appid'];
        $pars['nick_name'] =   $settings['send_name'];
        $pars['send_name'] = $settings['send_name'];
        $pars['re_openid'] = $fromUser;
        $pars['total_amount'] = $amount;
        $pars['min_value'] = $amount;
        $pars['max_value'] = $amount;
        $pars['total_num'] = 1;
        $pars['wishing'] = $desc;
        $pars['client_ip'] = $settings['ip'];
        $pars['act_name'] =  $settings['act_name'];
        $pars['remark'] = $settings['remark'];

        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$settings['password']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
       
        $extras['CURLOPT_CAINFO']= $settings['rootca'];
        $extras['CURLOPT_SSLCERT'] =$settings['apiclient_cert'];
        $extras['CURLOPT_SSLKEY'] =$settings['apiclient_key'];


        load()->func('communication');
        $procResult = null; 
        $resp = ihttp_request($url, $xml, $extras);
        if(is_error($resp)) {
            $procResult = $resp["message"];
            $ret['code']=-1;
            $ret['message']=$procResult;
            return $ret;     
        } else {
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new DOMDocument();
             if($dom->loadXML($xml)) {
                $xpath = new DOMXPath($dom);
                $code = $xpath->evaluate('string(//xml/return_code)');
                $result = $xpath->evaluate('string(//xml/result_code)');
                if(strtolower($code) == 'success' && strtolower($result) == 'success') {
                    $ret['code']=0;
                    $ret['message']="success";
               
                    return $ret;
                  
                } else {
                    $error = $xpath->evaluate('string(//xml/err_code_des)');
                    $ret['code']=-2;
                    $ret['message']=$error;
                    return $ret;
                 }
            } else {
                $ret['code']=-3;
                $ret['message']="3error3";
                return $ret;
            }
            
        }

     
    }

  
  
  

//主动文本回复消息，48小时之内
 function post_send_text($openid,$content) {
	    global $_W;	
		//$weid = $_W['acid'];  
	    $acid=!empty($_W['acid'])?$_W['acid']:$_W['uniacid'];
        load()->classs('weixin.account');
        $accObj= WeixinAccount::create($acid);
        $token=$accObj->fetch_token();
        load()->func('communication');
		$data['touser'] =$openid;
		$data['msgtype'] = 'text';
		$data['text']['content'] = urlencode($content);
		$dat = json_encode($data);
		$dat = urldecode($dat);
		 //客服消息
			$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;			
			$ret=ihttp_post($url, $dat);
			$dat = $ret['content'];
			$result = @json_decode($dat, true);
			if ($result['errcode'] == '0') {				
				//message('发送消息成功！', referer(), 'success');
			} else {
			  load()->func('logging');
			  logging_run("post_send_text:");
			  logging_run($dat);
		      logging_run($result);
			}
			return $result;
			
}

//返回百度地址
//根据经纬度返回百度地址：http://api.map.baidu.com/geocoder/v2/?ak=qen1OGw9ddzoDQrTX35gote2&location=26.047125,119.330221&output=json
function getAddr($location){
	if (empty($location)){
       return false;
	}

	if (empty($location['x']) && empty($location['location_x'])){
       return false;
	}
    $loc="";
	if (!empty($location['location_x']) && !empty($location['location_y'])){
		$loc=$location['location_x'].",".$location['location_y'];
	}

	if (!empty($location['x']) && !empty($location['y'])){
       $loc=$location['x'].",".$location['y'];
    }

    if (empty($loc)){
      return false;
    }

    $url="http://api.map.baidu.com/geocoder/v2/?ak=qen1OGw9ddzoDQrTX35gote2&location=".$loc."&output=json";
 
    $ret=json_decode(file_get_contents($url),true);
 
    if ($ret['status']!=0) {
       WeUtility::logging("getAddr", "$url==>" . json_encode($ret)); 
      return false;
    }
  
    if (strpos($ret['result']['formatted_address'],$location['addr'])===false){
        WeUtility::logging("getAddr", "error==>" . json_encode($location)); 
      return false;
    } else {
      return true;
    }

}



//返回百度地址
//根据经纬度返回百度地址：http://api.map.baidu.com/geocoder/v2/?ak=qen1OGw9ddzoDQrTX35gote2&location=26.047125,119.330221&output=json
function getNewAddr($location){
	if (empty($location)){
       return false;
	}
	if (empty($location['location_y']) ||  empty($location['location_x'])){
       return false;
	}   
    $loc=$location['location_x'].",".$location['location_y']; 
    $url="http://api.map.baidu.com/geocoder/v2/?ak=qen1OGw9ddzoDQrTX35gote2&location=".$loc."&output=json";
    $ret=json_decode(file_get_contents($url),true);
    if ($ret['status']!=0) {
       WeUtility::logging("getAddr", "$url==>" . json_encode($ret)); 
      return false;
    }
    
    return $ret['result'];
  
  
}






    function sendImage($access_token, $obj) {
  	 load()->func('communication');
  	 $data = array(
       "touser"=>$obj["openid"],
       "msgtype"=>"image",
       "image"=>array("media_id"=>$obj["media_id"])
     );
     WeUtility::logging('sendImage start', json_encode($data));
     $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
     WeUtility::logging('sendResurl', $url);
    
     $ret=ihttp_request($url, json_encode($data));
     $content = @json_decode($ret['content'], true);
    
     WeUtility::logging('sendImage end', $content);
     return $content;
  }
  
  
  /**
   * 根据微擎url获取siteroot
   * @param unknown_type $url
   * @return string
   */
  function getSiteRoot($url){
  	$arr = array('/web', '/app', '/payment/wechat', '/payment/alipay', '/api','/addons');
  	foreach ($arr as $value) {
  		$length = strpos($url, $value);
  		if($length){
  			$url = substr($url, 0, $length);
  			break;
  		}
  	}
  	return $url;
  }
  
  
  function send_invite_code($from_user,$member,$template_id){
  	global $_W, $_GPC;
  	
  	
  	$pic = pdo_get('cgc_voice_book_pic',array('uniacid' => $_W['uniacid'],'openid' => $from_user));
  	if(!$pic){
  		post_send_text($from_user,"未上传图片!");
  		return;
  	}
  
  	if(empty($pic['status'])&&!empty($settings['auto_audit'])){
  		post_send_text($from_user,"图片未通过审核!");
  		return;
  	}
  	$book_code = pdo_get('cgc_voice_book_code', array ('uniacid' => $_W['uniacid'],'openid' => $from_user));
  	if($book_code){
  		$invite_code = $book_code['invite_code'];
  		$_url = $_W['siteroot'] . "app/" . murl('entry', array('m' => 'cgc_voice_book','do' =>'invite_code', 'id' => $book_code['id']));
  		if (!empty($template_id)){
  			$msg="你上传的图片通过审核，点击领取邀请码";
  			$data = array(
  					'first'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  					'keyword1'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  					'keyword2'=>array('value'=>$msg,'color'=>'#173177'),
  					'remark'=>array('value'=>'','color'=>'#173177'),
  			);
  			sendTemplate_common($from_user,$template_id,$_url,$data);
  		}else{
	  		$msg = "<a href='".$_url."'>点击领取邀请码:".$invite_code."</a>";
	  		post_send_text($from_user,$msg);
  		}
  		return;
  	}else{
  		$invite_code = NoRand();
  		$data = array();
  		$data['uniacid'] = $_W['uniacid'];
  		$data['nickname'] = $member['nickname'];
  		$data['openid'] = $from_user;
  		$data['headimgurl'] = $member['avatar'];
  		$data['invite_code'] = $invite_code;
  		$data['status'] = 0;
  		$data['is_check'] = 0;
  		$data['createtime'] = time();
  		$result = pdo_insert("cgc_voice_book_code", $data);
  		if(!empty($result)) {
  			$id = pdo_insertid();
  			$_url = $_W['siteroot'] . "app/" . murl('entry', array('m' => 'cgc_voice_book','do' =>'invite_code', 'id' => $id));
  			if (!empty($template_id)){
  				$msg="你上传的图片通过审核，点击领取邀请码";
  				$data = array(
  						'first'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  						'keyword1'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  						'keyword2'=>array('value'=>$msg,'color'=>'#173177'),
  						'remark'=>array('value'=>'','color'=>'#173177'),
  				);
  				sendTemplate_common($from_user,$template_id,$_url,$data);
  			}else{
	  			$msg = "<a href='".$_url."'>点击领取邀请码:".$invite_code."</a>";
	  			post_send_text($from_user,$msg);
  			}
  			return;
  		}else{
  			
  			post_send_text($from_user,"生成邀请码失败!");
  			return;
  		}
  	}
  }
  
  
  function send_invite_code_new($from_user,$member){
  	global $_W, $_GPC;
  	
  	
  	$pic = pdo_get('cgc_voice_book_pic',array('uniacid' => $_W['uniacid'],'openid' => $from_user));
  	if(!$pic){
  		//post_send_text($from_user,"未上传图片!");
  		return "未上传图片!";
  	}
  
  	if(empty($pic['status'])&&!empty($settings['auto_audit'])){
  		//post_send_text($from_user,"图片未通过审核!");
  		return "图片未通过审核!";
  	}
  	$book_code = pdo_get('cgc_voice_book_code', array ('uniacid' => $_W['uniacid'],'openid' => $from_user));
  	if($book_code){
  		$invite_code = $book_code['invite_code'];
  		$_url = $_W['siteroot'] . "app/" . murl('entry', array('m' => 'cgc_voice_book','do' =>'invite_code', 'id' => $book_code['id']));
  		if (!empty($template_id)){
  			$msg="你上传的图片通过审核，点击领取邀请码";
  			$data = array(
  					'first'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  					'keyword1'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  					'keyword2'=>array('value'=>$msg,'color'=>'#173177'),
  					'remark'=>array('value'=>'','color'=>'#173177'),
  			);
  			sendTemplate_common($from_user,$template_id,$_url,$data);
  		}else{
	  		$msg = "<a href='".$_url."'>点击领取邀请码:".$invite_code."</a>";
	  		return $msg;
	  	//	post_send_text($from_user,$msg);
  		}
  		return;
  	}else{
  		$invite_code = NoRand();
  		$data = array();
  		$data['uniacid'] = $_W['uniacid'];
  		$data['nickname'] = $member['nickname'];
  		$data['openid'] = $from_user;
  		$data['headimgurl'] = $member['avatar'];
  		$data['invite_code'] = $invite_code;
  		$data['status'] = 0;
  		$data['is_check'] = 0;
  		$data['createtime'] = time();
  		$result = pdo_insert("cgc_voice_book_code", $data);
  		if(!empty($result)) {
  			$id = pdo_insertid();
  			$_url = $_W['siteroot'] . "app/" . murl('entry', array('m' => 'cgc_voice_book','do' =>'invite_code', 'id' => $id));
  			if (!empty($template_id)){
  				$msg="你上传的图片通过审核，点击领取邀请码";
  				$data = array(
  						'first'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  						'keyword1'=>array('value'=>'领取邀请码！','color'=>'#173177'),
  						'keyword2'=>array('value'=>$msg,'color'=>'#173177'),
  						'remark'=>array('value'=>'','color'=>'#173177'),
  				);
  				sendTemplate_common($from_user,$template_id,$_url,$data);
  			}else{
	  			$msg = "<a href='".$_url."'>点击领取邀请码:".$invite_code."</a>";
	  			return $msg;
	  			post_send_text($from_user,$msg);
  			}
  			return;
  		}else{
  			return "生成邀请码失败!";
  			post_send_text($from_user,"生成邀请码失败!");
  			return;
  		}
  	}
  }
  
  function NoRand($begin = 0, $end = 9, $limit = 8) {
  	global $_W, $_GPC;
  	$rand_array = range($begin, $end);
  	shuffle($rand_array); //调用现成的数组随机排列函数
  	$r = array_slice($rand_array, 0, $limit); //截取前$limit个
  	$r = implode($r);
  	$the = pdo_get('cgc_voice_book_code', array (
  			'uniacid' => $_W['uniacid'],
  			'invite_code' => $r
  	));
  	if ($the) {
  		return NoRand();
  	}
  	return $r;
  }
  
   function downUrlFile($url,$type,$uniacid){
  	global $_W, $_GPC;
  	load()->func('communication');
  	$resp = ihttp_get($url);
  	$result = array(
  			'error' => 1,
  			'message' => '',
  			'data' => ''
  	);
  	if (is_error($resp)) {
  		$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
  		return $result;
  	}
  	if (intval($resp['code']) != 200) {
  		$result['message'] = '提取文件失败: 未找到该资源文件.';
  		return $result;
  	}
  	
  	load()->func('file');
  	
  	$folder = "{$type}s/{$uniacid}";
  	$folder .= '/'.date('Y/m/');
  	
  	$ext = pathinfo($url, PATHINFO_EXTENSION);
  	$originname = pathinfo($url, PATHINFO_BASENAME);
  	$filename = file_random_name(ATTACHMENT_ROOT. $folder, $ext);
  	
  	$pathname = $folder . $filename;
  	$fullname = ATTACHMENT_ROOT  . $pathname;
  	
  	if (!file_exists(ATTACHMENT_ROOT .$folder)){
  		mkdir(ATTACHMENT_ROOT .$folder,0777,true);
  	}
  	
//   	exit($pathname);
  	if (file_put_contents($fullname, $resp['content']) == false) {
  		$result['message'] = '提取失败.';
  		return $result;
  	}
  	$info = array(
  			'name' => $originname,
  			'ext' => $ext,
  			'filename' => $pathname,
  			'attachment' => $pathname,
  			'url' => tomedia($pathname),
  	);
  	if (!empty($_W['setting']['remote']['type'])) {
  		$remotestatus = file_remote_upload($pathname);
  		if (is_error($remotestatus)) {
  			$result['message'] = '远程附件上传失败，请检查配置并重新上传';
  			file_delete($pathname);
  			return $result;
  		} else {
  			file_delete($pathname);
  			$info['url'] = tomedia($pathname);
  		}
  	}
  	return $info;
  }

