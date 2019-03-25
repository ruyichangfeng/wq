<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$userInfo = $this->getClientUserInfo();
$uidSql = " (select id from ".tablename(DBUtil::$TABLE_XKWKJ_USER)." u where u.openid=:openid and u.kid=k.id) as uid ";
//$listSql = "select k.id, k.p_name, k.p_y_price, k.p_low_price, k.p_preview_pic , k.`v_user` , ".$uidSql." from ".tablename(DBUtil::$TABLE_XKWKJ) . " k where k.show_index_enable=1 and k.weid=:weid order by index_sort asc limit 0,". $this::$PAGE_SIZE;

$cid = $_GPC['cid'];
$where = " k.show_index_enable=1 and k.weid=:weid ";
$params = array(
	":openid"=>$userInfo['openid'],
	":weid"=> $this->weid
);

if (!empty($cid)) {
	$where.= " and k.cid= :cid";
	$params[':cid'] = $cid;
}


//as p_name , p_pic as p_pic, p_preview_pic

$goods_name = "(select p_name from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_name";
$goods_pic = "(select p_pic from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_pic";
$goods_preview_pic = "(select p_preview_pic from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_preview_pic";

$listSql = "select k.* ," .$goods_name .",".$goods_preview_pic.",".$uidSql." from ".tablename(DBUtil::$TABLE_XKWKJ) . " k where ".$where." order by index_sort asc limit 0,". $this::$PAGE_SIZE;
$list = pdo_fetchall($listSql, $params);
unset($params[':openid']);
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ) . " k where ".$where  , $params);
$next = false;
if ($total > $this::$PAGE_SIZE) {
	$next = true;
}
$indexsetting = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_INDEX_SETTING, array(':weid' => $this->weid));

$ppts =pdo_fetchall("select * from ".tablename(DBUtil::$TABLE_XKWKJ_PPTS)." c where p_type=:p_type and weid=:weid order by dsort asc ",array(":p_type"=>self::PPT_INDEX, ":weid"=> $this->weid));

if ($indexsetting['category_enable']) {
	$categoryies = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_CATEGORY) . " WHERE weid =:weid  ORDER BY display_sort asc ", array(':weid' => $this->weid));
}



include  $this->template("home_index");