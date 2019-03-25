<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

//修改为已阅读----
$list_wyd = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_report')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and readt = '0' ORDER BY id DESC");
if (!empty($list_wyd)) {
	foreach ($list_wyd as &$row) {
		pdo_update('cwgl_user_report', array('readt' => 1), array('id' => $row['id'],'weid' => $_W['uniacid']));
	}
}//-------------

$urltk = $this->createMobileUrl('user_tallylist');

//年
$yearhtml = '';
$nowy = date('Y',mktime());
for ($i=0; $i<50; $i++) {
	$they = $nowy - $i;
	$yearhtml .= "<option value=\"$they\">$they</option>";
}

//月
$monthhtml = '';
$nowm = date('m',mktime());
for ($i=1; $i<13; $i++) {
	$selectstr = $i == $nowm ? " selected" : "";
	$monthhtml .= "<option value=\"$i\" {$selectstr}>$i</option>";
}

$op = $_GPC['op'];

//搜索
if($op == "search"){
	
	$years = intval($_GPC['years']);
	$month = intval($_GPC['month']);
	
	//年
	$yearhtml = '';
	$nowy = date('Y',mktime());
	for ($i=0; $i<100; $i++) {
		$they = $nowy - $i;
		$selectstr = $they == $years?' selected':'';
		$yearhtml .= "<option value=\"$they\" $selectstr >$they</option>";
	}
	
	//月
	$monthhtml = '';
	for ($i=1; $i<13; $i++) {
		$selectstr = $i == $month?' selected':'';
		$monthhtml .= "<option value=\"$i\" $selectstr >$i</option>";
	}
	
	
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_W['member']['uid']
	);
	
	if (!empty($years)) {
		$data['years'] = $years;
	}
	
	if (!empty($month)) {
		$data['month'] = $month;
	}
	
	//读取
	$srdb = pdo_get('cwgl_user_report', $data);
	
}	
	
include $this->template('user_tallylist');