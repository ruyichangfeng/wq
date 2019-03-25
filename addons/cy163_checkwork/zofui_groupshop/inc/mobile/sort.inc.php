<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['op'] = empty($_GPC['op']) ? ( $this->module['config']['sorttype'] <= 1 ? 'detail' : '' ) : $_GPC['op'];
	$_GPC['do'] = 'sort';
	
	//分类
	$sortdata = model_sort::getAllSort();
	$allsort = $sortdata[0];	
	

	
	$initParams = array(
		'do' => 'sort',
		'op' => $_GPC['op'],
		'forstr' => $_GPC['for'],
		'sortid' => intval( $_GPC['sortid'] ),
		'issetpage' => $this->module['config']['sorttype'] <= 1 || $_GPC['op'] == 'detail' ? 1 : 0,
		'sharedata' => array(
			'title' => '商品分类',
			'desc' => '商品分类',
			'link' => '',
			'imgUrl' => tomedia($this->module['config']['sharepic'])
		)	
	);
	
	$title = '分类';
	
	include $this->template('sort');
?>