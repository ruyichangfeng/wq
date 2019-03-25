<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('add', 'addok', 'manager', 'cardlist', 'cardaddok', 'delete', 'project', 'projectok');
$foo = in_array($foo, $foos) ? $foo : 'add';

if($foo == 'add'){
	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and parent_id=0 and chao=0 and delstate=1");
		
	$item = pdo_fetch("select id,openid,company_name,stop from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and  openid='".$openid."' and company_mge=1 and company_flag=1 and delstate=1");
		
	include $this->template('staff/staff/s_staffadd');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$staff_mobile = $_GPC['staff_mobile'];
		/*$item = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and staff_mobile='".$staff_mobile."' and delstate=1 and company_mge=0 and company_flag=1");
		if(empty($item['id'])){*/
			//上传头像
			$avatar = $_GPC['avatar'];
			if(!empty($avatar)){
				$path       = 'gohome/avatar/';
				$filename   = $this->uploadImage($avatar, $path);
				$data['avatar'] = $filename;
			}
				
			$servetype = $_GPC['servetype'];
			$serve_type = implode(",", $servetype);
				
			$jw = $_GPC['jw'];
			$jw_arr =  explode(",", $jw);
			$lng = $jw_arr[0];
			$lat = $jw_arr[1];
			$adrstr = $this->encode_geohash($lat,$lng,12);
			
			$data['weid'] = $this->weid;
			$data['openid'] = $_GPC['openid'];
			$data['staff_name'] = $_GPC['staff_name'];
			$data['card'] = $_GPC['card'];
			$data['staff_mobile'] = $staff_mobile;
			$data['sex'] = $_GPC['sex'];
			$data['serve_type'] = $serve_type;
			$data['age'] = $_GPC['age'];
			$data['year'] = $_GPC['year'];
			$data['bank'] = $_GPC['bank'];
			$data['bank_num'] = $_GPC['bank_num'];
			$data['alipay'] = $_GPC['alipay'];
			$data['stop'] = $_GPC['stop'];
			$data['flag'] = 1;
			$data['company_flag'] = 1;
			$data['company_name'] = $_GPC['company_name'];
			$data['money'] = 0;
			$data['grade_money'] = 0;
			$data['log'] = $lng;
			$data['lat'] = $lat;
			$data['adrstr'] = $adrstr;
			$data['permanent'] = $_GPC['text_'];
				
			$res = pdo_insert('xm_gohome_staff',$data);
			if($res){
				pdo_query("update ".tablename('xm_gohome_staff')." set staff_num=staff_num+1 where openid='".$_GPC['openid']."' and company_mge=1 and delstate=1");
				message('添加成功！', $this->createMobileUrl('staff', array('foo'=>'manager')), 'success');
			}else{
				message('添加失败！');
			}
		/*}else{
			message('添加失败,该手机号已添加，不能重复添加！');
		}*/
	}	
}

if($foo == 'manager'){
	$id = intval($_GPC['id']);
	
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and company_flag=1 and company_mge=0 and delstate=1 order by addtime desc");
		
	include $this->template('staff/staff/s_staffmanager');
}

if($foo == 'cardlist'){
	$id   = intval($_GPC['id']);
	$mark = intval($_GPC['mark']);
	if(empty($id)){
		message('参数错误：未获取到加盟ID');
	}
	if($mark == 1){
		$item = pdo_fetch("select license,license_pic from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
	}
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_card')." where weid=".$this->weid." and staff_id=".$id);
		
	include $this->template('staff/staff/s_cardlist');
}

if($foo == 'cardaddok'){
		$staff_id = intval($_GPC['staff_id']);
		
		$data['weid'] = $this->weid;
		$data['staff_id'] = $staff_id;
		$data['card_name'] = $_GPC['card_name'];
		load()->func('file');
		
		$path     = 'gohome/cardpic/';	
		$pic1 = $_GPC['pic1'];
		if(!empty($pic1)){
			$filename = date('YmdHis').'_1.jpg';
			$filename = $this->uploadImage($pic1, $path, $filename);
			$data['pic1'] = $filename;
		}
			
		$pic2 = $_GPC['pic2'];
		if(!empty($pic2)){
			$filename = date('YmdHis').'_2.jpg';
			$filename = $this->uploadImage($pic2, $path, $filename);
			$data['pic2'] = $filename;
		}
			
		$pic3 = $_GPC['pic3'];
		if(!empty($pic3)){
			$filename = date('YmdHis').'_3.jpg';
			$filename = $this->uploadImage($pic3, $path, $filename);
			$data['pic3'] = $filename;
		}
			
		$res = pdo_insert('xm_gohome_card',$data);
		if($res){
			$sitem = pdo_fetch("select card_all from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$staff_id);
			$u_info['card_all'] = $_GPC['card_name'].','.$sitem['card_all'];
			pdo_update('xm_gohome_staff', $u_info, array('id'=>$staff_id));

			message('证件上传成功！请等待管理员审核', $this->createMobileUrl('Validate', array('foo'=>'index')), 'success');
		}else{
			message('证件上传失败，请稍后再试！');
		}
}

if($foo == 'delete'){
	$id = $_GPC['id'];
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_staff',$data,array('id'=>$id));
	if($res){
		message('删除成功！', $this->createMobileUrl('staff', array('foo'=>'manager')), 'success');
	}else{
		message('删除失败');
	}
}

if($foo == "project"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}
	$item = pdo_fetch("select id,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
	if(empty($item['serve_type'])){
		message('数据不完善，无法显示！');
		exit();
	}

	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and parent_id=0 and delstate=1");
		
	include $this->template('staff/staff/s_staffproject');
}

if($foo == "projectok"){
	$id = $_GPC['staff_id'];
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}
	$item = pdo_fetch("SELECT serve_type FROM ".tablename('xm_gohome_staff')." WHERE weid=".$this->weid." AND delstate=1 AND id=".$id);
	$arr = explode(',',$item['serve_type']);
	//服务项目
	$servetype = $_GPC['servetype'];
	foreach($arr as $val)
	{
		if(in_array($val,$servetype))
		{
			message('不能重复申请同一项目！');
			exit();
		}
	}
	$serve_type = implode(",", $servetype);
	$data['sserve_type'] = $serve_type;
	$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
	if($res){
		message('申请成功！请等待管理员审核', $this->createMobileUrl('Validate', array()), 'success');
	}else{
		message('申请失败！');
	}
}

?>