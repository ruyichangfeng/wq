<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?php  echo $cur_catObj->title;?></title>
	<meta name="format-detection" content="telephone=no, address=no">
	<meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
	<meta name="apple-touch-fullscreen" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<meta name="keywords" content="<?php  if(empty($_W['page']['keywords'])) { ?><?php  if(IMS_FAMILY != 'x') { ?>微擎,微信,微信公众平台,we7.cc<?php  } ?><?php  } else { ?><?php  echo $_W['page']['keywords'];?><?php  } ?>" />
	
	<link rel="shortcut icon" href="<?php  echo $_W['siteroot'];?><?php  echo $_W['config']['upload']['attachdir'];?>/<?php  if(!empty($_W['setting']['copyright']['icon'])) { ?><?php  echo $_W['setting']['copyright']['icon'];?><?php  } else { ?>images/global/wechat.jpg<?php  } ?>" />
	<link href="<?php  echo $_W['siteroot'];?>app/resource/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php  echo $_W['siteroot'];?>app/resource/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php  echo $_W['siteroot'];?>app/resource/css/animate.css" rel="stylesheet">
	<link href="<?php  echo $_W['siteroot'];?>app/resource/css/common.css" rel="stylesheet">
	<link href="<?php  echo $_W['siteroot'];?>app/<?php  echo str_replace('./', '', url('utility/style'))?>" rel="stylesheet">
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script src="<?php  echo $_W['siteroot'];?>app/resource/js/require.js"></script>
	<script src="<?php  echo $_W['siteroot'];?>app/resource/js/app/config.js"></script>
	<script type="text/javascript" src="<?php  echo $_W['siteroot'];?>app/resource/js/lib/jquery-1.11.1.min.js"></script>
	<script type="text/javascript">
	if(navigator.appName == 'Microsoft Internet Explorer'){
		if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
			alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
		}
	}
	<?php  define('HEADER', true);?>
	window.sysinfo = {
<?php  if(!empty($_W['uniacid'])) { ?>
		'uniacid': '<?php  echo $_W['uniacid'];?>',
<?php  } ?>
<?php  if(!empty($_W['acid'])) { ?>
		'acid': '<?php  echo $_W['acid'];?>',
<?php  } ?>
<?php  if(!empty($_W['openid'])) { ?>
		'openid': '<?php  echo $_W['openid'];?>',
<?php  } ?>
<?php  if(!empty($_W['uid'])) { ?>
		'uid': '<?php  echo $_W['uid'];?>',
<?php  } ?>
		'siteroot': '<?php  echo $_W['siteroot'];?>',
		'siteurl': '<?php  echo $_W['siteurl'];?>',
		'attachurl': '<?php  echo $_W['attachurl'];?>',
<?php  if(defined('MODULE_URL')) { ?>
		'MODULE_URL': '<?php echo MODULE_URL;?>',
<?php  } ?>
		'cookie' : {'pre': '<?php  echo $_W['config']['cookie']['pre'];?>'}
	};
	
	// jssdk config 对象
	jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || {};
	
	// 是否启用调试
	jssdkconfig.debug = false;
	
	jssdkconfig.jsApiList = [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'hideMenuItems',
		'showMenuItems',
		'hideAllNonBaseMenuItem',
		'showAllNonBaseMenuItem',
		'translateVoice',
		'startRecord',
		'stopRecord',
		'onRecordEnd',
		'playVoice',
		'pauseVoice',
		'stopVoice',
		'uploadVoice',
		'downloadVoice',
		'chooseImage',
		'previewImage',
		'uploadImage',
		'downloadImage',
		'getNetworkType',
		'openLocation',
		'getLocation',
		'hideOptionMenu',
		'showOptionMenu',
		'closeWindow',
		'scanQRCode',
		'chooseWXPay',
		'openProductSpecificView',
		'addCard',
		'chooseCard',
		'openCard'
	];
	
	</script>
	
	<script>
	function _removeHTMLTag(str) {
		if(typeof str == 'string'){
			str = str.replace(/<script[^>]*?>[\s\S]*?<\/script>/g,'');
			str = str.replace(/<style[^>]*?>[\s\S]*?<\/style>/g,'');
			str = str.replace(/<\/?[^>]*>/g,'');
			str = str.replace(/\s+/g,'');
			str = str.replace(/&nbsp;/ig,'');
		}
		return str;
	}
	</script>
</head>
<body>
<div class="container container-fill">
