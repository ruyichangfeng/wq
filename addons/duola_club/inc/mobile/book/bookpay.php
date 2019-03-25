<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$schoolid = $_GPC['schoolid'];
$weid = $_W['uniacid'];
$op = $_GPC['op'] ? $_GPC['op'] : 'add';
if (empty($_W['openid'])) {
    message('无法获取到您的openid，请稍后重试');
}else{
    $payopenid = $_W['openid'];
}
if($op == 'add'){
    $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_cz'");
    if($margin['amount'] > 0){
        $rate = sprintf('%0.2f',$margin['couponAmount']/$margin['amount']);
    }else{
        $rate = 3;
    }
    include $this->template('book/bookcharge');
}elseif($op == 'cz'){
    if(empty($schoolid)){
        message('无法获取到您的schoolid，请稍后重试');
    }
    $tid = $_GPC['tid'];
    if(!empty($tid)){
        $paylog = pdo_fetch("SELECT * FROM ".tablename('core_paylog')." WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid ",array(':uniacid'=>$_W['uniacid'],':module'=>'jing_cash',':tid'=>$tid));
        if(!empty($paylog) && $paylog['status'] == 1 ){
            //开始处理额度
            $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $paylog['openid']));

            $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_cz'");
            $rate = $margin['couponAmount']/$margin['amount'];
            $cz_amount = $userAccount['cz_amount'] + $rate*$paylog['fee'];
            $balance = $userAccount['balance'] + $rate*$paylog['fee'];
            pdo_update($this->table_bookaccount,array('cz_amount' => $cz_amount,'balance' => $balance),array('openid' => $paylog['openid']));
            //发送模板消息
            $balance1 = $userAccount['balance'];
            $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $openid));
            if($orders['orderPrice']){
                $balance1 -= $orders['orderPrice'];
            }
            $trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename($this->table_mytransferorder) . " where  orderStatus in (1,2,3,4,5) And (openid = '{$openid}' or partybopenid = '{$openid}')");
            if(count($trans_orders) > 0){
                $orderPrice = 0;
                foreach ($trans_orders as $trans_order){
                    if($openid == $trans_order['openid'] && $trans_order['inPrice'] > 0){
                        $orderPrice += $trans_order['inPrice'];
                    }
                    if($openid == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
                        if($trans_order['outPrice'] > $trans_order['inPrice']){
                            $orderPrice += ($trans_order['outPrice']-$trans_order['inPrice']);
                        }
                    }
                }
                $balance1 -= $orderPrice;
            }
            if($balance1 < 0){
                $balance1 = 0;
            }
            $msgBody = array(
                'schoolid'   => $schoolid,
                'weid'       => $weid,
                'orderId'    => 10000,
                'orderType'  => 'cz',
                'amountData' => array(
                    'preAmount'   => $balance1,
                    'afterAmount' => $balance1+$rate*$paylog['fee'],
                    'amount'      => sprintf('%0.2f',$rate*$paylog['fee'])
                )
            );
            $this->sendMobileXsedbdtz($msgBody);
            //添加日志
            $data = array(
                'amount' => sprintf('%0.2f',$rate*$paylog['fee']),
                'type'   => 'cz',
                'openid' => $paylog['openid'],
                'remark' => '充值赠送额度'
            );
            pdo_insert($this->table_booklog,$data);
        }
    }
    die(json_encode(array(
        'result' => true,
        'msg'    => 'ok'
    )));
}elseif($op == 'tx'){
    if(empty($schoolid)){
       die(json_encode(array(
           'result' => false,
           'msg'    => 'error schoolid!'
       )));
    }
    $paylog = pdo_fetch("SELECT * FROM " . tablename('jing_cash_cash') . " WHERE `uniacid`=:uniacid AND `openid`=:openid ORDER BY createtime DESC", array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid']));
    if(!empty($paylog) && $paylog['status'] == 1){
        //开始处理额度
        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $paylog['payopenid']));

        $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_cz'");
        $rate = $margin['couponAmount']/$margin['amount'];
        $cz_amount = $userAccount['cz_amount'] - $rate*$paylog['money'];
        $balance = $userAccount['balance'] - $rate*$paylog['money'];
        pdo_update($this->table_bookaccount,array('cz_amount' => $cz_amount,'balance' => $balance),array('openid' => $paylog['payopenid']));
//			//发送模板消息
        $balance1 = $userAccount['balance'];
        $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $openid));
        if($orders['orderPrice']){
            $balance1 -= $orders['orderPrice'];
        }
        $trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename($this->table_mytransferorder) . " where  orderStatus in (1,2,3,4,5) And (openid = '{$openid}' or partybopenid = '{$openid}')");
        if(count($trans_orders) > 0){
            $orderPrice = 0;
            foreach ($trans_orders as $trans_order){
                if($openid == $trans_order['openid'] && $trans_order['inPrice'] > 0){
                    $orderPrice += $trans_order['inPrice'];
                }
                if($openid == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
                    if($trans_order['outPrice'] > $trans_order['inPrice']){
                        $orderPrice += ($trans_order['outPrice']-$trans_order['inPrice']);
                    }
                }
            }
            $balance1 -= $orderPrice;
        }
        if($balance1 < 0){
            $balance1 = 0;
        }
        $msgBody = array(
            'schoolid'   => $schoolid,
            'weid'       => $weid,
            'orderId'    => 10000,
            'orderType'  => 'tx',
            'amountData' => array(
                'preAmount'   => $balance1,
                'afterAmount' => $balance1-$rate*$paylog['money'],
                'amount'      => sprintf('%0.2f',$rate*$paylog['money']),
                'money'       => $paylog['money']
            )
        );
        $this->sendMobileXsedbdtz($msgBody);
        //添加日志
        $data = array(
            'amount' => sprintf('%0.2f',$rate*$paylog['money']),
            'type'   => 'tx',
            'openid' => $paylog['payopenid'],
            'remark' => '提现额度'
        );
        pdo_insert($this->table_booklog,$data);
    }
    die(json_encode(array(
        'result' => true,
        'msg'    => 'ok'
    )));
}
?>