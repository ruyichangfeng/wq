<?php
// +----------------------------------------------------------------------
// | Time:2016-05-16
// +----------------------------------------------------------------------
// | we7平台下为第三方系统开发微信内应用提供标准API接口转发
// +----------------------------------------------------------------------
// | Author: QJH <Qiujhai@126.com>
// +----------------------------------------------------------------------

load()->classs('weixin.account');
//error_reporting(7);
class weixinApi extends WeiXinAccount{

    public    $_request;
	public    $_error;
    public    $_code;
    public    $_type          = '';                        
    public    $_data          = array();
	public 	  $account 		  = null;
	public    $acid           = null;
	private   $allowType      = array('html','xml','json');
	private   $scope          = array('snsapi_base','snsapi_userinfo');
	private   $state          = 1;
	private   $response_type  = 'code';
	private   $grant_type     = 'authorization_code';

	public function __construct() {
		$this->_request = $_REQUEST = array_merge($_GET,$_POST);
		$this->acid = $this->_request['acid'];
		$acc = self::create($this->acid);
		$this->account = $acc->account;
	}

	function __call($name,$arguments){  
	    print("Sorry , Did you call me? I'm $name!");  
	} 

	/**
     * 输出返回数据
     * @access public
     * @param mixed $data 要返回的数据
     * @param String $type 返回类型 JSON XML
     * @param integer $code HTTP状态
     * @return void
     */
    protected function dataResponse($data,$type='',$code=200) {
        $this->sendHttpStatus($code);
        exit($this->encodeData($data,strtolower($type)));
    }

	/**
	* 编码数据
	* @access public
	* @param mixed $data 要返回的数据
	* @param String $type 返回类型 JSON XML
	* @return string
	*/
    protected function encodeData($data,$type='') {
        if(empty($data))  return '';
        if('json' == $type) {
            // 返回JSON数据格式到客户端 包含状态信息
            $data = json_encode($data);
        }elseif('xml' == $type){
            // 返回xml格式数据
            $data = $this->xml_encode($data);
        }elseif('php'==$type){
            $data = serialize($data);
        }// 默认直接输出
        return $data;
    }

    // 发送Http状态信息
    protected function sendHttpStatus($code) {
        static $_status = array(
            // Informational 1xx
            100 => 'Continue',
            101 => 'Switching Protocols',
            // Success 2xx
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            // Redirection 3xx
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Moved Temporarily ',  // 1.1
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            // 306 is deprecated but reserved
            307 => 'Temporary Redirect',
            // Client Error 4xx
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            // Server Error 5xx
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded'
        );
        if(isset($_status[$code])) {
            header('HTTP/1.1 '.$code.' '.$_status[$code]);
            // 确保FastCGI模式下正常
            header('Status:'.$code.' '.$_status[$code]);
        }
    }

    /**
	 * 数据XML编码
	 * @param mixed  $data 数据
	 * @param string $item 数字索引时的节点名称
	 * @param string $id   数字索引key转换为的属性名
	 * @return string
	 */
	protected function data_to_xml($data, $item='item', $id='id') {
	    $xml = $attr = '';
	    foreach ($data as $key => $val) {
	        if(is_numeric($key)){
	            $id && $attr = " {$id}=\"{$key}\"";
	            $key  = $item;
	        }
	        $xml    .=  "<{$key}{$attr}>";
	        $xml    .=  (is_array($val) || is_object($val)) ? $this->data_to_xml($val, $item, $id) : $val;
	        $xml    .=  "</{$key}>";
	    }
	    return $xml;
	}

	/**
	 * XML编码
	 * @param mixed $data 数据
	 * @param string $root 根节点名
	 * @param string $item 数字索引的子节点名
	 * @param string $attr 根节点属性
	 * @param string $id   数字索引子节点key转换的属性名
	 * @param string $encoding 数据编码
	 * @return string
	 */
	protected function xml_encode($data, $root='imolee', $item='item', $attr='', $id='id', $encoding='utf-8') {
	    if(is_array($attr)){
	        $_attr = array();
	        foreach ($attr as $key => $value) {
	            $_attr[] = "{$key}=\"{$value}\"";
	        }
	        $attr = implode(' ', $_attr);
	    }
	    $attr   = trim($attr);
	    $attr   = empty($attr) ? '' : " {$attr}";
	    $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
	    $xml   .= "<{$root}{$attr}>";
	    $xml   .= $this->data_to_xml($data, $item, $id);
	    $xml   .= "</{$root}>";
	    return $xml;
	}

	/**
	* 公共返回错误
	* @param  [string] $errorinfo [错误码描述]
	* @param  [string] $code      [错误码]
	* @param  array  $data      [数据]
	* @return [type]            [description]
	*/
    protected function verifyError($errorinfo=null,$code=null,$data = array()) {
        $message['message'] = $errorinfo;
        $message['code']    = $code;
        $message['data']    = $data;
        $this->dataResponse($message,$this->_type);
    }

	#获取指定公众号token
	public function getToken(){
		return $this->fetch_token($this->account);
		
	}
}

 
