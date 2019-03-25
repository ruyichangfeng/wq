<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0" />
    <title><?php  echo $title;?></title>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/menu/fonts/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/weui/css/weui.css" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/weui/css/example.css" />
    <script src="<?php echo MODULE_URL;?>/static/menu/js/jquery-1.9.1.min.js" type="text/javascript"></script>

    <script src="<?php echo MODULE_URL;?>/static/weui/js/zepto.min.js"></script>
    <script src="<?php echo MODULE_URL;?>/static/weui/js/validform.js"></script>
    <script src="<?php echo MODULE_URL;?>/static/mobile/js/layer.js"></script>
    <!--<link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/address/css/LArea.min.css">-->
    <!--<script src="<?php echo MODULE_URL;?>/static/address/js/LAreaData1.js"></script>-->
    <!--<script src="<?php echo MODULE_URL;?>/static/address/js/LArea.js"></script>-->
    <script>
        var price=0;
    </script>
    <style>
        header { top: 0; height: 49px; background-color: #89e5d2; font-size: 1rem;width: 100%;position: fixed;z-index: 9999}
        header h3 { text-align: center; width: 100%; line-height:49px; color: #fff; font-size: 1rem; }
        header .back, header .btn-menu { position: absolute; z-index: 10; top: .8rem; display: block; line-height: 49px  }
        header .back { left: 1rem; }
        header .back{background: url(<?php echo MODULE_URL;?>/static/mobile/css/images/homepage.png) center center no-repeat; background-size: 1.5rem 1.5rem; width: 1.5rem; height: 1.5rem;}
        header .btn-menu { background-image: url(<?php echo MODULE_URL;?>/static/mobile/css/images/other.png); right: 1rem; width: 2rem; height: 2rem;background-size: 2rem 2rem; top:.5rem}
        .mobi{color:#666 !important;}
    </style>
</head>
<body style="height: 100%">
