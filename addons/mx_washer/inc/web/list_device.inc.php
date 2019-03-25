<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$uniname = $_W['uniaccount']['name'];
$unilogo =  $_W['uniaccount']['logo'];
$outurl = $_W['siteroot'].$_W['script_name']."?c=home&a=welcome&do=platform&";
$uniacid = $_W['uniacid'];
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));

if($op == 'index'){
	//获取接入设备列表
	$agentlist = "select *  from ".tablename('xc_device')." where uniacid=".$_W['uniacid']." order by id desc";
	$all_list = pdo_fetchall($agentlist);
	$total_count = count($all_list);
	$page_size = 10;
	$page_count = ceil($total_count/$page_size);
	if($cfg['ishttps'] == 1){
					$http = 'https';
		}else{
					$http = 'http';
	}
	if(array_key_exists('page',$_GPC)) {
		$url=$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	} else {
		$url= $http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] . "&page=1";
	}
	$pages = array();
	for($i=0; $i<$page_count; $i++) {			
		$url=replace_var($url,"page",($i+1));
		$data['index'] = $i+1;
		$data['url'] = $url;
		array_push($pages,$data);
	}		
	$page = !empty($_GPC['page']) ? $_GPC['page'] : 1;
			
	$sql = $agentlist . " LIMIT " . ($page-1)*$page_size . "," . $page_size;
	$list = pdo_fetchall($sql);	
	
	foreach($list as $k=>$v){
		$agent = pdo_get('xc_agent',array('id'=>$v['aid']));
		$area = pdo_get('xc_area',array('id'=>$v['area_id']));
		$list[$k]['agent_name'] = $agent['user'];
		$list[$k]['true_name'] = $agent['true_name'];
		$list[$k]['area_name'] = $area['area_name'];
	}
	
	
	

	
	
}elseif($op =='update'){ //主控平台，设备更新状态
	
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
			message("设备状态更新成功!",$this->createWeburl('list_device',array('op'=>'index','aid'=>$cfg['aid'])),'success');
			//end			
		}else{
			message("远程设备响应失败!",'refresh','error');	
		}
}

/* //删除设备
if($op == 'del'){
	$id = intval($_GPC['id']);
	$wheres =[
		'id' => $id,
		'uniacid' => $_W['uniacid']
	];
	$result = pdo_delete('xc_device',$wheres);
	if($result){
			echo "<script>alert('操作成功！');window.location.href='".$this->createWeburl('list_device')."'</script>";
	}else{
			echo "<script>alert('操作失败！');window.history.back();</script>";
	}
} */
		






include $this->template('list_device');






function replace_var($url,$string,$new_value){  
    while(substr($url,0,1)=="&")  
    {  
            $url=substr($url,1);  
    }  
    if($url!="")  
    {  
        $url_array=explode("&",$url);  
        $new_url='';  
        $string_len=strlen($string)+1;  
        $i=0;  
        while($url_array[$i])  
        {  
            if(substr($url_array[$i],0,$string_len)==$string."=")  
            {  
                $url_array[$i]=$string."=".$new_value;  
            }  
            if($i>0) $url_array[$i]="&".$url_array[$i];  
                $new_url=$new_url.$url_array[$i];  
                $i++;  
        }  
    }  
    else $new_url=$_SERVER['PHP_SELF'];  
    return $new_url;  
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

