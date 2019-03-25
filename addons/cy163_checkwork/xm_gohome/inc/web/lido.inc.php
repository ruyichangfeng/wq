<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'delete');
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
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_lido')." WHERE `weid` = ".$_W['uniacid']." and delstate=1 $condition ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_lido') . " WHERE weid = ".$_W['uniacid']." and delstate=1 $condition";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
    include $this->template('web/takeout/lido');
}

if($foo == 'add'){	
	$id = intval($_GPC['id']);
	if(!empty($id)){
		$item = pdo_fetch("SELECT * FROM ".tablename('xm_gohome_lido')." where id=".$id);
	}
	include $this->template('web/takeout/lido-add');
}

if($foo == 'addok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
		$lido_name = $_GPC['lido_name'];
		if(empty($id)){
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_lido')." WHERE weid=".$_W['uniacid']." AND lido_name='".$lido_name."' and delstate=1");	
		}else{
			$check = pdo_fetch("SELECT id FROM ".tablename('xm_gohome_lido')." WHERE weid=".$_W['uniacid']." AND lido_name='".$lido_name."' and delstate=1 and id !=".$id);
		}
		if(empty($check['id'])){
			$data['lido_name'] = $lido_name;
			$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
			$data['stop'] = $_GPC['stop'];
			if(empty($id)){
				$data['weid'] = $_W['uniacid'];
				$res = pdo_insert('xm_gohome_lido', $data);
				if($res){
					message('添加商圈成功！', $this->createWebUrl('lido', array('foo'=>'index')), 'success');
				}else{
					message('添加商圈失败！');
				}	
			}else{
				$data['updatetime'] = date('Y-m-d H:i:s');
				$res = pdo_update('xm_gohome_lido', $data, array('id'=>$id));
				if($res){
					message('修改商圈成功！', $this->createWebUrl('lido', array('foo'=>'index')), 'success');
				}else{
					message('修改商圈失败！');
				}
			}
		}else{
			message('该商圈已存在！');
		}
	}	
}

if($foo == "delete"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到商圈ID");
	}
	$data['delstate'] = 0;
	$res  =pdo_update("xm_gohome_lido", $data, array('id'=>$id));
	if($res){
		message('删除商圈成功！', $this->createWebUrl('lido', array('foo'=>'index')), 'success');
	}else{
		message('删除商圈失败！');
	}
}

?>