<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta content="telephone=no" name="format-detection"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title><?php  echo $html['config']['title'];?></title>
    <meta id="share-logo" name="share_logo" content="<?php  echo $share['share_logo'];?>" />
    <meta id="share-url-id" name="share_url" content="<?php  echo $share['share_url'];?>" />
    <meta id="share-title-id" name="share_title" content="<?php  echo $share['share_title'];?>" />
    <meta id="share-content-id" name="share_content" content="<?php  echo $share['share_description'];?>" />
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/normalize.min.css">
    <style>
        .theme-color{color: <?php  echo $html['config']['theme_color'];?>;}
        .theme-bgcolor{background-color: <?php  echo $html['config']['theme_color'];?>;}
        .theme-bordercolor{border-color: <?php  echo $html['config']['theme_color'];?>;}
        /* radio */
        .radio-group.cur{border-color:<?php  echo $html['config']['theme_color'];?>; }
        .radio-group .cur-arrow{border-color: <?php  echo $html['config']['theme_color'];?> transparent transparent <?php  echo $html['config']['theme_color'];?>;}
        .description a {color: <?php  echo $html['config']['theme_color'];?>;}
        .items-box .item-group > a > img{height:110px;}
    </style>
    <script src="<?php  echo $resource['prefix'];?>assets/js/zepto.min.js"></script>
    <script src="<?php  echo $resource['prefix'];?>assets/js/swipe.min.js"></script>
</head>
<body>
<div id="db-content">
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/theme/template-v12.14.css">
    <style>
        .banner-position li.cur{background-color: <?php  echo $html['config']['theme_color'];?>;}/*主题色*/
        .icon-position li.cur{background-color: <?php  echo $html['config']['theme_color'];?>;}/*主题色*/
    </style>
    <div class="top">
        <div class="credits">
            <i></i>
            <a href="<?php  echo $html['config']['score_click_redirect'];?>">
                <span class="theme-color" id="db-credits-num">
                    <?php  echo $html['user']['fan_info']['score'];?>
                </span>
                <span class="unit"><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?></span>
            </a>
        </div>
        <a class="records" href="<?php  echo $resource['urls']['RecordList'];?>"><i class="records-arrow"></i><span>兑换记录</span><i id="db-new-record"></i><i class="records-right-arrow"></i></a>
    </div>
    <div class="banner">
        <div class="banner-swipe">
            <div style="">
                <?php  if(is_array($html['ads'])) { foreach($html['ads'] as $ad) { ?>
                <a href="<?php  echo $ad['url'];?>"><img alt="<?php  echo $ad['title'];?>" src="<?php  echo tomedia($ad['image']);?>" height="170px"/></a>
                <?php  } } ?>
            </div>
        </div>
        <div class="banner-position">
        </div>
    </div>
    <div class="icon-slider">
        <div class="icon-swipe">
            <?php  if(is_array($html['menus'])) { foreach($html['menus'] as $menu) { ?>
            <a href="<?php  echo $menu['url'];?>"><li><img src="<?php  echo tomedia($menu['icon'])?>"><p><?php  echo $menu['name'];?></p></li></a>
            <?php  } } ?>
        </div>
        <div class="icon-position"></div>
    </div>

    <div class="items-box" >
        <?php  if(is_array($html['gifts'])) { foreach($html['gifts'] as $gift) { ?>
        <div class="item-group">
            <a class="new" href="<?php  echo $this->createMobileUrl('Good',array('id'=>$gift['id'],'invite_id'=>$_GPC['invite_id']))?>">
                <img src="<?php  echo tomedia($gift['thumbnail']);?>" data-original="<?php  echo tomedia($gift['thumbnail']);?>">
                <h3><?php  echo $gift['title'];?></h3>
                <p class="theme-color">
                <?php  if($gift['buy_type'] == 1) { ?>
                <?php  echo $gift['score'];?><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?>
                <?php  } else if($gift['buy_type'] == 2) { ?>
                <?php  echo $gift['money'];?>元
                <?php  } else if($gift['buy_type'] == 3) { ?>
                <?php  echo $gift['score'];?><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?> + <?php  echo $gift['money'];?>元
                <?php  } ?>
                </p>
                <div class="tag" style="border-bottom-color:<?php  echo $gift['tag_color'];?>;"><span><?php  echo $gift['tag'];?></span></div>
            </a>
        </div>
        <?php  } } ?>
    </div>
    <script src="<?php  echo $resource['prefix'];?>assets/js/zepto.lazyload.min.js"></script>
    <script>
        $(function(){
            //滚动banner
            (function(){
                var $swipe=$('.banner-swipe'),
                        $swipeWrap=$swipe.children('div'),
                        $swipePosition=$('.banner-position'),
                        bannerLength=$swipeWrap.children('a').length;
                if(bannerLength>1){
                    var swipePosition='';
                    $swipeWrap.children('a').wrap('<div></div>');
                    for(i=0;i<bannerLength;i++){
                        if(i==0){
                            swipePosition+='<li class="cur"></li>';
                        }else{
                            swipePosition+='<li></li>';
                        }
                    }
                    $swipePosition.append(swipePosition);
                    var bullets = $swipePosition.children('li');
                    window.bannerSlider =  Swipe(document.getElementsByClassName('banner-swipe').item(0), {
                        auto: 3000,
                        startSlide: 0,
                        continuous: true,
                        disableScroll:false,
                        callback: function(index) {
                            if((index+1)>bullets.length){
                                index=index%2;
                            }
                            bullets.attr('class','').eq(index).attr('class','cur');
                        }
                    });
                }
                else{
                    $swipe.css('visibility','visible')
                }
            })();
            //滚动icon

            (function(){
                var $swipe=$('.icon-swipe'),
                        iconLength=$swipe.children('a').length;
                if(iconLength>4){
                    var newSwipe='',swipeLength=iconLength%4==0?(iconLength/4):(parseInt(iconLength/4)+1),swipePosition='';
                    $swipe.children('a').each(function(index, element) {
                        var curHtml=$(this).prop('outerHTML');
                        if(index==0){
                            curHtml='<div>'+curHtml;
                        }
                        else if((index+1)%4==0&&(index+1)!=iconLength){
                            curHtml+='</div><div>';
                        }
                        else if((index+1)==iconLength){
                            curHtml+='</div>';
                        }
                        newSwipe+=curHtml;
                    });
                    $swipe.html('<div>'+newSwipe+'</div>');
                    for(i=0;i<swipeLength;i++){
                        if(i==0){
                            swipePosition+='<li class="cur"></li>';
                        }else{
                            swipePosition+='<li></li>';
                        }
                    }
                    $('.icon-position').html(swipePosition);
                    var bullets = $('.icon-position').children('li');
                    var iconSlider = Swipe(document.getElementsByClassName('icon-swipe').item(0), {
                                auto: false,
                                startSlide: 0,
                                continuous: true,
                                disableScroll:false,
                                callback: function(index) {
                                    var i = bullets.length;
                                    while (i--) {
                                        bullets[i].className = ' ';
                                    }
                                    if((index+1)>bullets.length){
                                        index=index%2;
                                    }
                                    bullets[index].className = 'cur';
                                }
                            }
                    );
                }
                else{
                    var liWidth=(100/length)+'%';
                    $swipe.children('div').children('a').children('li').css('width',liWidth);
                    $('.icon-slider,.icon-swipe').css('visibility','visible');
                }
            })();

            //懒加载
            $(".items-box img,.items-rect img").lazyload({ threshold : 500 });
        })
    </script>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('copyright', TEMPLATE_INCLUDEPATH)) : (include template('copyright', TEMPLATE_INCLUDEPATH));?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('tabmenus', TEMPLATE_INCLUDEPATH)) : (include template('tabmenus', TEMPLATE_INCLUDEPATH));?>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=lonaking_new_gift_shop"></script></body>
<script src="<?php  echo $resource['prefix'];?>assets/js/fastclick.js"></script>
<script src="<?php  echo $resource['prefix'];?>assets/js/cookie.min.js"></script>


<script>
    (function(){
        $(function(){
            if(navigator.userAgent.match(/(iphone|ipad|Android|ios)/ig)){
                //app状态监控，用户10秒不触碰屏幕，即有可能离开了app，停止banner
                var inApp=true;
                function inAppTimerFn(){
                    window.inAppTimer=setTimeout(function(){
                        inApp=false;
                        if(window.bannerSlider){
                            bannerSlider.stop();
                        }
                    }, 12000);
                }
                inAppTimerFn();
                document.addEventListener('touchend',function(e){
                    if(window.inAppTimer) clearTimeout(window.inAppTimer);
                    if(!inApp){
                        inApp=true;
                        if(window.bannerSlider){
                            bannerSlider.begin();
                        }
                    }
                    inAppTimerFn();
                },false)
            }
        })
    })()

    (function(){
        Origami.fastclick(document.body);
    })()
</script>
<script src="<?php  echo $resource['prefix'];?>assets/js/crpto.min.js" type="text/javascript"></script>
<script type="text/javascript" src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false,
        appId: '<?php  echo $html['jsconfig']['appId'];?>',  //微信的appid需要在公众平台生成
        timestamp: '<?php  echo $html['jsconfig']['timestamp'];?>', //这是由php部分生成的
        nonceStr: '<?php  echo $html['jsconfig']['nonceStr'];?>', //这是由php部分生成的
        signature: '<?php  echo $html['jsconfig']['signature'];?>', //这是由php部分生成的
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
        ]
    });
</script>
<script src="<?php  echo $resource['prefix'];?>/share-assets/wxshare.js"></script>
</html>