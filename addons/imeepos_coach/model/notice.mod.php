<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/4
 * Time: 3:04
 */
class notice
{
    public function mc_notice_custom_news($openid, $title, $content,$url,$thumb) {
        global $_W;
        load()->model('mc');
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
    public function mc_notice_consume($openid, $title, $content, $url = '',$thumbs='') {
        global $_W;
        load()->model('mc');
        $acc = mc_notice_init();
        $status = 0;
        if(is_error($acc)) {
            return false;
        }
        if($_W['account']['level'] == 3){
            $status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumbs);
        }
        if($_W['account']['level'] == 4) {
            $status = mc_notice_public($openid, $title, $_W['account']['name'], $content);
            if(is_error($status)){
                $status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumbs);
            }
        }
        if(is_error($status)){
            $status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumbs);
        }
        return $status;
    }
}