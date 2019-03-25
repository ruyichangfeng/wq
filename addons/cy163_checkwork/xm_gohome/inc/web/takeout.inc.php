<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('list', 'sheng', 'shengok', 'add', 'addok', 'recommend', 'recommendok', 'activity', 'activityok', 'reports', 'info', 'xiangqing', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'list';

if($foo == 'list') {
    $pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
	
	if (!empty($_GPC['merchant_name'])) {
		$condition .= " AND merchant_name LIKE :merchant_name";
		$params[':merchant_name'] = "%{$_GPC['merchant_name']}%";
	}

	if (!empty($_GPC['merchant_phone'])) {
		$condition .= " AND merchant_phone =".$_GPC['merchant_phone'];
	}

	$sqllist = "SELECT * FROM ".tablename('xm_gohome_merchant')." WHERE `weid` = ".$_W['uniacid']." and delstate=1 $condition ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_merchant') . " WHERE weid = ".$_W['uniacid']." and delstate=1 $condition";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
    include $this->template('web/takeout/merchant');
}

if($foo == 'sheng'){
	$id = $_GPC['merchant_id'];
	if(empty($id)){
		message('参数错误：未获取到商铺ID');
	}
	$item = pdo_fetch("select id,openid,staff_id,license,license_pic from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and id=".$id);
	
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_card')." where weid=".$this->weid." and staff_id =".$item['staff_id']);
	
	include $this->template('web/takeout/merchant-sheng');
}

if($foo == 'shengok'){
	if(checksubmit('submit')){
		$id   	  = intval($_GPC['id']);
		$staff_id = $_GPC['staff_id'];
		$state 	  = $_GPC['state'];
		$data     = array(
			'stop'     => 1,
			'shuoming' => $_GPC['shuoming'],
			'state'    => $state,
			'stime'    => date('Y-m-d H:i:s')
		);
		$res = pdo_update('xm_gohome_merchant', $data, array('id'=>$id));
		if($res){
			if($state == 1){
				$u_info['merchant_state'] = 1;
				pdo_update('xm_gohome_staff', $u_info, array('id'=>$staff_id));
			}
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Validate&m=xm_gohome";
			$this->sheng_tmpmsg('mtmpmsg_id', $state, $jump, $staff_id, $id);
			message('审核成功！', $this->createWebUrl('takeout', array('foo'=>'list')), 'success');
		}else{
			message('审核失败！');
		}
	}
}

if($foo == 'add'){
	$list = pdo_fetchall("SELECT id,type_name FROM ".tablename('xm_gohome_type')." WHERE weid=".$_W['uniacid']." and delstate=1 ORDER BY addtime DESC");
	$list1 = pdo_fetchall("SELECT id,lido_name FROM ".tablename('xm_gohome_lido')." WHERE weid=".$_W['uniacid']." and delstate=1 ORDER BY addtime DESC");
	
	$id = intval($_GPC['id']);
	if(!empty($id)){
		$item     = pdo_fetch("SELECT * FROM ".tablename('xm_gohome_merchant')." WHERE weid=".$_W['uniacid']." AND id=".$id);
		$getLat   = array('lng'=>$item['lng'],'lat'=>$item['lat']);
	}
	include $this->template('web/takeout/merchant-add');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$merchant_name = $_GPC['merchant_name'];
		$merchant_mobile = $_GPC['merchant_mobile'];
		$password = $_GPC['password'];
		$id = intval($_GPC['id']);
		if(empty($merchant_name)){
			message('商铺名称不能为空');
		}
		if(empty($id)){
			if(empty($_GPC['mobile'])){
				message('商铺手机号码不能为空');
			}
			if(empty($_GPC['password'])){
				message('验证密码不能为空');
			}
		}

		if(empty($_GPC['lido_id'])){
			message('请选择所属商圈');
		}
		if(empty($_GPC['type_id'])){
			message('请选择所属品类');
		}
		/*
		if(empty($_GPC['coverpic'])){
			message('请上传商铺图片');
		}
		*/
		if(empty($_GPC['merchant_address'])){
			message('商铺地址不能为空');
		}
		$location = $_GPC['location'];
		if(empty($location['lng'])){
			message('请选择地址中心坐标');
		}
		$lng = $location['lng'];
		$lat = $location['lat'];
		if(empty($_GPC['merchant_phone'])){
			message('商铺电话不能为空');
		}
		if(empty($_GPC['merchant_time'])){
			message('配送时间不能为空');
		}
		/*
		if(empty($_GPC['merchant_timelong'])){
			message('平均配送时长不能为空');
		}
		*/
		if($_GPC['merchant_price'] == ''){
			message('起送价格不能为空');
		}
		if($_GPC['merchant_song'] == ''){
			message('配送费不能为空');
		}
		if(empty($id)){
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_merchant')." WHERE weid=".$_W['uniacid']." AND delstate=1 AND (merchant_name='".$merchant_name."' OR merchant_mobile='".$merchant_mobile."')");
		}else{
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_merchant')." WHERE weid=".$_W['uniacid']." AND delstate=1 AND (merchant_name='".$merchant_name."' OR merchant_mobile='".$merchant_mobile."') AND id !=".$id);
		}
		if(empty($check['id'])){
			$data['merchant_name'] = $merchant_name;
			$data['lido_id'] 	   = $_GPC['lido_id'];
			$data['type_id'] 	   = $_GPC['type_id'];
			if(!empty($_GPC['coverpic'])){
				$data['coverpic'] 	   = $_GPC['coverpic'];
			}
			$data['merchant_address'] = $_GPC['merchant_address'];
			$data['lng'] = $lng;
			$data['lat'] = $lat;
			$data['adrstr'] = $this->encode_geohash($lat,$lng,12);
			$data['merchant_mobile'] = $_GPC['merchant_mobile'];
			$data['chao'] = $_GPC['chao'];
			$data['chao_url'] = $_GPC['chao_url'];
			$data['merchant_phone'] = $_GPC['merchant_phone'];
			$data['merchant_time'] = $_GPC['merchant_time'];
			//$data['merchant_timelong'] = $_GPC['merchant_timelong'];
			$data['merchant_price'] = $_GPC['merchant_price'];
			$data['merchant_song'] = $_GPC['merchant_song'];
			$data['night'] = $_GPC['night'];
			$data['stop'] = $_GPC['stop'];
			$data['ordersum'] = $_GPC['ordersum'];
			if(empty($_GPC['gettype'])){
				$data['gettype'] = 0;
			}else{
				$data['gettype'] = $_GPC['gettype'];
			}
			$data['bili_bai'] = $_GPC['bili_bai'];
			$data['bili_money'] = $_GPC['bili_money'];
			$data['start'] = $_GPC['start'];
			$data['end'] = $_GPC['end'];
			if(empty($id)){
				$data['weid'] = $_W['uniacid'];
				$res = pdo_insert('xm_gohome_merchant', $data);
				if($res){
					message('添加商铺成功！', $this->createWebUrl('takeout', array('foo'=>'list')), 'success');
				}else{
					message('添加商铺失败！');
				}	
			}else{
				$res = pdo_update('xm_gohome_merchant', $data, array('id'=>$id));
				if($res){
					message('编辑商铺成功！', $this->createWebUrl('takeout', array('foo'=>'list')), 'success');
				}else{
					message('编辑商铺失败！');
				}
			}
		}else{
			message('该商铺或手机号码已经添加，不能重复添加！');
		}
	}	
}


if($foo == 'delete'){
	
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到商铺ID");
	}
	$staff_id     = $this->getMerchantInfo($id, "staff_id");
	$serve_type   = $this->getStaffInfo($staff_id, 'serve_type');
	$company_name = $this->getStaffInfo($staff_id, 'company_name');
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_merchant', $data, array('id'=>$id));
	if($res){
		if(empty($company_name)){
			if(empty($serve_type)){
				$data_s['delstate'] = 0;
				pdo_update('xm_gohome_staff', $data_s, array('id'=>$staff_id));
			}else{
				$data_s['merchant_state'] = 0;
				pdo_update('xm_gohome_staff', $data_s, array('id'=>$staff_id));
			}
		}
		message('删除商铺成功！', $this->createWebUrl('takeout', array('foo'=>'list')), 'success');
	}else{
		message('删除商铺失败！');
	}
}

if($foo == "recommend"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到商铺ID");
	}
	$item = pdo_fetch("select top1,top2,top3 from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and id=".$id);

	include $this->template('web/takeout/recommend');
}

if($foo == "recommendok"){
	$merchant_id = intval($_GPC['merchant_id']);
	$top1 = intval($_GPC['top1']);
	$top2 = intval($_GPC['top2']);
	$top3 = intval($_GPC['top3']);
	
	$data = array(
		'top1' => $top1,
		'top2' => $top2,
		'top3' => $top3
	);
	$res = pdo_update('xm_gohome_merchant', $data, array('id'=>$merchant_id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "activity"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到商铺ID");
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_activity')." where weid=".$this->weid." and merchant_id=".$id);

	include $this->template('web/takeout/activity');
}

if($foo == "activityok"){
	$id = intval($_GPC['id']);

	$merchant_id = intval($_GPC['merchant_id']);
	$new_disc	 = $_GPC['new_disc'];
	$man_1		 = $_GPC['man_1'];
	$jian_1		 = $_GPC['jian_1'];
	$man_2		 = $_GPC['man_2'];
	$jian_2		 = $_GPC['jian_2'];
	$man_3		 = $_GPC['man_3'];
	$jian_3		 = $_GPC['jian_3'];
	$disc  	     = $_GPC['disc'];

	$data = array(
		'merchant_id' => $merchant_id,
		'new_disc' => $new_disc,
		'man_1'	   => $man_1,
		'jian_1'   => $jian_1,
		'man_2'	   => $man_2,
		'jian_2'   => $jian_2,
		'man_3'	   => $man_3,
		'jian_3'   => $jian_3,
		'disc'     => $disc
	);
	if(empty($id)){
		$data['weid'] = $this->weid;
		$res = pdo_insert('xm_gohome_activity', $data);
		if(!empty($new_disc)){
			$data_u['new_disc'] = 1;
		}
		if(!empty($man_1) && !empty($jian_1)){
			$data_u['man1_disc'] = 1;
		}else{
			$data_u['man1_disc'] = 0;
		}
		if(!empty($man_2) && !empty($jian_2)){
			$data_u['man2_disc'] = 1;
		}
		else{
			$data_u['man2_disc'] = 0;
		}
		if(!empty($man_3) && !empty($jian_3)){
			$data_u['man3_disc'] = 1;
		}else{
			$data_u['man3_disc'] = 0;
		}
		if(!empty($disc)){
			$data_u['disc'] = 1;
		}else{
			$data_u['disc'] = 0;
		}
		pdo_update('xm_gohome_merchant', $data_u, array('id'=>$merchant_id));
	}else{
		$res = pdo_update('xm_gohome_activity', $data);
		if(!empty($new_disc)){
			$data_u['new_disc'] = 1;
		}else{
			$data_u['new_disc'] = 0;
		}
		if(!empty($man_1) && !empty($jian_1)){
			$data_u['man1_disc'] = 1;
		}else{
			$data_u['man1_disc'] = 0;
		}
		if(!empty($man_2) && !empty($jian_2)){
			$data_u['man2_disc'] = 1;
		}
		else{
			$data_u['man2_disc'] = 0;
		}
		if(!empty($man_3) && !empty($jian_3)){
			$data_u['man3_disc'] = 1;
		}else{
			$data_u['man3_disc'] = 0;
		}
		if(!empty($disc)){
			$data_u['disc'] = 1;
		}else{
			$data_u['disc'] = 0;
		}
		pdo_update('xm_gohome_merchant', $data_u, array('id'=>$merchant_id));
	}
	
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "reports"){
	$merchantid = intval($_GPC['merchant_id']);

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
	
	if (!empty($_GPC['realname'])) {
		$condition .= " AND realname LIKE :realname";
		$params[':realname'] = "%{$_GPC['realname']}%";
	}

	if (!empty($_GPC['mobile'])) {
		$condition .= " AND mobile =".$_GPC['mobile'];
	}

	$sqllist = "SELECT * FROM ".tablename('xm_gohome_takeorder')." WHERE `weid` = ".$_W['uniacid']." and merchantid=".$merchantid." $condition ORDER BY ctime DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM ".tablename('xm_gohome_takeorder')." WHERE weid = ".$_W['uniacid']." and merchantid=".$merchantid." $condition";

	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
    include $this->template('web/takeout/reports');
}

if($foo == "info"){
	$orderid = intval($_GPC['orderid']);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$orderid."'");
	
    include $this->template('web/takeout/info');
}

if($foo == "xiangqing"){
	$id = intval($_GPC['id']);

	$item = pdo_fetch("select * from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and id=".$id);
	
    include $this->template('web/takeout/xiangqing');
}

?>