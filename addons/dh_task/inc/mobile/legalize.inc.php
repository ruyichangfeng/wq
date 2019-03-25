<?php //认证
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_W,$_GPC;
$webinfo['title']= "用户认证";
$from_user = $this->dh_fromuser;

//START*****************************************检测登录获取用户信息开始
$weid = $this->dh_weid;
$method = 'legalize'; //method
$authurl = $_W['siteroot'] . 'app/' . $this->createMobileUrl($method, array(), true) . '&authkey=1';
$url = $_W['siteroot'] . 'app/' . $this->createMobileUrl($method, array(), true);
if (isset($_COOKIE[$this->dh_auth2_openid])) {    $from_user = $_COOKIE[$this->dh_auth2_openid];    $nickname = $_COOKIE[$this->dh_auth2_nickname];$headimgurl = $_COOKIE[$this->dh_auth2_headimgurl];}
else {  if (isset($_GPC['code'])) {$userinfo = $this->oauth2($authurl);if (!empty($userinfo)) {    $from_user = $userinfo["openid"];   $nickname = $userinfo["nickname"];  $headimgurl = $userinfo["headimgurl"];} 
else {    message('授权失败!');   }   } else {    if (!empty($this->dh_appsecret)) {    $this->getCode($url);   }   }}
$fans = pdo_fetch("SELECT id FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));
if (empty($fans)) {if(!empty($from_user)){$insert = array('weid' => $weid,'from_user' => $from_user,'nickname' => $nickname,'headimgurl' => $headimgurl,'dateline' => TIMESTAMP);
if (!empty($this->dh_account)) {  if (!empty($nickname)) {    pdo_insert($this->table_fans, $insert); }} else {  pdo_insert($this->table_fans, $insert); }}}
else {pdo_update($this->table_fans, array('nickname' => $nickname, 'headimgurl' => $headimgurl, 'lasttime' => TIMESTAMP), array('id' => $fans['id']));}
//END*****************************************检测登录获取用户信息结束
$from_user = $this->dh_fromuser;//用户id
$fans = pdo_fetch("SELECT id,legalize,status FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $from_user, ':weid' => $weid));
$setting = $this->getSetting();
if(empty($fans['status'])){
	$info = array('status'=>'error','msg'=>'你已经被禁止访问,请联系管理员');
	include $this->template($this->mobile_tpl . '/info');
	exit;
}
//以上是判断用户状态

if($fans['legalize'] == 0){//未认证
	$step = intval($_GPC['step'])?intval($_GPC['step']):1;
	if($step == 1){
		$taskCate = pdo_fetchall("SELECT * FROM " . tablename($this->table_task_cate) . " WHERE weid=:weid", array(':weid' => $weid));
		$step2url = $this->createMobileUrl('legalize', array('step'=>2), true);
	}elseif($step == 2){
		$taskcateid = intval($_GPC['taskcateid']);
		$step3url = $this->createMobileUrl('legalize', array('step'=>3,'taskcateid'=>$taskcateid), true);
	}elseif($step == 3){
		$taskcateid = intval($_GPC['taskcateid']);
		$sex = intval($_GPC['sex']);
		$step4url = $this->createMobileUrl('legalize', array('step'=>4,'taskcateid'=>$taskcateid,'sex'=>$sex), true);
	}elseif($step == 4){
		$userinfo['username'] = trim($_GPC['username']);
		$userinfo['cateid'] = intval($_GPC['taskcateid']);
		$userinfo['sex'] = intval($_GPC['sex']);
		$userinfo['mobile'] = trim($_GPC['mobile']);
		print_r($userinfo);
		if(empty($userinfo['username'])){
			$info['msg'] = '请输入姓名';
			$info['status'] = 'error';
		}
		if(empty($userinfo['cateid'])){
			$info['msg'] = '没有选择分类';
			$info['status'] = 'error';
		}
		if($userinfo['sex'] == 1 || $userinfo['sex'] == 2){
			
		}else{
			$info['msg'] = '没有选择性别';
			$info['status'] = 'error';
		}
		if(!preg_match("/^1[34578]\d{9}$/", $userinfo['mobile'])){
			$info['msg'] = '手机号码错误';
			$info['status'] = 'error';
		}
		if($info['status'] == 'error'){
			$info['url'] = 'javascript:history.go(-1)';
			include $this->template($this->mobile_tpl . '/info');
			exit;
		}
		$userinfo['legalize'] = 2;
		$sta = pdo_update($this->table_fans, $userinfo, array('from_user' => $from_user));
		if($sta){
			header("Location:".$this->createMobileUrl('legalize', array(), true));
			exit;
		}else{
			$info['msg'] = '提交认证失败';
			$info['status'] = 'error';
			$info['url'] = 'javascript:history.go(-1)';
			include $this->template($this->mobile_tpl . '/info');
			exit;
		}
	}
	
}elseif($fans['legalize'] == 2){//认证中

}else{//已认证
	header("Location:".$this->createMobileUrl('task', array(), true));
	exit;
}
include $this->template($this->mobile_tpl . '/legalize');