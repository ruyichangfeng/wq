<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <title><?php  echo $activity['title'];?>-投票</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="驽马工作室">
    <meta name="Keywords" content="驽马工作室">
    <meta name="author" content="驽马工作室">
    <!-- 忽略数字自动识别为电话号码 -->
    <meta content="telephone=no" name="format-detection" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <script type="text/javascript">
        !function(J){function H(){var d=E.getBoundingClientRect().width;var e=(d/7.5>100*B?100*B:(d/7.5<42?42:d/7.5));E.style.fontSize=e+"px",J.rem=e}var G,F=J.document,E=F.documentElement,D=F.querySelector('meta[name="viewport"]'),B=0,A=0;if(D){var y=D.getAttribute("content").match(/initial-scale=([d.]+)/);y&&(A=parseFloat(y[1]),B=parseInt(1/A))}if(!B&&!A){var u=(J.navigator.appVersion.match(/android/gi),J.navigator.appVersion.match(/iphone/gi)),t=J.devicePixelRatio;B=u?t>=3&&(!B||B>=3)?3:t>=2&&(!B||B>=2)?2:1:1,A=1/B}if(E.setAttribute("data-dpr",B),!D){if(D=F.createElement("meta"),D.setAttribute("name","viewport"),D.setAttribute("content","initial-scale="+A+", maximum-scale="+A+", minimum-scale="+A+", user-scalable=no"),E.firstElementChild){E.firstElementChild.appendChild(D)}else{var s=F.createElement("div");s.appendChild(D),F.write(s.innerHTML)}}J.addEventListener("resize",function(){clearTimeout(G),G=setTimeout(H,300)},!1),J.addEventListener("pageshow",function(b){b.persisted&&(clearTimeout(G),G=setTimeout(H,300))},!1),H()}(window);
        if (typeof(M) == 'undefined' || !M){
           	 window.M = {};
        }  
    </script>
     <link href="<?php  echo $_W['siteroot'];?>app/resource/css/bootstrap.min.css?v=20160906" rel="stylesheet">
    <link href="<?php  echo $this->staticPath?>/app/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php  echo $this->staticPath?>/app/css/component.css" />
    <script type="text/javascript" src="<?php  echo $this->staticPath?>/app/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php  echo $this->staticPath?>/app/js/layer.js" ></script> 
     <link href="<?php  echo $this->staticPath?>/app/css/theme_style.css" rel="stylesheet" type="text/css">
     <script src="../addons/<?php  echo $this->current_module?>/resource/js/alinuma.js"></script> 
    <style type="text/css">
    h1, .h1, h2, .h2, h3, .h3{margin:0}
    h3, .h3{font-size:18px}
    .layui-m-layer0 .layui-m-layerchild{font-size:0.26rem;max-width:6rem}
    .layui-m-layercont{padding:0.5rem 0.3rem;line-height:0.5rem;}
    .layui-m-layercont img{width:3.5rem}
     .layui-m-layercont p{font-size:0.3rem;width:4.5rem;margin:0 auto}
    .layui-m-layerbtn span{font-size:0.3rem}  
    </style>
      <?php  echo register_jssdk();?>  
</head>
<body class="<?php  echo $activity['tpl_id'];?>"> 
<!--页面框架开始-->
<div class="g-doc">   
    <!--top开始-->
    <div class="top">
        	<img src="<?php  echo tomedia($activity['top_image'])?>" />
    </div>
    <!--top结束--> 
    <div class="m-nav">
        <div class="col-3 f-fl nav-list">
            		<a href="<?php  echo $add_url;?>">我要参加</a>
        </div>
        <div class="col-3 f-fl nav-list">
            <a href="<?php  echo $index_url;?>">参赛选手</a>
        </div>
        <div class="col-3 f-fl nav-list">
            <a href="<?php  echo $detail_url;?>">赛事说明</a>
        </div>
    </div> 
    <!-- //赞助商-->
    <?php  if(!empty($sponsors)) { ?> 
    <script type="text/javascript" src="<?php  echo $this->staticPath?>/app/js/yxMobileSlider.js"></script>
     <div class="slider" >
		        <ul>
		          	<?php  if(is_array($sponsors)) { foreach($sponsors as $sponsor1) { ?>
		            <li><a href="<?php  echo $this->createMobileUrl('sponsor',array('op'=>'info','id'=>$activity['id'],'iid'=>$sponsor1['id']))?>" target="_blank"><img src="<?php  echo tomedia($sponsor1['slide_image'])?>" alt="<?php  echo $sponsor1['name'];?>"></a></li>
		            <?php  } } ?>
		         </ul>
	  </div>  
    <script>
        $(".slider").yxMobileSlider({width:640,height:144,during:5000})
    </script>
    <?php  } ?>
    <!-- //焦点图-->