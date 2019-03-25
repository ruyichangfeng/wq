<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php  echo $title;?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_tnyc012u2rlwstt9.css" media="all" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/css/news.css" media="all" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/css/global.css" media="all" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/css/main.css" media="all" />

    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/layui/layui.js"></script>
    <style type="text/css">
        .layui-table td, .layui-table th{ text-align: center; }
        .layui-table td{ padding:5px; }
        .layui-form-switch em{width: auto !important;}
    </style>
    <script>
        var resPath="<?php echo MODULE_URL;?>/static/admin/js/";
    </script>
</head>
<body class="childrenBody">