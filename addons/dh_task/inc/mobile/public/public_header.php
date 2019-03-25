<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */

$from_user = $this->dh_fromuser;

//START*****************************************检测登录获取用户信息开始
$weid = $this->dh_weid;
$method = $_GPC['do'];
//method
$setting = $this->getSetting();
$get = $this->zaddslashes($_GET);
$authurl = $_W['siteroot'] . 'app/' . $this->createMobileUrl($method, $get, true) . '&authkey=1';
$url = $_W['siteroot'] . 'app/' . $this->createMobileUrl($method, $get, true);
if (isset($_COOKIE[$this->dh_auth2_openid])) {
    $from_user = $_COOKIE[$this->dh_auth2_openid];
    $nickname = $_COOKIE[$this->dh_auth2_nickname];
    $headimgurl = $_COOKIE[$this->dh_auth2_headimgurl];
} else {
    if (isset($_GPC['code'])) {
        $userinfo = $this->oauth2($authurl);
        if (!empty($userinfo)) {
            $from_user = $userinfo["openid"];
            $nickname = $userinfo["nickname"];
            $headimgurl = $userinfo["headimgurl"];
        } else {
            message('授权失败!');
        }
    } else {
        if (!empty($this->dh_appsecret)) {
            $this->getCode($url);
        }
    }
}
$fans = pdo_fetch("SELECT id FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));
if (empty($fans)) {
    if (!empty($from_user)) {
      $uid = intval($_GPC['uid'])?intval($_GPC['uid']):0;
	  if($setting['is_commission'] == 0){$uid = 0;}
      $insert = array('weid' => $weid, 'uid'=>$uid, 'from_user' => $from_user, 'nickname' => $nickname, 'headimgurl' => $headimgurl, 'dateline' => TIMESTAMP);
        if (!empty($this->dh_account)) {
            if (!empty($nickname)) {
                pdo_insert($this->table_fans, $insert);
            }
        } else {
            pdo_insert($this->table_fans, $insert);
        }
    }
} else {
    pdo_update($this->table_fans, array('nickname' => $nickname, 'headimgurl' => $headimgurl, 'lasttime' => TIMESTAMP), array('id' => $fans['id']));
}
//END*****************************************检测登录获取用户信息结束

$from_user = $this->dh_fromuser;//用户id
$fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));
$recharge = pdo_fetch("SELECT id,points FROM ".tablename($this->table_recharge)." WHERE weid=:weid AND user_id=:userid AND status=0 ",array(':weid'=>$weid,':userid'=>$fans['id']));
if($recharge){
	$fans['points'] = $fans['points']-$recharge['points'];
}//如果用户存在提现中的积分，则将当前积分减去提现中的积分
//处理分享标题和内容
$username = $fans['username']?$fans['username']:$fans['nickname'];
$setting['share_title'] = preg_replace("/#会员名#/",$username,$setting['share_title']);
$setting['share_desc'] = preg_replace("/#会员名#/",$username,$setting['share_desc']);
if($setting['is_commission']){//如果开启分享功能则加上uid
	$setting['share_link'] = $_W["siteroot"]."app/".$this->createMobileUrl("task", array("uid"=>$fans["id"]), true);
}else{
	$setting['share_link'] = $_W["siteroot"]."app/".$this->createMobileUrl("task", array(), true);
}
//赠送关注奖励
if($fans['point_gift'] == 0 && $_W['fans']['follow'] == 1 && !empty($setting['user_points'])){
	if($this->changePoints($fans['id'],$setting["user_points"],"关注公众号赠送积分")){
		pdo_query("update". tablename($this->table_fans) . " set point_gift=1 WHERE id = :id",array(":id"=>$fans['id']));
	}
}
//推广奖励
if(($setting['manner'] == 1 || $setting['manner'] == 2) && $setting['is_commission'] == 1 && $fans['uid'] && $fans['is_commission'] == 0 && $setting['share_point']>0){
	$user_follow = false;
	if($setting['manner'] == 2 && $_W['fans']['follow'] == 1){
		$user_follow = true;
	}
	if($setting['manner'] == 1){
		$user_follow = true;
	}
	if($user_follow){
		$username = $fans['username']?$fans['username']:$fans['nickname'];
		$this->changePoints($fans['uid'],$setting['share_point'],"推广奖励-".$username);
		pdo_query("update " . tablename($this->table_fans) . " set is_commission=1 WHERE id = :id",array(":id"=>$fans['id']));
	}
}
$webinfo['title'] = $setting['web_name']?$setting['web_name']:"鼎华人才培养系统";