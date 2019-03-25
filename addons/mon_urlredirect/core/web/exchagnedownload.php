<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/9
 * Time: 23:44
 */

defined('IN_IA') or exit('Access Denied');
$params = array();
$jid = $_GPC['jid'];
$status = $_GPC['status'];
$ptype = $_GPC['ptype'];
$where = " e.jid =:jid";
$params[":jid"] = $jid;
if ($_GPC['uid'] != '') {
	$where .= " and e.uid =:uid";
	$params[":uid"] = $_GPC['uid'];
}

if ($_GPC['pid'] != '') {
	$where .= " and e.pid =:pid";
	$params[":pid"] = $_GPC['pid'];
}

if (!empty($status)) {
	$where .= " and e.status =:status";
	$params[":status"] = $status;
}

if (!empty($ptype)) {
	$where .= " and e.ptype =:ptype";
	$params[":ptype"] = $ptype;
}

$sqlPName = "(select pname from " . tablename(DBUtil::$TABLE_XKJT_PRIZE) .
	" p where p.id = e.pid ) as pname";

$sqlPType = "(select ptype from " . tablename(DBUtil::$TABLE_XKJT_PRIZE) .
	" p where p.id = e.pid ) as ptype";


$sqlNickName = "(select nickname from " . tablename(DBUtil::$TABLE_XKJT_USER) .
	" u where u.id = e.uid ) as nickname";
$sqlHeadimagUrl = "(select headimgurl from " . tablename(DBUtil::$TABLE_XKJT_USER) .
	" u where u.id = e.uid ) as headimgurl";


$sqlTel = "(select tel from ".tablename(DBUtil::$TABLE_XKJT_USER)." u1 where u1.id = e.uid) as tel";
$sqlUname = "(select uname from ".tablename(DBUtil::$TABLE_XKJT_USER)." u2 where u2.id = e.uid) as uname";



$list = pdo_fetchall("SELECT e.*, ".$sqlPName." ,".$sqlTel.", ".$sqlUname.",".$sqlPType.",".$sqlNickName.", ".$sqlHeadimagUrl." FROM " . tablename(DBUtil::$TABLE_XKJT_PRIZE_EXCHANGE_RECORD) . " e WHERE  " . $where . "   order by e.createtime desc", $params);


$i = 0;
foreach ($list as $key => $value) {
	$arr[$i]['pname'] = $value['pname'];
	$arr[$i]['nickname'] = $value['nickname'];
	$arr[$i]['uname'] = $value['uname'];
	$arr[$i]['tel'] = $value['tel'];
	$arr[$i]['ptype'] = $this->getPrizeTypeName($value['ptype']);

	$arr[$i]['unid'] = $value['unid'];

	if ($value['ptype'] == $this::$PRIZE_TYPE_GOOD || $value['ptype'] == $this::$PRIZE_WX_CARD) {
		$arr[$i]['ze'] = '-';
	} else if($value['ptype'] == $this::$PRIZE_TYPE_JF) {
		$arr[$i]['ze'] = $value['jf'];
	} else if($value['ptype'] == $this::$PRIZE_TYPE_YE) {
		$arr[$i]['ze'] = $value['ye'];
	}else if($value['ptype'] == $this::$PRIZE_TYPE_HB) {
		$arr[$i]['ze'] = $value['money'];
	}
	$arr[$i]['status'] = $this->getExchangeStatus($value['status']);
	$arr[$i]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);

	$i++;
}

MonUtil::exportexcel($arr, array('奖品名称', '兑换用户', '姓名', '手机', '奖品类型' ,"兑换订单号",  '现金红包/积分/余(总额)', '状态', "申请兑换时间"), $_GPC['dc'] ,'兑换数据');