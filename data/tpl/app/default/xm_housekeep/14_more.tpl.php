<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">    
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="format-detection" content="telephone=no">
<meta name="msapplication-tap-highlight" content="no">
<title>幸福家政</title>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-media.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-base.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-box.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/iconfont/iconfont.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-color.css">
</head>
<body>
<div id="page0" class="c-gra1 ub ub-ver">
    <?php  if(is_array($list)) { foreach($list as $vo) { ?>
	<div class="uinn ub ub-ac umar-t">
		<div><img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['icon'];?>" style="width:1.8rem;height:1.8rem"></div>
        <div class="umar-l"><?php  echo $vo['name'];?></div>
    </div>
	<div class="c-wh ubb ubt b-bla01 uinn11">
    	<?php  echo getProList($vo['id']);?>
    </div>
	<?php  } } ?>
    <!--
    <div class="uinn ub ub-ac umar-t">
    	<div class="icon-dingwei iconfont ulev1 t-blu"></div>
        <div class="umar-l">洗护服务</div>
    </div>
    <div class="c-wh ubb ubt b-bla01 uinn11">
    	<a href="order-form.html" class="ufl ub ub-ver ub-ac ub-pc" style="width:25%; height:4rem">
            <div class="icon-dingwei iconfont ulev3 t-blu2"></div>
            <div class="t-gra font-b ulev-1">洗衣洗鞋</div>
        </a>
        <a href="order-form.html" class="ufl ub ub-ver ub-ac ub-pc" style="width:25%; height:4rem">
            <div class="icon-dingwei iconfont ulev3 t-blu2"></div>
            <div class="t-gra font-b ulev-1">洗窗帘</div>
        </a>
        <a href="order-form.html" class="ufl ub ub-ver ub-ac ub-pc" style="width:25%; height:4rem">
            <div class="icon-dingwei iconfont ulev3 t-blu2"></div>
            <div class="t-gra font-b ulev-1">洗地毯</div>
        </a>
    </div>
    -->
    
    <div class="umar-t1" style="height:3em"></div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
	
</div>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/main.js"></script>
<script type="text/javascript">

</script>

<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_housekeep"></script></body>
</html>
