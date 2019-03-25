<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php  echo $base['title'];?></title>
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
<div class="bo" >
   <div class="top-bar" style="text-align:center;color:#fff;height:auto;padding-bottom: 10px;">
      <!--<div style="float:left;">
         <a class="btn_back" href="javascript:history.go(-1);"></a>
      </div>!-->
	 <h1 style="font-size:18px;"><b style="color:#fff;"><?php  echo $base['title'];?></b></h1>


<form class="search-form" method="post" action="<?php  echo $this->createMobileUrl('search',array('keyword'=>$_GPC['keyword']));?>">
    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
<div class="mm" style="width:80%;margin:0px auto;border-radius:5px;padding:0px;position:relative;">
 <!--        <script>
        function aa(){
        document.getElementById("form1").submit();
        }
        </script> -->
<!--  <input type="hidden" name="submit" value="1"> 
<input type="submit" name="test" value = "go" style="display:none"> 
 -->
    <input  style="margin:0px auto;border-radius:5px;width:90%;margin:0px;height:32px;"  type="text" name="keyword"  placeholder="你想要搜索什么...." />
<!--    <a href="" onclick="test_post()">  -->
   
   <input type="submit" style="width:32px;height:32px;line-height:32px;text-align:center;text;background:url(<?php echo MODULE_URL;?>chunyu/images/ss.png) no-repeat;display:block;position:absolute;top:5px;right:0px;" value="" /><!-- </a> -->
<!-- <script>
function test_post() {
var testform=document.getElementById("testform");
testform.action="<?php echo SITE_URL;?>index.php";
testform.submit();
}
</script> -->
   </div>
</form>
</div>

  <div class="conter" style="width:91%;">

            <?php  if(is_array($type)) { foreach($type as $key => $item) { ?>
        	         <a href="<?php  echo $this->createMobileUrl('list',array('tid'=>$item['tid']));?>">
          		      <div style="margin-top:5px;"><img src="<?php  if($item['typepic']) { ?><?php  echo tomedia($item['typepic'])?> <?php  } else { ?><?php  echo tomedia($base['typepic'])?><?php  } ?>"></div>
          		      <span><?php  echo $item['typename'];?></span>	   
          		  </a>
	      <?php  } } ?>                <!--<a href="__MODULE__/Lianxi/index">
                    <div style="margin-top:5px;"><img src="__PUBLIC__/images/timg.jpg"></div>
                    <span>各社区联系方式</span>    
                </a>
                 <a href="__MODULE__/Tougao/report">
                    <div style="margin-top:5px;"><img src="__PUBLIC__/images/product5.png"></div>
                    <span>投诉举报</span>    
                </a>
                <a href="__MODULE__/Tougao/news">
                    <div style="margin-top:5px;"><img src="__PUBLIC__/images/product5.png"></div>
                    <span>新闻投稿</span>    
                </a>
                <a href="__MODULE__/Tougao/appeal">
                    <div style="margin-top:5px;"><img src="__PUBLIC__/images/product5.png"></div>
                    <span>百姓诉求</span>    
                </a> -->
  </div>

<div style="clear:both"></div>

<div style="background:#fff;width:90%;margin:20px auto;font-size:12px;">
<div style="height:30px;line-height:30px;font-size:12px;padding:0px 10px;">所属机构：<?php  echo $base['jigou'];?></div>
<div  style="height:30px;line-height:30px;font-size:12px;padding:0px 10px;">办公地点：<?php  echo $base['didian'];?></div>
<div  style="height:30px;line-height:30px;font-size:12px;padding:0px 10px;">联系电话：<span style="font-size:12px;font-weight:bold;color:#333;"><a href="tel://<?php  echo $base['phone'];?>" style="color:#333;"><?php  echo $base['phone'];?></a></span></div>
<!-- <div  style="height:30px;line-height:30px;font-size:12px;padding:0px 10px;">监督电话：<span style="font-size:14px;font-weight:bold;color:#0d88f1"><a href="tel://{$shous.jphone}">{$shous.jphone}</a></span></div> -->
<!--<div  style="line-height:20px;font-size:12px;padding:10px 10px;">服务时间：{$shous.fuwu}</div>!-->
<div  style="line-height:20px;font-size:12px;padding:10px 10px;height:60px;">
    <div style="float:left;height:60px;">服务时间：</div>
    <div style="float:left">
	       <?php  echo $base['shijian'];?>
	</div>
</div>


</div>

<div style="color:#999;text-align:center;font-size:14px;line-height:30px;">
技术支持：<?php  echo $base['zhichi'];?>
</div>
</div>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=chunyu_banshi"></script></body>
</html>
