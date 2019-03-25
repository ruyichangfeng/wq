<?php
 
/* 
统一使用 ims_giz_service_token 数据表进行存储
示例：

$wx=new WeixinJS($appid,$secret);
$token=$wx->getToken();
$res=doApi($token);//调用需要token的接口
if($res['errcode']=="40001"){//缓存的access_token不正确
    $shop=$wx->getToken(true);//强制获取token
    $res=doApi($token);
} 
$jssdk=$wx->getSignPackage();//获取完整微信js签名包

*/  
class WeixinJS{
    public $appId;
    public $appSecret; 
    
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }
    
    public function getToken($new=false){//快捷方法
        if($new){
            return $this->getAccessToken();
        }else{
            return $this->getCacheToken();
        }
    }

    //获取数据库缓存的token
    public function getCacheToken(){
        $db=new Model("token");
        $data=$db->where(" appid='".$this->appId."'")->get();
        if(empty($data)){
            $db->add(array("appid"=>$this->appId));
        } 
        $data['errcode']=0;
        $data['errmsg']="获取缓存的token [get cache token in WeixinJS]";
        if((intval($data['lasttime'])<(time()-7150)||strlen($data['access_token'])<100)){//过期刷新
            $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appId.'&secret='.$this->appSecret; 
            $data=$this->getAccessToken(); 
        } 
        return $data;
    }

    //调用接口刷新token
    public function getAccessToken(){
        $appId = $this->appId;
        $appSecret = $this->appSecret;
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appSecret;
        $res = $this->api_request($url);
        if(isset($res->access_token)){
            $db=new Model("token");
            $db->where(" appid='".$appId."' ")->limit(1)->save( array("access_token"=>$res->access_token,"lasttime"=>time())); 
            return array(
                'errcode'       =>0,
                'errmsg'        =>'success',
                'access_token'  =>$res->access_token,
                'expires_in'    =>$res->expires_in
            );
        }else{
            return array(
                'errcode'       =>$res->errcode,
                'errmsg'        =>$res->errmsg,
                'access_token'  =>null,
                'expires_in'    =>null
            );
        }
    }

    //获取完整微信js-sdk，$new=true时强制刷新。 
    public function getSignPackage()
    { 
        $jsapiTicket_data = $this->getJsApiTicket();
        $nonceStr = $this->getNonceStr();
        $timestamp = time();
        $url = $this->getUrl();
        if($jsapiTicket_data['errcode']==0){
            $jsapiTicket = $jsapiTicket_data['ticket'];
            // 这里参数的顺序要按照 key 值 ASCII 码升序排序
            $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature = sha1($string);
            return  array(
                "appId"         => $this->appId,
                "nonceStr"      => $nonceStr,
                "timestamp"     => $timestamp,
                "url"           => $url,
                "signature"     => $signature,
                "rawString"     => $string,
                "errcode"       => $jsapiTicket_data['errcode'],
                "errmsg"        => $jsapiTicket_data['errmsg']
            );
        }else{
            return  array(
                "appId"         => $this->appId,
                "nonceStr"      => $nonceStr,
                "timestamp"     => $timestamp,
                "url"           => $url,
                "signature"     => null,
                "rawString"     => null,
                "errcode"       => $jsapiTicket_data['errcode'],
                "errmsg"        => $jsapiTicket_data['errmsg']
            );
        }
    }

    public function getJsApiTicket($new=false){
        $access_token_data = $this->getToken($new);
        if($access_token_data['errcode']==0){
            $access_token = $access_token_data['access_token'];
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
            $res = $this->api_request($url);
            if($res->errcode==0){

                return array(
                    'errcode'     =>$res->errcode,
                    'errmsg'      =>$res->errmsg,
                    'ticket'      =>$res->ticket,
                    'expires_in'  =>$res->expires_in
                );
            }else if($res->errcode==40001){//缓存的token不正确
                $this->getJsApiTicket(ture);
            }else{
                return array(
                    'errcode'     =>$res->errcode,
                    'errmsg'      =>$res->errmsg,
                    'ticket'      =>null,
                    'expires_in'  =>null
                );
            }
        }else{

            return array(
                'errcode'         =>$access_token_data['errcode'],
                'errmsg'          =>$access_token_data['errmsg'],
                'ticket'          =>null,
                'expires_in'      =>null
            );
        }
    }
    
    /*
     * 获取nonceStr
     * */
    public function getNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $nonceStr = "";
        for ($i = 0; $i < $length; $i++) {
            $nonceStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $nonceStr;
    }
    /*
     * 获取url
     * url（当前网页的URL，不包含#及其后面部分）
     * */
    public function getUrl(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $url;
    }
    /*
     * 微信API调用方法
     * */
    public function api_request($url,$data=null){
        //初始化cURL方法
        $ch = curl_init();
        //设置cURL参数（基本参数）
        $opts = array(
            //在局域网内访问https站点时需要设置以下两项，关闭ssl验证！
            //此两项正式上线时需要更改（不检查和验证认证）
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 500,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
        );
        curl_setopt_array($ch, $opts);
        //post请求参数
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //执行cURL操作
        $output = curl_exec($ch);
        if (curl_errno($ch)) {    //cURL操作发生错误处理。
          return(curl_error($ch));
             
        }
        //关闭cURL
        curl_close($ch);
        $res = json_decode($output);
        return ($res);   //返回json数据
    }
    public function post_file($url,$path){
        $curl = curl_init();
        if (class_exists('\CURLFile')) {
          curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
        $data = array('file' => new \CURLFile(realpath($path)));//>=5.5
        } else {
          if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
          }
          $data = array('file' => '@' . realpath($path));//<=5.5
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT,"TEST");
        $result = curl_exec($curl);
        
        if (curl_errno($curl)) {    //cURL操作发生错误处理。
          return(curl_error($curl));
             
        }
        //关闭cURL
        curl_close($curl);
        $res = json_decode($result,true);
        return ($res);   //返回json数据 
    }
}  
	
	 
	 