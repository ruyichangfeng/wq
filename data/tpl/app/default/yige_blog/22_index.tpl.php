<?php defined('IN_IA') or exit('Access Denied');?><html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php  echo $setting['name'];?></title>
    <meta name="description" content="<?php  echo $setting['description'];?>">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <link href="<?php echo MODULE_URL;?>/resources/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>/resources/site.min.css?v=35c9f39747">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script>
        function imgLoaded(img) {
            var imgWrapper = img.parentNode;
            imgWrapper.className += imgWrapper.className ? ' loaded' : 'loaded';
        }
    </script>

</head>
<body class="home-template vsc-initialized">


<div class="header" style="background-image: url(<?php  echo tomedia($setting['banner'])?>)">
    <div class="logoimg">
        <a href="" title="<?php  echo $setting['name'];?>"><img
                src="<?php echo MODULE_URL;?>/resources/icon.png" alt="<?php  echo $setting['name'];?>"
                width="78"></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="logotxt"><h1><a href=""><?php  echo $setting['name'];?></a></h1></div>
                <h2 class="site-name text-center"><?php  echo $setting['description'];?><span> <?php  echo $setting['description'];?> </span></h2>

            </div>
        </div>

    </div>
</div>
<main class="main" role="main">
    <div class="container">
        <div class="row" id="post-list">

            <?php  if(is_array($data)) { foreach($data as $item) { ?>
            <div class="col-xs-12 col-md-6">
                <article class="post tag-ad">
                    <h2 class="post-title">
                        <a href="<?php  echo $item['url'];?>" target="_blank"><?php  echo $item['name'];?></a>
                    </h2>
                    <div class="post-featured-image">
                        <a class="thumbnail loaded" href="<?php  echo $item['url'];?>" target="_blank">
                            <img src="<?php  echo tomedia($item['image'])?>" width="700"
                                 height="438" alt="<?php  echo $item['name'];?>" onload="imgLoaded(this)">
                        </a>
                    </div>
                </article>
            </div>
            <?php  } } ?>
        </div>
    </div>


</main>

<div class="submit-site">
    <div class="container">
        <div class="submit">
            <p class="text-center"><?php  echo $setting['description_bottom'];?></p>
        </div>
    </div>
</div>

<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">友情链接</h4>
                    <div class="content tag-cloud friend-links">
                        <?php  if(is_array($link1)) { foreach($link1 as $item) { ?>
                        <a href="<?php  echo $item['url'];?>" title="<?php  echo $item['name'];?>" target="_blank"><?php  echo $item['name'];?></a>
                        <?php  } } ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">技术支持</h4>
                    <div class="content tag-cloud">
                        <?php  if(is_array($link2)) { foreach($link2 as $item) { ?>
                        <a href="<?php  echo $item['url'];?>" title="<?php  echo $item['name'];?>" target="_blank"><?php  echo $item['name'];?></a>
                        <?php  } } ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="widget">
                    <h4 class="title">赞助商</h4>
                    <div class="content friend-links">
                        <?php  if(is_array($link3)) { foreach($link3 as $item) { ?>
                        <a href="<?php  echo $item['url'];?>" title="<?php  echo $item['name'];?>" target="_blank"><?php  echo $item['name'];?></a>
                        <?php  } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php  echo $setting['copyright'];?>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo MODULE_URL;?>/resources/jquery.min.js"></script>
<script src="<?php echo MODULE_URL;?>/resources/handlebars.min.js"></script>

<!--<script type="text/javascript" src="/assets/js/index.js?v=35c9f39747"></script>-->

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=22&c=utility&a=visit&do=showjs&m=yige_blog"></script></body>
</html>