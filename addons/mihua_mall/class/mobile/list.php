<?php
$cfg   = $this->module['config'];
$title = $cfg['shopname'];
if (empty($title)) {
	$title = '商城首页';
}
$from_user = $this->getFromUser();
$fans = pdo_fetch("SELECT * FROM " . tablename('mc_mapping_fans') . " WHERE openid=:from_user and uniacid=:uniacid", array(':from_user' => $from_user, ':uniacid' => $_W['uniacid']));
$day_cookies = 15;
$shareid     = mihua_COOKIE_SID . $_W['uniacid'];
if ((($_GPC['mid'] != $_COOKIE[$shareid]) && !empty($_GPC['mid']))) {
	$this->shareClick($_GPC['mid'], $_GPC['joinway']);
	setcookie($shareid, $this->getShareId(), time() + 3600 * 24 * $day_cookies);
}
$this->autoRegedit('list');
$profile = $this->getProfile();
$this->checkisAgent($from_user, $profile);
$signPackage = $this->getSignPackage();
if ($fans['follow'] != 1) {
	$shownotice = true;
}
$pindex    = max(1, intval($_GPC['page']));
$psize     = 4;
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
$zt_list=pdo_fetchall("select *  from ".tablename('mihua_zt')." where status=1  order by zt_order  desc,zt_id desc ");
$children = array();
$category = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_category') . " WHERE uniacid = '{$_W['uniacid']}' and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(), 'id');
foreach ($category as $index => $row) {
	if (!empty($row['parentid'])) {
		$children[$row['parentid']][$row['id']] = $row;
		unset($category[$index]);
	}
}
$recommandcategory = array();
foreach ($category as &$c) {
	if ($c['isrecommand'] == 1) {
		$c['list']           = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}' and deleted=0 AND status = '1'  and pcate='{$c['id']}'  ORDER BY displayorder DESC, sales DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		$c['total']          = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0  AND status = '1' and pcate='{$c['id']}'");
		$c['pager']          = pagination($c['total'], $pindex, $psize, $url = '', $context = array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
		$recommandcategory[] = $c;
	}
	if (!empty($children[$c['id']])) {
		foreach ($children[$c['id']] as &$child) {
			if ($child['isrecommand'] == 1) {
				$child['list']       = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0 AND status = '1'  and pcate='{$c['id']}' and ccate='{$child['id']}'  ORDER BY displayorder DESC, sales DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				$child['total']      = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0  AND status = '1' and pcate='{$c['id']}' and ccate='{$child['id']}' ");
				$child['pager']      = pagination($child['total'], $pindex, $psize, $url = '', $context = array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
				$recommandcategory[] = $child;
			}
		}
		unset($child);
	}
}
unset($c);
$carttotal = $this->getCartTotal();
$advs      = pdo_fetchall("select * from " . tablename('mihua_mall_adv') . " where enabled=1 and uniacid= '{$_W['uniacid']}' and type=1 order by displayorder asc");
foreach ($advs as &$adv) {
	if (substr($adv['link'], 0, 5) != 'http:') {
		$adv['link'] = $adv['link'];
	}
}
unset($adv);
$advs2      = pdo_fetchall("select * from " . tablename('mihua_mall_adv') . " where enabled=1 and uniacid= '{$_W['uniacid']}' and type=2 order by displayorder asc");
if($advs2){
foreach ($advs2 as &$adv) {
	if (substr($adv['link'], 0, 5) != 'http:') {
		$adv['link'] = $adv['link'];
	}
}
unset($adv);
}
$advs3      = pdo_fetchall("select * from " . tablename('mihua_mall_adv') . " where enabled=1 and uniacid= '{$_W['uniacid']}' and type=3 order by displayorder asc");
if($advs3){
foreach ($advs3 as &$adv) {
	if (substr($adv['link'], 0, 5) != 'http:') {
		$adv['link'] = $adv['link'];
	}
}
unset($adv);	
}
$rpindex   = max(1, intval($_GPC['rpage']));
$rpsize    = 6;
$condition = ' and isrecommand=1';
$rlist     = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' $condition ORDER BY displayorder DESC, sales DESC ");
// var_dump($rlist);exit;
$cfg = $this->module['config'];
if (empty($cfg['indexss'])) {
	$cfg['indexss'] = 5;
}
$islist      = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' and istime='1' ORDER BY displayorder DESC, sales DESC limit {$cfg['indexss']}");
$logo        = $cfg['logo'];
$ydyy        = $cfg['ydyy'];
$description = $cfg['description'];
$id          = $profile['id'];
if ($profile['status'] == 0) {
	$profile['flag'] = 0;
}
$theone = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rules') . " WHERE  uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
include $this->template('list');