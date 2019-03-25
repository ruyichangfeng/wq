<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'edit', 'addok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$staff_id    = intval($_GPC['id']);
	$merchant_id = intval($_GPC['merchant_id']);

	if(empty($staff_id) && empty($merchant_id)){
		message('参数错误：未获取到用户ID');
		exit();
	}

	if(empty($merchant_id)){
		$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and staff_id=".$staff_id);
		if(empty($item)){
			message('访问异常：未获取到数据');
			exit();
		}
		$merchant_id = $item['id'];
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and merchant_id=".$merchant_id." and delstate=1 order by menu_id desc,top asc");

	include $this->template('staff/curry/s_curry');
}

if($foo == 'add'){
	$merchant_id = intval($_GPC['merchant_id']);
	$staff_id	 = intval($_GPC['staff_id']);
	if(empty($merchant_id)){
		message('参数错误：未获取到商铺ID');
	}
	$list = pdo_fetchall("select id,menu_name from ".tablename('xm_gohome_menu')." where weid=".$this->weid." and stop=1 and merchant_id=".$merchant_id." and delstate=1");

	include $this->template('staff/curry/s_curryadd');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$id 		 = intval($_GPC['id']);
		$staff_id    = intval($_GPC['staff_id']);
		$merchant_id = intval($_GPC['merchant_id']);
		$curry_name   = $_GPC['curry_name'];
		if(empty($curry_name)){
			message('商品名称不能为空！');
		}
		$menu_id = intval($_GPC['menu_id']);
		$price   = $_GPC['price'];
		$top     = $_GPC['top'];
		if(empty($top)){$top = 0;}
		$stop    = $_GPC['stop'];
		$zhe     = $_GPC['zhe'];
		$barcode_number = $_GPC['barcode_number'];
		$remark  = $_GPC['remark'];

		$data = array(
			'merchant_id' => $merchant_id,
			'curry_name'  => $curry_name,
			'menu_id'	  => $menu_id,
			'price'		  => $price,
			'top'         => $top,
			'stop'        => $stop,
			'zhe'         => $zhe,
			'barcode_number'=> $barcode_number,
			'remark'	  => $remark,
			'adrstr'      => $this->getMerchantInfo($merchant_id, 'adrstr')
		);
		if(!empty($_GPC['pic'])){
			$pic      = $_GPC['pic'];
			$path     = 'gohome/currypic/';
			$filename = $this->uploadImage($pic, $path);
			$data['pic'] = $filename;
		}

		if(empty($id)){
			$check = pdo_fetch("select id from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and merchant_id=".$merchant_id." and curry_name='".$curry_name."' and delstate=1");	
		}else{
			$check = pdo_fetch("select id from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and merchant_id=".$merchant_id." and curry_name='".$curry_name."' and id !=".$id." and delstate=1");
		}
		
		if(empty($check)){
			if(!empty($barcode_number)){
				if(empty($id)){
					$check1 = pdo_fetch("select id from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and delstate=1 and merchant_id=".$merchant_id." and barcode_number='".$barcode_number."'");
				}else{
					$check1 = pdo_fetch("select id from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and delstate=1 and merchant_id=".$merchant_id." and barcode_number='".$barcode_number."' and id!=".$id);
				}
				if(empty($check1)){
					if(empty($id)){
						$data['weid'] = $this->weid;
						$res = pdo_insert('xm_gohome_curry', $data);
						if($res){
							pdo_query("update ".tablename('xm_gohome_menu')." set currysum=currysum+1 where id=".$menu_id);
							message('商品添加成功，页面跳转中...', $this->createMobileUrl('curry',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
						}else{
							message('商品添加失败，请重试！');
						}
					}else{
						$data['updatetime'] = date('Y-m-d H:i:s');
						$res = pdo_update('xm_gohome_curry', $data, array('id'=>$id));
						if($res){
							message('商品修改成功，页面跳转中...', $this->createMobileUrl('curry',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
						}else{
							message('商品修改失败，请重试！');
						}
					}
				}else{
					message("该商品条形码已经存在！");
					exit();
				}
			}else{
				if(empty($id)){
					$data['weid'] = $this->weid;
					$res = pdo_insert('xm_gohome_curry', $data);
					if($res){
						pdo_query("update ".tablename('xm_gohome_menu')." set currysum=currysum+1 where id=".$menu_id);
						message('商品添加成功，页面跳转中...', $this->createMobileUrl('curry',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
					}else{
						message('商品添加失败，请重试！');
					}
				}else{
					$data['updatetime'] = date('Y-m-d H:i:s');
					$res = pdo_update('xm_gohome_curry', $data, array('id'=>$id));
					if($res){
						message('商品修改成功，页面跳转中...', $this->createMobileUrl('curry',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
					}else{
						message('商品修改失败，请重试！');
					}
				}
			}
		}else{
			message('该商品名称已存在！');
			exit();
		}
	}
}

if($foo == 'edit'){
	$id 		 = intval($_GPC['id']);
	$staff_id 	 = intval($_GPC['staff_id']);
	$merchant_id = intval($_GPC['merchant_id']);
	if(empty($merchant_id)){
		message('参数错误：未获取到商铺ID');
	}
	$list = pdo_fetchall("select id,menu_name from ".tablename('xm_gohome_menu')." where weid=".$this->weid." and stop=1 and merchant_id=".$merchant_id." and delstate=1");

	$item = pdo_fetch("select * from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and id=".$id);

	include $this->template('staff/curry/s_curryadd');
}

if($foo == 'delete'){
	$id 		 = intval($_GPC['id']);
	$staff_id	 = intval($_GPC['staff_id']);
	$merchant_id = intval($_GPC['merchant_id']);
	if(empty($merchant_id)){
		message('参数错误：未获取到商铺ID');
	}
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_curry', $data, array('id'=>$id));
	if($res){
		pdo_query("update ".tablename('xm_gohome_menu')." set currysum=currysum-1 where id=".$menu_id);
		message('菜单删除成功，页面跳转中...', $this->createMobileUrl('curry',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
	}else{
		message('菜单删除失败，请重试！');
	}
}

?>