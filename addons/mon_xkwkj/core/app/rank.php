<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$kid = $_GPC['kid'];
MonUtil::checkmobile();
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
MonUtil::emtpyMsg($xkwkj, "炫酷砍价活动不存在或已删除");
$starttime = date("Y/m/d  H:i:s", $xkwkj['starttime'] );
$endtime = date("Y/m/d  H:i:s", $xkwkj['endtime'] );
$curtime = date("Y/m/d  H:i:s", TIMESTAMP);
$leftCount = $this->getLeftCount($xkwkj);
$status = $this->getStatus($xkwkj, null);
$statusText = $this->getStatusText($status);
$joinCount = $this->getJoinCount($xkwkj);

$join_rank_num = $xkwkj['join_rank_num'];

$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " WHERE kid =:kid   ORDER BY price asc, createtime desc limit 0,  ".$join_rank_num , array(':kid'=>$kid));


include $this->template("rank");
