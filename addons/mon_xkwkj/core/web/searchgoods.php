<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/8/21
 * Time: 21:53
 */


global $_W, $_GPC;
$pname = $_GPC['keyword'];
$sql = 'SELECT * FROM ' . tablename(DBUtil::$TABLE_XKWKJ_GOODS) . ' WHERE `weid`=:weid AND `p_name` LIKE :p_name';
$params = array();
$params[':weid'] = $this->weid;
$params[':p_name'] = "%{$pname}%";
$goods = pdo_fetchall($sql, $params);



foreach ($goods as &$row) {
	$r = array();
	$r['p_name'] = $row['p_name'];
	$r['id'] = $row['id'];
	$row['entry'] = $r;
}


include $this->template('search_goods');
