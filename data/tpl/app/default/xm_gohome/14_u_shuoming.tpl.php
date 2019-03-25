<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<!--加载进度开始-->
    <div id="pageLoader" class="weui_loading_toast">
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
           <p class="weui_toast_content">数据加载中</p>
       </div>
    </div>
    <!--加载进度结束-->
    
<div class="ub ub-ver bga page" id="page0">
    <!--服务说明内容-->
  	<div class="class">
	  	<div class="ub-f1 font-b ulev2 tx-c ub-ac ub-pc" style="padding-top:1rem">服务说明</div>
	  	<?php  if($item['shuoming'] == '') { ?>
	  	<!--无记录-->
	  	<div class="weui_msg">
	    	<div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div>
	    	<div class="weui_text_area">
	      		<h2 class="weui_msg_title">暂无内容</h2>
	    	</div>
	  	</div>
	  	<?php  } else { ?>
	  	<!--内容显示-->
	  	<div class="ub-f1 ulev0 uinn"><?php  echo $item['shuoming'];?></div>
	  	<?php  } ?>
  	</div>
  	
  	<div class="" style="height:3.125rem"></div>
  	<!--手机端底部-->
  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  	<!--手机端底部-->
  
  	
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout("document.getElementById('pageLoader').style.display = 'none';",1000);
	});
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
