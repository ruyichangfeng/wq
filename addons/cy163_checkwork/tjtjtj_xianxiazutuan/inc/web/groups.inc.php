<?php
/*
*
*  组团管理
*
*/

/*组团添加*/
if(isset($_GPC['submit'])){

	$data = array(

		'sid' => $_GPC['sid'],
		'gid' => $_GPC['gid'],
		'needpeople' => $_GPC['needpeople'],
		'donepeople' => $_GPC['donepeople'],
		'intro' => $_GPC['intro'],
		'create_at' => strtotime($_GPC['create_at']),
		'end_at' => strtotime($_GPC['end_at']),
		'deposit' => intval($_GPC['deposit'])
		);

	pdo_insert('tjtjtj_xxzt_groups',$data);
	message('添加成功',$this->createWebUrl('groups',array('action' => '')),'success');
}


/*编辑组团*/

if($_GPC['update']){

	$new_data = array(
		'gid' => $_GPC['gid'],
		'needpeople' => $_GPC['needpeople'],
		'donepeople' => $_GPC['donepeople'],
		'intro' => $_GPC['intro'],
		'create_at' => strtotime($_GPC['create_at']),
		'end_at' => strtotime($_GPC['end_at']),
		'deposit' => intval($_GPC['deposit'])
	);

	pdo_update('tjtjtj_xxzt_groups',$new_data,array('uid' => $_GPC['uid']));
	message('修改成功',$this->createWebUrl('groups',array('action' => '')),'success');
}

if(isset($_GPC['action']) && $_GPC['action'] == 'update'){
	$old_data = pdo_fetch('select * from'.tablename('tjtjtj_xxzt_groups').' where uid ='.$_GPC['uid']);
	if(empty($old_data)){
		message('数据为空',$this->createWebUrl('groups',array('action' => '')),'success');
	}
}

if ($_GPC['action'] == 'add' || $_GPC['action'] == 'update') {
	//获取商品信息
	$goodses = pdo_fetchall('SELECT * FROM '.tablename('tjtjtj_xxzt_goods').' WHERE sid = :sid', array(':sid' => $_W['uniacid']));
	if (!$goodses) {
		message('请先添加商品', $this->createWebUrl('goods', array('action' => 'add')), 'error');
	}
}

if ($_GPC['action'] == 'view') {
	$groupid = intval($_GPC['uid']);
	$group   = pdo_fetch(
		'SELECT
		groups.*,
		goods.uid AS goodsid,goods.name AS goodsname,goods.logo AS goodslogo,goods.gprice,goods.sprice,goods.mprice,goods.stock
		FROM '.tablename('tjtjtj_xxzt_groups').' AS groups
		INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON groups.gid = goods.uid
		WHERE groups.sid = :sid AND groups.uid = :uid LIMIT 1
		',
		array(
			':sid' => $_W['uniacid'],
			':uid' => $groupid
		)
	);
	$groupusers = pdo_fetchall(
		'SELECT
		orders.*,
		a.name AS truename,a.mobile,a.province,a.city,a.county,a.address
		FROM '.tablename('tjtjtj_xxzt_groups_records').' AS grecords
		INNER JOIN '.tablename('tjtjtj_xxzt_orders').' AS orders ON grecords.orderid = orders.uid
		INNER JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON orders.aid = a.uid
		WHERE grecords.groupid = :groupid AND grecords.sid = :sid
		',
		array(
			':groupid' => $groupid,
			':sid' => $_W['uniacid']
		)
	);
}

if ($_GPC['action'] != '') {
	include $this->template('groupsmanage');exit;
}

$page = intval($_GPC['page']);
$page = $page == 0 ? 1 : $page;
$pagesize = 20;

if (isset($_GPC['filter']) && ($_GPC['groupid'] != '' || $_GPC['goodsname'] != '' || $_GPC['status'] != '' || strtotime($_GPC['section']['start']) != strtotime($_GPC['section']['end']))) {
	//筛选
	if ($_GPC['groupid'] != '') {
		$count  = 1;
		$result = pdo_fetchall('select gp.*,goods.name AS goodsname from '.tablename('tjtjtj_xxzt_groups').' AS gp
						INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON gp.gid = goods.uid
						where gp.sid = :sid AND gp.uid = :uid LIMIT 1', array(':sid' => $_W['uniacid'], ':uid' => $_GPC['groupid']));
	}
	if ($_GPC['groupid'] == '' && $_GPC['goodsname'] != '') {
		$count = pdo_fetch(
			'select count(*) AS c from'.tablename('tjtjtj_xxzt_groups').' AS gp
			INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON gp.gid = goods.uid
			where gp.sid = :sid AND goods.name LIKE "%'.urldecode($_GPC['goodsname']).'%"',
			array(':sid' => $_W['uniacid']));
		$result = pdo_fetchall('select gp.*,goods.name AS goodsname from '.tablename('tjtjtj_xxzt_groups').' AS gp
						INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON gp.gid = goods.uid
						where gp.sid = :sid AND goods.name LIKE "%'.urldecode($_GPC['goodsname']).'%"
						order by gp.uid DESC
						limit '.(($page - 1)*$pagesize).','.$pagesize,
			array(':sid' => $_W['uniacid']));
	}
	if ($_GPC['groupid'] == '' && $_GPC['goodsname'] == '') {
		if (strtotime($_GPC['section']['start']) == strtotime($_GPC['section']['end'])) {
			$count  = pdo_fetch(
				'select count(*) AS c from'.tablename('tjtjtj_xxzt_groups').'
				where sid = :sid AND status = :status',
				array(
					':sid' => $_W['uniacid'],
					':status' => $_GPC['status'],
				));
			$result = pdo_fetchall(
				'select gp.*,goods.name AS goodsname from '.tablename('tjtjtj_xxzt_groups').' AS gp
				INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON gp.gid = goods.uid
				where gp.sid = :sid AND gp.status = :status
				order by gp.uid DESC
				limit '.(($page - 1)*$pagesize).','.$pagesize,
				array(
					':sid' => $_W['uniacid'],
					':status' => $_GPC['status'],
				));
		} else {
			if ($_GPC['status'] == '') {
				$count  = pdo_fetch(
					'select count(*) AS c from'.tablename('tjtjtj_xxzt_groups').'
					where sid = :sid AND (create_at >= :cat && create_at < :eat)',
					array(
						':sid' => $_W['uniacid'],
						':cat' => strtotime($_GPC['section']['start']),
						':eat' => strtotime($_GPC['section']['end']),
					));
				$result = pdo_fetchall(
					'select gp.*,goods.name AS goodsname from '.tablename('tjtjtj_xxzt_groups').' AS gp
					INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON gp.gid = goods.uid
					where gp.sid = :sid AND (gp.create_at >= :cat && gp.create_at < :eat)
					order by gp.uid DESC
					limit '.(($page - 1)*$pagesize).','.$pagesize,
					array(
						':sid' => $_W['uniacid'],
						':cat' => strtotime($_GPC['section']['start']),
						':eat' => strtotime($_GPC['section']['end']),
					));
			} else {
				$count  = pdo_fetch(
					'select count(*) AS c from'.tablename('tjtjtj_xxzt_groups').'
					where sid = :sid AND status = :status AND (create_at >= :cat && create_at < :eat)',
					array(
						':sid' => $_W['uniacid'],
						':status' => $_GPC['status'],
						':cat' => strtotime($_GPC['section']['start']),
						':eat' => strtotime($_GPC['section']['end']),
					));
				$result = pdo_fetchall(
					'select gp.*,goods.name AS goodsname from '.tablename('tjtjtj_xxzt_groups').' AS gp
					INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON gp.gid = goods.uid
					where gp.sid = :sid AND gp.status = :status AND (gp.create_at >= :cat && gp.create_at < :eat)
					order by gp.uid DESC
					limit '.(($page - 1)*$pagesize).','.$pagesize,
					array(
						':sid' => $_W['uniacid'],
						':status' => $_GPC['status'],
						':cat' => strtotime($_GPC['section']['start']),
						':eat' => strtotime($_GPC['section']['end']),
					));
			}
		}
	}
} else {
	$count  = pdo_fetch('select count(*) AS c from'.tablename('tjtjtj_xxzt_groups').' where sid = :sid', array(':sid' => $_W['uniacid']));
	$result = pdo_fetchall('select gp.*,go.name AS goodsname from '.tablename('tjtjtj_xxzt_groups').' AS gp
						INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS go ON gp.gid = go.uid
						where gp.sid = :sid order by gp.uid DESC limit '.(($page - 1)*$pagesize).','.$pagesize, array(':sid' => $_W['uniacid']));
}

$pager = pagination($count['c'], $page ,$pagesize);

include $this->template('groupsmanage');