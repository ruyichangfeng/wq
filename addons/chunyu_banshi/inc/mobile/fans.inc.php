<?php 

global $_W,$_GPC;
//所有页面都要引用这个方法，判断用户是否关注
$fan=mc_oauth_userinfo();
$mid=0;

var_dump($fan);

echo "<hr>";

$member=$_W['fans'];

var_dump($member);



// $user=pdo_fetch("SELECT * FROM ".tablename('peng_report_member')." WHERE weid=:uniacid AND openid=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$member['openid']));

// if(empty($user)){

// 	$data = array(
// 		'weid'=>$_W['uniacid'],
// 		'openid'=>$member['openid'],
// 		'nickname'=>$member['tag']['nickname'],
// 		'tel'=>'',
// 		'address'=>'',
// 		'avatar'=>$member['avatar'],
// 		'integral'=>'',
// 		'country'=>$member['tag']['country'],
// 		'province'=>$member['tag']['province'],
// 		'city'=>$member['tag']['city'],
// 		'createtime'=>time(),
// 	);
// 	$result = pdo_insert('peng_report_member', $data);

// 	if($result){
// 		$userinfo=pdo_fetch("SELECT * FROM ".tablename('peng_report_member')." WHERE weid=:uniacid AND openid=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$member['openid']));

// 		if(!empty($userinfo)){
// 			$mid=$userinfo['mid'];			
// 		}	
// 	}

// }else{

// 	$mid=$user['mid'];
// }

// return $mid;