<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
	<div class="ub ub-ver bga page" id="page0">
		<div class="ub-f1">
			<?php  if($staff_id == '') { ?>
				<?php  if($this->getServeInfo($item['serve_type'], 'mode') == 1) { ?>
				<div class="weui_msg">
					<div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
					<div class="weui_text_area">
						<h2 class="weui_msg_title">预约提交成功</h2>
						<p class="weui_msg_desc">系统已通知附近的服务人员竞单</p>
					</div>
					<div class="weui_opr_area">
						<p class="weui_btn_area">
							<!--
							<a href="<?php  echo $this->createMobileUrl('Selected',array('id'=>$order_id))?>" class="weui_btn weui_btn_plain_primary pc_btn">查看实时竞单</a>
							-->
							<a href="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $weid;?>&c=entry&do=selected&id=<?php  echo $order_id;?>&m=xm_gohome" class="weui_btn weui_btn_plain_primary pc_btn">查看实时竞单</a>
						</p>
					</div>
				</div>
				<?php  } else { ?>
				<div class="weui_msg">
					<div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
					<div class="weui_text_area">
						<h2 class="weui_msg_title">预约提交成功</h2>
						<p class="weui_msg_desc">系统管理员将尽快给你指派服务人员</p>
					</div>
					<div class="weui_opr_area">
						<p class="weui_btn_area">
							<a href="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $weid;?>&c=entry&do=order&m=xm_gohome" class="weui_btn weui_btn_plain_primary pc_btn">查看订单</a>
						</p>
					</div>
				</div>
				<?php  } ?>
			<?php  } else { ?>
				<div class="weui_msg">
					<div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
					<div class="weui_text_area">
						<h2 class="weui_msg_title">预约成功</h2>
						<p class="weui_msg_desc">系统已通知您预约的服务人员</p>
					</div>
					<div class="weui_opr_area">
						<p class="weui_btn_area">
							<a href="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $weid;?>&c=entry&do=order&m=xm_gohome" class="weui_btn weui_btn_plain_primary pc_btn">查看订单</a>
						</p>
					</div>
				</div>
			<?php  } ?>	
		</div>
		
		<!--推荐服务广告开始-->
		<?php  if($glist[0]['id'] != '') { ?>
		<div class="ub ub-ver  umar-t1">
        	<div class="ub ub-ac">
            	<div class="ubb b-bla01 ub-f1"></div>
                <div class="ulev-1 t-dgra" style="padding:0 0.5rem">推荐服务（广告）</div>
                <div class="ubb b-bla01 ub-f1"></div>
            </div>
            <div class="tj-ser swiper-container">
                <div class="swiper-wrapper tx-c">
                    <?php  if(is_array($glist)) { foreach($glist as $val) { ?>
                    <div class="swiper-slide ub ub-ver" style="width:5.5rem;">
                        <a href="<?php  echo $val['link'];?>" class="uinn213 ub ub-ver ub-ac block" >
                            <div class="uc-a1 uba b-bla01 ub ub-ac ub-pc imgbox2 ub-img1">
                                <img src="<?php  echo $_W['attachurl'];?><?php  echo $val['pic'];?>" style="width:2rem; height: 2rem;"> 
                            </div>
                            <div class="ulev-4 t-gra" style="padding-top:0.2rem"><?php  echo $val['gg_name'];?></div>
                        </a >
                    </div>
                    <?php  } } ?>
                    
                </div>
        	</div>
    	</div>
	    
	  	<?php  } ?>
	  	<!--推荐服务广告结束-->
  	
  		<div class="hbt"></div>
		
		<!--手机端底部-->
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
		<!--手机端底部-->


	</div>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>

</html>