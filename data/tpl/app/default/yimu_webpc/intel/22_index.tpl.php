<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
 <?php  include $this->template('intel/header')?>
<body>
	
    <div class="container">
        
        <!--轮播图-->
        <?php  if($inx['imgbt'] ==1) { ?>
        <div class="swiper-container">
            <div class="swiper-wrapper">
            	<?php  if(is_array($imgs)) { foreach($imgs as $index => $item) { ?>
                <div class="swiper-slide" style="background: url(<?php  echo $_W['siteroot'];?>attachment/<?php  echo $item;?>) no-repeat center; background-size: 100% 100%;">
                  <!--<div class="bannerLeft">
                      <div class="bannerLeftTitle">微站</div>
                      <div class="bannerLeftDesc">完全可视化拖拽<br>三分钟打造自己的小程序</div>
                      <div class="bannerLeftBtn">点&nbsp;&nbsp;击&nbsp;&nbsp;查&nbsp;&nbsp;看</div>
                  </div>-->
                  <!--<img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $item;?>" alt="2018年微信小程序年度报告" class="bannerRight">-->
                </div>
                <?php  } } ?>
                
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <?php  } ?>
        <!--结局方案-->
        <?php  if($inx['functionbt'] ==1) { ?>
        <section class="fanganContainer">
            <h3><?php  echo $setting['title'];?>为不同行业提供小程序核心功能</h3>
            <h5>各种场景核心功能，一键生成小程序，提前布局微信新生态，抢占第一波红利</h5>
            <div class="lineBox"><div class="lineGap"></div></div>
            <ul class="fanganCatBox">
                <li>
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $function['img'];?>" alt="O2O电商">
                    <div class="fanganCatText"><?php  echo $function['title'];?></div>
                    <div class="fanganSliderBox">
                        <div class="fanganSliderTitle"><?php  echo $function['title'];?></div>
                        <ul class="fanganSliderContext">
                            <li><?php  echo $function['introduce'];?></li>
                            
                        </ul>
                        <div class="fanganSliderBtn">立即查看</div>
                    </div>
                </li>
                <li>
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $function['img1'];?>" alt="O2O电商">
                    <div class="fanganCatText"><?php  echo $function['title1'];?></div>
                    <div class="fanganSliderBox">
                        <div class="fanganSliderTitle"><?php  echo $function['title1'];?></div>
                        <ul class="fanganSliderContext">
                            <li><?php  echo $function['introduce1'];?></li>
                            
                        </ul>
                        <div class="fanganSliderBtn">立即查看</div>
                    </div>
                </li>
                <li>
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $function['img2'];?>" alt="O2O电商">
                    <div class="fanganCatText"><?php  echo $function['title2'];?></div>
                    <div class="fanganSliderBox">
                        <div class="fanganSliderTitle"><?php  echo $function['title2'];?></div>
                        <ul class="fanganSliderContext">
                            <li><?php  echo $function['introduce2'];?></li>
                            
                        </ul>
                        <div class="fanganSliderBtn">立即查看</div>
                    </div>
                </li>
                <li>
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $function['img3'];?>" alt="O2O电商">
                    <div class="fanganCatText"><?php  echo $function['title3'];?></div>
                    <div class="fanganSliderBox">
                        <div class="fanganSliderTitle"><?php  echo $function['title3'];?></div>
                        <ul class="fanganSliderContext">
                            <li><?php  echo $function['introduce3'];?></li>
                            
                        </ul>
                        <div class="fanganSliderBtn">立即查看</div>
                    </div>
                </li>
                <li>
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $function['img4'];?>" alt="O2O电商">
                    <div class="fanganCatText"><?php  echo $function['title4'];?></div>
                    <div class="fanganSliderBox">
                        <div class="fanganSliderTitle"><?php  echo $function['title4'];?></div>
                        <ul class="fanganSliderContext">
                            <li><?php  echo $function['introduce4'];?></li>
                            
                        </ul>
                        <div class="fanganSliderBtn">立即查看</div>
                    </div>
                </li>
                
            </ul>
        </section>
        <?php  } ?>
        <!--核心场景-->
        <?php  if($inx['scenebt'] ==1) { ?>
        <section class="changjingContainer">
            <h3>小程序核心场景</h3>
            <ul class="changjingCatBox">
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/find-app.png" alt="分享到群"><div class="changjingText">分享到群</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/scan-code.png" alt="线下扫码"><div class="changjingText">线下扫码</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/top-search.png" alt="微信搜索"><div class="changjingText">微信搜索</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/code-drainage.png" alt="聊天顶部"><div class="changjingText">聊天顶部</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/recommend-friend.png" alt="推荐给好友"><div class="changjingText">推荐给好友</div></li>
            </ul>
            <ul class="changjingCatBox">
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/accessory-app.png" alt="附近小程序"><div class="changjingText">附近小程序</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/share-wx.png" alt="支付完成页"><div class="changjingText">支付完成页</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/mini-apps.png" alt="小程序列表"><div class="changjingText">小程序列表</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/wco.png" alt="公众号主页"><div class="changjingText">公众号主页</div></li>
                <li><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/article.png" alt="公众号文章"><div class="changjingText">公众号文章</div></li>
            </ul>
        </section>
        <?php  } ?>
        <!--营销工具-->
        <?php  if($inx['toolbt'] ==1) { ?>
        <section class="yingxiaoContainer">
            <h3>营销工具</h3>
            <div class="lineBox"><div class="lineGap"></div></div>
            <div class="yingxiaoList">
			    <div class="yingxiaoBox">
				    <img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/sol_01.png">
					<div class="yingxiaoTitle">餐饮</div>
					<div class="yingxiaoDesc">
					    <label>消费一定金额</label>
					    <label>享受价格优惠</label>
                    </div>
				</div>
				<div class="yingxiaoBox">
					<img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/sol_02.png">
					<div class="yingxiaoTitle">分销</div>
					<div class="yingxiaoDesc">
					    <label>提供货源，招揽分销商</label>
					    <label>帮自己卖货</label>
				    </div>
				</div>
				<div class="yingxiaoBox">
				    <img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/sol_03.png">
				    <div class="yingxiaoTitle">秒杀</div>
				    <div class="yingxiaoDesc">
				        <label>邀请好友拼团凑单，</label>
				        <label>价格更优</label>
				    </div>
				</div>
				<div class="yingxiaoBox">
				    <img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/sol_04.png">
				    <div class="yingxiaoTitle">消费</div>
				    <div class="yingxiaoDesc">
				        <label>用超低价吸引客户，</label>
				        <label>带动整体销量</label>
				    </div>
				</div>
				<div class="yingxiaoBox">
				    <img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/sol_05.png">
				    <div class="yingxiaoTitle">砍价</div>
				    <div class="yingxiaoDesc">
				        <label>邀请好友砍价得优惠,</label>
				        <label>同时带动销量</label>
				    </div>
				</div>
				<div class="yingxiaoBox">
				    <img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/sol_06.png">
				    <div class="yingxiaoTitle">会员卡</div>
				    <div class="yingxiaoDesc">
				        <label>老客户关系的</label>
				        <label>精细化管理</label>
				    </div>
				</div>	
            </div>
        </section>
        <?php  } ?>
        <div class="clearBox"></div>
        <!--精彩案例-->
        <?php  if($inx['casebt'] ==1) { ?>
        <section class="jingcaiContainer">
            <h3>精彩案例</h3>
            <div class="lineBox"><div class="lineGap"></div></div>
            <ul class="jingcaiCatBox">
                 <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['img'];?>" alt="商超百货">
                    <div class="jingcaiBottomBox">
                        <ul class="jingcaiCatTextBox">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category'];?></li>
                        </ul>
                        <div class="jingcaiCatIcon">
                            <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code'];?>" alt="">
                        </div>
                    </div>
                    <div class="jingcaiSliderBox">
                        <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code'];?>" alt="" class="jingcaiSliderImg">
                        <ul class="jingcaiSliderContext">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category'];?></li>
                        </ul>
                    </div>
                 </li>
                 
                  <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['img1'];?>" alt="商超百货">
                    <div class="jingcaiBottomBox">
                        <ul class="jingcaiCatTextBox">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title1'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category1'];?></li>
                        </ul>
                        <div class="jingcaiCatIcon">
                            <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code1'];?>" alt="">
                        </div>
                    </div>
                    <div class="jingcaiSliderBox">
                        <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code1'];?>" alt="" class="jingcaiSliderImg">
                        <ul class="jingcaiSliderContext">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title1'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category1'];?></li>
                        </ul>
                    </div>
                 </li>
                 
                  <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['img2'];?>" alt="商超百货">
                    <div class="jingcaiBottomBox">
                        <ul class="jingcaiCatTextBox">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title2'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category2'];?></li>
                        </ul>
                        <div class="jingcaiCatIcon">
                            <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code2'];?>" alt="">
                        </div>
                    </div>
                    <div class="jingcaiSliderBox">
                        <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code2'];?>" alt="" class="jingcaiSliderImg">
                        <ul class="jingcaiSliderContext">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title2'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category2'];?></li>
                        </ul>
                    </div>
                 </li>
                 
                  <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['img3'];?>" alt="商超百货">
                    <div class="jingcaiBottomBox">
                        <ul class="jingcaiCatTextBox">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title3'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category3'];?></li>
                        </ul>
                        <div class="jingcaiCatIcon">
                            <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code3'];?>" alt="">
                        </div>
                    </div>
                    <div class="jingcaiSliderBox">
                        <img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $cases['code3'];?>" alt="" class="jingcaiSliderImg">
                        <ul class="jingcaiSliderContext">
                            <li class="jingcaiCatTitle"><?php  echo $cases['title3'];?></li>
                            <li class="jingcaiCatDesc">经营类目：<?php  echo $cases['category3'];?></li>
                        </ul>
                    </div>
                 </li>
            </ul>
        </section>
        <?php  } ?>
        <!--核心优势-->
        <?php  if($inx['advantagebt'] ==1) { ?>
        <section class="youshiContainer">
            <h2>我们的核心优势</h2>
            <div class="youshiLineGap"></div>
            <ul class="youshiContentBox">
                <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="youshiImgBox"><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/reliable.png" alt="可靠"></div>
                    <div class="youshiContentText">可靠</div>
                    <div class="youshiDescText">本土团队亲力打造，专注活动平台开发与研究</div>
                </li>
                <li class="wow bounceInRight" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="youshiImgBox"><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/professional.png" alt="专业"></div>
                    <div class="youshiContentText">专业</div>
                    <div class="youshiDescText">专业的小程序第三方平台服务商，Web APP技术领域的先行者</div>
                </li>
                <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="youshiImgBox"><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/focus.png" alt="专注"></div>
                    <div class="youshiContentText">专注</div>
                    <div class="youshiDescText">十年专注HTML5和小程序技术研究，资深的技术团队支持</div>
                </li>
                <li class="wow bounceInRight" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="youshiImgBox"><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/power.png" alt="强大"></div>
                    <div class="youshiContentText">强大</div>
                    <div class="youshiDescText">产品强大易用，模板+定制开发，最低0元起，学习成本低</div>
                </li>
                <li class="wow bounceInLeft" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="youshiImgBox"><img src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/images/service.png" alt="服务"></div>
                    <div class="youshiContentText">服务</div>
                    <div class="youshiDescText">完善的售后服务，7x24小时人工在线问题解答，保证无忧</div>
                </li>
            </ul>
        </section>
        <?php  } ?>
        <!--小程序案例-->
        
        <!--开发流程-->
        <?php  if($inx['processbt'] ==1) { ?>
        <section class="liuchengContainer">
            <h3>开发流程</h3>
            <div class="liuchengContentBox">
                <div class="liuchengBox">
                    <div class="liuchengIndex">1</div>
                    <div class="liuchengContent">注册微信小程序</div>
                </div>
                <div class="liuchengArrow"></div>
                <div class="liuchengBox">
                    <div class="liuchengIndex">2</div>
                    <div class="liuchengContent">登陆后台制作小程序</div>
                </div>
                <div class="liuchengArrow"></div>
                <div class="liuchengBox">
                    <div class="liuchengIndex">3</div>
                    <div class="liuchengContent">上传并提交审核</div>
                </div>
                <div class="liuchengArrow"></div>
                <div class="liuchengBox">
                    <div class="liuchengIndex">4</div>
                    <div class="liuchengContent">审核通过，小程序上线</div>
                </div>
            </div>
        </section>
        <?php  } ?>
        <!--核心优势-->
        <?php  if($inx['timesbt'] ==1) { ?>
        <section class="kaiqiContainer">
            <h2>共同开启小程序时代</h2>
            <ul class="kaiqiContentBox">
                <li class="wow bounceInDown" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="kaiqiTopLine">
                        <div class="kaiqiTitleCount"><?php  echo $times['partner'];?></div>
                        <div class="kaiqiTitleUnit">家</div>
                    </div>
                    <div class="kaiqiDescText">代理合作伙伴</div>
                </li>
                <li class="wow bounceInUp" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="kaiqiTopLine">
                        <div class="kaiqiTitleCount"><?php  echo $times['industry'];?></div>
                        <div class="kaiqiTitleUnit">个</div>
                    </div>
                    <div class="kaiqiDescText">覆盖行业和类目</div>
                </li>
                <li class="wow bounceInDown" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="kaiqiTopLine">
                        <div class="kaiqiTitleCount"><?php  echo $times['access'];?></div>
                        <div class="kaiqiTitleUnit">万</div>
                    </div>
                    <div class="kaiqiDescText">页面访问量</div>
                </li>
                <li class="wow bounceInUp" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="kaiqiTopLine">
                        <div class="kaiqiTitleCount"><?php  echo $times['product'];?></div>
                        <div class="kaiqiTitleUnit">万</div>
                    </div>
                    <div class="kaiqiDescText">产品月交易额</div>
                </li>
                <li class="wow bounceInDown" data-wow-duration=".8s" data-wow-delay=".1s">
                    <div class="kaiqiTopLine">
                        <div class="kaiqiTitleCount"><?php  echo $times['business'];?></div>
                        <div class="kaiqiTitleUnit">万</div>
                    </div>
                    <div class="kaiqiDescText">商家信赖之选</div>
                </li>
            </ul>
            
        </section>
        <?php  } ?>
        <?php  include $this->template('intel/footer')?>
        <!--客服-->
        
    </div>
    <!--<script src="<?php  echo $_W['siteroot'];?>addons/yimu_webpc/template/webapp/intel/js/swiper.js"></script>
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
    </script>-->
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=22&c=utility&a=visit&do=showjs&m=yimu_webpc"></script></body>
</html>