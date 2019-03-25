<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/

require "function_cp.php";
global $_W, $_GPC;
$srdb = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));
require "function_ck.php";
$op = $_GPC['op'];

$urlt = $this->createWebUrl('cw_config');

//保存
if(checksubmit('add_submit') || checksubmit('edit_submit')){
	
	$data = array(
		'webtitle' => $_GPC['webtitle'],
		'mb_open' => $_GPC['mb_open'],
		'mbid1' => $_GPC['mbid1'],
		'mbid2' => $_GPC['mbid2'],
		'mbid3' => $_GPC['mbid3'],
		'mbid4' => $_GPC['mbid4'],
		'mbid5' => $_GPC['mbid5'],
		'mark_words' => $_GPC['mark_words'],
		'gzh_logo' => $_GPC['gzh_logo'],
		'sms_open' => $_GPC['sms_open'],
		'sms_name' => $_GPC['sms_name'],
		'sms_password' => $_GPC['sms_password'],
		'cost_youhui1' => $_GPC['cost_youhui1'],
		'cost_youhui2' => $_GPC['cost_youhui2'],
		'cost_youhui3' => $_GPC['cost_youhui3'],
		'cost_youhui4' => $_GPC['cost_youhui4'],
		'qrcode' => $_GPC['qrcode'],
		'mbid100' => $_GPC['mbid100'],
		'ckid' => $keyok,
		'invite_open' => $_GPC['invite_open'],
		'month_money' => round($_GPC['month_money'], 2),
		'fw_message' => $_GPC['fw_message'],
		'copyright' => $_GPC['copyright']
	);
	
	//添加
	if(checksubmit('add_submit')){	
		 $data['weid'] = $_W['uniacid'];
		 $result = pdo_insert('cwgl_config', $data); 
	}
	
	//修改
	if(checksubmit('edit_submit')){
		pdo_update('cwgl_config', $data, array('weid' => $_W['uniacid']));
	}
	
	message('保存成功！', $urlt, 'success');
		
}



include $this->template('cw_config');
?>