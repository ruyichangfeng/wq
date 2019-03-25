<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN" style="font-size: 15px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<title><?php  if(empty($settings['title'])) { ?>微导航<?php  } else { ?><?php  echo $settings['title'];?><?php  } ?></title>
<link rel="stylesheet" href="<?php echo STYLE_PATH;?>/css/index.css" />
<script src="<?php echo STYLE_PATH;?>/js/jquery-2.1.3.min.js"></script>
<?php  echo register_jssdk();?>
<script>
	wx.ready(function () {
		shareMeta = {
			title : "<?php  echo $settings['sharetitle'];?>",
			desc : "<?php  echo $settings['sharedescription'];?>",
			imgUrl:"<?php  echo tomedia($settings['shareimage'])?>",
			success: function(){
				alert("分享成功!");
			},
			cancel: function(){
				// alert("分享失败，可能是网络问题，一会儿再试试？");
			}
		};
		wx.onMenuShareTimeline(shareMeta);
		wx.onMenuShareAppMessage(shareMeta);
		wx.showAllNonBaseMenuItem();
		wx.onMenuShareWeibo(shareMeta);
		wx.onMenuShareQQ(shareMeta);
		wx.onMenuShareQZone(shareMeta);
	});
</script>
</head>
<body class="index1" <?php  if(!empty($settings['backcolor'])) { ?>style="background:<?php  echo $settings['backcolor'];?>"<?php  } ?>>
	<div class="div1">
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('inc/slide', TEMPLATE_INCLUDEPATH)) : (include template('inc/slide', TEMPLATE_INCLUDEPATH));?>
	</div>
	<div class="div1 clearfix">
		<?php  if(is_array($navigate)) { foreach($navigate as $item) { ?>
		<a href="<?php  if(empty($item['img_urls'])) { ?>javascript:void(0);<?php  } else { ?><?php  echo $item['img_urls'];?><?php  } ?>" class="w<?php  echo $item['layout'];?>">
			<img src="<?php  echo tomedia($item['img'])?>">
		</a>
		<?php  } } ?>
		<div class="box_i4"></div>
		<div class="w3">&nbsp;</div>
		<?php  if(!empty($settings['copyright'])) { ?>
		<div class="footer-copy">
		<a style="text-align:center;width:100%" href="<?php  if(empty($settings['copyright_link'])) { ?>javascript:void(0);<?php  } else { ?><?php  echo $settings['copyright_link'];?><?php  } ?>"><?php  echo $settings['copyright'];?></a></div>
		<?php  } ?>
	</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=lzy_navigate"></script></body>
</html>