<?php defined('IN_IA') or exit('Access Denied');?>
<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no" >
<meta http-equiv="Cache-Control" content="no-siteapp, no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="imagetoolbar" content="false"/>
<meta name="applicable-device" content="mobile"/>
<meta name="force-rendering" content="webkit"/>

<meta name="screen-orientation" content="landscape">
<meta name="full-screen" content="yes">
<meta name="x5-orientation" content="landscape">
<meta name="x5-fullscreen" content="true" />
<meta name="x5-page-mode" content="app" />

<title><?php  echo $indexInfo['share_title']?></title>
<meta name="author" content="<?php  echo $indexInfo['share_brief']?>" />
<link rel="shortcut icon" href="../addons/wxz_piclive/icon.jpg"/>
<link rel="icon" href="../addons/wxz_piclive/icon.jpg" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="../addons/wxz_piclive/template/mobile/css/swiper.css" />
<link rel="stylesheet" type="text/css" href="../addons/wxz_piclive/template/mobile/css/style.css" />
<script src="//res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
</head>
<style>
    .img{width:100%;}
    .listBox3{width:86%;margin:0 auto;height:200px;}
    .listBox3 .left{width:49%;float:left;height:100%;}
    .listBox3 .right{width:49%;float:right;height:100%;background:#e2e5ec;}
    .mid-in {
        position: static;
        top: 50%;
    }
    .listBoxtest p {
        font-size: 0.23rem;
        color: #839dbe;
        font-weight: bold;
    }
    .mid{position: relative;display: table-cell;vertical-align: middle;text-align: center;}
    .mid-in{position: static;*position: absolute;top: 50%;}
    .mid-in img{position: static;*position: relative;top: -50%;left: -50%;-ms-interpolation-mode: bicubic;width: 100%;}

    .mid-in p{position: static;*position: relative;top: -50%;-ms-interpolation-mode: bicubic;width: 100%;text-align: center; margin: 0 auto;}
    .listBoxtest p a{width: 90%; display: block; text-align: center; margin: 0 auto;font-size:16px;}
    .listBoxtest p a,.listBoxtest li p a:hover{color: #839dbe;}
    .listBoxtest p a span.f1{color: #132f52;}
    .listBoxtest p a{width: 90%; display: block; text-align: center; margin: 0 auto;font-size:16px;}
    .listBoxtest p a,.listBoxtest li p a:hover{color: #839dbe;}
    .f1{font-size:14px;}
</style>
<script>
    wx.config({
        debug: false,
        appId: "<?php  echo $_W['account']['jssdkconfig']['appId'];?>",
        timestamp: "<?php  echo $_W['account']['jssdkconfig']['timestamp'];?>",
        nonceStr: "<?php  echo $_W['account']['jssdkconfig']['nonceStr'];?>",
        signature: "<?php  echo $_W['account']['jssdkconfig']['signature'];?>",
        jsApiList: ["onMenuShareAppMessage", "onMenuShareTimeline", "onMenuShareQQ"]
    });
    wx.ready(function () {
        sharedata = {
            title: "<?php  echo $indexInfo['share_title']?>",
            desc: "<?php  echo $indexInfo['share_brief']?>",
            link:"<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('main',array('i' => $_W['weid'], 'lid'=>$lid)))?>",
            imgUrl: "<?php  echo tomedia($indexInfo['share_img'])?>",
            success: function () {
                
            },
            cancel: function () {
                //alert('分享取消');
            }
        };
        wx.onMenuShareTimeline(sharedata);
        wx.onMenuShareAppMessage(sharedata);
	wx.onMenuShareQQ(sharedata);
    });
</script>
<body class="bgcolor">
<div id="app" style="width:100%;min-height:100%;">
    <div class="topbars"><img src="<?php  echo $indexInfo['banner'];?>" class="img" style="width:100%;"></div>
    <div class="toptht"><img src="../addons/wxz_piclive/template/mobile/images/top_tht.png" class="img"></div>    
    <div class="clear"></div>
    <div class="listBoxtest listBox3 clearfix">
        <div class="left">
            <div style="width:100%;height:46%;background:#f2f2f2;">
                <div class="mid-in"><p style="position:relative;top:30px;line-height:20px;"><a href="<?php  echo $indexInfo['link_url1'];?>"><?php  echo $indexInfo['block_t1'];?><br><span class="f1"><?php  echo $indexInfo['subtitle1'];?></span></a></p></div>
            </div>
            <div style="width:100%;height:47%;background:#f7f8f8;margin-top:5%;">
                <div class="mid-in">
                    <p style="position:relative;top:30px;line-height:20px;"><a href="<?php  echo $indexInfo['link_url2'];?>"><?php  echo $indexInfo['block_t2'];?><br/><span class='f1'><?php  echo $indexInfo['subtitle2'];?></span></a></p>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="mid-in">
                    <p style="position:relative;margin-top:49%;line-height:20px;"><a href="<?php  echo $indexInfo['link_url3'];?>"><?php  echo $indexInfo['block_t3'];?><br/><span class='f1'><?php  echo $indexInfo['subtitle3'];?></span></a></p>
                </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="topfoot clearfix" style="margin-top:20px;"><img src="../addons/wxz_piclive/template/mobile/images/foot_text1.gif" class="img"></div>
    <div class="clear"></div>
</div>


<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=wxz_piclive"></script></body>
</html>