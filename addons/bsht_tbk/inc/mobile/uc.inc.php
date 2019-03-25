<?php
global $_GPC, $_W;
        $uniacid=$_W['uniacid'];
		$id=$_GPC['id'];
        $res=$this->res;
		$plus=$this->plus;
		load()->model('mc');
		load()->func('tpl');


$setting = $this->baseset($uniacid);
$settings = $this->module['config'];

$openid=$_W['openid'];
$userinfo=$this->Get_checkoauth();
if(empty($_W['openid'])){$openid = $userinfo['openid'];}

$follow=$userinfo['follow'];

$user=$this->getuserinfo($openid,$userinfo['nickname'],$userinfo['avatar'],$follow);


$touid = mc_openid2uid($openid);
if($touid){
$mcinfo=mc_fetch($touid);
$mc_data = array('credit1' => $mcinfo['credit1'],'credit2' => $mcinfo['credit2'],);
pdo_update($this->tableuser, $mc_data, array('uid' => $touid,'uniacid' => $_W['uniacid']));
}



$allcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc");


$indexcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND isindex=1 order by displayorder desc  LIMIT 8");

$_share['title'] = $setting['fxtit'];
$_share['imgUrl'] =tomedia($setting['fxlogo']);
$_share['desc'] =$setting['fxdes'];
$_share['link'] = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=index&m=bsht_tbk";
$_W['page']['sitename']=$setting['sitetitle'];

if(empty($_W['page']['sitename'])){
$pagename = '个人中心';
}else{$pagename=$_W['page']['sitename'];}

include $this->template('uc');
