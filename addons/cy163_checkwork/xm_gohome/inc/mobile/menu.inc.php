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
	$staff_id = intval($_GPC['id']);
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

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_menu')." where weid=".$this->weid." and merchant_id=".$merchant_id." and delstate=1 order by top asc");

	include $this->template('staff/menu/s_menu');
}

if($foo == 'add'){
	$staff_id = intval($_GPC['id']);
	$merchant_id = intval($_GPC['merchant_id']);
	if(empty($merchant_id)){
		message('参数错误：未获取到商铺ID');
		exit();
	}

	include $this->template('staff/menu/s_menuadd');	
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$id 		 = intval($_GPC['id']);
		$staff_id    = intval($_GPC['staff_id']);
		$merchant_id = intval($_GPC['merchant_id']);
		$menu_name   = $_GPC['menu_name'];
		if(empty($menu_name)){
			message('商品类别名称不能为空！');
		}
		$top 		 = $_GPC['top'];
		if(empty($top)){$top = 0;}
		$stop 		 = $_GPC['stop'];
		
		$data = array(
			'merchant_id' => $merchant_id,
			'menu_name'   => $menu_name,
			'top'         => $top,
			'stop'        => $stop
		);
		if(empty($id)){
			$check = pdo_fetch("select id from ".tablename('xm_gohome_menu')." where weid=".$this->weid." and merchant_id=".$merchant_id." and menu_name='".$menu_name."' and delstate=1");	
		}else{
			$check = pdo_fetch("select id from ".tablename('xm_gohome_menu')." where weid=".$this->weid." and merchant_id=".$merchant_id." and menu_name='".$menu_name."' and id !=".$id." and delstate=1");
		}
		
		if(empty($check)){
			if(empty($id)){
				$data['weid'] = $this->weid;
				$res = pdo_insert('xm_gohome_menu', $data);
				if($res){
					message('商品类别添加成功，页面跳转中...', $this->createMobileUrl('menu',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
				}else{
					message('商品类别添加失败，请重试！');
				}
			}else{
				$data['updatetime'] = date('Y-m-d H:i:s');
				$res = pdo_update('xm_gohome_menu', $data, array('id'=>$id));
				if($res){
					message('商品类别修改成功，页面跳转中...', $this->createMobileUrl('menu',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
				}else{
					message('商品类别修改失败，请重试！');
				}
			}
		}else{
			message('该商品类别名称已存在！');
			exit();
		}
	}
}

if($foo == 'edit'){
	$id 		 = intval($_GPC['id']);
	$staff_id    = intval($_GPC['staff_id']);
	$merchant_id = intval($_GPC['merchant_id']);
	if(empty($merchant_id) || empty($id)){
		message('参数错误：未获取到商铺ID');
		exit();
	}

	$item = pdo_fetch("select * from ".tablename('xm_gohome_menu')." where weid=".$this->weid." and id=".$id);
	if(empty($item)){
		message('访问异常：未获取到数据');
	}

	include $this->template('staff/menu/s_menuadd');
}

if($foo == 'delete'){
	$id 		 = intval($_GPC['id']);
	$staff_id	 = intval($_GPC['staff_id']);
	$merchant_id = intval($_GPC['merchant_id']);
	if(empty($merchant_id) || empty($id)){
		message('参数错误：未获取到商铺ID');
		exit();
	}
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_menu', $data, array('id'=>$id));
	if($res){
		message('删除成功，页面跳转中...', $this->createMobileUrl('menu',array('foo'=>'index', 'merchant_id'=>$merchant_id, 'id'=>$staff_id)), 'success');
	}else{
		message('删除失败，请重试！');
	}
}

?>