<?php
$from_user = $this->getFromUser();
$uid=mc_openid2uid($from_user);
$fans=mc_fansinfo($from_user,$_W['acid'],$_W['uniacid']);
if (!empty($fans) && !empty($fans['uid']) && $fans['follow'] != 1 && empty($_COOKIE[mihua_COOKIE_OPENID . '_checkfollow' . $_W['uniacid']])) {
	setcookie(mihua_COOKIE_OPENID . $_W['uniacid'], "", time() - 1);
	setcookie(mihua_COOKIE_OPENID . '_checkfollow' . $_W['uniacid'], "1", time() + 300);
	$from_user = $this->getFromUser();
}
$cfg = $this->module['config'];
$day_cookies = 15;
$shareid = mihua_COOKIE_SID . $_W['uniacid'];
if ((($_GPC['mid'] != $_COOKIE[$shareid]) && !empty($_GPC['mid']))) {
	$this->shareClick($_GPC['mid'], $_GPC['joinway']);
	setcookie($shareid, $this->getShareId(), time() + 3600 * 24 * $day_cookies);
}
$this->autoRegedit('list');
$profile = $this->getProfile();
$this->checkisAgent($from_user, $profile);
$goodsid = intval($_GPC['id']);
$goods = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE id = :id", array(':id' => $goodsid));
$arr = $this->time_tran($goods['timeend']);
$goods['timelaststr'] = $arr[0];
$goods['timelast'] = $arr[1];
$ccate = intval($goods['ccate']);
$commission = pdo_fetchcolumn(" SELECT commission FROM " . tablename('mihua_mall_goods') . " WHERE id=" . $goodsid . " ");
$member = $profile;
if($_W['member']['uid']){
	$have_zan=pdo_fetchcolumn("select zan_id from ims_mihua_mall_zan where uid={$_W['member']['uid']} and goods_id={$goodsid} ");
}
if ($commission == false || $commission == null || $commission < 0) {
	$commission = $this->module['config']['globalCommission'];
}
if (empty($goods)) {
	message('抱歉，商品不存在或是已经被删除！');
}
if ($goods['totalcnf'] != 2 && empty($goods['total'])) {
	message('抱歉，商品库存不足！');;
}
if ($goods['istime'] == 1) {
	if (time() < $goods['timestart']) {
		message('抱歉，还未到购买时间, 暂时无法购物哦~', referer(), "error");
	}
	if (time() > $goods['timeend']) {
		message('抱歉，商品限购时间已到，不能购买了哦~', referer(), "error");
	}
}
$this->memberQrcode($from_user);
pdo_query("update " . tablename('mihua_mall_goods') . " set viewcount=viewcount+1 where id=:id and uniacid='{$_W['uniacid']}' ", array(":id" => $goodsid));
$piclist = array(array("attachment" => $goods['thumb']));
if ($goods['thumb_url'] != 'N;') {
	$urls = unserialize($goods['thumb_url']);
	if (is_array($urls)) {
		$piclist = array_merge($piclist, $urls);
	}
}
$signPackage = $this->getSignPackage('detail', array('id' => $goods['id']), $_W['attachurl'] . $goods['thumb'], $goods['title']);
$marketprice = $goods['marketprice'];
$productprice = $goods['productprice'];
$stock = $goods['total'];
$allspecs = pdo_fetchall("select * from " . tablename('mihua_mall_spec') . " where goodsid=:id order by displayorder asc", array(':id' => $goodsid));
foreach ($allspecs as &$s) {
	$s['items'] = pdo_fetchall("select * from " . tablename('mihua_mall_spec_item') . " where  `show`=1 and specid=:specid order by displayorder asc", array(":specid" => $s['id']));
}
unset($s);
$options = pdo_fetchall("select id,title,thumb,marketprice,productprice,costprice, stock,weight,specs from " . tablename('mihua_mall_goods_option') . " where goodsid=:id order by id asc", array(':id' => $goodsid));
$specs = array();
if (count($options) > 0) {
	$specitemids = explode("_", $options[0]['specs']);
	foreach ($specitemids as $itemid) {
		foreach ($allspecs as $ss) {
			$items = $ss['items'];
			foreach ($items as $it) {
				if ($it['id'] == $itemid) {
					$specs[] = $ss;
					break;
				}
			}
		}
	}
}
$params = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods_param') . " WHERE goodsid=:goodsid order by displayorder asc", array(":goodsid" => $goods['id']));
$carttotal = $this->getCartTotal();
$rmlist = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_goods') . " WHERE uniacid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' and ishot='1' ORDER BY displayorder DESC, sales DESC limit 4 ");
$ydyy = $cfg['ydyy'];
$description = $cfg['description'];
$id = $profile['id'];
$theone = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rules') . " WHERE  uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
if ($fans['follow'] != 1) {
	$shownotice = 1;
}
if ($profile['status'] == 0) {
	$profile['flag'] = 0;
}
if ($member['status'] == 0) {
	$member['flag'] = 0;
}
$myheadimg=mc_fetch($uid,array('avatar','nickname'));
$comment_list=pdo_fetchall("select c.*,g.nickname from ims_mihua_mall_comment c left join ims_mc_members g on g.uid=c.uid where c.goods_id=:gid and status=1  ",array('gid'=>$goodsid));
$comment_count=count($comment_list);
include $this->template('detail');