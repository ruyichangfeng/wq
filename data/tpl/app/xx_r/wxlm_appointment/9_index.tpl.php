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
    .lw-indexlist{
        border-top: 1px solid #e2e2e2;
    }
     .lw-indexlistfor{
        width: 100%;
        padding-bottom: 10px;
    }
     .lw-indexlistfor li{
         float: left;
         width: 25%;
         text-align: center;
         overflow: hidden;
         margin-top: 10px;
     }
     .lw-indexlistfor li img{
          width: 50px;
          height: 50px;
          border-radius: 40px;
      }
       .lw-indexlistfor li p:nth-child(2){
           text-align: center;
           font-weight: 600;
           font-size: 14px;
           word-break:keep-all;                 
            white-space:nowrap;        
            overflow:hidden;   
            display: block;
            width: 80%;
            margin: 0 auto;
       }
       .lw-indexlistfor li p:nth-child(3){
           font-size: 12px;
           word-break:keep-all;                 
            white-space:nowrap;        
            overflow:hidden;   
            display: block;
            width: 80%;
            margin: 0 auto;
       }
       .clear{
           clear:both;
       }
       .lw-indexlistimg img{
           width: 100%;
       }
</style>
</head>

<body>
<div class="box">
	<div class="tops">
    	<div class="col-xs-3">
            <a href="<?php  echo $this->createMobileUrl('circle', array('log'=>$_GPC['log'], 'lat'=>$_GPC['lat']))?>">
                <div class="tops-l">
                    <span><?php  if(empty($circle)) { ?>全部<?php  } else { ?><?php  echo $circle['circle_name'];?><?php  } ?></span>
                    <img src="<?php echo RES;?>mobile/images/down.png">
                </div>
            </a>
        </div>
        <div class="col-xs-9">
        	<div class="tops-r">
            	<img src="<?php echo RES;?>mobile/images/big.png">
                <input type="text" id="searchstore" onchange="searchStore()" placeholder="门店名">
            </div>
        </div>
    </div>

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
     <div class="con01" >
        <ul class="con01-t01">
            <?php  if(is_array($storetype)) { foreach($storetype as $key => $item) { ?>
            <li class="col-xs-3">
                <a href="<?php  echo $item['storetype_url'];?>" style="text-decoration:none;">
                    <img src="<?php  echo tomedia($item['storetype_img'])?>">
                    <div class="con01-t01-text"><?php  echo $item['storetype_title'];?></div>
                </a>
            </li>
            <?php  } } ?>
        </ul>
    </div>



    <div class="con01">

        <?php  if(count($store_index) >= 3) { ?>
    	<div class="con01-t">
        	<img src="<?php echo RES;?>mobile/images/img01.png">
        </div>

        <div class="con01-b">
            <div class="swiper-container2" style="position: relative;background-color: white;">
                <div class="swiper-wrapper">
                    <?php  if(is_array($store_list)) { foreach($store_list as $key => $item) { ?>
                    <div class="swiper-slide">
                        <div class="con01-l">
                            <a href="<?php  echo $this->createMobileUrl('info', array('store_id'=>$item[0]['store_id']))?>">
                                <div class="con01-image01">
                                    <img src="<?php  echo tomedia($item[0]['store_pic'])?>">
                                </div>
                                <div class="con01-text03"><?php  echo $item[0]['store_name'];?></div>
                                <div class="con01-text04"><?php  echo $item[0]['store_index_reason'];?></div>
                            </a>
                        </div>
                        <div class="con01-r">
                         <?php  if(!empty($item['1'])) { ?>
                            <div class="con01-r01">
                                <a href="<?php  echo $this->createMobileUrl('info', array('store_id'=>$item[1]['store_id']))?>">
                                    <div class="con01-image02 col-xs-6">
                                        <img src="<?php  echo tomedia($item[1]['store_pic'])?>">
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="con01-text05"><?php  echo $item[1]['store_name'];?></div>
                                        <div class="con01-text06"><?php  echo $item[1]['store_index_reason'];?></div>
                                    </div>
                                </a>
                            </div>
                            <?php  } ?>


                            <?php  if(!empty($item['2'])) { ?>
                            <div class="con01-r01">
                                <a href="<?php  echo $this->createMobileUrl('info', array('store_id'=>$item[2]['store_id']))?>">
                                    <div class="con01-image02 col-xs-6">
                                        <img src="<?php  echo tomedia($item[2]['store_pic'])?>">
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="con01-text05"><?php  echo $item[2]['store_name'];?></div>
                                        <div class="con01-text06"><?php  echo $item[2]['store_index_reason'];?></div>
                                    </div>
                                </a>
                            </div>
                            <?php  } ?>
                        </div>   
                    </div>
                    <?php  } } ?>
                </div>
                <div class=" swiper-button-prev"></div>
                <div class=" swiper-button-next"></div>
            </div>
        </div>
        <?php  } ?>
    </div>
    <style>
    .active span:nth-child(2){
    display:block; 
    width:0; 
    height:0; 
    border-width:20px 20px 0;
    border-style:solid; 
    /*border-color:transparent transparent #d5be90; */
     border-color:#d5be90 transparent transparent;/*黄 透明 透明 */
    position:absolute; 
    top:38px; 
    left:50%;/* 三角形居中显示 */
    margin-left:-20px;/* 三角形居中显示 */
}
    </style>

 <?php  if(!empty($project_index)) { ?>
   <div class="lw-indexlist" >
       <div class="lw-indexlistimg"><img src="<?php echo RES;?>mobile/images/index_show.png" alt=""></div>

       <div class="lw-indexlistfor" style="border-bottom: 1px solid #e2e2e2;">
           <?php  if(is_array($project_index)) { foreach($project_index as $key => $item) { ?>

            <a href="<?php  echo $this->createMobileUrl('otherStore', array('project_id'=>$item['project_id'], 'log' => $_GPC['log'], 'lat' => $_GPC['lat']))?>">
                <li>
                    <img src="<?php  echo tomedia($item['project_pic'])?>">
                    <p><?php  echo $item['project_name'];?></p>
                    <p><?php  echo $item['project_index_reason'];?></p>
                </li>
            </a>

           <?php  } } ?>
       <div class="clear"></div>
    </div>

   </div>
        <?php  } ?>


	<div class="con02">
    	
            <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab" >附近门店<span style="color: #fea1a1;font-size: 14px">&nbsp;NEAR</span></a><span><em></em></span></li>
            <li ><a href="#ios" data-toggle="tab">最近预约<span style="color: #fea1a1;font-size: 14px">&nbsp;HOT</span></a> <span><em></em></span></li>
            </ul>

   <div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
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
                        </li>
                        <li>
                            <div class="con02-text05"><?php  echo $item['circle_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text06"><?php  echo $item['store_tel'];?></div>
                            <?php  if(!empty($item['dis'])) { ?>
                            <div class="con02-text07">
                                <div class="con02-text08"><?php  echo $item['dis'];?>km</div>
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



         <div class="tab-pane fade in " id="ios">
        <ul class="con02-con" id="">
            <?php  if(is_array($storesa)) { foreach($storesa as $key => $item) { ?>
            <a href="<?php  echo $this->createMobileUrl('info', array('store_id'=>$item['store_id']))?>">
                <li>
                    <div class="con02-image col-xs-4">

                        <img src="<?php  echo tomedia($item['store_pic'])?>">

                    </div>
                    <ul class="con02-r col-xs-7">
                        <li>
                            <div class="con02-text02"><?php  echo $item['store_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text05"><?php  echo $item['circle_name'];?></div>
                        </li>
                        <li>
                            <div class="con02-text06"><?php  echo $item['store_tel'];?></div>
                            <div class="con02-text07">
                                <div class="con02-text08" style="color: orangered">近1周预约过</div>
                            </div>
                        </li>
                    </ul>
                </li>
            </a>
            <?php  } } ?>
            <?php  if(empty($storesa)) { ?>
            <li style="padding: 10px;text-align: center">
                <img src="<?php echo RES;?>mobile/images/clear.png" style="height: 50px" alt="">
                <p>暂无预约信息</p>
            </li>
            <?php  } ?>
        </ul>

        </div>


    </div>
    </div>
    </div>
    <ul class="footer">

        <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> dq">
            <a href="<?php  echo $this->createMobileUrl('index', array())?>">
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

    /** 加载更多 
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
    } */

      var swiper = new Swiper('.swiper-container2', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        autoplay: 2500,
    });
   </script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>
