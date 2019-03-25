<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
<title><?php  echo $this->config['system_name']?></title>
<style>
    .con01-t01{width: 100%;
    overflow: hidden;}
.con01-t01 li{text-align: center;
    margin-top:10px;}
.con01-t01 img{width: 30px;
    height:30px;
    text-align: center;}
.con01-t01-text{font-family:"Microsoft YaHei";
    font-size:14px;
    color:#838383;}
</style>
</head>

<body>
<div class="box">
    <?php  if(!empty($ads)) { ?>
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php  if(is_array($ads)) { foreach($ads as $key => $item) { ?>
                <div class="swiper-slide">
                    <a href="<?php  echo $item['ad_url'];?>" style="display: block">
                   <img src="<?php  echo tomedia($item['ad_pic'])?>">
                    </a>
                </div>

                <?php  } } ?>

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <script src="<?php echo RES;?>mobile/js/swiper.min.js"></script>
    <?php  } ?>

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
	<div class="con">
	<div class="con02">
    	<div class="con02-text01">门店列表</div>
        <ul class="con02-con" id="storelist">
            <?php  if(is_array($stores)) { foreach($stores as $key => $item) { ?>
            <a href="<?php  echo $this->createMobileUrl('info', array('store_id'=>$item['store_id']))?>">
                <li>
                    <div class="con02-image col-xs-4">

                        <img src="<?php  echo tomedia($item['store_pic'])?>">

                    </div>
                    <ul class="con02-r col-xs-7">
                        <li>
                            <div class="con02-text02"><?php  echo $item['store_name'];?></div>
                            <!--<div class="con02-text03">-->
                                <!--<div class="con02-text04">￥7元</div>-->
                                <!--<img src="<?php echo RES;?>mobileimages/con02-bg02.jpg">-->
                            <!--</div>-->
                        </li>
                        <li>
                            <div class="con02-text05"><?php  echo $item['circle_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text06"><?php  echo $item['store_tel'];?></div>
                            <?php  if(!empty($item['distance'])) { ?>
                            <div class="con02-text07">
                                <div class="con02-text08"><?php  echo $item['distance'];?>km</div>
                                <img src="<?php echo RES;?>mobile/images/location.png">
                            </div>
                            <?php  } ?>
                        </li>
                    </ul>
                </li>
            </a>
            <?php  } } ?>
            <?php  if(empty($stores)) { ?>
            <li style="padding: 10px;text-align: center">
                <img src="<?php echo RES;?>mobile/images/clear.png" style="height: 50px" alt="">
                <p>未找到相关门店</p>
            </li>
            <?php  } ?>
        </ul>
    </div>
    </div>
    <ul class="footer">
    	<li class="footer01 dq">
        	<a href="<?php  echo $this->createMobileUrl('index', array())?>">
        		<img src="<?php echo RES;?>mobile/images/icon001.png">
                <span>首页</span>
            </a>
        </li>
        <li class="footer02">
        	<a href="<?php  echo $this->createMobileUrl('mine', array())?>">
                <img src="<?php echo RES;?>mobile/images/icon02.png">
                <span>个人中心</span>
            </a>
        </li>
    </ul>
</div>

<script>
    var page = 2;
    $(window).scroll(function(){

        if ($(document).scrollTop() == $(document).height() - $(window).height()) {

            if (page > 1)
            {
                loadStore();
            }
        }
    });
    /** 搜索门店 */
    function searchStore() {

        var content= $('#searchstore').val();

        if (content == '')
        {
            window.location.href = "<?php  echo $_W['siteurl'];?>";

        } else
        {
            $.ajax({
                url:"<?php  echo $this->createMobileUrl('ajaxStore', array('log'=>$_GPC['log'], 'lat'=>$_GPC['lat'], 'circle_id'=>$_GPC['circle_id']))?>"+"&content="+content,
                type:'get',
                success:function (data) {

                    $('#storelist').html(data);
                }
            })
        }

    }

    /** 加载更多 */
    function loadStore() {

        $.ajax({
            url:"<?php  echo $this->createMobileUrl('loadStore', array('log'=>$_GPC['log'], 'lat'=>$_GPC['lat'], 'circle_id'=>$_GPC['circle_id']))?>"+"&page="+page,
            type:'get',
            success:function (data) {

                data = eval('(' +data + ')');
               if (data.result == 'success')
               {
                   $('#storelist').append(data.store);
                   page = data.page;
                   
               }
            }
        })
    }
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>
