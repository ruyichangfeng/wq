<?php

/* Page */
$page = intval($_GPC['page']);
$page = $page == 0 ? 1 : $page;
$pagesize = 15;
$start = ($page - 1) * $pagesize;

$count = pdo_fetchcolumn(
		'select COUNT(*) from '.tablename('tjtjtj_xxzt_refunds').' where sid = :sid',
		array(':sid' => $_W['uniacid'])
	);
$pager = pagination($count, $page, $pagesize);

$refunds = pdo_fetchall(
		'select * from '.tablename('tjtjtj_xxzt_refunds').' where sid = :sid order by create_at DESC limit '.$start.','.$pagesize,
		array(':sid' => $_W['uniacid'])
	);

include_once $this->template('refund');