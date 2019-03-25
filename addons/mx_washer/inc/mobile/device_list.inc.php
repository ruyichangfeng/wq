<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
define("AID",$cfg['aid']);
define("APPID",$cfg['appid']);
$appid =  $cfg['appid'];
$appsecret =  $cfg['appsecrect'];



	if($op == 'index') {
		if(!isset($_GET['code'])){	
					$redirect_uri = urlencode($_W['siteurl']);
					$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
					header("location:$author_url");
		}else{
			$code = $_GET['code'];				
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";		
			$auth_token_data = curl_request($token_url);	
			$Token_arr =  json_decode($auth_token_data,true); //转数组								
			$openid =  $Token_arr['openid'];
			if(!empty($openid)){
		//逻辑代码开始
		//判断当前用户是否管理员
		$user_info = pdo_get('xc_user',array('openid'=>$openid,'aid'=>$_GPC['aid']));
		if($user_info['isadmin'] != 1){
			message("您还不是系统管理员!",$this->createMobileurl('mindex',array('aid'=>$_GPC['aid'])),'error');
			exit;
		}	
		$where_str = "";
		if(checksubmit("search")) {		
			$area_id = $_GPC['area_id'];
			$device_code = $_GPC['device_code'];
			$status = $_GPC['status'];
			if($area_id != ""){
				if($aid == 0){
					$wh_aid = '';
				}else{
					$wh_aid = " and area_id ='".$area_id."'";	
				}
				
			}else{
				$wh_aid = '';
			}
			if($device_code != ""){
				$wh_code = " and device_code ='".$device_code."'";
			}else{
				$wh_code = '';
			}
			if($status != ""){
				if($status == 2){
					$wh_sta = '';
				}else{
					$wh_sta = " and status ='".$status."'";
				}				
			}else{
				$wh_sta = '';
			}
			$where_str .= $wh_aid.$wh_code.$wh_sta;
		}else{
			$where_str .= "";
		}
		
				
		$device = "select *  from ".tablename('xc_device')." where uniacid=".$_W['uniacid']."  and aid=".$cfg['aid']." ".$where_str." order by id desc";
		
		
		$all_list = pdo_fetchall($device);
		$total_count = count($all_list);
		$page_size = 7;
		$page_count = ceil($total_count/$page_size);
		if($cfg['ishttps'] == 1){
				$http = 'https';
			}else{
				$http = 'http';
			}
		if(array_key_exists('page',$_GPC)) {
			$url= $http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
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
		
		$sql = $device . " LIMIT " . ($page-1)*$page_size . "," . $page_size;
		$list = pdo_fetchall($sql);	

		foreach($list as $k=>$v){
			$wh=[
				'id' => $v['area_id'],
				'uniacid' => $_W['uniacid'],
				'aid' => $cfg['aid']
			];
			$distruct = pdo_get('xc_area',$wh);			
			$list[$k]['address'] = $distruct['address'];
		}
		
		
	//远程API -- START
	//查询所有设备fid	
		$fid_list = "";
		foreach($list as $k){
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
			$t = "";
			for($i=0;$i<count($fid_arr);$i++){	
				$datat['status'] =$status_arr[$i];
				$wheres = [
					"fid" => $fid_arr[$i],
					'uniacid' => $_W['uniacid']
				];		
				pdo_update('xc_device',$datat,$wheres);
			}
			//end			
		}		
	//远程API --- end
	//逻辑代码结束
	}else{
				$redirect_uri = urlencode($_W['siteurl']);
				$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
					header("location:$author_url");
			}

	}
	
	
	
	
}
include $this->template('device_list');

	
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



