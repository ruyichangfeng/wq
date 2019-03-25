<?php
global $_W,$_GPC;
$pageindex = max(intval($_GPC['page']), 1); // 当前页码
$pagesize =3; // 设置分页大小
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('newfootball_teams')." WHERE `uniacid`=:uniacid ORDER BY teamid ASC",array(':uniacid'=>$_W['uniacid']));

$pager = pagination($total, $pageindex, $pagesize);

$data_teams=pdo_fetchall("SELECT * FROM ".tablename('newfootball_teams')." WHERE `uniacid`=:uniacid ORDER BY teamid ASC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize,array(':uniacid'=>$_W['uniacid']));

include $this->template('listallteams');

