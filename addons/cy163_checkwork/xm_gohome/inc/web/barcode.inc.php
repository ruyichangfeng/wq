<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_barcode')." WHERE weid =".$this->weid." and delstate=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_barcode')." WHERE weid = ".$this->weid." and delstate=1 ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/barcode/barcode-list');
}

if($foo == "add"){

	include $this->template('web/barcode/barcode-add');
}

if($foo == "addok"){
	$id 			= intval($_GPC['id']);
	$barcode_number = $_GPC['barcode_number'];
	$barcode_name   = $_GPC['barcode_name'];
	if(empty($id)){
		$check = pdo_fetch("select id from ".tablename('xm_gohome_barcode')." where weid=".$this->weid." and delstate=1 and barcode_number='".$barcode_number."'");
	}else{
		$check = pdo_fetch("select id from ".tablename('xm_gohome_barcode')." where weid=".$this->weid." and delstate=1 and barcode_number='".$barcode_number."' and id !=".$id);
	}

	$data['barcode_number'] = $barcode_number;
	$data['barcode_name']   = $barcode_name;
	$data['pic']			= $_GPC['pic'];
	if(empty($check)){
		if(empty($id)){
			$data['weid'] = $this->weid;
			$res = pdo_insert("xm_gohome_barcode", $data);
			if($res){
				message("添加条形码成功！", $this->createWebUrl('barcode', array('foo'=>'index')), 'success');
			}else{
				message("添加条形码失败！");
			}
		}else{
			$res = pdo_insert("xm_gohome_barcode", $data, array('id'=>$id));
			if($res){
				message("修改条形码成功！", $this->createWebUrl('barcode', array('foo'=>'index')), 'success');
			}else{
				message("修改条形码失败！");
			}
		}
	}else{
		message("该条形码编号已经存在！");
	}
}

?>