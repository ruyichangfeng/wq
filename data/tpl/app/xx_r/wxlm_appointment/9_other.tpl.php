<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php  echo $this->config['system_name']?></title>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .clear{
            clear: both;
        }
        ul,li{
            list-style: none;
        }

        a,a:visited,a:hover,a:focus{
            text-decoration: none;
        }
        a { text-decoration:none;
            out-line: none;
            color:#333333; }
        /*首页css*/
        #banner img{
            width: 100%;
        }
        .swiper-container2 .nav-tabs{
            padding-bottom: -1px !important;
            background-color: black;
            height: 40px;
            border: none;
        }
        .lw-swiper{
            text-align: center;
            height: 40px;
            overflow: hidden;
        }
        .lw-swiper a{
            color: white;
            line-height: 40px;
            font-size: 12px;
        }
        .swiper-container2 .nav-tabs .active{
            /*border-bottom: 1px solid red;*/
        }
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
            border: none;
            border-bottom: 1px solid white;
            background-color: black;
            color: white;
        }
        #myTabContent .tab-pane li{
            position: relative;
            margin-bottom: 10px;
        }
        #myTabContent .tab-pane li img{
            width: 100%;
        }
        .indexlist-model{
            width: 100%;
            height: 40px;
            position: absolute;
            bottom: 20px;
        }
        .indexlist-model-left{
            width: 80%;
            height: 50px;
            color: black;
            background: rgba(255, 255, 255, 0.6);
            float: left;
            line-height: 51px;
            font-weight: 600;
            padding-left: 20px;
            overflow: hidden;
        }
        .indexlist-model-right{
            width: 20%;
            float: left;
            background-color: black;
            height: 50px;
            color: white;
            line-height: 50px;
            text-align: center;
        }
        #myTab .active{
            background-color: transparent;
        }
        .swiper-container2{
            width: 100%;
            overflow: hidden
        }
        .nav > li > a:hover, .nav > li > a:focus{
            background-color: transparent;
        }
        .nav-tabs > li > a:hover{
            border: none;
        }
        #myTab{
            border: none;
            height: 40px !important;
        }
        .lw-swiper{
            height: 40px !important;
        }
        .tab-content{
            margin-top: 0 !important;
        }


        .swiper-container2{
            width: 100%;
            background-color: black;
        }



    </style>
</head>
<body style="margin-bottom: 30px;">
    <div class="swiper-container" id="banner">
                <div class="swiper-wrapper">
                    <?php  if(is_array($ads)) { foreach($ads as $key => $item) { ?>
                    <div class="swiper-slide">
                    	<a href="<?php  echo $item['ad_url'];?>"><img src="<?php  echo tomedia($item['ad_pic'])?>" ></a>
                    </div>
                    <?php  } } ?>

                </div>   
                <div class="swiper-pagination">

                </div>
    </div>

        <div class="swiper-container2">
            <ul class="swiper-wrapper nav nav-tabs"  id="myTab">
                <li class="swiper-slide lw-swiper active"><a href="#slide_all" data-toggle="tab">全部</a></li>
                <?php  if(is_array($ptypes)) { foreach($ptypes as $key => $item) { ?>
                <li class="swiper-slide lw-swiper "><a href="#slide_<?php  echo $key;?>" data-toggle="tab"><?php  echo $item['ptype_title'];?></a></li>
                <?php  } } ?>

            </ul>
        </div>


<div id="myTabContent" class="tab-content" style="padding-bottom: 50px">
   <div class="tab-pane fade in active" id="slide_all">
       <?php  if(is_array($projects)) { foreach($projects as $key => $item) { ?>
        <li>
            <a href="javascript:getUrl(<?php  echo $item['project_id'];?>)">
                <img src="<?php  echo tomedia($item['project_pic'])?>" >
                <div class="indexlist-model">
                    <div class="indexlist-model-left"><?php  echo $item['project_name'];?></div>
                    <div class="indexlist-model-right">立即预约</div>
                </div>
            </a>
        </li>
       <?php  } } ?>

   </div>
    <?php  if(is_array($ptypes)) { foreach($ptypes as $key => $item) { ?>
    <div class="tab-pane fade" id="slide_<?php  echo $key;?>">
        <?php  if(is_array($projects)) { foreach($projects as $key2 => $item2) { ?>
        <?php  if($item['ptype_id'] == $item2['project_type']) { ?>
        <li>
            <a href="javascript:getUrl(<?php  echo $item2['project_id'];?>)">
                <img src="<?php  echo tomedia($item2['project_pic'])?>" >
                <div class="indexlist-model">
                    <div class="indexlist-model-left"><?php  echo $item2['project_name'];?></div>
                    <div class="indexlist-model-right">立即预约</div>
                </div>
            </a>
        </li>
        <?php  } ?>
        <?php  } } ?>

   </div>
    <?php  } } ?>

</div>
    <ul class="footer">

        <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> dq">
            <a href="<?php  echo $this->createMobileUrl('other', array())?>">
                <img src="<?php echo RES;?>mobile/images/icon001.png">
                <span>首页</span>
            </a>
        </li>

        <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?>">
            <a href="<?php  echo $this->createMobileUrl('mine', array())?>">
                <img src="<?php echo RES;?>mobile/images/icon02.png">
                <span>个人中心</span>
            </a>
        </li>
        <?php  if($this->config['show_state'] == 2) { ?>
        <li class="col-xs-4">
            <a href="<?php  echo $this->createMobileUrl('show', array())?>">
                <img src="<?php echo RES;?>mobile/images/icon03.png">
                <span>作品</span>
            </a>
        </li>
        <?php  } ?>
    </ul>
    <script type="text/javascript">
        var mySwiper = new Swiper('.swiper-container', {
				autoplay: 5000,//可选选项，自动滑动
				    // 如果需要分页器
				pagination: '.swiper-pagination',
				
				// 如果需要前进后退按钮
				nextButton: '.swiper-button-next',
				prevButton: '.swiper-button-prev',
			})
        var swiper = new Swiper('.swiper-container2', {
            slidesPerView: 4,
            paginationClickable: true,
            spaceBetween: 0,
            freeMode: true
        });
    </script>
    <script>
        var lat;
        var log;
        wx.ready(function(){
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res) {
                    lat = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    log = res.longitude; // 经度，浮点数，范围为180 ~ -180。


                },

            });
        })

        function getUrl(id) {

           if ('<?php  echo $level;?>' == 4)
           {
               wx.getLocation({
                   type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                   success: function (res) {
                       lat = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                       log = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                      
                       location.href = "<?php  echo $this->createMobileUrl('otherStore')?>" + "&project_id=" + id + "&lat=" + lat + "&log=" + log;
                   },

               });

           } else
           {
               location.href = "<?php  echo $this->createMobileUrl('otherStore')?>" + "&project_id=" + id + "&lat=" + lat + "&log=" + log;

           }


        }
    </script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>