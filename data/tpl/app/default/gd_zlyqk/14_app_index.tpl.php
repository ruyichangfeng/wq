<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0" />
    <title><?php  echo $title;?></title>

    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/mobile/css/swiper.min.css" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/weui/css/weui.css" />
    <link type="text/css" href="<?php echo MODULE_URL;?>/static/sy/css/style.css" rel="stylesheet" />
    <script src="<?php echo MODULE_URL;?>/static/sy/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/sy/js/jquery.event.drag.js"></script>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/sy/js/jquery.touchSlider.js"></script>
    <script src="<?php echo MODULE_URL;?>/static/mobile/js/layer.js"></script>
    <script src="<?php echo MODULE_URL;?>/static/mobile/js/swiper.min.js"></script>
    <style>
        .app_qr{position: absolute;margin-top:20px;right: 10px;width: 25px;}
        .limg{width: 170px;}
        .swiper-button-white{display: none !important;}
    </style>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("thems", TEMPLATE_INCLUDEPATH)) : (include template("thems", TEMPLATE_INCLUDEPATH));?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".a_cat").click(function(){
                location.href=$(this).attr("data-url");
            });
        });
    </script>
</head>

<body>
<div class="swiper-container" style="">
    <div class="swiper-wrapper">
        <?php  if(is_array($ads)) { foreach($ads as $ad) { ?>
        <img class="swiper-slide" src="/<?php  echo $ad['cover'];?>" data-url="<?php  echo $ad['url'];?>">
        <?php  } } ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-white"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
</div>
<div class="bulletin">
    <img src="<?php echo MODULE_URL;?>/static/sy/img/bulletin.png"/>
    <span>公告：
         <?php  if($notice) { ?>
            <span id="nts" data-url="<?php  echo $this->createMobileUrl('article')?>&id=<?php  echo $notice['id'];?>"><?php  echo $notice['title'];?></span>
            <?php  } else { ?>
            请在添加通知公告!
         <?php  } ?>
    </span>
</div>
<?php  if($categorys) { ?>
<div class="classification">
    <?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
    <div class="a_cat" data-url="<?php  echo $category['url'];?>">
        <img src="/<?php  echo $category['cover'];?>" style="width: 52px;height: 52px;border-radius: 26px;" />
        <div><?php  echo $category['name'];?></div>
    </div>
    <?php  } } ?>
</div>
<?php  } ?>
<div class="application">
    <?php  if(is_array($appList)) { foreach($appList as $app) { ?>
    <div class="application_content">
        <?php  if($isAdmin) { ?>
        <img class="app_qr" src="<?php echo MODULE_URL;?>/static/mobile/images/ewm.png" data-app="<?php  echo $app['id'];?>" data-admin="<?php  echo $isAdmin['id'];?>" >
        <?php  } ?>
        <a href="<?php  echo $this->createMobileUrl('index',array('app_id'=>$app['id']))?>">
            <div class="application_img"><img src="<?php  echo $app['icon'];?>"/></div>
            <div class="application_txt">
                <div><?php  echo $app['name'];?></div>
                <div><?php  echo $app['cover_desc'];?></div>
            </div>
        </a>
    </div>
    <?php  } } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
<script>
    $(function(){
        $("#nts").click(function(){
            location.href=$(this).attr("data-url");
        });
        $(".swiper-slide").click(function(){
            location.href=$(this).attr("data-url");
        });
    });

    var swiper = new Swiper('.swiper-container', {
        autoHeight: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });


    $(".app_qr").click(function(){
        var url = $(this).attr("data-url");
        layer.open({
            content: '<img class="limg" src="<?php  echo $this->createMobileUrl('appQr')?>&admin='+$(this).attr("data-admin")+'&app='+$(this).attr("data-app")+'">'
            ,style: 'border:none;width:70%;'
            ,time: 30
        });
    });
</script>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>