<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
defined('IN_IA') or exit('Access Denied');
include "templateMsg.php";
require 'inc/func/core.php';

class dh_taskModuleSite extends Core {
    function __construct() {
        global $_W, $_GPC;
        $this->dh_fromuser = $_W['fans']['from_user'];

        $this->dh_weid = $_W['uniacid'];
        $account = $_W['account'];

        $this->dh_appid = '';
        $this->dh_appsecret = '';
        $this->dh_accountlevel = $account['level'];

        $this->dh_auth2_openid = 'auth2_openid_' . $_W['uniacid'];
        $this->dh_auth2_nickname = 'auth2_nickname_' . $_W['uniacid'];
        $this->dh_auth2_headimgurl = 'auth2_headimgurl_' . $_W['uniacid'];

        if (isset($_COOKIE[$this->dh_auth2_openid])) {
            $this->dh_fromuser = $_COOKIE[$this->dh_auth2_openid];
        }

        if ($this->dh_accountlevel < 4) {
            $setting = uni_setting($this->dh_weid);
            $oauth = $setting['oauth'];
            if (!empty($oauth) && !empty($oauth['account'])) {
                $this->dh_account = account_fetch($oauth['account']);
                $this->dh_appid = $this->dh_account['key'];
                $this->dh_appsecret = $this->dh_account['secret'];
            }
        } else {
            $this->dh_appid = $_W['account']['key'];
            $this->dh_appsecret = $_W['account']['secret'];
        }
        $this->mobile_tpl = "style1";
    }

    //后台页面标题
    public $actions_titles = array(
        'task'   => '任务管理',
        'fans'     => '会员管理',
        'task_review' => '任务领取记录',
        'points_record' => '积分记录',
        'point_propor'    => '积分提现',
        'task_category'  => '任务分类',
        'field' => '任务分类',
        'ad'      => '广告管理',
        'settings' => '系统设置',
        'cover'  => '入口设置',
        'task_nav' => '分类导航'
    );

    //用户积分改变和等级
    public function changePoints($userid,$points,$info,$level = 0){
        if(empty($userid) || empty($points) || empty($info)){
            return false;
        }
        $adduser = pdo_query("update " . tablename($this->table_fans) . " set points=points+$points WHERE id = :id AND weid=:weid",array(":id"=>$userid,":weid"=>$this->dh_weid));
        if($adduser){
            $insert = array(
                'weid'=>$this->dh_weid,
                'user_id'=>$userid,
                'points_income'=>$points,
                'points_desc'=>$info,
                'points_time'=>time(),
            );
            pdo_insert($this->table_points, $insert);
        }else{
            return false;
        }
        if(intval($level)){
            $level = intval($level);
            pdo_query("update " . tablename($this->table_fans) . " set level=level+$level WHERE id = :id AND weid=:weid",array(":id"=>$userid,":weid"=>$this->dh_weid));
        }
        return true;
    }
    public function getAd($type = 1,$limit = 5){
        global $_W;
        $adlist = pdo_fetchall("SELECT * FROM ".tablename($this->table_ad)." WHERE weid=:weid AND type=:type ORDER BY sorting asc,id desc LIMIT ".$limit,array(':weid'=>$_W['uniacid'],':type'=>$type));
        return $adlist;
    }

    public function doWebQueryFans() {
        global $_W, $_GPC;

        $kwd = $_GPC['keyword'];
        $sql = "SELECT * FROM " . tablename($this->table_fans) . " WHERE `weid`=:weid AND (`nickname` LIKE :nickname OR `username` LIKE :nickname) AND `nickname`<>'' ORDER
BY lasttime DESC,id DESC LIMIT 0,8";
        $params = array();
        $params[':weid'] = $_W['uniacid'];
        $params[':nickname'] = "%{$kwd}%";
        $ds = pdo_fetchall($sql, $params);
        foreach ($ds as $key => &$row) {
            $ds[$key]['nickname'] = !empty($row['username'])?$row['username']:$row['nickname'];
            $r = array();
            $r['id'] = $row['id'];
            $r['nickname'] = !empty($row['username'])?$row['username']:$row['nickname'];
            $r['headimgurl'] = $row['headimgurl'];
            $r['from_user'] = $row['from_user'];
            $row['entry'] = $r;
        }
        include $this->template('web/_query_fans');
    }

    

	//用户授权
    public function oauth2($url) {
        global $_GPC, $_W;
        load()->func('communication');
        $code = $_GPC['code'];
        if (empty($code)) {
            message('code获取失败.');
        }
        $token = $this->getAuthorizationCode($code);
        $from_user = $token['openid'];
        $userinfo = $this->getUserInfo($from_user);
        $sub = 1;
        if ($userinfo['subscribe'] == 0) {
            //未关注用户通过网页授权access_token
            $sub = 0;
            $authkey = intval($_GPC['authkey']);
            if ($authkey == 0) {
                $oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->dh_appid . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect";
                header("location:$oauth2_code");
            }
            $userinfo = $this->getUserInfo($from_user, $token['access_token']);
        }

        if (empty($userinfo) || !is_array($userinfo) || empty($userinfo['openid']) || empty($userinfo['nickname'])) {
            echo '<h1>获取微信公众号授权失败,无法取得用户信息, 请稍后重试！ 公众平台返回数据为: <br />' . $sub . $userinfo['meta'] . '<h1>';
            exit;
        }

        //设置cookie信息
        setcookie($this->dh_auth2_headimgurl, $userinfo['headimgurl'], time() + 3600 * 24);
        setcookie($this->dh_auth2_nickname, $userinfo['nickname'], time() + 3600 * 24);
        setcookie($this->dh_auth2_openid, $from_user, time() + 3600 * 24);
        return $userinfo;
    }

    public function getUserInfo($from_user, $ACCESS_TOKEN = '') {
        if ($ACCESS_TOKEN == '') {
            $ACCESS_TOKEN = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$from_user}&lang=zh_CN";
        } else {
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$ACCESS_TOKEN}&openid={$from_user}&lang=zh_CN";
        }

        $json = ihttp_get($url);
        $userInfo = @json_decode($json['content'], true);
        return $userInfo;
    }

    public function getAuthorizationCode($code) {
        $oauth2_code = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->dh_appid}&secret={$this->dh_appsecret}&code={$code}&grant_type=authorization_code";
        $content = ihttp_get($oauth2_code);
        $token = @json_decode($content['content'], true);
        if (empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['openid'])) {
            $oauth2_code = $this->createMobileUrl('task', array(), true);
            header("location:$oauth2_code");
            //echo '微信授权失败, 请稍后重试! 公众平台返回原始数据为: <br />' . $content['meta'] . '<h1>';
            exit;
        }
        return $token;
    }

    public function getAccessToken() {
        global $_W;
        $account = $_W['account'];
        if ($this->dh_accountlevel < 4) {
            if (!empty($this->dh_account)) {
                $account = $this->dh_account;
            }
        }
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($account['acid']);
        $access_token = $accObj->fetch_token();
        return $access_token;
    }

    public function getCode($url) {
        global $_W;
        $url = urlencode($url);
        $oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->dh_appid}&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=0#wechat_redirect";
        header("location:$oauth2_code");
    }
    
    //发送任务模板消息
    public function sendTaskTempMsgToUser($from_user, $taskid, $type = 1) {
        global $_W, $_GPC;
        $weid = $this->dh_weid;
        $tempid=$this->getSetting('task_tempid1');
        if(!empty($tempid)){
            $task = pdo_fetch("SELECT task_points,task_exp,task_title,is_review,task_do_time FROM ".tablename($this->table_task)." WHERE id=:id AND weid=:weid",array(':id'=>$taskid,':weid'=>$weid));
            $points_name = $this->getSetting('points_name');
            
            if($type == 1){//发送任务领取成功给用户
                $keyword2 = $task['is_review'] == 1?"进行中":"已完成";
                $content = array(
                    'first' => array(
                        'value' => "任务领取成功",
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $task['task_title'],
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => "领取支出：".$task['task_exp'].$points_name."\n完成奖励：".$task['task_points'].$points_name."\n领取时间：".date("Y-m-d H.i", TIMESTAMP)."\n完成时间：".$task['task_do_time'],
                        'color' => '#a6a6a9'
                    )
                );
                $url = $_W['siteroot'] . 'app/'.$this->createMobileUrl('me', array('op'=>'metask'), true);
            }elseif($type == 2){//发送任务审核通过给用户
                $keyword2 = "已完成";
                $content = array(
                    'first' => array(
                        'value' => "你的任务审核通过",
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $task['task_title'],
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => "获得奖励：".$task['task_points'].$points_name."\n审核时间：".date("Y-m-d H.i", TIMESTAMP),
                        'color' => '#a6a6a9'
                    )
                );
                $url = $_W['siteroot'] . 'app/'.$this->createMobileUrl('me', array('op'=>'metask'), true);
            }
            elseif($type == 3){//发送任务审核未通过给用户
                $keyword2 = "未通过";
                $content = array(
                    'first' => array(
                        'value' => "你的任务审核未通过",
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $task['task_title'],
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => "未获得奖励\n审核时间：".date("Y-m-d H.i", TIMESTAMP),
                        'color' => '#a6a6a9'
                    )
                );
                $url = $_W['siteroot'] . 'app/'.$this->createMobileUrl('me', array('op'=>'metask'), true);
            }
            
            load()->model('account');
            $access_token = WeAccount::token();
            $templateMsg = new templateMsg();
            $resule = $templateMsg->send_template_message($from_user, $tempid , $content, $access_token, $url);
        }
    }
    public function sendTaskTempMsgToAdmin($userid, $taskid, $task_user , $type = 1) {
        global $_W, $_GPC;
        $weid = $this->dh_weid;
        $tempid=$this->getSetting('task_tempid1');
        if(!empty($tempid)){
            //获取任务信息
            $task = pdo_fetch("SELECT task_points,task_exp,task_title,is_review,task_do_time FROM ".tablename($this->table_task)." WHERE id=:id AND weid=:weid",array(':id'=>$taskid,':weid'=>$weid));
            //获取任务领取人信息
            $taskuser = pdo_fetch("SELECT username,nickname FROM ".tablename($this->table_fans)." WHERE id=:id AND weid=:weid",array(':id'=>$task_user,':weid'=>$weid));
            $username = $taskuser['username']?$taskuser['username']:$taskuser['nickname'];
            //获取接收人from_user
            $user = pdo_fetch("SELECT from_user FROM ".tablename($this->table_fans)." WHERE id=:id AND weid=:weid",array(':id'=>$userid,':weid'=>$weid));
            $points_name = $this->getSetting('points_name');
            if($type == 1){//发送任务领取成功给管理员/审核人
                $keyword2 = $task['is_review'] == 1?"进行中":"已完成";
                $content = array(
                    'first' => array(
                        'value' => $username."支出".$task['task_exp'].$points_name."领取了任务",
                        'color' => '#333'
                    ),
                    'keyword1' => array(
                        'value' => $task['task_title'],
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => "领取时间：".date("Y-m-d H.i", TIMESTAMP)."\n完成时间：".$task['task_do_time'],
                        'color' => '#a6a6a9'
                    )
                );
                $url = $_W['siteroot'] . 'app/'.$this->createMobileUrl('me', array('op'=>'reviewtask'), true);
            }elseif($type == 2){//发送提交审核给审核员
                $keyword2 = "待审核";
                $content = array(
                    'first' => array(
                        'value' => $username."提交了任务审核",
                        'color' => '#333'
                    ),
                    'keyword1' => array(
                        'value' => $task['task_title'],
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => "提交时间：".date("Y-m-d H.i", TIMESTAMP)."\n请尽快为用户审核",
                        'color' => '#a6a6a9'
                    )
                );
                $url = $_W['siteroot'] . 'app/'.$this->createMobileUrl('me', array('op'=>'reviewtask'), true);
            }
            load()->model('account');
            $access_token = WeAccount::token();
            $templateMsg = new templateMsg();
            $resule = $templateMsg->send_template_message($user['from_user'], $this->getSetting('task_tempid1'), $content, $access_token, $url);
        }
    }

}