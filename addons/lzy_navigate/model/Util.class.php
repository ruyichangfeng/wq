<?php 
class Util 
{	
	static function formatDistance($dis){
		$dis = intval( $dis );
		switch ($dis) {
			case $dis <= 0:
				return '0m';
				break;
			case $dis < 2000:
				return $dis.'m';
				break;			
			default:
				return sprintf('%.2f',$dis/1000).'km';
				break;
		}
	}


	//获取区域
	static function getarea($ip = ''){
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

	static function echoResult($status,$str,$arr='') {
		global $_W;
		$uid = empty( $_W['openid'] ) ? 0 : $_W['openid'] ;
		$res = array('status'=>$status,'res'=>$str,'obj'=>$arr);
		echo json_encode($res);
		self::deleteCache('ing',$uid);
		exit;
	}	
	


	//获取客户端IP
	static function getClientIp() {
		$ip = "";
		if (!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		if (!empty($_SERVER["REMOTE_ADDR"])){
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}


	//微信端上传图片 传入微信端下载的图片
	static function uploadImageInWeixin($resp){
		global $_W;
		$setting = $_W['setting']['upload']['image'];
		$setting['folder'] = "images/{$_W['uniacid']}".'/'.date('Y/m/');	
		
		load()->func('file');
		if (is_error($resp)) {
			$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
			return $result;
		}
		if (intval($resp['code']) != 200) {
			$result['message'] = '提取文件失败: 未找到该资源文件.';
			return $result;
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
				return $result;
				break;
		}
		
		if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
			$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
			return $result;
		}
		$originname = pathinfo($url, PATHINFO_BASENAME);
		$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
		$pathname = $setting['folder'] . $filename;
		$fullname = ATTACHMENT_ROOT . '/' . $pathname;
		if(!is_dir(ATTACHMENT_ROOT.$setting['folder'])){
			mkdirs(ATTACHMENT_ROOT.$setting['folder']);
		}
		if (file_put_contents($fullname, $resp['content']) == false) {
			$result['message'] = '提取失败.';
			return $result;
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

		setting_load('remote');
		if (!empty($_W['setting']['remote']['type'])) {
			$remotestatus = file_remote_upload($pathname);
			if (is_error($remotestatus)) {
				$result['message'] = '远程附件上传失败，请检查配置并重新上传';
				file_delete($pathname);
				return $result;
			} else {
				file_delete($pathname);
				$info['url'] = tomedia($pathname);
			}
		}

		return $info;
	}	



	//查询模块config
	static function getModuleConfig(){
		$modulelist = uni_modules(false);
		return $modulelist[MODULE]['config'];
	}
		
	static function checkSubmit($name){
		global $_GPC;
		
		if($_GPC['mytoken'] == $_SESSION['mytoken'] && isset($_GPC[$name]) && !empty($_GPC['mytoken'])){
			unset($_SESSION['mytoken']);
			return true;
		}
		return false;
	}
	
	static function getRandom(){
		return time() . rand(10000,99999);
	}
	
	static function getRand($arg1,$arg2){
		$min = min($arg1,$arg2);
		$max = max($arg1,$arg2);
		return rand($min,$max);
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
	
	
	
	
	//删除数据库
	static function deleteData($id,$tablename){
		global $_W;
		if($id == '') return false;
		$id = intval($id);
		$datainfo = self::getSingelDataInSingleTable($tablename,array('id'=>$id));
		if (empty($datainfo)) message('数据不存在或是已经被删除！');
		
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
	
	//根据条件查询数据和
	static function countDataSum($tablename,$where,$sumstr,$str = ''){
		global $_W;
		$data = self::structWhereStringOfAnd($where);
		return pdo_fetchcolumn(" SELECT ".$sumstr." FROM " . tablename($tablename) . " WHERE $data[0] ".$str,$data[1]);
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
	static function getAllDataInSingleTable($tablename,$where,$page,$num,$order='id DESC',$iscache = false,$isNeedPager = true,$select = '*',$str='',$cachename='p'){
		global $_W;
		$data = self::structWhereStringOfAnd($where);
		
		$countStr = "SELECT COUNT(*) FROM ".tablename($tablename) ." WHERE $data[0] ";
		$selectStr = "SELECT $select FROM ".tablename($tablename) ." WHERE $data[0] ";
		$res = self::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$isNeedPager,$str,$cachename);
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
	static function fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order='`id` DESC',$iscache=false,$isNeedPager=false,$str='',$cachename='p'){
		$pindex = max(1, intval($page));
		$psize = $num;

		if($iscache){ // 缓存

			$cacheid = $countStr.$selectStr.$psize.$pindex.$order.$isNeedPager.$str;

			foreach ($params as $k => $v) {
				$cacheid .= $v;
			}
			$cacheid = md5($cacheid);
			$cache = self::getCache($cachename,$cacheid);

			if(!empty($cache[0]) && $cache['temptime'] > TIMESTAMP ) return $cache;
			
		}

		$total =  $isNeedPager?pdo_fetchcolumn($countStr.$str,$params):'';
		$data = pdo_fetchall($selectStr.$str." ORDER BY $order " . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize,$params);
		
		$pager = $isNeedPager?pagination($total, $pindex, $psize):'';

		if($iscache && !empty($data)){
			
			self::setCache($cachename,$cacheid,array($data,$pager,$total,'temptime'=>TIMESTAMP+$iscache));
		}
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
		return cache_read('zfcp:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//设置缓存
	static function setCache($key,$name,$value) {
		global $_W;
		if(empty($key) || empty($name)) return false;	
		$res = cache_write('zfcp:'.$_W['uniacid'].':'.$key.':'.$name,$value);
		return $res;
	}
	
	//删除缓存
	static function deleteCache($key,$name) {
		global $_W;		
		if(empty($key) || empty($name)) return false;
		return cache_delete('zfcp:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//删除所有缓存 每次设置参数后都要删除
	static function deleteThisModuleCache(){
		global $_W;
		$res = cache_clean('zfcp');
		return $res;
	}
	
	//创建目录
	static function mkdirs($path) {
		if (!is_dir($path)) {
			mkdir($path,0777,true);
		}
		return is_dir($path);
	}	
	
	
	//加密函数
	static function encrypt($txt) {
		srand((double)microtime() * 1000000);
		$encrypt_key = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
		   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		   $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
		}
		return base64_encode(self::passport_key($tmp));
	}

	//解密函数
	static function decrypt($txt) {
		
		$txt = self::passport_key(base64_decode($txt));
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++) {
		   $md5 = $txt[$i];
		   $tmp .= $txt[++$i] ^ $md5;
		}
		return $tmp;
	}

	static function passport_key($txt) {
		global $_W;
		$key = $_W['config']['setting']['authkey'];
		$encrypt_key = md5($key);
		$ctr = 0;
		$tmp = '';
		for($i = 0; $i < strlen($txt); $i++) {
		   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		   $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
		}
		return $tmp;
	}	
		
	

	//截取字符串,截取start-end之间的,结果不包含start和end；
	static function cut($from, $start, $end, $lt = false, $gt = false){
		$str = explode($start, $from);
		if (isset($str['1']) && $str['1'] != '') {
			$str = explode($end, $str['1']);
			$strs = $str['0'];
		} else {
			$strs = '';
		}
		if ($lt) {
			$strs = $start . $strs;
		}
		if ($gt) {
			$strs .= $end;
		}
		return $strs;
	}	
	
	//组合URL
	static function createModuleUrl($do,$array=array(),$site=''){
		global $_W;
		$str = '&do='.$do;
		if(!empty($array)){
			foreach($array as $k=>$v){
				$str .= '&'.$k.'='.$v;
			}		
		}
		$thissite = empty( $site ) ? $_W['siteroot'] : $site;
		return $thissite.'app/index.php?i='.$_W['uniacid'].'&c=entry'.$str.'&m='.MODULE;
	}

	static function webUrl($do,$array=array()){
		global $_W;
		$str = '&do='.$do;
		if(!empty($array)){
			foreach($array as $k=>$v){
				$str .= '&'.$k.'='.$v;
			}		
		}
		return $_W['siteroot'].'web/index.php?c=site&a=entry'.$str.'&m='.MODULE;
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
		
		$script = <<<EOF
	<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
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

	
static function tpl_ueditor($id, $value = '', $options = array()) {
	$s = '';
	if (!defined('TPL_INIT_UEDITOR')) {
		$s .= '<script type="text/javascript" src="../web/resource/components/ueditor/ueditor.config.js"></script><script type="text/javascript" src="../addons/zofui_countprice/admin/public/ueditor.all.js"></script><script type="text/javascript" src="../web/resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>';
	}
	$options['height'] = empty($options['height']) ? 200 : $options['height'];
	$s .= !empty($id) ? "<textarea id=\"{$id}\" name=\"{$id}\" type=\"text/plain\" style=\"height:{$options['height']}px;\">{$value}</textarea>" : '';
	$s .= "
	<script type=\"text/javascript\">
			var ueditoroption = {
				'autoClearinitialContent' : false,
				'toolbars' : [['fullscreen', 'source', 'preview', '|', 'bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', '|',
					'justifyleft', 'justifycenter', 'justifyright', '|', 'insertorderedlist', 'insertunorderedlist', 'blockquote', 'emotion', 'insertvideo',
					'link', 'removeformat', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight','indent', 'paragraph', 'fontsize', '|',
					'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol',
					'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|', 'anchor', 'map', 'print', 'drafts']],
				'elementPathEnabled' : false,
				'initialFrameHeight': {$options['height']},
				'focus' : false,
				'maximumWords' : 9999999999999
			};
			var opts = {
				type :'image',
				direct : false,
				multi : true,
				tabs : {
					'upload' : 'active',
					'browser' : '',
					'crawler' : ''
				},
				path : '',
				dest_dir : '',
				global : false,
				thumb : false,
				width : 0
			};
			UE.registerUI('myinsertimage',function(editor,uiName){
				editor.registerCommand(uiName, {
					execCommand:function(){
					util.image($('.edui-for-插入图片'), function(url){
						editor.execCommand('insertimage', {
							'src' : url.url,
							'_src' : url.attachment,
							'width' : '100%',
							'alt' : url.filename
						});
					}, {
						crop : false,
						multiple : false
					});
					}
				});
				var btn = new UE.ui.Button({
					name: '插入图片',
					title: '插入图片',
					cssRules :'background-position: -726px -77px',
					onclick:function () {
						editor.execCommand(uiName);
					}
				});
				editor.addListener('selectionchange', function () {
					var state = editor.queryCommandState(uiName);
					if (state == -1) {
						btn.setDisabled(true);
						btn.setChecked(false);
					} else {
						btn.setDisabled(false);
						btn.setChecked(state);
					}
				});
				return btn;
			}, 19);
			".(!empty($id) ? "
				$(function(){
					var ue = UE.getEditor('{$id}', ueditoroption);
					$('#{$id}').data('editor', ue);
					$('#{$id}').parents('form').submit(function() {
						if (ue.queryCommandState('source')) {
							ue.execCommand('source');
						}
					});

				});" : '')."
	</script>";
	return $s;
}

	static function single_image($name, $value) {
		
		$pic = empty( $value ) ? '' : tomedia( $value );
		$picstr = empty( $value ) ? '' : '<img src="'.$pic.'" style="width:70px;height:70px;margin-top:10px">';
		$html = <<<EOF
	<style>
	.webuploader-pick {color:#333;}
	</style>
	<div class="input-group">
		<input type="hidden" name="$name" value="$value" class="form-control" autocomplete="off" readonly="readonly">
		<a class="btn btn-default js-image-{$name}">上传图片</a>
	</div>
	<span class="images_preview">{$picstr}</span>

	<script>
		util.image($('.js-image-{$name}'), function(url){
			$('.js-image-{$name}').prev().val(url.attachment);
			$('.js-image-{$name}').parent().next().html('<img src="'+url.url+'" style="margin-top:10px" width="70px" height="70px">');
		}, {
			crop : false,
			multiple : false
		});
	</script>
EOF;
		return $html;
	}
	
	static function mult_image($name, $value = array(), $options = array()) {
		
		if (is_array($value) && count($value) > 0) {
			foreach ($value as $row) {
				$picstr .= '
	<div class="multi-item" style="width:100px;height:100px;position:relative;display: inline-block;margin: 10px 10px 10px 0;">
		<img style="width:100%" src="' . tomedia($row) . '" class="img-responsive img-thumbnail">
		<input type="hidden" name="' . $name . '[]" value="' . $row . '" >
		<em class="close" style="position:absolute;right:-10px;top:-10px" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
	</div>';
			}
		}

		$html = <<<EOF
	<style>
	.webuploader-pick {color:#333;}
	</style>
	<div class="input-group">
		<a class="btn btn-default js-image-{$name}">上传图片</a>
	</div>
	<span class="images_preview">{$picstr}</span>

	<script>
		util.image($('.js-image-{$name}'), function(url){
			$('.js-image-{$name}').parent().next().append('<div class="multi-item" style="width:100px;height:100px;position:relative;display: inline-block;margin: 10px 10px 10px 0;"><img src="'+url.url+'" style="width:100%" class="img-responsive img-thumbnail"><input type="hidden" name="{$name}[]" value="'+url.attachment+'"><em class="close" title="删除这张图片" style="position:absolute;right:-10px;top:-10px" onclick="deleteMultiImage(this)">×</em></div>');
		}, {
			crop : false,
			multiple : true
		});
		function deleteMultiImage(elm){
			$(elm).parent().remove();
		}
	</script>

EOF;
		return $html;
	}


}
	
	
