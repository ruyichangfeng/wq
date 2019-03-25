<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2017/1/10
 * Time: 下午12:39
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];
//查询是否用户登录

$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
$period = intval($_GPC['period']);
if ($period == '1') {
    $starttime = date('Ym01',strtotime(0));
    $endtime = date('Ymd', time());
} elseif($period == '0') {
    $starttime = date('Ym01', strtotime(1*$period . "month"));
    $endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
} else {
    $starttime = date('Ym01', strtotime(1*$period . "month"));
    $endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
}
$where = "date_format(createDate,'%Y%m%d') >= '{$starttime}' and date_format(createDate,'%Y%m%d') <= '{$endtime}'";
if(empty($_GPC['orderType'])){
	$where .= "And type in('borrow_add','borrow_sub','transfer_add','transfer_sub','cz','tx','jy','mz','xj')";
}else{
	if($_GPC['orderType'] == 'ce'){
		$where .= "And type in('borrow_add','borrow_sub','transfer_add','transfer_sub')";		
	}elseif($_GPC['orderType'] == 'yj'){
		$where .= "And type in('cz','tx')";
	}else{
		$where .= "And type = '{$_GPC['orderType']}'";
	}

}
//查询booklog
$logs   = pdo_fetchall("SELECT * FROM " . tablename($this->table_booklog) . " where  openid = '{$openid}' ANd {$where} order by createDate desc");
$mz_amount = 0;
$jy_amount = 0;
$cz_amount = 0;
$ce_amount = 0;
$xj_amount = 0;
$data = array();
foreach($logs as $log){	
	switch($log['type']){
		case 'tx':
			$mark = '提现减额';
			$log['amount'] = -$log['amount'];
				//提现
			break;
		case 'cz':
			$mark = '押金增额';
				//充值
			break;
		case 'mz':
		    $mark = '上架临额激活';
				//上架满赠
			break;
		case 'jy':
			$mark = '集赞增额';
				//集赞赠送
			break;
		case 'borrow_add':
				$mark = '闲书增额';
				//闲书借出增额
			break;
		case 'borrow_sub':
				$mark = '闲书减额';
				$log['amount'] = -$log['amount'];
				//闲书入库减额
			break;
        case 'sign':
            $mark = '签到增额';
            $log['amount'] = $log['amount'];
            break;
		case 'transfer_add':
			$mark = '易书增额';
            $log['amount'] = $log['amount'];
			    //易书增额（首发）
			break;
		case 'transfer_sub':
			$mark = '易书减额';
			$log['amount'] = -$log['amount'];
				//易书减额（回选）
			break;
        case 'xj':
            $mark = '上架临额收回';
            $xj_amount += $log['amount'];
            $log['amount'] = -$log['amount'];
            //易书减额（回选）
            break;
			default:
			    break;
	}
	$log['remark'] = $mark;
	$data[] = $log;
}
$userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
if($userAccount['cz_amount'] > 0){
	$cz_amount = $userAccount['cz_amount'];
}
if($userAccount['jy_amount'] > 0){
	$jy_amount = $userAccount['jy_amount'];
}
if($userAccount['couponAmount'] > 0){
	$mz_amount = $userAccount['couponAmount'];
}
$sign_amount = 0;
if($userAccount['signAmount'] > 0){
    $sign_amount = $userAccount['signAmount'];
}
$orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $openid));
$orderCount = 0;
if($orders['orderPrice']){
    $orderCount += $orders['orderPrice'];
}
$trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename($this->table_mytransferorder) . " where  orderStatus in (1,2,3,4,5) And (openid = '{$openid}' or partybopenid = '{$openid}')");
if(count($trans_orders) > 0){
    foreach ($trans_orders as $trans_order){
        if($openid == $trans_order['openid'] && $trans_order['inPrice'] > 0){
            $orderCount += $trans_order['inPrice'];
        }
        if($openid == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
            if($trans_order['outPrice'] > $trans_order['inPrice']){
                $orderCount += ($trans_order['outPrice']-$trans_order['inPrice']);
            }
        }
    }
}

if($orderCount > $userAccount['balance']){
    $orderCount = $userAccount['balance'];
}

if($userAccount['balance'] > 0){
	$ce_amount = $userAccount['balance'] - $mz_amount - $jy_amount - $cz_amount-$sign_amount;
}
include $this->template('book/scorelist');