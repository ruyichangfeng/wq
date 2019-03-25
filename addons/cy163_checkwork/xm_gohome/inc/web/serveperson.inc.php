<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete', 'sheng', 'shengok', 'projectsheng', 'projectshengok', 'chong', 'chongok', 'bao', 'baook', 'chonglog', 'xiaolog', 'subok', 'xiangqing', 'grablog');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
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
	
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_staff')." WHERE `weid` = ".$this->weid." and company_flag = 0 and delstate=1 $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql='SELECT COUNT(*) FROM ' . tablename('xm_gohome_staff') . " WHERE weid = ".$this->weid." and company_flag = 0 and delstate=1 $condition ";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
		
	include $this->template('web/person/serveperson-list');
}

if($foo == 'add'){
	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid = ".$this->weid." and parent_id = 0 and delstate=1");
	
	load()->func('tpl');
	include $this->template('web/person/serveperson-add');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		if(empty($_GPC['staff_name'])){
			message('服务人员姓名不能为空');
		}
		if(empty($_GPC['mobile'])){
			message('服务人员手机号码不能为空');
		}
		if(empty($_GPC['pwd'])){
			message('验证密码不能为空');
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
			
		$servetype = $_GPC['servetype'];
		$serve_type = implode(",", $servetype);
		$lng = $location['lng'];
		$lat = $location['lat'];
		$adrstr = $this->encode_geohash($lat,$lng,12);
			
		$data['weid'] = $this->weid;
		$data['staff_name'] = $_GPC['staff_name'];
		$data['staff_mobile'] = $_GPC['mobile'];
		$data['pwd'] = $_GPC['pwd'];
		$data['sex'] = $_GPC['sex'];
		$data['age'] = $_GPC['age'];
		$data['year'] = $_GPC['year'];
		$data['avatar'] = $_GPC['avatar'];
		$data['card'] = $_GPC['card'];
		$data['bank'] = $_GPC['bank'];
		$data['bank_num'] = $_GPC['bank_num'];
		$data['alipay'] = $_GPC['alipay'];
		$data['serve_type'] = $serve_type;
		$data['stop'] = $_GPC['stop'];
		$data['money'] = 0;
		$data['grade_money'] = 0;
		$data['flag'] = 1;
		$data['log'] = $lng;
		$data['lat'] = $lat;
		$data['adrstr'] = $adrstr;
		$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
			
		if(!empty($serve_type) || !empty($_GPC['staff_name'])){
			$res = pdo_insert('xm_gohome_staff', $data);
			if($res){
				message('服务人员添加成功！', $this->createWebUrl('serveperson', array('foo'=>'index')), 'success');
			}else{
				message('服务人员添加失败！');
			}
		}else{
			message('服务人员添加失败！');
		}
	}
}

if($foo == 'edit'){
	$id = intval($_GPC['id']);
	$flag = $_GPC['flag'];
		
	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid = ".$this->weid." and parent_id = 0 and delstate=1");
		
	$list1 = pdo_fetchall("select id,adr_name from ".tablename('xm_gohome_address')." where weid = ".$this->weid." and stop=1 order by id desc");
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where id=".$id);
	$servetype = explode(",", $item['serve_type']);	
		
	load()->func('tpl');
	include $this->template('web/person/serveperson-edit');
}

if($foo == 'editok'){
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
			message('服务人员修改成功！', $this->createWebUrl('serveperson', array('foo'=>'index')), 'success');
		}else{
			message('服务人员修改失败！');
		}
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	$data['delstate'] = 0;
	$result = pdo_update('xm_gohome_staff', $data, array('id' => $id));
	if($result){
		message('删除成功！', $this->createWebUrl('serveperson', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

if($foo == 'sheng'){
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
		
	include $this->template('web/person/serveperson-sheng');
}

if($foo == 'shengok'){
	if(checksubmit('submit')){
		$id   = $_GPC['id'];
		$flag = $_GPC['flag'];
			
		$item = pdo_fetch("select openid,staff_name,company_name from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
			
		$data['card_all']   = $_GPC['card_all'];
		$data['shuoming']    = $_GPC['shuoming'];
		$data['stop'] 	    = 1;
		$data['flag'] 	    = $flag;
		$data['stime'] = date('Y-m-d H:i:s');
		$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
		if($res){
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Validate&m=xm_gohome";
			$this->sheng_tmpmsg('stmpmsg_id', $flag, $jump, $id, 0);
			message('审核成功！',$this->createWebUrl('serveperson', array('foo'=>'index')), 'success');
		}else{
			message('审核失败！');
		}
	}
}

if($foo == 'projectsheng'){
	$id = $_GPC['id'];
	$item = pdo_fetch("select id,staff_name,serve_type,sserve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
	$list = explode(",", $item['sserve_type']);
		
	include $this->template('web/person/projectsheng');
}

if($foo == 'projectshengok'){
	if(checksubmit('submit')){
		$id = $_GPC['id'];
		$serve_type = $_GPC['serve_type'];
			
		$sservetype = $_GPC['sservetype'];
		$sserve_type = implode(",", $sservetype);
		$newserve_type = $serve_type.','.$sserve_type;
		
		$data['serve_type'] = $newserve_type;
		$data['sserve_type'] = '';
		$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
		if($res){
			message('审核成功！', $this->createWebUrl('serveperson', array('foo'=>'index')), 'success');
		}else{
			message('审核失败！');
		}
	}	
}

if($foo == 'chong'){
	$id = $_GPC['id'];
		
	include $this->template('web/person/chong');
}

if($foo == "chongok"){
	$id   = $_GPC['id'];
	
	$item = pdo_fetch("select openid,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
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

	include $this->template('web/person/bao');
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

	$id = $_GPC['id'];
		
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_rechargelog')." WHERE weid =".$this->weid." and id=".$id." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_rechargelog')." WHERE weid = ".$this->weid." and id=".$id." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/person/chong-list');
}

if($foo == 'xiaolog'){
	$id = $_GPC['id'];
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_paylog')." WHERE weid =".$this->weid." and id=".$id." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_paylog')." WHERE weid = ".$this->weid." and id=".$id." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/person/xiao-list');
}

if($foo == "subok"){
	$id = intval($_GPC['id']);
	$zt = $_GPC['zt'];

	$data['indextop'] = $zt;
	$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "xiangqing"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
	}

	$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);

	include $this->template('web/person/xiangqing');
}

if($foo == "grablog"){
	$id = $_GPC['id'];
	if(empty($id)){
		message("参数错误：未获取到用户ID");
		exit();
	} 

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
	
	$all = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id=".$id." ".$condition);
	$success = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id=".$id." and selected=1 ".$condition);
	$faill   = $all - $success;
	
	$sure    = pdo_fetchcolumn("SELECT sum(suremoney) FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id=".$id." and selected=1 ".$condition);
	
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_grab')." WHERE weid =".$this->weid." and staff_id=".$id." ".$condition." ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
    if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_grab')." WHERE weid = ".$this->weid." and staff_id=".$id." ".$condition);
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/person/grablog-list');
}

?>