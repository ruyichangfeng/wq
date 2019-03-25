<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>业务请求详情页 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
</head>
<body >
<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $urltk;?>">
	<em class="return"><</em>
	<span class="fanhui">返回</span>
	</a>
   </div>
</div>
	
<div id="content" >
  
   <div class="k-manage-bd">
      <div class="titbox">
	    <h3 class="htit">待办业务详情</h3>
	  </div>
	  <div class="daiban-box">
	     <div class="box1">
		  <p>申请日期：<?php  echo date('Y-m-d', $srdb['dateline']);?></p>
		  <?php  if($srdb['urgency']) { ?>
          <p>紧急程度：<a class="red">【紧急】</a></p>
		  <?php  } ?>
          <p>公司名称：<a class="green"><?php  echo $user_show['compname'];?></a></p>
          <p>要求完成时间：<a class="c666"><?php  echo $srdb['endtimes'];?></a></p>
          <p>办理人：<a class="c666"><?php  echo $profile_t['name'];?></a></p>
          <p>事项内容：<a class="c666"><?php  echo $category[$srdb['type']]['name'];?></a></p>         
		 </div>
		 <div class="box2">
		   <h3>详情描述</h3>
		   <p class="ptxt"><?php  echo $srdb['content'];?></p>
		   <?php  if($srdb['download']) { ?>
		   <p class="ptxt"><a href="../attachment/<?php  echo $srdb['download'];?>">点击下载附件</a></p>
		   <?php  } ?>
		 </div>
		 <div class="box3">
		   <h3>办理进度</h3>
		   <div class="txt">
		   	 <?php  if(is_array($list_progress)) { foreach($list_progress as $value) { ?>
		     <p>
			  <span><?php  echo date('Y-m-d H:i', $value['dateline']);?></span>
			  <span class="cl"><?php  echo $value['content'];?></span>
			 </p>
             <?php  } } ?>
		   </div>
		 </div>
	  </div>
	  
   </div>
   
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('user_footer', TEMPLATE_INCLUDEPATH)) : (include template('user_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
