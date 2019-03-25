<?php
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
$str = "<xml>
<appid><![CDATA[wx62bf53077f4f80f4]]></appid>
<attach><![CDATA[test]]></attach>
<bank_type><![CDATA[CFT]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[Y]]></is_subscribe>
<mch_id><![CDATA[1354683902]]></mch_id>
<nonce_str><![CDATA[q1zkv7mag70gv7vw3xoblprwdw2fk7cd]]></nonce_str>
<openid><![CDATA[o2jo0wUQezCFNBzCCEdfD8_J8UbA]]></openid>
<out_trade_no><![CDATA[135468390220170910155839]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[31EC82E42C00F731D3F503ECF25DC907]]></sign>
<time_end><![CDATA[20170910155843]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[NATIVE]]></trade_type>
<transaction_id><![CDATA[4010002001201709101315661848]]></transaction_id>
</xml>";
 $data =[
	'action' => 'success',
	'str' => $str
];
curl_request('http://wx.52zaozi.com/addons/weitest/inc/mobile/notice.inc.php',$data);
file_put_contents("c.txt",$_GET['t']);
/*$str = "<xml>
<appid><![CDATA[wx62bf53077f4f80f4]]></appid>
<attach><![CDATA[test]]></attach>
<bank_type><![CDATA[CFT]]></bank_type>
<cash_fee><![CDATA[1]]></cash_fee>
<fee_type><![CDATA[CNY]]></fee_type>
<is_subscribe><![CDATA[Y]]></is_subscribe>
<mch_id><![CDATA[1354683902]]></mch_id>
<nonce_str><![CDATA[q1zkv7mag70gv7vw3xoblprwdw2fk7cd]]></nonce_str>
<openid><![CDATA[o2jo0wUQezCFNBzCCEdfD8_J8UbA]]></openid>
<out_trade_no><![CDATA[135468390220170910155839]]></out_trade_no>
<result_code><![CDATA[SUCCESS]]></result_code>
<return_code><![CDATA[SUCCESS]]></return_code>
<sign><![CDATA[31EC82E42C00F731D3F503ECF25DC907]]></sign>
<time_end><![CDATA[20170910155843]]></time_end>
<total_fee>1</total_fee>
<trade_type><![CDATA[NATIVE]]></trade_type>
<transaction_id><![CDATA[4010002001201709101315661848]]></transaction_id>
</xml>";

$ob = simplexml_load_string($str);

echo "appid:".$ob->appid."<br>";   //公众账号ID
echo "attach:".$ob->attach."<br>";   //附加数据
echo "bank_type:".$ob->bank_type."<br>";  //银行类型  https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=4_2
echo "cash_fee:".$ob->cash_fee."<br>";
echo "fee_type:".$ob->fee_type."<br>";    //标价币种
echo "is_subscribe:".$ob->is_subscribe."<br>";  //是否关注公众账号	  Y/N
echo "mch_id:".$ob->mch_id."<br>";     //商户号	
echo "nonce_str:".$ob->nonce_str."<br>";  //随机字符串
echo "openid:".$ob->openid."<br>";   //用户标识
echo "out_trade_no:".$ob->out_trade_no."<br>";  //商户订单号
echo "result_code:".$ob->result_code."<br>";  //业务结果 SUCCESS/FAIL
echo "return_code:".$ob->return_code."<br>";  //返回状态码 SUCCESS/FAIL
echo "sign:".$ob->sign."<br>";    //签名
echo "time_end:".$ob->time_end."<br>";
echo "total_fee:".$ob->total_fee."<br>";   //订单总金额，单位为分
echo "trade_type:".$ob->trade_type."<br>";
echo "transaction_id:".$ob->transaction_id."<br>";  //微信订单号
*/
 function curl_request($url,$data = null){			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			if (!empty($data)){
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($curl);
			curl_close($curl);
			return $output;
}	
?>