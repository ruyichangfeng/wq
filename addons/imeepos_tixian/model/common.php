<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/18
 * Time: 14:43
 */
class ImeeposTixian_common
{
    public function createImage($image){
        load()->func('file');
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $image, $result)){
            $type = $result[2];
            $filename = "images/imeepos_runner/".date('Y/m/d')."/".time()."_".random(6).".".$type;
            if(file_write($filename, base64_decode(str_replace($result[1],'',$image)))){
                $return = tomedia($filename);
            }
        }else{
            $return = tomedia($image);
        }
        return $return;
    }
    public function refund(){
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $params = array();
        $params['appid'] = '';
        $params['mch_id'] = '';
        $params['out_trade_no'] = '';
        $params['out_refund_no'] = '';
        $params['total_fee'] = '';
        $params['refund_fee'] = '';
        $params['op_user_id'] = '';
        $params['nonce_str'] = '';
        $params['sign'] = '';

    }
    public function createQr($url){
        global $_W,$_GPC;
        $path = IA_ROOT . '/addons/imeepos_fvoice/public/qrcode/' . $_W['uniacid'] . '/';
        if (!is_dir($path)) {
            load()->func('file');
            mkdirs($path);
        }
        $file = md5(base64_encode($url)) . '_qr.jpg';
        $qrcode_file = $path . $file;
        if(!is_file($qrcode_file)){
            require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
            QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
        }
        return $_W['siteroot'].'/addons/imeepos_fvoice/public/qrcode/' . $_W['uniacid'] . '/'.$file;
    }
    function mc_notice_consume2($openid, $title, $content, $url = '',$thumbs='') {
        global $_W;
        $acc = mc_notice_init();
        $status = 0;
        if(is_error($acc)) {
            return error(-1, $acc['message']);
        }
        if($_W['account']['level'] == 4) {
            $status = mc_notice_public($openid, $title, $_W['account']['name'], $content);
            if(is_error($status)){
                $status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumbs);
            }
        }
        if($_W['account']['level'] == 3){
            $status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumbs);
        }
        return $status;
    }
    function mc_notice_custom_news($openid, $title, $content,$url,$thumb) {
        global $_W;
        $acc = mc_notice_init();
        if(is_error($acc)) {
            return error(-1, $acc['message']);
        }
        $fans = pdo_fetch('SELECT salt,acid,openid FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

        $row = array();
        $row['title'] = urlencode($title);
        $row['description'] = urlencode($content);
        !empty($thumb) && ($row['picurl'] = tomedia($thumb));

        if(strexists($url, 'http://') || strexists($url, 'https://')) {
            $row['url'] = $url;
        } else {

            $pass['time'] = TIMESTAMP;
            $pass['acid'] = $fans['acid'];
            $pass['openid'] = $fans['openid'];
            $pass['hash'] = md5("{$fans['openid']}{$pass['time']}{$fans['salt']}{$_W['config']['setting']['authkey']}");
            $auth = base64_encode(json_encode($pass));
            $vars = array();
            $vars['__auth'] = $auth;
            if(empty($url)){
                $vars['forward'] = base64_encode($this->createMobileUrl('fans_home'));
            }else{
                $vars['forward'] = base64_encode($url);
            }


            $row['url'] =  $_W['siteroot'] . 'app/' . murl('auth/forward', $vars);
        }
        $news[] = $row;
        $send['touser'] = trim($openid);
        $send['msgtype'] = 'news';
        $send['news']['articles'] = $news;
        $status = $acc->sendCustomNotice($send);
        return $status;
    }
    /**
     * 格式化开始时间
     * */
    public function format_start_time($created_at) {
        if (!is_numeric($created_at)) {
            $created_at = strtotime($created_at);
        }
        $seconds = $created_at - time();
        $minutes = floor($seconds / 60);
        $hours = floor($seconds / (60 * 60));
        $days = floor($seconds / (60 * 60 * 24));
        if ($seconds <= 0) {
            return "报名进行中";
        } else if ($seconds < 60 && $seconds > 0) {
            return "即将开始";
        } elseif ($seconds < 120) {
            return "1分钟后开始";
        } elseif ($minutes < 60) {
            return $minutes . "分钟后开始";
        } elseif ($minutes < 120) {
            return "1小时后开始";
        } elseif ($hours < 24) {
            return $hours . "小时后开始";
        } elseif ($hours < 24 * 2) {
            return "1天后开始";
        } elseif ($days < 30) {
            return $days . "天后开始";
        } elseif ($days < 365) {
            return floor($days / 30) . "个月后开始";
        } else {
            return date("YYYY年mm月dd日", $created_at);
        }
    }
    /**
     * 格式化结束时间
     * */

    public function format_end_time($created_at) {
        if (!is_numeric($created_at)) {
            $created_at = strtotime($created_at);
        }

        $seconds = $created_at - time();
        $minutes = floor($seconds / 60);
        $hours = floor($seconds / (60 * 60));
        $days = floor($seconds / (60 * 60 * 24));

        if ($seconds <= 0) {
            return "已经结束";
        } else if ($seconds < 60) {
            return "即将结束";
        } elseif ($seconds < 120) {
            return "1分钟后结束";
        } elseif ($minutes < 60) {
            return $minutes . "分钟后结束";
        } elseif ($minutes < 120) {
            return "1小时后结束";
        } elseif ($hours < 24) {
            return $hours . "小时后结束";
        } elseif ($hours < 24 * 2) {
            return "1天后结束";
        } elseif ($days < 30) {
            return $days . "天后结束";
        } elseif ($days < 365) {
            return floor($days / 30) . "个月后结束";
        } else {
            return floor($days / 365) . "年后截止";
        }
    }
    /**
     * 格式化创建时间
     * */
    public function format_create_time($created_at) {
        if (!is_numeric($created_at)) {
            $created_at = strtotime($created_at);
        }
        $seconds = time() - $created_at;
        $minutes = floor($seconds / 60);
        $hours = floor($seconds / (60 * 60));
        $days = floor($seconds / (60 * 60 * 24));
        if ($seconds < 60) {
            return "刚刚";
        } elseif ($seconds < 120) {
            return "1分钟前";
        } elseif ($minutes < 60) {
            return $minutes . "分钟前";
        } elseif ($minutes < 120) {
            return "1小时前";
        } elseif ($hours < 24) {
            return $hours . "小时前";
        } elseif ($hours < 24 * 2) {
            return "1天前";
        } elseif ($days < 30) {
            return $days . "天前";
        } elseif ($days < 365) {
            return floor($days / 30) . "个月前";
        } else {
            return date("YYYY年mm月dd日", $created_at);
        }
    }
}