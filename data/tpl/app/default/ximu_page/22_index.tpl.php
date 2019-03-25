<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="<?php  echo $data['web_config']['keyword'];?>">
    <meta name="description" content="<?php  echo $data['web_config']['desc'];?>">
    <meta name="author" content="YY-MO">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="author" content="order by ximusoft.com" />
    <link rel="shortcut icon" href="/attachment/<?php  echo $data['web_config']['icon'];?>" />
    <link rel="stylesheet" type="text/css" href="<?php  echo $data['path'];?>/css/lib.css">
    <link rel="stylesheet" type="text/css"  href="<?php  echo $data['path'];?>/css/style.css">
    <link rel="stylesheet" type="text/css"  href="<?php  echo $data['path'];?>/css/4.css">
    <script type="text/javascript" src="<?php  echo $data['path'];?>/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="<?php  echo $data['path'];?>/js/lib.min.js"></script>
    <script type="text/javascript" src="<?php  echo $data['path'];?>/js/org.js" data-main="indexMain"></script>
    <title><?php  echo $data['web_config']['name'];?></title>
    <meta http-equiv="mobile-agent" content="format=xhtml;url=/m/index.php"></head>
<body >
<div id="header">
    <div class="content"> <a href="<?php  echo $data['url'];?>" id="logo"><img src="/attachment/<?php  echo $data['web_config']['logo'];?>" height="40" /></a>
        <ul id="nav">
            <li class="navitem"><a href="#sitecontent">首页</a></li>
            <li class="navitem"><a href="#mproject">案例</a></li>
            <li class="navitem"><a href="#mservice">服务</a></li>
            <li class="navitem"><a href="#mteam">团队介绍</a></li>
            <li class="navitem"><a href="#mpage">关于我们</a></li>
            <li class="navitem"><a href="#mpartner">合作伙伴</a></li>
            <li class="navitem"><a href="#mcontact">联系我们</a></li>
        </ul>
        <div class="clear"></div>
        <script type="application/javascript">
            $("#header li:eq(0)").addClass('active');
            $('.navitem').on('click',function () {
                $("#header li").removeClass('active');
                $(this).addClass('active');
            });
        </script>
    </div>
</div>
<div id="sitecontent">
    <div id="indexPage">
        <div id="mslider">
            <style type="text/css">
                #indexPage #mslider,#indexPage #mslider ul li{ height:700px}
            </style>
            <script type="text/javascript">$(function(){$("#mslider li video").each(function(index, element) {element.play();});})</script>
            <ul class="slider" data-options-auto="1" data-options-mode="0" data-options-pause="5">
                <?php  if(is_array($data['web_slide']['list'])) { foreach($data['web_slide']['list'] as $index => $item) { ?>
                <?php  if($item['images']) { ?>
                <li style="background-image:url(/attachment/<?php  echo $item['images'];?>)"  class="active">
                    <div id="tempImage_0"></div>
                    <img style="display:none" src="/attachment/<?php  echo $item['images'];?>" />
                    <div class="mask"></div>
                    <a target="_blank" >
                        <div>
                            <p class="title ellipsis"> </p>
                        </div>
                        <div class="sliderArrow fa fa-angle-down"></div>
                    </a></li>
                <?php  } ?>
                <?php  } } ?>

            </ul>
        </div>
        <div id="mproject" class="module bgShow" style="background-image:url(<?php  echo $data['path'];?>/images/al.png);">
            <div class="bgmask"></div>
            <div class="content">
                <div class="header">
                    <p class="title">案例</p>
                    <p class="subtitle">uelike design work</p>
                </div>
                <div id="projectlist">
                    <div class="wrapper">
                        <?php  if(is_array($data['web_item']['list'])) { foreach($data['web_item']['list'] as $index => $item) { ?>
                        <?php  if($item['images']) { ?>
                        <div class="projectitem wow fadeInUp" data-wow-delay="0.1s">
                            <a href="javascript:;" target="_blank">
                                <img src="/attachment/<?php  echo $item['images'];?>" width="500" height="320"/>
                                <div class="project_info">
                                    <div>
                                        <p class="title"><?php  echo $item['name'];?></p>
                                        <p class="subtitle"><?php  echo $item['desc'];?></p>
                                    </div>
                                    <div class="line1"></div>
                                </div>
                            </a>
                        </div>
                        <?php  } ?>
                        <?php  } } ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="mservice" class="module bgShow">
            <div class="bgmask"></div>
            <div class="content fw">
                <div class="header wow slideInUp" data-wow-delay=".1s">
                    <p class="title">服务</p>
                    <p class="subtitle">What can I do</p>
                </div>
                <div class="module-slider">
                    <div class="slider_control prev fl"></div>
                    <div class="slider_control next fr"></div>
                    <div class="slider_wrapper">
                        <ul class="slider">
                            <?php  if(is_array($data['web_service']['list'])) { foreach($data['web_service']['list'] as $index => $item) { ?>
                            <?php  if($item['images']) { ?>
                            <li class="serviceitem wow slideInUp" data-wow-delay=".1s"><a href="javascript:;" target="_blank">
                                <span class="kuangf"></span><img src="/attachment/<?php  echo $item['images'];?>" width="320" height="120" /></a>
                                <div>
                                    <p class="title"><?php  echo $item['name'];?></p>
                                    <p class="description"><?php  echo $item['desc'];?></p>
                                </div>
                            </li>
                            <?php  } ?>
                            <?php  } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="mteam" class="module bgShow" style="background-image:url(<?php  echo $data['path'];?>/images/team.png);">
            <div class="bgmask"></div>
            <div class="content fw">
                <div class="module-slider">
                    <div class="slider_control prev fl"></div>
                    <div class="slider_control next fr"></div>
                    <div class="slider_wrapper">
                        <ul class="slider">
                            <?php  if(is_array($data['web_team']['list'])) { foreach($data['web_team']['list'] as $index => $item) { ?>
                            <?php  if($item['images']) { ?>
                            <li>
                                <div class="header wow slideInUp" data-wow-delay=".2s">
                                    <a href="javascript:;" target="_blank">
                                        <img src="/attachment/<?php  echo $item['images'];?>" width="180" height="180" />
                                        <p class="title"><?php  echo $item['name'];?></p>
                                        <p class="subtitle"><?php  echo $item['position'];?></p>
                                        <div class="line1"></div>
                                    </a>
                                </div>
                                <p class="description wow slideInUp" data-wow-delay=".3s"><?php  echo $item['desc'];?></p>
                            </li>
                            <?php  } ?>
                            <?php  } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="mpage" class="module bgShow" style="background-image:url(<?php  echo $data['path'];?>/images/li.png);">
            <div class="bgmask"></div>
            <div class="content">
                <div class="module-slider">
                    <div class="slider_wrapper">
                        <ul class="slider one">
                            <li>
                                <div class="header wow fadeInUp" data-wow-delay=".2s">
                                    <p class="title">关于我们</p>
                                    <p class="subtitle">About me</p>
                                </div>
                                <p class="description wow fadeInUp" data-wow-delay=".3s"><?php  echo $data['web_config']['about'];?></p>
                                <a href="#mcontact" class="more wow fadeInUp" data-wow-delay=".5s">联系我们<strong class="line2"></strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <div class="fimg wow fadeInUp" data-wow-delay=".3s" style="background-image:url(/attachment/<?php  echo $data['web_config']['ads'];?>)"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="mpartner" class="module">
            <div class="bgmask"></div>
            <div class="content fw">
                <div class="module-slider">
                    <div class="slider_control prev fl wow bounceIn" data-wow-delay=".1s"></div>
                    <div class="slider_control next fr wow bounceIn" data-wow-delay=".1s"></div>
                    <div class="slider_wrapper">
                        <ul class="slider">
                            <?php  if(is_array($data['web_partner']['list'])) { foreach($data['web_partner']['list'] as $index => $item) { ?>
                            <?php  if($item['images']) { ?>
                            <li class="wow slideInUp" data-wow-delay=".1s">
                                <img src="/attachment/<?php  echo $item['images'];?>" width="160" height="80" />
                            </li>
                            <?php  } ?>
                            <?php  } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="mcontact" class="module bgShow" style="background-image:url(<?php  echo $data['path'];?>/images/us.jpg)">
            <div class="bgmask"></div>
            <div class="content fw">
                <div class="header wow fadeInUp" data-wow-delay=".1s">
                    <p class="title">联系我们</p>
                    <p class="subtitle">Contact us</p>
                </div>
                <div id="contactlist">
                    <div id="contactinfo" class="fl wow fadeInLeft" data-wow-delay=".2s">
                        <h3 class="ellipsis"><?php  echo $data['web_config']['name'];?></h3>
                        <p class="ellipsis">地址：<?php  echo $data['web_config']['address'];?></p>
                        <p class="ellipsis">Tel：<?php  echo $data['web_config']['tel'];?></p>
                        <p class="ellipsis">Email：<?php  echo $data['web_config']['email'];?></p>
                        <p class="ellipsis">腾讯QQ：<a title="QQ" target="_blank" style="color: rgb(113, 113, 113);" href="tencent://message/?uin=<?php  echo $data['web_config']['qq'];?>&Site=uelike&Menu=yes"><?php  echo $data['web_config']['qq'];?></a> </p>
                        <div>
                            <a class="fl" target="_blank" href="<?php  echo $data['web_config']['weibo'];?>">
                                <i class="fa fa-weibo"></i></a>
                            <a class="fl" target="_blank" href="tencent://message/?uin=<?php  echo $data['web_config']['qq'];?>&Menu=yes">
                                <i class="fa fa-qq"></i></a>
                            <a id="mpbtn" class="fl" href="/attachment/<?php  echo $data['web_config']['qrcode'];?>">
                                <i class="fa fa-weixin"></i></a>
                        </div>
                    </div>
                    <div id="contactform" class="wow fadeInRight" data-wow-delay=".2s">
                        <section class="" id="modules"
                                 style="margin-top: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;background-repeat: no-repeat;background-size: cover;background-position: center center;">
                            <div class="modules-fw-inner container-fluid">
                                <section class="section wpcom-modules modules-map row" id="modules-3"
                                         style="margin-top: 0;margin-bottom: 0;height: 400px;">
                                    <div id="maps" style="height: 100%;"></div>
                                </section>
                            </div>
                        </section>
                        <script type='text/javascript'
                                src='//api.map.baidu.com/api?v=2.0&#038;ak=0RisxUuPqPSBMWjZQ24ROEch4TQFrQXE&#038;ver=4.9.5'></script>
                        <script>
                            window.baidu_map = function (t, a, i, s) {
                                if (0 != $("#" + t).length) {
                                    var n = new BMap.Map(t, {enableMapClick: !1}), r = new BMap.Point(i[0], i[1]), o = new BMap.Marker(r);
                                    if (n.centerAndZoom(r, 16), n.addOverlay(o), s && n.enableScrollWheelZoom(), n.setMapStyle({
                                            styleJson: [{
                                                featureType: "all",
                                                elementType: "all",
                                                stylers: {lightness: 30, saturation: -80}
                                            }]
                                        }), a) {
                                        var l = new BMap.InfoWindow(a);
                                        o.openInfoWindow(l), o.addEventListener("click", function () {
                                            this.openInfoWindow(l)
                                        })
                                    }
                                }
                            }
                            baidu_map('maps', "<h3 class=\"map-title\"><?php  echo $data['web_config']['name'];?></h3><p class=\"map-address\"><?php  echo $data['web_config']['address'];?></p>", [<?php  echo $data['web_config']['map'];?>], 0);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer" style="position:relative; z-index:2"><p>Copyright &copy; 2018 <?php  echo $data['web_config']['name'];?> 版权所有&nbsp;&nbsp;<?php  echo $data['web_config']['icp'];?></p></div>
<div id="shares">
    <a href="javascript:;" id="gotop"><i class="fa fa-angle-up"></i></a>
</div>
<div class="hide"></div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=22&c=utility&a=visit&do=showjs&m=ximu_page"></script></body>
</html>