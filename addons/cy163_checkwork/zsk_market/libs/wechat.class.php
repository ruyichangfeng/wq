<?php
    
   
     
     
function getOpenID($result=false){//获取用户openid
    global $_W; 
    $setting=getSetting("all");
    $appid=trim($setting['appid']);
    $secret=trim($setting['secret']);
    $jscode=$_POST['code'];  
    $url="https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$jscode}&grant_type=authorization_code"; 
    $res=CURL_send($url); 
    $res['url']=$url;  
    if($res){
      return $res;  
    }else{
      return $res['openid'];  
    }
}


 
class WeixinJS{
    public $appId;
    public $appSecret; 
    
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }
    public function initTable(){//创建数据表
        $createSql='CREATE TABLE '.tablename('zsk_access_token').' ( `id` INT NOT NULL AUTO_INCREMENT ,  `appid` VARCHAR(50) NULL DEFAULT NULL , `access_token` VARCHAR(300) NULL DEFAULT NULL , `lasttime` INT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;';
        pdo_query($createSql); 
    }
    public function getToken($new=false){//快捷方法
        $token="";
        if($new){
            $token=$this->getAccessToken();
        }else{
            $token=$this->getCacheToken();
        }
         if(strlen($token['access_token'])<50){
            $token=$this->getAccessToken(); 
        }
        return $token;
    }

    //获取数据库缓存的token
    public function getCacheToken(){
        $data=pdo_fetch("SELECT * FROM ".tablename('zsk_access_token')." WHERE appid='".$this->appId."' LIMIT 1") or $this->initTable();
        if(empty($data)){
            pdo_insert("zsk_access_token",array("appid"=>$this->appId));
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
            pdo_query("UPDATE ".tablename('zsk_access_token')." SET access_token='".$res->access_token."',lasttime=".time()." WHERE appid='".$appId."' LIMIT 1");
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
}  
class WXBizDataCrypt
{
    private $appid;
    private $sessionKey;

    /**
     * 构造函数
     * @param $sessionKey string 用户在小程序登录后获取的会话密钥
     * @param $appid string 小程序的appid
     */
    public function __construct( $appid, $sessionKey)
    {
        $this->sessionKey = $sessionKey;
        $this->appid = $appid;
    }


    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData( $encryptedData, $iv, &$data )
    {
        if (strlen($this->sessionKey) != 24) {
            return ErrorCode::$IllegalAesKey;
        }
        $aesKey=base64_decode($this->sessionKey);

        
        if (strlen($iv) != 24) {
            return ErrorCode::$IllegalIv;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return ErrorCode::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $this->appid )
        {
            return ErrorCode::$IllegalBuffer;
        }
        $data = $result;
        return ErrorCode::$OK;
    }

}
class ErrorCode
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;
}
    
     
     