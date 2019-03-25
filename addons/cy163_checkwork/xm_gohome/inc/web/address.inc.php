<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_address')." WHERE weid =".$this->weid." and delstate=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_address')." WHERE weid = ".$this->weid." and delstate=1 ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/address/adrlist');
}

if($foo == 'add'){
	include $this->template('web/address/adr-add');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$location = $_GPC['location'];
		if(empty($location['lng'])){
			$lng = '116.403963';
		}else{
			$lng = $location['lng'];
		}
			
		if(empty($location['lat'])){
			$lat = '39.923966';
		}else{
			$lat = $location['lat'];
		}
		$data['adr_name'] = $_GPC['adr_name'];
		$data['lng'] 	  = $lng;
		$data['lat'] 	  = $lat;
		$data['stop'] 	  = $_GPC['stop'];
		$data['delstate'] = 1;
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_address',$data);
			if($result){
				message('地区数据添加成功！', $this->createWebUrl('address', array('foo'=>'index')), 'success');
			}else{
				message('地区数据添加失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_address', $data, array('id'=>$id));
			if($result){
				message('地区数据修改成功！', $this->createWebUrl('address', array('foo'=>'index')), 'success');
			}else{
				message('地区数据修改失败！');
			}
		}
	}
}

if($foo == 'edit'){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("SELECT * FROM ".tablename('xm_gohome_address')." WHERE weid=".$this->weid." AND id=".$id);
	$getLat = array('lng'=>$item['lng'],'lat'=>$item['lat']);
	
	include $this->template('web/address/adr-edit');
}


if($foo == 'delete'){
	$id = intval($_GPC['id']);
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_address', $data, array('id'=>$id));
	if($res){
		message('删除成功！', $this->createWebUrl('address', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

?>