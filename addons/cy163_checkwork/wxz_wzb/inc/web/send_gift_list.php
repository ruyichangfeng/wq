<?php

global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
$rid = intval($_GPC['rid']);
if(empty($rid)){
    message('直播id不存在',$this->createWebUrl('list_list'),'error');
}

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$total = pdo_fetchcolumn('SELECT count(*) as c FROM ' . tablename('wxz_wzb_giftlog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id WHERE a.rid='.$rid.' and a.status=1');
$start = ($pindex - 1) * $psize;

$sql='SELECT b.nickname,b.id,b.headimgurl,a.amount as amount,a.dateline as dateline FROM ' . tablename('wxz_wzb_giftlog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id  inner join ' . tablename('wxz_wzb_gift') . ' as c on a.giftid = c.id WHERE a.rid='.$rid.' and a.status=1 and a.type=1 ORDER BY a.dateline DESC limit '.$start.','.$psize;

$ds = pdo_fetchall($sql);
echo "<pre>";
print_r($ds);exit;
$pager = pagination($total, $pindex, $psize);

include $this->template('pay');