<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>押金余额</title>
    <link rel="stylesheet" href="<?php echo CSS_PATH;?>weui.css?v=1"/>
    <?php  echo register_jssdk()?>
</head>
<body>
<style type="text/css">
    body,html{height:100%;-webkit-tap-highlight-color:transparent}.page,body{background-color:#fbf9fe}.page{overflow-y:auto;-webkit-overflow-scrolling:touch}
</style>
<div class="page">
    <div class="weui_msg">
        <div class="weui_icon_area"><i class="weui_icon_safe weui_icon_safe_success"></i></div>
        <div class="weui_text_area">
            <h2 class="weui_msg_title" style="font-size: 16px;color: #888;">我的余额</h2>
            <p class="weui_msg_desc" style="font-size: 24px;color: #000;">￥<?php  echo $result['credit2'];?></p>
        </div>
        <div class="weui_opr_area">
            <p class="weui_btn_area">
                <a href="./index.php?i=9&c=entry&schoolid=8&do=dispatchMobileBook&op=bookPay&m=duola_club" class="weui_btn weui_btn_primary">押金提额</a>
                <a href="<?php  echo $this->createMobileUrl('cash',array('schoolid' => $schoolid))?>" class="weui_btn weui_btn_default">押金提现</a>
            </p>
        </div>
        <div class="weui_extra_area" style="position: absolute;">
            <a href="<?php  echo $this->createMobileUrl('bond', array('credittype' => 'credit2','type' => 'record','period' => 1))?>">余额明细</a>
        </div>
    </div>
</div>
<script src="<?php echo JS_PATH;?>jquery-1.8.3.min.js"></script>
<script src="<?php echo JS_PATH;?>weui.js"></script>
<script type="text/javascript">
    wx.ready(function(){
        wx.hideAllNonBaseMenuItem();
        });
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=jing_cash"></script></body>
</html>