<?php
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
require '../../data/config.php';


//获取主域名
$url_array = explode("/",$_W['siteroot']); 
$url = $url_array[0]."//".$url_array[2]."/";

//处理接收参数
$par_array = explode("%",base64_decode(str_replace(" ","+",$_GPC['id'])));
$device = $par_array[0];  //设备名
$moudle = $par_array[1]; //模块
$action = $par_array[2]; //方法
$prefix =  $par_array[3]; //数据表前缀
$money =  $par_array[4]; //商品单价



$db_fix = $config['db']['master']['tablepre'].$prefix;
$dsn = 'mysql:dbname='.$config['db']['master']['database'].';host='.$config['db']['master']['host'].'';
	try {
		$dh = new PDO($dsn, $config['db']['master']['username'],$config['db']['master']['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));		
	} catch (PDOException $e) {
		return  $e->getMessage();
} 

//查询设备信息， 
$sql="select *  from ".$db_fix."device where device_code = '".$device."'";
$stmt=$dh->prepare($sql);
$stmt->execute();
$result=$stmt->fetchAll(PDO::FETCH_ASSOC);

//查询对应代理商配置信息
$sql2="select *  from ".$db_fix."config where aid = '".$result[0]['aid']."'";
$stmt=$dh->prepare($sql2);
$stmt->execute();
$agent_config=$stmt->fetchAll(PDO::FETCH_ASSOC);

if($agent_config[0]['ispay'] == 1){
	$sql3="select *  from ".$db_fix."sysconfig where uniacid = '".$result[0]['uniacid']."'";
	$stmt=$dh->prepare($sql3);
	$stmt->execute();
	$sys_config=$stmt->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($sys_config);
	//
	//服务商信息
	$par_appid = $sys_config[0]['appid'];
	$par_mchid = $sys_config[0]['mchid'];
	$par_appsec = $sys_config[0]['appsecrect'];
	$par_wxkey = $sys_config[0]['wxkey'];

}else{
	//服务商信息
	$par_appid = "";
	$par_mchid = "";
	$par_appsec = "";
	$par_wxkey = "";
}


 
//代理身份AID，最大取值2位数
if($result[0]['aid'] < 10){
	$aid = "0".$result[0]['aid'];
}elseif($result[0]['aid'] >= 10 and $result[0]['aid'] < 100){
	$aid = $result[0]['aid'];
}else{
	$aid = "00";
}
//uniacid 主公众号安装id，最大取值2位数
if($result[0]['uniacid'] < 10){
	$uniacid = "0".$result[0]['uniacid'];
}elseif($result[0]['uniacid'] >= 10 and $result[0]['uniacid'] < 100){
	$uniacid = $result[0]['uniacid'];
}else{
	$uniacid = "00";
}


?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>微信在线支付</title>
    <!-- Bootstrap -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		body{padding:0px;margin:0px;background:#eeeff1;font-size:14px;font-family:"微软雅黑";}
		.t2{width:99%;height:60px;line-height:60px;background:#fff;border-bottom:1px #eeeff1 solid;color:#666;font-size:14px;}
		.blure{color:#2c962a;font-weight:700;}
		.d1{width:120px;height:120px;margin:0 auto;margin-top:20px;}
		.d1 img{width:120px;height:120px;margin:0 auto;}
		.d2{width:100%;height:30px;line-height:30px;text-align:Center;font-size:14px;color:#999;}
		.d3{width:100%;height:50px;text-align:Center;color:#000;font-size:30px;font-weight:700;margin-bottom:10px;margin-top:5px;}
		.d4{width:90%;height:55px;background:#44c014;margin:0 auto;text-align:center;line-height:55px;color:#fff;font-size:18px;margin-top:30px;border-radius:5px;}
		.d5{width:100%;height:50px;text-align:center;position:absolute;bottom:0px;}
		.d5 img{width:145px;height:35px;}
		.ainput{width:200px;height:45px;border:none;border-left:1px #eeeff1 solid;list-style-type:none;padding:0px;margin:0px;font-size:25px;color:#000;padding-left:5px;background:#eee;}
	</style>
	<script src="jquery-3.2.1.min.js"></script>
	<script>
	 $(function(){
		$(".ainput").focus();
		$(".repay").click(function(){
			var money = $(".ainput").val();
			if(money < 0 || money ==""){
				alert("填写有效金额！");
				return  false;
			}else{		
				var price = <?php echo $money;?>;
				var mod_value = (money*100)%(price*100); //取模
				if(!mod_value == 0){
					alert('请输入'+ price +'倍数有效金额！');
					window.history.back();
				}else{
					$("#myform").submit();
				}
				
				
			}
			
		});	
		
	 });
	</script>
  </head>
  <body>
  <form action="jsapi.php" method="get" name="myform" id="myform">
   <div class="d1"><img src="icon.jpg"></div>
   <div class="d2"><?php echo $result[0]['device_code'];?></div>
   <!-- <div class="d3">¥ 0.03 元</div> -->
   
   <?php
		if($result[0]['isfixed'] == 1){
			echo '<div class="d3">¥ '.$money.' 元</div>';
			echo '<input type="hidden"  name="money" value="'.$money.'"   class="ainput">';
		}else{
			echo '<div class="t2" style="margin-top:20px;">&nbsp;&nbsp;输入金额：<input type="text" required name="money" value="'.$money.'"  placeholder="1.00" class="ainput"></div>';
		}
	?>
	 

   <div class="t2">&nbsp;&nbsp;订单描述：扫码支付消费 - <?php echo $result[0]['device_code'];?></div>
   <div class="t2">&nbsp;&nbsp;收款单位：<?php echo $agent_config[0]['title'];?></div>
   <!-- <div class="t2">&nbsp;&nbsp;收取金额：<span class="blure">¥ 5.0 元</span></div> -->
		
		
		<input type="hidden" value="<?php echo $result[0]['device_code'];?>" required name="device"/>
		<input type="hidden" name="url" value="<?php echo $url;?>">
		<input type="hidden" name="uniacid" value="<?php echo $uniacid;?>">   
		<input type="hidden" name="moudle" value="<?php echo $moudle;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="notice" value="<?php echo $agent_config[0]['title']."扫码消费";?>">
		
		<input type="hidden" name="prefix" value="<?php echo trim($prefix,"_");?>">
		<input type="hidden" name="aid" value="<?php echo $aid;?>">

		<input type="hidden" name="par_appid" value="<?php echo $par_appid;?>">   
		<input type="hidden" name="par_mchid" value="<?php echo $par_mchid;?>">
		<input type="hidden" name="par_appsec" value="<?php echo $par_appsec;?>">
		<input type="hidden" name="par_wxkey" value="<?php echo $par_wxkey;?>">
		<input type="hidden" name="ispay" value="<?php echo $agent_config[0]['ispay'];?>">
		
		<input type="hidden" name="appid" value="<?php echo $agent_config[0]['appid'];?>">   
		<input type="hidden" name="mchid" value="<?php echo $agent_config[0]['mchid'];?>">
		<input type="hidden" name="wxkey" value="<?php echo $agent_config[0]['wxkey'];?>">
		<input type="hidden" name="appsecrect" value="<?php echo  $agent_config[0]['appsecrect'];?>">
   
   
    <div class="d4 repay" >立即支付</div>

   <div class="d5"><img src="foots.png"></div>
   
   
   </form>
  </body>
</html>