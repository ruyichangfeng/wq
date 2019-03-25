<?php
global $_W,$_GPC;

$op = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($op == 'display'){
	if (checksubmit('submit')){
		$sorts = $_GPC['sort'];
		foreach ($sorts as $id=>$sort){
			pdo_update($this->modulename.'_report', array('sort'=>$sort), array('id'=>$id));
		}
		message('批量更改排序成功',referer(),'success');
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize =20;//每页显示
	$condition = '';
	$list = pdo_fetchall("SELECT * FROM ".tablename($this->modulename.'_report')." WHERE weid = '{$_W['weid']}' order by sort desc, id desc LIMIT ".($pindex - 1) * $psize.','.$psize);//分页
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->modulename.'_report') . " WHERE weid = '{$_W['uniacid']}'");
	$pager = pagination($total, $pindex, $psize);
}elseif ($op == 'post'){
	$id = intval($_GPC['id']);
	if(!empty($id)){
		//查找是否存在
		$item = pdo_fetch("SELECT * FROM ".tablename($this->modulename.'_report')." WHERE id = :id" , array(':id' => $id));
		if (empty($item)) {
			message('数据不存在！', '', 'error');
		}
	}
	if(checksubmit('submit')){//检测是否post
		$content = trim($_GPC['content']);//分类名称
		if (empty($content)) {
			message('举报内容不能为空!');
		}
	
		$data = array(
				'weid'=>$_W['uniacid'],
				'content'=>$content,
				'status'=>$_GPC['status'],
				'sort'=>$_GPC['sort'],
		);
		if(empty($id)){
			pdo_insert($this->modulename.'_report', $data);//添加数据
			message('举报添加成功！', $this->createWebUrl('report', array('op' => 'display')), 'success');
		}else{
			pdo_update($this->modulename.'_report', $data, array('id' => $id));
			message('举报更新成功！', $this->createWebUrl('report', array('op' => 'display')), 'success');
		}
	}
}elseif ($op == 'del'){
	$id = intval($_GPC['id']);
	$row = pdo_fetch("SELECT id FROM ".tablename($this->modulename.'_report')." WHERE id = :id", array(':id' => $id));
	if (empty($row)) {
		message('举报不存在！');
	}
	pdo_delete($this->modulename.'_report',array('id'=>$id));
	message('删除成功！', referer(), 'success');
}elseif ($op == 'record'){
	$pindex = max(1, intval($_GPC['page']));
	$psize =20;//每页显示
	$list = pdo_fetchall("select r.*,w.psw,w.status,w.title,w.cover,w.nickname,w.avatar from ".tablename($this->modulename.'_report_detail')." r join ".tablename($this->modulename.'_works')." w on r.wid=w.id where r.weid='{$_W['uniacid']}' order by r.createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize);
	$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->modulename.'_report_detail') . " WHERE weid = '{$_W['uniacid']}'");
	$pager = pagination($total, $pindex, $psize);
}elseif ($op == 'forbidden'){
	$wid = $_GPC['wid'];
	$work = pdo_fetch("select id from ".tablename($this->modulename.'_works')." where id='{$wid}'");
	if (empty($work)){
		message('简记不存在！');
	}
	pdo_update($this->modulename.'_works',array('status'=>1),array('id'=>$wid));
	message('禁用成功！', referer(), 'success');
}


include $this->template('report');