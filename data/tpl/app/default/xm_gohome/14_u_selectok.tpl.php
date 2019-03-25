<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<!--加载进度开始-->
    <div id="pageLoader" class="weui_loading_toast" style="display:none">
       <div class="weui_mask_transparent"></div>
       <div class="weui_toast">
           <div class="weui_loading">
               <!-- :) -->
               <div class="weui_loading_leaf weui_loading_leaf_0"></div>
               <div class="weui_loading_leaf weui_loading_leaf_1"></div>
               <div class="weui_loading_leaf weui_loading_leaf_2"></div>
               <div class="weui_loading_leaf weui_loading_leaf_3"></div>
               <div class="weui_loading_leaf weui_loading_leaf_4"></div>
               <div class="weui_loading_leaf weui_loading_leaf_5"></div>
               <div class="weui_loading_leaf weui_loading_leaf_6"></div>
               <div class="weui_loading_leaf weui_loading_leaf_7"></div>
               <div class="weui_loading_leaf weui_loading_leaf_8"></div>
               <div class="weui_loading_leaf weui_loading_leaf_9"></div>
               <div class="weui_loading_leaf weui_loading_leaf_10"></div>
               <div class="weui_loading_leaf weui_loading_leaf_11"></div>
           </div>
           <p class="weui_toast_content">初始化设备</p>
       </div>
    </div>
    <!--加载进度结束-->
<div class="ub ub-ver bga page" id="page0">
	
	<div class="ub-f1 ub ub-ac ub-pc ub-ver tx-c">
	    	<div><i class="iconfont icon-kafei t-gre1" style="font-size:5rem"></i> </div>
	        <div class="umar-t1 ulev2 t-gre1">妥了</div>
	        <div class="umar-t t-gre1">请耐心等候服务人员上门</div>
	        <div class="uinn8 t-gra ulev-1" style="">服务人员可能会电话联系您<br>请您保持电话畅通</div>
	        <div class="umar-b1 umar-l umar-r umar-t1"> <a href="<?php  echo $this->createMobileUrl('Order',array())?>" class="weui_btn weui_btn_primary">查看订单</a>
	    </div>
	</div>

	<div class="wap_index">
		<div class="ub ub-ver"><!--wap推荐服务-->
		        	<div class="ub ub-ac ">
		            	<div class="ubb b-bla01 ub-f1"></div>
		                <div class="ulev-1 t-dgra" style="padding:0 0.5rem">试试我们的其他服务</div>
		                <div class="ubb b-bla01 ub-f1"></div>
		            </div>
		            <div class="tj-ser swiper-container">
		                <div class="swiper-wrapper tx-c">
		                    <?php  if(is_array($list)) { foreach($list as $vo) { ?>
		                    <div class="swiper-slide ub ub-ver" style="width:5.5rem;">
		                        <!--<a href="<?php  echo $this->createMobileUrl('project',array('id'=>$vo['id']))?>" class="uinn213 ub ub-ver ub-ac block" >-->
		                        <a href="<?php  echo $_W['siteroot'];?>/app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=project&id=<?php  echo $vo['id'];?>&m=xm_gohome" class="uinn213 ub ub-ver ub-ac block" >	
		                            <div class="uc-a1 uba b-bla01 ub ub-ac ub-pc imgbox2 ub-img1">
		                            	<?php  if($vo['icon'] != '') { ?>
		                                <img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['icon'];?>" style="width:2rem; height: 2rem;">
		                                <?php  } ?>
		                            </div>
		                            <div class="ulev-4 t-gra" style="padding-top:0.2rem"><?php  echo $vo['type_name'];?></div>
		                        </a >
		                    </div>
		                    <?php  } } ?>
		                </div>
		        </div>
		    </div>
	  </div>
  
  <div class="hbt"></div>
  <!--手机端底部-->
  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>	
  <!--手机端底部-->
  
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
var Scroll0 = new Swiper('.con0', {
        pagination: '.con0 .swiper-pagination',
		autoplay: 7000,
		watchSlidesProgress : true,
		watchSlidesVisibility : true,
		lazyLoading: true,
		lazyLoadingInPrevNext: true,
});
var tjser = new Swiper('.tj-ser', {
    slidesPerView:4,
	autoplay: 5000,
  });
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>