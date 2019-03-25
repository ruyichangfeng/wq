<?php
$pindex = max(1, intval($_GPC["page"]));
$psize = 10;
$condition = '';
if (!empty($_GPC['ccate'])) {
	$cid = intval($_GPC['ccate']);
	$condition .= " AND ccate = '{$cid}'";
	$_GPC['pcate'] = pdo_fetchcolumn("SELECT parentid FROM " . tablename('mihua_mall_category') . " WHERE id = :id", array(':id' => intval($_GPC['ccate'])));
} elseif (!empty($_GPC['pcate'])) {
	$cid = intval($_GPC['pcate']);
	$condition .= " AND pcate = '{$cid}'";
}
if (!empty($_GPC['keyword'])) {
	$condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
}
$sort = empty($_GPC['sort']) ? 0 : $_GPC['sort'];
$sortfield = "displayorder asc";
$sortb0 = empty($_GPC['sortb0']) ? "desc" : $_GPC['sortb0'];
$sortb1 = empty($_GPC['sortb1']) ? "desc" : $_GPC['sortb1'];
$sortb2 = empty($_GPC['sortb2']) ? "desc" : $_GPC['sortb2'];
$sortb3 = empty($_GPC['sortb3']) ? "asc" : $_GPC['sortb3'];
if ($sort == 0) {
	$sortb00 = $sortb0 == "desc" ? "asc" : "desc";
	$sortfield = "createtime " . $sortb0;
	$sortb11 = "desc";
	$sortb22 = "desc";
	$sortb33 = "asc";
} else if ($sort == 1) {
	$sortb11 = $sortb1 == "desc" ? "asc" : "desc";
	$sortfield = "sales " . $sortb1;
	$sortb00 = "desc";
	$sortb22 = "desc";
	$sortb33 = "asc";
} else if ($sort == 2) {
	$sortb22 = $sortb2 == "desc" ? "asc" : "desc";
	$sortfield = "viewcount " . $sortb2;
	$sortb00 = "desc";
	$sortb11 = "desc";
	$sortb33 = "asc";
} else if ($sort == 3) {
	$sortb33 = $sortb3 == "asc" ? "desc" : "asc";
	$sortfield = "marketprice " . $sortb3;
	$sortb00 = "desc";
	$sortb11 = "desc";
	$sortb22 = "desc";
}
$sorturl = $this->createMobileUrl('list2', array("keyword" => $_GPC['keyword'], "pcate" => $_GPC['pcate'], "ccate" => $_GPC['ccate']));
if (!empty($_GPC['isnew'])) {
	$condition .= " AND isnew = 1";
	$sorturl .= "&isnew=1";
}
if (!empty($_GPC['ishot'])) {
	$condition .= " AND ishot = 1";
	$sorturl .= "&ishot=1";
}
if (!empty($_GPC['isdiscount'])) {
	$condition .= " AND isdiscount = 1";
	$sorturl .= "&isdiscount=1";
}
if (!empty($_GPC['istime'])) {
	$condition .= " AND istime = 1 ";
	$sorturl .= "&istime=1";
}
$children = array();
$category = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_category') . " WHERE uniacid = '{$_W['uniacid']}' and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(), 'id');
foreach ($category as $index => $row) {
	if (!empty($row['parentid'])) {
		$children[$row['parentid']][$row['id']] = $row;
		unset($category[$index]);
	}
}
$list = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' $condition ORDER BY $sortfield  ");
foreach ($list as &$r) {
	if ($r['istime'] == 1) {
		$arr = $this->time_tran($r['timeend']);
		$r['timelaststr'] = $arr[0];
		$r['timelast'] = $arr[1];
	}
}
unset($r);
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0  AND status = '1' $condition");
$pager = pagination($total, $pindex, $psize, $url = '', $context = array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
$carttotal = $this->getCartTotal();
$cfg = $this->module['config'];
$ydyy = $cfg['ydyy'];
$logo = $cfg['logo'];
$description = $cfg['description'];
$id = $profile['id'];
if ($profile['status'] == 0) {
	$profile['flag'] = 0;
}
$theone = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rules') . " WHERE  uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
include $this->template('list2');