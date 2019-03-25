<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 17/3/23
 * Time: 20:36
 */

defined('IN_IA') or exit('Access Denied');
foreach ($_GPC['idArr'] as $k => $cid) {
    $id = intval($cid);
    if ($id == 0)
        continue;
    $userCouponCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " WHERE cid=:cid and uid <> 0", array(':cid' => $cid));

    if ($userCouponCount == 0) {
        pdo_delete(DBUtil::$TABLE_COUPON, array("id" => $id));
    }
}
echo json_encode(array('code' => 200));