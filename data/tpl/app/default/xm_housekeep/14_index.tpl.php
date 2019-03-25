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
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/swiper307.min.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-base.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-box.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/iconfont/iconfont.css">
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/ui-color.css">
<style>
.indexlist a:nth-child(3n+0) .ubr{
border-right: none;
}
.topa:nth-child(2n+0) .ubr{
border-right: none;
}
</style>
</head>
<body>

<div id="page0" class="c-gra1 ub ub-ver">
    <div style="height:12rem">
    	<div class="con0 swiper-container" style="height:100%; width:100%">
            <div class="swiper-pagination"></div>
            <div class="swiper-wrapper">
				<?php  if(is_array($list)) { foreach($list as $val) { ?>
                <div class="swiper-slide ub hide">
                    <img data-src="<?php  echo $_W['attachurl'];?><?php  echo $val['pic'];?>" class="swiper-lazy" style="width:100%">
            		<div class="swiper-lazy-preloader  swiper-lazy-preloader-white"></div>
                </div>
				<?php  } } ?>
            </div>
        </div>
    </div>
    <div class="ub-f1">
    	<div class="ubb b-bla01 ub c-wh umar-b1">
        <?php  if(is_array($top1)) { foreach($top1 as $val) { ?>
        	<a href="<?php  echo $this->createMobileUrl('Detailed',array('id'=>$val['id'],'typename'=>$val['name'],'name'=>'xm_housekeep'));?>" class="topa uof ub-f1 ub" style="">
            	<div class="ub ub-f1 ub-ac ub-pc ubr b-bla01">
                    <div class="uinn211 ub ub-ac">
                        <div><img src="<?php  echo $_W['attachurl'];?><?php  echo $val['icon'];?>" style="width:1.8rem;height:1.8rem"></div>
                        <div class="umar-l">
                            <div class="t-red font-b"><?php  echo $val['name'];?></div>
                            <div class="ulev-1 t-gra" style="text-overflow: clip;overflow:hidden; width:6rem; height:1rem;"><?php  echo $val['jianjie'];?></div>
                        </div>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
        <div class="ubt b-bla01 c-wh  umar-b1 indexlist">
        <?php  if(is_array($top2)) { foreach($top2 as $val) { ?>
        	<a href="<?php  echo $this->createMobileUrl('Detailed',array('id'=>$val['id'],'typename'=>$val['name'],'name'=>'xm_housekeep'));?>" class="ufl ub" style="width:33%; height:6rem">
            	<div class="ub ub-f1 ubb ubr b-bla01 ub-ver ub-ac ub-pc">
                    <div><img src="<?php  echo $_W['attachurl'];?><?php  echo $val['icon'];?>" style="width:1.8rem;height:1.8rem"></div>
                    <div class="t-gra font-b ulev-1"><?php  echo $val['name'];?></div>
                </div>
            </a>
            <?php  } } ?>
            <a href="<?php  echo $this->createMobileUrl('More',array('name'=>'xm_housekeep'));?>" class="ufl ub" style="width:33%; height:6rem">
            	<div class="ub ub-f1 ubb ubr b-bla01 ub-ver ub-ac ub-pc">
                    <div class="icon-gengduo1 iconfont ulev3 t-blu2"></div>
                    <div class="t-gra font-b ulev-1">更多服务</div>
                </div>
            </a>
            
            <div class="clear"></div>
        </div>
    </div>
    <div class="umar-t1" style="height:3em"></div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
</div>

<!--<script type="text/javascript" src="js/zepto1.3.min.js"></script>-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/main.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/swiper307.min.js"></script>
<script type="text/javascript">
var Scroll0 = new Swiper('.con0', {
        pagination: '.con0 .swiper-pagination',
		autoplay: 7000,
		watchSlidesProgress : true,
		watchSlidesVisibility : true,
		lazyLoading: true,
		lazyLoadingInPrevNext: true,
});

</script>

<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_housekeep"></script></body>
</html>