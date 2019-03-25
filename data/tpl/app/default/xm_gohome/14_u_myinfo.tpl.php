<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div class="ub ub-ver bga page" id="page0"> 
	
  	<!--头部显示区域-->
  	<div class="ub ub-pc ub-ac c-red1 t-wh ub-ver uinn8 ub-img1" style="padding-bottom:3rem; background-image:url(<?php echo MODULE_URL;?>static/images/u-center-bg.jpg)">
  		<div class="ub ub-ac ub-pc tx-c us1">
  			<?php  if($headurl != '') { ?>
  				<img src="<?php  echo $headurl;?>" width="200" height="200" class="rod-imgbox2 uba2 b-org50 imgbox ub-img1 uc-a50 ">
  			<?php  } else { ?>
  				<img src="<?php echo MODULE_URL;?>static/takeout/images/nopic.jpg" width="200" height="200" class="rod-imgbox2 uba2 b-org50 imgbox ub-img1 uc-a50 ">	
  			<?php  } ?>
  		</div>
  		<div class="tx-c ulev-3 umar-t umar-b"><?php  echo $nickname;?></div>
  		<!--基本信息展示-->
	    <div class="ub-con ub wenzi">
	    	<div class=" bid_header ub">
	        	<div class="tx-c ub-f1" style="width:33.3%">
	            	<div class="ulev-2 uinn3">订单</div>
	                <div class="t-yel"><span class="ulev1"><?php  echo $total;?></span></div>
	            </div>
	            <div class="ubl b-gra tx-c ub-f1" style="width:33.3%">
	            	<div class="ulev-2 uinn3">积分</div>
	                <div class="t-yel"><span class="ulev1"><?php  echo floor($item['credit1'])?></span></div>
	            </div>
	            <div class="ubl b-gra tx-c ub-f1" style="width:33.3%">
	            	<div class="ulev-2 uinn3">余额</div>
	                <div class="t-yel"><span class="ulev-1">￥</span><span class="ulev1"><?php  echo $item['credit2']?></span></div>
	            </div>
	        </div>
	    </div>
	    <div class="ub c-bla ub-con diceng"></div>
 	</div>
  	<!--基本选项-->
  	<div class="class c-wh ubb ubl b-gra5 us1 ub">
  		<ul class="t-line12 ub-fh">
	      <!--循环开始-->
	      <li> <a href="<?php  echo $this->createMobileUrl('order',array())?>" class="block ubb ubr b-gra5">
	        <div class="ub ub-ac ub-pc iconn" style="margin:0 auto">
	         <i class="iconfont icon-dingdan ulev3 t-red1"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">我的订单</div>
	        </a>
	      </li>

	      <li> <a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'uselist'))?>" class="block ubb ubr b-gra5">
	       <div class="ub ub-ac ub-pc iconn" style="margin:0 auto">
	         <i class="iconfont icon-xiaofeijilu ulev3 t-org"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">消费记录</div>
	        </a>
	      </li>
	      
	      <li> <a href="<?php  echo $this->createMobileUrl('recharge',array())?>" class="block ubb ubr b-gra5 ">
	       <div class="ub ub-ac ub-pc iconn" style="margin:0 auto">
	         <i class="iconfont icon-chongzhi ulev3 t-red1"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">充值</div>
	        </a>
	      </li>
	      
	      <li> <a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'editmobile'))?>" class="block ubb ubr b-gra5">
	       <div class="ub ub-ac ub-pc iconn" style="margin:0 auto">
	         <i class="iconfont icon-shoujihaoma ulev3 t-blu"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">换手机号</div>
	        </a>
	      </li>

	      <li> <a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'editinfo'))?>" class="block ubb ubr b-gra5">
	       <div class="ub ub-ac ub-pc iconn" style="margin: 0 auto">
	         <i class="iconfont icon-xiugaiziliao ulev3 t-blu2"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">修改资料</div>
	        </a>
	      </li>
	      
	      <li> <a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'mycomment'))?>" class="block ubb ubr b-gra5">
	       <div class="ub ub-ac ub-pc iconn" style="margin:0 auto">
	         <i class="iconfont icon-wodepinglun ulev3 t-org"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">我的评论</div>
	        </a>
	      </li>
	      
	      <li> <a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'question'))?>" class="block ubb ubr b-gra5">
	       <div class="ub ub-ac ub-pc iconn" style="margin:0 auto">
	         <i class="iconfont icon-changjianwenti ulev3 t-blu"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">常见问题</div>
	        </a>
	      </li>
	      
	      <li> <a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'shuoming'))?>" class="block ubb ubr b-gra5">
	       <div class="ub ub-ac ub-pc iconn" style="margin: 0 auto"">
	         <i class="iconfont icon-shuoming ulev3 t-red1"></i> 
	         </div>
	        <div class="ulev-4 t-gra hit">服务说明</div>
	        </a>
	      </li>
	      <!--循环结束-->
	    </ul>
    	<div class="clear"></div>
  	</div>
  	
  	
  	
  	<!--退出-->
  	<div class="umar-b1 umar-t1 umar-r umar-l pc_btn">
  		<a href="<?php  echo $this->createMobileUrl('myinfo',array('foo'=>'tui'))?>" class="weui_btn weui_btn_warn"  onClick="return confirm('确认注销账号?');">退出</a>
  	</div> 
  	
  	<div class="ubt b-bla01 uinn ulev-4 tx-c"><?php  echo $banquan;?></div>
  	
  	<!--手机端底部-->
  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  	<!--手机端底部-->
  	
</div>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/jquery-1.10.2.min.js"></script> 
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/main.js"></script> 
<script type="text/javascript">
//进页面加载数据
$(document).ready(function(){  
	localStorage['type_id'] = id;
}); 
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
