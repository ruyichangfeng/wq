<?php

/*商品添加*/
if(isset($_GPC['submit'])){

    $data = array(
		
	    'sid' => $_W['uniacid'],
		'sort' => $_GPC['sort'],
	    'name' => $_GPC['name'],
		'logo' => $_GPC['logo'],
		'cid' => $_GPC['cid'],
		'stock' => $_GPC['stock'],
		'sales' => $_GPC['sales'],
		'singlelimit' => $_GPC['singlelimit'],
		'morelimit' => $_GPC['morelimit'],
		'gprice' => $_GPC['gprice'],
		'sprice' => $_GPC['sprice'],
		'mprice' => $_GPC['mprice'],
		'atlas' => implode('$', $_GPC['atlas']),
		'details' => $_GPC['details'],
		'lid' => $_GPC['lid'],
		'status' => 0,
	    'create_at' => time()	
	);

	$res = pdo_insert('tjtjtj_xxzt_goods',$data);
    
	if(!empty($res)){

		$goods = pdo_get('tjtjtj_xxzt_goods', $data, array('uid'));

		//添加商品分享信息
		$dat = array(
			'sid' => $_W['uniacid'],
			'gid' => $goods['uid'],
			'thumb' => $_GPC['share_logo'],
			'title' => $_GPC['share_title'],
			'description' => $_GPC['share_description'],
			'sharenums' => $_GPC['share_nums']
		);

		pdo_insert('tjtjtj_xxzt_share', $dat);

	    message('商品添加成功',$this->createWebUrl('goods',array('action' =>'add')),'success');
	}
}

/*商品删除*/

if(isset($_GPC['action']) && $_GPC['action'] == 'delete'){
	pdo_query('UPDATE '.tablename('tjtjtj_xxzt_goods').' set status = -1 where uid = '.$_GPC['uid']);
	message('删除成功',$this->createWebUrl('goods',array('action' => '')),'success');
}

/*编辑商品*/

if(isset($_GPC['update'])){

	$new_data = array(
		
	    'sort' => $_GPC['sort'],
	    'name' => $_GPC['name'],
		'logo' => $_GPC['logo'],
		'cid' => $_GPC['cid'],
		'stock' => $_GPC['stock'],
		'sales' => $_GPC['sales'],
		'singlelimit' => $_GPC['singlelimit'],
		'morelimit' => $_GPC['morelimit'],
		'gprice' => $_GPC['gprice'],
		'sprice' => $_GPC['sprice'],
		'mprice' => $_GPC['mprice'],
		'atlas' => implode('$', $_GPC['atlas']),
		'details' => $_GPC['details'],
		'lid' => $_GPC['lid'],
		'status' => $_GPC['status'],
	    'create_at' => time()
		);

		$result = pdo_update('tjtjtj_xxzt_goods',$new_data,array('uid' => $_GPC['uid']));

		$share = array(
			'thumb' => $_GPC['share_logo'],
			'title' => $_GPC['share_title'],
			'description' => $_GPC['share_description'],
			'sharenums' => $_GPC['share_nums']
		);
		pdo_update('tjtjtj_xxzt_share', $share, array('uid' => $_GPC['shareid']));

		message('修改成功',$this->createWebUrl('goods', array('action' => '')),'success');
}

if(isset($_GPC['action']) && $_GPC['action'] == 'update'){

	$re = pdo_fetch('select
						g.*,
						s.uid AS shareid,s.title AS share_title,s.description AS share_description,s.sharenums AS share_nums,s.thumb AS share_thumb from '.tablename('tjtjtj_xxzt_goods').' AS g
						LEFT JOIN '.tablename('tjtjtj_xxzt_share').' AS s ON g.uid = s.gid
						where g.uid = '.$_GPC['uid']);
	if(empty($re)){
		message('数据为空',$this->createWebUrl('goods',array('action' => '')),'success');
	}
}


/*商品列表*/
$page = intval($_GPC['page']);
$page = $page == 0 ? 1 : $page;
$pagesize = 15;

//分类查询条件
$where_category = $_GPC['goodscate'] == 0 ? '1 = 1' : 'g.cid = '.intval($_GPC['goodscate']);
if ($_GPC['goodsname'] != '') {
	$count   = pdo_fetchcolumn(
		'SELECT COUNT(*) FROM '.tablename('tjtjtj_xxzt_goods').' AS g
		where g.sid = :sid and '.$where_category.' and g.name LIKE "%'.urldecode($_GPC['goodsname']).'%"',
		array(':sid' => $_W['uniacid']));
	$records = pdo_fetchall('select
 							g.*,
 							c.name AS categoryname,l.name AS logisticname,
 							s.uid AS shareid,s.title AS share_title,s.description AS share_description,s.sharenums AS share_nums,s.thumb AS share_thumb
 							FROM '.tablename('tjtjtj_xxzt_goods').' AS g
 							INNER JOIN '.tablename('tjtjtj_xxzt_category').' AS c ON g.cid = c.uid
 							INNER JOIN '.tablename('tjtjtj_xxzt_logistics').' AS l ON g.lid = l.uid
 							LEFT JOIN '.tablename('tjtjtj_xxzt_share').' AS s ON g.uid = s.gid
 							where g.sid = :sid and g.status != -1 and g.name LIKE "%'.urldecode($_GPC['goodsname']).'%" and '.$where_category.'
 							order by g.sort ASC
 							limit '.(($page-1)*$pagesize).','.$pagesize, array(':sid' => $_W['uniacid']));
} else {
	$count   = pdo_fetchcolumn(' SELECT COUNT(*) FROM '.tablename('tjtjtj_xxzt_goods').' AS g where '.$where_category.' and g.sid = :sid', array(':sid' => $_W['uniacid']));
	$records = pdo_fetchall('select
 							g.*,
 							c.name AS categoryname,l.name AS logisticname,
 							s.uid AS shareid,s.title AS share_title,s.description AS share_description,s.sharenums AS share_nums,s.thumb AS share_thumb
 							FROM '.tablename('tjtjtj_xxzt_goods').' AS g
 							INNER JOIN '.tablename('tjtjtj_xxzt_category').' AS c ON g.cid = c.uid
 							INNER JOIN '.tablename('tjtjtj_xxzt_logistics').' AS l ON g.lid = l.uid
 							LEFT JOIN '.tablename('tjtjtj_xxzt_share').' AS s ON g.uid = s.gid
 							where g.sid = :sid and g.status != -1 and '.$where_category.'
 							order by g.sort ASC
 							limit '.(($page-1)*$pagesize).','.$pagesize, array(':sid' => $_W['uniacid']));
}

$pager = pagination( $count , $page , $pagesize);

if ($_GPC['action'] == 'add' || $_GPC['action'] == 'update' || $_GPC['action'] == '') {
	$goodscategory = pdo_fetchall('select uid,name from '.tablename('tjtjtj_xxzt_category').' where sid = :sid', array(':sid' => $_W['uniacid']));
	$logistics = pdo_fetchall(' select * from '.tablename('tjtjtj_xxzt_logistics').' where sid = :sid', array(':sid' => $_W['uniacid']));
	if (!$goodscategory) {
		message('请先添加商品分类', $this->createWebUrl('goodscategory', array('action' => 'add')), 'error');
	}
	if (!$logistics) {
		message('请先添加物流', $this->createWebUrl('logistics', array('action' => 'add')), 'error');
	}
}


include $this->template('goodsmanage');