<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_binding');

$op = $_GPC['op'];

if($op=='add'){

	//生成邀请员工注册二维码

	//引入核心库文件
	require "phpqrcode.php";
	
	//定义纠错级别
	$errorLevel = "L";
	
	//定义生成图片宽度和高度;默认为3
	$size = "8";
	
	$url = $_W['siteroot'] . "app/index.php?i=".$_GPC['i']."&c=".$_GPC['c']."&m=".$_GPC['m']."&do=user_regist&jluid=".$_W['member']['uid'];
	
	$attach_dir = '../attachment/qrcode';
	if(!is_dir($attach_dir)){
		@mkdir($attach_dir, 0777);
		@fclose(fopen($attach_dir.'/index.htm', 'w'));
	}
	$imgurl = 'yqqrcode_'.$_W['member']['uid'].'_'.$errorLevel.'_'.$size.'.png';
	$filename = $attach_dir.'/'.$imgurl;
	QRcode::png($url, $filename, $errorLevel, $size, 2);
	
	if (file_exists($filename)) {
	    $qrcode_url = "qrcode/".$imgurl;
		pdo_update('cwgl_user_list', array('qrcode_url' => $qrcode_url), array('weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
		
		message('生成成功！', $urltk, 'success');
	} else {
		message('生成/更新失败！', $urltk, 'error');
	}
	
}elseif($op=='addpp'){
	
	//生成邀请码
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_employees')."  WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}'");
	if($total > 2){
		if($_GPC['tg']==1){
			message('抱歉！您最多能生成3个邀请！', $urltk.'&op=code', 'error');
		}else{
			message('抱歉！您最多能生成3个邀请！', $urltk, 'error');	
		}
	}
	
	$nub = 3 - $total;
	
	for($i=0;$i < $nub; $i++){
		 $code = random(6, 1);
		 pdo_insert('cwgl_user_employees', array('uid' => $_W['member']['uid'],'weid' => $_W['uniacid'],'code' => $code));
	}
	
	message('生成成功！', $urltk.'&op=code', 'success');
	
}elseif($op=='code'){
	
	//员工管理
	$list_empl = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_employees')."  WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' ORDER BY id DESC");
	include $this->template('user_binding_code');
	
}elseif($op == 'delete'){

	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_employees', array('id' => $id,'weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
		message('删除成功', $urltk.'&op=code', 'success');
	}else{
		message('删除失败', $urltk.'&op=code', 'success');
	}
	
}else{
	include $this->template('user_binding');
}