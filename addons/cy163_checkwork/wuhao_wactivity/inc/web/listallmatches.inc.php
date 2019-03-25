<?php
global $_W,$_GPC;
$pageindex = max(intval($_GPC['page']), 1); // 当前页码
$pagesize =3; // 设置分页大小
$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('wactivity_matches')." WHERE `uniacid`=:uniacid ORDER BY matchid DESC",array(':uniacid'=>$_W['uniacid']));

$pager = pagination($total, $pageindex, $pagesize);

$data_matches=pdo_fetchall("SELECT * FROM ".tablename('wactivity_matches')." WHERE `uniacid`=:uniacid ORDER BY matchid DESC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize,array(':uniacid'=>$_W['uniacid']));

include $this->template('listallmatches');
