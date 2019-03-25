<?php
define('IN_MOBILE', true);
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
$ob = simplexml_load_string($xml);




require '../../framework/bootstrap.inc.php';
require '../../data/config.php';


$out_trade_no = $ob->out_trade_no;
$pat = "/([a-z]{2})([\d]{3})([\d]{2})([\d]{2})/";
if(preg_match($pat,$out_trade_no,$arr)){
	$prifix = $arr[1]."_";  //表前缀
	$order_cat = $arr[2];  //获取订单类型 $order_cat   取值   010:微信扫码消费  020：充值
	$uniacid = $arr[3]; //主公众号id
	$agenid = $arr[4]; //代理商id
}


$db_fix = $config['db']['master']['tablepre'].$prifix;
$dsn = 'mysql:dbname='.$config['db']['master']['database'].';host='.$config['db']['master']['host'].'';
	try {
		$dh = new PDO($dsn, $config['db']['master']['username'],$config['db']['master']['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
	} catch (PDOException $e) {
		return  $e->getMessage();
} 
//查询支付类型
$sql_ag="select  * from ".$db_fix."agent  where uniacid= ".(int)$uniacid." and id = '".(int)$agenid."'";
$stmt=$dh->prepare($sql_ag);
$stmt->execute();
$ag_rs=$stmt->fetchAll(PDO::FETCH_ASSOC);

$ispay = $ag_rs[0]['ispay'];

if($order_cat == '010'){ //微信在线消费
	if($ispay == 1){ //服务商
		$openid = $ob->sub_openid;
		$appid = $ob->sub_appid;
		$mchid = $ob->sub_mch_id;
	}else if($ispay == 0){ //独立支付
		$openid = $ob->openid;
		$appid = $ob->appid;
		$mchid = $ob->mch_id;
	}	
	$field = "uniacid,openid,appid,mchid,pay_type,pay_money,device_code,status,aid,remark,times,out_trade_no,trans_id";
	$values = [(int)$uniacid,$openid,$appid,$mchid,2,($ob->total_fee/100),$ob->attach,1,$agenid,'微信扫码支付消费'.($ob->total_fee/100) .'元',time(),$ob->out_trade_no,$ob->transaction_id];
	//file_put_contents("7.txt",$values);
	$arr_field = explode(",",trim($field,","));
	$z_str = "";
	for($i=0;$i<count($arr_field);$i++){
		$z_str .= "?,";
	}
	$query="insert into ".$db_fix."financial(".$field.") values(".trim($z_str,",").")";
    $stmt=$dh->prepare($query); 
    $stmt->execute($values);	
	$financial_result = $dh->lastInsertId();			
	if($financial_result){ //财务记录成功
		//file_put_contents("1.txt",111);
		/*设备指令开始*/
		//1、根据 uniacid 查询系统秘钥+APPID
		$sql="select  * from ".$db_fix."sysconfig  where uniacid= ".(int)$uniacid."";
		$stmt=$dh->prepare($sql);
		$stmt->execute();
		$sysconfig=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$api_token =  $sysconfig[0]['tokens'];  //token
		$api_appid =  $sysconfig[0]['appid'];  //appid
		//file_put_contents("2.txt",$api_token.'--'.$api_appid);
		//2、根据设备编号获取设备套餐数量
		$sql2="select  * from ".$db_fix."device  where uniacid= ".(int)$uniacid." and device_code ='".$ob->attach."' and aid= '".$agenid."'";
		$stmt=$dh->prepare($sql2);
		$stmt->execute();
		$devieinfo=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$dev_price = $devieinfo[0]['price']; //普通单价
		$dev_vip_price = $devieinfo[0]['vip_price']; //VIP单价
		$dev_packe = $devieinfo[0]['package']; //套餐数
		$dev_name = $devieinfo[0]['device_code']; //设备名称
      	$dev_folder = $devieinfo[0]['folder']; //设备接口文件夹
		
		//3、根据openid，aid,uniacid,获取用户信息判断用户身份
		$sql3="select  * from ".$db_fix."user  where uniacid= ".(int)$uniacid." and openid ='".$openid."' and aid= '".$agenid."'";
		$stmt=$dh->prepare($sql3);
		$stmt->execute();
		$userinfo=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$user_type = $userinfo[0]['isvip']; //用户身份是否VIP
		
		//设置不同用户身份不同价格
		if($user_type  == 1){
			$j_price = $dev_vip_price;
		}else{
			$j_price = $dev_price;
		}
		
		//file_put_contents("3.txt",($ob->total_fee/100).'--'.$j_price);
		//3、根据输入的钱数(元)换算多少脉冲发送
		$result_pluse = (($ob->total_fee/100)/$j_price)*$dev_packe; //计算结果脉冲数,取值范围 0-99
		//file_put_contents("3.txt",($ob->total_fee/100).'--'.$dev_price.'--'.$dev_packe);
		if($result_pluse < 10){
			$pluse = "000".$result_pluse; //最终计算脉冲数
		}elseif($result_pluse >= 10 and $result_pluse < 100){
			$pluse = "00".$result_pluse; //最终计算脉冲数
		}elseif($result_pluse >= 100 and $result_pluse < 1000){
			$pluse = $result_pluse; //最终计算脉冲数
		}
		//file_put_contents("4.txt",$pluse);
		//4、响应远程发送指令
		//远程存库
		$curl_data = [
			'action' => 'sendIns',
			'pluse' => $pluse,
			'device_code' => $dev_name,
			'token' => $api_token,
			'appid' => $api_appid,			
		];
		$curl_url = $sysconfig[0]['apiurl']."/".$dev_folder."/Api.php";
		
		 function Post($url, $post = null){
			$context = array();
			if (is_array($post)) {
			  ksort($post);		 
			  $context['http'] = array (
				'timeout'=>60,
				'method' => 'POST',
				'content' => http_build_query($post, '', '&'),
			   );
			}		 
			return file_get_contents($url, false, stream_context_create($context));
		}		 
		Post($curl_url, $curl_data);		

		/*设备指令结束*/
	}else{ //财务记录失败
		
	} 
}elseif($order_cat == '020'){ //在线账户充值
	if($ispay == 1){ //服务商
		$openid = $ob->sub_openid;
		$appid = $ob->sub_appid;
		$mchid = $ob->sub_mch_id;
	}else if($ispay == 0){ //独立支付
		$openid = $ob->openid;
		$appid = $ob->appid;
		$mchid = $ob->mch_id;
	}
	$field = "uniacid,openid,appid,mchid,pay_type,pay_money,device_code,status,aid,remark,times,out_trade_no,trans_id";
	$values = [(int)$uniacid,$openid,$appid,$mchid,6,($ob->total_fee/100),$ob->attach,1,$agenid,'账户余额充值'.($ob->total_fee/100) .'元',time(),$ob->out_trade_no,$ob->transaction_id];
	
	$arr_field = explode(",",trim($field,","));
	$z_str = "";
	for($i=0;$i<count($arr_field);$i++){
		$z_str .= "?,";
	}
	$query="insert into ".$db_fix."financial(".$field.") values(".trim($z_str,",").")";
	
    $stmt=$dh->prepare($query); 
    $stmt->execute($values);	
	$financial_result = $dh->lastInsertId();			
	if($financial_result){ //财务记录成功，执行账户余额增加
			$sql="select *  from ".$db_fix."user where appid='".$appid."' and openid='".$openid."'";
			$stmt=$dh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$pre_money = $result[0]['money']; //原始金额
			$ths_money = $ob->total_fee/100; //本次金额			
			
			$new_money = $ths_money + $pre_money;	//总金额
			//file_put_contents("2.txt",$new_money);
			$sql="update ".$db_fix."user  set money=? where appid='".$appid ."' and openid='".$openid ."'";
			//file_put_contents("2.txt",$sql);
			$stmt = $dh->prepare($sql);
			$rs=$stmt->execute(array($new_money));
			if($rs){ //入款成功
				
			}else{ //入款失败
				
			}
			
		
	}else{ //财务记录失败
		
	} 
}elseif($order_cat == '021'){ //升级VIP
	if($ispay == 1){ //服务商
		$openid = $ob->sub_openid;
		$appid = $ob->sub_appid;
		$mchid = $ob->sub_mch_id;
	}else if($ispay == 0){ //独立支付
		$openid = $ob->openid;
		$appid = $ob->appid;
		$mchid = $ob->mch_id;
	}
	$field = "uniacid,openid,appid,mchid,pay_type,pay_money,device_code,status,aid,remark,times,out_trade_no,trans_id";
	$values = [(int)$uniacid,$openid,$appid,$mchid,6,($ob->total_fee/100),$ob->attach,1,$agenid,'升级VIP账户充值'.($ob->total_fee/100) .'元',time(),$ob->out_trade_no,$ob->transaction_id];
	
	$arr_field = explode(",",trim($field,","));
	$z_str = "";
	for($i=0;$i<count($arr_field);$i++){
		$z_str .= "?,";
	}
	$query="insert into ".$db_fix."financial(".$field.") values(".trim($z_str,",").")";
    $stmt=$dh->prepare($query); 
    $stmt->execute($values);	
	$financial_result = $dh->lastInsertId();			
	if($financial_result){ //财务记录成功，执行账户余额增加,修改身份VIP
			$sql="select *  from ".$db_fix."user where appid='".$appid."' and openid='".$openid."'";
			$stmt=$dh->prepare($sql);
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$pre_money = $result[0]['money']; //原始金额
			$ths_money = $ob->total_fee/100; //入款金额		
			
			$new_money = $ths_money + $pre_money; //总金额
			$isvip = 1;
			$sql="update ".$db_fix."user  set money=?,isvip=? where appid='".$appid ."' and openid='".$openid ."'";
			$stmt = $dh->prepare($sql);
			$rs=$stmt->execute(array($new_money,$isvip));
			if($rs){ //入款-升VIP 成功
				
				
			}else{ //入款-升VIP  失败
				
			}		
		
	}else{ //财务记录失败
		
	} 
	
}

echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';