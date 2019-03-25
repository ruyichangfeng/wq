<?php
$from = $_GPC['from'];
$returnurl = urldecode($_GPC['returnurl']);
$operation = $_GPC['op'];
if ($operation == 'post') {
	$id = intval($_GPC['id']);
	$data = array('uniacid' => $_W['uniacid'], 'openid' => $from_user, 'realname' => $_GPC['realname'], 'mobile' => $_GPC['mobile'], 'province' => $_GPC['province'], 'city' => $_GPC['city'], 'area' => $_GPC['area'], 'address' => $_GPC['address'],);
	if (empty($_GPC['realname']) || empty($_GPC['mobile']) || empty($_GPC['address'])) {
		message('请输完善您的资料！');
	}
	if (!empty($id)) {
		unset($data['uniacid']);
		unset($data['openid']);
		pdo_update('mihua_mall_address', $data, array('id' => $id));
		message($id, '', 'ajax');
	} else {
		pdo_update('mihua_mall_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $from_user));
		$data['isdefault'] = 1;
		pdo_insert('mihua_mall_address', $data);
		$id = pdo_insertid();
		$uid=mc_openid2uid($from_user);
		$profile=mc_fetch($uid,array('realname','mobile'));
		if (empty($profile['realname']) || empty($profile['mobile'])) {
				mc_update($uid,array("mobile" => $_GPC['mobile']));
		}
		if (!empty($id)) {
			message($id, '', 'ajax');
		} else {
			message(0, '', 'ajax');
		}
	}
} elseif ($operation == 'default') {
	$id = intval($_GPC['id']);
	pdo_update('mihua_mall_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $from_user));
	pdo_update('mihua_mall_address', array('isdefault' => 1), array('id' => $id));
	message(1, '', 'ajax');
} elseif ($operation == 'detail') {
	$id = intval($_GPC['id']);
	$row = pdo_fetch("SELECT id, realname, mobile, province, city, area, address FROM " . tablename('mihua_mall_address') . " WHERE id = :id", array(':id' => $id));
	message($row, '', 'ajax');
} elseif ($operation == 'remove') {
	$id = intval($_GPC['id']);
	if (!empty($id)) {
		$address = pdo_fetch("select isdefault from " . tablename('mihua_mall_address') . " where id='{$id}' and uniacid='{$_W['uniacid']}' and openid='" . $from_user . "' limit 1 ");
		if (!empty($address)) {
			pdo_update("mihua_mall_address", array("deleted" => 1, "isdefault" => 0), array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $from_user));
			if ($address['isdefault'] == 1) {
				$maxid = pdo_fetchcolumn("select max(id) as maxid from " . tablename('mihua_mall_address') . " where uniacid='{$_W['uniacid']}' and openid='" . $from_user . "' limit 1 ");
				if (!empty($maxid)) {
					pdo_update('mihua_mall_address', array('isdefault' => 1), array('id' => $maxid, 'uniacid' => $_W['uniacid'], 'openid' => $from_user));
					die(json_encode(array("result" => 1, "maxid" => $maxid)));
				}
			}
		}
	}
	die(json_encode(array("result" => 1, "maxid" => 0)));
} else {
	$uid=mc_openid2uid($from_user);
	$profile=mc_fetch($uid,array('resideprovince','residedist','residedist','address','realname','mobile'));
	$address = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_address') . " WHERE deleted=0 and openid = :openid", array(':openid' => $from_user));
	if (empty($address) || count($address) == 0) {
			$useAddApi = true;
			if (!isset($_GPC['code'])) {
				$this->getUserTokenForAddr();
			}
			if (isset($_GPC['code']) && $_GPC['code'] != "authdeny") {
				$state = $_GPC['state'];
				$code = $_GPC['code'];
				$addressSignInfo = $this->getAddressSignInfo($code, "http://" . $_SERVER[HTTP_HOST] . "" . $_SERVER['REQUEST_URI'], $signPackage);
			}
	}
	$carttotal = $this->getCartTotal();
	include $this->template('address');
}