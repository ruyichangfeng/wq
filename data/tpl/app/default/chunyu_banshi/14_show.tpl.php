<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>chunyu/css/style.css">
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
if(navigator.appName == 'Microsoft Internet Explorer'){
	if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
		alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
	}
}
window.sysinfo = {
	<?php  if(!empty($_W['uniacid'])) { ?>'uniacid': '<?php  echo $_W['uniacid'];?>',<?php  } ?>
	<?php  if(!empty($_W['acid'])) { ?>'acid': '<?php  echo $_W['acid'];?>',<?php  } ?>
	<?php  if(!empty($_W['openid'])) { ?>'openid': '<?php  echo $_W['openid'];?>',<?php  } ?>
	<?php  if(!empty($_W['uid'])) { ?>'uid': '<?php  echo $_W['uid'];?>',<?php  } ?>
	'siteroot': '<?php  echo $_W['siteroot'];?>',
	'siteurl': '<?php  echo $_W['siteurl'];?>',
	'attachurl': '<?php  echo $_W['attachurl'];?>',
	'attachurl_local': '<?php  echo $_W['attachurl_local'];?>',
	'attachurl_remote': '<?php  echo $_W['attachurl_remote'];?>',
	<?php  if(defined('MODULE_URL')) { ?>'MODULE_URL': '<?php echo MODULE_URL;?>',<?php  } ?>
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
	'openCard',
	'openAddress'
];
</script>

<title><?php  echo $yewu['lname'];?></title>

<style type="text/css">
body,td,th,ul,li，a,span{
	font-family: 微软雅黑;
	padding:0;
	margin:0;
}
a {
	color: #333;
	text-decoration:none;
	cursor:pointer;
	font-family: 微软雅黑;
}
.find_nav {
    width: 100%;
    height: 40px;
    background-color: #22ac79;
    /*position: fixed;
    top: 0;*/
    z-index: 9999;
    border-bottom: 1px solid #ddd;
    display: -moz-box;
    display: -webkit-box;
    display: box;
}
.find_nav_left {
    height: 40px;
    position: relative;
    overflow: hidden;
    -moz-box-flex: 1;
    -webkit-box-flex: 1;
    box-flex: 1;
}
.find_nav_list {
    position: absolute;
    left: 0;
	    width: 100%;
}
.find_nav_list ul {
    position: relative;
    white-space: nowrap;
    font-size: 0;
}
.find_nav_list ul li {
    display: inline-block;
    padding: 0;
	width:33%;
}
.find_nav_list ul li a {
    display: block;
    width: 100%;
    height: 100%;
    line-height: 40px;
    font-size: 20px;
    text-align: center;
    color: #fff;
	font-weight:bold;font-family: 微软雅黑;
}
.find_nav_cur a {
    color: #f9f306 !important;font-family: 微软雅黑;
}
.find_nav_list a.active{ color:#C00}
.li_list{  /*color:#fff; text-align:center*/}
.swipe{/* padding:70px 0 0 0;*/}
</style>
</head>
<body>
 <div class="top-bar">
      <div style="float:left;">
    	     <a class="btn_back" onclick="javascript:history.go(-1);"></a>
      </div>
      <div style="float:right">
       	 <a class="dh1" href="tel://<?php  echo $base['phone'];?>"></a>
      </div>
  </div>
<div class="find_nav">
    <div class="find_nav_left">
        <div class="find_nav_list" id="pagenavi1">
            <ul>
                <li><a href="#" class="active">详情</a></li>
                <li><a href="#">流程</a></li>
	    <li><a href="#">所需材料</a></li>
            </ul>
        </div>
    </div>
</div>
    <div id="slider1" class="swipe">
      <ul class="box01_list">
        <li class="li_list">	
	<div class="mc">
		<?php  echo htmlspecialchars_decode($yewu['lname'])?>
	</div>
	<div class="cl">
		<a style="float:left;background:#22ac79;width:3px;display:block;height:20px;line-height:20px;"></a>
		<a style="float:left;margin-left:10px;">办理介绍</a> 
	</div> 
	<div class="zj">
		<!--  <div class="bt" style="">
			<i class="ii"></i>
		</div> -->
		<div class="w">
			<?php  echo htmlspecialchars_decode($yewu['ljieshao'])?>
		</div>
	</div>
	<div class="cl">
	        <a style="float:left;background:#22ac79;width:3px;display:block;height:20px;line-height:20px;"></a>
	      <a style="float:left;margin-left:10px;">办理条件</a> 
	  </div> 
	  <div class="zj">
	        <div class="w">
	        <?php  echo htmlspecialchars_decode($yewu['ltiaojian'])?>
	        </div>
	  </div>
	    

	<div style="border:#c5bfbf 1px dotted;width:80%;margin:20px auto;">
		<a style="text-align:center;display:block;color:#999;font-size:14px;">法律责任</a>
		<p style="display:block;color:#999;font-size:14px;padding:10px">请您务必提供准确、真实的证明材料、您所提供的材料我们将会以电话、传真、实际走访等形式核查、如果出现虚假、我处会追究相关责任</p>
	</div>
<div style="color:#999;text-align:center;font-size:14px;line-height:30px;">
技术支持：<?php  echo $base['zhichi'];?>
</div>
</li>
<li class="li_list" >	
  <div class="mc">
        <?php  echo htmlspecialchars_decode($yewu['lname'])?>
  </div>
	<div class="cl">
		<a style="float:left;background:#22ac79;width:3px;display:block;height:20px;line-height:20px;"></a>
		<a style="float:left;margin-left:10px;">办理流程</a> 
	</div> 
	<div class="zj">
		<div class="w">
			<?php  echo htmlspecialchars_decode($yewu['lliucheng'])?>
		</div>
	</div>
<div style="border:#c5bfbf 1px dotted;width:80%;margin:20px auto;">
  <a style="text-align:center;display:block;color:#999;font-size:14px;">法律责任</a>
  <p style="display:block;color:#999;font-size:14px;padding:10px">请您务必提供准确、真实的证明材料、您所提供的材料我们将会以电话、传真、实际走访等形式核查、如果出现虚假、我处会追究相关责任</p>
</div>
<div style="color:#999;text-align:center;font-size:14px;line-height:30px;">
技术支持：<?php  echo $base['zhichi'];?>
</div>
		
		</li>
		<li  class="li_list" >
		<div class="mc">
        <?php  echo htmlspecialchars_decode($yewu['lname'])?>
  </div>
  <div class="cl">
	        <a style="float:left;background:#22ac79;width:3px;display:block;height:20px;line-height:20px;"></a>
	      <a style="float:left;margin-left:10px;">办理所需材料</a> 
	  </div> 
	  <div class="zj">
	        <div class="w">
	       <?php  echo htmlspecialchars_decode($yewu['lcailiao'])?>
	        </div>
	  </div>

<!-- <a class="tj" style="">
 资料已经填好，去上传
</a> -->

<div style="border:#c5bfbf 1px dotted;width:80%;margin:20px auto;">
  <a style="text-align:center;display:block;color:#999;font-size:14px;">法律责任</a>
  <p style="display:block;color:#999;font-size:14px;padding:10px">请您务必提供准确、真实的证明材料、您所提供的材料我们将会以电话、传真、实际走访等形式核查、如果出现虚假、我处会追究相关责任</p>
</div>
<div style="color:#999;text-align:center;font-size:14px;line-height:30px;">
技术支持：<?php  echo $base['zhichi'];?>
</div>
		</li>
       
      </ul>

    </div>


<?php  echo register_jssdk(false);?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>chunyu/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>chunyu/js/touchslider.js"></script>
<script type="text/javascript">
$(".find_nav_list").css("left",0);

$(".find_nav_list li").each(function(){
		$(".sideline").css({left:0});
		$(".find_nav_list li").eq(0).addClass("find_nav_cur").siblings().removeClass("find_nav_cur");
});
var nav_w=$(".find_nav_list li").first().width();
$(".sideline").width(nav_w);
$(".find_nav_list li").on('click', function(){
	nav_w=$(this).width();
	$(".sideline").stop(true);
	$(".sideline").animate({left:$(this).position().left},300);
	$(".sideline").animate({width:nav_w});
	$(this).addClass("find_nav_cur").siblings().removeClass("find_nav_cur");
	var fn_w = ($(".find_nav").width() - nav_w) / 2;
	var fnl_l;
	var fnl_x = parseInt($(this).position().left);
	if (fnl_x <= fn_w) {
		fnl_l = 0;
	} else if (fn_w - fnl_x <= flb_w - fl_w) {
		fnl_l = flb_w - fl_w;
	} else {
		fnl_l = fn_w - fnl_x;
	}
	$(".find_nav_list").animate({
		"left" : fnl_l
	}, 300);
	
});
var fl_w=$(".find_nav_list").width();
var flb_w=$(".find_nav_left").width();
$(".find_nav_list").on('touchstart', function (e) {
	var touch1 = e.originalEvent.targetTouches[0];
	x1 = touch1.pageX;
	y1 = touch1.pageY;
	ty_left = parseInt($(this).css("left"));
});
$(".find_nav_list").on('touchmove', function (e) {
	var touch2 = e.originalEvent.targetTouches[0];
	var x2 = touch2.pageX;
	var y2 = touch2.pageY;
	if(ty_left + x2 - x1>=0){
		$(this).css("left", 0);
	}else if(ty_left + x2 - x1<=flb_w-fl_w){
		$(this).css("left", flb_w-fl_w);
	}else{
		$(this).css("left", ty_left + x2 - x1);
	}
	if(Math.abs(y2-y1)>0){
		e.preventDefault();
	}
});


for(n=1;n<9;n++){
	var page='pagenavi'+n;
	var mslide='slider'+n;
	var mtitle='emtitle'+n;
	arrdiv = 'arrdiv' + n;
	var as=document.getElementById(page).getElementsByTagName('a');
	var tt=new TouchSlider({id:mslide,'auto':'-1',fx:'ease-out',direction:'left',speed:600,timeout:5000,'before':function(index){
		var as=document.getElementById(this.page).getElementsByTagName('a');
		as[this.p].className='';
		this.p=index;
		
		fnl_x =  parseInt($(".find_nav_list li").eq(this.p).position().left);
		
		nav_w=$(".find_nav_list li").eq(this.p).width();
		$(".sideline").stop(true);
		$(".sideline").animate({left:$(".find_nav_list li").eq(this.p).position().left},300);
		$(".sideline").animate({width:nav_w},100);
		$(".find_nav_list li").eq(this.p).addClass("find_nav_cur").siblings().removeClass("find_nav_cur");
		var fn_w = ($(".find_nav").width() - nav_w) / 2;
		var fnl_l;
		if (fnl_x <= fn_w) {
			fnl_l = 0;
		} else if (fn_w - fnl_x <= flb_w - fl_w) {
			fnl_l = flb_w - fl_w;
		} else {
			fnl_l = fn_w - fnl_x;
		}
		$(".find_nav_list").animate({
			"left" : fnl_l
		}, 300);
	}});
	tt.page = page;
	tt.p = 0;
	//console.dir(tt); console.dir(tt.__proto__);

	for(var i=0;i<as.length;i++){
		(function(){
			var j=i;
			as[j].tt = tt;
			as[j].onclick=function(){
				this.tt.slide(j);
				return false;
			}
		})();
	}
}



	
	
wx.ready(function () {
        
    wx.onMenuShareAppMessage({
    	title: '<?php  echo $share['sharetitle']?>', // 
    	desc: '<?php  echo $share['sharetext']?>',
    	link: '<?php  echo $share['shareurl']?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    	imgUrl: '<?php  echo tomedia($share['sharepic'])?>', // 分享图标
    	success: function () { 
        	alert('分享成功');
    	},
    	cancel: function () { 
        	alert('取消分享');
    	}
	});
	
    wx.onMenuShareTimeline({
   		title: '<?php  echo $share['sharetitle']?>', // 
    	desc: '<?php  echo $share['sharetext']?>',
    	link: '<?php  echo $share['shareurl']?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    	imgUrl: '<?php  echo tomedia($share['sharepic'])?>', // 分享图标
    	success: function () { 
        	alert('分享成功');
    	},
    	cancel: function () { 
        	alert('取消分享');
    	}
	});


	wx.onMenuShareQQ({
    	title: '<?php  echo $share['sharetitle']?>', // 
    	desc: '<?php  echo $share['sharetext']?>',
    	link: '<?php  echo $share['shareurl']?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    	imgUrl: '<?php  echo tomedia($share['sharepic'])?>', // 分享图标
    	success: function () { 
        	alert('分享成功');
    	},
    	cancel: function () { 
        	alert('取消分享');
    	}
	});

	wx.onMenuShareWeibo({
    	title: '<?php  echo $share['sharetitle']?>', // 
    	desc: '<?php  echo $share['sharetext']?>',
    	link: '<?php  echo $share['shareurl']?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    	imgUrl: '<?php  echo tomedia($share['sharepic'])?>', // 分享图标
    	success: function () { 
       		alert('分享成功');
    	},
    	cancel: function () { 
        	alert('取消分享');
    	}
	});
});

</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=chunyu_banshi"></script></body>
</html>