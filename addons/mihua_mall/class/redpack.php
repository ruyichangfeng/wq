<?php
/**
 *@param $params Array
 *@param nonce_str String 随机字符串，不长于32位
 *@param sign String 签名
 *@param mch_billno String 商户订单号（每个订单号必须唯一）组成：mch_id+yyyymmdd+10位一天内不能重复的数字。
 *@param mch_id String 微信支付分配的商户号
 *@param wxappid String 微信分配的公众账号ID（企业号corpid即为此appId）
 *@param nick_name String 提供方名称
 *@param send_name String 红包发送者名称
 *@param re_openid String 接受红包的用户
 *@param total_amount int 付款金额，单位分
 *@param min_value int 最小红包金额，单位分
 *@param max_value int 最大红包金额，单位分
 *@param total_num int 红包发放总人数
 *@param wishing int 红包祝福语
 *@param client_ip String 调用接口的机器Ip地址
 *@param act_name String 活动名称
 *@param remark String 备注信息
 *@param logo_imgurl String 商户logo的url
 */
function sendRedPack($params = array(),$oid) {
	global $_W;
	$have_send=find_have_send($params['re_openid'],$_W['uniacid'],$oid);
	if($have_send) return true;
	load()->func('communication');
	$uri     = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
	$ordersn = $params['mch_id'] . date('Ymd') . substr(getMillisecond(), 0, 7) . mt_rand(100, 999);
	$params['nonce_str']  = getNonceStr();
	$params['mch_billno'] = $ordersn;
	$params['client_ip']  = CLIENT_IP;
	$_key                 = $params['key'];
	unset($params['key']);
	ksort($params);
	$string1 = '';
	foreach ($params as $key => $v) {
		if (empty($v)) {
			continue;
		}
		$string1 .= "{$key}={$v}&";
	}
	$string1 .= "key=" . $_key;
	$params['sign'] = strtoupper(md5($string1));
	$xml                       = array2xml($params);
	$extras                    = array();
	$cert_dir                  = $_SERVER['DOCUMENT_ROOT'] . '/payment/cert/';
	$extras['CURLOPT_CAINFO']  = $cert_dir . '/rootca.pem.';
	$extras['CURLOPT_SSLCERT'] = $cert_dir . '/apiclient_cert.pem.';
	$extras['CURLOPT_SSLKEY']  = $cert_dir . '/apiclient_key.pem.';
	$result                    = ihttp_request($uri, $xml, $extras);
	if (is_error($result)) {
		return false;
	}
	$xml = @simplexml_load_string($result['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
	if (strval($xml->return_code) == 'FAIL') {
		return false;
	}
	if (strval($xml->result_code) == 'FAIL') {
		return false;
	}
	insert_red_record($params['re_openid'],$params['total_amount']/100,$_W['uniacid'],$oid);
	return true;
}
function insert_red_record($openid,$money,$uniacid,$orderid=0){
	$in['openid']=$openid;
	$in['money']=$money;
	$in['uniacid']=$uniacid;
	$in['orderid']=$orderid;
	$in['addtime']=time();
	pdo_insert('mihua_mall_red',$in);
}
function find_have_send($openid,$uniacid,$orderid){
	if($orderid>0 && $openid && $uniacid){
		$result=pdo_fetch("select * from ims_mihua_mall_red where openid=:openid and uniacid=:uniacid and orderid=:orderid",array('openid'=>$openid,'uniacid'=>$uniacid,'orderid'=>$orderid));
		if($result) return true;
	}
	return false;
}
/**
 *
 * 产生随机字符串，不长于32位
 * @param int $length
 * @return 产生的随机字符串
 */
function getNonceStr($length = 32) {
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
	$str   = "";
	for ($i = 0; $i < $length; $i++) {
		$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $str;
}

function http_post($url, $param, $post_file = false) {
	$oCurl = curl_init();
	if (stripos($url, "https://") !== FALSE) {
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
	}
	if (is_string($param) || $post_file) {
		$strPOST = $param;
	} else {
		$aPOST = array();
		foreach ($param as $key => $val) {
			$aPOST[] = $key . "=" . urlencode($val);
		}
		$strPOST = join("&", $aPOST);
	}
	curl_setopt($oCurl, CURLOPT_URL, $url);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($oCurl, CURLOPT_POST, true);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
	$sContent = curl_exec($oCurl);
	$aStatus  = curl_getinfo($oCurl);
	curl_close($oCurl);
	if (intval($aStatus["http_code"]) == 200) {
		return $sContent;
	} else {
		return false;
	}
}

/**
 * 获取毫秒级别的时间戳
 */
function getMillisecond() {
	//获取毫秒的时间戳
	$time  = explode(" ", microtime());
	$time  = $time[1] . ($time[0] * 1000);
	$time2 = explode(".", $time);
	$time  = $time2[0];
	return $time;
}

function ToXml($values) {
	if (!is_array($values) || count($values) <= 0) {
		return false;
	}
	$xml = "<xml>";
	foreach ($values as $key => $val) {
		if (is_numeric($val)) {
			$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
		} else {
			$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
		}
	}
	$xml .= "</xml>";
	return $xml;
}