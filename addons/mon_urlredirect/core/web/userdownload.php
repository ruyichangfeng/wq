<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/9
 * Time: 23:07
 */

defined('IN_IA') or exit('Access Denied');

$dc = $_GPC['dc'];
$keyword = $_GPC['keyword'];
$where = '';
$params = array(
	':weid' => $this->weid
);

if (!empty($keyword)) {
	$where .= ' and (nickname like :nickname)';
	$params[':nickname'] = "%$keyword%";

}

if ($_GPC['uid'] != '') {
	$where .= ' and id=:uid';
	$params[':uid'] = $_GPC['uid'];
}

$pindex = max(1, intval($_GPC['page']));
$psize = 20;
$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_COUPON_USER) . " WHERE weid =:weid " . $where . "  ORDER BY createtime DESC ", $params);


$i = 0;
foreach ($list as $key => $value) {
	$arr[$i]['openid'] = $value['openid'];
	$arr[$i]['nickname'] = $value['nickname'];
	$arr[$i]['uname'] = $value['uname'];
	$arr[$i]['tel'] = $value['tel'];
	$arr[$i]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
	$i++;
}

MonUtil::exportexcel($arr, array('openid', '昵称', '姓名', "手机",  '注册时间'), $dc ,'参加用户');