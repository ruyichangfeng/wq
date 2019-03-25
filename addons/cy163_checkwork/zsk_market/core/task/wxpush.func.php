<?php 
	function get_form_id($tousers){ 

		$uniacid0=intval($setting['uniacid']);
		$model=Model("formid");
		$ops="";
		foreach ($tousers as $key => $val) {
			$ops.="'".$val['openid']."',";
		}
		if(strlen($ops)){ 
			$ops=substr($ops,0,strlen($ops)-1);
			$formids=$model->where("openid in ($ops) and createtime>".(time()-86390*7))->order("createtime asc")->group("openid")->getall("id,openid,content,createtime");
			 
			$ids="";
			foreach ($tousers as $key => $val) {
				foreach ($formids as $k => $v) {
				 	if($val['openid']==$v['openid']){
				 		$ids.=$v['id'].",";
				 		$tousers[$key]['formid']=$v['content'];
				 		unset($formids[$k]);
				 		continue;
				 	}
				}
			}    
			if(strlen($ids)){//删掉用了的id
				$ids=substr($ids, 0,strlen($ids)-1);
				$model->limit(count($tousers))->delete("id in ($ids)");
			}

		}
		return $tousers;
	}
	 
	//提现失败
	function withdraw_fail($openid,$data){
		global $_W,$setting; 
		if(strlen($setting['wxapp_conf']['tplid_withdraw_fail'])<20) return false;
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
	    $formid=get_form_id($openid);
	    $res['formid']=$formid;
		if(strlen($formid)<10)return false;
		if($data['type']=="wxpay")$payway="微信零钱";
		if($data['type']=="bank")$payway="银行卡";
		$jsonStr='{
			  "touser": "'.$openid.'",
			  "template_id": "'.$setting['wxapp_conf']['tplid_withdraw_fail'].'",
			  "page": "zsk_market/pages/index/home",
			  "form_id": "'.$formid.'",
			  "data": {
			      "keyword1": {
			          "value": "'.$data['datetime'].'"
			      },
			      "keyword2": {
			          "value": "'.$payway.'"
			      },
			      "keyword3": {
			          "value": "'.mb_substr($data['account'], 0,1,"gbk").' **** '.mb_substr($data['account'], strlen($data['account'])-4,4,"gbk").'"
			      },
			      "keyword4": {
			          "value": "'.date("Y-m-d H:i:s",time()).'"
			      },
			      "keyword5": {
			          "value": "'.$data['reply'].'"
			      }
			  } 
		}'; 
		$res=CURL_send($url,$jsonStr);
		if(intval($res['errcode'])==41001||intval($res['errcode'])==40001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		return $res;
	}
	//拼团成功
	function pintuan_tpl_ok($tousers,$orders){
		global $_W,$setting;   
		if(strlen($setting['wxapp_conf']['tplid_pintuan_ok'])<20) return false;
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
		
		foreach ($orders as $k => $data) {
			foreach ($tousers as $key => $user) {
				if($data['openid']==$user['openid']){ 
					if(strlen($user['formid'])<10)continue;
					 $jsonStr='{
						  "touser": "'.$user['openid'].'",
						  "template_id": "'.$setting['wxapp_conf']['tplid_pintuan_ok'].'",
						  "page": "zsk_market/pages/index/home",
						  "form_id": "'.$user['formid'].'",
						  "data": {
						      "keyword1": {
						          "value": "'.$data['order_no'].'"
						      },
						      "keyword2": {
						          "value": "'.$data['abstract'].'"
						      },
						      "keyword3": {
						          "value": "'.$data['money_pay'].'"
						      } ,
						      "keyword4": {
						          "value": "'.$data['date'].'"
						      },
						      "keyword5": {
						          "value": "'.$data['remark'].'"
						      }
						  } 
					}'; 
					$res=CURL_send($url,$jsonStr);
					if(intval($res['errcode'])==41001||intval($res['errcode'])==40001){
						$token=$js->getToken(true);
						$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
						$res=CURL_send($url,$jsonStr);
					} 
					$res['json']=json_decode($jsonStr,true);
					$res['access_token']=$token;  
					break;
				}
			}
		} 

		return $res;
	}
	//拼团发货提现
	function pintuan_tpl_send($tousers,$data){
		global  $setting; 
		if(strlen($setting['wx_conf']['tplid_pintuan_send'])<20) return false;
 	 	$js=new Wechat($setting['wx_auth_id'],$setting['wx_conf']['appid'],$setting['wx_conf']['secret']);
 	 	$token=$js->getToken(); 
 	
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token['access_token'];
  		
		foreach ($tousers as $key => $user) {  
			 
			$json=[
				"touser"=>$user['openid'],
				"template_id"=>$setting['wx_conf']['tplid_pintuan_send'],
				"data"=>[
					"first"=>["value"=>"你的店铺有新的拼团订单需要处理！"],
					"keyword1"=>["value"=>$data['order_count']],
					"keyword2"=>["value"=>date("Y-m-d H:i:s",time())],
					"remark"=>["value"=>$data['remark']],
				],
				
			];
			$res=CURL_send($url,json_encode($json,JSON_UNESCAPED_UNICODE)); 
			 
			if(intval($res['errcode'])==41001||intval($res['errcode'])==40001){
				$token=$js->getToken(true);  
				$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token['access_token'];
				$res=CURL_send($url,json_encode($json,JSON_UNESCAPED_UNICODE)); 
			} 
			$res['json']=$json;
			 
		} 
		return $res;
	}
	//拼团失败提现
	function pintuan_tpl_fail($tousers,$orders){
		global $_W,$setting; 
		if(strlen($setting['wxapp_conf']['tplid_pintuan_fail'])<20) return false;
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
		foreach ($orders as $k => $data) {
			foreach ($tousers as $key => $user) {
				if($data['openid']==$user['openid']){ 
					if(strlen($user['formid'])<10)continue;
					 $jsonStr='{
						  "touser": "'.$user['openid'].'",
						  "template_id": "'.$setting['wxapp_conf']['tplid_pintuan_fail'].'",
						  "page": "zsk_market/pages/index/home",
						  "form_id": "'.$user['formid'].'",
						  "data": {
						      "keyword1": {
						          "value": "'.$data['order_no'].'"
						      },
						      "keyword2": {
						          "value": "'.$data['abstract'].'"
						      },
						      "keyword3": {
						          "value": "'.$data['money_pay'].'"
						      } ,
						      "keyword4": {
						          "value": "'.$data['date'].'"
						      },
						      "keyword5": {
						          "value": "'.$data['remark'].'"
						      }
						  } 
					}'; 
					$res=CURL_send($url,$jsonStr);
					if(intval($res['errcode'])==41001||intval($res['errcode'])==40001){
						$token=$js->getToken(true);
						$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
						$res=CURL_send($url,$jsonStr);
					} 
					$res['json']=json_decode($jsonStr,true);
					break;
				}
			}
		}

		return $res;
	}
	//秒杀开始提醒
	function miaosha_start($tousers){
		global $_W,$setting;
		if(strlen($setting['wxapp_conf']['tplid_activity_start'])<20) return false;
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
		foreach ($tousers as $key => $user) {
			if(strlen($user['formid'])<10)continue;
			 $jsonStr='{
				  "touser": "'.$user['openid'].'",
				  "template_id": "'.$setting['wxapp_conf']['tplid_activity_start'].'",
				  "page": "zsk_market/pages/index/home",
				  "form_id": "'.$user['formid'].'",
				  "data": {
				      "keyword1": {
				          "value": "'.$user['keyword1'].'"
				      },
				      "keyword2": {
				          "value": "'.$user['keyword2'].'"
				      } 
				  } 
			}';  
			$res=CURL_send($url,$jsonStr); 
			if(intval($res['errcode'])==41001||intval($res['errcode'])==40001){
				$token=$js->getToken(true);
				$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
				$res=CURL_send($url,$jsonStr);
			} 
			$res['json']=json_decode($jsonStr);
			$tousers[$key]['result']=$res;
		}
		return $tousers;
	}
	function lib_list(){
		$url="https://api.weixin.qq.com/cgi-bin/wxopen/template/library/list?access_token=ACCESS_TOKEN
";

	} 