<?php
/*
*
*
*
*/

/*用户列表*/

$page = intval($_GPC['page']);
$page = $page == 0 ? 1 : $page;
$pagesize = 15;
$count = pdo_fetchcolumn('select count(*) from '.tablename('tjtjtj_xxzt_users').' WHERE sid = :sid', array(':sid' => $_W['uniacid']));
$pager = pagination($count,$page,$pagesize);

$records = pdo_fetchall('select * from'.tablename('tjtjtj_xxzt_users').' where sid = :sid order by uid DESC limit '.(($page - 1)* $pagesize).','.$pagesize, array(':sid' => $_W['uniacid']));

/*删除用户*/
if(isset($_GPC['action']) && $_GPC['action'] == 'delete'){
	pdo_delete('tjtjtj_xxzt_users',array('uid' => $_GPC['uid']));
	message('删除成功',$this->createWebUrl('users',array('action' => '' )),'success');
}


include $this->template('usersmanage');