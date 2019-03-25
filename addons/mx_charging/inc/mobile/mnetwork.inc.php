<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));
define("AID",$_GPC['aid']);
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
			
				//逻辑部分
				$tel = $cfg['hotline'];
				$article = "select *  from ".tablename('xc_area')." where uniacid=".$_W['uniacid']." and aid=".AID." order by id desc";
				$all_list = pdo_fetchall($article);
				$total_count = count($all_list);
				$page_size = 8;
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
				
				$sql = $article . " LIMIT " . ($page-1)*$page_size . "," . $page_size;
				$list = pdo_fetchall($sql);
				foreach($list as $k=>$v){		
					$dev_total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xc_device')." where area_id=".$v['id']);
					$list[$k]['num_count'] = $dev_total;
				} 
			
			}else{
				$redirect_uri = urlencode($_W['siteurl']);
				$author_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?appid=". $appid ."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=".AID."#wechat_redirect";
				header("location:$author_url");
			}
			
			
		}

	
}

include $this->template('mnetwork');

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