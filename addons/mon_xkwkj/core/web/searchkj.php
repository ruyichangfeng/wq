<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/8/21
 * Time: 21:53
 */


global $_W, $_GPC;
$kwd = $_GPC['keyword'];
$sql = 'SELECT * FROM ' . tablename(DBUtil::$TABLE_XKWKJ) . ' WHERE `weid`=:weid AND `title` LIKE :title';
$params = array();
$params[':weid'] = $this->weid;
$params[':title'] = "%{$kwd}%";
$kjs = pdo_fetchall($sql, $params);



foreach ($kjs as &$row) {
	$r = array();
	$r['title'] = $row['title'];
	$r['id'] = $row['id'];
	$row['entry'] = $r;
}


include $this->template('reply_kj_search');
