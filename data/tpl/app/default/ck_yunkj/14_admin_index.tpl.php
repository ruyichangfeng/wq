<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>管理员主页  - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
<style>
.menu-list li a{
	display:block;
	height:50px;
	width:100%;
}
</style>
</head>
<body >

<div id="content" style="top:0px;">
  <div class="kehu-user-top clearFix">
     <div class="userpic">
		<?php  if($profile['avatar']) { ?>
		<img src="<?php  echo tomedia($profile['avatar']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'" />
		<?php  } else { ?>
		<img src="../addons/<?php  echo $_GPC['m'];?>/template/noavatar_middle.gif"/>
		<?php  } ?>
	 </div>
	 <div class="userinfo">
	    <h3 class="username"><font size="+2"><?php  echo $admin_show['username'];?></font></h3>
		<p>&nbsp;</p>
        <P>&nbsp;</P>
	 </div>
  </div>
  
  <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('admin_userlist')?>">
		<i class="kehu-ico11"></i>
	    <em>客户管理<font class="red">（<?php  echo $total_admin_userlist;?>）</font></em>
		<span>></span>
		</a>
	  </li>

	  <li>
	    <a href="<?php  echo $this->createMobileUrl('admin_payofficial')?>">
		<i class="kehu-ico11"></i>
	    <em>购买成为正式客户管理<font class="red">（<?php  echo $total_admin_payofficial_fp;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('admin_order')?>">
		<i class="kehu-ico06"></i>
	    <em>服务项目订单管理<font class="red">（<?php  echo $total_admin_order_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('admin_ywlist')?>">
		<i class="kehu-ico07"></i>
	    <em>业务请求管理<font class="red">（<?php  echo $total_admin_ywlist_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
   <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('admin_toushu')?>">
		<i class="kehu-ico09"></i>
	    <em>客户投诉管理<font class="red">（<?php  echo $total_admin_toushu_wd;?>）新</font></em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('admin_footer', TEMPLATE_INCLUDEPATH)) : (include template('admin_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
