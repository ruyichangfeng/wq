<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$userInfo = $this->getClientUserInfo();
if (empty($userInfo)) {
	message("您未登录，或登录已失效");
}

//$listSql = "select u.id, k.id, k.p_name, k.p_y_price, k.p_low_price, k.p_preview_pic from ".tablename(DBUtil::$TABLE_XKWKJ_USER). " u left join "
//	.tablename(DBUtil::$TABLE_XKWKJ). " k on u.kid=k.id where k.show_index_enable=1 and k.weid=:weid and u.openid=:openid order by k.index_sort asc limit 0,".$this::$PAGE_SIZE;


$goods_name = "(select p_name from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_name";
$goods_preview_pic = "(select p_preview_pic from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_preview_pic";


$listSql = "select u.id, k.*, ".$goods_name." , ".$goods_preview_pic. " from ".tablename(DBUtil::$TABLE_XKWKJ). " k left join "
	.tablename(DBUtil::$TABLE_XKWKJ_USER). " u on u.kid=k.id where k.show_index_enable=1 and k.weid=:weid and u.openid=:openid order by k.index_sort asc limit 0,".$this::$PAGE_SIZE;



$countSql = "select count(*) from ".tablename(DBUtil::$TABLE_XKWKJ). " k left join "
	.tablename(DBUtil::$TABLE_XKWKJ_USER). " u on u.kid=k.id where k.show_index_enable=1 and k.weid=:weid and u.openid=:openid";
$params = array(
	":openid"=>$userInfo['openid'],
	":weid"=> $this->weid
);
$list = pdo_fetchall($listSql, $params);
$total = pdo_fetchcolumn($countSql , $params);
$next = false;
if ($total > $this::$PAGE_SIZE) {
	$next = true;
}
$indexsetting = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_INDEX_SETTING, array(':weid' => $this->weid));


$ppts =pdo_fetchall("select * from ".tablename(DBUtil::$TABLE_XKWKJ_PPTS)." c where p_type=:p_type order by dsort asc ",array(":p_type"=>self::PPT_INDEX));



include $this->template("my_kj_list");