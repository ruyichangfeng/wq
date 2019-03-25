<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/9/5
 * Time: 21:34
 */

global $_W, $_GPC;
$kwd = $_GPC['keyword'];
$sql = 'SELECT * FROM ' . tablename(DBUtil::$TABLE_URLREDIRECT) . ' WHERE `weid`=:weid AND `rname` LIKE :rname';

$params = array();
$params[':weid'] = $this->weid;
$params[':rname'] = "%{$kwd}%";
$redirects = pdo_fetchall($sql, $params);


if (!empty($redirects)) {
	foreach ($redirects as &$row) {
		$r = array();
		$r['rname'] = $row['rname'];
		$r['id'] = $row['id'];
		$row['entry'] = $r;
	}
}

include $this->template('web/reply_search');
