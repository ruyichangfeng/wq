<?php 
	
class Util 
{
	

	
	static function echoResult($status,$str,$arr='') {
		global $_W;
		$uid = empty( $_W['openid'] ) ? 0 : $_W['openid'] ;
		$res = array('status'=>$status,'res'=>$str,'obj'=>$arr);
		echo json_encode($res);
		self::deleteCache('ing',$uid);
		exit;
	}

	//查询模块config
	static function getModuleConfig(){
		$modulelist = uni_modules(false);
		return $modulelist['zofui_groupshop']['config'];
	}
	
	//注册jssdk，因为微擎自带的方法内没有加openAddress，所以重新写一个。
	static function register_jssdk($debug = false){
		global $_W;
		if (defined('HEADER')) {
			echo '';
			return;
		}
		
		$sysinfo = array(
			'uniacid' 	=> $_W['uniacid'],
			'acid' 		=> $_W['acid'],
			'siteroot' 	=> $_W['siteroot'],
			'siteurl' 	=> $_W['siteurl'],
			'attachurl' => $_W['attachurl'],
			'cookie' 	=> array('pre'=>$_W['config']['cookie']['pre'])
		);
		if (!empty($_W['acid'])) {
			$sysinfo['acid'] = $_W['acid'];
		}
		if (!empty($_W['openid'])) {
			$sysinfo['openid'] = $_W['openid'];
		}
		if (defined('MODULE_URL')) {
			$sysinfo['MODULE_URL'] = MODULE_URL;
		}
		$sysinfo = json_encode($sysinfo);
		$jssdkconfig = json_encode($_W['account']['jssdkconfig']);
		$debug = $debug ? 'true' : 'false';
		
		$jsscript = '<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>';
		if( $_W['ishttps'] ) $jsscript = '<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>';
		
		$script = <<<EOF
	{$jsscript}
	<script type="text/javascript">
		window.sysinfo = window.sysinfo || $sysinfo || {};
		
		// jssdk config 对象
		jssdkconfig = $jssdkconfig || {};
		
		// 是否启用调试
		jssdkconfig.debug = $debug;
		
		jssdkconfig.jsApiList = [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'hideMenuItems',
			'showMenuItems',
			'hideAllNonBaseMenuItem',
			'showAllNonBaseMenuItem',
			'translateVoice',
			'startRecord',
			'stopRecord',
			'onRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getNetworkType',
			'openLocation',
			'getLocation',
			'hideOptionMenu',
			'showOptionMenu',
			'closeWindow',
			'scanQRCode',
			'chooseWXPay',
			'openProductSpecificView',
			'addCard',
			'chooseCard',
			'openCard',
			'openAddress'
		];
		
		wx.config(jssdkconfig);
		
	</script>
EOF;
		echo $script;
	}	
	
	
	//微信端上传图片 传入微信端下载的图片
	static function uploadImageInWeixin($resp){
		global $_W;
		$setting = $_W['setting']['upload']['image'];
		$setting['folder'] = "images/{$_W['uniacid']}".'/'.date('Y/m/');	
		
/* 		load()->func('communication');
		$resp = ihttp_get($url); */
		load()->func('file');
		if (is_error($resp)) {
			$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
			return json_encode($result);
		}
		if (intval($resp['code']) != 200) {
			$result['message'] = '提取文件失败: 未找到该资源文件.';
			return json_encode($result);
		}
		$ext = '';
		
		switch ($resp['headers']['Content-Type']){
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				return json_encode($result);
				break;
		}
		
		if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
			$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
			return json_encode($result);
		}
		$originname = pathinfo($url, PATHINFO_BASENAME);
		$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
		$pathname = $setting['folder'] . $filename;
		$fullname = ATTACHMENT_ROOT . '/' . $pathname;
		if (file_put_contents($fullname, $resp['content']) == false) {
			$result['message'] = '提取失败.';
			return json_encode($result);
		}
		$info = array(
			'name' => $originname,
			'ext' => $ext,
			'filename' => $pathname,
			'attachment' => $pathname,
			'url' => tomedia($pathname),
			'is_image' => $type == 'image' ? 1 : 0,
			'filesize' => filesize($fullname),
		);		
		return json_encode($info);
	}	
	
	
	//格式化时间,多久之前
	static function formatTime($time){
		$difftime = time() - $time;
		
		if($difftime < 60){
			return $difftime . '秒前';
		}
		if($difftime < 120){
			return '1分钟前';	
		}
		if($difftime < 3600){
			return  intval($difftime/60).'分钟前';			
		}		
		if($difftime < 3600*24){
			return  intval($difftime/60/60).'小时前';			
		}
		if($difftime < 3600*24*2){
			return  '昨天';			
		}
		return  intval($difftime/60/60/24).'天前';
	}
	
	//剩余时间
	static function lastTime($time,$secondflag = true){
		$diff = $time - time();
		if($diff <= 0) return '0天0时0分';
		$day = intval($diff/24/3600);
		$hour = intval( ($diff%(24*3600))/3600 );
		$minutes = intval( ($diff%(24*3600))%3600/60 );
		$second = $diff%60;
		if($secondflag){
			return $day. '天' . $hour . '时' .$minutes. '分' .$second. '秒';
		}else{
			return $day. '天' . $hour . '时' .$minutes. '分';
		}
	}	
	
	
	
	//当前距明天的时间差
	static function diffTimeOftomorrow(){
		$tomo = date("Y-m-d",strtotime("+1 day"));
		return strtotime($tomo) - time();
	}
	
	//删除数据库
	static function deleteData($id,$tablename){
		global $_W;
		if($id == '') return false;
		$id = intval($id);
		$datainfo = self::getSingelDataInSingleTable($tablename,array('id'=>$id));
		if (empty($datainfo)) message('抱歉，数据不存在或是已经被删除！');
		
		$res = pdo_delete($tablename, array('id' => $id,'uniacid' => $_W['uniacid']), 'AND');
		return $res;
	}		
		
	//插入数据
	static function inserData($tablename,$data){
		global $_W;
		if($data == '') return false;
		$data = $data;
		$data['uniacid'] = $_W['uniacid'];
		$res = pdo_insert($tablename,$data);
		return $res;
	}
	
	//根据条件查询数据条数
	static function countDataNumber($tablename,$where,$str = ''){
		global $_W;
		$data = self::structWhereStringOfAnd($where);	
		return pdo_fetchcolumn(" SELECT COUNT(*) FROM " . tablename($tablename) . " WHERE $data[0] ".$str,$data[1]);
	}
	
	//更新单条数据，对数据进行加减，更新。需传入id
	static function addOrMinusOrUpdateData($tablename,$countarray,$id,$type='addorminus'){
		global $_W;
		if(empty($countarray)) return false;
		$count = '';
		if($type == 'addorminus'){
			foreach($countarray as $k=>$v){
				$count .= ' `'.$k.'`'.' = '.' `'.$k.'` '.' + '.$v.',';
			}
		}elseif($type == 'update'){
			foreach($countarray as $k=>$v){
				$count .= "`".$k."` = '".$v."',";
			}
		}
		$count = trim($count,',');
		$id = intval($id);
		$res = pdo_query("UPDATE ".tablename($tablename)." SET $count WHERE `id` = '{$id}' AND `uniacid` = '{$_W['uniacid']}' ");
		if($res) return true;
		return false;
	}
	
	//在一个表里查询单条数据
	static function getSingelDataInSingleTable($tablename,$array,$select='*'){
		$data = self::structWhereStringOfAnd($array);
		$sql = "SELECT $select FROM ". tablename($tablename) ." WHERE $data[0] ";
		return pdo_fetch($sql,$data[1]);
	}
	
	//在一个表里查询多条数据
	static function getAllDataInSingleTable($tablename,$where,$page,$num,$order='id DESC',$isNeadPager = true,$select = '*'){
		global $_W;
		$data = self::structWhereStringOfAnd($where);
		
		$countStr = "SELECT COUNT(*) FROM ".tablename($tablename) ." WHERE $data[0] ";
		$selectStr = "SELECT $select FROM ".tablename($tablename) ." WHERE $data[0] ";
		$res = self::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$isNeadPager);
		return $res;
	}
	
	/*
	*	查询数据共用方法
	*	$selectStr -> mysql字符串
	*	$page -> 页码
	*	$num -> 每页数量
	*	$order -> 排序
	*	$isNeadPager -> 是否需要分页
	*/
	static function fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order='`id` DESC',$isNeadPager=false){
		$pindex = max(1, intval($page));
		$psize = $num;
		$total =  $isNeadPager?pdo_fetchcolumn($countStr,$params):'';
		
		$data = pdo_fetchall($selectStr." ORDER BY $order " . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize,$params);
		$pager = $isNeadPager?pagination($total, $pindex, $psize):'';		
		return array($data,$pager,$total);
	}	
	
	//组合AND数据查询where字符串 = ,>= ,<= <、>必须紧挨字符 例：$where = array('status'=>1,'overtime<'=>time());
 	static function structWhereStringOfAnd($array,$head=''){
		global $_W;
		if(!is_array($array)) return false;
		$array['uniacid'] = $_W['uniacid'];
		$str = '';
		foreach($array as $k=>$v){
			if(isset($k) && $v === '') message('存在异常参数'.$k);
			if(strpos($k,'>') !== false){
				$k = trim(trim($k),'>');
				$eq = ' >= ';
			}elseif(strpos($k,'<') !== false){
				$k = trim(trim($k),'<');
				$eq = ' <= ';
			}elseif(strpos($k,'@') !== false){ //模糊查询
				$eq = ' LIKE ';
				$k = trim(trim($k),'@');
				$v = "%".$v."%";
			}elseif(strpos($k,'#') !== false){ //in查询
				$eq = ' IN ';
				$k = trim(trim($k),'#');
			}else{
				$eq = ' = ';
			}
			$str .= empty($head) ? 'AND `'.$k.'`'.$eq.':'.$k.' ' : 'AND '.$head.'.`'.$k.'`'.$eq.':'.$k.' ';
			
			$params[':'.$k] = $v;
			
		}
		$str = trim($str,'AND');
		return array($str,$params);
	}	
	
	
	//用户唯一字符串
	static function structUserStr($openid){
		global $_W;
		if($openid == '') return false;
		$openid = empty($openid)?$_W['openid']:$openid;
		$rump = substr($openid, -20);
		return 'fshopuser'.$rump.$_W['uniacid'];		
	}
	
	//获取cookie 传入cookie名 //解决js与php的编码不一致情况。
	static function getCookie($str){
		return urldecode($_COOKIE[$str]);
	}
	
	//共用先查询缓存数据
	static function getDataByCacheFirst($key,$name,$funcname,$valuearray){
		$data = self::getCache($key,$name);
		if(empty($data)){
			$data = call_user_func_array($funcname,$valuearray);
			self::setCache($key,$name,$data);
		}
		return $data;
	}
	
	//查询缓存
 	static function getCache($key,$name) {
		global $_W;
		if(empty($key) || empty($name)) return false;
		return cache_read('zofui_groupshop:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//设置缓存
	static function setCache($key,$name,$value) {
		global $_W;
		if(empty($key) || empty($name)) return false;	
		
		$res = cache_write('zofui_groupshop:'.$_W['uniacid'].':'.$key.':'.$name,$value);
		return $res;
	}
	
	//删除缓存
	static function deleteCache($key,$name) {
		global $_W;		
		if(empty($key) || empty($name)) return false;
		
		return cache_delete('zofui_groupshop:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//删除所有缓存 每次设置参数后都要删除
	static function deleteThisModuleCache(){
		global $_W;
		$res = cache_clean('zofui_groupshop');
		return $res;
	}
	
	//创建目录
	static function mkdirs($path) {
		if (!is_dir($path)) {
			mkdir($path,0777,true);
		}
		return is_dir($path);
	}	
	
	//核查文件是否存在
	static function fileExists($name,$dir=''){
		global $_W;		
		if(empty($name)){
			return false;
		}	
		$name = MD5($name.$GLOBALS['_W']['config']['setting']['authkey']);	
		$dir = ZOFUI_GROUPSHOP . 'cache/' .$_W['uniacid'] . '/' . $dir;	
		$file = $dir . '/' . $name.'.php';		
		if(file_exists($file)){
			return true;
		}else{
			return false;
		}
	}
	
	//加密
	static function encrypt($str){
		global $_W;
		return authcode($str, 'ENCODE' ,$_W['account']['key'],600); 
	}
	//解密
	static function decode($str){
		global $_W;
		return authcode($str, 'DECODE' ,$_W['account']['key'],600); 
	}	
	
	
	//组合URL
	static function createModuleUrl($do,$array=array()){
		global $_W;
		$str = '&do='.$do;
		foreach((array)$array as $k=>$v){
			$str .= '&'.$k.'='.$v;
		}
		return $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry'.$str.'&m=zofui_groupshop';
	}	
	
	//处理空格
	static function trimWithArray($array){
		if(!is_array($array)){
			return trim($array);
		}
		foreach($array as $k=>$v){	
			$res[$k] = self::trimWithArray($v);
		}
		return $res;	
	}
	
    public static function httpRequest($url, $post = '', $headers = array(), $forceIp = '', $timeout = 60, $options = array())
    {
        load()->func('communication');
        return ihttp_request($url, $post, $options, $timeout);
    }
	//get请求
    public static function httpGet($url, $forceIp = '', $timeout = 60)
    {
        $res = self::httpRequest($url, '', array(), $forceIp, $timeout);
        if (!is_error($res)) {
            return $res['content'];
        }
        return $res;
    }
	//post请求
    public static function httpPost($url, $data, $forceIp = '', $timeout = 60)
    {
        $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
        $res = self::httpRequest($url, $data, $headers, $forceIp, $timeout);
        if (!is_error($res)) {
            return $res['content'];
        }
        return $res;
    }
}
	
	
?>