<?php
global $_W,$_GPC;
$pageindex = max(intval($_GPC['page']), 1); // 当前页码
$pagesize =10; // 设置分页大小
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid ORDER BY groupid ASC",array(':uniacid'=>$_W['uniacid']));

$pager = pagination($total, $pageindex, $pagesize);

$data_groups=pdo_fetchall("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid ORDER BY groupid ASC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize,array(':uniacid'=>$_W['uniacid']));

include $this->template('listallgroups');

