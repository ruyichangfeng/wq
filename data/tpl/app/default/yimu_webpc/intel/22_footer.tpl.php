<?php defined('IN_IA') or exit('Access Denied');?><link rel="stylesheet" href="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/css/style.css">
<footer>
            <div class="footerContainer">
                <div class="footerLogoBox"></div>
                <div class="footerContextBox">
                    <ul class="footerNavBox">
                        <li>联系人：<?php  echo $setting['name'];?></li>
                        <li>|</li>
                        <li>联系电话：<?php  echo $setting['tel'];?></li>
                        <li>|</li>
                        <li>QQ:<?php  echo $setting['qq'];?></li>
                    </ul>
                    <div class="footerAddr">公司地址：<?php  echo $setting['address'];?></div>
                    <div class="footerCopyright"><?php  echo $setting['copyright'];?></div>
                </div>
                <div class="footerPicBox"><img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $setting['code'];?>" alt="" style="width: 120px; height: 120px;">扫微信关注我们吧</div>
            </div>
</footer>
<script src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/js/swiper.js"></script>
    <script>
        new WOW().init();
        var ti;
        function changeColor() {
            $(".serviceLayer1").addClass("selectColor3");
            $(".serviceLayer2").addClass("selectColor2");
        }
        function reChangeColor() {
            $(".serviceLayer1").removeClass("selectColor3");
            $(".serviceLayer2").removeClass("selectColor2");
        }
        function changeingColor(){
            $(".serviceLayer1").addClass("selectColor2");
            ti = setInterval(function(){   
                changeColor()
                setTimeout("reChangeColor()",280)
            },700);
        }
        $(".serviceAvatarBox").hover(function(){
            changeingColor();
            $(this).find('.serviceBall').addClass("serviceBallSelected");
            $(".servicerBox").addClass("servicerBoxSelected");
		},function(){
            clearInterval(ti);
            $(".serviceLayer1").removeClass("selectColor2");
            $(this).find('.serviceBall').removeClass("serviceBallSelected");
		})
        $(".servicerTitleBox>img").click(function(){
            $(".servicerBox").removeClass("servicerBoxSelected");
        })
        $(".yingxiaoBox").hover(function(){
            $(this).addClass("yingxiaoBoxSelected")
		},function(){
            $(this).removeClass("yingxiaoBoxSelected")
		})
        $(".changjingContainer li").hover(function(){
            $(this).find('.changjingText').addClass("changjingTextSelected");
		},function(){
            $(this).find('.changjingText').removeClass("changjingTextSelected");
		})
        $(".jingcaiCatBox li").hover(function(){
            $(this).find('.jingcaiSliderBox').animate({top: "0"},"normal","swing");
		},function(){
            $(this).find('.jingcaiSliderBox').animate({top: "-414px"},"normal","swing");
		})
        $(".fanganCatBox li").hover(function(){
            $(this).find('.fanganSliderBox').animate({bottom: "0"},"fast","swing");
		},function(){
            $(this).find('.fanganSliderBox').animate({bottom: "-340px"},"fast","swing");
		})
        $(".anliCatBox>li").hover(function(event) {
            $(this).siblings().removeClass("anliCatSelected").end().addClass("anliCatSelected");
            $(".anliContent").children("li").removeClass("anliContentSelected")
            let cName = $(this).data("tab");
            $("." + cName).addClass("anliContentSelected");
        });
        var swiper = new Swiper('.swiper-container', {
          autoplay: {
            delay: 3500,
            disableOnInteraction: false,
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
              return '<span class="' + className + '"></span>';
            },
          },
        });
    </script>