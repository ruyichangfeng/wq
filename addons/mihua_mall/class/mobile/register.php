<?php
$uniacid = $_W['uniacid'];
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
$id = $profile['id'];
if ($op == 'display') {
	$opp = $_GPC['opp'];
	$rule = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rules') . " WHERE `uniacid` = :uniacid ", array(':uniacid' => $_W['uniacid']));
	$fans = pdo_fetch('SELECT realname FROM ' . tablename('mc_members') . "mc left join ".tablename('mc_mapping_fans')." fans on fans.uid=mc.uid  WHERE  mc.uniacid = :uniacid  AND fans.openid = :from_user LIMIT 1", array(':uniacid' => $_W['uniacid'], ':from_user' => $from_user));
	if (empty($profile['realname'])) {
		$profile['realname'] = $fans['realname'];
	}
	$cfg = $this->module['config'];
	$ydyy = $cfg['ydyy'];
	include $this->template('register');
	exit;
}
$myfansx = pdo_fetch('SELECT * FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid` = :uniacid AND openid=:from_user limit 1", array(':uniacid' => $_W['uniacid'], ':from_user' => $from_user));
if (empty($myfansx['nickname']) && !empty($_GPC['realname'])) {
	pdo_update('mc_mapping_fans', array('nickname' => $_GPC['realname']), array('fanid' => $myfansx['fanid']));
}
if (!empty($profile['bankcard'])) {
	if (empty($_GPC['bankcard']) || empty($_GPC['banktype'])) {
		echo -1;
		exit;
}
	$data = array('realname' => $_GPC['realname'], 'mobile' => $_GPC['mobile'], 'pwd' => $_GPC['password'], 'bankcard' => $_GPC['bankcard'], 'banktype' => $_GPC['banktype'], 'alipay' => $_GPC['alipay'], 'wxhao' => $_GPC['wxhao']);
	pdo_update('mihua_mall_member', $data, array('id' => $profile['id']));
	echo 2;
	exit;
}
if ($op == 'add') {
	$shareids = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_share_history') . " WHERE  from_user=:from_user and uniacid=:uniacid limit 1", array(':from_user' => $from_user, ':uniacid' => $_W['uniacid']));
	if (!empty($shareids['sharemid'])) {
		$seid = $shareids['sharemid'];
		$member = $this->getMember($shareids['sharemid']);
		if ($member['flag'] != 1) {
			$seid = 0;
		}
	} else {
		$seid = 0;
	}
	$theone = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rules') . " WHERE  uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
	if ($theone['promotertimes'] == 1) {
		$data = array('uniacid' => $_W['uniacid'], 'from_user' => $from_user, 'realname' => $_GPC['realname'], 'bankcard' => $_GPC['bankcard'], 'banktype' => $_GPC['banktype'],  'mobile' => $_GPC['mobile'], 'pwd' => $_GPC['password'], 'alipay' => $_GPC['alipay'], 'wxhao' => $_GPC['wxhao'], 'createtime' => TIMESTAMP, 'flagtime' => TIMESTAMP, 'shareid' => $seid, 'status' => 1, 'flag' => 1);
	} else {
		$data = array('uniacid' => $_W['uniacid'], 'from_user' => $from_user, 'realname' => $_GPC['realname'], 'bankcard' => $_GPC['bankcard'], 'banktype' => $_GPC['banktype'],  'mobile' => $_GPC['mobile'], 'pwd' => $_GPC['password'], 'alipay' => $_GPC['alipay'], 'wxhao' => $_GPC['wxhao'] );
	}
	if ($data['from_user'] == $profile['from_user']) {
		pdo_update('mihua_mall_member', $data, array('id' => $profile['id']));
	} else {
		pdo_insert('mihua_mall_member', $data);
	}
	if ($seid > 0) {
		$sharemember = pdo_fetch('SELECT from_user,id FROM ' . tablename('mihua_mall_member') . " WHERE `uniacid` = :uniacid AND id=:id ", array(':uniacid' => $_W['uniacid'], ':id' => $seid));
		$joinfans = pdo_fetch('SELECT openid,nickname FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid` = :uniacid AND openid=:from_user limit 1", array(':uniacid' => $_W['uniacid'], ':from_user' => $from_user));
		if (!empty($sharemember) && !empty($sharemember['id']) && !empty($joinfans['nickname']) && $theone['promotertimes'] == 1) {
			$this->sendtjrtzdl($joinfans['nickname'], $sharemember['from_user']);
		}
	}
	$theone = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rules') . " WHERE  uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
	echo 1;
	exit;
}