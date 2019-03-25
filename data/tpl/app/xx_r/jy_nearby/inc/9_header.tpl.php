<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php  echo $title;?></title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="<?php echo NEARBY_CSS;?>css.css">
	<link rel="stylesheet" href="<?php echo NEARBY_CSS;?>swiper.min.css">
	<link rel="stylesheet" href="<?php echo NEARBY_CSS;?>sweetalert.css">
	<link rel="stylesheet" href="<?php echo NEARBY_CSS;?>weui.min.css" type="text/css"/>
	<script type="text/javascript" src="<?php echo NEARBY_JS;?>sweetalert.min.js"></script>
	<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<?php  echo register_jssdk(false);?>