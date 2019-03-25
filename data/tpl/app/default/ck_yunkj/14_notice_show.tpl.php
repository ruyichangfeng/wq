<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>公告展示 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">

<style>
.shoppic_pt{
	margin-left:auto;
	margin-right:auto;
	width:50%;
}
.shoppic_pt img{
 	border-radius:50%;
	width:100%;
}
</style>
</head>
<body >
<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $this->createMobileUrl('index');?>">
	 <em class="return"><</em>
	 <span class="fanhui">返回</span>
	</a>
	</div>
</div>

<div id="content">
  
   <div class="serve-buy-bd">
	  
	  <div class="serve-shop-fuwu">
	     <h3 class="htit" style="text-align:center; font-weight:bold;"><?php  echo $srdb['titlename'];?></h3>
		 <div style=" width:100%; padding-top:10px; padding-bottom:10px; text-align:center; color:#666666;">
		 	 发布时间：<?php  echo date('Y-m-d H:i', $srdb['dateline']);?>&nbsp;&nbsp;&nbsp;&nbsp;
			 阅读：<font color="#FF6600"><?php  echo $hot;?></font>&nbsp;次
		 </div>
		 <div class="txt"><?php  echo html_entity_decode($srdb['message']);?></div>
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
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
