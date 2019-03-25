<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 16/9/1
 * Time: 下午5:00
 */
function p($arr){
    echo "<pre>";
    print_r($arr);
}
//模板消息提醒
function sendtpl($openid, $url, $template_id, $content) {
    global $_GPC, $_W;
    load() -> classs('weixin.account');
    load() -> func('communication');
    $obj = new WeiXinAccount();
    $access_token = $obj -> fetch_available_token();
    $data = array(
        'touser' => $openid,
        'template_id' => $template_id,
        'url' => $url,
        'topcolor' => "#FF0000",
        'data' => $content,
    );
    $json = json_encode($data);
    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
    $ret = ihttp_post($url, $json);
}
//文本消息提醒
function sendtext($text,$openid){
    global $_GPC, $_W;
    load() -> func('tpl');
    load() -> model('mc');
    $acc = WeAccount::create($_W['account']['acid']);
    $send = array("touser" =>$openid, "msgtype" => "text", "text" => array("content" => urlencode($text)));
    $res = $acc -> sendCustomNotice($send);
}
function getmedia($media_id,$file,$picname){
    $access_token = WeAccount::token();
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
    if (!file_exists($file)) {
        mkdir($file, 0777, true);
    }
    $targetName = '..'.$file.'/'.$picname;
    $ch = curl_init($url); // 初始化
    $fp = fopen($targetName, 'wb'); // 打开写入
    curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return $file.'/'.$picname;
}
//提现
function tx($partner_trade_no,$openid,$amount,$des,$appid,$key,$mchid){
    global $_W,$_GPC;
    load()->func('communication');
    $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    $pars = array();
    $pars['mch_appid'] = $appid;
    $pars['mchid'] = $mchid;
    $pars['nonce_str']= random(32);
    $pars['partner_trade_no']=$partner_trade_no;
    $pars['openid']=$openid;
    $pars['check_name']= 'NO_CHECK';
    $pars['amount']=$amount;
    $pars['desc']=$des;
    $pars['spbill_create_ip']='127.0.0.1';
    ksort($pars,SORT_STRING);
    $string1 = '';
    foreach ($pars as $k => $v) {
        $string1 .= "{$k}={$v}&";
    }
    $string1 .= "key={$key}";//支付密钥
    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();
    $extras['CURLOPT_CAINFO'] = MODULE_ROOT . '/cert/rootca.pem.' . $_W['uniacid'];
    $extras['CURLOPT_SSLCERT'] = MODULE_ROOT . '/cert/apiclient_cert.pem.' . $_W['uniacid'];
    $extras['CURLOPT_SSLKEY'] = MODULE_ROOT . '/cert/apiclient_key.pem.' . $_W['uniacid'];
    $procResult = null;
    $resp = ihttp_request($url, $xml, $extras);
    if (is_error($resp)) {
        $procResult = $resp;
    } else {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        $dom = new DOMDocument();
        if ($dom->loadXML($xml)) {
            $xpath = new DOMXPath($dom);
            $code = $xpath->evaluate('string(//xml/return_code)');
            $ret = $xpath->evaluate('string(//xml/result_code)');
            if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                $procResult = error(1,'success');
            } else {
                $error = $xpath->evaluate('string(//xml/err_code_des)');
                $code = $xpath->evaluate('string(//xml/err_code)');
                $procResult = error(-2, array('code' => $code, 'error' => $error));
            }
        } else {
            $procResult = error(-1, 'error response');
        }
    }
    //echo json_encode(array('error'=>-1,'message'=>$procResult));return false;
    return $procResult;
}
//检测手机号码
function checkmobile($mobile){
    if(preg_match("/^1[34578]{1}\d{9}$/",$mobile)){
        return true;
    }else{
        return false;
    }
}
function createqrcode($openid){
    global $_W;
    //先检测有没有图片二维码,然后再生成
    $filedir = '/addons/qw_microedu/assets/img/qr/';
    $qr = $filedir.$openid.'.jpg';
    if(file_exists('..'.$qr)){
        return array(1,'已存在',$qr);
    }else {
        load()->func('communication');
        load()->classs('weixin.account');
        load()->func('file');
        $acc = WeAccount::create($_W['account']['acid']);
        $qrcid = pdo_fetchcolumn("SELECT qrcid FROM " . tablename('qrcode') . " WHERE acid = :acid AND model = '2' AND uniacid=:uniacid ORDER BY qrcid DESC", array(':acid' => $_W['account']['acid'], ':uniacid' => $_W['uniacid']));
        $barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid + 1) : 1;
        if ($barcode['action_info']['scene']['scene_id'] > 100000) {
            return array(-1,'生成数量超过最大数',$qr);
            die;
            //返回错误
        }
        $barcode['action_name'] = 'QR_LIMIT_SCENE';
        $result = $acc->barCodeCreateFixed($barcode);
        if (!is_error($result)) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'acid' => $_W['account']['acid'],
                'qrcid' => $barcode['action_info']['scene']['scene_id'],
                'name' => '324',
                'model' => '2',
                'ticket' => $result['ticket'],
                'expire' => $result['expire_seconds'],
                'createtime' => TIMESTAMP,
                'status' => '1'
            );
            pdo_insert('qrcode', $data);
            $qrid = pdo_insertid();
            $file = ihttp_get('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket']);
            $file = $file['content'];
            // $qr = $filedir.$openid.'.jpg';
            file_write('..'.$qr, $file);
            return array(1,'生成成功',$qr);
            die;
        }
        else {
            return array(-1,'未知错误',$qr);
            die;
        }
    }
}