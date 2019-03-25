 <?php
 class Priter extends ZskPage
 { 
 	public function orderxxxx(){
 		 global $_W,$_GPC;
 		$model=Model("order");
 		$order_no="20180623150200924";
 		$result=$model->where($order_no)->get();
 		include $this->template("web/temp/priter");
 	} 

 	//创建电子面单、打印电子面单
 	public function order(){
 		 global $_W,$_GPC;
 		$model=Model("order");
 		$shopid=getShopID();
 		$order=$model->where("order_no='".$_GPC['order']."'")->get(); 
		if(intval($order['pay_status'])<1){
			if(intval($order['discounttype'])==4||intval($order['discounttype'])==5){
				message("活动未完成不能发货");exit;
			}
			if(intval($order['pay_way'])==1){
				message("微信未支付不能发货");exit;
			}
		}
		
 	 	$default=Model("shopexpress")->where("shopid=".$shopid." and status=2")->get();
 	 	$explist=json_decode(file_get_contents(ZSK_PATH."/static/datas/express.json"),true);
 	 	$buff=false; 
 	 	foreach ($explist as $key => $val) {
 			if($val['code']==$default['code']&& intval($val['printer'])>0){
 				$buff=true;
 			}
 		}
 	 	if(!$buff){
 	 		$result1['Reason']="不支持的快递类型";
 	 	}
 	 	else{
	 		$kdniao=$setting['kdniao'];
	 		$shop=getShopInfo();

	 		//构造电子面单提交信息
	 		$eorder = [];
	 		$eorder["ShipperCode"] = $default['code'];//快递公司
	 		$eorder["OrderCode"] = $order['order_no'];//订单编号
	 		$eorder["PayType"] = 1;//付款方式1.现付2.到付3.月结4.第三方付
	 		$eorder["ExpType"] = 1;//快递方式:标准快件

	 		$sender = [];
	 	
	 		$sender["Name"] = $shop['express']['contact'];//发件方
	 		$sender["Mobile"] = $shop['express']['mobile'];
	 		$sender["ProvinceName"] = $shop['express']['province'];//省份
	 		$sender["CityName"] = $shop['express']['city'];//市 
	 		$sender["Address"] = $shop['express']['address'];
	 		 
	 		$receiver = [];
	 		$receiver["Name"] = $order['contact'];//收件方
	 		$receiver["Mobile"] = $order['mobile'];
	 		$receiver["ProvinceName"] = $order['province'];
	 		$receiver["CityName"] = $order['city'];
	 		$receiver["ExpAreaName"] = $order['county'];
	 		$receiver["Address"] = $order['street'];

	 		$commodityOne = [];
	 		//if(strlen($order['abstract'])>60){$order['abstract']=substr($order['abstract'], 0,60);}
	 		$commodityOne["GoodsName"] = $order['abstract'];//货物类型
	 		$commodity = [];
	 		$commodity[] = $commodityOne;

	 		$eorder["Sender"] = $sender;//发件
	 		$eorder["Receiver"] = $receiver;//收件
	 		$eorder["Commodity"] = $commodity;//货物
	 		$eorder["IsReturnPrintTemplate"]=1;
	 		 
	 		// 调用电子面单 
	 		$jsonParam = JSON_OUT($eorder);
	 		 
	 		//$jsonParam = JSON($eorder);//兼容php5.2（含）以下

	 		// echo "电子面单接口提交内容：<br/>".$jsonParam;
	 		$jsonResult=$this->submitEOrder($jsonParam);
	 		//header("Content-Type:text/html;charset=utf-8");
	 		 
	 		//解析电子面单返回结果
	 		$result1 = json_decode($jsonResult, true); 
	 		 
	 		if(strlen($result1['Order']["LogisticCode"])>5) {
	 		  	
	 			$model->where("order_no='".$order['order_no']."'")->save(array(
	 				"expressno"=>$result1['Order']['LogisticCode'],
	 				"expresstype"=>$default['code'],
	 				"status"=>2,
	 				"sendtime"=>date("Y-m-d H:i:s",time())
	 			));
	 			$order=$model->where("order_no='".$_GPC['order']."'")->get(); 
	 			$res=order_send($order['openid'],$order);
	 			 
	 		}
 		}
 		// else {
 		//     echo "<br/>电子面单下单失败";
 		// }
 		//var_dump($result1);
 		include $this->template("web/printer/order");
 	}

 	 //打印快递调用方法电子面单
 	 /**
 	 * Json方式 调用电子面单接口
 	 */
 	public function submitEOrder($requestData){
 		$setting=getSetting();
 		$userid=$setting['kdniao_id'];
 		$key=$setting['kdniao_key'];
 	    $datas = array(
 	        'EBusinessID' =>$userid,
 	        'RequestType' => '1007',
 	        'RequestData' =>urlencode($requestData),
 	        'DataType' => '2',
 	    );
 	    $datas['DataSign'] =$this->encrypt($requestData, $key);

 	     //$result=$this->sendPost('http://api.kdniao.cc/api/Eorderservice', $datas);  
 	    $result=$this->sendPost('http://testapi.kdniao.com:8081/api/Eorderservice', $datas);  
 	    //根据公司业务处理返回的信息......
 	    return $result;
 	}

 	 
 	/**
 	 *  post提交数据 
 	 * @param  string $url 请求Url
 	 * @param  array $datas 提交的数据 
 	 * @return url响应返回的html
 	 */
 	public function sendPost($url, $datas) {
 	    $temps = array();   
 	    foreach ($datas as $key => $value) {
 	        $temps[] = sprintf('%s=%s', $key, $value);      
 	    }   
 	    $post_data = implode('&', $temps);
 	    $url_info = parse_url($url);
 	    if(empty($url_info['port']))
 	    {
 	        $url_info['port']=80;   
 	    }
 	    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
 	    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
 	    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
 	    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
 	    $httpheader.= "Connection:close\r\n\r\n";
 	    $httpheader.= $post_data;
 	    $fd = fsockopen($url_info['host'], $url_info['port']);
 	    fwrite($fd, $httpheader);
 	    $gets = "";
 	    $headerFlag = true;
 	    while (!feof($fd)) {
 	        if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
 	            break;
 	        }
 	    }
 	    while (!feof($fd)) {
 	        $gets.= fread($fd, 128);
 	    }
 	    fclose($fd);  
 	    
 	    return $gets;
 	}

 	/**
 	 * 电商Sign签名生成
 	 * @param data 内容   
 	 * @param appkey Appkey
 	 * @return DataSign签名
 	 */
 	public function encrypt($data, $appkey) {
 	    return urlencode(base64_encode(md5($data.$appkey)));
 	}

 	/************************************************************** 
 	 * 
 	 *  使用特定function对数组中所有元素做处理 
 	 *  @param  string  &$array     要处理的字符串 
 	 *  @param  string  $function   要执行的函数 
 	 *  @return boolean $apply_to_keys_also     是否也应用到key上 
 	 *  @access public 
 	 * 
 	 *************************************************************/  
 	public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
 	{  
 	    static $recursive_counter = 0;  
 	    if (++$recursive_counter > 1000) {  
 	        die('possible deep recursion attack');  
 	    }  
 	    foreach ($array as $key => $value) {  
 	        if (is_array($value)) {  
 	            $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);  
 	        } else {  
 	            $array[$key] = $function($value);  
 	        }  
 	   
 	        if ($apply_to_keys_also && is_string($key)) {  
 	            $new_key = $function($key);  
 	            if ($new_key != $key) {  
 	                $array[$new_key] = $array[$key];  
 	                unset($array[$key]);  
 	            }  
 	        }  
 	    }  
 	    $recursive_counter--;  
 	}  


 	/************************************************************** 
 	 * 
 	 *  将数组转换为JSON字符串（兼容中文） 
 	 *  @param  array   $array      要转换的数组 
 	 *  @return string      转换得到的json字符串 
 	 *  @access public 
 	 * 
 	 *************************************************************/  
 	public function JSON($array) {  
 	    $this->arrayRecursive($array, 'urlencode', true);  
 	    $json = json_encode($array);  
 	    return urldecode($json);  
 	}

}