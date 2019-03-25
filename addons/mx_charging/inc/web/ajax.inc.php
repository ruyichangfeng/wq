<?php
global $_W,$_GPC;
//财务图形报表
if(isset($_GPC['action']) && $_GPC['action'] == 'get_report'){
	//日期下表
	for($i = 7; $i > 0; $i--){
		$date_list[]  = date('m-d', strtotime('-'.$i.' day'));
	}
	//循环 年 -  月 - 日
	for($i = 7; $i > 0; $i--){		
		$date_strtotime_y[] =  date('Y-m-d', strtotime('-'.($i+1).' day'))."|".date('Y-m-d', strtotime('-'.$i.' day'));  //年月日
	}
	//求和
	for($i=0;$i<count($date_strtotime_y);$i++){
		$date_arr = explode("|",$date_strtotime_y[$i]);
		//开始时间时间戳  --- 结束时间时间戳
		$money_total[] = pdo_fetchcolumn("SELECT SUM(pay_money) FROM ".tablename('xc_financial')." where uniacid=".$_W['uniacid']." and  status=1 and   times  between '".strtotime($date_arr[0])."' and '".strtotime($date_arr[1])."'");
	}
	for($i=0;$i<count($money_total);$i++){
	if($money_total[$i] == Null){
			$feel[] = 0.00;
		}else{
			$feel[] = $money_total[$i];
		}
	}
	$time = "日消费总额";
	$arr = [
		$date_list,
		$feel,
		$time
	];	
	echo json_encode($arr);		
}
//AJAX定时更新状态
if(isset($_GPC['action']) && $_GPC['action'] == 'fresh'){
	//查询所有设备fid	
	$dlist = pdo_getall('xc_device', array('uniacid' => $_W['uniacid']),array('fid'));
	$fid_list = "";
    foreach($dlist as $k){
		$fid_list .=  $k['fid'].",";
	}		
	 //系统配置通信字段
	$syscfg = pdo_get('xc_sysconfig',array('uniacid'=>$_W['uniacid']));	
		//远程存库
		$curl_data = [
			'action' => 'reupdate',		
			'token' => $syscfg['tokens'],
			'appid' => $syscfg['appid'],
			'fidlist' => trim($fid_list,",")
		];		
		$curl_url = $syscfg['apiurl']."/paycloud/Api.php";
		$rs_json = curl_request($curl_url,$curl_data);			
		$rs_arr = json_decode($rs_json,true);		
		if($rs_arr[0] == 'SUCCESS'){
			$status_arr = explode(",",$rs_arr[1]); //远程返回状态数组
			$fid_arr = explode(",",trim($fid_list,","));
			//循环更新状态，根据上面的fid的顺序					
			for($i=0;$i<count($fid_arr);$i++){			
				$data['status'] =$status_arr[$i];
				$where = [
					"fid" => $fid_arr[$i],
					'uniacid' => $_W['uniacid']
				];		
				pdo_update('xc_device',$data,$where);
			}			
			echo 1;
			//end			
		}else{
			echo 0;
		}
}
//检车设备状态是否在线
if(isset($_POST['action']) && $_GPC['action'] == 'checkSta'){		
	$fid = $_POST['fid'];
    $uniacid = $_POST['uniacid'];
	//API远程 ---- 状态查询-----
	//系统配置通信字段	
	$sys_data = [		
		'uniacid' => $_W['uniacid']
	 ];
	$syscfg = pdo_get('xc_sysconfig',$sys_data);
	
	//远程
	$curl_data = [
		'action' => 'checkSta',		
		'token' => $syscfg['tokens'],
		'appid' => $syscfg['appid'],
		'fid' => $fid
	];		
	$curl_url = $syscfg['apiurl']."/paycloud/Api.php";
	$rs_json = curl_request($curl_url,$curl_data);
	$rs_arr = json_decode($rs_json,true);		
	if($rs_arr[0] == 'SUCCESS'){
		if($rs_arr[1] == '0001'){ //设备在线
			echo 1;
		}elseif($rs_arr[1] == '0000'){ //设备离线
			echo 0;
		}		
	}else{
		echo 2;  //新设备没有入网
	} 				
	//API远程 -- 状态 end		
}



//CURL
 function curl_request($url,$data = null){			
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

