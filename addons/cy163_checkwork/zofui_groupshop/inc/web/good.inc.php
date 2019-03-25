<?php 
	global $_W,$_GPC;
	$op = isset($_GPC['op'])?$_GPC['op']:'list';
	

	if($_W['ispost'] && $_GPC['checkaddgood'] == 1){
		$_GPC = Util::trimWithArray($_GPC);

		$data = array(
			'title' => htmlspecialchars($_GPC['title']),
			'descrip' => htmlspecialchars($_GPC['descrip']),			
			'oldprice' => sprintf('%.2f',$_GPC['oldprice']),
			'nowprice' => sprintf('%.2f',$_GPC['nowprice']),
			
			'groupprice' => sprintf('%.2f',$_GPC['groupprice']),
			'groupnum' => intval($_GPC['groupnum']),			
			'stock' => intval($_GPC['stock']),
			'sales' => intval($_GPC['sales']),
			
			'order' => intval($_GPC['order']),
			'ruletype' => intval($_GPC['ruletype']),					
			'inco' => iserializer($_GPC['inco']),
			'expresstype'=> intval($_GPC['expresstype']),	

			'expressmoney' => sprintf('%.2f',$_GPC['expressmoney']),
			'expressid' => intval($_GPC['expressid']),			
			'iscredit' => intval($_GPC['iscredit']),

			'maxcredit' => intval($_GPC['maxcredit']),
			'isfreeexpress'=> intval($_GPC['isfreeexpress']),
			'fullmoney'=> sprintf('%.2f',$_GPC['fullmoney']),			
			'groupendtime' => sprintf('%.2f',$_GPC['groupendtime']),
			
			'isfirstcut' => intval($_GPC['isfirstcut']),
			'firstcutmoney' => sprintf('%.2f',$_GPC['firstcutmoney']),			
			'iscard' => intval($_GPC['iscard']),
			'limitbuy' => intval($_GPC['limitbuy']),			
			
			'limittime' => intval($_GPC['limittime']),
			'limitnum' => intval($_GPC['limitnum']),	
			'pic' => iserializer($_GPC['pic']),
			'status' => intval($_GPC['status']),		

			'detail'=> htmlspecialchars($_GPC['detail']),
			'createtime'=>time(),
			'edittime'=>time(),
			'usercredit' => intval($_GPC['usercredit']),
			'maxallow' => intval($_GPC['maxallow']),
			'isshowgroup' => intval($_GPC['isshowgroup']),
			
			'isselftake' => intval( $_GPC['isselftake'] ),

		);
		
		
		//处理规格
		if($data['ruletype'] > 0){
			
			if((empty($_GPC['samerulename'][0]) && $data['ruletype'] == 1) || (empty($_GPC['diffrulename'][0]) && $data['ruletype'] == 2)) 
				message('请填写完整的商品规格');
			
			if($data['ruletype'] == 1){
				foreach($_GPC['samerulename'] as $k=>$v){
					if($v != ''){
						$data['rulearray'][$k]['name'] = $v;
						$data['rulearray'][$k]['pro'] = $_GPC['samerulepro'][$k];					
					}
				}
			}elseif($data['ruletype'] == 2){
				foreach($_GPC['diffrulename'] as $k=>$v){
					if($v != ''){
						$data['rulearray'][$k]['name'] = $v;
						$data['rulearray'][$k]['nowprice'] = $_GPC['diffnowprice'][$k];	
						$data['rulearray'][$k]['groupprice'] = $_GPC['diffgroupprice'][$k];							
					}
				}
				//将现价、团购价改为规格价格的最小值
				$data['nowprice'] = min($_GPC['diffnowprice']);
				$data['groupprice'] = min($_GPC['diffgroupprice']);
			}
			
			$data['rulearray'] = iserializer($data['rulearray']);
		}else{
			$data['rulearray'] = '';
		}	
		
		//处理参数
		if(!empty($_GPC['paramsname'])){
			foreach($_GPC['paramsname'] as $k=>$v){
				$data['params'][$k]['name'] = $v;
				$data['params'][$k]['pro'] = $_GPC['paramspro'][$k];				
			}
			$data['params'] = iserializer($data['params']);
		}			
		
		if(!empty($_GPC['id'])){
			$id = intval($_GPC['id']);
			unset($data['createtime']);
			$type = 'edit';
			
			$res = pdo_update('zofui_groupshop_good',$data,array('uniacid'=>$_W['uniacid'],'id'=>$id));
			Util::deleteCache('good',$id);
			model_good::editGoodWithEditPage($id,'edit',$this); //修改前端模板里的商品
		}else{
			$type = 'add';		
			$res = Util::inserData('zofui_groupshop_good',$data);
			$id = pdo_insertid();
		}	
		if(!empty($_GPC['sort'])) $res = WebCommon::insertGoodSort($_GPC['sort'],$id,$type);
		if($res) message('操作成功',referer(),'success');		
		
	}
	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteAllGood($_GPC['checkid']);
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}
	
	//批量分类
	if(checksubmit('changesort')){
		if(empty($_GPC['checkid'])) message('没有选择商品');
		foreach($_GPC['checkid'] as $k=>$v){
			$id = intval($v);
			WebCommon::insertGoodSort($_GPC['sortvalue'],$id,'edit');
		}
		message('批量设置分类完成',referer(),'success');
	}
	
	
	//批量上下架
	if(checksubmit('upgood')) changeStatus($_GPC['checkid'],'up');
	if(checksubmit('downgood')) changeStatus($_GPC['checkid'],'down');
	
	function changeStatus($idarray,$type){
		global $_W;
		if($type == 'up') $status = 0;
		if($type == 'down') $status = 1;
		if(empty($idarray)) message('没有选择商品');
		foreach($idarray as $k=>$v){
			$id = intval($v);
			pdo_update('zofui_groupshop_good',array('status'=>$status),array('uniacid'=>$_W['uniacid'],'id'=>$id));
			if($status == 1) model_good::editGoodWithEditPage($id,'delete',''); //修改前端模板里的商品
			Util::deleteCache('good',$id);
		}
		
		message('操作完成',referer(),'success');
	}
	
	//批量排序
	if(checksubmit('suborder')){
		WebCommon::orderData($_GPC['order'],'zofui_groupshop_good');
		message('排序更新成功！',referer(), 'success');
	}	
	
	//分类
	$sortdata = model_sort::getAllSort();
	$allsort = $sortdata[0];	
	
	//运费模板
	$expressdata = model_express::getAllExpress();
	$allexpress = $expressdata[0];
	
	
	if($op == 'list'){

		$where['uniacid'] = $_W['uniacid'];
		$where['isdust'] = 0;
		$order=' `order` ';
		$by = ' DESC ';
		
		if($_GPC['stock'] == 'no') $where['stock'] = 0;
		if($_GPC['stock'] == 'yes') $where['stock>'] = 0.1;
		
		if($_GPC['activity'] == '1') $where['iscredit'] = 1;
		if($_GPC['activity'] == '2') $where['isfreeexpress'] = 1;
		if($_GPC['activity'] == '3') $where['isfirstcut'] = 1;
		if($_GPC['activity'] == '4') $where['iscard'] = 1;
		
		if($_GPC['limit'] == '1') $where['limitbuy'] = 1;
		if($_GPC['limit'] == '2') $where['limitbuy'] = 0;
		
		if($_GPC['status'] === '0') $where['status'] = 0;
		if($_GPC['status'] == '1') $where['status'] = 1;		
		
		if(!empty($_GPC['order'])) $order = htmlspecialchars($_GPC['order']);
		
		if(!empty($_GPC['by'])) $by = ' ASC ';
		
		if(!empty($_GPC['for'])) $where['title@'] = htmlspecialchars($_GPC['for']);
		
		$info = model_good::getAllGood($where,$_GPC['page'],8,$order.$by);
		$list = $info[0];
		$pager = $info[1];
	}
	
	if($op == 'edit'){
		//这里不使用 model_good::getSingleGood 方法的原因是，这个方法里是查询上架的商品
		$info = Util::getDataByCacheFirst('good',$_GPC['id'],array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_good',array('id'=>$_GPC['id'],'isdust'=>0)));
		$info = model_good::initSingleGoodPro($info);
		
		if(empty($info)) message('没有找到商品',referer(),'error');
	}
	
	if($op == 'delete'){
		$res = WebCommon::deleteGood($_GPC['id']);
		if($res) message('商品已移入垃圾站内',referer(),'success');
	}
	

	
	
	
	include $this->template('web/good');