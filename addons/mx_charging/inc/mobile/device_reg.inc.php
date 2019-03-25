<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
define("APPID",$cfg['appid']);
define("AID",$_GPC['aid']);



if($op == 'index') {
	$appid =  $cfg['appid'];	
	$device_id = $_GPC['device_id'];

	//区域消息
	$arealist = "select *  from ".tablename('xc_area')." where uniacid=".$_W['uniacid']." and aid=".$cfg['aid']." order by id desc";
	$list = pdo_fetchall($arealist);
	if(checksubmit("sub")) {
		
		$device_code = $_GPC['device_code'];
		$price = $_GPC['price'];
		$vip_price = $_GPC['vip_price'];
		$package = $_GPC['package'];
		$area_id = $_GPC['area_id'];
		$isfixed = $_GPC['isfixed'];		
		
		
		//检查设备名长度
		if(strlen($device_code) == 10){
			$pat="/^C[A-Z0-9]{9}/";
		    if(!preg_match($pat,$device_code,$arr)){
		      message("设备识别码格式异常01！",'refresh','error');  
		    }
		}else{
			message("设备设别码格式异常02！",'refresh','error');
			exit;
		}
		//系统配置通信字段
		$syscfg = pdo_get('xc_sysconfig',array('uniacid'=>$_W['uniacid']));		
		//远程存库
		$curl_data = [
			'action' => 'registered',
			'device_code' => $device_code,			
			'token' => $syscfg['tokens'],
			'appid' => $syscfg['appid'],			
		];
		$curl_url = $syscfg['apiurl']."/paycloud/Api.php";
		$rs_json = curl_request($curl_url,$curl_data);
		$rs_arr = json_decode($rs_json,true);
		if($rs_arr[0] == 'SUCCESS'){
			//Start
			$data = [
				'aid' => $cfg['aid'],
				'uniacid'=> $_W['uniacid'],					
				'device_code' => $device_code,
				'price' => $price,
				'vip_price' => $vip_price,
				'package' => $package,				
				'area_id' => $area_id,	
				'reg_date' => time(),
				'fid' => $rs_arr[1],
				'isfixed' => $isfixed,
				'status' => 0	
			];
			$result = pdo_insert('xc_device',$data);
			if($result){
				message("设备入网成功!",$this->createMobileurl('device_list',array('aid'=>$cfg['aid'])),'success');
			}else{ 
				message("设备入网失败!",'refresh','error');	
			}
			//End
		}elseif($rs_arr[0] == 'ERROR'){			
			switch($rs_arr[1]){
				case 1001:
					message("Appid或Tken异常!",'refresh','error');	
				break;
				case 2001:
					message("设备编号格式异常!",'refresh','error');	
				break;
				case 2002:
					message("设备编号长度异常!",'refresh','error');	
				break;
				case 2003:
					message("设备编号已存在!",'refresh','error');	
				break;	
				case 2004:
					message("设备出库异常!",'refresh','error');	
				break;				
				case "ERROR":
					message("设备远程联网失败!",'refresh','error');
				break;
			}		
		}
		
		
		 
		}
	}

include $this->template('device_reg');
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