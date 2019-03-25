<?php

class ImeeposTixian_finance extends Imeepos_tixianModuleSite
{
    public function getSystemPay(){
        global $_W;
        load()->model('payment');
        $setting = uni_setting($_W['uniacid'], array('payment'));
        $wechat = $setting['payment']['wechat'];
        return $wechat;
    }
    public function pay($openid = '', $money = 0, $trade_no = '', $desc = '')
    {
        global $_W, $_GPC;
        if (empty($openid)) {
            return error(-1, 'openid不能为空');
        }
        $member = $this->M('member')->getInfo($openid);
        if (empty($member)) {
            return error(-1, '未找到用户');
        }
        $wechat = $this->getSystemPay();

        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
        $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
        $url                      = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $pars                     = array();
        $pars['mch_appid']        = $row['key'];
        $pars['mchid']            = $wechat['mchid'];
        $pars['nonce_str']        = random(32);
        $pars['partner_trade_no'] = empty($trade_no) ? time() . random(4, true) : $trade_no;
        $pars['openid']           = $openid;
        $pars['check_name']       = 'NO_CHECK';
        $pars['amount']           = $money;
        $pars['desc']             = empty($desc) ? '佣金提现' : $desc;
        $pars['spbill_create_ip'] = gethostbyname($_SERVER["HTTP_HOST"]);
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key=" . $wechat['apikey'];
        $pars['sign'] = strtoupper(md5($string1));
        $xml          = array2xml($pars);

        $pay_setting = $this->M('setting')->getSetting('pay');
        $extras = array();
        $weixin_cert_file = $pay_setting['weixin_cert_file'];
        $weixin_key_file = $pay_setting['weixin_key_file'];
        $weixin_root_file = $pay_setting['weixin_root_file'];
        $extras['CURLOPT_SSLCERT'] = $weixin_cert_file;
        $extras['CURLOPT_SSLKEY']  = $weixin_key_file;
        $extras['CURLOPT_CAINFO']  = $weixin_root_file;
        load()->func('communication');
        $resp = ihttp_request($url, $xml, $extras);

        if (is_error($resp)) {
            return error(-2, $resp['message']);
        }
        if (empty($resp['content'])) {
            return error(-2, '网络错误');
        } else {
            $arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new \DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new \DOMXPath($dom);
                $code  = $xpath->evaluate('string(//xml/return_code)');
                $ret   = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    return true;
                } else {
                    $error = $xpath->evaluate('string(//xml/return_msg)') . "<br/>" . $xpath->evaluate('string(//xml/err_code_des)');
                    return error(-2, $error);
                }
            } else {
                return error(-1, '未知错误');
            }
        }
    }
    public function refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney = 0)
    {
        global $_W, $_GPC;
        if (empty($openid)) {
            return error(-1, 'openid不能为空');
        }
        $member = m('member')->getInfo($openid);
        if (empty($member)) {
            return error(-1, '未找到用户');
        }
        $wechat = $this->getSystemPay();
        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
        $row = pdo_fetch($sql, array(':acid' => $wechat['account']));

        $url                   = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $pars                  = array();
        $pars['appid']         = $row['key'];
        $pars['mch_id']        = $wechat['mchid'];
        $pars['nonce_str']     = random(8);
        $pars['out_trade_no']  = $out_trade_no;
        $pars['out_refund_no'] = $out_refund_no;
        $pars['total_fee']     = $totalmoney;
        $pars['refund_fee']    = $refundmoney;
        $pars['op_user_id']    = $wechat['mchid'];
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key=" . $wechat['apikey'];
        $pars['sign'] = strtoupper(md5($string1));
        $xml          = array2xml($pars);

        $pay_setting = $this->M('setting')->getSetting('pay');
        $extras = array();
        $weixin_cert_file = $pay_setting['weixin_cert_file'];
        $weixin_key_file = $pay_setting['weixin_key_file'];
        $weixin_root_file = $pay_setting['weixin_root_file'];
        $extras['CURLOPT_SSLCERT'] = $weixin_cert_file;
        $extras['CURLOPT_SSLKEY']  = $weixin_key_file;
        $extras['CURLOPT_CAINFO']  = $weixin_root_file;
        load()->func('communication');
        $resp = ihttp_request($url, $xml, $extras);

        if (is_error($resp)) {
            return error(-2, $resp['message']);
        }
        if (empty($resp['content'])) {
            return error(-2, '网络错误');
        } else {
            $arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new \DOMDocument();
            if ($dom->loadXML($xml)) {
                $xpath = new \DOMXPath($dom);
                $code  = $xpath->evaluate('string(//xml/return_code)');
                $ret   = $xpath->evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                    return true;
                } else {
                    $error = $xpath->evaluate('string(//xml/return_msg)') . "<br/>" . $xpath->evaluate('string(//xml/err_code_des)');
                    return error(-2, $error);
                }
            } else {
                return error(-1, '未知错误');
            }
        }
    }
    public function downloadbill($starttime, $endtime, $type = 'ALL')
    {
        global $_W, $_GPC;
        $dates     = array();
        $startdate = date('Ymd', $starttime);
        $enddate   = date('Ymd', $endtime);
        if ($startdate == $enddate) {
            $dates = array(
                $startdate
            );
        } else {
            $days = (float) ($endtime - $starttime) / 86400;
            for ($d = 0; $d < $days; $d++) {
                $dates[] = date('Ymd', strtotime($startdate . "+{$d} day"));
            }
        }
        if (empty($dates)) {
            message('对账单日期选择错误!', '', 'error');
        }
        $wechat = $this->getSystemPay();
        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
        $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
        $content = "";
        foreach ($dates as $date) {
            $dc = $this->downloadday($date, $row, $wechat, $type);
            if (is_error($dc) || strexists($dc, 'CDATA[FAIL]')) {
                continue;
            }
            $content .= $date . " 账单\r\n\r\n";
            $content .= $dc . "\r\n\r\n";
        }
        $file = time() . ".csv";
        header('Content-type: application/octet-stream ');
        header('Accept-Ranges: bytes ');
        header("Content-Disposition: attachment; filename={$file}");
        header('Expires: 0 ');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0 ');
        header('Pragma: public ');
        die($content);
    }
    private function downloadday($date, $type)
    {
        $wechat = $this->getSystemPay();
        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
        $row = pdo_fetch($sql, array(':acid' => $wechat['account']));

        $url                 = 'https://api.mch.weixin.qq.com/pay/downloadbill';
        $pars                = array();
        $pars['appid']       = $row['key'];
        $pars['mch_id']      = $wechat['mchid'];
        $pars['nonce_str']   = random(8);
        $pars['device_info'] = "ewei_shop";
        $pars['bill_date']   = $date;
        $pars['bill_type']   = $type;
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key=" . $wechat['apikey'];
        $pars['sign'] = strtoupper(md5($string1));
        $xml          = array2xml($pars);
        $extras       = array();
        load()->func('communication');
        $resp = ihttp_request($url, $xml, $extras);
        if (strexists($resp['content'], 'No Bill Exist')) {
            return error(-2, '未搜索到任何账单');
        }
        if (is_error($resp)) {
            return error(-2, $resp['message']);
        }
        if (empty($resp['content'])) {
            return error(-2, '网络错误');
        } else {
            return $resp['content'];
        }
    }
}