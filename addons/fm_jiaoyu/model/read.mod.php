<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');

function check_readtype($weid,$schoolid,$openid,$noticeid){
	$thisuser = pdo_fetch("SELECT id,sid FROM " . tablename('wx_school_user') . " where id = :id ", array(':id' => $openid));
	$recode = pdo_fetch("SELECT readtime FROM ".tablename('wx_school_record')." WHERE sid = '{$thisuser['sid']}' And userid = '{$thisuser['id']}' And noticeid = '{$noticeid}'");
	if($recode){
		if ($recode['readtime'] != 0){
			$readtype = 1;
		}else{
			$readtype = 2;
		}
	}else{
		$readtype = 2;
	}
	return $readtype;
}

function check_unread($userid){  //底部菜单我的冒泡
	$it = pdo_fetch("SELECT id,sid FROM " . tablename('wx_school_user') . " where id = :id ", array(':id' => $userid));
	$rest = pdo_fetch("SELECT id FROM ".tablename('wx_school_order')." WHERE sid = '{$it['sid']}' And status = '1' ");
	$restleave = pdo_fetch("SELECT id FROM ".tablename('wx_school_leave')." WHERE sid = '{$it['sid']}' And touserid = '{$it['id']}' And isread = 1 And isliuyan = 2 ");
	$resttz = pdo_fetch("SELECT id FROM ".tablename('wx_school_record')." WHERE sid = '{$it['sid']}' And type = 1 And readtime = 0 And userid = '{$it['id']}' ");
	$restzy = pdo_fetch("SELECT id FROM ".tablename('wx_school_record')." WHERE sid = '{$it['sid']}' And type = 2 And readtime = 0 And userid = '{$it['id']}' ");
	if ($resttz['id'] || $restzy['id'] || $rest['id'] || $restleave['id']){
		$unread = 1;
	}else{
		$unread = 2;
	}
	return $unread;
}
