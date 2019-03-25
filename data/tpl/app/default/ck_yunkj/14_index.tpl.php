<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>首页 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php  echo $templateurl;?>/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php  echo $templateurl;?>/js/swipe.js"></script>
<script type="text/javascript">
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideToolbar');});
	$(function(){
		new Swipe(document.getElementById('banner_box'), {
			speed:500,
			auto:3000,
			callback: function(){
				var lis = $(this.element).next("ol").children();
				lis.removeClass("on").eq(this.index).addClass("on");
			}
		});
	});
</script>

</head>
<body>

<div id="content" style="top:0px;">
 <div class="banner">
      <div id="banner_box" class="box_swipe">
        <ul>
			<?php  if(is_array($flash_list)) { foreach($flash_list as $value) { ?>
			<li><a href="<?php  echo $value['urlt'];?>" ><img alt="<?php  echo $value['titlename'];?>" src="<?php  echo tomedia($value['imgurl']);?>" style="width:100%;"/></a></li>
			<?php  } } ?>
        </ul>
        <ol>
			<?php  if(is_array($flash_list)) { foreach($flash_list as $i => $value) { ?>
			<li <?php  if($i==0) { ?>class="on"<?php  } ?>></li>
			<?php  } } ?>
        </ol>
      </div>
  </div>
<div class="topnav">
	<ul>
		<?php  if($nav_list) { ?>
		<?php  if(is_array($nav_list)) { foreach($nav_list as $value) { ?>
		<li><a href="<?php  echo $value['urlt'];?>"><img src="<?php  echo tomedia($value['imgurl']);?>" border="0"></a><p><?php  echo $value['titlename'];?></p></li>
		<?php  } } ?>
		<?php  } else { ?>
		<li><a href="<?php  echo $this->createMobileUrl('fw_lsit_index')?>"><img src="<?php  echo $templateurl;?>/images/dh01.gif" border="0"></a><p>服务项目</p></li>
		<li><a href="<?php  echo $this->createMobileUrl('user_paycost')?>"><img src="<?php  echo $templateurl;?>/images/dh02.gif" border="0"></a><p>在线缴费</p></li>
		<li><a href="<?php  echo $this->createMobileUrl('user_tallylist')?>"><img src="<?php  echo $templateurl;?>/images/dh03.gif" border="0"></a><p>记账查询</p></li>
		<li><a href="<?php  echo $this->createMobileUrl('user_ywlist')?>"><img src="<?php  echo $templateurl;?>/images/dh04.gif" border="0"></a><p>业务请求</p></li>
		<li><a href="<?php  echo $this->createMobileUrl('user_accounting')?>"><img src="<?php  echo $templateurl;?>/images/dh05.gif" border="0"></a><p>公司会计</p></li>
		<?php  } ?>
	</ul>
</div>

<?php  if($notice_list) { ?>
<script type="text/javascript" src="<?php  echo $templateurl;?>/js/MessageRoll.js"></script>
<div class="ingg" >
	<ul style="height: 61px; overflow: hidden; margin-top:15px;" id="demo01">
		<?php  if(is_array($notice_list)) { foreach($notice_list as $value) { ?>
		<li><a href="<?php  echo $this->createMobileUrl('notice_show', array('id' => $value['id']));?>"><?php  echo $value['titlename'];?></a></li>
		<?php  } } ?>
	</ul>
</div>
<script type="text/javascript">

   /*构造滚动对象方法*/
   var roll = new MessageRoll({
    container : document.getElementById("demo01"), // 滚动的容器
    height : 60 + 1 , // 滚动信息条的高度,算上底边框1px,如果没有底边框则不加1
    rollElements : "li" // 滚动元素的html标记名称
   });
   roll.start(2000); //开始滚动,每三秒滚动一次
  
</script>
<?php  } ?>

<div class="inboxbj">
<div class="titlecss">
	<ul>
		<li class="titleico"><img src="<?php  echo $templateurl;?>/images/int01.gif"></li>
		<li class="titlecontent">业务推荐</li>
		<li class="titlemore "><a href="<?php  echo $this->createMobileUrl('fw_lsit_index')?>" style="color:#FFFFFF;">更多</a></li>
	</ul>
</div>

<div class="tjgg">
	<ul>
		<?php  if($ad_list_1) { ?>
		<?php  if(is_array($ad_list_1)) { foreach($ad_list_1 as $value) { ?>
		<li><a href="<?php  echo $value['urlt'];?>"><img src="<?php  echo tomedia($value['imgurl']);?>" border="0" height="100"></a></li>
		<?php  } } ?>
		<?php  } else { ?>
		<li><img src="<?php  echo $templateurl;?>/images/gg01.jpg" height="100"></li>
		<?php  } ?>
		<?php  if($ad_list_2) { ?>
		<?php  if(is_array($ad_list_2)) { foreach($ad_list_2 as $value) { ?>
		<li><a href="<?php  echo $value['urlt'];?>"><img src="<?php  echo tomedia($value['imgurl']);?>" border="0" height="100"></a></li>
		<?php  } } ?>
		<?php  } else { ?>
		<li><img src="<?php  echo $templateurl;?>/images/gg02.jpg" height="100"></li>
		<?php  } ?>
		<?php  if($ad_list_3) { ?>
		<?php  if(is_array($ad_list_3)) { foreach($ad_list_3 as $value) { ?>
		<li><a href="<?php  echo $value['urlt'];?>"><img src="<?php  echo tomedia($value['imgurl']);?>" border="0" height="100"></a></li>
		<?php  } } ?>
		<?php  } else { ?>
		<li><img src="<?php  echo $templateurl;?>/images/gg03.jpg" height="100"></li>
		<?php  } ?>
		<?php  if($ad_list_4) { ?>
		<?php  if(is_array($ad_list_4)) { foreach($ad_list_4 as $value) { ?>
		<li><a href="<?php  echo $value['urlt'];?>"><img src="<?php  echo tomedia($value['imgurl']);?>" border="0" height="100"></a></li>
		<?php  } } ?>
		<?php  } else { ?>
		<li><img src="<?php  echo $templateurl;?>/images/gg04.jpg" height="100"></li>
		<?php  } ?>
	</ul>
</div>
</div>

<?php  if($ad_list_big) { ?>
<?php  if(is_array($ad_list_big)) { foreach($ad_list_big as $value) { ?>
<div class="inboxbj_ght"><a href="<?php  echo $value['urlt'];?>"><img src="<?php  echo tomedia($value['imgurl']);?>" border="0" ></a></div>
<?php  } } ?>
<?php  } else { ?>
<div class="inboxbj_ght"><img src="<?php  echo $templateurl;?>/images/gg05.jpg"></div>
<?php  } ?>

<?php  if(is_array($category_fw)) { foreach($category_fw as $value) { ?>
<div class="inboxbj">

	<div class="titlecss">
		<ul>
			<li class="titleico"><img src="<?php  echo $templateurl;?>/images/int02.gif"></li>
			<li class="titlecontent"><?php  echo $value['name'];?></li>
			<li class="titlemore "><a href="<?php  echo $this->createMobileUrl('fw_lsit', array('type' => $value['cid']));?>" style="color:#FFFFFF;">更多</a></li>
		</ul>
	</div>
	<div class="inshop">
		<ul>
			<?php  if(is_array($value['list_fw'])) { foreach($value['list_fw'] as $valuesd) { ?>
			<li>
				<div class="inshopimg"><a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $valuesd['id']));?>" ><img src="<?php  echo tomedia($valuesd['imgurl']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'"/></a></div>
				<div class="inshoptitle"><dl><dt><?php  echo $valuesd['titlename'];?></dt><dd><?php  echo $valuesd['jianjie'];?></dd></dl></div>
				<div class="inshopprice"><dl><dt>价格：</dt><dd>￥<?php  echo $valuesd['price'];?> </dd></dl><div class="inpricemore"><a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $valuesd['id']));?>" style="color:#FFFFFF;">查看详情</a></div></div>
			</li>
			<?php  } } ?>
		</ul>
	</div>
</div>
<?php  } } ?>

<?php  if(is_array($category_zw)) { foreach($category_zw as $value) { ?>
<div class="inboxbj">
	<div class="titlecss">
		<ul>
			<li class="titleico"><img src="<?php  echo $templateurl;?>/images/int03.gif"></li>
			<li class="titlecontent"><?php  echo $value['name'];?>a</li>
			<li class="titlemore "><a href="<?php  echo $this->createMobileUrl('yg_lsit', array('type' => $value['cid']));?>" style="color:#FFFFFF;">更多</a></li>
		</ul>
	</div>
	<div class="inshop">
		<ul>
			<?php  if(is_array($value['list_zw'])) { foreach($value['list_zw'] as $valuesd) { ?>
			<li>
				<div class="inkjimg">
					<?php  if($valuesd['avatar']) { ?>
					<img src="<?php  echo tomedia($valuesd['avatar']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'" />
					<?php  } else { ?>
					<img src="../addons/<?php  echo $_GPC['m'];?>/template/noavatar_middle.gif" />
					<?php  } ?>
				</div>
				<div class="inshoptitle">
					<dl>
						<dt><?php  echo $valuesd['name'];?></dt>
						<dd><?php  echo $valuesd['message'];?></dd>
					</dl>
				</div>
				<div class="inshopprice"><div class="inkjmore"><a href="<?php  echo $this->createMobileUrl('yg_show', array('id' => $valuesd['id']));?>" style="color:#FFFFFF;">查看详情</a></div></div>
			</li>
			<?php  } } ?>
		</ul>
	</div>
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
	<?php  echo $copyright;?>
	</div>
</div>
<?php  } ?>
</div>
  
<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
<!--footer end-->
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
