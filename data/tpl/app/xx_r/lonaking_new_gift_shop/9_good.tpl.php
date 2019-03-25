<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<?php  $good = $html['good'];?>
<html data-location="<?php  echo $good['radius'];?>" data-buy-tip="<?php  echo $good['buy_tip'];?>" data-good-buy-type="<?php  echo $good['buy_type'];?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no"/>
    <title><?php  echo $html['good']['title'];?></title>
    <meta id="share-logo" name="share_logo" content="<?php  echo $share['share_logo'];?>" />
    <meta id="share-url-id" name="share_url" content="<?php  echo $share['share_url'];?>" />
    <meta id="share-title-id" name="share_title" content="<?php  echo $html['good']['title'];?>" />
    <meta id="share-content-id" name="share_content" content="<?php  echo $share['share_description'];?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/normalize.min.css">
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/modal.min.css">
    <link rel="stylesheet" href="<?php  echo $resource['prefix'];?>assets/css/detail.css">
    <style>
        .powered-logo{width:27px;}
    </style>
    <style>
        .theme-color{color: <?php  echo $html['config']['theme_color'];?>;}
        .theme-bgcolor{background-color: <?php  echo $html['config']['theme_color'];?>;}
        .theme-bordercolor{border-color: <?php  echo $html['config']['theme_color'];?>;}
        /* radio */
        .radio-group.cur{border-color:<?php  echo $html['config']['theme_color'];?>; }
        .radio-group .cur-arrow{border-color: <?php  echo $html['config']['theme_color'];?> transparent transparent <?php  echo $html['config']['theme_color'];?>;}
        .description a {color: <?php  echo $html['config']['theme_color'];?>;}
        .pricing-text{
            font-size: 12px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php  echo $resource['prefix'];?>assets/css/ordinaryRecommend.css">
</head>
<body>
<div id="db-content">
    <div class="db-banner-style">
        <div class="db-banner-swipe" id="swipe">
            <div>
                <?php  if(is_array(unserialize($html['good']['detail_image']))) { foreach(unserialize($html['good']['detail_image']) as $image) { ?>
                <a><img src="<?php  echo tomedia($image);?>"/></a>
                <?php  } } ?>
            </div>
        </div>
        <div class="db-banner-position">
            <strong>1</strong><span>/<?php  echo $detail_image_num;?></span>
        </div>
    </div>
    <header>
        <div class="item-info">
            <div class="item-title">
                <h3><?php  echo $good['title'];?></h3>
                <?php  if($good['buy_type'] == 2) { ?>
                <span><?php  if($good['num']>10) { ?>热卖中<?php  } else if($good['num'] == 0) { ?>已结束<?php  } else { ?>剩余：<?php  echo $good['num'];?><?php  } ?></span>
                <?php  } else { ?>
                <span><?php  if($good['num']>10) { ?>抢兑中<?php  } else if($good['num'] == 0) { ?>已结束<?php  } else { ?>剩余：<?php  echo $good['num'];?><?php  } ?></span>
                <?php  } ?>

            </div>
            <div class="price">
                <?php  if($good['buy_type'] == 1) { ?>
                <span class="num theme-color"><?php  echo $html['good']['score'];?></span><span class="unit theme-color"><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?></span>
                <?php  } else if($good['buy_type'] == 2) { ?>
                <span class="num theme-color"><?php  echo $good['money'];?></span><span class="unit theme-color">元</span>
                <?php  } else if($good['buy_type'] == 3) { ?>
                <span class="num theme-color"><?php  echo $html['good']['score'];?></span><span class="unit theme-color"><?php  if($this->module['config']['score_name']) { ?><?php  echo $this->module['config']['score_name']?><?php  } else { ?>积分<?php  } ?></span>
                <span class="plus">＋</span>
                <span class="num theme-color"><?php  echo $good['money'];?></span><span class="unit theme-color">元</span>
                <?php  } ?>
                <span class="rmb"><?php  if($html['good']['market_price'] > 0) { ?>￥<?php  echo $html['good']['market_price'];?><?php  } ?></span>
                <?php  if($html['good']['type'] == 3) { ?>
                <span class="express">运费:
                    <?php  if($html['good']['trans_fee'] > 0) { ?>
                        <?php  echo $html['good']['trans_fee'];?>
                    <?php  } else { ?>
                        包邮
                    <?php  } ?>
                </span>
                <?php  } ?>
            </div>
        </div>

        <?php  if($html['good']['type'] == 4 || $html['good']['type']==2) { ?>
        <?php  if($html['good']['validate_start_date'] && $html['good']['validate_end_date']) { ?>
        <div class="validDate">
            <i class="arrow"></i><strong>有效期：</strong>
            <?php  if($html['good']['valid_date_type'] ==1) { ?>
            <span><?php  echo $html['good']['validate_start_date'];?>至<?php  echo $html['good']['validate_end_date'];?></span>
            <?php  } ?>
            <?php  if($html['good']['valid_date_type'] ==2) { ?>
            <span>下单后<?php  echo $html['good']['valid_date_after_days'];?>天内有效</span>
            <?php  } ?>
        </div>
        <?php  } ?>
        <?php  } ?>
        <?php  if($html['good']['type'] == 3) { ?>
        <?php  if($html['address']) { ?>
            <?php  $address = $html['address'];?>
        <a class="address" href="<?php  echo $html['addressSettingPage'];?>">
            <div>
                <p>
                    <i class="arrow"></i>
                    <strong>配送至：</strong>
                    <span><?php  echo $address['name'];?>&nbsp;<?php  echo $address['mobile']?></span>
                </p>
            <span>
                <?php  echo $address['province'];?>
                <?php  echo $address['city'];?>
                <?php  echo $address['area'];?>
                <?php  echo $address['address'];?>
            </span>
            </div>
        </a>
            <?php  } else { ?>
        <a class="no-address" href="<?php  echo $html['addressSettingPage'];?>">
            <div>
                <p>
                    <i class="arrow"></i><strong>配送至：</strong><span>您还未填写收货信息，马上去填写。</span>
                </p>
            </div>
        </a>
        <?php  } ?>
        <?php  } ?>
    </header>
    <section>

        <p class="title">
            <i class="arrow"></i><span>详情说明：</span>
        </p>
        <div class="description">
            <?php  echo htmlspecialchars_decode($html['good']['description'])?>

        </div>
    </section>
    <div class="statement">
        <p>
            <i class="arrow"></i><span>重要声明：</span>
        </p>
        <?php  echo htmlspecialchars_decode($html['config']['important_notice'])?>
    </div>
    <div class="recommandLocation" style='margin-top:10px; display:none'>
        <em></em><i></i><span>为您推荐</span><em></em>
    </div>
    <div class="recommandLocationItems clearfix" style=''>
    </div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('copyright', TEMPLATE_INCLUDEPATH)) : (include template('copyright', TEMPLATE_INCLUDEPATH));?>
</div>
<footer>
    <div class="timedown">
        <span class="dateRange"></span>
        <i></i>
        <strong>
            <span class="hourTens"></span>
            <span class="hourOnes"></span>
            <span>时</span>
            <span class="minuteTens"></span>
            <span class="minuteOnes"></span>
            <span>分</span><span class="secondTens"></span>
            <span class="secondOnes"></span>
            <span>秒</span>
        </strong>
    </div>
    <?php  if($good['buy_type'] == 2) { ?>
    <?php  if($good['num'] <= 0) { ?>
    <button type="button" class="submit theme-bgcolor" disabled>已售完</button>
    <?php  } else { ?>
    <button type="button" class="submit theme-bgcolor">
        马上<?php  if($good['raffle'] == 0) { ?>购买<?php  } else { ?>抽奖<?php  } ?>
        <span class="pricing-text"><?php  echo $html['pricing_text'];?></span>
    </button>
    <?php  } ?>
    <?php  } else { ?>
    <?php  if($good['num'] <= 0) { ?>
    <button type="button" class="submit theme-bgcolor" disabled>已兑完</button>
    <?php  } else { ?>
    <button type="button" class="submit theme-bgcolor">
        马上<?php  if($good['raffle'] == 0) { ?>兑换<?php  } else { ?>抽奖<?php  } ?>
        <span class="pricing-text">
            <?php  echo $html['pricing_text'];?>
        </span>
    </button>
    <?php  } ?>
    <?php  } ?>

</footer>
<div class="captcha">
    <div class="captcha-dialog">
    </div>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=lonaking_new_gift_shop"></script></body>
<script src="<?php  echo $resource['prefix'];?>assets/js/zepto.min.js"></script>
<script src="<?php  echo $resource['prefix'];?>assets/js/swipe.min.js"></script>
<script src="<?php  echo $resource['prefix'];?>assets/js/modal.min.js"></script>
<script src="<?php  echo $resource['prefix'];?>assets/js/fastclick.js"></script>

<script type="text/javascript" src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false,
        appId: '<?php  echo $resource['js']['appId'];?>',  //微信的appid需要在公众平台生成
        timestamp: '<?php  echo $resource['js']['timestamp'];?>', //这是由php部分生成的
        nonceStr: '<?php  echo $resource['js']['nonceStr'];?>', //这是由php部分生成的
        signature: '<?php  echo $resource['js']['signature'];?>', //这是由php部分生成的
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'scanQRCode',
            'getLocation'
        ]
    });

</script>
<script src="<?php  echo $resource['prefix'];?>share-assets/wxshare.js"></script>
<script>
    var GOOD = <?php  echo json_encode($good)?>;
    var ADDRESS = <?php  echo json_encode($html['address'])?>;
    var INVITE_ID = "<?php  echo $_GPC['invite_id'];?>";
    var lng = 0;
    var lat = 0;
    //fastclick
    Origami.fastclick(document.body);
    //微信启动

    wx.ready(function () {
    		var location_radius = parseInt(<?php  echo $good['radius'];?>);
    		if(location_radius > 0){
    			wx.getLocation({
    	            type: 'wgs84',
    	            success: function (res) {
    	                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
    	                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
    	                lng = longitude;
    	                lat = latitude;
    	            },
    	            cancel: function (res) {
    	                alert("系统无法获取您的位置，本次交易无法继续");
    	                return false;
    	            },
    	            fail: function (res) {
    	                alert("系统无法获取您的位置，本次交易无法继续");
    	                return false;
    	            }
    	        });
    		}

        $(function () {

            (function ($) {
                var swipelength = $('.db-banner-swipe').children('div').children('a').length;
                $('.db-banner-position span').html('/' + swipelength);
                if (swipelength > 1) {
                    window.bannerSlider = Swipe(document.getElementById('swipe'), {
                        auto: 3000,
                        startSlide: 0,
                        continuous: true,
                        disableScroll: false,
                        callback: function (index) {
                            if ((index + 1) > swipelength) {
                                index = index % 2;
                            }
                            $('.db-banner-position strong').html(index + 1)
                        }
                    });
                    $('.db-banner-position').css("visibility", "visible")
                } else {
                    $('.db-banner-swipe').css("visibility", "visible")
                }
            })(Zepto)

            var day_status = "2";
            if (day_status == 1
                    || day_status == 2
                    || day_status == 3
                    || day_status == 4
                    || day_status == 5
                    || day_status == 6
                    || day_status == 10
            ) {
                $('.timedown').hide();
            }
            $('#db-content').css('padding-bottom', $('footer').height());
            var addressUrl = "<?php  echo $html['addressSettingPage'];?>";
            var addre = true;
            $('.submit').on('click', function () {
                var title = "确定使用&nbsp;<?php  echo $html['pricing_price_text'];?>&nbsp;";

                title = title + "购买(兑换)?";
                if (true) {
                    if (addre) {
                        $.modal({
                            type: 'confirm',
                            title: title,
                            section: '<p>' + $("html").data("buy-tip") + '</p>',
                            callback: {
                                save: function () {
                                    window.loading = $.modal({
                                        type: 'loading',
                                        title: '正在处理，请稍后···'
                                    });

                                    var orderAPIData = {
                                        gift_id: GOOD.id,
                                        invite_id : INVITE_ID,
                                    };

                                    if (ADDRESS) {
                                        orderAPIData.address = ADDRESS.id;
                                    }

                                    if (parseInt(GOOD.radius) > 0) {

                                        if(lng == 0 || lat == 0){
                                            $.modal({
                                                type: 'confirm',
                                                title: '系统无法获取您的位置，本次兑换无法继续',
                                                callback: {

                                                }
                                            });
                                        }else{
                                            orderAPIData.lng = lng;
                                            orderAPIData.lat = lat;
                                            order(orderAPIData);
                                        }
                                    }else{
                                        return order(orderAPIData);
                                    }

                                }
                            }
                        })
                    }
                    else {
                        //没有地址，跳往填写地址页面
                        window.location.href = addressUrl;
                    }
                } else {
                    //非限时直接跳往地址页面
                    window.location.href = addressUrl;
                }
            });
            function order(orderAPIData){
                $.ajax({
                    url: "<?php  echo $resource['urls']['OrderApi'];?>&invite_id=<?php  echo $_GPC['invite_id'];?>",
                    type: 'POST',
                    dataType: 'json',
                    timeout: 60000,
                    data: orderAPIData,
                    success: function (result) {
                        if (result.status == 200) {
                            window.loading.close();
                            $.modal({
                                type: 'confirm',
                                title: '交易成功',
                                section: result.message,
                                callback: {
                                    save: function () {
                                        if (result.data.redirect) {
                                            window.location.href = result.data.redirect;
                                        } else {

                                        }
                                    }
                                }
                            });

                        } else {
                            window.loading.close();
                            $.modal({
                                type: 'confirm',
                                title: '交易失败',
                                section: result.message,
                                callback: {
                                    save: function () {
                                        if(result.status == 48066){
                                            window.location.href = "<?php  echo $html['addressSettingPage'];?>";
                                        }else{
                                            window.location.reload();
                                        }

                                    }
                                }
                            });
                        }
                    },
                    error: function (e) {
                        window.loading.close();
                        $.modal({
                            type: 'confirm',
                            title: '请求超时',
                            callback: {
                                save: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });
            }
        });
        (function () {
            $(function () {
                if (navigator.userAgent.match(/(iphone|ipad|Android|ios)/ig)) {
                    //app状态监控，用户10秒不触碰屏幕，即有可能离开了app，停止banner
                    var inApp = true;

                    function inAppTimerFn() {
                        window.inAppTimer = setTimeout(function () {
                            inApp = false;
                            if (window.bannerSlider) {
                                bannerSlider.stop();
                            }
                        }, 12000);
                    }

                    inAppTimerFn();
                    document.addEventListener('touchend', function (e) {
                        if (window.inAppTimer) clearTimeout(window.inAppTimer);
                        if (!inApp) {
                            inApp = true;
                            if (window.bannerSlider) {
                                bannerSlider.begin();
                            }
                        }
                        inAppTimerFn();
                    }, false)
                }
            })
        })()
    });


    function judgeCookie(offset) {
        var endstr = document.cookie.indexOf(";", offset);
        if (endstr == -1)
            endstr = document.cookie.length;
        return unescape(document.cookie.substring(offset, endstr));
    }
    function GetCookie(name) {
        var arg = name + "=";
        var alen = arg.length;
        var clen = document.cookie.length;
        var i = 0;
        while (i < clen) {
            var j = i + alen;
            if (document.cookie.substring(i, j) == arg)
                return judgeCookie(j);
            i = document.cookie.indexOf(" ", i) + 1;
            if (i == 0)
                break;
        }
        return null;
    }
    function SetCookie(name, value) {
        var argv = SetCookie.arguments;
        var argc = SetCookie.arguments.length;
        var expires = (2 < argc) ? argv[2] : null;
        var path = (3 < argc) ? argv[3] : null;
        var domain = (4 < argc) ? argv[4] : null;
        var secure = (5 < argc) ? argv[5] : false;
        document.cookie = name
                + "="
                + escape(value)
                + ((expires == null) ? "" : ("; expires=" + expires
                        .toGMTString()))
                + ((path == null) ? "" : ("; path=" + path))
                + ((domain == null) ? "" : ("; domain=" + domain))
                + ((secure == true) ? "; secure" : "");
    }
    var expdate = new Date();
    var visits;
    expdate.setTime(expdate.getTime() + (24 * 60 * 60 * 1000)); //设置cookie时间为一天
    if (!(visits = GetCookie("visits"))) {
        visits = 0;
    }
    var oldjessionid = GetCookie("calculate");
    if (!oldjessionid) {
        oldjessionid = "111";
    }
    var newjessionid = GetCookie("index");
    if (oldjessionid != newjessionid) {
        visits++;
        SetCookie("calculate", newjessionid, expdate, "/", null, false);
        SetCookie("visits", visits, expdate, "/", null, false);
    }

</script>
<script type="text/javascript">
    Zepto(function($) {
        /**
         * 链接转换
         */
        var isOpen = false
        var links = $('[data-tag="is-link"]')

        links.each(function() {
            if (isOpen) {
                var text = $(this).text()
                $(this).replaceWith('<span>' + text + '</span>')
            } else {
                $(this).removeAttr('data-tag')
            }
        })
    })
</script>

</html>