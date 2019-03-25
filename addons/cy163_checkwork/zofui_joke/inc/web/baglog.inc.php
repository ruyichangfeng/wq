<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'baglog';
	$_GPC['op'] = empty($_GPC['op'])? 'send' : $_GPC['op'];
	
	
	// 批量删除
	if( checkSubmit('deleteallsend') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_timeredbag_redbag');
		message('成功删除'.$res[0].'项','referer','success');
	}
	//
	if( checkSubmit('deleteallget') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_timeredbag_taobag');
		message('成功删除'.$res[0].'项','referer','success');
	}
	//
	if( checkSubmit('deleteallpayget') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_timeredbag_order');
		message('成功删除'.$res[0].'项','referer','success');
	}	
	//
	if( checkSubmit('deleteallling') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_timeredbag_linglog');
		message('成功删除'.$res[0].'项','referer','success');
	}	

	if($_GPC['op'] == 'send'){
		//$topbar = topbal::goodList();

		$page = intval( $_GPC['page'] );
		$where = array('status>'=>0.1);

		$order='`id` DESC';

		$select =  model_user::isOauth() ?  ' a.*,b.headimgurl,b.nickname ' : ' a.*,b.tag,b.nickname ';
		$info = model_redbag::getAllredbag($where,$page,10,$order,false,true,$select);
		$list = $info[0];

		

		$pager = $info[1];
	}

	if( $_GPC['op'] == 'deletesend' ){
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleData($id,'zofui_timeredbag_redbag');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

	if( $_GPC['op'] == 'sendinfo' ){
		$id = intval($_GPC['id']);

		$red = pdo_get('zofui_timeredbag_redbag',array('uniacid'=>$_W['uniacid'],'id'=>$id));
		$order = pdo_get('zofui_timeredbag_order',array('uniacid'=>$_W['uniacid'],'thisid'=>$id,'type'=>1));

		$user = model_user::getSingleUser($red['openid']);

	}

/*收红包*/
	if($_GPC['op'] == 'get'){
		//$topbar = topbal::goodList();

		$page = intval( $_GPC['page'] );
		$where = array('uniacid'=>$_W['uniacid']);

		$order='`id` DESC';
		
		$select =  model_user::isOauth() ?  ' a.*,b.headimgurl,b.nickname ' : ' a.*,b.tag,b.nickname ';
		$info = model_taobag::getAlltaobag($where,$page,10,$order,false,true,$select);
		$list = $info[0];
		$pager = $info[1];
	}
	if( $_GPC['op'] == 'deleteget' ){
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleData($id,'zofui_timeredbag_taobag');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

/*支付收红包*/
	if($_GPC['op'] == 'payget'){
		//$topbar = topbal::goodList();

		$page = intval( $_GPC['page'] );
		$where = array('uniacid'=>$_W['uniacid']);

		$where['status'] = 1;
		$where['type'] = 2;
		$order=' a.`id` DESC ';

		if( !empty( $_GPC['redid'] ) ) $where['thisid'] = intval( $_GPC['redid'] );

		$select =  model_user::isOauth() ?  ' a.*,b.headimgurl,b.nickname ' : ' a.*,b.tag,b.nickname ';
		$info = model_order::getAllPaylog($where,$page,10,$order,false,true,$select);
		$list = $info[0];
		$pager = $info[1];
	}

	if( $_GPC['op'] == 'deletepayget' ){
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleData($id,'zofui_timeredbag_order');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}	

/*领取记录*/
	if($_GPC['op'] == 'ling'){
		//$topbar = topbal::goodList();

		$page = intval( $_GPC['page'] );
		$where = array('uniacid'=>$_W['uniacid']);

		if( !empty( $_GPC['redid'] ) ) $where['redbagid'] = intval( $_GPC['redid'] );
		
		$order=' a.`id` DESC ';
		
		$select =  model_user::isOauth() ?  ' a.*,b.headimgurl,b.nickname ' : ' a.*,b.tag,b.nickname ';
		$info = model_linglog::getAllLinglog($where,$page,10,$order,false,true,$select);
		$list = $info[0];
		$pager = $info[1];
	}
	if( $_GPC['op'] == 'deleteling' ){
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleData($id,'zofui_timeredbag_linglog');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

	include $this->template('web/baglog');