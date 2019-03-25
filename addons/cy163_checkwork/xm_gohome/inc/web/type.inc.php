<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'deltype');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
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
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_type')." WHERE `weid` = ".$_W['uniacid']." and delstate=1 $condition ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_type') . " WHERE weid = ".$_W['uniacid']." and delstate=1 $condition";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
    include $this->template('web/takeout/type');
}

if($foo == 'add'){
	
	include $this->template('web/takeout/type-add');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['type_name'])){
			message('品类名称不能为空！');
		}
		if(empty($_GPC['icon'])){
			message('品类图标不能为空！');
		}
		$type_name = $_GPC['type_name'];
		if(empty($id)){
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_type')." WHERE weid=".$_W['uniacid']." AND type_name='".$type_name."' and delstate=1");	
		}else{
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_type')." WHERE weid=".$_W['uniacid']." AND type_name='".$type_name."' and id !=".$id." and delstate=1");
		}
		if(empty($check['id'])){
			$data['type_name']  = $type_name;
			$data['icon']    	= $_GPC['icon'];
			$data['remark']  	= htmlspecialchars_decode($_GPC['remark']);
			$data['gettype'] 	= $_GPC['gettype'];
			$data['bili_bai']   = $_GPC['bili_bai'];
			$data['bili_money'] = $_GPC['bili_money'];
			$data['start']		= $_GPC['start'];
			$data['end']        = $_GPC['end'];
			$data['stop']    	= $_GPC['stop'];
			$data['delstate']   = 1;
			if(empty($id)){
				$data['weid'] = $_W['uniacid'];
				$res = pdo_insert('xm_gohome_type', $data);
				if($res){
					message('添加商铺类别成功！', $this->createWebUrl('type', array('foo'=>'index')), 'success');
				}else{
					message('添加商铺类别失败！');
				}	
			}else{
				$data['updatetime'] = date('Y-m-d H:i:s');
				$res = pdo_update('xm_gohome_type', $data, array('id'=>$id));
				if($res){
					message('修改商铺类别成功！', $this->createWebUrl('type', array('foo'=>'index')), 'success');
				}else{
					message('修改商铺类别失败！');
				}
			}
		}else{
			message('该商铺类别名称已存在！');
		}
	}	
}

if($foo == "edit"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到类别ID");
	}
	$item = pdo_fetch("SELECT * FROM ".tablename('xm_gohome_type')." where id=".$id);
	
	include $this->template('web/takeout/type-edit');
}

if($foo == "deltype"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到类别ID");
	}
	$data['delstate'] = 0;
	$res = pdo_update("xm_gohome_type", $data, array('id'=>$id));
	if($res){
		message('删除品类成功！', $this->createWebUrl('type', array('foo'=>'index')), 'success');
	}else{
		message('删除品类失败！');
	}	
}
?>