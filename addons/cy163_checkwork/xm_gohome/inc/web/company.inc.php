<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'sheng', 'shengok', 'look', 'edit', 'editok', 'delete','addstaff','addstaffok', 'editstaff', 'editstaffok', 'deletestaff', 'chong', 'chongok', 'bao', 'baook', 'chonglog', 'xiaolog', 'subok', 'staffsheng', 'staffshengok', 'grablog');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;	
	$condition = '';
	$params = array();
		
	if (!empty($_GPC['company_name'])) {
		$condition .= " AND company_name LIKE :company_name";
		$params[':company_name'] = "%{$_GPC['company_name']}%";
	}		
	if (!empty($_GPC['mobile'])) {
		$condition .= " AND contact =".$_GPC['mobile'];
	}
	if (!empty($_GPC['address'])) {
		$condition .= " AND address LIKE :address";
		$params[':address'] = "%{$_GPC['address']}%";
	}
		
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_staff')." WHERE `weid` = ".$this->weid." and company_flag = 1 and company_mge=1 and delstate=1 $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
		
	$list = pdo_fetchall($sqllist, $params);
	$sql='SELECT COUNT(*) FROM ' . tablename('xm_gohome_staff') . " WHERE weid =".$this->weid." and company_flag = 1 and company_mge=1 and delstate=1 $condition ";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
		
	include $this->template('web/company/company-list');
}

if($foo == 'sheng'){
	$id = $_GPC['id'];
	if(empty($id)){
		message("参数错误:未获取到公司ID");
		exit();
	}

	$item = pdo_fetch("select id,company_name,license,license_pic,card_all from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);   
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_card')." where weid=".$this->weid." and staff_id=".$id." order by id desc");
	$idStr = '';
	foreach($list as $value){
		$idStr .= $value['card_name'].',';
	}
	$idStr = rtrim($idStr,',');
		
	if(empty($item['card_all'])){
		$card_v = $idStr;
	}else{
		$card_v = $item['card_all'];
	}

	include $this->template('web/company/company-sheng');
}

if($foo == 'shengok'){
	if(checksubmit('submit')){
		$id   = intval($_GPC['id']);
		$flag = intval($_GPC['flag']);
		
		$data['card_all'] = $_GPC['card_all'];
		$data['shuoming'] = $_GPC['shuoming'];	
		$data['flag'] = $flag;
		$data['serve_type'] = '';
		$data['stop'] = 1;
		$data['stime'] = date('Y-m-d H:i:s');
		$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
		if($res){
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Validate&m=xm_gohome";
			$this->sheng_tmpmsg('ctmpmsg_id', $flag, $jump, $id, 0);
			message('审核成功！', $this->createWebUrl('company', array('foo'=>'index')), 'success');
		}else{
			message('审核失败！');
		}
	}
}

if($foo == 'look'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到公司ID');
		exit();
	}
	$item = pdo_fetch("select openid,company_name from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);

	$pindex = max(1, intval($_GPC['page']));
	$psize  = 20;
	$condition = '';
	$params = array();
		
	if (!empty($_GPC['staff_name'])) {
		$condition .= " AND staff_name LIKE :staff_name";
		$params[':staff_name'] = "%{$_GPC['staff_name']}%";
	}		
	if (!empty($_GPC['staff_mobile'])) {
		$condition .= " AND staff_mobile =".$_GPC['staff_mobile'];
	}
	if (!empty($_GPC['card'])) {
		$condition .= " AND card =".$_GPC['card'];
	}

	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_staff')." WHERE weid =".$this->weid." and company_flag = 1 and company_mge=0 and openid='".$item['openid']."' and company_name='".$item['company_name']."' and delstate=1 $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_staff')." WHERE weid = ".$this->weid." and company_flag = 1 and company_mge=0 and openid='".$item['openid']."' and company_name='".$item['company_name']."' and delstate=1 $condition ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}

	include $this->template('web/company/company-look');
}

if($foo == 'edit'){
	$id = $_GPC['id'];
	if(empty($id)){
		message('参数错误:未获取到公司ID');
		exit();
	}
	$item= pdo_fetch("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
	
	load()->func('tpl');
		
	include $this->template('web/company/company-edit');
}

if($foo == 'editok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$company_name = $_GPC['company_name'];
		if(empty($_GPC['company_name'])){
			message('公司名称不能为空');
		}
		if(empty($_GPC['contact'])){
			message('联系电话不能为空');
		}
		if(empty($_GPC['address'])){
			message('公司地址不能为空');
		}
			
		if(empty($_GPC['staff_name'])){
			message('负责人姓名不能为空');
		}
		if(empty($_GPC['staff_mobile'])){
			message('手机号码不能为空');
		}
			
		$item= pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and staff_mobile='".$_GPC['staff_mobile']."' and id !=".$id." and delstate=1");
		if(empty($item)){
			$data['staff_name'] = $_GPC['staff_name'];
			$data['staff_mobile'] = $_GPC['staff_mobile'];
			if(!empty($_GPC['pwd'])){
				$data['pwd'] = $_GPC['pwd'];
			}
			$data['sex'] = $_GPC['sex'];
			$data['avatar'] = $_GPC['avatar'];
			$data['stop'] = $_GPC['stop'];
			$data['flag'] = 1;
			$data['company_name'] = $_GPC['company_name'];
			$data['contact'] = $_GPC['contact'];
			$data['address'] = $_GPC['address'];
			$res = pdo_update('xm_gohome_staff', $data ,array('id'=>$id));
			if($res){
				$c_openid = $this->getStaffInfo($id, 'openid');
				pdo_query("update ".tablename('xm_gohome_staff')." set company_name='".$company_name."' where weid=".$this->weid." and openid='".$c_openid."' and delstate=1");
				message('公司修改成功！', $this->createWebUrl('company', array()), 'success');
			}else{
				message('公司修改失败！');
			}
		}else{
			message('该手机号也添加，请输入新的号码');
		}
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到公司ID');
		exit();
	}
	$item = pdo_fetch("select openid,company_name from ".tablename('xm_gohome_staff')." where id=".$id);
	$result = pdo_query("update ".tablename('xm_gohome_staff')." set delstate=0 where openid='".$item['openid']."' and company_name='".$item['company_name']."'");
	if($result){
		//pdo_query("update ".tablename('xm_gohome_merchant')." set delstate=0 where weid=".$this->weid." and staff_id=".$id." and openid='".$item['openid']."'");

		message('删除成功！', $this->createWebUrl('company', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

if($foo == 'addstaff'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到公司ID');
		exit();
	}

	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid = ".$this->weid." and parent_id = 0 and delstate=1");
		
	load()->func('tpl');
	include $this->template('web/company/staffadd');
}

if($foo == 'addstaffok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['staff_name'])){
			message('服务人员姓名不能为空');
		}
		if(empty($_GPC['mobile'])){
			message('服务人员手机号码不能为空');
		}
		if(empty($_GPC['card'])){
			message('服务人员身份证号码不能为空');
		}
		$location = $_GPC['location'];
		if(empty($location['lng'])){
			message('服务人员常驻地址不能为空');
		}
		if(empty($_GPC['servetype'])){
			message('服务项目至少选择一个');
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and staff_mobile='".$_GPC['mobile']."' and delstate=1");
		if(empty($check)){
			$item = pdo_fetch("select openid,company_name from ".tablename('xm_gohome_staff')." where weid =".$this->weid." and delstate=1 and id=".$id);
				
			$servetype = $_GPC['servetype'];
			$serve_type = implode(",", $servetype);
			$lng = $location['lng'];
			$lat = $location['lat'];
			$adrstr = $this->encode_geohash($lat,$lng,12);
				
			$data['weid'] 		  = $this->weid;
			$data['openid'] 	  = $item['openid'];
			$data['staff_name']   = $_GPC['staff_name'];
			$data['staff_mobile'] = $_GPC['mobile'];
			$data['pwd'] 		  = $_GPC['pwd'];
			$data['sex'] 		  = $_GPC['sex'];
			$data['age'] 		  = $_GPC['age'];
			$data['year'] 		  = $_GPC['year'];
			$data['avatar'] 	  = $_GPC['avatar'];
			$data['card'] 		  = $_GPC['card'];
			$data['serve_type']   = $serve_type;
			$data['bank'] 		  = $_GPC['bank'];
			$data['bank_num'] 	  = $_GPC['bank_num'];
			$data['alipay'] 	  = $_GPC['alipay'];
			$data['stop'] 	  	  = $_GPC['stop'];
			$data['money'] 		  = 0;
			$data['flag'] 		  = 1;
			$data['company_name'] = $item['company_name'];
			$data['company_flag'] = 1;
			$data['log'] 		  = $lng;
			$data['lat'] 		  = $lat;
			$data['adrstr'] 	  = $adrstr;
			$res = pdo_insert('xm_gohome_staff', $data);
			if($res){
				pdo_query("update ".tablename('xm_gohome_staff')." set staff_num=staff_num+1 where delstate=1 and id=".$id);
				message('公司服务人员添加成功！', $this->createWebUrl('company', array('foo'=>'look', 'id'=>$id)), 'success');
			}else{
				message('公司服务人员添加失败！');
			}
		}else{
			message('该手机号码已添加，请输入新的号码');
		}
	}
}

if($foo == 'editstaff'){		
	$id 		= intval($_GPC['id']);
	$company_id = intval($_GPC['company_id']);
	if(empty($id)){
		message('参数错误：未获取到工人ID');
		exit();
	}	
	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid = ".$this->weid." and parent_id = 0 and delstate=1");
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where delstate=1 and id=".$id);
	$servetype = explode(",", $item['serve_type']);	
		
	load()->func('tpl');
		
	include $this->template('web/company/staffedit');
}

if($foo == 'editstaffok'){
	if(checksubmit('submit')){
		$id 		= intval($_GPC['id']);
		$company_id = intval($_GPC['company_id']);
		if(empty($_GPC['staff_name'])){
			message('服务人员姓名不能为空');
		}
		if(empty($_GPC['mobile'])){
			message('服务人员手机号码不能为空');
		}
		if(empty($_GPC['card'])){
			message('服务人员身份证号码不能为空');
		}
		$location = $_GPC['location'];
		if(empty($_GPC['servetype'])){
			message('服务项目至少选择一个');
		}
			
		$servetype = $_GPC['servetype'];
		$serve_type = implode(",", $servetype);
		if(!empty($location)){
			$lng = $location['lng'];
			$lat = $location['lat'];
			$adrstr = $this->encode_geohash($lat,$lng,12);
				
			$data['log'] = $lng;
			$data['lat'] = $lat;
			$data['adrstr'] = $adrstr;
		}

		$check = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and staff_mobile='".$_GPC['mobile']."' and delstate=1 and id !=".$id);
		if(empty($check)){	
			$data['staff_name'] = $_GPC['staff_name'];
			$data['staff_mobile'] = $_GPC['mobile'];
			if(!empty($_GPC['pwd'])){
				$data['pwd'] = $_GPC['pwd'];
			}
			$data['sex'] = $_GPC['sex'];
			$data['age'] = $_GPC['age'];
			$data['year'] = $_GPC['year'];
			$data['avatar'] = $_GPC['avatar'];
			$data['card'] = $_GPC['card'];
			$data['serve_type'] = $serve_type;
			$data['bank'] = $_GPC['bank'];
			$data['bank_num'] = $_GPC['bank_num'];
			$data['alipay'] = $_GPC['alipay'];
			$data['stop'] = $_GPC['stop'];
			$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
			$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
			if($res){
				message('服务人员修改成功！', $this->createWebUrl('company', array('foo'=>'look','id'=>$company_id)), 'success');
			}else{
				message('服务人员修改失败！');
			}
		}else{
			message('该手机号码已添加，请输入新的号码');
		}	
	}
}

if($foo == 'deletestaff'){
	$id = intval($_GPC['id']);
	$company_id = intval($_GPC['company_id']);
	if(empty($id)){
		message('参数错误：未获取到工人ID');
		exit();
	} 
	$data['delstate'] = 0;
	$result = pdo_update('xm_gohome_staff', $data, array('id' => $id));
	if($result){
		pdo_query("update ".tablename('xm_gohome_staff')." set staff_num=staff_num-1 where company_mge=1 and delstate=1 and id=".$company_id);
		message('删除成功！', $this->createWebUrl('company', array('foo'=>'look', 'id'=>$company_id)), 'success');
	}else{
		message('删除失败！');
	}
}

if($foo == "chong"){
	$id   = intval($_GPC['id']);

	include $this->template('web/company/chong');
}

if($foo == "chongok"){
	$id   = $_GPC['id'];
	
	$item = pdo_fetch("select openid,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
	if(!empty($item)){
		$data['money'] = $item['money'] + $_GPC['money'];
		$res = pdo_update('xm_gohome_staff',$data, array('id'=>$id));
		if($res){
			$data1['weid']    = $this->weid;
			$data1['staff_id']= $id;
			$data1['openid']  = $item['openid'];
			$data1['type']    = 2;
			$data1['money']   = $_GPC['money'];
			$data1['remark']  = '后台余额充值';
			$res = pdo_insert('xm_gohome_rechargelog',$data1);
			if($res){
				echo 1;
			}else{
				echo 0;
			}	
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
}

if($foo == "bao"){
	$id   = intval($_GPC['id']);
	$flag = intval($_GPC['flag']);

	$item = pdo_fetch("select id,openid,grade_id,grade_money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_grade')." where weid=".$this->weid." and delstate=1 order by grade_money asc");

	include $this->template('web/company/bao');
}

if($foo == "baook"){
	$id            	  = intval($_GPC['id']);
	$old_grade_id     = intval($_GPC['old_grade_id']);
	$old_grade_money  = $_GPC['old_grade_money'];
		
	$arr = explode("@", $_GPC['grade_id']);
	$grade_id = $arr[0];

	if($old_grade_id == ''){
		$money = $arr[1];
	}
		
	if($old_grade_id == $arr[0]){
		echo 2;
		exit();
	}
		
	if($old_grade_id > $arr[0]){
		echo 3;
		exit();
	}
		
	if($old_grade_id < $arr[0]){
		$getMoney = $arr[1];
		$money = $getMoney - $old_grade_money;
	}

	$item = pdo_fetch("select id,openid,grade_money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
	$n_money = $item['grade_money'] + $money;
	$data['grade_money'] = $n_money;
	$data['grade_id']    = $grade_id;
	$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
	if($res){
		$data_log = array(
			'weid'     => $this->weid,
			'staff_id' => $id,
			'openid'   => $item['openid'],
			'type'     => 3,
			'money'    => $money,
			'remark'   => '后台保证金充值'
		);
		pdo_insert('xm_gohome_rechargelog', $data_log);
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == 'chonglog'){
	$id   = intval($_GPC['id']);
	if(empty($id)){
		message("未获取到用户ID");
		exit();
	}
		
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_rechargelog')." WHERE weid =".$this->weid." and staff_id=".$id." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_rechargelog')." WHERE weid = ".$this->weid." and staff_id=".$id." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/company/chong-list');
}

if($foo == 'xiaolog'){
	$id = $_GPC['id'];
	if(empty($id)){
		message("参数错误：未获取到用户ID");
		exit();
	} 

	$openid = $this->getStaffInfo($id, 'openid');
	$idStr  = $this->getStaffId($openid);
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_paylog')." WHERE weid =".$this->weid." and staff_id in (".$idStr.") ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_paylog')." WHERE weid = ".$this->weid." and staff_id in (".$idStr.")");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/company/xiao-list');
}

if($foo == "subok"){
	$id    = intval($_GPC['id']);
	$state = intval($_GPC['state']);

	$data['indextop'] = $state;
	$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == 'staffsheng'){
	$id = $_GPC['id'];
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_card')." where weid=".$this->weid." and staff_id=".$id);
	$idStr = '';
	foreach($list as $value){
		$idStr .= $value['card_name'].',';
	}
	$idStr = rtrim($idStr,',');
		
	$item = pdo_fetch("select id,card_all from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
	if(empty($item['card_all'])){
		$card_v = $idStr;
	}else{
		$card_v = $item['card_all'];
	}
		
	include $this->template('web/company/staff-sheng');
}

if($foo == 'staffshengok'){
	if(checksubmit('submit')){
		$id   = $_GPC['id'];
		$flag = $_GPC['flag'];
			
		$item = pdo_fetch("select openid,staff_name,company_name from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
			
		$data['card_all']   = $_GPC['card_all'];
		$data['shuoming']   = $_GPC['shuoming'];
		$data['flag'] 	    = $flag;
		$data['stime'] = date('Y-m-d H:i:s');
		$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
		if($res){
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Validate&m=xm_gohome";
			$this->sheng_tmpmsg('stmpmsg_id', $flag, $jump, $id, 0);
			message('审核成功！',$this->createWebUrl('company', array('foo'=>'index')), 'success');
		}else{
			message('审核失败！');
		}
	}
}

if($foo == "grablog"){
	$id = $_GPC['id'];
	if(empty($id)){
		message("参数错误：未获取到用户ID");
		exit();
	} 

	$openid = $this->getStaffInfo($id, 'openid');
	$idStr  = $this->getStaffId($openid);
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
		
	if (!empty($_GPC['selected'])) {
		if($_GPC['selected'] == 1){
			$condition .= " AND selected = 1";
		}else{
			$condition .= " AND selected != 1";
		}
	}

	if (!empty($_GPC['addtime'])) {
		$addtime = $_GPC['addtime'];
		$starttime = $addtime['start'].' 00:00:00';
		$endtime   = $addtime['end'].' 23:59:59';
		$condition .= " AND addtime between '".$starttime."' and '".$endtime."'";
	}
	
	$all = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id in (".$idStr.") ".$condition);
	$success = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id in (".$idStr.") and selected=1 ".$condition);
	$faill   = $all - $success;

	$sure    = pdo_fetchcolumn("SELECT sum(suremoney) FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id in (".$idStr.") and selected=1 ".$condition);
	
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id in (".$idStr.") ".$condition." ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
    if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_grab')." WHERE weid = ".$this->weid." and staff_id in (".$idStr.") ".$condition);
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/company/grablog-list');
}

?>