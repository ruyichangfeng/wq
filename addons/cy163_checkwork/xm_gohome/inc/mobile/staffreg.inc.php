<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('staffReg', 'xieyi', 'staffRegOk', 'companyReg', 'companyRegOk', 'merchantReg', 'merchantRegOk');
$foo = in_array($foo, $foos) ? $foo : 'staffReg';

if($foo == 'staffReg'){
	$list = pdo_fetchall("select id,type_name,child_num from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and parent_id=0 and chao=0 and delstate=1");
	
	$list1 = pdo_fetchall("select id,adr_name from ".tablename('xm_gohome_address')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");

	$list2 = pdo_fetchall("select id,lido_name from ".tablename('xm_gohome_lido')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");

	$list3 = pdo_fetchall("select id,type_name from ".tablename('xm_gohome_type')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");

	$timeout = $this->getBase('timeout')*60;
	$sauthen = $this->getBase('sauthen');
	load()->func('tpl');
			
	include $this->template('staff/reg/s_personreg');	
}

if($foo == 'xieyi'){
	$type = intval($_GPC['type']);

	$item = pdo_fetch("select xieyi_content from ".tablename('xm_gohome_xieyi')." where weid=".$this->weid." and type=".$type);
			
	include $this->template('staff/reg/xieyi');
}


if($foo == 'staffRegOk'){
	$leixing1     = $_GPC['leixing1'];
	$leixing2     = $_GPC['leixing2'];

	$staff_mobile = $_GPC['staff_mobile'];
	$item = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid = '".$openid."' and delstate=1 and company_flag=0");
	if(empty($item['id'])){
		$citem = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and staff_mobile = '".$staff_mobile."' and delstate=1");
		if(empty($citem['id'])){
			$data['weid'] = $this->weid;
			$data['avatar'] = $_GPC['avatar'];
			$data['servetype'] = $_GPC['servetype'];
			$data['jw'] = $_GPC['jw'];
			$data['openid'] = $openid;
			$data['staff_name'] = $_GPC['staff_name'];
			$data['card'] = $_GPC['card'];
			$data['staff_mobile'] = $staff_mobile;
			$data['sex'] = $_GPC['sex'];
			$data['age'] = $_GPC['age'];
			$data['year'] = $_GPC['year'];
			$data['bank'] = $_GPC['bank'];
			$data['bank_num'] = $_GPC['bank_num'];
			$data['alipay'] = $_GPC['alipay'];
			$data['permanent'] = $_GPC['text_'];
				
			if($this->getBase('sauthen')){
				$code = $_GPC['code'];
				$nowtime = time();
					
				$check = pdo_fetch("select id,code from ".tablename('xm_gohome_code')." where weid=".$this->weid." and mobile=".$staff_mobile." and type=2 and isUse=0 and ".$nowtime." between starttime and endtime");
				if(!empty($check)){
					if($check['code'] == $code){
						$res = $this->addPersonreg($data);	
						if($res){
							$data_c['isUse'] = '1';
							pdo_update('xm_gohome_code', $data_c, array('id'=>$check['id']));
							if($leixing2 == 1){
								$staff_id      = intval($res);
								$merchant_name = $_GPC['merchant_name'];
								$check = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and merchant_name='".$merchant_name."'");
								if(empty($check)){
									if(!empty($_GPC['coverpic'])){
										$name 	    = date('YmdHis').'1.jpg';
										$coverpic   = $_GPC['coverpic'];
										$path       = 'gohome/coverpic/';
										$filename   = $this->uploadImage($coverpic, $path, $name);
										$data_m['coverpic'] = $filename;
									}

									if(!empty($_GPC['license_pic'])){
										$name2 	    = date('YmdHis').'2.jpg';
									    $license_pic= $_GPC['license_pic'];			
										$path1      = 'gohome/mlicense/';
										$filename1  = $this->uploadImage($license_pic, $path1, $name2);
										$data_m['license_pic'] = $filename1;
									}

									$jw  = $_GPC['jw1'];
									$arr = explode(",",$jw);
									$lng = $arr[0];
									$lat = $arr[1];
									if($_GPC['merchant_song'] == ''){
										$merchant_song = 0;	
									}else{
										$merchant_song = $_GPC['merchant_song'];
									}
									$data_m['weid'] = $this->weid;
									$data_m['openid']        = $openid;
									$data_m['staff_id']      = $staff_id;
									$data_m['merchant_name'] = $merchant_name;
									$data_m['adr_id']        = $_GPC['adr_id'];
									$data_m['lido_id']       = $_GPC['lido_id'];
									$data_m['type_id']       = $_GPC['type_id'];
									$data_m['merchant_address']= $_GPC['text_'];
									$data_m['lng']   		= $lng;
									$data_m['lat']			= $lat;
									$data_m['adrstr']		= $this->encode_geohash($lat,$lng,12);
									$data_m['merchant_mobile']= $staff_mobile;
									$data_m['merchant_phone']= $_GPC['merchant_phone'];
									$data_m['merchant_time'] = $_GPC['merchant_time'];
									$data_m['merchant_price']= $_GPC['merchant_price'];
									$data_m['merchant_song'] = $merchant_song;
									$data_m['night']   		= $_GPC['night'];
									$data_m['license']       = $_GPC['license'];
									$data_m['stop']          = 0;
									$data_m['state']         = 0;
									$res = pdo_insert('xm_gohome_merchant', $data_m);
									if($res){
										message('商铺申请提交成功，请等待管理员审核', $this->createMobileUrl('Validate', array('foo'=>'index')));
									}else{
										message('商铺申请提交失败，请重试');
									}
								}else{
									message('该商铺已经添加！');
								}
							}else{
								message('申请成功！请等待管理员审核', $this->createMobileUrl('Validate', array()), 'success');
							}
						}else{
							message('注册失败！');
						}						
					}else{
						message('验证码错误或已失效！');
					}
				}else{
					message('验证码错误或已失效！');
				}
			}else{
				$res = $this->addPersonreg($data);
				if($res){
					if($leixing2 == 1){
						$staff_id      = intval($res);
						$merchant_name = $_GPC['merchant_name'];
						$check = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and merchant_name='".$merchant_name."'");
						if(empty($check)){
							if(!empty($_GPC['coverpic'])){
								$name 	    = date('YmdHis').'1.jpg';
								$coverpic   = $_GPC['coverpic'];
								$path       = 'gohome/coverpic/';
								$filename   = $this->uploadImage($coverpic, $path, $name);
								$data_m['coverpic'] = $filename;
							}

							if(!empty($_GPC['license_pic'])){
								$name2 	    = date('YmdHis').'2.jpg';
							    $license_pic= $_GPC['license_pic'];			
								$path1      = 'gohome/mlicense/';
								$filename1  = $this->uploadImage($license_pic, $path1, $name2);
								$data_m['license_pic'] = $filename1;
							}

							$jw  = $_GPC['jw1'];
							$arr = explode(",",$jw);
							$lng = $arr[0];
							$lat = $arr[1];

							if($_GPC['merchant_song'] == ''){
								$merchant_song = 0;	
							}else{
								$merchant_song = $_GPC['merchant_song'];
							}
			
							$data_m['weid'] = $this->weid;
							$data_m['openid']        = $openid;
							$data_m['staff_id']      = $staff_id;
							$data_m['merchant_name'] = $merchant_name;
							$data_m['adr_id']        = $_GPC['adr_id'];
							$data_m['lido_id']       = $_GPC['lido_id'];
							$data_m['type_id']       = $_GPC['type_id'];
							$data_m['merchant_address']= $_GPC['text_'];
							$data_m['lng']   		= $lng;
							$data_m['lat']			= $lat;
							$data_m['adrstr']		= $this->encode_geohash($lat,$lng,12);
							$data_m['chao']         = $_GPC['chao'];
							$data_m['chao_url']		= $_GPC['chao_url'];
							$data_m['merchant_mobile']= $staff_mobile;
							$data_m['merchant_phone']= $_GPC['merchant_phone'];
							$data_m['merchant_time'] = $_GPC['merchant_time'];
							$data_m['merchant_price']= $_GPC['merchant_price'];
							$data_m['merchant_song'] = $merchant_song;
							$data_m['night']   		= $_GPC['night'];
							$data_m['license']       = $_GPC['license'];
							$data_m['stop']          = 0;
							$data_m['state']         = 0;
							$res = pdo_insert('xm_gohome_merchant', $data_m);
							if($res){
								message('商铺申请提交成功，请等待管理员审核', $this->createMobileUrl('Validate', array('foo'=>'index')));
							}else{
								message('商铺申请提交失败，请重试');
							}
						}else{
							message('该商铺已经添加！');
						}
					}else{
						message('申请成功！请等待管理员审核', $this->createMobileUrl('Validate', array()), 'success');
					}
				}else{
					message('注册失败！');
				}
			}
		}else{
			message('该手机号码已申请,请重新输入手机号码！');
		}	
	}else{
		message('该微信号已申请注册！');
	}
}

if($foo == 'companyReg'){
	$item = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and delstate=1");
		
	$sauthen = $this->getBase('sauthen');
	$timeout = $this->getBase('timeout')*60;
		
	include $this->template('staff/reg/s_companyreg');
}

if($foo == 'companyRegOk'){
	$id = $_GPC['id'];
		
	$data['id'] = $id;
	$data['weid'] = $this->weid;
	$data['openid'] = $openid;
	$data['staff_name'] = $_GPC['staff_name'];
	$data['staff_mobile'] = $_GPC['staff_mobile'];
	$data['company_name'] = $_GPC['company_name'];
	$data['contact'] = $_GPC['contact'];
	$data['address'] = $_GPC['address'];
	$data['logo'] = $_GPC['logo'];
	$data['bank'] = $_GPC['bank'];
	$data['bank_num'] = $_GPC['bank_num'];
	$data['alipay'] = $_GPC['alipay'];
	$data['license'] = $_GPC['license'];
	$data['license_pic'] = $_GPC['license_pic'];

	$check1 = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and openid='".$openid."' and company_flag=1");
	if(empty($check1['id'])){
		$check2 = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and company_name='".$_GPC['company_name']."' and company_flag=1");
		if(empty($check2['id'])){
			if($this->getBase('sauthen')){
				$code = $_GPC['code'];
				$nowtime = time();
							
				$check = pdo_fetch("select id,code from ".tablename('xm_gohome_code')." where weid=".$this->weid." and mobile=".$_GPC['staff_mobile']." and type=2 and isUse=0 and ".$nowtime." between starttime and endtime");
				if(!empty($check)){
					if($check['code'] == $code){
						$res = $this->addCompanyreg($data);
						if($res){
							$data_c['isUse'] = '1';
							pdo_update('xm_gohome_code', $data_c, array('id'=>$check['id']));
							message('公司申请成功！请等待管理员审核通过', $this->createMobileUrl('Validate', array()), 'success');
						}else{
							message('公司申请失败，请稍后再试！');
						}
					}else{
						message('验证码错误或已失效！');
					}
				}else{
					message('验证码错误或已失效！');
				}
			}else{
				$res = $this->addCompanyreg($data);
				if($res){
					message('公司申请成功！请等待管理员审核通过', $this->createMobileUrl('Validate', array()), 'success');
				}else{
					message('公司申请失败，请稍后再试！');
				}
			}
		}else{
			message('该公司已申请注册,不能重复申请！');
		}	
	}else{
		message('该微信号已申请注册！');
	}
	
}

if($foo == 'merchantReg'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误：未获取到ID');
		exit();
	}
	$check = pdo_fetch("select id,state from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and staff_id=".$id);
	if(!empty($check['id']) && $check['state']==0){
		$check = 1;
	}else{

		$list1 = pdo_fetchall("select id,adr_name from ".tablename('xm_gohome_address')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");

		$list2 = pdo_fetchall("select id,lido_name from ".tablename('xm_gohome_lido')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");

		$list3 = pdo_fetchall("select id,type_name from ".tablename('xm_gohome_type')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");
	}

	include $this->template('staff/reg/s_merchantreg');
}

if($foo == 'merchantRegOk'){
	$staff_id      = intval($_GPC['staff_id']);
	$merchant_name = $_GPC['merchant_name'];
	$check = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and merchant_name='".$merchant_name."'");
	if(empty($check)){
		if(!empty($_GPC['coverpic'])){
			$coverpic   = $_GPC['coverpic'];
			$filename   = date('YmdHis').'logo.jpg';
			$path       = 'gohome/coverpic/';
			$this->uploadImage($coverpic, $path, $filename);
			$data['coverpic'] = $filename;
		}

		if(!empty($_GPC['license_pic'])){
		    $license_pic    = $_GPC['license_pic'];
		    $filename1   = date('YmdHis').'license.jpg';
			$path1      = 'gohome/mlicense/';
			$this->uploadImage($license_pic, $path1, $filename1);
			$data['license_pic'] = $filename1;
		}

		$jw  = $_GPC['jw'];
		$arr = explode(",",$jw);
		$lng = $arr[0];
		$lat = $arr[1];

		if($_GPC['merchant_song'] == ''){
			$merchant_song = 0;
		}else{
			$merchant_song = $_GPC['merchant_song'];
		}
		$data['weid'] = $this->weid;
		$data['openid']        = $openid;
		$data['staff_id']      = $staff_id;
		$data['merchant_name'] = $merchant_name;
		$data['adr_id']        = $_GPC['adr_id'];
		$data['lido_id']       = $_GPC['lido_id'];
		$data['type_id']       = $_GPC['type_id'];
		$data['merchant_address']= $_GPC['text_'];
		$data['lng']   		= $lng;
		$data['lat']			= $lat;
		$data['adrstr']		= $this->encode_geohash($lat,$lng,12);
		$data['chao']       = $_GPC['chao'];
		$data['chao_url']   = $_GPC['chao_url'];
		$data['merchant_mobile']= $_GPC['merchant_mobile'];
		$data['merchant_phone']= $_GPC['merchant_phone'];
		$data['merchant_time'] = $_GPC['merchant_time'];
		$data['merchant_price']= $_GPC['merchant_price'];
		$data['merchant_song'] = $merchant_song;
		$data['night']   		= $_GPC['night'];
		$data['license']       = $_GPC['license'];
		$data['stop']          = 0;
		$data['state']         = 0;
		$res = pdo_insert('xm_gohome_merchant', $data);
		if($res){
			message('商铺申请提交成功，请等待管理员审核', $this->createMobileUrl('Validate', array('foo'=>'index')));
		}else{
			message('商铺申请提交失败，请重试');
		}
	}else{
		message('该商铺已经添加！');
	}
}

?>