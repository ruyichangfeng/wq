<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$userInfo = $this->getClientUserInfo();
$page_size = $this::$PAGE_SIZE;
$page = max(1, intval($_GPC['page']));
$start= $page_size + ($page - 1) * $page_size;
$uidSql = " (select id from ".tablename(DBUtil::$TABLE_XKWKJ_USER)." u where u.openid=:openid and u.kid=k.id) as uid ";
$cid = $_GPC['cid'];

$where = ' k.show_index_enable=1 and k.weid=:weid';
$params = array(
	":openid"=>$userInfo['openid'],
	":weid"=> $this->weid
);

if (!empty($cid)) {
	$where.= " and k.cid=:cid ";
	$params[':cid'] = $cid;
}


$goods_name = "(select p_name from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_name";
$goods_preview_pic = "(select p_preview_pic from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_preview_pic";


$listSql = "select  k.id, ".$goods_name.", k.p_y_price, k.p_low_price, ".$goods_preview_pic.", ".$uidSql."from ".tablename(DBUtil::$TABLE_XKWKJ) . " k where ".$where." order by index_sort asc limit ".$start.",". $page_size;
$list = pdo_fetchall($listSql, $params);

if (empty($list)) {
	echo "";
	exit;
}
include $this->template("index_page");