<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if('post' == $op){
	$id = intval($_GPC['id']);
	if(!empty($id)){
		//查找是否存在
		$item = pdo_fetch("SELECT * FROM ".tablename($this->modulename.'_cate')." WHERE id = :id" , array(':id' => $id));
		if (empty($item)) {
			message('数据不存在！', '', 'error');
		}
	}
	if(checksubmit('submit')){//检测是否post
		$title = trim($_GPC['title']);//分类名称
		if (empty($title)) {
			message('分类名称不能为空!');
		}

		$data = array(
				'weid'=>$_W['uniacid'],
				'title'=>$title,
				'status'=>$_GPC['status'],
				'displayorder'=>$_GPC['displayorder'],
		);
		if(empty($id)){
			pdo_insert($this->modulename.'_cate', $data);//添加数据
			message('分类添加成功！', $this->createWebUrl('mcate', array('op' => 'display')), 'success');
		}else{
			pdo_update($this->modulename.'_cate', $data, array('id' => $id));
			message('分类更新成功！', $this->createWebUrl('mcate', array('op' => 'display')), 'success');
		}
	}
}else if('del' == $op){//删除数据
	$id = intval($_GPC['id']);
	$row = pdo_fetch("SELECT id FROM ".tablename($this->modulename.'_cate')." WHERE id = :id", array(':id' => $id));
	if (empty($row)) {
		message('分类不存在！');
	}
		
	//删除该分类下的所有的东西
	pdo_delete($this->modulename.'_music', array('cate' => $id));
	pdo_delete($this->modulename.'_cate', array('id' => $id));
	message('删除成功！', referer(), 'success');
}else if('display'==$op){
	if (checksubmit('submit')){
		$displayorders = $_GPC['displayorder'];
		foreach ($displayorders as $id=>$displayorder){
			pdo_update($this->modulename.'_cate', array('displayorder'=>$displayorder), array('id'=>$id));
		}
		message('批量更改排序成功',referer(),'success');
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize =20;//每页显示
	$condition = '';
	$list = pdo_fetchall("SELECT * FROM ".tablename($this->modulename.'_cate')." WHERE weid = '{$_W['weid']}' order by displayorder desc  LIMIT ".($pindex - 1) * $psize.','.$psize);//分页
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->modulename.'_cate') . " WHERE weid = '{$_W['uniacid']}'");
	$pager = pagination($total, $pindex, $psize);
}else if ('status'==$op){
	$id = $_GPC['id'];
	pdo_query('update '.tablename($this->modulename."_cate")." set status = !status where id='{$id}'");
	die('1');
}

include $this->template('mcate');