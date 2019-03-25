<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('staffmobile', 'staffmobileok', 'info', 'companyeditok', 'personeditok');
$foo = in_array($foo, $foos) ? $foo : 'staffmobile';

if($foo == 'staffmobile'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}

	$item = pdo_fetch("select id,staff_mobile from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		
	$timeout = $this->getBase('timeout')*60;
		
	include $this->template('staff/edit/s_editmobile');
}

if($foo == 'staffmobileok'){
	$id = intval($_GPC['id']);
	$mobile = $_GPC['mobile'];
		
	$check_m = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and staff_mobile='".$mobile."'");
	if(empty($check_m)){
		$code = $_GPC['code'];
		$nowtime = time();
		$check = pdo_fetch("select id,code from ".tablename('xm_gohome_code')." where weid=".$this->weid." and mobile=".$mobile." and type=2 and isUse=0 and ".$nowtime." between starttime and endtime");
		if(empty($check)){
			echo 0;
		}else{
			if($code == $check['code']){
				$data['staff_mobile'] = $mobile;
				$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
				if($res){
					$data_c['isUse'] = '1';
					pdo_update('xm_gohome_code', $data_c, array('id'=>$check['id']));
					echo 1;
				}else{
					echo 2;
				}
			}else{
				echo 3;
			}
		}
	}else{
		echo 4;
	}
}

if($foo == 'info'){
	$staff_id = intval($_GPC['staff_id']);
	$type     = $_GPC['type'];
	if($type == 'company'){
		$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=1 and delstate=1 and id=".$staff_id);
				
		include $this->template('staff/edit/s_editinfocompany');
	}else{
		$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and parent_id=0 and chao=0 and delstate=1");
		
		$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
		
		$servetype = explode(",", $item['serve_type']);
		$s_flag = 0;
		if(empty($servetype)){
			$s_flag = 1;
		}

		$flag      = $_GPC['flag']; 

		include $this->template('staff/edit/s_editinfoperson');
	}
}

if($foo == 'companyeditok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$company_name = $_GPC['company_name'];
		$data['staff_name'] = $_GPC['staff_name'];
		$data['company_name'] = $_GPC['company_name'];
		$data['contact'] = $_GPC['contact'];
		$data['address'] = $_GPC['address'];
		$data['bank'] = $_GPC['bank'];
		$data['bank_num'] = $_GPC['bank_num'];
		$data['alipay'] = $_GPC['alipay'];
		$res = pdo_update('xm_gohome_staff',$data, array('id'=>$id));
		if($res){
			$c_openid = $this->getStaffInfo($id, 'openid');
			pdo_query("update ".tablename('xm_gohome_staff')." set company_name='".$company_name."' where weid=".$this->weid." and openid='".$c_openid."' and delstate=1");
			message('修改信息成功！', $this->createMobileUrl('Validate', array()), 'success');
		}else{
			message('修改信息失败！');
		}
	}
}

if($foo == 'personeditok'){
	if(checksubmit('submit')){
		$id     = intval($_GPC['id']);
		$avatar = $_GPC['avatar'];	
		if(!empty($avatar)){
			$path           = 'gohome/avatar/';
			$filename       = $this->uploadImage($avatar, $path);
			$data['avatar'] = $filename;
		}
		$data['staff_name'] = $_GPC['staff_name'];
		$data['sex']        = $_GPC['sex'];
		$data['bank'] = $_GPC['bank'];
		$data['bank_num'] = $_GPC['bank_num'];
		$data['alipay'] = $_GPC['alipay'];
		$jw = $_GPC['jw'];
		if(!empty($jw)){
			$jw_arr =  explode(",", $jw);
			$lng = $jw_arr[0];
			$lat = $jw_arr[1];
			$adrstr = $this->encode_geohash($lat,$lng,12);
			$data['log'] = $lng;
			$data['lat'] = $lat;
			$data['adrstr'] = $adrstr;
			$data['permanent'] = $_GPC['text_'];
		}
			
		$flag = $_GPC['flag'];
		if($flag != 1){	
			$servetype = $_GPC['servetype'];
			$serve_type = implode(",", $servetype);
			$data['serve_type'] = $serve_type;	
		}
			
		$res = pdo_update('xm_gohome_staff',$data, array('id'=>$id));
		if($res){
			message('修改成功！', $this->createMobileUrl('Validate', array()), 'success');
		}else{
			message('修改失败！');
		}
	}
}

?>