<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_gg')." WHERE weid =".$this->weid." ORDER BY top ASC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list1)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_gg')." WHERE weid = ".$this->weid);
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/guanggao/gg-list');
}

if($foo == 'add'){
	include $this->template('web/guanggao/gg-add');	
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		if(empty($_GPC['gg_name'])){
			message('幻灯片名称不能为空');
		}
		if(empty($_GPC['link'])){
			message('请输入链接地址');	
		}
		if(substr($_GPC['link'],0,7)!='http://'){
			message('链接地址必须以http://开头');
		}
		if(empty($_GPC['gg_adr'])){
			message('请选择显示位置');
		}
		if(empty($_GPC['pic'])){
			message('请输入上传图片');	
		}
			
		$data['weid'] = $this->weid;
		$data['gg_name'] = $_GPC['gg_name'];
		$data['link'] = $_GPC['link'];
		$data['gg_adr'] = $_GPC['gg_adr'];
		$data['pic'] = $_GPC['pic'];
		$data['top'] = $_GPC['top'];
		$data['stop'] = $_GPC['stop'];
		$result = pdo_insert('xm_gohome_gg',$data);
				
		if($result){
			message('推荐服务[广告]添加成功！', $this->createWebUrl('gg', array('foo'=>'index')), 'success');
		}else{
			message('推荐服务[广告]添加失败!');
		}
	}
}

if($foo == 'edit'){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_gg')." where id=".$id);
	
	include $this->template('web/guanggao/gg-edit');
}

if($foo == 'editok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
			
		if(empty($_GPC['gg_name'])){
			message('推荐服务[广告]名称不能为空');
		}
		if(empty($_GPC['link'])){
			message('请输入链接地址');	
		}
		if(substr($_GPC['link'],0,7)!='http://'){
			message('链接地址必须以http://开头');
		}
		if(empty($_GPC['gg_adr'])){
			message('请选择显示位置');
		}
		if(empty($_GPC['pic'])){
			message('请输入上传图片');	
		}
			
		$data['gg_name'] = $_GPC['gg_name'];
		$data['link'] = $_GPC['link'];
		$data['gg_adr'] = $_GPC['gg_adr'];
		$data['pic'] = $_GPC['pic'];
		$data['top'] = $_GPC['top'];
		$data['stop'] = $_GPC['stop'];
		$result = pdo_update('xm_gohome_gg', $data, array('id'=>$id));
		if($result){
			message('推荐服务[广告]修改成功！', $this->createWebUrl('gg', array('foo'=>'index')), 'success');
		}else{
			message('推荐服务[广告]修改失败!');
		}
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']); 
	$result = pdo_delete('xm_gohome_gg', array('id' => $id));
	if($result){
		message('删除成功！', $this->createWebUrl('gg', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

?>