<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	
	$good = model_good::getSingleGood(intval($_GPC['id']));
	
	$good['rulearray'] = model_good::decodeGoodRule($good['rulearray']);
	$slide = $good['pic'];
	
	if($good['isshowgroup'] == 1 && empty($_GPC['groupid'])){

		$where = array('uniacid'=>$_W['uniacid'],'gid'=>intval($_GPC['id']),'status'=>1,'overtime>'=>time());
		$select = ' a.id,a.lastnumber,a.overtime,b.nickname,b.headimgurl ';
		$data = model_group::getLatelyGroup($where,'',1,2,$select,' a.`id` DESC ',false);
		$group = $data[0];
	}
	
	$commentnumber = model_good::getGoodCommentNumber(intval($_GPC['id']));
	
	$initParams = array(
		'op' => $_GPC['op'],
		'groupid' => $_GPC['groupid'],
		'insertelem' => '.index_goodlist',
		'deal'=>$_GPC['deal'],
		'sharedata' => array(
			'title' => $good['title'],
			'desc' => $good['descrip'],
			'link' => '',
			'imgUrl' => tomedia($slide[0])
		)
	);
	$title = $good['title'];
	
	include $this->template('good');
?>