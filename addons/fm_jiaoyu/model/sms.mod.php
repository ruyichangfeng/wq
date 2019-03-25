<?php
/**
 * 微教育模块
 *QQ：332035136
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');

function sms_send($mobile, $content, $sms_SignName, $sms_templte, $type, $weid, $schoolid) {
	include IA_ROOT.'/addons/fm_jiaoyu/inc/func/api_sdk/aliyun-php-sdk-core/Config.php';
	include_once IA_ROOT.'/addons/fm_jiaoyu/inc/func/api_sdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
	include_once IA_ROOT .'/addons/fm_jiaoyu/inc/func/api_sdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';    
    $bdset = get_weidset($weid,'sms_acss');
    $accessKeyId = $bdset['accessKeyId'];
    $accessKeySecret = $bdset['accessKeySecret'];
    //短信API产品名
    $product = "Dysmsapi";
    //短信API产品域名
    $domain = "dysmsapi.aliyuncs.com";
    //暂时不支持多Region
    $region = "cn-hangzhou";
    
    //初始化访问的acsCleint
    $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
    $acsClient= new DefaultAcsClient($profile);
    $request = new Dysmsapi\Request\V20170525\SendSmsRequest;
    //必填-短信接收号码
    $request->setPhoneNumbers($mobile);
    //必填-短信签名
    $request->setSignName($sms_SignName);
    //必填-短信模板Code
    $request->setTemplateCode($sms_templte);
    //选填-假如模板中存在变量需要替换则为必填(JSON格式)
    $request->setTemplateParam(json_encode($content));
    //选填-发送短信流水号
    //$request->setOutId("1234");
    
    //发起访问请求
    $acsResponse = $acsClient->getAcsResponse($request);
		
	//$result = @json_decode($acsResponse, true);
	$Code = ($acsResponse->Code);
	$Message = ($acsResponse->Message);
	if($Code == 'OK') {
		$status = 1;
		sms_insert_send_log($schoolid, $type, $mobile, $weid, $status, 'OK');
	}else{
		$status = 2;
		sms_insert_send_log($schoolid, $type, $mobile, $weid, $status, $Message);		
	}
	$data['Code'] = $Code;
	$data['Message'] = $Message;
	return $data;
}

function sms_insert_send_log($schoolid, $type, $mobile, $weid, $status, $msg) {
	if(!empty($schoolid)){
		pdo_query('update ' . tablename('wx_school_index') . ' set sms_use_times = sms_use_times + 1 where id = :id', array(':id' => $schoolid));
		pdo_query('update ' . tablename('wx_school_index') . ' set sms_rest_times = sms_rest_times - 1 where id = :id', array(':id' => $schoolid));
	}else{
		pdo_query('update ' . tablename('wx_school_set') . ' set sms_use_times = sms_use_times + 1 where weid = :weid', array(':weid' => $weid));
	}
	$data = array(
		'weid' => $weid,
		'schoolid' => $schoolid,
		'type' => $type,
		'mobile' => $mobile,
		'sendtime' => TIMESTAMP,
	);
	if($status == 1){
		$data['status'] = 1;
		$data['msg'] = 'OK';
	}else{
		$data['status'] = 2;
		$data['msg'] = $msg;
	}	
	pdo_insert('wx_school_sms_log', $data);
	return true;
}

function sms_types($type) {
	$types = array(
		'code' 		=> '手机验证码',
		'bmshtz' 	=> '报名审核提醒',
		'fzqdshjg'  => '微信签到审核结果',
		'signshtz' 	=> '微信签到审核提醒',
		'bmshjgtz' 	=> '报名审核结果通知',
		'bjqshtz' 	=> '班级圈审核提醒',
		'bjqshjg' 	=> '班级圈审核结果通知',
		'zuoye' 	=> '作业群发通知',
		'bjtz' 		=> '班级通知',
		'xsqingjia' => '学生请假提醒',
		'xsqjsh'	=> '学生请假审核提醒',
		'liuyan' 	=> '家长或学生留言',
		'liuyanhf'  => '教师回复家长留言',
		'lyhf' 		=> '通讯录私聊',
		'jsqingjia' => '教师请假提醒',
		'jsqjsh' 	=> '教师请假结果提醒',
		'jxlxtx' 	=> '进校离校提醒',
	);
	return $types[$type];
}
