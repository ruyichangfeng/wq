<?php

class Message 
{
	
	
	
	/*
	未支付提醒通知
	
	{{first.DATA}}

	{{type.DATA}}名称：{{e_title.DATA}}
	订单编号：{{o_id.DATA}}
	下单时间：{{order_date.DATA}}
	订单金额：{{o_money.DATA}}
	{{remark.DATA}} 
	编号：TM00470[标题：未支付提醒通知]
	*/
	public static function kmessage($openid,$item='',$module,$fee,$title,$time,$orderid,$idoforder) {
		
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		$i_item = empty($item) ? '您有一笔订单还未支付，就要过期了，支付后我们会准备给您发货。' : $item;

		$i_id = $module -> module['config']['k_id'];
		$i_remark = $module -> module['config']['k_remark'];

		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"type":{
					"value":"商品"
				},				
               	"o_money":{
					"value":"'.$fee.'",
               		"color":"#ff5f27"
				},
               	"e_title":{
					"value":"'.$title.'",
               		"color":"#ff5f27"
				},
               	"order_date":{
					"value":"' . date('Y-m-d H:i:s',$time) .'",
               		"color":"#ff5f27"
				},
               	"o_id":{
					"value":"'.$orderid.'",
               		"color":"#ff5f27"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	
	/*
	售出成功通知
	{{first.DATA}}
	商品名称：{{keyword1.DATA}}
	成交时间：{{keyword2.DATA}}
	成交金额：{{keyword3.DATA}}
	{{remark.DATA}}
	编号：OPENTM406074965[标题：售出成功通知]
	*/
	public static function jmessage($module,$title,$fee,$idoforder) {
		if(empty($module->module['config']['adminopenid'])) return false;		
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder,'isadmin'=>1));
		
		$i_item = '平台有会员下单购买了一款商品，请及时发货处理，点击此处可查看订单详情';
		$i_id = $module -> module['config']['j_id'];
		$i_remark = $module -> module['config']['j_remark'];
		$msg_json = '{
           	"touser":"' . $module->module['config']['adminopenid'] . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$title.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#ff5f27"
				},
               	"keyword3":{
					"value":"'.$fee.' 元",
               		"color":"#ff5f27"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	/*
	订单取消通知
	{{first.DATA}}
	订单编号：{{keyword1.DATA}}
	订单金额：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM400925266[标题：订单取消通知]
	*/
	public static function imessage($openid,$module,$orderid,$fee,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		
		$i_item = '您有一笔订单没有及时支付已被取消了，点击此处可查看订单详情。';
		$i_id = $module -> module['config']['i_id'];
		$i_remark = $module -> module['config']['i_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"'.$fee.'",
               		"color":"#ff5f27"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	/*
	订单完成通知
	{{first.DATA}}
	订单号：{{keyword1.DATA}}
	完成时间：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM202521011[标题：订单完成通知]
	*/
	public static function hmessage($openid,$module,$orderid,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		
		$i_item = '您有一笔订单超过确认收货时间已自动完成了，点击此处查看订单详情';
		$i_id = $module -> module['config']['h_id'];
		$i_remark = $module -> module['config']['h_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#ff5f27"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	/*
	组团失败提醒
	{{first.DATA}}
	商品信息：{{keyword1.DATA}}
	组团信息：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM400833482[标题：组团失败提醒]
	*/
	public static function gmessage($openid,$module,$title,$fullnumber,$groupid) {
		$url2 = Util::createModuleUrl('group',array('groupid'=>$groupid));
		
		$i_item = '您的团购组团失败了，请等待系统处理此订单，点击此处查看团详情';
		$i_id = $module -> module['config']['g_id'];
		$i_remark = $module -> module['config']['g_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$title.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"'.$fullnumber.'人团",
               		"color":"#ff5f27"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	
	/*
	订单退款提醒
	{{first.DATA}}
	订单编号：{{keyword1.DATA}}
	退款金额：{{keyword2.DATA}}
	退款方式：{{keyword3.DATA}}
	到账时间：{{keyword4.DATA}}
	{{remark.DATA}}
	编号：OPENTM200565278[标题：订单退款提醒]
	*/
	public static function fmessage($openid,$module,$orderid,$fee,$paytype,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		
		if($paytype == 'wechat') $typestr = '支付方式原路退回';
		if($paytype == 'credit') $typestr = '退回账户余额内';
		
		$i_item = '您有订单已退款了，点击此处查看订单详情';
		$i_id = $module -> module['config']['f_id'];
		$i_remark = $module -> module['config']['f_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"'.$fee.' 元",
               		"color":"#ff5f27"
				},			
               	"keyword3":{
					"value":"'.$typestr.'",
               		"color":"#ff5f27"
				},				
               	"keyword4":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#777777"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	
	/*
	订单发货通知
	{{first.DATA}}
	订单内容：{{keyword1.DATA}}
	物流服务：{{keyword2.DATA}}
	快递单号：{{keyword3.DATA}}
	收货信息：{{keyword4.DATA}}
	{{remark.DATA}}
	编号：OPENTM202243318[标题：订单发货通知]
	*/
	public static function emessage($openid,$module,$title,$expressname,$expressnumber,$address,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		
		if(empty($expressname)) $expressname = '无物流';
		if(empty($expressnumber)) $expressnumber = '无物流';
		$i_item = '嗖嗖嗖，您的宝贝已上路，点击此处可查看订单详情';
		$i_id = $module -> module['config']['e_id'];
		$i_remark = $module -> module['config']['e_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$title.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"'.$expressname.'",
               		"color":"#ff5f27"
				},			
               	"keyword3":{
					"value":"'.$expressnumber.'",
               		"color":"#ff5f27"
				},				
               	"keyword4":{
					"value":"'.$address.'",
               		"color":"#777777"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	/*
	团购成功通知
	{{first.DATA}}
	{{first.DATA}}
	订单编号：{{keyword1.DATA}}
	团购商品：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM206953990[标题：团购成功通知]
	*/
	public static function dmessage($openid,$module,$orderid,$idoforder) {

		$time = Util::lastTime($overtime,false);		
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		$i_item = '您的团购已经组团成功了，我们会在最快时间内为您发货，点击此处可查看订单详情';
		$i_id = $module -> module['config']['d_id'];
		$i_remark = $module -> module['config']['d_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#ff5f27"
				},				
               	"keyword2":{
					"value":"点击此处查看商品详情",
               		"color":"#ff5f27"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	
	/*
	参团成功通知
{{first.DATA}}
拼团名：{{keyword1.DATA}}
拼团价：{{keyword2.DATA}}
有效期：{{keyword3.DATA}}
{{remark.DATA}}
	编号：OPENTM400048581[标题：参团成功通知]
	*/
	public static function cmessage($openid,$module,$title,$overtime,$price,$groupid) {
		$time = Util::lastTime($overtime,false);		
		$url2 = Util::createModuleUrl('group',array('groupid'=>$groupid));
		$i_item = '您已参团成功，再邀请'.$number.'位朋友参团就可团购成功了，点击此处可查看团详情';
		
		$i_id = $module -> module['config']['c_id'];
		$i_remark = $module -> module['config']['c_remark'];

		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},							
               	"keyword1":{
					"value":"' . $title .'",
               		"color":"#ff5f27"
				},	
               	"keyword2":{
					"value":"' . $price .' 元",
               		"color":"#ff5f27"
				},				
               	"keyword3":{
					"value":"' . $time .'",
               		"color":"#ff5f27"
				},							
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	
	/*
	开团成功提醒
	{{first.DATA}}
	商品名称：{{keyword1.DATA}}
	商品价格：{{keyword2.DATA}}
	组团人数：{{keyword3.DATA}}
	拼团类型：{{keyword4.DATA}}
	组团时间：{{keyword5.DATA}}
	{{remark.DATA}}
	编号：OPENTM407307456[标题：开团成功提醒]
	*/
	public static function bmessage($openid,$module,$title,$price,$number,$groupid) {
		$url2 = Util::createModuleUrl('group',array('groupid'=>$groupid));
		
		$lastnumber = $number - 1;
		$title = self::shortTitle($title);
		$i_item = '您已开团成功，再邀请'.$lastnumber.'位朋友参团就可团购成功了，点击此处可查看团详情';
		$i_id = $module -> module['config']['b_id'];
		$i_remark = $module -> module['config']['b_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},							
               	"keyword1":{
					"value":"' . $title .'",
               		"color":"#ff5f27"
				},	
               	"keyword2":{
					"value":"' . $price .' 元",
               		"color":"#ff5f27"
				},				
               	"keyword3":{
					"value":"' . $number .'人",
               		"color":"#ff5f27"
				},
               	"keyword4":{
					"value":"无",
               		"color":"#ff5f27"
				},				
               	"keyword5":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#ff5f27"
				},							
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	/*
	商品支付成功通知
	{{first.DATA}}
	付款金额：{{keyword1.DATA}}
	商品详情：{{keyword2.DATA}}
	支付方式：{{keyword3.DATA}}
	交易单号：{{keyword4.DATA}}
	交易时间：{{keyword5.DATA}}
	{{remark.DATA}}
	编号：OPENTM206425979[标题：商品支付成功通知]
	*/
	public static function amessage($openid,$module,$fee,$title,$paytype,$orderid,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		if( $paytype == 'wechat')  $paytype = '微信支付';
		if( $paytype == 'credit')  $paytype = '余额支付';
		
		$title = self::shortTitle($title);
		$i_item = '您已支付成功，我们会在最快的时间内为您发货，点击此处可查看订单详情';
		$i_id = $module -> module['config']['a_id'];
		$i_remark = $module -> module['config']['a_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"' . $fee .' 元",
               		"color":"#44b549"
				},							
               	"keyword2":{
					"value":"' . $title .'",
               		"color":"#ff5f27"
				},
               	"keyword3":{
					"value":"' . $paytype .'",
               		"color":"#ff5f27"
				},	
               	"keyword4":{
					"value":"' . $orderid .'",
               		"color":"#ff5f27"
				},					
               	"keyword5":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#777777"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}
	
	
	static function shortTitle($title){
		return mb_substr($title,0,40,"utf-8") . '...';
	}
	
	//模板消息url
	static function getUrl1(){
		load() -> model('account');
		$access_token = WeAccount::token();
		$url1 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token . "";		
		return $url1;
	}
	
	static function commonPostMessage($msg_json){
		$url1 = self::getUrl1();
		$res = Util::httpPost($url1, $msg_json,1);
		$res = json_decode((string)$res,true);
		if($res['errmsg'] == 'ok') return true;return false;
	}	
	
	
}
?>