<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');

function check_userlogin($weid,$schoolid,$openid,$userss){  //底部菜单我的冒泡
	if($userss != 1){
		$ite = pdo_fetch("SELECT id FROM " . tablename('wx_school_user') . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $userss));
		if(!empty($ite)){
			$sessionid = $ite['id'];
		}else{
			$sessionid = 2;
		}			
	}else{
		$userid = pdo_fetch("SELECT id FROM " . tablename('wx_school_user') . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid LIMIT 0,1 ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
		$sessionid = $userid['id'];	
	}
	return $sessionid;
}

function check_gx($pard){  //底部菜单我的冒泡
	if ($pard == 2){
		$gx = "妈妈";
	}
	if ($pard == 3){
		$gx = "爸爸";
	}
	if ($pard == 4){
		$gx = "";
	}
	if ($pard == 5){
		$gx = "家长";
	}
	return $gx;
}