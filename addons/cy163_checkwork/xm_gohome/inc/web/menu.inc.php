<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('list', 'add', 'addok', 'delete', 'curry', 'curryadd', 'curryaddok', 'delcurry');
$foo = in_array($foo, $foos) ? $foo : 'list';

if($foo == 'list') {
	$merchant_id = intval($_GPC['merchant_id']);
	
    $pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
	
	if (!empty($_GPC['keyword'])) {
		$condition .= " AND merchant_name LIKE :merchant_name";
		$params[':merchant_name'] = "%{$_GPC['keyword']}%";
	}
	
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_menu')." WHERE `weid` = ".$_W['uniacid']." and merchant_id=".$merchant_id." and delstate=1 $condition ORDER BY top asc LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_menu') . " WHERE weid = ".$_W['uniacid']." and merchant_id=".$merchant_id." and delstate=1 $condition";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
    include $this->template('web/takeout/menu');
}

if($foo == 'add'){
	$merchant_id = intval($_GPC['merchant_id']);
	$id = intval($_GPC['id']);
	if(!empty($id)){
		$item = pdo_fetch("SELECT * FROM ".tablename('xm_gohome_menu')." WHERE weid=".$_W['uniacid']." AND id=".$id);
	}
	
	include $this->template('web/takeout/menu-add');
}

if($foo == 'addok'){
	
	if(checksubmit('submit')){
		$menu_name = $_GPC['menu_name'];
		$merchant_id = intval($_GPC['merchant_id']);
		$id = intval($_GPC['id']);
		if(empty($merchant_id)){
			message('商铺参数不全，请刷新重试');
		}
		if(empty($menu_name)){
			message('菜系名称不能为空');
		}
		
		if(empty($id)){
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_menu')." WHERE weid=".$_W['uniacid']." AND menu_name='".$menu_name."' AND merchant_id=".$merchant_id." and delstate=1");
		}else{
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_menu')." WHERE weid=".$_W['uniacid']." AND menu_name='".$menu_name."' AND merchant_id=".$merchant_id." AND id !=".$id." and delstate=1");
		}
		if(empty($check['id'])){
			$data['merchant_id'] = $merchant_id;
			$data['menu_name'] = $menu_name;
			$data['top'] = $_GPC['top'];
			$data['stop'] = $_GPC['stop'];
			if(empty($id)){
				$data['weid'] = $_W['uniacid'];
				$res = pdo_insert('xm_gohome_menu', $data);
				if($res){
					message('添加菜系成功！', $this->createWebUrl('menu', array('foo'=>'list', 'merchant_id'=>$merchant_id)), 'success');
				}else{
					message('添加菜系失败！');
				}	
			}else{
				$data['updatetime'] = date('Y-m-d H:i:s');
				$res = pdo_update('xm_gohome_menu', $data, array('id'=>$id));
				if($res){
					message('修改菜系成功！', $this->createWebUrl('menu', array('foo'=>'list', 'merchant_id'=>$merchant_id)), 'success');
				}else{
					message('修改菜系失败！');
				}
			}
		}else{
			message('该菜系已经添加在'.$this->getMerchantInfo($merchant_id, 'merchant_name').'下，不能重复添加！');
		}
	}	
}


if($foo == 'delete'){
	$merchant_id = intval($_GPC['merchant_id']);
	$id = intval($_GPC['id']);
	$res = pdo_delete('xm_gohome_menu', array('id'=>$id));
	if($res){
		message('删除菜系成功！', $this->createWebUrl('menu', array('foo'=>'list', 'merchant'=>$merchant_id)), 'success');
	}else{
		message('删除菜系失败！');
	}
}

if($foo == 'curry') {
	$merchant_id = intval($_GPC['merchant_id']);	
	$id = intval($_GPC['id']);	
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
	/*
	if (!empty($_GPC['keyword'])) {
		$condition .= " AND area_name LIKE :area_name";
		$params[':area_name'] = "%{$_GPC['keyword']}%";
	}
	*/
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_curry')." WHERE `weid` = ".$_W['uniacid']." and merchant_id=".$merchant_id." and menu_id=".$id." and delstate=1 $condition ORDER BY top ASC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_curry') . " WHERE weid = ".$_W['uniacid']." and merchant_id=".$merchant_id." and menu_id=".$id." and delstate=1 $condition";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
    include $this->template('web/takeout/curry');
}

if($foo == 'curryadd'){
	$merchant_id = intval($_GPC['merchant_id']);	
	$id = intval($_GPC['id']);
	
	$c_id = intval($_GPC['c_id']);
	if(!empty($c_id)){
		$item = pdo_fetch("SELECT * FROM ".tablename('xm_gohome_curry')." where id=".$c_id);
	}
	
	include $this->template('web/takeout/curry-add');
}

if($foo == 'curryaddok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
	
		$c_id = intval($_GPC['c_id']);
		$merchant_id = intval($_GPC['merchant_id']);
		$menu_id = $_GPC['menu_id'];
		$curry_name = $_GPC['curry_name'];
		if(empty($c_id)){
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_curry')." WHERE weid=".$_W['uniacid']." AND merchant_id=".$merchant_id." AND menu_id=".$menu_id." AND curry_name='".$curry_name."' and delstate=1");	
		}else{
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_curry')." WHERE weid=".$_W['uniacid']." AND merchant_id=".$merchant_id." AND menu_id=".$menu_id." AND curry_name='".$curry_name."' and delstate=1 and id !=".$c_id);
		}

		if(empty($check['id'])){
			$data['merchant_id'] = $merchant_id;
			$data['menu_id'] = $menu_id;
			$data['curry_name'] = $_GPC['curry_name'];
			$data['barcode_number'] = $_GPC['barcode_number'];
			$data['pic'] = $_GPC['pic'];
			$data['price'] = $_GPC['price'];
			$data['top'] = $_GPC['top'];
			$data['stop'] = $_GPC['stop'];
			$data['allsum'] = $_GPC['allsum'];
			$data['zan'] = $_GPC['zan'];
			$data['remark'] = $_GPC['remark'];
			$data['images'] = serialize($_GPC['images']);
			if(empty($c_id)){
				$data['weid'] = $_W['uniacid'];
				$res = pdo_insert('xm_gohome_curry', $data);
				if($res){
					pdo_query("update ".tablename('xm_gohome_menu')." set currysum=currysum+1 where id=".$menu_id);
					message('添加菜单成功！', $this->createWebUrl('menu', array('foo'=>'curry', 'merchant_id'=>$merchant_id, 'id'=>$id)), 'success');
				}else{
					message('添加菜单失败！');
				}	
			}else{
				$data['updatetime'] = date('Y-m-d H:i:s');
				$res = pdo_update('xm_gohome_curry', $data, array('id'=>$c_id));
				if($res){
					message('修改菜单成功！', $this->createWebUrl('menu', array('foo'=>'curry', 'merchant_id'=>$merchant_id, 'id'=>$id)), 'success');
				}else{
					message('修改菜单失败！');
				}
			}
		}else{
			message('该菜单名称已存在！');
		}
	}	
}


if($foo == 'delcurry'){
	$merchant_id = intval($_GPC['merchant_id']);
	$id = intval($_GPC['id']);
	$res = pdo_delete('xm_gohome_menu', array('id'=>$id));
	if($res){
		message('删除菜系成功！', $this->createWebUrl('menu', array('foo'=>'list', 'merchant'=>$merchant_id)), 'success');
	}else{
		message('删除菜系失败！');
	}
}
?>