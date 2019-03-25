<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>服务项目列表页 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
</head>
<body >
<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $this->createMobileUrl('index')?>">
	 <em class="return"><</em>
	<span class="fanhui">返回</span>
	</a>
	</div>
</div>

<div id="content">
   <?php  if(is_array($category)) { foreach($category as $value) { ?>
   <div class="serve-box">
      <div class="top-titel">
	     <span class="tit"><?php  echo $value['name'];?></span>
	     <a href="<?php  echo $this->createMobileUrl('fw_lsit', array('type' => $value['cid']));?>" class="more">更多服务</a>	
	  </div>
	  <?php  if(is_array($value['list_fw'])) { foreach($value['list_fw'] as $valuesd) { ?>
	  <div class="serve-list clearFix">
	     <a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $valuesd['id']));?>" class="pic">
		 <img src="<?php  echo tomedia($valuesd['imgurl']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'"/>
		 </a>
		 <div class="info">
		    <h3 class="htit"><a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $valuesd['id']));?>"><?php  echo $valuesd['titlename'];?></a></h3>
			<P class="ptxt"><?php  echo $valuesd['jianjie'];?></P>
		    <div class="box clearFix">
			  <div class="price">
			    <em>价格:</em>
				<span class="pricenum">￥<?php  echo $valuesd['price'];?></span>
			  </div>
		      <a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $valuesd['id']));?>" class="lookbtn">查看</a>
		    </div>
		 </div>
	  </div>
	  <?php  } } ?>
   </div>
   <?php  } } ?>
   
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
