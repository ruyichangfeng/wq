<?php 
global $_W,$_GPC;

$ops = array('display', 'update', 'delete','add'); // 只支持此 3 种操作.
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'display';

load()->func('db');
load()->func('pdo');
$table='imeepos_news_nav';
// print_r(pdo_fetchallfields('ims_imeepos_news'));

// 	exit();
if($op=='display'){
	$pageindex = max(intval($_GPC['page']), 1); // 当前页码
	$pagesize = 4; // 设置分页大小
	$sql = 'SELECT * FROM'.tablename($table);
	$nav_lists = pdo_fetchall($sql);
 	foreach($nav_lists as $key => $val){
 		if($val['uniacid']==0){
 			$data['uniacid'] = $_W['uniacid'];
 			$row = pdo_update($table,$data,array('nav_id'=>$val['nav_id']));
 		}	
 	}
	$sql = 'SELECT * FROM'.tablename($table)." WHERE uniacid = :uniacid ORDER BY nav_id desc LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;
	$sql1 = 'SELECT COUNT(*) FROM '.tablename($table).'WHERE uniacid = :uniacid';
	$params = array(':uniacid'=>$_W['uniacid']);
 	$nav_list = pdo_fetchall($sql,$params);

 	$total = pdo_fetchcolumn($sql1,$params);
 	$pager = pagination($total, $pageindex, $pagesize);

}   
if($op=='add'){
	if(checksubmit('join')){
	$nav['nav_title']=$_GPC['title'];
	$nav['nav_detail']=$_GPC['detail'];
	$nav['nav_status']=$_GPC['status'];
	$nav['nav_sort']=$_GPC['sort'];
	$nav['uniacid']=$_W['uniacid'];
	$row = pdo_insert($table, $nav);
	if($row){
		message('添加分类成功',$this->createWebUrl('activity'),array('op'=>'display'),'success');
	}else{
		message('添加分失败',$this->createWebUrl('activity'),array('op'=>'add'),'error');
		}
	}
}
if($op=='delete'){
	$id = intval($_GPC['id']);
			if(empty($id)){
				message('未找到指定新闻分类');
			}
			$result = pdo_delete($table, array('nav_id'=>$id,'uniacid'=>$_W['uniacid']));
			if(intval($result) == 1){
				message('删除新闻分类成功.', $this->createWebUrl('activity'), 'success');
			} else {
				message('删除新闻分类失败.');
			}
	}
if($op=='update'){
	$id = intval($_GPC['id']);
	if(!empty($id)){
		$sql = 'SELECT * FROM '.tablename($table).' WHERE nav_id=:id AND uniacid = :uniacid';
		$params = array(':id'=>$id,':uniacid'=>$_W['uniacid']);
		$results = pdo_fetch($sql, $params);
	}

	if(checksubmit('submit')){
		if(empty($id)){
		message('未找到指定新闻分类');
	}
	$data['nav_title']=$_GPC['title'];
	$data['nav_detail']=$_GPC['detail'];
	$data['nav_status']=$_GPC['status'];
	$data['nav_sort']=$_GPC['sort'];
	$data['uniacid']=$_W['uniacid'];
	$resut = pdo_update($table, $data, array('nav_id'=>$id,'uniacid'=>$_W['uniacid']));
	if (!empty($resut)) {
			message('新闻导航修改成功！', $this->createWebUrl('activity', array('op'=>'display')), 'success');
		} else {
			message('新闻导航修改失败！');
		}
	}
}
include $this->template('web/activity');
