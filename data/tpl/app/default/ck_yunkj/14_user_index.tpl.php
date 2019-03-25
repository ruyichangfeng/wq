<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>客户主页  - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php  echo $templateurl;?>/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php  echo $templateurl;?>/js/jquery.countdown.js"></script>
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
	    <h3 class="username"><?php  echo $user_show['name'];?></h3>
		<p>等级：<?php  if($user_show['type']) { ?>注册会员<?php  } else { ?>普通会员&nbsp;<a href="<?php  echo $this->createMobileUrl('user_payofficial')?>" class="qiehuan-btn">购买正式会员</a><?php  } ?></p>
		<?php  if($user_show['type']) { ?>
		<p>会员期限：
			<?php  if($newtimes < $user_show['deadline']) { ?>
			<div id="fnTimeCountDown" data-end="<?php  echo date('Y/m/d h:i:s', $user_show['deadline']);?>">
				<span class="year">00</span>年
				<span class="month">00</span>月
				<span class="day">00</span>&nbsp;天&nbsp;
				<span class="hour">00</span>&nbsp;时&nbsp;
				<span class="mini">00</span>&nbsp;分&nbsp;
				<span class="sec">00</span>&nbsp;秒
			</div>
			<script type="text/javascript">
				$("#fnTimeCountDown").fnTimeCountDown("<?php  echo date('Y/m/d H:i:s', $user_show['deadline']);?>");
			</script>
			<?php  } else { ?>
			<font color="#FFFF99">已到期，快去缴费吧！</font>
			<?php  } ?>
			
			<a href="<?php  echo $this->createMobileUrl('user_paycost2')?>" class="qiehuan-btn">我要续费</a>
		</p>
		<?php  } ?>
		<?php  if($user_show['registerdate']) { ?>
		<p>注册时间：<?php  echo date('Y-m-d', $user_show['registerdate']);?></p>
		<?php  } ?>
        <P>企业名称：<?php  echo $user_show['compname'];?><a href="<?php  echo $this->createMobileUrl('user_profile')?>" class="qiehuan-btn">设置</a></P>
		<P>联系电话：<?php  echo $user_show['phone'];?><a href="<?php  echo $this->createMobileUrl('user_phone')?>" class="qiehuan-btn">修改</a></P>
	 </div>
  </div>
  
  <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_notice')?>" >
		<i class="kehu-ico01"></i>
	    <em>系统通知 <?php  if($total_notice_wd1) { ?><font class="red">（<?php  echo $total_notice_wd1;?>）</font><?php  } ?></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_notice1')?>">
		<i class="kehu-ico02"></i>
	    <em>催费通知 <?php  if($total_notice_wd2) { ?><font class="red">（<?php  echo $total_notice_wd2;?>）</font><?php  } ?></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_order')?>">
		<i class="kehu-ico03"></i>
	    <em>购买的服务项目 <?php  if($total_order_w) { ?><font class="red">（<?php  echo $total_order_w;?>）<font size="-1">未</font><?php  } ?></font></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_paycost')?>">
		<i class="kehu-ico04"></i>
	    <em>在线缴费 <?php  if($total_pay_wz) { ?><font class="red">（<?php  echo $total_pay_wz;?>）<font size="-1">新</font></font><?php  } ?></em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
  <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_tallylist')?>">
		<i class="kehu-ico05"></i>
	    <em>年/月代记账查询 <?php  if($total_tallys_wd) { ?><font class="red">（<?php  echo $total_tallys_wd;?>）<font size="-1">新</font></font><?php  } ?></em>
		<span>></span>
		</a>
	  </li>

	  <li>
	    <a href="<?php  echo $this->createMobileUrl('fw_lsit_index')?>">
		<i class="kehu-ico06"></i>
	    <em>服务项目购买 <?php  if($total_service) { ?><font class="red">（<?php  echo $total_service;?>）</font><?php  } ?></em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_ywlist')?>">
		<i class="kehu-ico07"></i>
	    <em>发起业务请求</em>
		<span>></span>
		</a>
	  </li>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_accounting')?>">
		<i class="kehu-ico08"></i>
	    <em>查看专属会计</em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
   <div class="menu-box">
    <ul class="menu-list clearFix">
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_toushu')?>">
		<i class="kehu-ico09"></i>
	    <em>我要投诉</em>
		<span>></span>
		</a>
	  </li>
	  <?php  if($cwgl_config['invite_open']!=1) { ?>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('share_urlt', array('tgid' => $_W['member']['uid']));?>">
		<i class="kehu-ico10"></i>
	    <em>邀请好友注册会员</em>
		<span>></span>
		</a>
	  </li>
	  <?php  } ?>
	  <li>
	    <a href="<?php  echo $this->createMobileUrl('user_binding');?>">
		<i class="kehu-ico11"></i>
	    <em>邀请员工绑定注册</em>
		<span>></span>
		</a>
	  </li>
	</ul>
  </div>
  
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('user_footer', TEMPLATE_INCLUDEPATH)) : (include template('user_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
