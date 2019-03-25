<?php
$category = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_category') . " WHERE uniacid = '{$_W['uniacid']}' and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(), 'id');
foreach ($category as $index => $row) {
	if (!empty($row['parentid'])) {
		$children[$row['parentid']][$row['id']] = $row;
		unset($category[$index]);
	}
}
$carttotal = $this->getCartTotal();
$cfg = $this->module['config'];
$ydyy = $cfg['ydyy'];
$id = $profile['id'];
include $this->template('list_category'); ?>