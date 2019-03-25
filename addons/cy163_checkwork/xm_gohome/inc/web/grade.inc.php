<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index','add','addok','edit','editok','delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
		
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_grade')." WHERE weid =".$_W['uniacid']." and delstate=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_grade')." WHERE weid = ".$_W['uniacid']." and delstate=1");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
	include $this->template('web/grade/grade-list');
}

if($foo == 'add'){
	include $this->template('web/grade/grade-add');
}

if($foo == 'addok'){
	if(checksubmit()){
		if(empty($_GPC['grade_name'])){
			message('保证金名称不能为空！');
		}
		if(empty($_GPC['grade_money'])){
			message('保证金金额不能为空！');
		}
		if(empty($_GPC['icon'])){
			message('保证金标志不能为空！');
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_grade')." where weid=".$_W['uniacid']." and grade_name='".$_GPC['grade_name']."' and delstate=1");
		if(empty($check['id'])){
			$data['weid'] = $_W['uniacid'];
			$data['grade_name'] = $_GPC['grade_name'];
			$data['grade_money'] = $_GPC['grade_money'];
			$data['icon'] = $_GPC['icon'];
			$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
			$res = pdo_insert('xm_gohome_grade', $data);
			if($res){
				message('保证金级别添加成功！', $this->createWebUrl('grade', array('foo'=>'index')), 'success');
			}else{
				message('保证金级别添加失败！');
			}
		}else{
			message('该级别名称已存在，请输入新的级别名称！');
		}
	}
}

if($foo == 'edit'){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_grade')." where weid=".$this->weid." and id=".$id);
		
	include $this->template('web/grade/grade-edit');
}

if($foo == 'editok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
		if(empty($_GPC['grade_name'])){
			message('保证金名称不能为空！');
		}
		if(empty($_GPC['grade_money'])){
			message('保证金金额不能为空！');
		}
		if(empty($_GPC['icon'])){
			message('保证金标志不能为空！');
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_grade')." where weid=".$this->weid." and grade_name='".$_GPC['grade_name']."' and id!=".$id." and delstate=1");
		if(empty($check['id'])){
			$data['grade_name'] = $_GPC['grade_name'];
			$data['grade_money'] = $_GPC['grade_money'];
			$data['icon'] = $_GPC['icon'];
			$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
			$res = pdo_update('xm_gohome_grade', $data, array('id'=>$id));
			if($res){
				message('保证金级别修改成功！', $this->createWebUrl('grade', array('foo'=>'index')), 'success');
			}else{
				message('保证金级别修改失败！');
			}
		}else{
			message('该级别名称已存在，请输入新的级别名称！');
		}
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_grade', $data, array('id'=>$id));
	if($res){
		message('删除成功！', $this->createWebUrl('grade', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}
?>