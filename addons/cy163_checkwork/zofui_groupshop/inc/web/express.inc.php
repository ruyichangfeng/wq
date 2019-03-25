<?php 
	global $_W,$_GPC;
	$op = isset($_GPC['op'])?$_GPC['op']:'list';
	

	
	//添加，编辑
	if(checksubmit('addexpress')){
		$_GPC = Util::trimWithArray($_GPC);
		
		$data['name'] = htmlspecialchars($_GPC['expressname']);
		$data['defaultnum'] = intval($_GPC['defaultnum']);
		$data['defaultmoney'] = sprintf('%.2f',$_GPC['defaultmoney']);
		$data['defaultnumex'] = intval($_GPC['defaultnumex']);
		$data['defaultmoneyex'] = sprintf('%.2f',$_GPC['defaultmoneyex']);	
		
		if(!empty($_GPC['express']['area']) && is_array($_GPC['express']['area'])){
			foreach($_GPC['express']['area'] as $k=>$v){
				$expressarray[] = array(
					'area'=>$v,
					'num'=> intval($_GPC['express']['num'][$k]),
					'money'=>sprintf('%.2f',$_GPC['express']['money'][$k]),
					'numex'=>intval($_GPC['express']['numex'][$k]),
					'moneyex'=>sprintf('%.2f',$_GPC['express']['moneyex'][$k])
				);
			}
		}
		
		$data['expressarray'] = iserializer($expressarray);
		$data['time'] = time();		
		
		if(!empty($_GPC['id'])){
			$id = intval($_GPC['id']);
			$res = pdo_update('zofui_groupshop_express',$data,array('uniacid'=>$_W['uniacid'],'id'=>$id));	
			Util::deleteCache('express',$id);			
		}else{
			$res = Util::inserData('zofui_groupshop_express',$data);
		}
		Util::deleteCache('express','allexpress');		
		
		if($res) message('操作成功',referer(),'success');
	}
	
	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteDataInWeb($_GPC['checkid'],'zofui_groupshop_express');
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}
	
	
	if($op == 'list'){	
		$info = Util::getAllDataInSingleTable('zofui_groupshop_express',array('uniacid'=>$_W['uniacid']),$_GPC['page'],8,$order='`id` DESC');
		$list = $info[0];
		$pager = $info[1];
	}
	
	if($op == 'edit'){
		$id = intval($_GPC['id']);
		$info = model_express::getSingleExpress($id);
		$info['expressarray'] = iunserializer($info['expressarray']);
	}	
	
	if($op == 'delete'){
		$res = model_express::deleteExpress($_GPC['id']);
		if($res) message('删除成功',referer(),'success');
	}
	
	
	
	include $this->template('web/express');