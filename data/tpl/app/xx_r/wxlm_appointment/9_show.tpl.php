<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php  echo $this->config['system_name']?></title>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
</head>
<style>
    .lw-tab-title{
        width: 100%;
        text-align: center;
        color: #bfa965;
        border-bottom: 1px solid #bfa965;
        line-height: 40px;
    }
    .lw-swiper{
        text-align: center;
        line-height: 50px;
    }
    .swiper-slide-add a{
        color: #bfa965;
    }
    .swiper-slide-add{
        border-bottom: 1px solid #bfa965 !important;
    }
    .lw-tab-imglist
    {

    }
    .lw-tab-imglist img{
        width: 100%;
        margin-top: 10px;
    }
    .load
    {
        line-height: 40px;
        text-align: center;
        display: block;
        width: 100%;
    }

</style>
<body>
<div class="lw-tab-title">
    作品
</div>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide lw-swiper <?php  if(empty($type_id)) { ?>swiper-slide-add<?php  } ?>"><a href="<?php  echo $this->createMobileUrl('show')?>">全部</a></div>
        <?php  if(is_array($showtypes)) { foreach($showtypes as $key => $item) { ?>
        <div class="swiper-slide lw-swiper <?php  if($type_id == $item['showtype_id']) { ?>swiper-slide-add<?php  } ?>"><a href="<?php  echo $this->createMobileUrl('show', array('type_id'=>$item['showtype_id']))?>"><?php  echo $item['showtype_title'];?></a></div>
        <?php  } } ?>

    </div>
</div>
<div class="lw-tab-imglist">
    <?php  if(is_array($shows)) { foreach($shows as $key => $item) { ?>
    <a href="<?php  echo $item['show_url'];?>"><img src="<?php  echo tomedia($item['show_pic'])?>" alt=""></a>
    <?php  } } ?>
</div>
<?php  if($page > 0) { ?>
<a class="load" href="javascript:load()">加载更多</a>
<?php  } ?>
<div style="height: 60px"></div>
<ul class="footer">
    <?php  if($_SESSION['index'] == 2) { ?>
    <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> ">
        <a href="<?php  echo $this->createMobileUrl('other', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon01.png">
            <span>首页</span>
        </a>
    </li>
    <?php  } else { ?>
    <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> ">
        <a href="<?php  echo $this->createMobileUrl('index', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon01.png">
            <span>首页</span>
        </a>
    </li>
    <?php  } ?>
    <li class="col-xs-4">
        <a href="<?php  echo $this->createMobileUrl('mine', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon02.png">
            <span>个人中心</span>
        </a>
    </li>
    <li class="col-xs-4 dq">
        <a href="<?php  echo $this->createMobileUrl('show', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon003.png">
            <span>作品</span>
        </a>
    </li>
</ul>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>

<script>

    var page = "<?php  echo $page;?>";

    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 5,
        paginationClickable: true,
        spaceBetween: 0,
        freeMode: true
    });
    // 高亮位置
    var lwcunum=$(".swiper-wrapper  .swiper-slide-add").index()+1;
    //tab个数
    var lwnum=$(".swiper-slide").length;

    // tab宽度
    var slidewidth=$(".swiper-slide").width();
    // 满足总数大于5，高亮不在后两个且不在前三个
    var slideleft1=(lwcunum-3)*slidewidth*-1;
    // 高亮在后两个
    var slideleft2=(lwnum-5)*slidewidth*-1;
    console.log(slideleft1);
    console.log(slideleft1);
    if(lwnum>5){
        if(lwcunum+1<lwnum&&lwcunum>3){
            $(".swiper-wrapper").css("transform",'translate3d('+slideleft1+'px, 0px, 0px)');
        }
        if(lwcunum+1>=lwnum){
            $(".swiper-wrapper").css("transform",'translate3d('+slideleft2+'px, 0px, 0px)');
        }
    }

    function load() {

        if (page == 0)
        {
            $('.load').html('已经到最底部');

            return false;

        } else
        {
            page++;

            $.ajax({

                url:"<?php  echo $this->createMobileUrl('LoadShow')?>" + "&page=" + page + '&type='+"<?php  echo $type_id;?>",
                type:"get",
                success:function (data) {

                    if (data == '')
                    {
                        page = 0;
                        $('.load').html('已经到最底部');

                    } else
                    {
                        $('.lw-tab-imglist').append(data);
                    }

                }
            })
        }
    }
</script>

</html>