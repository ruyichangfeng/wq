<?php 
	global $_W,$_GPC;
	$op = isset($_GPC['op'])?$_GPC['op']:'list';
	

	
	//添加，编辑
	if(checksubmit('addcard')){
		$_GPC = Util::trimWithArray($_GPC);
		
		$data['cardtype'] = intval($_GPC['cardtype']);
		$data['cardname'] = htmlspecialchars($_GPC['cardname']);		
		$data['needcredit'] = intval($_GPC['needcredit']);	
		$data['cardvalue'] = sprintf('%.2f',$_GPC['cardvalue']);			
		$data['fullmoney'] = $_GPC['fullmoney'];		
		$data['totalnum'] =  intval($_GPC['totalnum']);	
		$data['lastnum'] =  intval($_GPC['totalnum']);
		$data['limitnum'] = intval($_GPC['limitnum']);			
		$data['expire'] = intval($_GPC['expire']);
		$data['starttime'] = strtotime($_GPC['datelimit']['start']);
		$data['endtime'] = strtotime($_GPC['datelimit']['end']);
		$data['status'] =  intval($_GPC['status']);		
		$data['time'] = time();		
		
		
		//验证下
		if(empty($data['cardtype']) || empty($data['cardname']) || $data['cardvalue'] <= 0 || $data['fullmoney'] <=0  || $data['totalnum'] <= 0 || $data['limitnum'] <= 0 || $data['expire'] <= 0 || $data['starttime'] == $data['endtime']){
			message('存在异常参数，请仔细核对参数');
		}
		if(($data['cardtype'] == 1 || $data['cardtype'] == 3) && $data['cardvalue'] >= $data['fullmoney']){
			message('优惠券面值不能大于等于设定的订单金额');
		}
		if(($data['cardtype'] == 2 || $data['cardtype'] == 4) && $data['cardvalue'] >= 1){
			message('折扣值应在0-1之间，有效小数是2位');
		}
		
		if(!empty($_GPC['id'])){
			$lastnum = intval($_GPC['lastnum']);
			if($lastnum > $data['totalnum']){
				$data['lastnum'] = $data['totalnum'];
			}else{
				$data['lastnum'] = $lastnum + ($data['totalnum'] - $lastnum);
			}
			
			$res = pdo_update('zofui_groupshop_card',$data,array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
			Util::deleteCache('card',$_GPC['id']);
		}else{
			
			$res = Util::inserData('zofui_groupshop_card',$data);
		}
		if($res) message('操作成功',referer(),'success');
	}
	
	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteDataInWeb($_GPC['checkid'],'zofui_groupshop_card');
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}
	
	//批量上下架
	if(checksubmit('upstatus')) changeStatus($_GPC['checkid'],'up');
	if(checksubmit('downstatus')) changeStatus($_GPC['checkid'],'down');
	
	function changeStatus($idarray,$type){
		global $_W;
		if($type == 'up') $status = 0;
		if($type == 'down') $status = 1;
		
		if(empty($idarray)) message('没有选择优惠券');
		foreach($idarray as $k=>$v){
			$id = intval($v);
			pdo_update('zofui_groupshop_card',array('status'=>$status),array('uniacid'=>$_W['uniacid'],'id'=>$id));
			Util::deleteCache('card',$id);
		}
		message('操作完成',referer(),'success');
	}	
	
	
 	if($op == 'list'){	
		$where['uniacid'] = $_W['uniacid'];
		if(!empty($_GPC['type'])) $where['cardtype'] = intval($_GPC['type']);
		if($_GPC['status'] == '1') $where['status'] = 1;
		if($_GPC['status'] == '2') $where['starttime>'] = time();		
		if($_GPC['status'] == '3') $where['endtime<'] = time();	
		
		$order = '`id` ';
		if($_GPC['order'] == 'value') $order = '`cardvalue` ';
		if($_GPC['order'] == 'total') $order = '`totalnum` ';
		if($_GPC['order'] == 'taked') $order = '`takednum` ';		
		if($_GPC['order'] == 'used') $order = '`usednum` ';
		
		$by = ' DESC ';
		if($_GPC['by'] == '1') $by = ' ASC ';
		
		$info = Util::getAllDataInSingleTable('zofui_groupshop_card',$where,$_GPC['page'],8,$order.$by);
		$list = $info[0];
		$pager = $info[1];
	}
	
	if($op == 'edit'){
		$id = intval($_GPC['id']);
		$info = model_card::getSingleCard($id);
		$limittime['start'] = date('Y-m-d H:i:s',$info['starttime']);
		$limittime['end'] = date('Y-m-d H:i:s',$info['endtime']);
		
	}	
	
	if($op == 'delete'){
		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_groupshop_card');
		if($res) message('删除成功',referer(),'success');
	}
	
	if($op == 'takelog'){
		
		$where['uniacid'] = $_W['uniacid'];
		if(!empty($_GPC['type'])) $where['cardtype'] = intval($_GPC['type']);
		if(!empty($_GPC['status'])) $where['status'] = intval($_GPC['status']);
		
		if($_GPC['status'] == 1) $where['status'] = 0;	
		if($_GPC['status'] == 2) $where['status'] = 1;	
		if($_GPC['status'] == 3){
			$where['status'] = 0;
			$where['overtime<'] = time();	
		}
		
		
		$order = ' b.`id` ';
		$by = ' DESC ';		
		if(!empty($_GPC['order'])) $order = ' b.'.$_GPC['order']; 	
		
		if($_GPC['by'] == 1) $by = ' ASC ';			
		

		
		$info = model_card::getTakedCard($where,8,intval($_GPC['page']),$order.$by,'web',true);
		$list = $info[0];
		$pager = $info[1];		

	}
	
	
	
	include $this->template('web/card');