<?php 
/*
1、实例化wxpay,设置conf参数
2、调用方法，传入指定格式；
3、具体调用时需要哪些参数参考微信支付api传入对于
 
*/
class Wxpay{  
	function __construct($conf=array()){ 
		$this->conf=$conf;  
	} 

	public $conf=array(//小程序及支付账号配置， 
		"wxpay_mchid"=>" ",
		"wxpay_key"=>" ",
		"certpem"=>" ",
		"keypem"=>" ",
	);
	public $xml=""; 
	public function orderNumber($prefix=""){
		//产生随机订单号，$prefix订单前缀
		return strtoupper($prefix).date("YmdHis",time()).rand(100,999);
	}
	public function nonce_str($length){
		$str="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$tmp="";
		for($i=0;$i<$length;$i++){
			$tmp.=$str[mt_rand(0,52)];
		}  
		return $tmp;
	}
	public function saveCert(){
		$path=$this->certpath(); 
		$pfile=fopen($path.'apiclient_key.pem','w+'); 
 	 	$res=fwrite($pfile,$this->conf['keypem']);
 	 	fclose($pfile);
 	 	$pfile=fopen($path.'apiclient_cert.pem','w+');
 	 	fwrite($pfile,$this->conf['certpem']);
 	 	fclose($pfile);
 	 	return $res;
	}
	function certpath(){
		$path=ZSK_CERTPATH; 
		$server=md5($_SEVER['HTTP_HOST']);
		$mchid=$this->conf['wxpay_mchid'];
		if(floatval($mchid) < 1){
			$mchid=$this->conf['wxpay']['mchid'];
		}
		if(!is_dir($path)){
            mkdir($path);
        }
        if(!is_dir($path.$server)){
            mkdir($path.$server);
        }
        if(!is_dir($path.$server."/".$mchid)){
            mkdir($path.$server."/".$mchid);
        }
        return $path.$server."/".$mchid."/";
	}
	public function orderquery($data){//查询订单状态
		$url="https://api.mch.weixin.qq.com/pay/orderquery";
		$data['appid']=$this->conf['appid'];
		$data['nonce_str']=$this->nonce_str(20); 
		$data['mch_id']=$this->conf['wxpay_mchid'];
		$xml=$this->signXml($data);
		$res=$this->postXmlCurl($xml,$url,false); 
		return $res;
	}
	public function payBank($data){//企业转账到银行
		$url="https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank";
		$data['nonce_str']=$this->nonce_str(25); 
		$data['mch_id']=$this->conf['wxpay_mchid'];
		$xml=$this->signXml($data);
		$res=$this->postXmlCurl($xml,$url,true); 
		return $res;
	}
	//查询企业转账到银行
	public function queryBank($data){
		$url="https://api.mch.weixin.qq.com/mmpaysptrans/query_bank";
		$data['nonce_str']=$this->nonce_str(25); 
		$data['mch_id']=$this->conf['wxpay_mchid'];
		$xml=$this->signXml($data);
		$res=$this->postXmlCurl($xml,$url,true); 
		return $res;
	}
	public function payYue($data){
		$url="https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
		$data['nonce_str']=$this->nonce_str(20);  
		$xml=$this->signXml($data); 
		$res=$this->postXmlCurl($xml,$url,true); 
		return $res;
	} 
	public function pubkey($rewrite=false){
		$path=$this->certpath();
		if($rewrite){
			$url="https://fraud.mch.weixin.qq.com/risk/getpublickey";
			$data['nonce_str']=$this->nonce_str(20); 
			$data['mch_id']=$this->conf['wxpay_mchid'];
			$data['sign_type']="MD5"; 
			$xml=$this->signXml($data);  
			$resp=$this->postXmlCurl($xml,$url,true); 
			if(strlen($resp['pub_key'])>10){
				$pfile=fopen($path.'rsa_public_key.pem','w+');
		 	 	fwrite($pfile,$resp['pub_key']);
		 	 	fclose($pfile);
			} 
			//通过shell命令将公钥格式PKCS#1 转 PKCS#8，并写入新文件，下次直接读取
	 	 	$sh="openssl rsa -RSAPublicKey_in -in ".$this->certpath()."rsa_public_key.pem -pubout -out ".$this->certpath()."public_key.pem";  
	 	 	 
	 	 	shell_exec($sh); 

		}
		return $this->certpath()."public_key.pem";;
	}

	public function rsa_encrypt($str){
		$path =$this->certpath().'/public_key.pem';
		$pu_key =openssl_pkey_get_public(file_get_contents($path));
		$encryptedBlock = '';
		$encrypted = '';
		// 用标准的RSA加密库对敏感信息进行加密，选择RSA_PKCS1_OAEP_PADDING填充模式
		// （eg：Java的填充方式要选 " RSA/ECB/OAEPWITHSHA-1ANDMGF1PADDING"）
		// 得到进行rsa加密并转base64之后的密文
		openssl_public_encrypt($str,$encryptedBlock,$pu_key,OPENSSL_PKCS1_OAEP_PADDING);
		$str_base64=base64_encode($encrypted.$encryptedBlock);
		return $str_base64;
	}

	public function refund($data){//退款
		$url="https://api.mch.weixin.qq.com/secapi/pay/refund";
		$data['appid']=$this->conf['appid'];
		$data['nonce_str']=$this->nonce_str(20); 
		$data['mch_id']=$this->conf['wxpay_mchid'];
		$xml=$this->signXml($data); 
		$res=$this->postXmlCurl($xml,$url,true); 
		return $res;
	}
	public function unifiedorder($data){//统一下单接口
		$url="https://api.mch.weixin.qq.com/pay/unifiedorder";
		$data['appid']=$this->conf['appid'];
		$data['nonce_str']=$this->nonce_str(20); 
		$data['mch_id']=$this->conf['wxpay_mchid'];
 
		$xml=$this->signXml($data); 
		$res=$this->postXmlCurl($xml,$url,false);   
		return $res;
	}
	public function signXml($data){//传入键值对数组，获取带sign的xml字符串
		global $_W;
		
		ksort($data); //根据键名进行asc排序

		$xml="<xml>";
		$sign="";
		$tempStr="";//加密临时字符串
		$temp=true;
		foreach ($data as $key => $val) {//凭借xml，以及算法字符串
			$tempStr.="&".$key."=".$val;
			$xml.='<'.$key.'>'.$val.'</'.$key.'>';
		} 
		
		$tempStr=substr($tempStr, 1,strlen($tempStr)-1);
		$tempStr=$tempStr."&key=".$this->conf['wxpay_key']; 
		 
		$sign=strtoupper(MD5($tempStr)); 
		$xml.="<sign>".$sign."</sign>"; 
		$xml.="</xml>";  
		$this->xml=$xml;
		return $xml;
	}
	public function postXmlCurl($xml, $url, $useCert = false, $second = 30)
	{		 
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
		//如果有配置代理这里就设置代理
		 
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	 
		if($useCert == true){ 
			$path=$this->certpath();
			if(!file_exists($path."apiclient_cert.pem")||strlen(file_get_contents($path."apiclient_cert.pem"))<1000){
				return array('errcode'=>400,"errmsg"=>"证书不正确");
			}
			if(!file_exists($path."apiclient_key.pem")||strlen(file_get_contents($path."apiclient_key.pem"))<1000){
				return array('errcode'=>400,"errmsg"=>"证书不正确");
			}
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件 
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM'); 
			curl_setopt($ch,CURLOPT_SSLCERT,$path."apiclient_cert.pem");

			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, $path."apiclient_key.pem");
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl 
		$data = curl_exec($ch);   
		 
		//返回结果  
		curl_close($ch);  
		if($data){ 
			$res=(array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
			 
			return $res;
		} else { 
			$error = curl_errno($ch);
			return array('errcode'=>curl_errno($ch),"errmsg"=>curl_error($ch));
		}
	}
}