<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';

$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
define("AID",$cfg['aid']);
define("APPID",$cfg['appid']);

//判断当前用户是否管理员
$user_info = pdo_get('xc_user',array('openid'=>$_W['openid'],'aid'=>$_GPC['aid']));
if($user_info['isadmin'] != 1){
	message("您还不是系统管理员!",$this->createMobileurl('mindex',array('aid'=>$_GPC['aid'])),'error');
	exit;
}

if($op == 'index') {
		//区域选择
		$areas = "select *  from ".tablename('xc_area')." where uniacid=".$_W['uniacid']." and aid=".$cfg['aid']." and appid='".$cfg['appid']."' order by id desc";
		$areas_list = pdo_fetchall($areas);
		
	}
	
	
include $this->template('search');

	
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



