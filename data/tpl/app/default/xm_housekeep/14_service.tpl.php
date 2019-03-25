<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">    
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="format-detection" content="telephone=no">
<meta name="msapplication-tap-highlight" content="no">
<title>服务说明</title>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-media.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/swiper307.min.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-base.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-box.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/iconfont/iconfont.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-color.css">
</head>
<body>
<div id="page0" class="c-wh ub ub-ver">
    <div class="ub-f1">
    	<div class="ubb b-bla01 ub umar-b1 uinn8 font-b ulev1">
        	<?php  echo $item['name'];?>
        </div>
        <div class="uinn8 page-con t-line15">
            <?php  echo $item['content'];?>
        </div>
    </div>
    <div class="umar-t1" style="height:3em"></div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
</div>

<!--<script type="text/javascript" src="js/zepto1.3.min.js"></script>-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/main.js"></script>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_housekeep"></script></body>
</html>
