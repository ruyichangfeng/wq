<?php
/**
 * 微教育模块
 *QQ：332035136
 * @author 高贵血迹
 */
function p($data)
{
	echo '<pre>';
	print_r($data);
}
function mload()
{
	static $mloader;
	if (empty($mloader)) {
		$mloader = new Mloader();
	}
	return $mloader;
}

class Mloader
{
	private $cache = array();
	function func($name)
	{
		if (isset($this->cache['func'][$name])) {
			return true;
		}
		$file = IA_ROOT . '/addons/fm_jiaoyu/function/' . $name . '.func.php';
		if (file_exists($file)) {
			include $file;
			$this->cache['func'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Helper Function /addons/fm_jiaoyu/function/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	function model($name)
	{
		if (isset($this->cache['model'][$name])) {
			return true;
		}
		$file = IA_ROOT . '/addons/fm_jiaoyu/model/' . $name . '.mod.php';
		if (file_exists($file)) {
			include $file;
			$this->cache['model'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Model /addons/fm_jiaoyu/model/' . $name . '.mod.php', E_USER_ERROR);
			return false;
		}
	}
	function classs($name)
	{
		if (isset($this->cache['class'][$name])) {
			return true;
		}
		$file = IA_ROOT . '/addons/fm_jiaoyu/class/' . $name . '.class.php';
		if (file_exists($file)) {
			include $file;
			$this->cache['class'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Class /addons/fm_jiaoyu/class/' . $name . '.class.php', E_USER_ERROR);
			return false;
		}
	}
}

function sub_day($staday)
{
	$value = TIMESTAMP - $staday;
	if ($value < 0) {
		return '';
	} elseif ($value >= 0 && $value < 59) {
		return $value + 1 . "秒";
	} elseif ($value >= 60 && $value < 3600) {
		$min = intval($value / 60);
		return $min . " 分钟";
	} elseif ($value >= 3600 && $value < 86400) {
		$h = intval($value / 3600);
		return $h . " 小时";
	} elseif ($value >= 86400 && $value < 86400 * 30) {
		$d = intval($value / 86400);
		return intval($d) . " 天";
	} elseif ($value >= 86400 * 30 && $value < 86400 * 30 * 12) {
		$mon = intval($value / (86400 * 30));
		return $mon . " 月";
	} else {
		$y = intval($value / (86400 * 30 * 12));
		return $y . " 年";
	}
}

function register_jssdks($debug = false){
	
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

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
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
		'getLocalImgData',
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
		'openCard'
	];
	
	wx.config(jssdkconfig);
	
</script>
EOF;
	echo $script;
}

function tpl_form_field_fans($name, $value = array('openid' => '', 'nickname' => '', 'avatar' => ''))
{
	global $_W;
	if (empty($default)) {
		$default = './resource/images/nopic.jpg';
	}
	$s = '';
	if (!defined('TPL_INIT_TINY_FANS')) {
		$s = '
				<script type="text/javascript">
					function showFansDialog(elm) {
						var btn = $(elm);
						var openid = btn.parent().prev();
						var avatar = btn.parent().prev().prev();
						var nickname = btn.parent().prev().prev().prev();
						var img = btn.parent().parent().next().find("img");
						tiny.selectfan(function(fans){
							if(fans.tag.avatar){
								if(img.length > 0){
									img.get(0).src = fans.tag.avatar;
								}
								openid.val(fans.openid);
								avatar.val(fans.tag.avatar);
								nickname.val(fans.nickname);
							}
						});
					}
				</script>';
		define('TPL_INIT_TINY_FANS', true);
	}
	$s .= '
			<div class="input-group">
				<input type="text" name="' . $name . '[nickname]" value="' . $value['nickname'] . '" class="form-control" readonly>
				<input type="hidden" name="' . $name . '[avatar]" value="' . $value['avatar'] . '">
				<input type="hidden" name="' . $name . '[openid]" value="' . $value['openid'] . '">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="showFansDialog(this);">选择粉丝</button>
				</span>
			</div>
			<div class="input-group" style="margin-top:.5em;">
				<img src="' . $value['avatar'] . '" onerror="this.src=\'' . $default . '\'; this.title=\'头像未找到.\'" class="img-responsive img-thumbnail" width="150" />
			</div>';
	return $s;
}
function ifile_put_contents($filename, $data)
{
	global $_W;
	$filename = MODULE_ROOT . '/' . $filename;
	mkdirs(dirname($filename));
	file_put_contents($filename, $data);
	@chmod($filename, $_W['config']['setting']['filemode']);
	return is_file($filename);
}

function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon)
{
	$fEARTH_RADIUS = 6378137;
	$fRadLon1 = deg2rad($fP1Lon);
	$fRadLon2 = deg2rad($fP2Lon);
	$fRadLat1 = deg2rad($fP1Lat);
	$fRadLat2 = deg2rad($fP2Lat);
	$fD1 = abs($fRadLat1 - $fRadLat2);
	$fD2 = abs($fRadLon1 - $fRadLon2);
	$fP = pow(sin($fD1 / 2), 2) + cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2 / 2), 2);
	return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
}

function sys_delivery_config($uniacid = 0)
{
	global $_W;
	$uniacid = intval($uniacid);
	if (!$uniacid) {
		$uniacid = $_W['uniacid'];
	}
	$config = pdo_get('tiny_wmall_delivery_config', array('uniacid' => $uniacid));
	if (empty($config)) {
		$config = array('delivery_type' => 1, 'store_fee_type' => 1, 'store_fee' => 0, 'delivery_fee_type' => 1, 'delivery_fee' => 0, 'get_cash_fee_limit' => 1, 'get_cash_fee_rate' => 0, 'get_cash_fee_min' => 0, 'get_cash_fee_max' => 0);
	}
	return $config;
}


// 只需调用函数 并传参2即可
// echo getRandomString(2);
// 如果仅仅是生成小写字母你可以使用类似方法

// echo chr(mt_rand(65, 90);
// 大写字母

// echo chr(mt_rand(97, 122));
function getRandomString($len, $chars=null){
    if (is_null($chars)){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    }  
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
        $str .= $chars[mt_rand(0, $lc)];  
    }
    return $str;
}

function get_mylist($schoolid,$id,$type){
	if($type == 'teacher'){
		$bjlist = pdo_fetchall("SELECT id,bj_id,km_id FROM ".tablename('wx_school_user_class')." WHERE tid = :tid And schoolid = :schoolid ", array(':tid' => $id,':schoolid' => $schoolid));
	}
	if($type == 'student'){
		$bjlist = pdo_fetchall("SELECT id,bj_id,km_id FROM ".tablename('wx_school_user_class')." WHERE sid = :sid And schoolid = :schoolid ", array(':sid' => $id,':schoolid' => $schoolid));
	}
	foreach($bjlist as $key =>$row){
		if(!empty($row['bj_id'])){
			$bjinfo = pdo_fetch("SELECT sname,parentid FROM ".tablename('wx_school_classify')." WHERE sid = :sid ", array(':sid' => $row['bj_id']));
			$xqinfo = pdo_fetch("SELECT sname FROM ".tablename('wx_school_classify')." WHERE sid = :sid ", array(':sid' => $bjinfo['parentid']));
			$bjlist[$key]['xq_id'] = $bjinfo['parentid'];
			$bjlist[$key]['xqname'] = $xqinfo['sname'];
			$bjlist[$key]['bjname'] = $bjinfo['sname'];
		}
		if(!empty($row['km_id'])){	
			$kminfo = pdo_fetch("SELECT sname FROM ".tablename('wx_school_classify')." WHERE sid = :sid ", array(':sid' => $row['km_id']));
			$bjlist[$key]['kmname'] = $kminfo['sname'];
		}
	}	
	return $bjlist;
}

function get_myschool($weid,$openid){ //查询老师所有授课学校
	$list = pdo_fetchall("SELECT schoolid FROM " . tablename('wx_school_user') . " where  weid = :weid And openid = :openid And sid = :sid ", array(':weid' => $weid,':openid' => $openid,':sid' => 0));	
	foreach($list as $key =>$row){
		if(!empty($row['schoolid'])){
			$school = pdo_fetch("SELECT title,logo FROM ".tablename('wx_school_index')." WHERE id = :id ", array(':id' => $row['schoolid']));
			$list[$key]['schoolname'] = $school['title'];
			$list[$key]['schoolicon'] = $school['logo'];
		}		
	}
	return $list;
}

function get_myallclass($weid,$openid){ //查询绑定学生所有班级信息（包含其他学校）
	$user = pdo_fetchall("SELECT id,sid FROM " . tablename('wx_school_user') . " where :weid = weid And :openid = openid And :tid = tid", array(
			':weid' => $weid,
			':openid' => $openid,
			':tid' => 0
	));
	foreach($user as $key => $row){
		$student = pdo_fetch("SELECT id,s_name,schoolid,bj_id FROM " . tablename('wx_school_students') . " where id=:id ", array(':id' => $row['sid']));
		$bajinam = pdo_fetch("SELECT sname FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $student['bj_id']));
		$user[$key]['s_name'] = $student['s_name'];
		$user[$key]['bjname'] = $bajinam['sname'];
		$user[$key]['sid'] = $student['id'];  
		$user[$key]['schoolid'] = $student['schoolid'];
	}
	return $user;
}

function check_bj($tid,$bj_id){ //检查当前班级是否属于本年级管辖且是否为年级主任
	$class = pdo_fetch("SELECT parentid FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $bj_id));
	$status = false;
	if(!empty($class['parentid'])){
		$nianji = pdo_fetch("SELECT tid FROM " . tablename('wx_school_classify') . " where sid = :sid ", array(':sid' => $class['parentid']));
		if($tid == $nianji['tid']){
			$status = true;
		}
	}
	return $status;
}

function get_weidset($weid,$name){
	$item = pdo_fetch("SELECT $name FROM ".tablename('wx_school_set')." WHERE :weid = weid ", array(':weid' => $weid));
	$set = unserialize($item[$name]);	
	return $set;
}

function get_school_sms_rest($schoolid){
	$item = pdo_fetch("SELECT sms_rest_times FROM ".tablename('wx_school_index')." WHERE :id = id ", array(':id' => $schoolid));	
	if ($item['sms_rest_times'] == 0) {
		return false;
	}else{
		return true;
	}
}

function get_school_sms_set($schoolid){
	$item = pdo_fetch("SELECT sms_set FROM ".tablename('wx_school_index')." WHERE :id = id ", array(':id' => $schoolid));
	$set = unserialize($item['sms_set']);	
	return $set;
}

function isallow_sendsms($schoolid,$type){//综合判断是否发送短信
	$item = pdo_fetch("SELECT weid,sms_set,sms_rest_times FROM ".tablename('wx_school_index')." WHERE :id = id ", array(':id' => $schoolid));
	$school_sms_set = unserialize($item['sms_set']);
	$smsset = get_weidset($item['weid'],$type);
	if(!empty($smsset['sms_SignName']) && !empty($smsset['sms_Code']) && $school_sms_set[$type] == 1 && $item['sms_rest_times'] > 0){
		return true;
	}else{
		return false;
	}
}

function check_verifycode($mobile, $code, $weid){
	$bdset = get_weidset($weid,'bd_set');
	$thiscode = pdo_fetch("SELECT createtime FROM ".tablename('uni_verifycode')." WHERE uniacid = :uniacid And receiver = :receiver And verifycode = :verifycode ", array(':uniacid' => $weid, ':receiver' => $mobile, ':verifycode' => $code));
	$resttime = empty($bdset['code_time']) ? 1800 : intval($bdset['code_time']);
	$duibi = TIMESTAMP - $thiscode['createtime'];
	if($duibi < $resttime) {
		return true;
	}else{
		return false;
	}
}

function need_guid($userid,$schoolid,$type){ //检查是否设置新手引导
	global $_W;
	$guids = pdo_fetchall("SELECT id,arr,begintime,endtime FROM " . tablename('wx_school_banners') . " WHERE enabled = 1 And weid = '{$_W['uniacid']}' And place = $type ORDER BY id ASC");
	$user = pdo_fetch("SELECT is_frist FROM ".tablename('wx_school_user')." WHERE :id = id ", array(':id' => $userid));
	foreach($guids as $key => $row){
		$uniarr = explode(',',$row['arr']);
		$is = unarr($uniarr,$schoolid);
		if ($is && TIMESTAMP >= $row['begintime'] && TIMESTAMP < $row['endtime']) {
			$guid = $row['id'];
		}		
	}
	if(!empty($guid) && $user['is_frist'] == 1){
		return $guid;
	}
}

function unarr($uniarr, $id) {
	foreach ($uniarr as $key => $value) {
		if ($id == $value) {
			return true;
		}
	}
	return false;
}

function getvisitorsip(){
	$visitorsip = pdo_fetch("SELECT * FROM ".tablename('wx_school_classify')." WHERE :type = type ", array(':type' => 'thevideos'));
	return $visitorsip['video1'];
}

function getoauthurl(){
	$oauthurl = $_SERVER ['HTTP_HOST'];
	return $oauthurl;
}

function getpard($pard){
	if($pard == 0){
		$jsr  = "";
	}
	if($pard == 1){
		$jsr  = "";
	}
	if($pard == 2){
		$jsr  = "妈妈";
	}
	if($pard == 3){
		$jsr  = "爸爸";
	}
	if($pard == 4){
		$jsr  = "爷爷";
	}
	if($pard == 5){
		$jsr  = "奶奶";
	}
	if($pard == 6){
		$jsr  = "外公";
	}
	if($pard == 7){
		$jsr  = "外婆";
	}
	if($pard == 8){
		$jsr  = "叔叔";
	}
	if($pard == 9){
		$jsr  = "阿姨";
	}
	if($pard == 10){
		$jsr  = "其他家长";
	}
	if($pard == 11){
		$jsr  = "-老师代签";
	}
    return $jsr;
}

function getpardforkqj($pard){
	if($pard == 1){
		$jsr  = "学生";
	}
	if($pard == 2){
		$jsr  = "妈妈";
	}
	if($pard == 3){
		$jsr  = "爸爸";
	}
	if($pard == 4){
		$jsr  = "爷爷";
	}
	if($pard == 5){
		$jsr  = "奶奶";
	}
	if($pard == 6){
		$jsr  = "外公";
	}
	if($pard == 7){
		$jsr  = "外婆";
	}
	if($pard == 8){
		$jsr  = "叔叔";
	}
	if($pard == 9){
		$jsr  = "阿姨";
	}
	if($pard == 10){
		$jsr  = "家长";
	}
    return $jsr;
}

function get_teacher($pard){
	if($pard == 1){
		$jsr  = "老师";
	}
	if($pard == 2){
		$jsr  = "校长";
	}
	if($pard == 3){
		$jsr  = "主任";
	}
    return $jsr;
}

function get_guanxi($pard){ //获取用户绑定时候选定关系称谓
	if($pard == 2){
		$jsr  = "妈妈";
	}
	if($pard == 3){
		$jsr  = "爸爸";
	}
	if($pard == 4){
		$jsr  = "";
	}
	if($pard == 5){
		$jsr  = "家长";
	}	
    return $jsr;
}

function CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps)
{
    $FullHttpUrl = $HttpUrl."/v2/index.php";

    /***************对请求参数 按参数名 做字典序升序排列，注意此排序区分大小写*************/
    $ReqParaArray = array_merge($COMMON_PARAMS, $PRIVATE_PARAMS);
    ksort($ReqParaArray);

    /**********************************生成签名原文**********************************
     * 将 请求方法, URI地址,及排序好的请求参数  按照下面格式  拼接在一起, 生成签名原文，此请求中的原文为 
     * GETcvm.api.qcloud.com/v2/index.php?Action=DescribeInstances&Nonce=345122&Region=gz
     * &SecretId=AKIDz8krbsJ5yKBZQ1pn74WFkmLPx3gnPhESA&Timestamp=1408704141
     * &instanceIds.0=qcvm12345&instanceIds.1=qcvm56789
     * ****************************************************************************/
    $SigTxt = $HttpMethod.$FullHttpUrl."?";

    $isFirst = true;
    foreach ($ReqParaArray as $key => $value)
    {
        if (!$isFirst) 
        { 
            $SigTxt = $SigTxt."&";
        }
        $isFirst= false;

        /*拼接签名原文时，如果参数名称中携带_，需要替换成.*/
        if(strpos($key, '_'))
        {
            $key = str_replace('_', '.', $key);
        }

        $SigTxt=$SigTxt.$key."=".$value;
    }

    /*********************根据签名原文字符串 $SigTxt，生成签名 Signature******************/
    $Signature = base64_encode(hash_hmac('sha1', $SigTxt, $secretKey, true));


    /***************拼接请求串,对于请求参数及签名，需要进行urlencode编码********************/
    $Req = "Signature=".urlencode($Signature);
    foreach ($ReqParaArray as $key => $value)
    {
        $Req=$Req."&".$key."=".urlencode($value);
    }

    /*********************************发送请求********************************/
    if($HttpMethod === 'GET')    {
        if($isHttps === true) {
            $Req="https://".$FullHttpUrl."?".$Req;
        }else{
            $Req="http://".$FullHttpUrl."?".$Req;
        }

        $Rsp = file_get_contents($Req);

    }else{
        if($isHttps === true)
        {
            $Rsp= SendPost("https://".$FullHttpUrl,$Req,$isHttps);
        }
        else
        {
            $Rsp= SendPost("http://".$FullHttpUrl,$Req,$isHttps);
        }
    }
    return(json_decode($Rsp,true));
}

function SendPost($FullHttpUrl,$Req,$isHttps){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $Req);

	curl_setopt($ch, CURLOPT_URL, $FullHttpUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if ($isHttps === true) {
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
	}
	$result = curl_exec($ch);
	return $result;
}

function upload_file_to_cdn($data,$host){
    $ch = curl_init();
	$oauthurl = getoauthurl();
	$url = 'http://www.daren007.com/api/amr.php?type=amr&oauthurl='.$oauthurl.'&host='.$host;	
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		$postdata = array (
			"upload" => new CURLFile(realpath($data))
		);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
	}else{
		$postdata = array (
		  "upload" => "@".$data
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		$response = curl_exec($ch);
	}
	return $response;
}

function delvioce($data,$host){
    $ch = curl_init();
	$oauthurl = getoauthurl();
	$url = 'http://www.daren007.com/api/amr.php?type=delamr&oauthurl='.$oauthurl.'&mp3name='.$data.'&host='.$host;
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
	}else{
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		$response = curl_exec($ch);
	}
	return $response;
}

function delcheckpic($name){
    $ch = curl_init();
	$oauthurl = getoauthurl();
    $post_data = array (
		"checkpic" => $name
    );	
	$url = 'http://www.daren007.com/api/amr.php?type=delcheckpic&oauthurl='.$oauthurl;
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}else{
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}
	return true;
}

function opreatmac($macid,$mactype,$posturl,$type,$schoolname){
    $ch = curl_init();
    $post_data = array (
		"type" => $type,
		"mactype" => $mactype,
		"macid" => $macid,
		"schoolname" => $schoolname,
		"posturl" => $posturl
    );
	$oauthurl = getoauthurl();
	if($oauthurl){$url = 'http://www.daren007.com/api/mac.php?oauthurl='.$oauthurl;}
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}else{
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
	}	
	return $response;
}

function getImg($picurl){
	$ch=curl_init();
	$timeout=5;
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}else{
		curl_setopt($ch, CURLOPT_URL, $picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}	
	delcheckpic($picurl);
	return $img;
}

function getimg_form_oss($picurl){
	$ch=curl_init();
	$timeout=5;
	if(version_compare(PHP_VERSION,'5.5.0','>=')){
		curl_setopt($ch, CURLOPT_URL,$picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}else{
		curl_setopt($ch, CURLOPT_URL, $picurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img=curl_exec($ch);
		curl_close($ch);		
	}	
	return $img;
}
