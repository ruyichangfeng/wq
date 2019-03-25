<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_tnyc012u2rlwstt9.css" media="all" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/css/main.css" media="all" />
    <script>
        var resPath="<?php echo MODULE_URL;?>/static/admin/js/";
    </script>
</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main">
            <a href="#" class="logo"><?php  echo $baseConfig['soft_names'];?></a>
            <!-- 显示/隐藏菜单 -->
            <a href="javascript:;" class="iconfont hideMenu icon-menu1" style="background: none"></a>
            <!-- 搜索 -->
            <!-- 天气信息 -->
            <div class="weather" pc style="margin-left: 10px;">
                <div id="tp-weather-widget"></div>
                <script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
                <script>tpwidget("init", {
                    "flavor": "slim",
                    "location": "WX4FBXXFKE4F",
                    "geolocation": "enabled",
                    "language": "zh-chs",
                    "unit": "c",
                    "theme": "chameleon",
                    "container": "tp-weather-widget",
                    "bubble": "disabled",
                    "alarmType": "badge",
                    "color": "#FFFFFF",
                    "uid": "U9EC08A15F",
                    "hash": "039da28f5581f4bcb5c799fb4cdfb673"
                });
                tpwidget("show");</script>
            </div>
            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <!--<li class="layui-nav-item showNotice" id="showNotice" pc>-->
                    <!--<a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>切换应用</cite></a>-->
                <!--</li>-->
                <li class="layui-nav-item" pc>
                    <a href="javascript:;">
                        <img src="<?php  if($supAdmin['avatar']) { ?><?php  echo $supAdmin['avatar'];?><?php  } else { ?><?php echo MODULE_URL;?>/static/admin/images/df.png<?php  } ?>" class="layui-circle" width="35" height="35">
                        <cite><?php  echo $_GPC['m_name'];?></cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" onclick="changePwd()"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>修改密码</cite></a></dd>
                        <dd><a href="<?php  echo $this->createWebUrl('loginout')?>" class="signOut"><i class="iconfont icon-loginout"></i><cite>退出系统</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>