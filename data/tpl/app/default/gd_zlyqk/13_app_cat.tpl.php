<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php  echo $title;?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0" />
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/weui/css/weui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>/static/sy/css/next.css"/>
</head>
<body>
<div class="top">
    <div><a href="javascript:history.back()"><img src="<?php echo MODULE_URL;?>/static/sy/img/D4339D7F-73FE-4292-8D13-5CDC5B7E4751.png"/></a></div>
    <div><?php  echo $title;?></div>
</div>
<div class="message">
    <?php  if(is_array($appList)) { foreach($appList as $app) { ?>
    <div class="message_content">
        <a href="<?php  echo $this->createMobileUrl('index',array('app_id'=>$app['id']))?>">
            <div class="message_img"><img src="<?php  echo $app['icon'];?>"/></div>
            <div class="message_txt">
                <div><?php  echo $app['name'];?></div>
                <div><?php  echo $app['cover_desc'];?></div>
            </div>
        </a>
    </div>
    <?php  } } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
