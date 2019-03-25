<?php
date_default_timezone_set('PRC'); 
function __autoload($classname){
	require_once $classname . '.class.php';
}
$ac = new Actions();
//检测设备重复
 if(isset($_POST['ac']) &&  $_POST['ac'] == 'check_device'){
	 $device_name = $_POST['device_name'];
	 $data = [
		'table' => 'device',
		'where' => 'device_code = "'.$device_name.'"',
		'field' => 'id',
	];
	$result = $ac->Find($data);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }
//读取分页设备数据 --  设备
if(isset($_POST['ac']) &&  $_POST['ac'] == 'fpage'){
	$page = $_POST['p'];
	$where_str = $_POST['where_str'];
	$psize =  $_POST['psize'];
	$limit = ($page-1) * $psize;
	$aid =$_POST['aid'];
	$uniacid = $_POST['uniacid'];
	$data = [
		'table' => "device,ims_xc_area",
		'field' => 'ims_xc_device.id as  did,device_code,folder,tid,price,isfixed,vip_price,fid,package,area_id,status,reg_date,ims_xc_area.id,area_name',
		//'where' => 'ims_xc_device.area_id=ims_xc_area.id'.$where_str.'',
		'where' => 'ims_xc_device.area_id=ims_xc_area.id and  ims_xc_device.aid='.$aid.' and ims_xc_device.uniacid='.$uniacid.''.$where_str.'',
		'limit' => ''.$limit.','.$psize.'',
		'order' => "ims_xc_device.id desc"	
	];
	$list = $ac->Select($data);
	
		//读取设备分类
				foreach($list as $k=>$v){
					$type_data = [
						'table' => 'types',
						'where' => 'id = '.$v['tid'].'',
					];
					$type_rs = $ac->Find($type_data);		
					$list[$k]['tname'] = $type_rs['tname'];
				}
	
	
	
	//API远程 ---- 更新状态数据-----
	$fid_list = "";
	foreach($list as $k){
		$fid_list .= $k['fid'].",";					
	}
				 //系统配置通信字段
	$sys_data = [
		'table' => 'sysconfig',
		'where' => 'uniacid = '.$uniacid.'',
	];
	$syscfg = $ac->Find($sys_data);			   
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
			$data=[
				'table' => 'device',
				'where' => 'fid = '.$fid_arr[$i].'',
			];
			$value = [
				'status' => $status_arr[$i],						
			];
		$ac->Update($data,$value);
		}	
	}				
	//API远程 -- 更新 end		
	$str="";
	if($list){
		foreach($list as $k){
		$str .= '<tr>';	
		$str .= '<td  align="center">'.$k['did'].'</td>';
		if($k['isfixed'] == 1){			
			$str .= '<td  align="center"><span style="color:green;font-size:12px;">'.$k['device_code'].'</span></td>';
		}else{
			$str .= '<td  align="center">'.$k['device_code'].'</td>';
		}	
	    $str .= '<td  align="center">'.$k['tname'].'</td>';	
		$str .= '<td  align="center">'.$k['area_name'].'</td>';
		if($k['folder'] == 'paycloud'){
			$str .= '<td  align="center">'.$k['price'].' | <span style="color:red;">'.$k['vip_price'].'</span> /'.$k['package'].'</td>';
		}else{
			$str .= '<td  align="center"></td>';
		}
		
		if($k['status'] == 0){
			$str .= '<td  align="center"><span style="color:#999;">离线</span></td>';
		}else{
			$str .= '<td  align="center"><span style="color:green;">在线</span></td>';
		}		
		$str .= '<td  align="center">'.date("Y-m-d H:i:s",$k['reg_date']).'</td>';
		$str .= '<td  style="text-align:center;">';
		
		$str .= '<a href="#" alt="'.$k['fid'].'-'.$k['did'].'"  type="button" class="btn btn-default checksend" >发包测试</a>&nbsp;';
		$str .= '<a href="#" alt="'.$k['fid'].'-'.$k['did'].'"  type="button" class="btn btn-warning checksta" >状态检测</a> ';
		
		//$QrCodeUrlurl = 'http://'.$_SERVER['SERVER_NAME'].'/addons/mx_washer/agent/qrcode.php?state='.$_SESSION['Id'].'_'.$_SESSION['Uniacid'].'_'.$k['did']."";
        $QrCodeUrlurl = 'http://'.$_SERVER['SERVER_NAME'].'/addons/mx_washer/agent/qrcode.php?state='.$aid.'_'.$uniacid.'_'.$k['did']."";  
          
          
		$str .= '<a href="#" alt="'. $QrCodeUrlurl.'" title="'.$k['device_code'].'" type="button" class="btn btn-primary qrcode_btn"  data-toggle="modal" data-target="#myModal">付款码</a>&nbsp;';
		
		$str .= '<a href="device_edit.php?id='.$k['did'].'" type="button" class="btn btn-info">编辑</a>';
		$str .= '&nbsp;&nbsp;';												
		$str .= '<a href="?ac=del&id='.$k['did'].'" onclick="return confirm(\'确定删除该条记录?\')" class="btn btn-danger">删除</a>';
		$str .= '</td>';
		$str .= '</tr>';
		}
	}else{
		$str .= '<tr>';
        $str .= '<td colspan="7" style="text-align:center;">暂无记录</td>';                                                
        $str .= '</tr>';
	}	
	echo $str;
}
//读取分页财务数据 --  财务
if(isset($_POST['ac']) &&  $_POST['ac'] == 'fpagebill'){
	$page = $_POST['p'];
	$where_str = $_POST['where_str'];
	$psize =  $_POST['psize'];
	$limit = ($page-1) * $psize;	
	$aid =$_POST['aid'];
	$uniacid = $_POST['uniacid'];
	$data = [
		'table' => "financial",
		'field' => '*',
		'where' => 'aid='.$aid.' and uniacid='.$uniacid.'',
		'limit' => ''.$limit.','.$psize.'',
		'order' => "id desc"	
	];
	$list = $ac->Select($data);
	$str="";
	if($list){
		foreach($list as $k){	
		$str .= '<tr>';
        $str .= '<th scope="row"  style="padding-left:5px;">'.$k['id'].'</th>';
		$str .= '<td  style="padding-left:5px;">'.$k['device_code'].'</td>';
        $str .= '<td  style="padding-left:5px;">'.$k['pay_money'].' 元</td>';
		$str .= '<td style="padding-left:5px;">'.$k['mchid'].'</td>';
		$str .= '<td style="padding-left:5px;">';
		if($k['pay_type'] == 2){
			$str .= "微信扫码";
		}elseif($k['pay_type'] == 3){
			$str .= "支付宝扫码";
		}elseif($k['pay_type'] == 4){
			$str .= "积分支付";
		}elseif($k['pay_type'] == 5){
			$str .= "余额支付";
		}elseif($k['pay_type'] == 6){
			$str .= "<span style='color:green'>账户充值</span>";
		}											
		$str .= '</td>';
        $str .= '<td style="padding-left:5px;">'.$k['remark'].'</td>';
        $str .= '<td style="text-align:center;">'.$k['out_trade_no'].'</td>';
        $str .= '<td style="text-align:center;">'.date("Y-m-d H:i:s",$k['times']).'</td>';
        $str .= '</tr>';
		}
	}else{
		$str .= '<tr>';
        $str .= '<td colspan="7" style="text-align:center;">暂无记录</td>';                                                
        $str .= '</tr>';
	}	
	echo $str;
}
//读取分页用户列表
if(isset($_POST['ac']) &&  $_POST['ac'] == 'fpageuser'){
	$page = $_POST['p'];
	$psize =  $_POST['psize'];
	$limit = ($page-1) * $psize;	
	$aid =$_POST['aid'];
	$uniacid = $_POST['uniacid'];
	$data = [
		'table' => "user",
		'field' => '*',
		'where' => 'aid='.$aid.' and uniacid='.$uniacid.'',
		'limit' => ''.$limit.','.$psize.'',
		'order' => "id desc"	
	];
	$list = $ac->Select($data);
	$str="";
	if($list){
		foreach($list as $k){	
		$str .= '<tr>';
        $str .= '<th scope="row"  style="padding-left:5px;">'.$k['id'].'</th>';
		$str .= '<td  style="padding-left:5px;"><img src="'.$k['avatar'].'" width="30" height="30"></td>';
        $str .= '<td  style="padding-left:5px;">'.$k['nickname'].'</td>';
		$str .= '<td style="padding-left:5px;">'.$k['money'].'</td>';
		$str .= '<td style="padding-left:5px;">'.$k['integral'].'</td>';
        $str .= '<td style="padding-left:5px;">'.date("Y-m-d H:i:s",$k['regtime']).'</td>';
		$str .= '<td style="text-align:center;padding-top:3px;padding-bottom:3px;">';
		$str .= '<a href="?ac=update" type="button" class="btn btn-warning" >删除用户</a>&nbsp;&nbsp;';
		$str .= '<a href="?ac=update" type="button" class="btn btn-default" >升级管理</a>';
		$str .= '</td>';
        $str .= '</tr>';
		}
	}else{
		$str .= '<tr>';
        $str .= '<td colspan="6" style="text-align:center;">暂无记录</td>';                                                
        $str .= '</tr>';
	}	
	echo $str;
}
//财务图形报表
if(isset($_POST['ac']) && $_GPC['ac'] == 'get_report'){	
	 $uniacid = $_POST['uniacid'];
	 $aid = $_POST['aid'];
	//日期下表
	for($i = 7; $i > 0; $i--){
		$date_list[]  = date('m-d', strtotime('-'.$i.' day'));
	}
	$money_total = $ac->getSUM($uniacid,$aid);
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
//检车设备状态是否在线
if(isset($_POST['ac']) && $_GPC['ac'] == 'checkSta'){		
	$fid = $_POST['fid'];
	$arr = explode("-",$fid);  // 0：fid   1: id
    $uniacid = $_POST['uniacid'];
	//查询设备所属远程api  folder 目录
	$dev_data = [
		'table' => 'device',
		'where' => 'id = '.$arr[1].' and uniacid="'.$uniacid.'"',
	];
	$dev_rs = $ac->Find($dev_data);
	//API远程 ---- 状态查询-----
	//系统配置通信字段
	$sys_data = [
		'table' => 'sysconfig',
		'where' => 'uniacid = '.$uniacid.'',
	];
	$syscfg = $ac->Find($sys_data);
	//远程
	$curl_data = [
		'action' => 'checkSta',		
		'token' => $syscfg['tokens'],
		'appid' => $syscfg['appid'],
		'fid' => $arr[0]
	];		
	$curl_url = $syscfg['apiurl']."/".$dev_rs['folder']."/Api.php";
	$rs_json = curl_request($curl_url,$curl_data);
	$rs_arr = json_decode($rs_json,true);		
	if($rs_arr[0] == 'SUCCESS'){
		if($rs_arr[1] == '0001'){ //设备在线
			echo 1;
		}elseif($rs_arr[1] == '0000'){
			echo 0;
		}		
	}else{
		echo 2;
	} 				
	//API远程 -- 状态 end		
}
//发送设备信号测试
if(isset($_POST['ac']) && $_GPC['ac'] == 'checksend'){		
	$fid = $_POST['fid'];
	$arr = explode("-",$fid);  // 0：fid   1: id
    $uniacid = $_POST['uniacid'];
	
	//查询设备
	$dev_data = [
		'table' => 'device',
		'where' => 'id = '.$arr[1].' and uniacid="'.$uniacid.'"',
	];
	$dev_rs = $ac->Find($dev_data);
		
	//API远程 ---- 状态查询-----
	//系统配置通信字段
	$sys_data = [
		'table' => 'sysconfig',
		'where' => 'uniacid = '.$uniacid.'',
	];
	$syscfg = $ac->Find($sys_data);
	
	
	//远程
	$curl_data = [
		'action' => 'sendIns',		
		'token' => $syscfg['tokens'],
		'appid' => $syscfg['appid'],
		'pluse' => '0001',
		'device_code' => $dev_rs['device_code']
	];		
	$curl_url = $syscfg['apiurl']."/".$dev_rs['folder']."/Api.php";
	$rs_json = curl_request($curl_url,$curl_data);
	$rs_arr = json_decode($rs_json,true);		
	if($rs_arr[0] == 'SUCCESS'){		
		echo 1;			
	}else{
		echo 0;
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