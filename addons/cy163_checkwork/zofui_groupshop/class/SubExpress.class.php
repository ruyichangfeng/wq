<?php 
//订阅快递信息接口

class SubExpress{	
	private $eorder = array();		
	private $EBusinessID;	
	private $AppKey;
	private $ReqURL;
	private $expressno;	
	
	
	function __construct($eorder,$type){
		$this->eorder = $eorder;
		$this->EBusinessID = $eorder['EBusinessID'];		
		$this->AppKey = $eorder['AppKey'];
		unset($eorder['EBusinessID'],$eorder['AppKey']);
		if($type == 1) $this->ReqURL = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx'; //普通订阅
		if($type == 2) $this->ReqURL = 'http://api.kdniao.cc/api/dist'; //推送订阅
	}
	
/**
 * Json方式 查询订单物流轨迹
 */
function getOrderTracesByJson(){
	$requestData= "{'OrderCode':'','ShipperCode':'{$this->eorder['ShipperCode']}','LogisticCode':'{$this->eorder['LogisticCode']}'}";
	
	$datas = array(
        'EBusinessID' => $this->EBusinessID,
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = self::encrypt($requestData, $this->AppKey);
	$result = Util::HttpPost($this->ReqURL, $datas);	
	//根据公司业务处理返回的信息......
	
	return $result;
}	
	
	
	/**
	 * 电商Sign签名生成
	 * @param data 内容   
	 * @param appkey Appkey
	 * @return DataSign签名
	 */
	static private function encrypt($data, $appkey) {
		return urlencode(base64_encode(md5($data.$appkey)));
	}	
	
	
	/**
	 * Json方式  物流信息订阅
	 */
	function orderTracesSubByJson(){
		$requestData = <<<div
		{
			'OrderCode': '',
			'ShipperCode':"{$this->eorder['ShipperCode']}",
			'LogisticCode':'{$this->eorder['LogisticCode']}',
			'PayType':1,
			'ExpType':1,
			'IsNotice':0,
			'Cost':1.0,
			'OtherCost':1.0,
			'Sender':'',
			'Receiver':'',
			'Commodity':'',
			'Weight':'',
			'Quantity':'',
			'Volume':'',
			'Remark':''
		}
div;

		
		
		$datas = array(
			'EBusinessID' =>$this->EBusinessID,
			'RequestType' => '1008',
			'RequestData' => urlencode($requestData) ,
			'DataType' => '2',
		);
		$datas['DataSign'] = self::encrypt($requestData, $this->AppKey);
		$result = Util::HttpPost($this->ReqURL, $datas);	
		
		return $result;
	}	
	
}



?>