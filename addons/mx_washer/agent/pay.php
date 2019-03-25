<?php
	date_default_timezone_set('PRC'); 	
	function __autoload($classname){
		require_once $classname .'.class.php';
	}
	$ac = new Actions();

	
	if(isset($_GET['id']) && !empty($_GET['id'])){
		//处理接收参数
		$par_array = explode("%",base64_decode(str_replace(" ","+",$_GET['id'])));
		$device_id = $par_array[0];
		$openid = $par_array[1];
		$aid = $par_array[2];
		$uniacid = $par_array[3];
		
		// file_put_contents("11.txt",$device_id.'--'.$openid.'--'.$aid.'--'.$uniacid);
		
		//20--oCGoJ1ZCkiRORs--8dF4lvVwfGLu8--14
		
		
		//查询代理商配置信息
		$data = [
			'table' => 'config',
			'where' => 'aid = '.(int)$aid.' and uniacid ='.(int)$uniacid.'',
		];
		$cfg = $ac->Find($data);
		
	
		
		

		//根据aid,uniacid,device_id 查询设备信息	
		$dev_data = [
			'table' => 'device',
			'where' => 'aid = '.$aid.' and uniacid ='.(int)$uniacid.' and id = '.(int)$device_id.'',
		];
		$dev_rs = $ac->Find($dev_data);
		
		//根据openid,aid,uniacid 查询用户信息
		$user_data = [
			'table' => 'user',
			'where' => 'aid = '.$aid.' and uniacid ='.(int)$uniacid.' and openid = "'.$openid.'"',
		];
		$user_rs = $ac->Find($user_data);
		if($user_rs['isvip'] == 1){ //VIP价格
			$money = $dev_rs['vip_price'];
		}else{ //普通价格
			$money = $dev_rs['price'];
		}	
	}
	
	
	//执行处理 ----  定额
	if(isset($_POST['subs'])){
		
			//代理身份AID，最大取值2位数
		if($aid < 10){
			$aid = "0".$aid;
		}elseif($aid >= 10 and $aid < 100){
			$aid = $aid;
		}else{
			$aid = "00";
		}
		//uniacid 主公众号安装id，最大取值2位数
		if($uniacid < 10){
			$uniacid = "0".$uniacid;
		}elseif($uniacid >= 10 and $uniacid < 100){
			$uniacid = $uniacid;
		}else{
			$uniacid = "00";
		}
		
		
		
		//单价的查询
		if($user_rs['isvip'] == 1){ //VIP价格
			$dev_money = $dev_rs['vip_price'];			
		}else{ //普通价格
			$dev_money = $dev_rs['price'];
		}
				
		if($_POST['money'] < 0){
			echo "<script>alert('输入非0数字！');window.history.back();</script>";
			exit;
		}elseif(($_POST['money']*100) % ($dev_money*100) != 0){ //放大100倍比较，0.01都可以比较
			echo "<script>alert('输入单价".$dev_money."整倍数！');window.history.back();</script>";
		    exit;
		}

		//最终支付的金额,判断定额或非定额	
		if($dev_rs['isfixed'] == 1){ //定额
			if($user_rs['isvip'] == 1){ //VIP价格
				$get_money = $dev_rs['vip_price'];			
			}else{ //普通价格
				$get_money = $dev_rs['price'];
			}
		}else{ //非定额
			if($user_rs['isvip'] == 1){ //
				$get_money = $_POST['money']; //支付的金额		
			}else{ //普通价格
				$get_money = $_POST['money']; //支付的金额
			}
			
		}	
		
		//判断输入数字与余额对比
		$js_count = $user_rs['money'] - $get_money;
		if($js_count <0){
			echo "<script>alert('账户余额不足！！！');window.history.back();</script>";
			exit;
		}
		
		//执行用户财务更新 -- 定额消费
		$data3=[
				'table' => 'user',
				'where' => 'openid = "'.$openid.'" and aid='.(int)$aid.' and uniacid='.(int)$uniacid.'',
		];
		$value3 = [
				'money' => ($user_rs['money'] - $get_money),							
		];
		$rs3 =  $ac->Update($data3,$value3);
		if($rs3){	//记录财务
		
			
		
		
			$data4 = [
				'uniacid' => (int)$uniacid,
				'openid' => $openid,
				'appid' => $user_rs['appid'],
				'aid' => (int)$aid,
				'remark' => '账户余额支付'.$get_money.'元',
				'pay_type' => 5,
				'pay_money' => $get_money,
				'times' => time(),
				'device_code' => $dev_rs['device_code'],
				'out_trade_no' => "xc011".$uniacid.$aid.date("YmdHis",time()).mt_rand(999,9999),
				'status' => 1,								
			];
			$rs4 = $ac->Add("financial",$data4);
			
			if($cfg['ishttps'] == 1){
					$http = 'https';
				}else{
					$http = 'http';
			}		
			$redirect = $http."://".$_SERVER['SERVER_NAME'].'/app/index.php?i='.(int)$uniacid.'&aid='.(int)$aid.'&c=entry&do=mindex&m=mx_washer';
			if($rs4){
				//计算脉冲
				$result_pluse = ($get_money/$dev_money)*$dev_rs['package']; //计算结果脉冲数,取值范围 0-99
				if($result_pluse < 10){
					$pluse = "0".$result_pluse; //最终计算脉冲数
				}elseif($result_pluse >= 10 and $result_pluse < 100){
					$pluse = $result_pluse; //最终计算脉冲数
				}
				
				//获取系统token和appid通信
				$sysdata = [
					'table' => 'sysconfig',
					'where' => 'uniacid='.(int)$uniacid.'',
					'field' => '*',
				];
				$sys_rs = $ac->Find($sysdata);	
				$curl_data = [
					'action' => 'sendIns',
					'pluse' => $pluse,
					'device_code' => $dev_rs['device_code'],
					'token' => $sys_rs['tokens'],
					'appid' => $sys_rs['appid'],			
				];						
				$curl_url = $sys_rs['apiurl']."/paycloud/Api.php";	
				
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
					echo "<script>alert('支付成功！');window.location.href='".$redirect."';</script>";
			}else{
					echo "<script>alert('支付异常！');window.location.href='".$redirect."';</script>";
					exit;
			}
		}
		
	}

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title><?php echo $cfg['title'];?> -- 账户余额支付</title>
    <!-- Bootstrap -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		body{padding:0px;margin:0px;background:#eeeff1;font-size:14px;font-family:"微软雅黑";}
		.t2{width:99%;height:50px;line-height:50px;background:#fff;border-bottom:1px #eeeff1 solid;color:#666;font-size:14px;}
		.blure{color:#2c962a;font-weight:700;}
		.d1{width:120px;height:120px;margin:0 auto;margin-top:20px;}
		.d1 img{width:120px;height:120px;margin:0 auto;}
		.d2{width:100%;height:30px;line-height:30px;text-align:Center;font-size:14px;color:#999;}
		.d3{width:100%;height:50px;text-align:Center;color:#000;font-size:30px;font-weight:700;margin-bottom:10px;margin-top:5px;}
		.d4{width:90%;height:55px;background:#44c014;margin:0 auto;text-align:center;line-height:55px;color:#fff;font-size:18px;margin-top:30px;border-radius:5px;border:none;display:block;}
		.d5{width:100%;height:50px;text-align:center;position:absolute;bottom:0px;}
		.d5 img{width:145px;height:35px;}
		.ainput{width:200px;height:38px;border:none;border:1px #8DB6CD solid;list-style-type:none;padding:0px;margin:0px;font-size:25px;color:#000;padding-left:5px;background:#FFFAFA;margin-top:5px;}
	</style>
	<script src="jquery-3.2.1.min.js"></script>
	<script>
	 $(function(){
		$(".ainput").focus();		
	 });
	</script>
  </head>
  <body>
  <form action="" method="post" name="myform" id="myform">
   <div class="d1"><img src="icon.jpg"></div>
   <div class="d2"><?php echo $dev_rs['device_code'];?></div>
   <!-- <div class="d3">¥ 0.03 元</div> -->
   
   <?php
		if($dev_rs['isfixed'] == 1){
			echo '<div class="d3">¥ '.$money.' 元</div>';
			echo '<input type="hidden"  name="money" value="'.$money.'"   class="ainput">';
		}else{
			echo '<div class="t2" style="margin-top:20px;">&nbsp;&nbsp;输入金额：<input type="text" required name="money" value="'.$money.'"  placeholder="1.00" class="ainput"></div>';
		}
	?>
	 

   <div class="t2">&nbsp;&nbsp;订单描述：账户余额支付 - <?php echo $dev_rs['device_code'];?></div>
   <div class="t2">&nbsp;&nbsp;收款单位：<?php echo $cfg['title'];?></div>
   <div class="t2">&nbsp;&nbsp;支付方式：余额支付</div>
   <?php
		if($dev_rs['isfixed'] == 1){
			echo '<div class="t2">&nbsp;&nbsp;支付金额：<span class="blure">¥ '.$money.' 元</span></div>';
		}
   ?>
   
    <input class="d4 repay" type="submit" name="subs" value="立即支付" >

   <div class="d5"><img src="foots.png"></div>
   
   
   </form>
  </body>
</html>