<?php

global $_W, $_GPC;
load()->web('tpl'); 

//获取所有用户列表

$pindex = max(1, intval($_GPC['page']));

$psize = 10;

$memberlist=pdo_fetchall("SELECT * FROM ".tablename('chunyu_banshi_member')." WHERE uniacid=:uniacid ORDER BY mid ASC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));

$total = pdo_fetchcolumn("SELECT count(mid) FROM " . tablename('chunyu_banshi_member') ."WHERE uniacid=:uniacid ORDER BY mid ASC",array(':uniacid'=>$_W['uniacid']));

$pager = pagination($total, $pindex, $psize);

include $this->template('web/member');

?>