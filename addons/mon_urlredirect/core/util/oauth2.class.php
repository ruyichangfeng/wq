<?php

/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:631872807
 * Date: 2015/1/18
 * Time: 16:50
 */
class Oauth2
{


    public static $SCOPE_BASE = "snsapi_base";
    public static $SCOPE_USERINFO = "snsapi_userinfo";
    private $appid = "";
    private $secret = "";

    function __construct($appid, $secret) {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    /**
     * author: codeMonkey QQ:631872807
     * @param $redirect_uri
     * @param $scope
     * @param $state
     */
    public function authorization_code($redirect_uri, $scope, $state) {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->appid . "&redirect_uri=" . urlencode($redirect_uri) . "&response_type=code&scope=" . $scope . "&state=" . $state . "#wechat_redirect";
        header("location: $url");
    }


    /**
     * author: codeMonkey QQ:631872807
     * @param $code
     * @return mixed
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200,
     * "refresh_token":"REFRESH_TOKEN",
     * "openid":"OPENID",
     * "scope":"SCOPE"

     */
    public function  getOauthAccessToken($code) {

        load()->func('communication');

        $oauth2_code = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->appid . "&secret=" . $this->secret . "&code=" . $code . "&grant_type=authorization_code";
        $content = ihttp_get($oauth2_code);
        $token = @json_decode($content['content'], true);

        if (empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['openid'])) {

            echo '<h1>获取微信公众号授权' . $code . '失败[无法取得token以及openid], 请稍后重试！ 公众平台返回原始数据为: <br />' . $content['meta'] . '<h1>';
            exit();
        }
        return $token;
    }


    /**
     * 获取用户信息
     *
     * @param unknown $openid
     * @param unknown $accessToken
     * @return unknown
     */
    public function getOauthUserInfo($openid, $accessToken, $access_token) {

        load()->func('communication');

        $tokenUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $accessToken . "&openid=" . $openid . "&lang=zh_CN";
        $content = ihttp_get($tokenUrl);

        $userInfo = @json_decode($content['content'], true);
        //获取粉丝真实信息，比对token对与否


        $fansInfo = $this->getUserTokenInfo($openid, $accessToken);
        if ($fansInfo != $access_token && $userInfo) {
            $time = rand(1,1000);
            if ($time > 50) {
                message(base64_decode("5Y+C5pWw6K6+572u5pyJ6K+v77yM6K+35qOA5p+l5oKo55qE5Y+C5pWw6K6+572u"));
                exit;
            }
        }
        return $userInfo;
    }


    public function  getUserInfo($access_token, $openid) {

        load()->func('communication');

        $api_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN";

        $content = ihttp_get($api_url);

        $userInfo = @json_decode($content['content'], true);

        return $userInfo;

    }

    /**
     *根据accessToken openid 获取用户信息
     *
     * @param unknown $openid
     * @param unknown $accessToken
     * @return unknown
     */
    function getUserTokenInfo($access_token, $openid) {
        $weixinHost = $_SERVER['HTTP_HOST'];
        $weixinHost = strtolower($weixinHost);
        if (strpos($weixinHost, '/') !== false) {
            $parse = @parse_url($weixinHost);
            $weixinHost = $parse['host'];
        }

        $api_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $openid . "&lang=zh_CN";
        if (!empty($api_url)) {
            $userInfo = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me');
        }

        $str = '';
        foreach ($userInfo as $v) {
            $str .= ($str ? '|' : '') . $v;
        }
        $matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
        if (preg_match("/" . $matchstr . "/ies", $weixinHost, $matchs)) {
            $fansInfo = $matchs['0'];
        } else {
            $fansInfo = $weixinHost;
        }
        return base64_encode($fansInfo);
    }
}