 <?php 
 	/*
	tplid_order_new 通知商家新订单
	tplid_refund_toadmin 通知商家有人退款
	tplid_pintuan_send 通知商家拼团发货提醒

	tplid_order_ok 用户下单成功通知
	tplid_order_send 用户订单发货通知
	tplid_order_refund 用户订单退款通知
	tplid_pintuan_ok 用户拼团成功通知
	tplid_pintuan_fail 用户拼团失败通知
	tplid_withdraw_ok 用户、商家提现成功通知
	tplid_withdraw_fail 用户、商家提现失败通知
	tplid_activity_start 活动开始通知

 	*/
	function get_form_id($openid){
		global $_W;
		$uniacid=intval($_W['uniacid']);
		$model=Model("formid"); 
		$formid=$model->where("uniacid=$uniacid and openid='$openid' and createtime>".(time()-86390*7))->order("createtime asc")->get("id,openid,content,createtime");
		 
		if(!empty($formid)){//删掉用了的id 
			$model->limit(1)->delete("id =".intval($formid['id']));
		} 
		return $formid['content'];
	}
	function sendWithdrawApply($apply){ 
        global $_GPC,$_W; 

        $setting=getSetting();
      
        $wxjs=new WeixinJS($setting['wx_appid'],$setting['wx_secret']);//获取带有access_token的shop对象
        if(is_bool($setting)||empty($setting)){
            return false;
        }
        $tplid=$setting['wx_conf']['tplid_withdraw_apply'];
        $token=($wxjs->getToken());//access_token
        $access_token=$token['access_token'];
      
        if(!$pusher){
            $pusher=Model("pusher")->where("uniacid=".intval($_W['uniacid'])." and type=5 ")->get("*");
        }  
        $url="";
        $openid=$pusher['openid'];
        $jsonStr='{
           "touser":"'.$openid.'",
           "template_id":"'.$tplid.'", 
           "url":"'.$url.'",  
           "data":{
                   "first": {
                       "value":"小程序 '.$setting['name'].' 有新的提现申请，请尽快处理",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"'.$apply['nickname'].'",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"'.$apply['datetime'].'",
                       "color":"#173177"
                   },
                   "keyword3": {
                       "value":"'.$apply['money'].'",
                       "color":"#173177"
                   },
                   "keyword4": {
                       "value":"'.$apply['type'].'",
                       "color":"black"
                   }, 
                   "remark":{
                       "value":"'.$apply['remark'].'",
                       "color":"#173177"
                   }
           }
       }'; 
       $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token; 
       $res=CURL_send($url,$jsonStr,5);  
       $res['token']=$access_token;  
       if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){//access_token不正确
            $token2=$wxjs->getToken(true);//强制获取token
            $access_token=trim($token2['access_token']);//access_token
            $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
            $res=CURL_send($url,$jsonStr,5);
            $res['token2']=$access_token;
       }   
        if($res['errcode']=="40165"){//access_token不正确 
            $res['errmsg']="小程序路径不正确，需要线上版本才能推送！";
       } 

 
        $res['jsonStr']=json_decode($jsonStr,true);
        return $res;
    } 
	 function sendOrderNotice($order,$pusher=null){ 
        global $_GPC,$_W; 

        $setting=getSetting();
      
        $wxjs=new WeixinJS($setting['wx_appid'],$setting['wx_secret']);//获取带有access_token的shop对象
        if(is_bool($setting)||empty($setting)){
            return false;
        }

        $token=($wxjs->getToken());//access_token
        $access_token=$token['access_token'];
      
        if(!$pusher){
            $pusher=Model("pusher")->where("uniacid=".intval($_W['uniacid'])." and type=2 and shopid=".intval($order['shopid']))->group("openid")->getall("*");
        } 
        $tplid=trim($setting['wx_conf']['tplid_order_new']);//微信推送模板id
         
        $customer=$order['contact']."  ".$order['mobile']."  ".$order['city']." ".$order['street'];//客户
         
        $count=Model("order")->where('uniacid='.intval($_W['uniacid'])."  ")->count();//未处理数量
        switch ($order['pay_way']) {
            case '1':
                $type="微信支付";
                break;
            case '2':
                $type="货到付款";
                break;
            default: 
                break;
        }

        foreach ($pusher as $key => $user) {
            $openid=$user['openid'];
            $jsonStr='{
               "touser":"'.$openid.'",
               "template_id":"'.$tplid.'",
               "miniprogram":{
                    "appid":"'.$setting['appid'].'",
                    "pagepath":"zsk_market/pages/index/home"
               },  
               "url":"'.$url.'",  
               "data":{
                       "first": {
                           "value":"您有新订单，请及时处理",
                           "color":"#173177"
                       },
                       "tradeDateTime":{
                           "value":"'.$order['date'].'",
                           "color":"#173177"
                       },
                       "orderType": {
                           "value":"'.$type.'",
                           "color":"#173177"
                       },
                       "customerInfo": {
                           "value":"'.$customer.'",
                           "color":"#173177"
                       },
                       "orderItemName": {
                           "value":"订单摘要",
                           "color":"#000000"
                       },
                       "orderItemData": {
                           "value":"'.$order['abstract'].'",
                           "color":"#173177"
                       },
                       "remark":{
                           "value":"",
                           "color":"#173177"
                       }
               }
           }'; 
           $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token; 
           $res=CURL_send($url,$jsonStr,5);  
           $res['token']=$access_token;  
           if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){//access_token不正确
                $token2=$wxjs->getToken(true);//强制获取token
                $access_token=trim($token2['access_token']);//access_token
                $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
                $res=CURL_send($url,$jsonStr,5);
                $res['token2']=$access_token;
           }   
            if($res['errcode']=="40165"){//access_token不正确 
                $res['errmsg']="小程序路径不正确，需要线上版本才能推送！";
           } 


        }
        
        $res['jsonStr']=json_decode($jsonStr,true);
        return $res;
    } 
    //订单申请退款提醒
	function order_refund_toadmin($data){
		 global $_GPC,$_W; 

        $setting=getSetting();
        $wxjs=new WeixinJS($setting['wx_appid'],$setting['wx_secret']);//获取带有access_token的shop对象
        if(is_bool($setting)||empty($setting)){
            return false;
        }
        $token=($wxjs->getToken());//access_token
        $access_token=$token['access_token'];
      
       
        if(!$pusher){
            $pusher=Model("pusher")->where("uniacid=".intval($_W['uniacid'])." and type=2 and shopid=".intval($data['shopid']))->group("openid")->getall("*");
        } 
        $tplid=trim($setting['wx_conf']['tplid_refund_toadmin']);//微信推送模板id
        
	    $abstract=$data['abstract'];
	    if(mb_strlen($data['abstract'],"gbk")>30){
	    	$abstract=mb_substr($data['abstract'], 0,30,"utf-8")."...";
	    }
		if(strlen($tplid)<10)return array("errno"=>4000,'errmsg'=>"模板id长度不对");
		$payway="货到付款";
		if(intval($data['pay_way'])==1)$payway="微信支付";
		 foreach ($pusher as $key => $user) {
            $openid=$user['openid'];
            $jsonStr='{
               "touser":"'.$openid.'",
               "template_id":"'.$tplid.'",
               "miniprogram":{
                    "appid":"'.$setting['appid'].'",
                    "pagepath":"zsk_market/pages/admin/index?openid='.$openid.'"
               },  
               "url":"'.$url.'",  
               "data":{
			  	  "first":{
			  	  	  "value":"有用户申请退款，请及时处理。"
			  	  },
			      "orderProductPrice": {
			          "value": "'.$data['money_pay'].'"
			      },
			      "orderProductName": {
			          "value": "'.$abstract.'"
			      },
			      "orderName": {
			          "value": "'.$data['order_no'].'"
			      } ,
			      "remark": {
			          "value": "申请时间：'.$data['date'].'"
			      }
               }
           }'; 
           $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
           $res=CURL_send($url,$jsonStr,5);  
           $res['token']=$access_token; 
           if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){//access_token不正确
                $token2=$wxjs->getToken(true);//强制获取token
                $access_token=trim($token2['access_token']);//access_token
                $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
                $res=CURL_send($url,$jsonStr,5);
                $res['token2']=$access_token;
           }   
            if($res['errcode']=="40165"){//access_token不正确 
                $res['message']="小程序路径不正确，需要线上版本才能推送！";
           } 


        }
        $res['jsonStr']=json_decode($jsonStr,true);
        return $res;
		 
	}
	//普通下单通知
	function order_notice($openid,$data){
		$setting=getSetting();
		global $_W; 
		$order = Model('order')->where("order_no='".trim($data['order_no'])."' and uniacid='".intval($_W['uniacid'])."'")->get();
		$sms=Model("smsconfig")->where("uniacid=".$_W['uniacid'])->get();
		if($sms){
			$type=true;
			if($sms['ckneworder']==1){
				$smsdata['tpl_id'] = intval($sms['ckneworderid']);
			 	$smsdata['name'] = $order['contact'];
			 	$smsdata['goodsname'] = $order['abstract'];
			 	$smsdata['phone'] = $order['mobile'];
			 	$smsdata['address'] = $order['province'].$order['city'].$order['county'].$order['street'];
			 	// var_dump($smsdata);die();
				$res = sendsms($sms['apikey'],$sms['signature'],"",$order['mobile'],$type,false,$smsdata);
				// var_dump($res);die();
			}
		}
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
	    $formid=get_form_id($openid);
	    $res['formid']=$formid;
	    $abstract=$data['abstract'];
	    if(mb_strlen($data['abstract'],"gbk")>30){
	    	$abstract=mb_substr($data['abstract'], 0,30,"utf-8")."...";
	    }
		if(strlen($formid)<10)return false;
		$payway="货到付款";
		if(intval($data['pay_way'])==1)$payway="微信支付";
		$jsonStr='{
			  "touser": "'.$openid.'",
			  "template_id": "'.$setting['wxapp_conf']['tplid_order_ok'].'",
			  "page": "zsk_market/pages/index/home",
			  "form_id": "'.$formid.'",
			  "data": {
			      "keyword1": {
			          "value": "'.$data['order_no'].'"
			      },
			      "keyword2": {
			          "value": "'.$abstract.'"
			      },
			      "keyword3": {
			          "value": "'.mb_substr($data['contact'], 0,1,"utf-8").'* '.mb_substr($data['mobile'], 0,3,"gbk").'****'.mb_substr($data['mobile'], strlen($data['mobile'])-4,4,"gbk")." ".$data['city'].$data['street'].'"
			      } ,
			      "keyword4": {
			          "value": "'.$data['date'].'"
			      },
			      "keyword5": {
			          "value": "'.$payway.'"
			      },
			      "keyword6": {
			          "value": "￥'.$data['money_pay'].'"
			      }
			  } 
		}';  
		$res=CURL_send($url,$jsonStr);
		if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		return $res;
	}

	//订单发货提醒
	function order_send($openid,$data){
		$setting=getSetting();
		global $_W; 
		// 发货短信提醒
		$order = Model('order')->where("order_no='".trim($data['order_no'])."' and uniacid='".intval($_W['uniacid'])."'")->get();
		$sms=Model("smsconfig")->where("uniacid=".$_W['uniacid'])->get();
		if($sms){
			$type=true;
			if($sms['ckdelivery']==1){
				 	$smsdata['tpl_id'] = $sms['deliveryid'];
			 		$smsdata['name'] = $order['contact'];
			 		$smsdata['goodsname'] = $order['abstract'];
			 		$smsdata['phone'] = $order['mobile'];
			 		$smsdata['address'] = $order['province'].$order['city'].$order['county'].$order['street'];
				sendsms($sms['apikey'],$sms['signature'],"",$order['mobile'],$type,false,$smsdata);
			}
		}
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
	    $formid=get_form_id($openid);
	    $res['formid']=$formid;
		if(strlen($formid)<10)return false;
		if(strlen($data['expressno'])<10&& strlen($data['expresscom'])<2)return false;
		$express=json_decode(file_get_contents(ZSK_STATIC."datas/express.json"),true);
		foreach ($express as $key => $val) {
			if($val['code']==$data['expresstype']){
				$data['expresscom']=$val['name'];
			}
		}
		$jsonStr='{
			  "touser": "'.$openid.'",
			  "template_id": "'.$setting['wxapp_conf']['tplid_order_send'].'",
			  "page": "zsk_market/pages/index/home",
			  "form_id": "'.$formid.'",
			  "data": {
			      "keyword1": {
			          "value": "'.$data['order_no'].'"
			      },
			      "keyword2": {
			          "value": "'.$data['expresscom'].'"
			      },
			      "keyword3": {
			          "value": "'.$data['expressno'].'"
			      } ,
			      "keyword4": {
			          "value": "'.$data['sendtime'].'"
			      },
			      "keyword5": {
			          "value": "'.$data['abstract'].'"
			      }
			  } 
		}'; 
		$res=CURL_send($url,$jsonStr);
		if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		 
		return $res;
	}
	//订单退款
	function order_refund($openid,$data){
$setting=getSetting();
		global $_W; 
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
	    $formid=get_form_id($openid);
	    $res['formid']=$formid;
		if(strlen($formid)<10)return false;
		$jsonStr='{
			  "touser": "'.$openid.'",
			  "template_id": "'.$setting['wxapp_conf']['tplid_order_refund'].'",
			  "page": "zsk_market/pages/index/home",
			  "form_id": "'.$formid.'",
			  "data": {
			      "keyword1": {
			          "value": "'.$data['order_no'].'"
			      },
			      "keyword2": {
			          "value": "'.$data['abstract'].'"
			      },
			      "keyword3": {
			          "value": "'.$data['refund_money'].'"
			      } ,
			      "keyword4": {
			          "value": "'.$data['refund_date'].'"
			      },
			      "keyword5": {
			          "value": "'.$data['refund_reason'].'"
			      }
			  } 
		}'; 
		$res=CURL_send($url,$jsonStr);
		if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		return $res;
	}
	//提现成功
	function withdraw_ok($openid,$data){
		$setting=getSetting();
		global $_W; 
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
			  "template_id": "'.$setting['wxapp_conf']['tplid_withdraw_ok'].'",
			  "page": "zsk_market/pages/index/home",
			  "form_id": "'.$formid.'",
			  "data": {
			      "keyword1": {
			          "value": "'.mb_substr($data['truename'], 0,1,"utf-8").'**"
			      },
			      "keyword2": {
			          "value": "'.date("Y-m-d H:i:s",time()).'"
			      },
			      "keyword3": {
			          "value": "'.mb_substr($data['account'], 0,1,"utf-8").' **** '.mb_substr($data['account'], strlen($data['account'])-4,4,"utf-8").'"
			      },
			      "keyword4": {
			          "value": "'.$payway.'"
			      },
			      "keyword5": {
			          "value": "提现通过，已提交微信处理"
			      }
			  } 
		}'; 
		$res=CURL_send($url,$jsonStr);
		if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		return $res;
	}
	//提现失败
	function withdraw_fail($openid,$data){
		$setting=getSetting();
		global $_W; 
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
		if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		return $res;
	}
	//参与拼团通知
	function pintuan_tpl($openid,$data){
		$setting=getSetting();
		global $_W; 
 	 	$js=new WeixinJS($setting['appid'],$setting['secret']);
 	 	$token=$js->getToken(); 
		$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
	    $formid=get_form_id($openid);
	    $res['formid']=$formid;
		if(strlen($formid)<10)return false;
		$jsonStr='{
			  "touser": "'.$openid.'",
			  "template_id": "'.$setting['wxapp_conf']['tplid_pintuan_ok'].'",
			  "page": "zsk_market/pages/index/home",
			  "form_id": "'.$formid.'",
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
		if(intval($res['errcode'])==40001||intval($res['errcode'])==41001){
			$token=$js->getToken(true);
			$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$token['access_token'];
			$res=CURL_send($url,$jsonStr);
		} 

		$res['json']=json_decode($jsonStr,true);  
		return $res;
	}
	 
	function lib_list(){
		 

	} 