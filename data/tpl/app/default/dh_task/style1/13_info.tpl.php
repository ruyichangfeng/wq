<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  echo $webinfo['title'];?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style1/css/weui.css"/>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style1/css/weui2.css"/>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/style1/css/weui3.css"/>
    <script src="<?php echo MODULE_URL;?>template/mobile/style1/js/zepto.min.js"></script>
    <script>
    </script> 
</head>
<body ontouchstart  class="page-bg">
    <div class="weui_msg hide" id="msg2" style="display: block; opacity: 1;">
        <div class="weui_icon_area"><i class="<?php  if($info['status'] == 'success') { ?>weui_icon_success weui_icon_msg<?php  } else { ?>weui_icon_warn weui_icon_msg<?php  } ?>"></i></div>
        <div class="weui_text_area">
            <h2 class="weui_msg_title"><?php  if($info['status'] == 'success') { ?>操作成功<?php  } else { ?>操作失败<?php  } ?></h2>
            <p class="weui_msg_desc"><?php  echo $info['msg'];?></p>
        </div>
        <div class="weui_opr_area">
            <p class="weui_btn_area">
                <a href="<?php  echo $info['url'];?>" class="weui_btn weui_btn_primary">确定</a>
            </p>
        </div>
    </div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=dh_task"></script></body>
</html>