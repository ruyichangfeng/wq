<?php defined('IN_IA') or exit('Access Denied');?><footer>
    <div class="footer_consult">
        <a href="http://kefu.3g.cn?cin=454&amp;waped=9&amp;lt=sug&amp;sid=&amp;wid=&amp;pz=&amp;gaid=&amp;pvs=">客  服</a>
        <a href="http://a.3g.cn/case.php?waped=9&amp;lt=sug&amp;sid=&amp;wid=&amp;pz=&amp;gaid=&amp;pvs=">广 告</a>
        <a href="http://news.3g.cn/mzsm.php?sid=&amp;wid=&amp;waped=9&amp;pz=&amp;gaid=&amp;pvs=">免责声明</a>
    </div>
    <div class="footer_bottom">
        <p>                Copyright © 2004 - 2014</p>
        <p>                广州市久邦数码科技有限公司</p>
        <p><a href="http://www.miitbeian.gov.cn" target="_blank">粤ICP备09018773号</a></p>
        <p><a href="http://www.3g.cn/template/global/default/images/cert/st.jpg" target="_blank">信息网络传播视听节目许可证1910442号</a></p>
    </div>
</footer>
<script>
    var more_url="<?php  echo $this->createMobileUrl('index',['category_id' => $category['id'],'_wg' => 'more']);?>";
    var edit_url="<?php  echo $this->createMobileUrl('index');?>";
    var last_id=<?php  echo intval($last_id)?>;
    var category_id=<?php  echo $category['id'];?>
</script>
<script src="<?php echo STATIC_ROOT;?>/js/zepto.js"></script>
<script src="<?php echo STATIC_ROOT;?>/js/iscroll.js?1123"></script>
<!--<script src="<?php echo STATIC_ROOT;?>/js/jquery-1.11.1.min.js"></script>-->
<style>
    .play-icon {
        position: absolute;
        z-index: 0;
        width: 50px;
        height: 50px;
        left: 50%;
        top: 50%;
        font-size: 0;
        -webkit-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
        border-radius: 50%;
        background-image: url(<?php echo STATIC_ROOT;?>/images/play-circle.svg);
        background-size: contain;
    }
    </style>
<script type="text/template" id="template_pic0">
    <section class="modle_5">
        <a class="statistic" href="{url}">
            <div class="item-title"><span>{title}</span></div>
            <div class="item-img-bord"></div>
            <div class="item-channel">
                <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{author}</span>
                <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{time}</span>
                <span style="font-size: .23rem;">{kw}</span><p></p>
            </div>
        </a>
    </section>
</script>
<script type="text/template" id="template_pic1">
    <section class="modle_1">
        <a class="statistic" href="{url}">
            <div class="item-info">
                <div class="item-title"><span>{title}</span></div>
                <div class="item-img-bord"></div>
                <div class="item-channel">
                    <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{author}</span>
                    <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{time}</span>
                    <span style="font-size: .23rem;">{kw}</span><p></p>
                </div>
            </div>
            <div class="item-img"><img class="lazy" data-src="" src="{image_0}"></div>
        </a>
    </section>
</script>
<script type="text/template" id="template_pic3">
    <section class="modle_2">
        <a class="statistic" href="{url}">
            <div class="item-title"><span>{title}</span></div>
            <div class="item-img">
                <div><img class="lazy" data-src="" src="{image_0}"></div>
                <div><img class="lazy" data-src="" src="{image_1}"></div>
                <div><img class="lazy" data-src="" src="{image_2}"></div>
            </div>
            <div class="item-channel">
                <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{author}</span>
                <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{time}</span>
                <span style="font-size: .23rem;">{kw}</span><p></p>
            </div>
        </a>
    </section>
</script>
<script type="text/template" id="template_pic_video">
    <section class="modle_2">
        <a class="statistic" href="{url}">
            <div class="item-title"><span>{title}</span></div>
            <div class="item-img" style="position: relative;">
                <div style="width:100%;height:4rem;">
                    <img style="max-height: 4.5rem;" class="lazy" data-src="" src="{image_0}">

                </div>
                <i class="play-icon"></i>
            </div>
            <div class="item-channel">
                <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{author}</span>
                <span class="rn-domainName" style="font-size: .24rem;padding-left: 0;border:0;color:#999;">{time}</span>
                <span style="font-size: .23rem;">{kw}</span><p></p>
            </div>
        </a>
    </section>
</script>
<script type="text/template" id="slider_content">
    <div class="swiper-slide " style="width: 414px;">
        <a href="{url}" ><img class="statistic" width="100%" src="{src}"></a>
        <p><span>{title}</span></p>
    </div>
</script>
<script src="<?php echo STATIC_ROOT;?>/js/fresh.js?1123"></script>
<script src="<?php echo STATIC_ROOT;?>/js/swiper.js"></script>
<script>
    var slider_content = $('#slider_content').html();
    var mySwiper = new Swiper("#carousel",{
//        pagination: ".swiper-pagination",
//        paginationClickable: !0,
        autoplay: 5e3,
        speed: 300,
        loop: !0
    });
    var mySwiper2 = new Swiper("#top-news",{
        direction : 'vertical',
        autoplay: 5e3,
        speed: 200,
        loop: !0
    });
    var myScroll;
    myScroll = new IScroll('#scroller',
        {
            eventPassthrough: true,
            scrollX: true,
            scrollY: false,
            preventDefault: false
        });
    myScroll.on('scrollEnd', function () {
//        console.log(this.x,this.maxScrollX,"");
    });
    $("#carousel").css("height", "4.3rem;");
    <?php  if($now_scroller > 5 && $now_scroller <= 8) { ?>
    myScroll.scrollToElement('#scroller-<?php  echo $now_scroller-4;?>' );
    <?php  }elseif($now_scroller > 8 && $now_scroller < 20) {?>
        myScroll.scrollToElement('#scroller-<?php  echo $now_scroller-4;?>' );
        <?php  } ?>
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=25&c=utility&a=visit&do=showjs&m=wg_sales"></script></body></html>