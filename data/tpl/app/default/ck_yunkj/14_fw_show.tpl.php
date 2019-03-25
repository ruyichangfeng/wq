<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>服务项目购买页 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
</head>
<body >
<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $this->createMobileUrl('fw_lsit', array('type' => $srdb['type']));?>">
	 <em class="return"><</em>
	 <span class="fanhui">返回</span>
	</a>
	</div>
</div>

<div id="content">
  
   <div class="serve-buy-bd">
      <form name="formpt" action="<?php  echo $this->createMobileUrl('fw_order');?>" method="post" >
	  <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	  <input type="hidden" name="price" value="<?php  echo $srdb['price'];?>">
	  <input type="hidden" name="sid" value="<?php  echo $srdb['id'];?>">
      <div class="serve-shop-info-top clearFix">
	      <div class="shoppic"><img src="<?php  echo tomedia($srdb['imgurl']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'"/></div>
		  <div class="shopinfo">
		    <h3 class="htit"><?php  echo $srdb['titlename'];?></h3>
			<P class="ptxt"><?php  echo $srdb['jianjie'];?></P>
		  </div>
	  </div>
	  <div class="serve-shop-g clearFix">
	    <span class="span-l">价格：<font class="price">￥<?php  echo $srdb['price'];?></font></span>
		<input type="submit" name="do_submit" value="立即购买" class="buy-btn" style="border:0px;">
	  </div>
	  </form>
	  
	  <div class="serve-shop-fuwu">
	     <h3 class="htit">服务介绍</h3>
		 <div class="txt"><?php  echo html_entity_decode($srdb['content']);?></div>
	  </div>
   </div>
   
   <?php  if($cwgl_config['copyright']) { ?>
	<style>
	.copyright{
		background-color: #FFFFFF;
		float: left;
		width: 100%;
		margin-top: 10px;
		border-top-width: 1px;
		border-top-style: solid;
		border-top-color: #CCCCCC;
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #CCCCCC;
	}
	.copyright .copyrightp{
		padding:15px;
		text-align: center;
	}
	</style>
	<div class="copyright">
		<div class="copyrightp">
		<?php  echo $cwgl_config['copyright'];?>
		</div>
	</div>
	<?php  } ?>
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('fw_footer', TEMPLATE_INCLUDEPATH)) : (include template('fw_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
