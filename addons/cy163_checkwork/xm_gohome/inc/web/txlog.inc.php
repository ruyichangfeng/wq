<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'merchant', 'tixianadd', 'tixianmerchant', 'tixianaddok', 'bank', 'bankadd', 'bankaddok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_tixianlog')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_tixianlog')." WHERE weid = ".$this->weid."");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/tixian/tixian-list');
}

if($foo == 'merchant') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_tixianlog_merchant')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_tixianlog_merchant')." WHERE weid = ".$this->weid."");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/tixian/tixian-merchant');
}

if($foo == 'tixianadd'){
	$id = intval($_GPC['id']);
	$type = 'project'; 

	$item = pdo_fetch("select * from ".tablename('xm_gohome_tixianlog')." where weid=".$this->weid." and id=".$id);
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_moneylog')." where weid=".$this->weid." and tid=".$id." and type='project'");
		
	if($item['famoney'] == 0){
		$s_item = pdo_fetch("select id,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$item['openid']."' and delstate=1");
		$staff_id = $s_item['id'];
		if($s_item['company_flag'] == 1){
			$idStr = $this->getStaffId($item['openid']);
			$item1 = pdo_fetch("select sum(getMoney) as yu from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and type!=1 and staff_id in (".$idStr.") and addtime between '".$item['start']."' and '".$item['end']."' and state=1");
		}else{
			$item1 = pdo_fetch("select sum(getMoney) as yu from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and type!=1 and staff_id=".$staff_id." and addtime between '".$item['start']."' and '".$item['end']."' and state=1");
		}
		if($item1['yu'] == ''){
			$yu = 0;
		}else{
			$yu = $item1['yu'];
		}
		/*	
		if($yu != $item['money']){
			message('计算数据不正确，不能操作！');
		} 
		*/
	}
		
	include $this->template('web/tixian/tixian-add'); 
}

if($foo == 'tixianmerchant'){
	$id = intval($_GPC['id']);
	$type = 'takeout';

	$item = pdo_fetch("select * from ".tablename('xm_gohome_tixianlog_merchant')." where weid=".$this->weid." and id=".$id);
	$staff_id = $this->getMerchantInfo($item['merchant_id'], 'staff_id');
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_moneylog')." where weid=".$this->weid." and tid=".$id." and type='takeout'");
		
	if($item['famoney'] == 0){
		$item1 = pdo_fetch("select sum(getmoney) as yu from ".tablename('xm_gohome_takepaylog')." where weid=".$this->weid." and merchant_id=".$item['merchant_id']." and addtime between '".$item['start']."' and '".$item['end']."' and state=1");
		if($item1['yu'] == ''){
			$yu = 0;
		}else{
			$yu = $item1['yu'];
		}
		/*	
		if($yu != $item['money']){
			message('计算数据不正确，不能操作！');
		}
		*/
	}
		
	include $this->template('web/tixian/tixianmerchant-add'); 
}

if($foo == 'tixianaddok'){
	if(checksubmit()){
		$tid     = intval($_GPC['tid']);
		$type    = $_GPC['type'];
		$fangshi = $_GPC['fangshi'];
		$staff_id= $_GPC['staff_id'];
		if($_GPC['money2'] > $_GPC['money1']){
			message('实发金额不能大于待发金额！');
		}
		if($_GPC['money2'] < 0){
			message('实发金额必须大于0！');
		}
		$data['weid'] = $this->weid;
		$data['money1'] = $_GPC['money1'];
		$data['money2'] = $_GPC['money2'];
		$data['remark'] = $_GPC['remark'];
		$data['username'] = $_W['username'];
		$data['tid'] = $tid;
		$data['type'] = $type;
		$data['s_openid'] = $_GPC['s_openid'];
		/*
		$bank['YURREF'] = $this->generate_code(8);
		$bank['DBTACC'] = '591902896910604 ';
		$bank['DBTBBK'] = '59';
		$bank['TRSAMT'] = $_GPC['money2'];
		$bank['NUSAGE'] = $_GPC['remark'];
		$bank['CRTACC'] = $_GPC['CRTACC'];
		$bank['CRTNAM'] = $_GPC['CRTNAM'];
		$bank['BNKFLG'] = "Y";
		$bank['CRTBNK'] = '招商银行福州分行';
		
		$url = 'http://weiwend.picp.net:97/home/index/dcPayment.html';
		var_dump($bank);
		$res = $this->post($url, $bank, 5);
		var_dump($res);
		exit();
		*/
		if($fangshi == 2){
			if(empty($_GPC['remark'])){
				message('银行打款摘要备注不能为空！');
				exit();
			}
			if(DBTACC == ""){
				message('付方帐号不能为空！');
				exit();
			}
			if(DBTBBK == ""){
				message('付方帐号的开户行所在地区不能为空！');
				exit();
			}
			$bank['YURREF'] = $this->generate_code(8);
			$bank['DBTACC'] = DBTACC;
			$bank['DBTBBK'] = DBTBBK;
			$bank['TRSAMT'] = $_GPC['money2'];
			$bank['NUSAGE'] = $_GPC['remark'];
			$bank['CRTACC'] = $this->getStaffInfo($staff_id,'bank_num');
			$bank['CRTNAM'] = $this->getStaffInfo($staff_id,'staff_name');
			if (strstr($this->getStaffInfo($staff_id,'bank'),'招商')){
				$bank['BNKFLG'] = "Y";
			}else{
				$bank['BNKFLG'] = "N";
				$bank['CRTBNK'] =  $this->getStaffInfo($staff_id,'bank');
			}

			$url = 'http://weiwend.picp.net:97/home/index/dcPayment.html';
			$result = $this->post($url, $bank, 5);
			$result = json_decode($result);
			$res = $result->success;
			$bank['success'] = $result->success;
			$bank['message'] = $result->message;
			$bank['weid'] = $this->weid;
			pdo_insert('xm_gohome_banklog', $bank);
			if($res == "true"){
				pdo_insert('xm_gohome_moneylog',$data);
				if($type == "project"){
					pdo_query("update ".tablename('xm_gohome_tixianlog')." set famoney=famoney+".$_GPC['money2'].",yumoney=yumoney-".$_GPC['money2'].",state=1 where id=".$tid);
					message('操作记录添加成功！'.$result->message,$this->createWebUrl('Txlog',array('foo'=>'index')), 'success');
				}else{
					pdo_query("update ".tablename('xm_gohome_tixianlog_merchant')." set famoney=famoney+".$_GPC['money2'].",yumoney=yumoney-".$_GPC['money2'].",state=1 where id=".$tid);
					message('操作记录添加成功！',$this->createWebUrl('Txlog',array('foo'=>'merchant')), 'success');
				}
			}else{
				message('操作记录添加失败！');
			}
		}else{
			$res = pdo_insert('xm_gohome_moneylog',$data);
			if($res){
				if($type == "project"){
					pdo_query("update ".tablename('xm_gohome_tixianlog')." set famoney=famoney+".$_GPC['money2'].",yumoney=yumoney-".$_GPC['money2'].",state=1 where id=".$tid);
					message('操作记录添加成功！',$this->createWebUrl('Txlog',array('foo'=>'index')), 'success');
				}else{
					pdo_query("update ".tablename('xm_gohome_tixianlog_merchant')." set famoney=famoney+".$_GPC['money2'].",yumoney=yumoney-".$_GPC['money2'].",state=1 where id=".$tid);
					message('操作记录添加成功！',$this->createWebUrl('Txlog',array('foo'=>'merchant')), 'success');
				}
			}else{
				message('操作记录添加失败！');
			}
		}
	}
}

if($foo == 'bank') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_bank')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_bank')." WHERE weid = ".$this->weid."");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/tixian/bank-list');
}

if($foo == "bankadd"){
	$id = intval($_GPC['id']);
	if(!empty($id)){
		$item = pdo_fetch("select * from ".tablename('xm_gohome_bank')." where weid=".$this->weid." and id=".$id);
	}

	include $this->template('web/tixian/bank-add');	
}

if($foo == "bankaddok"){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$bank_name = trim($_GPC['bank_name']);
		if(empty($bank_name)){
			message('银行名称不能为空');
		}
		if(empty($id)){
			$check = pdo_fetch("select id from ".tablename('xm_gohome_bank')." where weid=".$this->weid." and bank_name='".$bank_name."'");
		}else{
			$check = pdo_fetch("select id from ".tablename('xm_gohome_bank')." where weid=".$this->weid." and bank_name='".$bank_name."' and id!=".$id);
		}
		if(empty($check['id'])){
			$data['bank_name'] = $bank_name;
			$data['pic'] = $_GPC['pic'];
			$data['top'] = $_GPC['top'];
			if(empty($id)){
				$data['weid'] = $this->weid;
				$res = pdo_insert('xm_gohome_bank', $data);
				if($res){
					message('添加银行成功！', $this->createWebUrl('txlog', array('foo'=>'bank')), 'success');
				}else{
					message('添加银行失败！');
				}
			}else{
				$res = pdo_update('xm_gohome_bank', $data, array('id'=>$id));
				if($res){
					message('修改银行成功！', $this->createWebUrl('txlog', array('foo'=>'bank')), 'success');
				}else{
					message('修改银行失败！');
				}
			}
		}else{
			message('该银行名称已存在！');
		}
	}
}

if($foo == "delete"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到银行ID");
	}
	$res = pdo_delete("xm_gohome_bank", array("id"=>$id));
	if($res){
		message('删除银行成功！', $this->createWebUrl('txlog', array('foo'=>'bank')), 'success');
	}else{
		message('删除银行失败！');
	}
}

?>