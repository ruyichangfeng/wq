<?php
/*
*
*   
*   商品分类管理
*
*
*/

/*商品分类显示*/

$page = intval($_GPC['page']);
$page = $page == 0 ? 1 : $page;
$pagesize = 10;
//echo $pagesize;exit;
$count = pdo_fetchcolumn('select count(*) from'.tablename('tjtjtj_xxzt_category'));
//echo $count;exit;
$pager = pagination($count, $page ,$pagesize);

$result = pdo_fetchall('select * from '.tablename('tjtjtj_xxzt_category').' order by sort ASC limit '.(($page - 1)*$pagesize).','.$pagesize);

//print_r($result);


/*商品分类添加*/

if(isset($_GPC['submit'])){

	$data = array(

		'sid' => $_W['uniacid'],
		'sort' => $_GPC['sort'],
		'name' => $_GPC['name'],
		'logo' => $_GPC['logo'],
		'create_at' => time()
		);

	$v = pdo_insert('tjtjtj_xxzt_category',$data);
	if($v){

		message('添加成功',$this->createWebUrl('goodscategory',array('action' => 'add')),'success');
	}
}


/*删除商品类*/

if(isset($_GPC['action']) && $_GPC['action'] == 'delete'){

	$v = pdo_DELETE('tjtjtj_xxzt_category',array('uid' => $_GPC['uid']));
	if($v){

		message('删除成功',$this->createWebUrl('goodscategory',array('action' => '')),'success');
	}
}

/*编辑商品类*/

if($_GPC['update']){

	$new_data = array(

		'sid' => $_GPC['sid'],
		'name' => $_GPC['name'],
		'sort' => $_GPC['sort'],
		'logo' => $_GPC['logo'],
		'create_at' => time()
		);

		$v = pdo_update('tjtjtj_xxzt_category',$new_data,array('uid' => $_GPC['uid']));
		if($v){

			message('修改成功',$this->createWebUrl('goodscategory',array('action' => '')),'success');
		}
}

if(isset($_GPC['action']) && $_GPC['action'] == 'update'){

	$old_data = pdo_fetch('select * from'.tablename('tjtjtj_xxzt_category').' where uid ='.$_GPC['uid']);
	//print_r($old_data);exit;
	if(empty($old_data)){

		message('数据为空',$this->createWebUrl('goodscategory',array('action' => '')),'success');
	}
}


include $this->template('goodscategorymanage');