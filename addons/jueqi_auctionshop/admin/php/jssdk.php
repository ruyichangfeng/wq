<?php
class JSSDK
{
    private $appId;
    private $appSecret;

 
    private $weid;

    public function __construct(){
        global $_W;
        $this->weid = $_W['uniacid'];
        load()->model('account');
        $_W['account'] = account_fetch($_W['uniacid']);
        $this->appId = $_W['account']['key'];
        $this->appSecret = $_W['account']['secret'];
		
        $_W['account']['appid_share'] = $this->appId;
        $_W['account']['appsecret_share'] = $this->appSecret;

    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
   
        if (IMS_VERSION >= 0.6) {
            load()->func('cache');
        }
        $api = cache_load("auctionshop.flight.api_share.json::" . $this->weid, true);
        $new = false;
        if (empty($api['appid']) || $api['appid'] !== $this->appId) {
            $new = true;
        }
        if (empty($api['appsecret']) || $api['appsecret'] !== $this->appSecret) {
            $new = true;
        }

        $data = cache_load("auctionshop.flight.jsapi_ticket.json::" . $this->weid, true);

        if (empty($data['expire_time']) || $data['expire_time'] < time() || $new) {
            $accessToken = $this->getAccessToken();

            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=1&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
			
            if ($ticket) {
            	
                $data['expire_time'] = time() + 7000;
                $data['jsapi_ticket'] = $ticket;
                cache_write("auctionshop.flight.jsapi_ticket.json::" . $this->weid, iserializer($data));
                cache_write("auctionshop.flight.api_share.json::" . $this->weid, iserializer(array("appid" => $this->appId, "appsecret" => $this->appSecret)));
            }
        } else {
        	
            $ticket = $data['jsapi_ticket'];
        }

        return $ticket;
    }

    private function getAccessToken()
    {
		$acc = WeAccount::create($this->weid);
		$token = $acc->fetch_token();
        return $token;
    }

    private function httpGet($url){
    
        if(function_exists('curl_init')){
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	        curl_setopt($ch, CURLOPT_HEADER, 0);
	        $return = curl_exec($ch);
	        curl_close($ch); 
	        return $return;
	    }
	    return false;
    }

}