<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_print')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_print')." WHERE weid = ".$this->weid." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/cloudprint/print-list');
}

if($foo == 'add'){
	$id         = intval($_GPC['id']);
	$company_id = intval($_GPC['company_id']);
	$mark       = $_GPC['mark'];

	if(empty($id)){
		$staff_id = '';
	}else{
		$staff_id = $id;
	}
		
	include $this->template('web/cloudprint/print-add');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$id         = intval($_GPC['id']);
		$company_id = intval($_GPC['company_id']);
		$mark       = $_GPC['mark'];

		if(empty($_GPC['staff_id'])){
			message('工人ID不能为空！');
		}
		if(empty($_GPC['printer_sn'])){
			message('printer_sn不能为空！');
		}
		if(empty($_GPC['key_info'])){
			message('key不能为空！');
		}
			
		if(empty($_GPC['number'])){
			message('打印联数不能为空！');
		}
		if($_GPC['number']>9){
			message('打印联数最大值为9！');
		}
		if(empty($_GPC['xiaopiao'])){
			message('小票内容不能为空！');
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_print')." where staff_id=".$_GPC['staff_id']);
		if(empty($check['id'])){
			$data['staff_id'] = $_GPC['staff_id'];
			$data['printer_sn'] = $_GPC['printer_sn'];
			$data['key_info'] = $_GPC['key_info'];
			//$data['ip'] = $_GPC['ip'];
			$data['number'] = $_GPC['number'];
			//$data['xiaopiao'] = htmlspecialchars_decode($_GPC['xiaopiao']);
			$data['xiaopiao'] = htmlspecialchars_decode($_GPC['xiaopiao']);
			$data['weid'] = $this->weid;
			$res = pdo_insert('xm_gohome_print',$data);
			if($res){
				$data_u['print_state'] = 1;
				pdo_update('xm_gohome_staff',$data_u, array('id'=>$_GPC['staff_id']));
				if(!empty($company_id)){
					message('数据添加成功！', $this->createWebUrl('company', array('foo'=>'look', 'id'=>$company_id)), 'success');
				}else{
					if($mark == 'staff'){
						message('数据添加成功！', $this->createWebUrl('serveperson', array('foo'=>'index')), 'success');
					}else{
						message('数据添加成功！', $this->createWebUrl('cloudprint', array('foo'=>'index')), 'success');
					}
				}
			}else{
				message('数据添加失败！');
			}
		}else{
			message('该工人已录入打印机,如需修改请到');
		}
	}
}

if($foo == 'edit'){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_print')." where id=".$id);
		
	include $this->template('web/cloudprint/print-edit');
}

if($foo == 'editok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['staff_id'])){
			message('工人ID不能为空！');
		}
		if(empty($_GPC['printer_sn'])){
			message('printer_sn不能为空！');
		}
		if(empty($_GPC['key_info'])){
			message('key不能为空！');
		}
			
		if(empty($_GPC['number'])){
			message('打印联数不能为空！');
		}
		if($_GPC['number']>9){
			message('打印联数最大值为9！');
		}
		if(empty($_GPC['xiaopiao'])){
			message('小票内容不能为空！');
		}
		$data['staff_id'] = $_GPC['staff_id'];
		$data['printer_sn'] = $_GPC['printer_sn'];
		$data['key_info'] = $_GPC['key_info'];
		//$data['ip'] = $_GPC['ip'];
		$data['number'] = $_GPC['number'];
		$data['xiaopiao'] = htmlspecialchars_decode($_GPC['xiaopiao']);
		$res = pdo_update('xm_gohome_print',$data,array('id'=>$id));
		if($res){
			message('数据修改成功！', $this->createWebUrl('cloudprint', array('foo'=>'index')), 'success');
		}else{
			message('数据修改失败！');
		}
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select staff_id from ".tablename('xm_gohome_print')." where id=".$id);
	$data['print_state'] = 0;
	$res = pdo_update('xm_gohome_staff',$data, array('id'=>$item['staff_id']));
	if($res){
		pdo_delete('xm_gohome_print',array('id'=>$id));
		message('删除成功！', $this->createWebUrl('cloudprint', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

?>