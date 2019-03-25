<?php        
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set('PRC'); 	
	function __autoload($classname){
		require_once $classname .'.class.php';
	}
   $ac = new Actions();
		$state_srt =  $_GET['state'];
		$srt_arr= explode("_",$state_srt); // 6_3_11  agent_uniacid_device_id   代理商ID_主公众号id_设备id
		
		$agent_id = $srt_arr[0]; //代理商
		$uniac_id = $srt_arr[1]; //主公众号
		$devic_id = $srt_arr[2]; //设备id
		
		
		$data = [
			'table' => 'config',
			'where' => 'aid = '. $agent_id.' and uniacid ='.$uniac_id.'',
		];
		$cfg = $ac->Find($data);
		$appid =  $cfg['appid'];
		$appsecret =  $cfg['appsecrect'];
		
	
	//代理身份AID，最大取值2位数
	if($agent_id < 10){
		$aid = "0".$agent_id;
	}elseif($agent_id >= 10 and $agent_id < 100){
		$aid = $agent_id;
	}else{
		$aid = "00";
	}
	//uniacid 主公众号安装id，最大取值2位数
	if($uniac_id < 10){
		$uniacid = "0".$uniac_id;
	}elseif($uniac_id >= 10 and $uniac_id < 100){
		$uniacid = $uniac_id;
	}else{
		$uniacid = "00";
	}
      
	/////
	if(!isset($_GET['code'])){
		//当前公众号信息
		$redirect_uri = urlencode('http://'.$_SERVER['SERVER_NAME'].'/addons/mx_charging/agent/qrcode.php');
        $author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=".$state_srt."#wechat_redirect";
		header("location:$author_url");
		exit;
	}else{	
		$code = $_GET['code'];				
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
			$token_data = https_request($token_url);
			$Token_arr =  json_decode($token_data,true); //转数组
			
			//逻辑代码开始
			//1、查询设备信息			
				$data = [
					'table' => 'device',
					'where' => 'id = '.$devic_id.' and aid='.$agent_id.' and uniacid='.$uniac_id.'',
					'field' => '*',
				];
				$device_rs = $ac->Find($data);				
			//2、查询设备系统配置api通信信息，判断设备是否在线
				$sys_data = [
					'table' => 'sysconfig',
					'where' => 'uniacid='.$uniac_id.'',
					'field' => '*',
				];
				$sys_rs = $ac->Find($sys_data);
				$curl_data = [
					'action' => 'checkSta',
					'fid' => $device_rs['fid'],
					'token' => $sys_rs['tokens'],
					'appid' => $sys_rs['appid'],			
				];
				$curl_url = $sys_rs['apiurl']."/paycloud/Api.php";
				$sta_json = https_request($curl_url,$curl_data);
				$star_arr = json_decode($sta_json,true);
      			if($sys_rs['ishttps'] == 1){
                	$http = "https";
                }else{
                	$http = "http";
                }
				$redirect =  $http."://".$_SERVER['SERVER_NAME'].'/app/index.php?i='.(int)$uniacid.'&aid='.(int)$aid.'&c=entry&do=mindex&m=mx_charging';
				if($star_arr[0] =='SUCCESS'){ 
					if($star_arr[1] == '0000'){ //设备离线
						echo "<script>alert('抱歉！当前设备状态离线！');window.location.href='".$redirect."';</script>";
						exit;
					}					
				}else{ //状态查询失败
					echo "<script>alert('抱歉！当前设备网络状态异常！');window.location.href='".$redirect."';</script>";
					exit;
				}
      
				//该部分为临时使用模块， 开始
				/*$check_data = [
					//'table' => 'rhinfo_zyxq_member',
					'where' => 'openid = "'.$Token_arr['openid'].'"',
					'field' => 'id',
				];
				$check_rs = $ac->Find2($check_data,'ims_rhinfo_zyxq_member');
				if(!$check_rs){
					header('Location: error.html');
					exit;
				}*/
				//代码结束
      
			//3、查询用户账户信息
				$data2 = [
					'table' => 'user',
					'where' => 'openid = "'.$Token_arr['openid'].'" and aid='.$agent_id.' and uniacid='.$uniac_id.'',
					'field' => '*',
				];				
				$user_rs = $ac->Find($data2);
				$user_money = $user_rs ['money']; //账户余额
				$user_vip = $user_rs ['isvip'];  //是否VIP
			
				
				if($user_vip == 1){ //会员身份判断 ： VIP用户
					if($user_money >= $device_rs['vip_price']){ //VIP 账户余额足够，扣除余额结算			

						$arr =[
							$devic_id, //设备id
							$Token_arr['openid'], //openid
							$agent_id, //aid
							$uniac_id,  //uniacid						
						];
						$str = implode("%",$arr);
						if($cfg['ishttps'] == 1){
								$http = 'https';
							}else{
								$http = 'http';
						}
						$repay_url = $http."://".$_SERVER['HTTP_HOST']."/addons/mx_charging/agent/pay.php?id=".base64_encode($str)."";
						header('Location: '.$repay_url.'');
						
					}else{ //VIP 账户余额不足--扫码
						$arr =[
							$device_rs['device_code'], //设备名称
							'mx_charging', //当前模块
							'mindex', //支付成功跳转方法名
							'xc_',  //							
							$device_rs['vip_price'],						
						];
						$str = implode("%",$arr);
						if($cfg['ishttps'] == 1){
									$http = 'https';
								}else{
									$http = 'http';
						}
						$repay_url = $http."://".$_SERVER['HTTP_HOST']."/payment/jsapi/pay.php?id=".base64_encode($str)."";
						header('Location: '.$repay_url.'');
					}
				}else{ //会员身份判断 --- 普通用户
					if($user_money >= $device_rs['price']){ //普通 --  账户余额足够，扣除余额结算
						
						$arr =[
							$devic_id, //设备id
							$Token_arr['openid'], //openid
							$agent_id, //aid
							$uniac_id,  //uniacid						
						];						
						$str = implode("%",$arr);
						if($cfg['ishttps'] == 1){
								$http = 'https';
							}else{
								$http = 'http';
						}
						$repay_url = $http."://".$_SERVER['HTTP_HOST']."/addons/mx_charging/agent/pay.php?id=".base64_encode($str)."";
						header('Location: '.$repay_url.'');

						
						
					}else{ //普通用户 -- 余额不足，扫码支付
						$arr =[
							$device_rs['device_code'],
							'mx_charging', //当前模块
							'mindex', //支付成功跳转方法名
							'xc_',  //
							$device_rs['price'],						
						];
                      if($cfg['ishttps'] == 1){
								$http = 'https';
							}else{
								$http = 'http';
						}
						$str = implode("%",$arr);
                      
						$repay_url = $http."://".$_SERVER['HTTP_HOST']."/payment/jsapi/pay.php?id=".base64_encode($str)."";
						header('Location: '.$repay_url.'');
					}
					
				}
			
			//逻辑代码结束
		}			
		
		

 
    
function https_request($url,$data = null){
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
