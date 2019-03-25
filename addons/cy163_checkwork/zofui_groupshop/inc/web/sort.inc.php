<?php 
	global $_W,$_GPC;
	$op = isset($_GPC['op'])?$_GPC['op']:'list';
	

	
	//添加，编辑
	if(checksubmit('addsort')){
		$_GPC = Util::trimWithArray($_GPC);
		
		$data['class'] = intval($_GPC['sorttype']);
		$data['name'] = trim($_GPC['sortname']);		
		$data['order'] = intval(trim($_GPC['sortorder']));		
		$data['parentid'] = $data['class'] == 2 ? intval($_GPC['upsort']) : 0;		
		$data['time'] = time();		
		$data['pic'] = $_GPC['pic'];
		
		if(!empty($_GPC['id'])){
			$res = pdo_update('zofui_groupshop_sort',$data,array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));		
		}else{
			$res = Util::inserData('zofui_groupshop_sort',$data);
		}
		Util::deleteCache('sort',$_GPC['id']);
		Util::deleteCache('sort','allsort');
		
		if($res) message('操作成功',referer(),'success');
	}
	

	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteDataInWeb($_GPC['checkid'],'zofui_groupshop_sort');
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}
	
	//批量排序
	if(checksubmit('suborder')){
		WebCommon::orderData($_GPC['order'],'zofui_groupshop_sort');
		message('排序更新成功！',referer(), 'success');		
	}
	
	
	$sortdata = model_sort::getAllSort();
	$allsort = $sortdata[0];	
	
	if($op == 'list'){
		$_GPC['class'] = isset($_GPC['class'])?$_GPC['class']:2;
		if($_GPC['class'] == 1) $where = array('class'=>1);
		if($_GPC['class'] == 2) $where = array('class'=>2);		

		$info = Util::getAllDataInSingleTable('zofui_groupshop_sort',$where,$_GPC['page'],8,$order='parentid DESC,`order` DESC');
		$list = $info[0];
		$pager = $info[1];
	}
	
	if($op == 'edit'){
		$id = intval($_GPC['id']);
		$info = model_sort::getSingleSort($id);
	}	
	
	if($op == 'delete'){
		$res = model_sort::deleteSort($_GPC['id']);
		if($res) message('删除成功',referer(),'success');
	}
	

	
	
	include $this->template('web/sort');