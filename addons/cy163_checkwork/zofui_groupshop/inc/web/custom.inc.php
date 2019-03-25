<?php 
	global $_W,$_GPC;
	$op = isset($_GPC['op'])?$_GPC['op']:'list';
	
	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteDataInWeb($_GPC['checkid'],'zofui_groupshop_custom');
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}	
	
	if($op == 'toindex'){
		$id = intval($_GPC['id']);
		$page = model_custom::getSinglePage($id);
		if(empty($page)) message('请先选择页面');
		
		pdo_update('zofui_groupshop_custom',array('status'=>1),array('uniacid'=>$_W['uniacid']));
		pdo_update('zofui_groupshop_custom',array('status'=>0),array('uniacid'=>$_W['uniacid'],'id'=>$id));
		
		util::deleteCache('custompage','index');

		message('操作成功！', referer(), 'success');
		
	}
	
	//模板列表
	if($op == 'list'){
		$where['uniacid'] = $_W['uniacid'];
		$data = Util::getAllDataInSingleTable('zofui_groupshop_custom',$where,$_GPC['page'],10);
		$list = $data[0];
		$pager = $data[1];
		
		foreach($list as $k=>$v){
			$basic = iunserializer($v['basicparams']);		
			$list[$k]['pagetitle'] = $basic[0]['params']['title'];
			
		}
	
	}
	
	//添加模板
	if($op == 'add' || $op == 'edit'){
		if(!empty($_GPC['id'])){
			$page = model_custom::getSinglePage($_GPC['id']);
			
		}else{
			$page['basicparams'] = <<<div
		[{
			id:'M0',
			temp:'topbar',
			params:{
				title:'',desc:'',bgColor:'',floatico:'0',floatstyle:'right',floatwidth:'30',floattop:'30',floatimg:'',floatlink:'',totop:'1',totopimg:'',totopwidth:'50',totoptop:'80'
			}
		}]
div;
			$page['type'] = 0;
			$page['pagename'] = '默认备注名称';
		}
	}
	
	
		
	//删除
	if($op == 'delete'){
		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_groupshop_custom');
		if($res) message('删除成功！', referer(), 'success');			
	}
	
	
	
	
	include $this->template('web/custom');	