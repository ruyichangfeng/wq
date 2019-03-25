<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
require '../../../../framework/bootstrap.inc.php';
$input = file_get_contents('php://input');
$isxml = true;

if (!empty($input) && empty($_GET['out_trade_no'])) {
    $obj = isimplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
    $data = json_decode(json_encode($obj), true);
    if (empty($data)) {
        $result = array(
            'return_code' => 'FAIL',
            'return_msg' => ''
        );
        echo array2xml($result);
        exit;
    }
    if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
        $result = array(
            'return_code' => 'FAIL',
            'return_msg' => empty($data['return_msg']) ? $data['err_code_des'] : $data['return_msg']
        );
        echo array2xml($result);
        exit;
    }
    $get = $data;
} else {
    $isxml = false;
    $get = $_GET;
}
load()->web('common');
load()->classs('coupon');
$_W['uniacid'] = $_W['weid'] = intval($get['attach']);
$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
$_W['acid'] = $_W['uniaccount']['acid'];

    $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniontid`=:uniontid';
    $pars = array();
    $pars[':uniontid'] = $get['out_trade_no'];
    $paylog = pdo_fetch($sql, $pars);

    $order = pdo_get('xcommunity_order',array('ordersn' => $paylog['tid']),array('companyid'));

    $payapi = pdo_fetch('select * from'.tablename('uni_account_modules')."where module=:module and uniacid =:uniacid ",array(':module' => 'xfeng_community',':uniacid' =>$_W['uniacid'] ));

    $set = iunserializer($payapi['settings']);
    if($set['xq_wechat']){
        //借用微信支付
        $api = pdo_get('xcommunity_pay_api',array('cid' => $order['companyid'],'paytype' => 2),array('pay'));
        $setting = unserialize($api['pay']);
        $wechat['appid'] = trim($setting['wechat']['appid']);
        $wechat['secret'] = trim($setting['wechat']['appsecret']);
        $wechat['mchid'] = trim($setting['wechat']['mchid']);
        $wechat['signkey'] = trim($setting['wechat']['apikey']);
        $wechat['apikey'] = trim($setting['wechat']['apikey']);
        $wechat['switch'] = 2;
        $wechat['account'] = $_W['uniacid'];
        $wechat['version'] = 2;
        $wechat['partner'] = '';
        $wechat['key'] = '';
        $wechat['borrow'] = 3;
        $wechat['sub_mch_id'] = '';
    }else{
        $setting = uni_setting($_W['uniacid'], array('payment'));
        if(!is_array($setting['payment'])) {
            exit('没有设定支付参数.');
        }
        $wechat = $setting['payment']['wechat'];
        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
        $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
        $wechat['appid'] = $row['key'];
        $wechat['secret'] = $row['secret'];
        //子商户
        if($set['xq_wechat_sub']){
            $api = pdo_get('xcommunity_pay_api',array('cid' => $order['companyid'],'paytype' => 3,'uniacid' => $_W['uniacid']),array('pay'));
            $setting = unserialize($api['pay']);
            $wechat['sub_mch_id'] = trim($setting['sub']['sub_mch_id']);
            $apis = pdo_get('xcommunity_pay_api',array('paytype' => 4,'uniacid' => $_W['uniacid']),array('pay'));
            $set = unserialize($apis['pay']);
            $wechat['signkey'] = trim($set['service']['signkey']);
            $wechat['mchid'] = trim($set['service']['mchid']);
        }
    }


    WeUtility::logging('pay', var_export($get, true));
    if(!empty($wechat)) {
        ksort($get);
        $string1 = '';
        foreach($get as $k => $v) {
            if($v != '' && $k != 'sign') {
                $string1 .= "{$k}={$v}&";
            }
        }
        $sign = strtoupper(md5($string1 . "key={$wechat['signkey']}"));
        if($sign == $get['sign']) {
            $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniontid`=:uniontid';
            $params = array();
            $params[':uniontid'] = $get['out_trade_no'];
            $log = pdo_fetch($sql, $params);
            if(!empty($log) && $log['status'] == '0' && (($get['total_fee'] / 100) == $log['card_fee'])) {
                $log['tag'] = iunserializer($log['tag']);
                $log['tag']['transaction_id'] = $get['transaction_id'];
                $log['uid'] = $log['tag']['uid'];
                $record = array();
                $record['status'] = '1';
                $record['tag'] = iserializer($log['tag']);
                pdo_update('core_paylog', $record, array('plid' => $log['plid']));
                if ($log['is_usecard'] == 1 && !empty($log['encrypt_code'])) {
                    $coupon_info = pdo_get('coupon', array('id' => $log['card_id']), array('id'));
                    $coupon_record = pdo_get('coupon_record', array('code' => $log['encrypt_code'], 'status' => '1'));
                    load()->model('activity');
                    $status = activity_coupon_use($coupon_info['id'], $coupon_record['id'], $log['module']);
                }

                $site = WeUtility::createModuleSite($log['module']);
                if(!is_error($site)) {
                    $method = 'payResult';
                    if (method_exists($site, $method)) {
                        $ret = array();
                        $ret['weid'] = $log['weid'];
                        $ret['uniacid'] = $log['uniacid'];
                        $ret['acid'] = $log['acid'];
                        $ret['result'] = 'success';
                        $ret['type'] = $log['type'];
                        $ret['from'] = 'notify';
                        $ret['tid'] = $log['tid'];
                        $ret['uniontid'] = $log['uniontid'];
                        $ret['transaction_id'] = $log['transaction_id'];
                        $ret['trade_type'] = $get['trade_type'];
                        $ret['follow'] = $get['is_subscribe'] == 'Y' ? 1 : 0;
                        $ret['user'] = empty($get['openid']) ? $log['openid'] : $get['openid'];
                        $ret['fee'] = $log['fee'];
                        $ret['tag'] = $log['tag'];
                        $ret['is_usecard'] = $log['is_usecard'];
                        $ret['card_type'] = $log['card_type'];
                        $ret['card_fee'] = $log['card_fee'];
                        $ret['card_id'] = $log['card_id'];
                        if(!empty($get['time_end'])) {
                            $ret['paytime'] = strtotime($get['time_end']);
                        }
                        $site->$method($ret);
                        if($isxml) {
                            $result = array(
                                'return_code' => 'SUCCESS',
                                'return_msg' => 'OK'
                            );
                            echo array2xml($result);
                            exit;
                        } else {
                            exit('success');
                        }
                    }
                }
            }
        }
    }

if($isxml) {
    $result = array(
        'return_code' => 'FAIL',
        'return_msg' => ''
    );
    echo array2xml($result);
    exit;
} else {
    exit('fail');
}
