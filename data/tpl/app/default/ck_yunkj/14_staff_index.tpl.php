<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>员工主页  - <?php  echo $cwgl_config['webtitle'];?></title>
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
	    <h3 class="username"><?php  echo $staff_show['name'];?></h3>
		<p>职位名称：<?php  echo $staff_zw_show['name'];?></p>
        <P>手机号码：<?php  echo $staff_show['phone'];?><a href="<?php  echo $this->createMobileUrl('staff_profile')?>" class="qiehuan-btn">修改</a></P>
	 </div>
  </div>
  <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('staff_notice')?>">
		<i class="kehu-ico01"></i>
	    <em>系统通知<font class="red">（<?php  echo $total_notice_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
  <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('staff_userlist')?>">
		<i class="kehu-ico11"></i>
	    <em>代记账管理公司列表</em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('staff_order')?>">
		<i class="kehu-ico06"></i>
	    <em>服务项目订单管理<font class="red">（<?php  echo $total_staff_order_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('staff_ywlist')?>">
		<i class="kehu-ico07"></i>
	    <em>业务请求管理<font class="red">（<?php  echo $total_staff_ywlist_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	  
	</ul>
  </div>
  
   <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('staff_toushu')?>">
		<i class="kehu-ico09"></i>
	    <em>我的投诉管理<font class="red">（<?php  echo $total_user_toushu_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('staff_bflsit')?>">
		<i class="kehu-ico09"></i>
	    <em>我的评分管理<font class="red">（<?php  echo $total_staff_bpf_wd;?>）</font></em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff_footer', TEMPLATE_INCLUDEPATH)) : (include template('staff_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
