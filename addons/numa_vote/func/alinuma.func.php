<?php
 /**
 * 【阿里驽马工作室】 
 * @author 驽马壹號
 * @常用函数
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 调试时打印输出
 * @param array 可以是字符串 数组 对象等
 * @return string 格式化的字符串
 */
function alinuma_prePrint($object){
	 	  echo "<pre/>";
	 	  print_r($object);
		  exit;
 }  
/**
 *日期转换
 *@param time 数字日期
 *@param format 格式 默认 Y-m-d H:i:s
 *@return string
 */
function alinuma_toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}
/**
 * 图片地址转为base64
 */
function alinuma_base64EncodeImage ($image_file) {
  $base64_image = '';
  $image_info = getimagesize($image_file);
  $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
  $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
  return $base64_image;
}
/**
 * 获取IP所在城市
 */
 function  alinuma_getIpLookup($ip = ''){  
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
    if(empty($res)){ return false; }  
    $jsonMatches = array();  
    preg_match('#\{.+?\}#', $res, $jsonMatches);  
    if(!isset($jsonMatches[0])){ return false; }  
    $json = json_decode($jsonMatches[0], true);  
    if(isset($json['ret']) && $json['ret'] == 1){  
        $json['ip'] = $ip;  
        unset($json['ret']);  
    }else{  
        return false;  
    }  
    return $json;  
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function alinuma_getClientIp($type = 0) {
	$type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    } 
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 获取邻近访问地址
 * @return string 
 */
function alinuma_getReferer(){
		if ( empty( $_SERVER['HTTP_REFERER'] ) ){
				return "";
		}
		return $_SERVER['HTTP_REFERER'];
}
  /**
 * 加密函数
 *
 * @param string $txt 需要加密的字符串
 * @param string $key 密钥
 * @return string 返回加密结果
 */
function alinuma_encrypt($txt, $key = ''){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
	$nh1 = rand(0,64);
	$nh2 = rand(0,64);
	$nh3 = rand(0,64);
	$ch1 = $chars{$nh1};
	$ch2 = $chars{$nh2};
	$ch3 = $chars{$nh3};
	$nhnum = $nh1 + $nh2 + $nh3;
	$knum = 0;$i = 0;
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum%8,$knum%8 + 16);
	$txt = base64_encode(time().'_'.$txt);
	$txt = str_replace(array('+','/','='),array('-','_','.'),$txt);
	$tmp = '';
	$j=0;$k = 0;
	$tlen = strlen($txt);
	$klen = strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = ($nhnum+strpos($chars,$txt{$i})+ord($mdKey{$k++}))%64;
		$tmp .= $chars{$j};
	}
	$tmplen = strlen($tmp);
	$tmp = substr_replace($tmp,$ch3,$nh2 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch2,$nh1 % ++$tmplen,0);
	$tmp = substr_replace($tmp,$ch1,$knum % ++$tmplen,0);
	return $tmp;
}
/**
 * 解密函数
 *
 * @param string $txt 需要解密的字符串
 * @param string $key 密匙
 * @return string 字符串类型的返回结果
 */
function alinuma_decrypt($txt, $key = '', $ttl = 0){
	if (empty($txt)) return $txt;
	if (empty($key)) $key = md5(MD5_KEY);

	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
	$ikey ="-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
	$knum = 0;$i = 0;
	$tlen = @strlen($txt);
	while(isset($key{$i})) $knum +=ord($key{$i++});
	$ch1 = @$txt{$knum % $tlen};
	$nh1 = strpos($chars,$ch1);
	$txt = @substr_replace($txt,'',$knum % $tlen--,1);
	$ch2 = @$txt{$nh1 % $tlen};
	$nh2 = @strpos($chars,$ch2);
	$txt = @substr_replace($txt,'',$nh1 % $tlen--,1);
	$ch3 = @$txt{$nh2 % $tlen};
	$nh3 = @strpos($chars,$ch3);
	$txt = @substr_replace($txt,'',$nh2 % $tlen--,1);
	$nhnum = $nh1 + $nh2 + $nh3;
	$mdKey = substr(md5(md5(md5($key.$ch1).$ch2.$ikey).$ch3),$nhnum % 8,$knum % 8 + 16);
	$tmp = '';
	$j=0; $k = 0;
	$tlen = @strlen($txt);
	$klen = @strlen($mdKey);
	for ($i=0; $i<$tlen; $i++) {
		$k = $k == $klen ? 0 : $k;
		$j = strpos($chars,$txt{$i})-$nhnum - ord($mdKey{$k++});
		while ($j<0) $j+=64;
		$tmp .= $chars{$j};
	}
	$tmp = str_replace(array('-','_','.'),array('+','/','='),$tmp);
	$tmp = trim(base64_decode($tmp));

	if (preg_match("/\d{10}_/s",substr($tmp,0,11))){
		if ($ttl > 0 && (time() - substr($tmp,0,11) > $ttl)){
			$tmp = null;
		}else{
			$tmp = substr($tmp,11);
		}
	}
	return $tmp;
}  
/**
 * 判断授权码是否正确
 * @param $code 授权码
 * @param $type adv广告授权1模块授权
 * @param $module 模块名称
 * @param $weid 公众号ID
 */
 function alinuma_checkAuth($code,$type='adv',$module='',$weid=''){
 		// 加载 sdk
		load()->classs('cloudapi'); 
		// 开发模式调用云API, 需 'developer.cer'
		$api = new CloudApi();  
		$host = $_SERVER['HTTP_HOST']; 
		// 1. URL
		$params = array();
		$params["host"] = $host;
		$params["code"] = $code;
		$params["module"] = $module;
		$params["weid"] = $weid;
		$params["type"] = $type;   
		// 2. GET
		$result =$api->get("AlinumaUtil", "checkAuth", $params, 'json');   
		return $result; 
 }
 /**
  * 产生json数据格式 
  * @status 1成功0失败
  * @message 消息内容 
  * @jumpUrl 跳转地址
  * @data 反馈数据
  */
   function alinuma_returnJson($status=1,$message='',$jumpUrl="",$data=''){
  		 	$data   =   is_array($data)?$data:array();
            $data['info']   =   $message;
            $data['status'] =   $status;
            $data['url']    =   $jumpUrl;
             // 返回JSON数据格式到客户端 包含状态信息  
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($data));
   }
  /**
 * 字符串截取
 * @param sourcestr 源字符串
 * @param cutlength 截取的长度
 * @param suffix 省略字符串 默认 ...
 * @return string 
 */
function alinuma_strCut($sourcestr,$cutlength,$suffix='...'){
	$str_length = strlen($sourcestr);
	if($str_length <= $cutlength) {
		return $sourcestr;
	}
	$returnstr='';	
	$n = $i = $noc = 0;
	while($n < $str_length) {
			$t = ord($sourcestr[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$i = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$i = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$i = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$i = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$i = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$i = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $cutlength) {
				break;
			}
	}
	if($noc > $cutlength) {
			$n -= $i;
	}
	$returnstr = substr($sourcestr, 0, $n); 
	if ( substr($sourcestr, $n, 6)){
          $returnstr = $returnstr . $suffix;//超过长度时在尾处加上省略号
      }
	return $returnstr;
}
 /**
 * 获取当前页面完整URL地址
 * @return string 当前页面
 */
 function alinuma_getCurrentUrl() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
 } 
   /**
 * 获取赞助广告
 * @param $type 1随机
 * @param $aid 广告ID
 * @param $adv_type 指定广告类型2图片1JS
 * @param weid 公众号原始ID
 * @return 
 */
 function alinuma_getSponsorAdv($type=1,$aid=0,$adv_type=0){
 	    global $_W; 
 	    $adv_data = array();
		$host = $_SERVER['HTTP_HOST'];
		$ip2long = alinuma_getClientIp(1);
		// 1. URL
		 $uniaccount_key = 'uniaccount:'.$_W['uniacid'];  
         $weid = isset($_W['cache'][$uniaccount_key]['original'])?$_W['cache'][$uniaccount_key]['original']:'未知';
 		 $result = alinuma_getRemoteAdv($type,$aid,$adv_type,$weid,$ip2long);
	     if(!is_error($result)){
	       		$adv_data = $result['data']; 
	     } 
	    return $adv_data;  
 }
 /**
  * 直接获取广告代码
 * @param $type 1随机
 * @param $aid 广告ID
 * @param $adv_type 指定广告类型2图片1JS
 * @param weid 公众号原始ID
 * @param ip2longIP地址long
  */
  function alinuma_getRemoteAdv($type=1,$aid=0,$adv_type=0,$ip2long=''){
  				 global $_W;
  	 			 include(IA_ROOT . '/addons/'.IN_MODULE.'/PhalApiClient.php');
  		 		 $client = PhalApiClient::create()->withHost('http://api.alinuma.com/');
                 $adv_id = $aid;
                 $adv_type = $adv_type;
                 //当前IP地址
                 if($ip2long=='')  $ip2long = alinuma_getClientIp(1);
                 if($type==2 && !$adv_id){
                 	     return array("errno"=>"1","msg"=>"广告ID不能为空");
                 }
                 if($type==3 && !$adv_type){
                 	      return array("errno"=>"1","msg"=>"广告类型不能为空"); 
                 }
                $uniaccount_key = 'uniaccount:'.$_W['uniacid'];  
                $weid = isset($_W['cache'][$uniaccount_key]['original'])?$_W['cache'][$uniaccount_key]['original']:'未知';
		        $rs = $client->reset()
				    ->withService('Adv.GetRand')
				    ->withParams('type', $type)
				    ->withParams('advid', $adv_id)
				    ->withParams('advtype', $adv_type)
				    ->withParams('weid', $weid)
				    ->withParams('ip',$ip2long)
				    ->withTimeout(3000)
				    ->request();  
				  if($rs->getRet()=='200'){
				  	     return array("data"=>$rs->getData());  
				  }else{
				  	    return array("errno"=>"1","msg"=>$rs->getMsg());  
				  }   
  		 }
  	  /**
  	   * 授权检查
  	   * @settings 全局配置
  	   * @module 模块名称
  	   * @key 加密密钥
  	   */
  	   function alinuma_authReload($settings,$module,$key='advauthcode'){
  	   	 		global $_W; 
      		 	$key  = "numa_vote_".$key."_".$_W['uniacid'];   
  	   			$need_reload = false;
  	   			$have_auth = false;
			    if(isset($settings['valid']) && $settings['valid']==1 && $settings['advcode']!=''){
					  		if($settings['etime']>time() || ($settings['stime']<time() && $settings['etime']==0)){
					  				 //获取授权是否写入缓存 
					  				 $auth_code =  cache_read($key);
					  				 if(!empty($auth_code)){//查看是否需要进行重新获取
					  				 		 $code_content = alinuma_decrypt($auth_code,$module);
					  				 		 $temp_array = explode("|",$code_content);
					  				 		 if(empty($temp_array)){
					  				 		 	    $need_reload=true;
					  				 		 }else{
					  				 		 	    if($temp_array[0]!=$settings['advcode']){
					  				 		 	    		 $need_reload=true;
					  				 		 	    }elseif(isset($temp_array[2]) && $temp_array[2]<time()){
					  				 		 	    	     $need_reload=true;
					  				 		 	    }
					  				 		 }
					  				 }else{
					  				 		$need_reload = true;
					  				 }
					  		}else{
					  			  $need_reload = true;
					  		}
					  		//需要重新获取后重新更新授权信息并写入cache
					  		if($need_reload){ 
					  			      $auth_code="";
					  				  $result = alinuma_checkAuth($settings['advcode'],"adv",$module,$_W['account']['original']);
									  if((is_array($result) && $result['valid']==1 )){
											   //并写入缓存
											   $text = $settings['advcode']."|".time()."|".(time()+7*86400);
											   $auth_code=alinuma_encrypt($text,$module);
											   $have_auth = true;
									  }
									  cache_write($key,$auth_code);
					  		}else{
					  			  $have_auth = true;
					  		}
				 }
				 return $have_auth;
  	   }
  	   /**
  	    * 内容中加入赞助广告代码
  	    * @type 1图片广告
  	    * @adv 广告数据
  	    */
  	    function alinuma_writeSponsorAdvCode($type,$adv){
  	    	   $str="";
         	   if($type==1){
		         	   $str .= '<style type="text/css">.guanggao h2 span{width:1.2rem}.guanggao img{height:1.5rem}</style>';
		         	   $str .='<div class="guanggao" style="background:#fff">';
								$str .='<h2 style="color: #999; text-align: center; height: .6rem; line-height: .6rem; font-size: .25rem; position: relative;"><span style="width: 1rem; z-index: 1;position: absolute;background:#FFF;left: 50%; margin-left: -.5rem;">广告</span><i style="border-bottom: 1px  dashed #ddd; background: #f4f4f4; display: block; position: absolute; width: 100%; top: .3rem; z-index:0;"></i></h2>';
				         	  $str .='<a href="'.$adv['url'].'" onclick="document.location.href=this.href"><img src="'.$adv['image'].'" alt="'.$adv['title'].'" /></a>';
		         	   $str .='</div></div>';
		         	 
         	   }elseif($type==2){//JS代码
         	   	     if(!empty($adv['code'])){
		         	   	    $str .= '<style type="text/css">.guanggao h2 span{width:1.2rem}</style>';
				             $str .='<div class="guanggao"  style="background:#fff">';
								 $str .='<h2 style="color: #999; text-align: center; height: .6rem; line-height: .6rem; font-size: .25rem; position: relative;"><span style="width: 1rem; z-index: 1;position: absolute;background:#FFF;left: 50%; margin-left: -.5rem;">广告</span><i style="border-bottom: 1px  dashed #ddd; background: #f4f4f4; display: block; position: absolute; width: 100%; top: .3rem; z-index:0;"></i></h2>';
				         	 	 $str .=htmlspecialchars_decode($adv['code']);
				            $str .='</div></div>'; 
         	   	     } 
         	   } 
         	  return $str;
         } 
         /**
		 * 获取地图地理位置链接
		 * @param array data //map_jwd地图经纬度 title标题 address地址
		 * @return string url 地址
		 */
		 function alinuma_getMapUrl($data,$qqappkey='WJEBZ-7A5WO-I4LWO-SOPQ3-5CS6K-AJBCW'){ 
		     	$gotourl = "http://apis.map.qq.com/tools/poimarker?type=0&marker=coord:".$data['map_jwd']
				.";title:".$data['title']
				.";addr:".$data['address']
				."&key=".$qqappkey."&referer=myapp";  
			     return $gotourl;
		 } 
	 /**
	  * 第三方获取openid
	  */
	 function alinuma_getOauthOpenid($code,$appid){
		    $openid = '';
		    $get_openid_url = "http://www.nbwaka.com/getopenidfromcode.php?code={$code}&grant_type=authorization_code";
		    $return = alinuma_getHtml($get_openid_url);
		    if(!empty($return)){
		        $content = json_decode($return,true);
		        if(is_array($content) && !empty($content) && isset($content['openid']) && !empty($content['openid'])){
		            $openid = $content['openid'];
		        }
		    }
		    return $openid;
		} 
		function alinuma_getOauthAccessToken($code,$appid){
		    $outArr = array(
		        'access_token' => '',
		        'openid' => '',
		    );
		    $get_url = "http://www.nbwaka.com/getopenidfromcode.php?code={$code}&grant_type=authorization_code";
		    $return = alinuma_getHtml($get_url);   
		    if(!empty($return)){
		        $content = json_decode($return,true);
		        if(is_array($content) && !empty($content) && isset($content['access_token']) && !empty($content['access_token'])){
		            $outArr = array(
		                'access_token' => $content['access_token'],
		                'openid' => $content['openid'],
		            );
		        }
		    }
		    return $outArr;
		} 
	   function alinuma_getOauthUserinfo($access_token,$openid){
	   	        //load()->func("")
		    	$outArr = array(); 
		    	$get_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
			    $return = alinuma_getHtml($get_url);
			    if(!empty($return)){
			        $content = json_decode($return,true);
			        if(is_array($content) && !empty($content) && isset($content['nickname']) && !empty($content['nickname'])){
			            $outArr = $content;
			        }
			    }
			    return $outArr;
		}
	 function alinuma_getHtml($url){
		    if(function_exists('curl_init')){
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		        curl_setopt($ch, CURLOPT_HEADER, 0);
		        $return = curl_exec($ch);
		        curl_close($ch); 
		        return $return;
		    }
		    return false;
    }
   /**
   * 写数据到excel表格 
   * @param fileurl 写入文件名
   * @param header 表格头部标题
   * @param  data_list 写入数据数组
   * @return void 空操作
    */
    function alinuma_writeXls($fileurl,$headers,$data_list){
    	        // 创建phpexcel对象，此对象包含输出的内容及格式 
		 	   include(IA_ROOT."/framework/library/phpexcel/PHPExcel.php"); // 生成excel的基本类定义(注意文件名的大小写)
				// 如果直接输出excel文件，则要包含此文件
				include(IA_ROOT."/framework/library/phpexcel/PHPExcel/Writer/Excel5.php");	
				include(IA_ROOT."/framework/library/phpexcel/PHPExcel/Cell/DataType.php");	
			   $m_objPHPExcel = new PHPExcel();	 		
	 	       $m_objPHPExcel->setActiveSheetIndex(0);  
				$col = 0; //写表格表头
				foreach($headers[0] as $header){ 
					$m_objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $header);
					$col++;					
				} 
				$row = 2;//写表数据 
				if(!empty($data_list)) {
					foreach($data_list as $data) {
						 $col = 0;
						 foreach ($data as $v) {
						 	if(is_numeric($v)) {
						 		$excel_col= alinuma_numToEn($col).$row; 
								$m_objPHPExcel->getActiveSheet()->setCellValueExplicit($excel_col, $v, PHPExcel_Cell_DataType::TYPE_STRING);
							} else {
								$m_objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$v);								
							}
							$col++;
						 } 
						 $row++;
					}					
				} 
				$objWriter = new PHPExcel_Writer_Excel5($m_objPHPExcel);
				$objWriter->save($fileurl); 
    }
    function alinuma_numToEn($num) {
			$asc = 0;
			$en = "";
			$num =(int)$num+1;
			if($num<26) {                     //判断指定的数字是否需要用两个字母表示
			     if((int)$num<10) {
					$asc = ord($num);
					$en =chr($asc+16);
				} else {
					$num_g = substr($num,1,1);
					$num_s = substr($num,0,1);
					$asc = ord($num_g);
					$en =chr($asc+16+10*$num_s);
				}
			} else {
				$num_complementation = floor($num/26);
				$en_q = alinuma_numToEn($num_complementation);
				$en_h = $num%26 != 0 ? alinuma_numToEn($num-$num_complementation*26):"A";
				$en = $en_q.$en_h;
			}
			return $en;
	 }	  
/**
 * 下载文件
 * @param string filename
 * @param string fileurl
 */
   function alinuma_downFile($fileurl,$filename){
   	   //下载这个文件 
	        include(IA_ROOT."/addons/numa_vote/library/Http.class.php");	
			ob_end_clean();
			$download=new Http();	
			$download->download($fileurl,$filename);	 
		    exit;  
   }
   /**
 * 创建目录
 * @param dir 目录
 * @param mode 权限 0777全部权限
 * @return void
 */
 function alinuma_mkDir($dir, $mode = 0777) {
   	 if (is_dir($dir) || @mkdir($dir, $mode))
	        return true;
	    if (!alinuma_mkDir(dirname($dir), $mode))
	        return false;
	    return @mkdir($dir, $mode);
}
/**
 * 获取压缩图片
 * @img_src 图片地址
 * @precent 压缩比例1
 */
  function alinuma_getCompress($img_src,$percent=1){
  			global $_W;  
			$source = $img_src;
			$filename = substr(basename($img_src),0,strrpos(basename($img_src), '.'));   
			$filetype =  substr(basename($img_src),strrpos(basename($img_src), '.'));   
			 if (strexists($source, 'http://') || strexists($source, 'https://') || substr($source, 0, 2) == '//') {
 				    $uniacid = intval($_W['uniacid']);
					$path = "images/{$uniacid}/" . date('Y/m/');
					alinuma_mkDir(ATTACHMENT_ROOT . '/' . $path);
					$dst_img_name = ATTACHMENT_ROOT ."/".$path.'/' .$filename."_compress";
					$image = $path.$filename."_compress".$filetype;
 			}else{
			        $source = tomedia($source);
 				    //$source = ATTACHMENT_ROOT ."/".$source;
 					$dst_img_name = ATTACHMENT_ROOT .dirname($img_src).'/' . $filename."_compress";
 					$image = dirname($img_src).'/'.$filename."_compress".$filetype;
 			}  
			include_once(IA_ROOT."/addons/numa_vote/library/Image.class.php");
			
			$imgCompress = new ImageCompress($source,$percent);
			
		    $imgCompress->compressImg($dst_img_name); 
		    return $image;
  }
?>