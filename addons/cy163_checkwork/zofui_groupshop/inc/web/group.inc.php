<?php 
	global $_W,$_GPC;
	$op = empty($_GPC['op'])?'list':$_GPC['op'];
	$_GPC['do'] = empty($_GPC['do'])?'group':$_GPC['do'];
	
	//批量无物流发货
	if(checksubmit('noexpresssend')) WebCommon::batchToSend($_GPC,'noexpress');
	
	//批量物流发货
	if(checksubmit('submitbatchexpress')) WebCommon::batchToSend($_GPC,'express');
	
	if($op == 'list'){
		
		$whereb['uniacid'] = $_W['uniacid'];
		//if(!empty($_GPC['gstatus'])) $whereb['status'] = intval($_GPC['gstatus']);
		if($_GPC['gstatus'] == 1) { //组团中的
			$whereb['overtime>'] = time();
			$whereb['lastnumber>'] = 0.1;
			$whereb['status'] = 1;
		}
		if($_GPC['gstatus'] == 2){ // 失败的
			$whereb['overtime<'] = time(); 
			$statusstr = ' AND b.`status` = 2 ';
		} 
		if($_GPC['gstatus'] == 3){ // 成功的
			//$whereb['lastnumber'] = 0; 
			$statusstr = ' AND ( b.lastnumber = 0 OR b.`status` = 3 ) ';
		}
		
		
		$select = ' b.*,a.title,a.pic,a.nowprice,a.oldprice,a.groupprice ';
		
		$data = model_group::getAllGroup($wherea,$whereb,$statusstr,$select,intval($_GPC['page']),10,' b.`id` DESC ',true);
				
		$groupinfo = $data[0];
		foreach($groupinfo as $k => $v){
			$groupinfo[$k]['gstatus'] = model_group::decodeGroupStatus($v['status'],$v['overtime'],$v['isrefund'],$v['lastnumber']);
		}
		$pager = $data[1];
	}
	
	if($op == 'info'){
		
		$wherea['uniacid'] = $_W['uniacid'];
		$order=' a.`id` ';
		$by = ' DESC ';	
		$wherea['groupid'] = intval($_GPC['id']);
		if(empty($wherea['groupid'])) message('团不存在',referer(),'error');
		
		if(empty($_GPC['status'])) $str = ' a.status IN (3,4,5,6,7) ';
		if(in_array($_GPC['status'],array(1,2,3,4,7))) $wherea['status'] = intval($_GPC['status']);
		if($_GPC['status'] == 'refund') $wherea['refundstatus'] = 1;
		if($_GPC['status'] == 'end') $str = ' a.status IN (5,6) ';			
		
		
		$res = WebCommon::slelectOrder($wherea,$whereb,$str,$_GPC['page'],10,$order,$by);
		$pager = $res[1];
		$list = $res[0];
		
		$where = array('uniacid'=>$_W['uniacid'],'id'=>$wherea['groupid']);		
		$groupinfo = model_group::getSingleGroup($where,$wherea['groupid']);
		$groupinfo['gstatus'] = model_group::decodeGroupStatus($groupinfo['status'],$groupinfo['overtime'],$groupinfo['isrefund'],$groupinfo['lastnumber']);
	}	
	
	

	
	
	include $this->template('web/group');