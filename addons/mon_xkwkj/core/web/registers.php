<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {

	$keyword = $_GPC['keyword'];
	$where = ' weid=:weid';
	$params = array(
		':weid' => $this->weid
	);


	if (!empty($keyword)) {
		$where .= ' and (u.nickname like :nickname)';
		$params[':nickname'] = "%$keyword%";
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT u.*  FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER_INFO) . " u where  ".$where."
	  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_USER_INFO) . " u WHERE " . $where, $params);
	$pager = pagination($total, $pindex, $psize);

} else if ($operation == 'delete') {
	$openid = $_GPC['openid'];

	$countSql = "select count(*) from " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on u.kid=k.id where k.weid=:weid and u.openid=:openid";
	$total = pdo_fetchcolumn($countSql, array(':openid'=> $openid, ':weid'=> $this->weid));
	if ($total > 0) {
		message('删除失败， 用户有参与的活动信息，请先删除用户活动信息，再删除用户！', referer(), 'error');
	}


	$user = $this->findUniUserInfo($openid, $this->weid);
	if (!empty($user)) {
		pdo_query("delete from " . tablename(DBUtil::$TABLE_XKWKJ_USER_ADDRESS) . " where openid='{$openid}' and weid = '{$user['weid']}'");
		pdo_delete(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, array("unid" => $user['id']));
		pdo_delete(DBUtil::$TABLE_XKWKJ_USER_INFO, array("id" => $user['id']));
	}

	message('删除成功！', referer(), 'success');

	//pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("uid" => $uid));
	//pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array("uid" => $uid));
	//pdo_delete(DBUtil::$TABLE_XKWKJ_USER, array("id" => $uid));
	//message('删除成功！', referer(), 'success');
}


include $this->template("register_list");
