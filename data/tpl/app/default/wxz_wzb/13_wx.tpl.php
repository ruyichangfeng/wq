<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    </head>
    <body>
        <script type="text/javascript">
            var ua = navigator.userAgent.toLowerCase();
            var isWeixin = ua.indexOf('micromessenger') != -1;
            var isAndroid = ua.indexOf('android') != -1;
            var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);
            if (!isAndroid && !isIos) {
                document.head.innerHTML = '<title>抱歉，出错了</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"><link rel="stylesheet" type="text/css" href="https://res.wx.qq.com/open/libs/weui/0.4.1/weui.css">';
                document.body.innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><img src="../addons/wxz_wzb/qrcode/wxz_wzb<?php  echo $_W['uniacid'];?><?php  echo $rid;?>.png";"></div><div class="weui_text_area"><h4 class="weui_msg_title">请在手机微信客户端打开链接</h4></div></div>';
            }
        </script>
    <script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=wxz_wzb"></script></body>
</html>