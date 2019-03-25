<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head2', TEMPLATE_INCLUDEPATH)) : (include template('head2', TEMPLATE_INCLUDEPATH));?>

<title><?php  echo $title;?></title>
<style>
    .classify_box li {
        float: left;
        width: 25%;
        text-align: center;
        color: #333;
        margin-top: 10px;
    }

    .classify_box li img {
        width: 40px;
        height: 40px;
        margin-bottom: 6px;
    }
</style>
<script>
    wx.ready(function () {

        sharedata = {

            title: "<?php  echo $config['mobile_card_sharetitle'];?>",

            desc: "<?php  echo $config['mobile_card_sharedesc'];?>",

            link: "<?php  echo $_W['siteroot'];?>app/<?php  echo str_replace('./','',$this->createMobileUrl('Carddis',array('parent'=>$openid)))?>",

            imgUrl: "<?php  echo tomedia($config['mobile_card_shareimg'])?>",

            type: '', // 分享类型,music、video或link，不填默认为link

            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空

            success: function () {

            },

            cancel: function () {

            }

        };



        wx.onMenuShareAppMessage(sharedata);

        wx.onMenuShareTimeline(sharedata);

        wx.onMenuShareQQ(sharedata);

        wx.onMenuShareWeibo(sharedata);

        wx.onMenuShareQZone(sharedata);

    });
</script>



</head>



<body>

    <div class="box">

        <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head-nav', TEMPLATE_INCLUDEPATH)) : (include template('head-nav', TEMPLATE_INCLUDEPATH));?>

        <div class="banner">

            <!-- Swiper -->

            <div class="swiper-container">

                <div class="swiper-wrapper">

                    <?php  if(is_array($advcont_list)) { foreach($advcont_list as $key => $item) { ?>

                    <div class="swiper-slide">

                        <?php  if($item['advcont_url']!='') { ?>

                        <a href="<?php  echo $item['advcont_url'];?>">

                            <img src="<?php  echo tomedia($item['advcont_thumb'])?>">

                        </a>

                        <?php  } else { ?>

                        <img src="<?php  echo tomedia($item['advcont_thumb'])?>"> <?php  } ?>

                    </div>

                    <?php  } } ?>

                </div>

                <!-- Add Pagination -->

                <div class="swiper-pagination"></div>

                <!-- Add Arrows -->

                <!--<div class="swiper-button-next"></div>

            <div class="swiper-button-prev"></div>-->

            </div>



            <!-- Swiper JS -->

            <script src="<?php echo RES;?>public/discount/js/swiper.min.js"></script>



            <!-- Initialize Swiper -->

            <script>
                var swiper = new Swiper('.swiper-container', {

                    pagination: '.swiper-pagination',

                    nextButton: '.swiper-button-next',

                    prevButton: '.swiper-button-prev',

                    paginationClickable: true,

                    spaceBetween: 30,

                    centeredSlides: true,

                    autoplay: 2500,

                    autoplayDisableOnInteraction: false

                });
            </script>

        </div>

        <?php  if(is_array($types)) { foreach($types as $key => $item) { ?>
        <div class="classify_box">
            <a href="<?php  echo $this->createMobileUrl('CardType', array('op' => 'display', 'type_id' => $item['storetype_id']))?>">
                <li>
                    <img src="<?php  echo tomedia($item['storetype_pic'])?>">
                    <p><?php  echo $item['storetype_name'];?></p>
                </li>
            </a>
        </div>
        <?php  } } ?>
        <div class="cont-box">

            <ul class="cont">

                <?php  if(is_array($store_array)) { foreach($store_array as $key1 => $item1) { ?>

                <li id="cont1">

                    <div class="cont-t">

                        <div class="cont-image01">

                            <a href="<?php  echo $this->createMobileUrl('storecon',array('store_id'=>$item1['store_id']));?>">

                                <img src="<?php  echo tomedia($item1['store_thumb'])?>">

                            </a>

                        </div>

                        <div class="cont-image">

                            <img class="cont-image02" id="img_2_<?php  echo $item1['store_id'];?>" onClick="javascript:_show(this,<?php  echo $item1['store_id'];?>,2)" src="<?php echo RES;?>public/discount/images/xin03.png"
                                style="display:<?php  if($item1['collect_gzzt']==1) { ?> none<?php  } else { ?>block<?php  } ?>;">
                            <img class="cont-image03" id="img_3_<?php  echo $item1['store_id'];?>" onClick="javascript:_show(this,<?php  echo $item1['store_id'];?>,3)" src="<?php echo RES;?>public/discount/images/xin02.png"
                                style="display:<?php  if($item1['collect_gzzt']==1) { ?>block<?php  } else { ?>none<?php  } ?>;">
                        </div>
                    </div>
                    <div class="cont-c">
                        <a href="<?php  echo $this->createMobileUrl('storecon',array('store_id'=>$item1['store_id']));?>" class="cont-text01"><?php  echo $item1['store_title'];?></a>
                    </div>
                    <ul class="cont-b" id="collectid<?php  echo $item1['store_id'];?>">
                        <?php  if(is_array($item1['collect_list'])) { foreach($item1['collect_list'] as $key2 => $item2) { ?>
                        <li id="avatar<?php  echo $item1['store_id'];?><?php  echo $item2['collect_id'];?>">
                            <a href="#">
                                <img src="<?php  if($item2['collect_avatar']) { ?><?php  echo $item2['collect_avatar'];?><?php  } else { ?><?php echo RES;?>images/noavatar.gif<?php  } ?>" class="img-circle">
                            </a>
                        </li>
                        <?php  } } ?>
                        <a href="<?php  echo $this->createMobileUrl('storecon',array('store_id'=>$item1['store_id']));?>" class="cont-text02">等
                            <span id="count<?php  echo $item1['store_id'];?>"><?php  echo $item1['store_amountcollect'];?></span>人想去</a>

                    </ul>

                </li>

                <?php  } } ?>



            </ul>

            <script>
                function _show(t, storeid, i2)

                {

                    t.style.display = "none";



                    if (i2 == 2)

                    {

                        addordelcollect(storeid, 1);

                        dg("img_2_" + storeid).style.display = "none";

                        dg("img_3_" + storeid).style.display = "block";

                    } else

                    {

                        addordelcollect(storeid, 2);

                        dg("img_2_" + storeid).style.display = "block";

                        dg("img_3_" + storeid).style.display = "none";

                    }

                }

                function dg(id)

                {

                    return document.getElementById(id);

                }



                function addordelcollect(storeid, state)

                {

                    $.ajax({

                        type: "POST",

                        url: "<?php  echo $this->createMobileUrl('ajaxcollect');?>",

                        data: {
                            store_id: storeid,
                            collect_state: state
                        },

                        dataType: "json",

                        async: false,

                        success: function (data) {

                            if (data.result == 'success')

                            {

                                if (data.type == 1)

                                {

                                    var sss = '';

                                    sss = "<li id='avatar" + storeid + data.content.id + "'><a href='#'/>";

                                    sss += "<img src='" + data.content.avatar + "' class='img-circle'>";

                                    sss += '</li>';

                                    $("#collectid" + storeid).prepend(sss);



                                } else {

                                    $("#avatar" + storeid + data.content.id).remove();

                                }

                                $('#count' + storeid).text(data.count);

                            } else {

                                alert(data.rs);

                            }

                        }

                    });

                }
            </script>



        </div>

        <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('foot-nav', TEMPLATE_INCLUDEPATH)) : (include template('foot-nav', TEMPLATE_INCLUDEPATH));?>