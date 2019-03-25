<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'data';

	
	$st = $_GPC['datelimit']['start'] ? strtotime($_GPC['datelimit']['start']) : strtotime('-7day');
	$et = $_GPC['datelimit']['end'] ? strtotime($_GPC['datelimit']['end']) : strtotime(date('Y-m-d'));
	$starttime = min($st, $et);
	$endtime = max($st, $et);
	$day_num = intval(($endtime - $starttime) / 86400) + 2;
	$endtime += 86399;	
	
	
	if($_W['ispost'] && $_W['isajax']){
		$days = array();
		$datasets = array();
		for($i = 0; $i < $day_num; $i++){
			$key = date('m-d', $starttime + 86400 * $i); //$key是日期 9-22
			$days[$key] = 0;
			$datasets['flow1'][$key] = 0;
			$datasets['flow2'][$key] = 0;
			$datasets['flow3'][$key] = 0;
			$datasets['flow4'][$key] = 0;
		}
		


		
		$where = array('paytime>'=>$starttime,'uniacid'=>$_W['uniacid']);
		$str= ' AND `status` > 0 AND  paytime <= '.$endtime;
		$data = Util::getAllDataInSingleTable('zofui_timeredbag_order',$where,1,1000*$day_num,'id DESC',true,false,' * ',$str);
		
		foreach((array)$data[0] as $da) { //付款订单数量
			$key = date('m-d', $da['paytime']);
			if(in_array($key, array_keys($days))) {
				if( $da['type'] == 1){
					$datasets['flow1'][$key] += $da['fee'] - $da['server'];
				}
				if( $v['paytype'] == 'wechat'){
					$datasets['flow2'][$key] += $da['fee'];
				}
				$datasets['flow4'][$key] += $da['server'];
			}
		}
		
		// 提现
		$where = array('time>'=>$starttime,'uniacid'=>$_W['uniacid'],'status'=>1);
		$str= ' AND  time <= '.$endtime;
		$draw = Util::getAllDataInSingleTable('zofui_timeredbag_draw',$where,1,1000*$day_num,'id DESC',true,false,' * ',$str);	
		if(!empty($draw)){
			foreach($draw[0] as $da){
				$key = date('m-d', $da['time']);
				if(in_array($key, array_keys($days))) {
					$datasets['flow3'][$key] += $da['money'];
					$datasets['flow4'][$key] += $da['server'];
				}
			}
		}

		
		$shuju['label'] = array_keys($days);
		$shuju['datasets'] = $datasets;
		
		

		$shuju['datasets']['flow1'] = array_values($shuju['datasets']['flow1']);
		$shuju['datasets']['flow2'] = array_values($shuju['datasets']['flow2']);
		$shuju['datasets']['flow3'] = array_values($shuju['datasets']['flow3']);
		$shuju['datasets']['flow4'] = array_values($shuju['datasets']['flow4']);
		exit(json_encode($shuju));
	}
	
	
	

	
	$todystart = strtotime(date('Y-m-d',time()));
	//今日订单
	$where = array('paytime>'=>$todystart,'uniacid'=>$_W['uniacid']);
	$str = ' AND `status` > 0 ';
	$todaydata = Util::getAllDataInSingleTable('zofui_timeredbag_order',$where,1,1000*$day_num,'id DESC',true,false,' * ',$str);

	$todayred = 0;
	$todayfee = 0;
	$todaydraw = 0;
	$todayserver = 0;
	if(!empty($todaydata)){
		foreach($todaydata[0] as $k => $v){
			if( $v['paytype'] == 'wechat'){
				$todayfee += $v['fee'];				
			}
			$todayserver += $v['server'];
			if( $v['type'] == 1){
				$todayred += $v['fee'] - $v['server'];
			}	
		}
	}


	$yeststart = $todystart - 86400;
		

	
	//昨日订单
	$where = array('paytime>'=>$yeststart,'uniacid'=>$_W['uniacid']);
	$str = ' AND `status` > 0 AND paytime <= '.$todystart;
	$yestdata = Util::getAllDataInSingleTable('zofui_timeredbag_order',$where,1,1000*$day_num,'id DESC',true,false,' * ',$str);	
	$yestred = 0;
	$yestfee = 0;
	$yestdraw = 0;
	$yestserver = 0;
	if(!empty($yestdata)){
		foreach($yestdata[0] as $k => $v){
			if( $v['paytype'] == 'wechat'){
				$yestfee += $v['fee'];
			}
			$yestserver += $v['server'];
			if( $v['type'] == 1){
				$yestred += $v['fee'] - $v['server'];
			}
		}
	}
	
	// 提现
	$where = array('time>'=>$yeststart,'uniacid'=>$_W['uniacid'],'status'=>1);
	$todaydrawdata = Util::getAllDataInSingleTable('zofui_timeredbag_draw',$where,1,1000*$day_num,'id DESC',true,false,' * ');	
	if(!empty($todaydrawdata)){
		foreach($todaydrawdata[0] as $k => $v){
			if( $v['time'] >= $todystart ){
				$todaydraw += $v['money'];
				$todayserver += $v['server'];
			}else{
				$yestdraw += $v['money'];
				$yestserver += $v['server'];
			}
			
		}
	}	

	include $this->template('web/data');