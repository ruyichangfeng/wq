<?php defined('IN_IA') or exit('Access Denied');?><div class="footer clearFix">
<ul>
	<li class="on">
	  <a href="<?php  echo $this->createMobileUrl('index')?>">
	  <i class="home"></i>
	  <p>首页</p>
	  </a>
	 </li>
	<li>
	  <a href="<?php  echo $this->createMobileUrl('user_tallylist')?>">
	    <i class="staff"></i>
		<p>记账查询</p>
	  </a>
	</li>
	<li>
	  <a href="<?php  echo $this->createMobileUrl('user_order')?>">
	    <i class="kehu"></i>
		<p>服务管理</p>
	  </a>
	</li>
	<li>
	  <a href="<?php  echo $this->createMobileUrl('user_ywlist')?>">
	  <i class="manager"></i>
	  <p>业务申请</p>
	  </a>
	</li>
</ul>	
</div>
<!--footer end-->
<!--<script type="text/javascript" src="<?php  echo $templateurl;?>/js/jquery.min.js"></script>
<script type="text/javascript">
    $('.footer').on('click','li',function(){
    	$('.footer li').removeClass('on');
    	$(this).addClass('on');
    })
</script>-->