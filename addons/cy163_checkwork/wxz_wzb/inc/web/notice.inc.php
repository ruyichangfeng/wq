<?php

global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
load()->model('cache');
$rid = intval($_GPC['rid']);
$id = intval($_GPC['id']);
$result = cache_load('notice');

$setting = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_notice')." WHERE id=:id",array(':id'=>$id));

if (checksubmit('submit')) {
	$data = array();
	$data['template_id'] = $_GPC['template_id'];
	$data['uniacid'] = $_W['uniacid'];
	$data['rid'] = $_GPC['rid'];
	$data['type'] = $_GPC['type'];
	$data['images'] = $_GPC['images'];
	$data['status'] = $_GPC['status'];
	$data['timeType'] = $_GPC['timeType'];
	$data['timer'] = strtotime($_GPC['timer']);
	$data['firstvalue'] = $_GPC['firstvalue'];
	$data['firstcolor'] = $_GPC['firstcolor'];
	$data['keyword1value'] = $_GPC['keyword1value'];
	$data['keyword1color'] = $_GPC['keyword1color'];
	$data['keyword2value'] = $_GPC['keyword2value'];
	$data['keyword2color'] = $_GPC['keyword2color'];
	$data['keyword3value'] = $_GPC['keyword3value'];
	$data['keyword3color'] = $_GPC['keyword3color'];
	$data['remarkvalue'] = $_GPC['remarkvalue'];
	$data['remarkcolor'] = $_GPC['remarkcolor'];
	$data['os'] = $_GPC['os'];
	$data['url'] = $_W['siteroot'] . 'app' . substr(substr($this->createMobileUrl('index2',array('rid'=>$rid,'uniacid'=>$_W['uniacid'])), 1), 0);
	$data['dateline'] = time();

	if(!empty($setting)){
		pdo_update('wxz_wzb_notice',$data,array('id'=>$setting['id']));
		$id = $setting['id'];
		$result[$id] = $data['timer'];
		cache_write('notice', $result);
		message('编辑成功',$this->createWebUrl('noticelist',array('rid'=>$rid)),'success');
	}else{
		pdo_insert('wxz_wzb_notice',$data);
		$id = pdo_insertid();
		$result[$id] = $data['timer'];

		cache_write('notice', $result);
		message('新增成功',$this->createWebUrl('noticelist',array('rid'=>$rid)),'success');
	}
	
}


include $this->template('notice');