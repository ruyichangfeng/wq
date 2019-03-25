<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/mp3/css/audioplayer.css" />
<style>
    .m_ico{margin-top:15px;}
    .m_ico img{width: 35px;height: 35px;}
</style>
<body ontouchstart>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">消息列表</div>
</header>
<div class="ui-content">
    <div class="weui-navbar weui-navbar-tabs">
        <a class="weui-navbar__item weui-bar__item--on" href="<?php  echo $this->createMobileUrl('detail')?>&app_id=<?php  echo $appId;?>&id=<?php  echo $_GPC['id'];?>">
            数据报表
        </a>
        <a class="weui-navbar__item" href="<?php  echo $this->createMobileUrl('sdetail')?>&app_id=<?php  echo $appId;?>&id=<?php  echo $_GPC['id'];?>">
            流程进程
        </a>
    </div>
    <div class="msg-wrap">
        <?php  if(is_array($msgList)) { foreach($msgList as $index => $msg) { ?>
        <div class="swiper-container">
            <?php  if($labPhoto[$index] ) { ?>
            <div class="swiper-wrapper">
                <?php  if(is_array($labPhoto[$index])) { foreach($labPhoto[$index] as $photo) { ?>
                <div class="swiper-slide"><img src="<?php  echo $setting['niu_url'];?>/<?php  echo $photo;?>?imageView2/1/w/386/h/179" data-id="<?php  echo $setting['niu_url'];?>/<?php  echo $photo;?>"></div>
                <?php  } } ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev swiper-button-white"></div> <!-- 白色 -->
            <div class="swiper-button-next swiper-button-white"></div> <!-- 黑色 -->
            <?php  } ?>
        </div>
        <!--信息-->
        <div class="msg-row">
            <?php  if($labSig[$index]) { ?>
            <?php  if(is_array($labSig[$index])) { foreach($labSig[$index] as $area) { ?>
            <p class="txt"><?php  echo $area['name'];?> : <?php  echo $area['val'];?></p>
            <?php  } } ?>
            <?php  } ?>
            <?php  if($labInput[$index]) { ?>
            <?php  if(is_array($labInput[$index])) { foreach($labInput[$index] as $input) { ?>
            <p class="txt"><?php  echo $input['name'];?> : <?php  echo $input['val'];?></p>
            <?php  } } ?>
            <?php  } ?>
            <p class="txt">单号 : <?php  echo $gdSn;?> <font style="font-size: 12px;font-weight: 800;color:red"><?php  echo $prop;?></font></p>
            <?php  if($labArea[$index]) { ?>
            <?php  if(is_array($labArea[$index])) { foreach($labArea[$index] as $area) { ?>
            <p class="txt"><?php  echo $area['name'];?> : <?php  echo $area['val'];?></p>
            <?php  } } ?>
            <?php  } ?>
            <?php  if($labChild[$index]) { ?>
            <?php  if(is_array($labChild[$index])) { foreach($labChild[$index] as $child) { ?>
            <p class="txt" style="font-weight: 800;margin-top:5px;"><?php  echo $child['name'];?></p>
            <?php  if(is_array($child['val'])) { foreach($child['val'] as $chd) { ?>
            <p class="txt"><?php  echo $chd['key'];?> : <?php  echo $chd['value'];?></p>
            <?php  } } ?>
            <?php  } } ?>
            <?php  } ?>
            <div class="m_ico">
                <?php  if($labCom[$index]['lc_lat']) { ?>
                <img  src="<?php echo MODULE_URL;?>/static/mobile/images/lc1.png"  data-lat="<?php  echo $labCom[$index]['lc_lat'];?>" data-lnt="<?php  echo $labCom[$index]['lc_lnt'];?>" class="notice_lc">
                <?php  } ?>
                <?php  if($labVoice[$index]) { ?>
                <img  src="<?php echo MODULE_URL;?>/static/mobile/images/voice1.png" onclick="hidPlay('<?php  echo $setting['niu_url'];?>/<?php  echo $labVoice;?>')">
                <?php  } ?>
            </div>
        </div>
        <?php  } } ?>
    </div>
    <div id="wrapper" style="position:fixed !important;bottom: 0 !important;width: 80%;left:10%;display: none">
        <audio id="od" src="<?php echo MODULE_URL;?>/static/mp3/audio/seeyouagain.mp3" preload="auto" controls></audio>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("wx_js", TEMPLATE_INCLUDEPATH)) : (include template("wx_js", TEMPLATE_INCLUDEPATH));?>
<script type='text/javascript' src='<?php echo MODULE_URL;?>/static/new/js/swiper.min.js' charset='utf-8'></script>
<script src="<?php echo MODULE_URL;?>/static/mp3/js/audioplayer.js"></script>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,//可选选项，自动滑动
        pagination : '.swiper-pagination',
        loop : true,
        prevButton:'.swiper-button-prev',
        nextButton:'.swiper-button-next',
    });

    //查看地理位置
    $(".notice_lc").click(function(){
        wx.openLocation({
            latitude: Number($(this).attr("data-lat")),
            longitude: Number($(this).attr("data-lnt")),
            name: '位置',
            address: $(this).attr("data-name"),
            scale: 14
        });
    });

    //图片预览
    $("body").on("click",".swiper-slide",function(){
        var imgArr=new Array();
        imgList = $(this).parent().find("img");
        imgList.each(function () {
            imgArr.push($(this).attr("data-id"));
        });
        wx.previewImage({
            urls: imgArr
        });
    });

    function hidPlay(url){
        $("#wrapper").show();
        var aud = document.getElementById("od");
        aud.src=url;
        aud.play();
        aud.onended = function() {
            setTimeout(function(){
                $("#wrapper").hide();
            },2000);
        };
    }
</script>
<script>
    (function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
</script>
<script>$( function() { $( 'audio' ).audioPlayer(); } );</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
