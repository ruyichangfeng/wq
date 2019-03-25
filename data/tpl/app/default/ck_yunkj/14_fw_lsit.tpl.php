<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>服务项目购买列表页 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">

<!--分页-->
<link href="./resource/css/bootstrap.min.css" rel="stylesheet">
<!--分页-->
<style>
	.form-control_pp{width:180px;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}
	.tab_menu li a{color:#666666; display:block;}
	.tab_menu .selected a{ color:#FFFFFF;}
</style>

</head>
<body >
<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $this->createMobileUrl('fw_lsit_index')?>">
	 <em class="return"><</em>
	 <span class="fanhui">返回</span>
	</a>
	</div>
</div>

<div id="content">

   <div class="serve-box">
   
      <div class="top-titel">
	     <span class="tit"><?php  if($_GPC['type']) { ?><?php  echo $srdb['name'];?><?php  } else { ?>全部列表<?php  } ?></span>
	  </div>
	  <?php  if(is_array($list)) { foreach($list as $key => $value) { ?>
	  <div class="serve-list clearFix">
	     <a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $value['id']));?>" class="pic">
		 <img src="<?php  echo tomedia($value['imgurl']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'"/>
		 </a>
		 <div class="info">
		    <h3 class="htit"><a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $value['id']));?>"><?php  echo $value['titlename'];?></a></h3>
			<P class="ptxt"><?php  echo $value['jianjie'];?></P>
		    <div class="box clearFix">
			  <div class="price">
			    <em>价格:</em>
				<span class="pricenum">￥<?php  echo $value['price'];?></span>
			  </div>
		      <a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $value['id']));?>" class="lookbtn">查看</a>
		    </div>
		 </div>
	  </div>
      <?php  } } ?>
	  
	  <div style="padding: 0 10px; text-align:center;">
		<style>.pagination {margin-top: 0px;}</style>
		<?php  echo $pager;?>
	  </div>
   </div>
   
   
   <?php  if($cwgl_config['copyright']) { ?>
	<style>
	.copyright{
		background-color: #FFFFFF;
		float: left;
		width: 100%;
		margin-top: 10px;
		border-top-width: 1px;
		border-top-style: solid;
		border-top-color: #CCCCCC;
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #CCCCCC;
	}
	.copyright .copyrightp{
		padding:15px;
		text-align: center;
	}
	</style>
	<div class="copyright">
		<div class="copyrightp">
		<?php  echo $cwgl_config['copyright'];?>
		</div>
	</div>
	<?php  } ?>
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('fw_footer', TEMPLATE_INCLUDEPATH)) : (include template('fw_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
