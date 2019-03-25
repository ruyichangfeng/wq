<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
$openid = m('user')->getOpenid();

$sql = 'select * from '.tablename('index_page_list').' where id=:id and uniacid=:uniacid';

$settings = pdo_fetch($sql,array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid'])); 

$settings['images'] = unserialize($settings['images']);

if($settings['weixin']==1){
	if (is_weixin() && strexists($_SERVER['REQUEST_URI'], '/app/')) {
		
	}else{

		 die("<!DOCTYPE html>
<html>
    <head>
        <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
        <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
    </head>
    <body>
    <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
    </body>
</html>");

	}
}

if($settings['status']==0){

	$sql = ' select id,readed from '.tablename('index_page_readed').' where moduleid=:moduleid and openid=:openid';
	
	$result = pdo_fetch($sql,array(':moduleid'=>$_GPC['id'],':openid'=>$openid));

	if($result){

		pdo_update('index_page_readed',array('readed'=>$result['readed']+1),array('id'=>$result['id']));

	}else{

		pdo_insert('index_page_readed',array('readed'=>1,'moduleid'=>$_GPC['id'],'openid'=>$openid));

	}
	//增加浏览量

	$id = 'indexpage'.$settings['id'];
	
	if(isset($_COOKIE[$id])){

		header("Location: ".$settings['url']); 

		exit;

	}else{

		setcookie($id,rand(0,99999),time()+7*3600*24);

		$images = $settings['images'];

		$sql = 'select share,share_title,share_image,share_desc from '.tablename('index_page_wxshare').' where uniacid=:uniacid and moduleid=:moduleid';

		$wx = pdo_fetch($sql,array(':uniacid'=>$_W['uniacid'],':moduleid'=>$settings['id']));

		$count = count($images);

		include $this->template('index');

	}

}else if($settings['status']==1){

	$sql = ' select id,readed from '.tablename('index_page_readed').' where moduleid=:moduleid and openid=:openid';
	
	$result = pdo_fetch($sql,array(':moduleid'=>$_GPC['id'],':openid'=>$openid));

	if($result){

		pdo_update('index_page_readed',array('readed'=>$result['readed']+1),array('id'=>$result['id']));

	}else{

		pdo_insert('index_page_readed',array('readed'=>1,'moduleid'=>$_GPC['id'],'openid'=>$openid));

	}
	//增加浏览量

	setcookie($id,rand(0,99999),time()+7*3600*24);

	$images = $settings['images'];

	$sql = 'select share,share_title,share_image,share_desc from '.tablename('index_page_wxshare').' where uniacid=:uniacid and moduleid=:moduleid';

	$wx = pdo_fetch($sql,array(':uniacid'=>$_W['uniacid'],':moduleid'=>$settings['id']));

	$count = count($images);

	include $this->template('index');


}



?>