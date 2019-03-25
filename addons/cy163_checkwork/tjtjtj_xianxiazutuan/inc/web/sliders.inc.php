<?php
/*
*
*  幻灯片管理
*
*/

/*显示幻灯片列表*/

$page = intval($_GPC['page']);
$page = $page == 0 ? 1 : $page;
$pagesize = 10;
//echo $pagesize;exit;
$count = pdo_fetchcolumn('select count(*) from'.tablename('tjtjtj_xxzt_sliders'));
//echo $count;exit;
$pager = pagination($count, $page ,$pagesize);

$result = pdo_fetchall('select * from '.tablename('tjtjtj_xxzt_sliders').' order by sort ASC limit '.(($page - 1)*$pagesize).','.$pagesize);


/*添加幻灯片*/

if(isset($_GPC['submit'])){

	$data = array(

		'sid' => $_W['uniacid'],
		'sort' => $_GPC['sort'],
		'title' => $_GPC['title'],
		'thumb' => $_GPC['thumb'],
		'href' => $_GPC['href'],
		'create_at' => time()
		);

	$v = pdo_insert('tjtjtj_xxzt_sliders',$data);
	if($v){

		message('添加成功',$this->createWebUrl('sliders',array('action' => 'add')),'success');
	}
}

/*删除幻灯片*/

if(isset($_GPC['action']) && $_GPC['action'] == 'delete'){

	$v = pdo_DELETE('tjtjtj_xxzt_sliders',array('uid' => $_GPC['uid']));
	if($v){

		message('删除成功',$this->createWebUrl('sliders',array('action' => '')),'success');
	}
}

/*编辑幻灯片*/

if($_GPC['update']){

	$new_data = array(

		'sid' => $_GPC['sid'],
		'title' => $_GPC['title'],
		'sort' => $_GPC['sort'],
		'thumb' => $_GPC['thumb'],
		'href' => $_GPC['href'],
		'create_at' => time()
		);

		$v = pdo_update('tjtjtj_xxzt_sliders',$new_data,array('uid' => $_GPC['uid']));
		if($v){

			message('修改成功',$this->createWebUrl('sliders',array('action' => '')),'success');
		}
}

if(isset($_GPC['action']) && $_GPC['action'] == 'update'){

	$old_data = pdo_fetch('select * from'.tablename('tjtjtj_xxzt_sliders').' where uid ='.$_GPC['uid']);
	//print_r($old_data);exit;
	if(empty($old_data)){

		message('数据为空',$this->createWebUrl('sliders',array('action' => '')),'success');
	}
}

include $this->template('slidersmanage');