<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	
	if($this->module['config']['shoptype'] == 2) die('页面不存在');
	
	$id = intval($_GPC['groupid']);
	$where = array('uniacid'=>$_W['uniacid'],'id'=>$id);
	$groupinfo = model_group::getSingleGroup($where,$id);
	if(empty($groupinfo)) message('当前团购不存在');
	$groupinfo['gstatus'] = model_group::decodeGroupStatus($groupinfo['status'],$groupinfo['overtime'],$groupinfo['isrefund'],$groupinfo['lastnumber']);
	
	
	//是否在团内
	$isingroup = model_order::getSingleOrderByStatus(array('groupid'=>$id,'openid'=>$_W['openid']),' NOT IN (1,2) ');
	
	//人员列表
	$memberdata = model_group::getGroupMemberWithCache($id);
	$member = $memberdata[0];
	
	$initParams = array(
		'op' => $_GPC['op'],
		'groupid' => $_GPC['groupid'],
		'insertelem' => '.index_goodlist',
		'sharedata' => array(
			'title' => '我正在团购一款宝贝，您也来参团吧',
			'desc' => $groupinfo['title'],
			'link' => '',
			'imgUrl' => tomedia($groupinfo['pic'][0])
		)
	);	
	$title = $groupinfo['title'];
	
	
	include $this->template('group');
?>