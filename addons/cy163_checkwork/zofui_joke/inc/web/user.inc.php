<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'user';
	$_GPC['op'] = empty($_GPC['op'])? 'list' : $_GPC['op'];
	

	// 批量删除
	if( checkSubmit('deleteall') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_timeredbag_user');
		message('成功删除'.$res[0].'项','referer','success');
	}


	if($_GPC['op'] == 'list'){
		//$topbar = topbal::goodList();

		$page = intval( $_GPC['page'] );
		$where = array('uniacid'=>$_W['uniacid']);

		$info = Util::getAllDataInSingleTable('zofui_timeredbag_user',$where,$page,10,'`id` DESC',false,false);

		$list = $info[0];
		$pager = $info[1];
	}
	if( $_GPC['op'] == 'delete' ){
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleData($id,'zofui_timeredbag_user');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

	include $this->template('web/user');