<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php  echo $type['typename'];?></title>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<!-- /供app使用的页面标题 -->
<meta name="web-site" content=" ">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="wap-font-scale" content="no">
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>chunyu/css/style.css">
</head>
<body  style="padding-top:0px;">
<div class="bo"  style="min-height:600px;">
   <div class="top-bar" style="text-align:center;color:#fff;">
        <div style="float:left;">
           <a class="btn_back" href="javascript:history.go(-1);"></a>
        </div>
	 <?php  echo $type['typename'];?>
      <div style="float:right">
        <a class="dh1" href="tel://<?php  echo $base['phone'];?>"></a>
      </div>
    </div>
<!--    <div class="mm">
    <input type="text" name="keyword" maxlength=""  placeholder="你想要搜索什么...." >
   </div> -->

<?php  if(is_array($yewulist)) { foreach($yewulist as $key => $item) { ?>
 <div class="conter3">
	<a href="<?php  echo $this->createMobileUrl('show',array('lid'=>$item['lid']))?>">
		<div style="">
		    <?php  if($item['lpic']) { ?>
		    <img src="<?php  echo tomedia($item['lpic'])?>" >
		    <?php  } else { ?>
		    <img src="<?php  echo tomedia($base['lcpic'])?>">
		    <?php  } ?>
		</div>
		<span><?php  echo $item['lname'];?></span>	   
	</a>
 </div>
<?php  } } ?>
<div style="clear:both"></div>
<div style='text-align:center;'><?php  echo $pages;?></div>
</div>
<div style="color:#999;text-align:center;font-size:14px;line-height:30px;">
技术支持：<?php  echo $base['zhichi'];?>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=chunyu_banshi"></script></body>
</html>
