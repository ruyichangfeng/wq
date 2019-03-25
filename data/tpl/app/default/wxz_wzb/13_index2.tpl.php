<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">

<meta name="format-detection" content="telephone=no">

<meta name="apple-mobile-web-app-capable" content="yes">

<title><?php  echo $item['title'];?></title>
<link rel="stylesheet"  href="<?php echo MODULE_URL;?>template/mobile/css/base.css" />

<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/css/live.css" />

<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/css/weui.css" />

<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/css/weui2.css" />

<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/css/weui3.css" />





<link type="text/css" rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/css/global.css" />

<link type="text/css" rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/css/style.css" />







<script src="../addons/wxz_wzb/template/mobile/js/jquery.min.js"></script>

<script src="../addons/wxz_wzb/template/mobile/js/layer.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo MODULE_URL;?>template/mobile/js/zepto.min.js"></script>


<script>


var WinW=$(window).width(),WinH=$(window).height();

var player_height = WinW *<?php  echo $list['player_height'];?>/<?php  echo $list['player_weight'];?>;

</script>


<style>
.tabcon1{height:100%;}
</style>
</head>

<body style="position: relative;margin:auto;" onload="init()">

<script type="text/javascript">



function sendmsg(id,nickname){
	if(id){
		$("#msg_id").val(id);
		$("#content_msg").attr('placeholder','对'+nickname+'说');
	}
}

</script>



<input type="hidden" id="lastid" value="<?php  echo $lasdLive['id']?>" />

<input type="hidden" id="replyid" value="<?php  echo $lasdCom['id']?>" />



<style>


body,#tab{background:#ebebeb;}
#wrap{position:relative;background:#000;}

#tab-content{ height:50%; overflow-y:auto; -webkit-overflow-scrolling : touch;}

#tab{position:relative;width:100%;z-index:2;}
#tab1{display:block;}
.new_class_hongbao{transition: opacity 0.5s ease, -webkit-transform 0.5s ease; transform: rotateY(360deg);}
#dt_review_box_button button { margin-top: 1px; width: 60px; height: 30px; overflow: hidden; font-size: 14px; background-color: #ff6600;border-radius: 5px; color: #FFF; cursor: pointer; border: none; float: right;}; 


</style>
<?php  if($item['theme']) { ?>
<div class="topimg" onclick="$('.topimg').hide();" style="position:relative;">
	<span style="position: absolute;  right: 0px;  top: 0px;  padding: 9px 9px;  color: #FFF;">点击关闭</span>
	<a href="javascript:;" target="_blank">
		<img id="ticketHeaderpic" src="<?php  echo tomedia($item['theme'])?>" width="100%" >
	</a>
</div>
<?php  } ?>

<div id="wrap" style="position:relative;">
<?php  if($limit && (($uid=='-1') || ($item['limit'] == 1 && $item['password'] != $viewer['password']) || ($item['limit'] == 2 && $paylog['status']!=1) || ($item['limit'] == 3 && $paylog['status']!=1 && ($limit_time - time())<0) || ($item['limit']==4 && ($item['password'] != $viewer['password'] || $paylog['status']!=1)))) { ?>
<?php  } else { ?>
	<div class="titname" id="titname"><?php  echo $item['title'];?></div>
<?php  if($list['type']=='1') { ?>
<?php  if($list['settings']['ltype']==1) { ?>
	<div id="player" style="width:100%;position:absolute;">
		<script type="text/javascript" charset="utf-8" src="http://yuntv.letv.com/player/live/blive.js"></script>
		<script type="text/javascript"> 
			var player = new CloudLivePlayer();
			player.init({activityId:"<?php  echo $list['settings']['activity_id'];?>"});
		</script>
	</div>
<?php  } else if($list['settings']['ltype']==2) { ?>
	<div id="player" style="width:100%;position:absolute;">
		<script type="text/javascript" charset="utf-8" src="http://yuntv.letv.com/player/vod/bcloud.js"></script>
		<script>
			var player = new CloudVodPlayer();
			player.init({uu:"<?php  echo $list['settings']['uu'];?>",vu:"<?php  echo $list['settings']['vu'];?>"});
		</script>
	</div>
<?php  } ?>
<?php  } else if($list['type']=='2') { ?>

<?php  if((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)) { ?>

<div id="play" ></div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">

var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    //adveReAddr: '',//封面图点击链接
    //isclickplay: true,//是否单击播放，默认为false
    isfullscreen: true//是否双击全屏，默认为true
});

</script>
<?php  } else { ?>


<iframe id="iframeVi" style="display:none;min-height:240px;width:100%;" src="" frameborder='0'></iframe>
<div class="videoPoster" style="display:none;">
	<img id="playbtn" style="top: 50%;left:50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position: absolute;cursor:pointer;" src="<?php echo MODULE_URL;?>template/mobile/img/play.png" width="80px">
	<img src="<?php echo MODULE_URL;?>template/mobile/img/bg.png" style="cursor:pointer;border:0;width:100%;" id="livePoster">
</div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<div class="d-flex videocontrol" id="videocontrol" style="display:none;">
	<div id="lss-radio-operate" class="lss-radio-operate flex d-flex d-flex-center">
	<?php  if($list['settings']['ltype']==1) { ?>
		<i id="lssRadioPlay" class="lss-play"></i><!--回访显示-->
		<i id="SongTime_current" style="width:70%;">00:00</i><!--回访显示-->
	<?php  } else { ?>
		<div class="lss-swf-box">
			<div id="lssSwfBox"></div>
		</div>
		<i id="lssRadioPlay" class="lss-play"></i>
		<i id="lssTips"></i>
		<i id="SongTime_current">00:00</i>
		<span class="audio-bar-area flex">
			<span class="front-bar" style=""></span>
			<span class="block" data-second="0" data-current="0" style=""><b></b></span>
		</span>
		<i id="SongTime_total">00:00</i>
	<?php  } ?>
		<i id="videofs" class="videofs"></i>
	</div>
</div>
<script>
    var oTestVideo=document.getElementById("play");
	window.onresize = function(){
        oTestVideo.style.width = "100%";
        oTestVideo.style.height = window.innerHeight + "px";
	}
</script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/js/play.js"></script>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">
var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
    isfullscreen: true//是否双击全屏，默认为true
});
</script>


<?php  } ?>

<?php  } else if($list['type']=='6') { ?>

<?php  if((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)) { ?>
<script type="text/javascript" src="//g.alicdn.com/de/prismplayer/1.5.6/prism-min.js"></script>
<div id="play" class="prism-player"></div>
<script>
    // 初始化播放器
    var player = new prismplayer({
        id: "play", // 容器id
        source: "<?php  echo $list['settings']['lrtmp'];?>",// 视频地址
        autoplay: false,    //自动播放：否
        width: "100%",       // 播放器宽度
        height: "100%"      // 播放器高度
    });
    var clickDom = document.getElementById("J_clickToPlay");
    clickDom.addEventListener("click", function(e) {
    // 调用播放器的play方法
        player.play();
    });

</script>

<?php  } else { ?>


<iframe id="iframeVi" style="display:none;min-height:240px;width:100%;" src="" frameborder='0'></iframe>
<div class="videoPoster" style="display:none;">
	<img id="playbtn" style="top: 50%;left:50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position: absolute;cursor:pointer;" src="<?php echo MODULE_URL;?>template/mobile/img/play.png" width="80px">
	<img src="<?php echo MODULE_URL;?>template/mobile/img/bg.png" style="cursor:pointer;border:0;width:100%;" id="livePoster">
</div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['limg'])?>" class="video" src="<?php  echo $list['settings']['lhls'];?>"/></video>
<div class="d-flex videocontrol" id="videocontrol" style="display:none;">
	<div id="lss-radio-operate" class="lss-radio-operate flex d-flex d-flex-center">
	<?php  if($list['settings']['lltype']==1) { ?>
		<i id="lssRadioPlay" class="lss-play"></i><!--回访显示-->
		<i id="SongTime_current" style="width:70%;">00:00</i><!--回访显示-->
	<?php  } else { ?>
		<div class="lss-swf-box">
			<div id="lssSwfBox"></div>
		</div>
		<i id="lssRadioPlay" class="lss-play"></i>
		<i id="lssTips"></i>
		<i id="SongTime_current">00:00</i>
		<span class="audio-bar-area flex">
			<span class="front-bar" style=""></span>
			<span class="block" data-second="0" data-current="0" style=""><b></b></span>
		</span>
		<i id="SongTime_total">00:00</i>
	<?php  } ?>
		<i id="videofs" class="videofs"></i>
	</div>
</div>
<script>
    var oTestVideo=document.getElementById("play");
	window.onresize = function(){
        oTestVideo.style.width = "100%";
        oTestVideo.style.height = window.innerHeight + "px";
	}
</script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/js/play.js"></script>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">
var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['lrtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['lhls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
    isfullscreen: true//是否双击全屏，默认为true
});
</script>


<?php  } ?>


<?php  } else if($list['type']=='3') { ?>
<?php  echo $list['settings']['daima'];?>
<?php  } else if($list['type']=='7') { ?>
<?php  echo $list['settings']['images'];?>
<?php  } else if($list['type']=='4') { ?>

<?php  if((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)) { ?>

<div id="play" ></div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">

var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    //adveReAddr: '',//封面图点击链接
    //isclickplay: true,//是否单击播放，默认为false
    isfullscreen: true//是否双击全屏，默认为true
});

</script>
<?php  } else { ?>


<iframe id="iframeVi" style="display:none;min-height:240px;width:100%;" src="" frameborder='0'></iframe>
<div class="videoPoster" style="display:none;">
	<img id="playbtn" style="top: 50%;left:50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position: absolute;cursor:pointer;" src="<?php echo MODULE_URL;?>template/mobile/img/play.png" width="80px">
	<img src="<?php echo MODULE_URL;?>template/mobile/img/bg.png" style="cursor:pointer;border:0;width:100%;" id="livePoster">
</div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<div class="d-flex videocontrol" id="videocontrol" style="display:none;">
	<div id="lss-radio-operate" class="lss-radio-operate flex d-flex d-flex-center">
	
		<i id="lssRadioPlay" class="lss-play"></i><!--回访显示-->
		<i id="SongTime_current" style="width:70%;">00:00</i><!--回访显示-->
	
		<i id="videofs" class="videofs"></i>
	</div>
</div>
<script>
    var oTestVideo=document.getElementById("play");
	window.onresize = function(){
        oTestVideo.style.width = "100%";
        oTestVideo.style.height = window.innerHeight + "px";
	}
</script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/js/play.js"></script>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">
var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    isfullscreen: true//是否双击全屏，默认为true
});
</script>


<?php  } ?>
<?php  } else if($list['type']=='8') { ?>

<?php  if((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)) { ?>

<div id="play" ></div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">

var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    //adveReAddr: '',//封面图点击链接
    //isclickplay: true,//是否单击播放，默认为false
    isfullscreen: true//是否双击全屏，默认为true
});

</script>
<?php  } else { ?>


<iframe id="iframeVi" style="display:none;min-height:240px;width:100%;" src="" frameborder='0'></iframe>
<div class="videoPoster" style="display:none;">
	<img id="playbtn" style="top: 50%;left:50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position: absolute;cursor:pointer;" src="<?php echo MODULE_URL;?>template/mobile/img/play.png" width="80px">
	<img src="<?php echo MODULE_URL;?>template/mobile/img/bg.png" style="cursor:pointer;border:0;width:100%;" id="livePoster">
</div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<div class="d-flex videocontrol" id="videocontrol" style="display:none;">
	<div id="lss-radio-operate" class="lss-radio-operate flex d-flex d-flex-center">
	
		<i id="lssRadioPlay" class="lss-play"></i><!--回访显示-->
		<i id="SongTime_current" style="width:70%;">00:00</i><!--回访显示-->
	
		<i id="videofs" class="videofs"></i>
	</div>
</div>
<script>
    var oTestVideo=document.getElementById("play");
	window.onresize = function(){
        oTestVideo.style.width = "100%";
        oTestVideo.style.height = window.innerHeight + "px";
	}
</script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/js/play.js"></script>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">
var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    isfullscreen: true//是否双击全屏，默认为true
});
</script>


<?php  } ?>
<?php  } else if($list['type']=='5') { ?>

<?php  if((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)) { ?>

<div id="play" ></div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">

var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    //adveReAddr: '',//封面图点击链接
    //isclickplay: true,//是否单击播放，默认为false
    isfullscreen: true//是否双击全屏，默认为true
});

</script>
<?php  } else { ?>


<iframe id="iframeVi" style="display:none;min-height:240px;width:100%;" src="" frameborder='0'></iframe>
<div class="videoPoster" style="display:none;">
	<img id="playbtn" style="top: 50%;left:50%;-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position: absolute;cursor:pointer;" src="<?php echo MODULE_URL;?>template/mobile/img/play.png" width="80px">
	<img src="<?php echo MODULE_URL;?>template/mobile/img/bg.png" style="cursor:pointer;border:0;width:100%;" id="livePoster">
</div>
<video x5-video-player-type="h5" x5-video-player-fullscreen="true" class="video" preload="auto" type="application/x-mpegURL" playsinline webkit-inline="true" webkit-playsinline x-webkit-airplay="allow" loop="loop" style="object-position:center 0;width: 100%;position:absolute;z-index: 0;object-fit:cover;left: 0;top:0;right:0;" width="" height=""  id="play" poster="<?php  echo tomedia($list['settings']['img'])?>" class="video" src="<?php  echo $list['settings']['hls'];?>"/></video>
<div class="d-flex videocontrol" id="videocontrol" style="display:none;">
	<div id="lss-radio-operate" class="lss-radio-operate flex d-flex d-flex-center">
	
		<i id="lssRadioPlay" class="lss-play"></i><!--回访显示-->
		<i id="SongTime_current" style="width:70%;">00:00</i><!--回访显示-->
	
		<i id="videofs" class="videofs"></i>
	</div>
</div>
<script>
    var oTestVideo=document.getElementById("play");
	window.onresize = function(){
        oTestVideo.style.width = "100%";
        oTestVideo.style.height = window.innerHeight + "px";
	}
</script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/js/play.js"></script>
<script type="text/javascript" src="../addons/wxz_wzb/template/mobile/js/player.js"></script>
<script type="text/javascript">
var objectPlayer=new aodianPlayer({
    container:'play',//播放器容器ID，必要参数
    rtmpUrl: "<?php  echo $list['settings']['rtmp'];?>",//控制台开通的APP rtmp地址，必要参数
    hlsUrl: "<?php  echo $list['settings']['hls'];?>",//控制台开通的APP hls地址，必要参数
    /* 以下为可选参数*/
    width: '100%',//播放器宽度，可用数字、百分比等
    height: '100%',//播放器高度，可用数字、百分比等
    autostart: true,//是否自动播放，默认为false
    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
    stretching: '2',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
	adveDeAddr: "<?php  echo tomedia($list['settings']['img'])?>",//封面图片链接
    adveWidth: WinW+'px',//封面图宽度
    adveHeight: player_height+'px',//封面图高度
    isfullscreen: true//是否双击全屏，默认为true
});
</script>


<?php  } ?>
<?php  } ?>
	<ul class=" videowrap cl">
		<li class="onlineuser" style='z-index:99;'>
		<span class="videoicon seeuser"></span>
		<var class="p-views" style="">
<?php  if($item['istruenum']==1) { ?>
<?php  echo $item['real_num'];?>
<?php  } else { ?>
<?php  echo $item['total_num'];?>
<?php  } ?>
</var>
		</li>
	</ul>
	<?php  } ?>
</div>

<?php  if(($item['limit'] == 3 && $paylog['status']!=1)) { ?>

<script language="javascript" type="text/javascript"> 

var intDiffs = parseInt(<?php  echo ($limit_time - time())?>);//倒计时总秒数量
$(function(){
	if(intDiffs>0){
		timer(intDiffs,'1');
	}
});	

//getCountDown(<?php  echo $limit_time;?>,<?php  echo $this->createMobileUrl('pay', array('fee'=>$item['amount'],'rid'=>$rid,'lid'=>$item['id']));?>); 

</script> 
<?php  } ?>

<script>

function timer(intDiff,type){
	window.setInterval(function(){
	var day=0,
		hour=0,
		minute=0,
		second=0;//时间默认值		
	if(intDiff > 0){
		day = Math.floor(intDiff / (60 * 60 * 24));
		hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
		minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
		second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
	}
	if (minute <= 9) minute = '0' + minute;
	if (second <= 9) second = '0' + second;

	if(type==1){
		if(intDiff < 0){
			window.location.reload();
		}else{
			$("#dt_review_box_main").html("<span style='color:rgb(192, 0, 0);'>还可免费观看：<span style='color:<?php  echo $item['timecolor'];?>;'>"+day+"天<span style='color:<?php  echo $item['timecolor'];?>;'>"+hour+"</font>时<span style='color:<?php  echo $item['timecolor'];?>;'>"+minute+"</font>分<span style='color:<?php  echo $item['timecolor'];?>;'>"+second+'</font>秒'+"</span>");
		}
		
	}else{
		if(intDiff <= 0){
			$("#countdown").html("<font style='color:<?php  echo $item['color'];?>;'>直播已开始</font>");
			 window.location.reload();
		}else{
			$("#countdown").html("<span style='color:<?php  echo $item['color'];?>;'>直播开始倒计时：<span style='color:<?php  echo $item['timecolor'];?>;'>"+day+"天<span style='color:<?php  echo $item['timecolor'];?>;'>"+hour+"</font>时<span style='color:<?php  echo $item['timecolor'];?>;'>"+minute+"</font>分<span style='color:<?php  echo $item['timecolor'];?>;'>"+second+'</font>秒'+"</span>");
		}
		
	}
	intDiff--;
	}, 1000);
}

</script>


<?php  if(TIMESTAMP<$item['start_at']) { ?>
<div class="live-qiye-notice" id="countdown" style="text-align:center;background:<?php  echo $item['bgcolor'];?>;"></div>

<script language="javascript" type="text/javascript"> 

var intDiff = parseInt(<?php  echo $diff;?>);//倒计时总秒数量
$(function(){
	timer(intDiff,'2');
});	
//getCountDown(<?php  echo $item['start_at'];?>); 

</script> 

<?php  } ?>


<script>
function limit(type){
		if(type==1 || type==4){
			var pass = $('#password').val();
			if(!pass){
				showtips('请输入密码');
				return false;
			}
		}else{
			var pass = '';
		}

		$.ajax({
			type:'post',
			data:{'password':pass,'type':type},
			url:"<?php  echo $this->createMobileurl('limit',array('rid'=>$rid))?>",
			dataType:"json",
			//async:false,
			success: function(json){
				if(json.s=='1'){
					if(type != 1){
						var e = json.msg;
						WeixinJSBridge.invoke(
						   'getBrandWCPayRequest', {
							   "appId":e.appId,         
							   "timeStamp": ""+e.timeStamp ,             
							   "nonceStr": e.nonceStr,   
							   "package":e.package,     
							   "signType":e.signType,             
							   "paySign":e.paySign
						   },
						   function(res){  
								if(res.err_msg == "get_brand_wcpay_request:ok") {
									if(type==3){
										$("#limit2").hide();
									}else{
										$("#limit"+type).hide();
									}
									window.location.reload();
								}else{
									if(res.err_msg == "get_brand_wcpay_request:cancel"){
										var tips = '你取消了支付';
									}else{
										var tips = '支付失败';
									}
									showtips(tips);	
								}
						   }
						);  
					}else if(type== 1){
						$("#limit"+type).hide();
						window.location.reload();
					}
				}else{
					showtips(json.msg);
				}
				
			}	
		})
	}
</script>


<div id="tips"></div>

<div style="position:relative;">
	<div>
		<ul class="clearfix live-qiye-nav d-flex tabs" >
			<?php  if(is_array($menusss)) { foreach($menusss as $key => $value) { ?>
			<?php  if($value['type']=='1') { ?>

			<?php  $settings = iunserializer($value['settings'])?>

			<li class="flex <?php  if($key==0) { ?>on<?php  } ?>" data-type = "<?php  echo $value['type'];?>" onClick="tab('tab<?php  echo ($key+1)?>')" id="news_tab_menu<?php  echo ($key+1)?>"  <?php  if($value['type']=='1') { ?> data-url="<?php  echo $settings['iframe'];?>"<?php  } ?>>
			<?php  } else { ?>
			<li class="flex <?php  if($key==0) { ?>on<?php  } ?>" data-type = "<?php  echo $value['type'];?>" onClick="tab('tab<?php  echo ($key+1)?>')" id="news_tab_menu<?php  echo ($key+1)?>" >
			<?php  } ?>
			

				<a ><?php  echo $value['name'];?></a>

			</li>

			<?php  } } ?>
			<?php  if($item['button_show']==1) { ?>
				<?php  if($_W['fans']['follow']==1) { ?>
				<li id="" style="background: #01b3e9; color: #fff;"><a style="color:#FFF;">已关注</a></li>
				<?php  } else { ?>
				<li id="ent_focus"><a>关注</a></li>
				<?php  } ?>
			<?php  } ?>
		</ul>
	</div>
	<?php  if($roll && $roll['type']==1) { ?>
	<div class="live-qiye-notice">
		<marquee scrollamount="3"><?php  echo $roll['content'];?></marquee>
	</div>
	<?php  } ?>
</div>

<style>

.hongbao_lingqu p{font-size:12px; line-height:18px; font-weight:400; margin:10px; display:block; text-align:center;  border-radius:6px; background-color:#cecece; color:#FFFFFF}

.hongbao_lingqu p img{width:14px; height:14px; vertical-align:middle;}
.hongbao_lingqu .pmsg{padding: 8px;margin:2px;}
</style>

<div id="tab">
	<?php  if(is_array($menusss)) { foreach($menusss as $key => $value) { ?>

	<div id="tab<?php  echo ($key+1)?>" class="tabcon <?php  if($value['type'] !='3') { ?>tabcon1<?php  } ?>">
		<div class="hiddencon" id="hiddencon">
					<?php  if($value['type']=='3') { ?>
					<?php  $commentkey = $key+1;?>
					<div id="liveMainBox" class="chatarea">
						<div class="scrollContentBox" style="height:565px;">
							<div id="speakBox" class="liveTabBox imScroll speakBox" name="speak">
								<div class="liveBoxContent" style="padding-bottom: 8rem;padding-top:2rem;">

									<ul class="chat-msglist" id="chat-msglist">

									<?php  $i=0;?>

									<?php  if(is_array($Comment)) { foreach($Comment as $key => $value) { ?>



									<?php  $i++;?>

									<?php  if(date('YmdHi',$Comment[$key-1]['dateline']) !=date('YmdHi',$value['dateline'])) { ?>

										<li class="news-alert-time"><span><?php  echo date("m-d H:i",$value['dateline'])?> </span></li>

									<?php  } ?>

									<?php  if($value['ispacket']==1) { ?>
										<li class="d-flex">
											<div class="marry-chat-content clearfix d-flex">
												<img src="<?php  echo tomedia($value['headimgurl'])?>" alt="" class="userphoto">
												<div class="flex">
													<span class="nickname"><?php  echo $value['nickname'];?></span>
													<div class="msg-content" style="background:none; padding:6px 6px 6px 0;">
													<?php  if(in_array($value['id'],$packetuid)) { ?>
														<a href="#"  id="selecthongbao_<?php  echo $value['id'];?>" onClick="gethbshow(<?php  echo $value['id'];?>)" style="display:block;">
													<?php  } else { ?>
														<a href="#"  id="selecthongbao_<?php  echo $value['id'];?>" onClick="jQuery('.on_liaotian_hb').show();$('#hb_money').val(<?php  echo $value['id'];?>)" style="display:block;">
													<?php  } ?>
															<img src="<?php echo MODULE_URL;?>template/mobile/img/hb_img_0001.png" width="100%" height="auto" alt="" />
														</a>
														<div id="msg_<?php  echo $value['id'];?>" class="hongbao_lingqu">
														<?php  if(is_array($value['reply'])) { foreach($value['reply'] as $r) { ?>
															<p>
																<img  src="<?php echo MODULE_URL;?>template/mobile/img/mini_hongbao.png" /> 
																	<?php  echo $r['nickname'];?>领取了<span style="color:#FF0000;">红包</span>
															</p>
														<?php  } } ?>
														</div>
														<div class="nhzb-redline-all">
															<div class="nhzb-redline"></div>
															<div class="nhzb-hen"></div>
														</div>
													</div>
												</div>
											</div>
										</li>
									<?php  } else { ?>
										<?php  if($value['dsid'] && $value['dsstatus']==1 && $value['dsamount']>0) { ?>
											<li class="d-flex">
												<div class="marry-chat-content clearfix d-flex" style="margin:0 auto;">
													<div class="flex">
														<div id="msg_ds" class="hongbao_lingqu">
															<p class="pmsg">
																	<?php  echo $value['nickname'];?>打赏了<span style="color:#FF0000;"><?php  echo ($value['dsamount']/100)?></span>元
															</p>
														</div>
													</div>
												</div>
											</li>
										<?php  } else if($value['dsid']==0 || $value['dsid']=='') { ?>
										
											<li class="d-flex">
												<div class="marry-chat-content clearfix d-flex">
													<img src="<?php  echo $value['headimgurl'];?>" alt="" class="userphoto">
													<div class="flex">
														<span class="nickname">
	<?php  echo $value['nickname'];?>&nbsp;&nbsp;<a href="javascript:;" onclick="javascript:sendmsg(<?php  echo $value['id'];?>,'<?php  echo $value['nickname'];?>');">回复</a></span>
														<div class="msg-content">
	<?php  echo $value['content'];?>
															<div class="nhzb-redline-all">
																<div class="nhzb-redline"></div>
																<div class="nhzb-hen"></div>
															</div>
														</div>
														<ul id="msg_<?php  echo $value['id'];?>">
														<?php  if(is_array($value['reply'])) { foreach($value['reply'] as $r) { ?>
															<li style="margin-top:10px;"><div class="marry-chat-content clearfix d-flex">
																<img src="<?php  echo $r['headimgurl'];?>" alt="" class="userphoto">
																<div class="flex">
																	<span class="nickname"><?php  echo $r['nickname'];?></span>
																	<div class="msg-content"><?php  echo $r['content'];?></div>
																</div>
																</div>
															</li>
															<?php  } } ?>
														</ul>
													</div>
												</div>
											</li>
										<?php  } ?>
									<?php  } ?>
									<?php  } } ?>
									</ul>
								</div>
							</div>
							<div class="ico_loading loadingStop"></div>
						</div>
					</div>
				</div>
		<?php  if($item['copyrightshow']==1) { ?>
		<div class="" style="display: block;  z-index:99;  position: fixed;     bottom: 5rem;    height: 2rem;    text-align: center;    width: 100%;    color: #aaa;    z-index: 99;"><?php  echo $item['copyright'];?></div><?php  } ?>

				<div class="login_box">

					<?php  if(($item['limit'] == 3 && $paylog['status']!=1)) { ?>
					<div id="dt_review_box_main" style="text-align:center;font-size: 17px;  line-height: 40px;background:<?php  echo $item['bgcolor'];?>">
						
					</div>
					<?php  } else { ?>
					<div id="dt_review_box_main" >

						<div id="dt_review_box_input">

							<input type="text" placeholder="我要说两句" id="content_msg" class="input content_msg" onpaste="return false" oncontextmenu="return false" oncopy="return false" oncut="return false" maxlength="200">
							<input type="hidden" class="msg_id" id="msg_id">

						</div>

						<div id="dt_review_box_button"><button class="button_1_disabled send_msg" >发送</button></div>

						<div class="clear"></div>

					</div>
					<?php  } ?>
			
<?php  } else if($value['type']=='4') { ?>

<section class="live mt20" style="margin-top:20px;">

		<i class="live_ico"></i>
		<div class="chat_item" id="livepic">
		<?php  if(is_array($LivePic)) { foreach($LivePic as $v) { ?>
			<div class="detail">
				<div class="live_title">
					<h3><?php  echo $v['title'];?></h3>
					<span class="time"><?php  echo date('H:i',$v['dateline'])?></span>
					<div class="clear"></div>
				</div>
				<figure>
					<figcaption><?php  echo $v['content'];?></figcaption>
				</figure>
			</div> 
		<?php  } } ?>
		</div>
		</section>


		

<?php  } else if($value['type']=='2') { ?>

<?php  $settings = iunserializer($value['settings'])?>

<div style="padding:20px; font-size:14px; line-height:20px;">

<?php  echo $settings['content'];?>





</div>

<?php  } else if($value['type']=='6') { ?>

<?php  $settings = iunserializer($value['settings'])?>


<style type="text/css">
	#allmap{height:500px;width:100%;}
</style>
	


<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<style type="text/css">
#container{
	min-width:100%;
	min-height:450px;
}
</style>
<script>
var init = function() {

    var center = new qq.maps.LatLng(<?php  echo $settings['longitude'];?>,<?php  echo $settings['latitude'];?>);
    var map = new qq.maps.Map(document.getElementById('container'),{
        center: center,
        zoom: 13
    });
    var marker = new qq.maps.Marker({
        position: center,
        map: map
    })	
}

</script>

<div id="container"></div>

<?php  } else if($value['type']=='1') { ?>
<?php  $ifr = $key+1;?>

<?php  $settings = iunserializer($value['settings'])?>

<iframe src="<?php  echo $settings['iframe'];?>" frameborder="no" marginheight="0" marginwidth="0" allowTransparency="true" style="overflow-y:auto"></iframe>

<?php  } else if($value['type']=='7') { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('store', TEMPLATE_INCLUDEPATH)) : (include template('store', TEMPLATE_INCLUDEPATH));?>
<?php  } else if($value['type']=='5') { ?>
<?php  $rankkey = $key+1;?>
<div>

	<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/js/idangerous.swiper.min.js"></script>

  <script>



  $(document).ready(function () {

  

})

  </script>



<?php  $settings = iunserializer($value['settings'])?>



<ul class="tab-title d-flex ranksss">

<?php  if(is_array($settings['list'])) { foreach($settings['list'] as $kk => $vv) { ?>

	<li <?php  if($kk==0) { ?>class="on"<?php  } ?> style='width:100%'><a><?php  echo $vv;?></a></li>

<?php  } } ?>

</ul>

  <div class="rank-content swiper-container swiper-container-horizontal swiper-container-autoheight swiper-container-android">

    <div class="swiper-wrapper">

	<?php  if(is_array($settings['list'])) { foreach($settings['list'] as $kk => $vv) { ?>

	<?php  if($vv=='邀请榜') { ?>

	<div class="swiper-slide swiper-slide-active" >

		<div class="content-slide">

			<table border="0" cellpadding="0" cellspacing="0" class="table-banglist">

						<tbody>

						<tr>

						<?php  $q=0;?>

						<?php  if(is_array($help_user_count)) { foreach($help_user_count as $ke => $va) { ?>

							<td style="width:4.5rem;" class="banglist-num banglistnum">

							   <?php  if($q==0) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-1.png" class="banglist-tag">

								<?php  } else if($q ==1) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-2.png" class="banglist-tag">

								<?php  } else if($q ==2) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-3.png" class="banglist-tag">

								<?php  } else { ?>

								<?php  echo ($q+1)?>

								<?php  } ?>

							</td>

							<?php  $q++;?>

							<td  style="width:6rem;">

								<img src="<?php  echo $va['headimgurl'];?>" class="banglist-photo shangzhubo" data-hostimg="<?php  echo $va['headimgurl'];?>" data-hostuserid="1278913" data-hostusername="<?php  echo $va['nickname'];?>">

							</td>

							<td width="40%"><span class="banglist-nickname"><?php  echo $va['nickname'];?></span></td>

							<td align="left">

								<span class="banglist-money">

									邀请

										<em><?php  echo $va['c'];?></em>

									人

								</span>

							</td>

						</tr>

						<?php  } } ?>

						

			</tbody></table>

		</div>

	</div>
	<?php  } else if($vv=='打赏榜') { ?>

	<div class="swiper-slide swiper-slide-active" >

		<div class="content-slide">

			<table border="0" cellpadding="0" cellspacing="0" class="table-banglist">

						<tbody>

						<tr>

						<?php  $q=0;?>

						<?php  if(is_array($dsrank)) { foreach($dsrank as $ke => $va) { ?>

							<td style="width:4.5rem;" class="banglist-num banglistnum">

							   <?php  if($q==0) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-1.png" class="banglist-tag">

								<?php  } else if($q ==1) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-2.png" class="banglist-tag">

								<?php  } else if($q ==2) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-3.png" class="banglist-tag">

								<?php  } else { ?>

								<?php  echo ($q+1)?>

								<?php  } ?>

							</td>

							<?php  $q++;?>

							<td  style="width:6rem;">

								<img src="<?php  echo $va['headimgurl'];?>" class="banglist-photo shangzhubo" data-hostimg="<?php  echo $va['headimgurl'];?>" data-hostuserid="1278913" data-hostusername="<?php  echo $va['nickname'];?>">

							</td>

							<td width="40%"><span class="banglist-nickname"><?php  echo $va['nickname'];?></span></td>

							<td align="left">

								<span class="banglist-money">


										<em>¥<?php  echo ($va['fee']/100)?>元</em>


								</span>

							</td>

						</tr>

						<?php  } } ?>

						

			</tbody></table>

		</div>

	</div>
	<?php  } else if($vv=='金额榜') { ?>

	<div class="swiper-slide swiper-slide-active" >

		<div class="content-slide">

			<table border="0" cellpadding="0" cellspacing="0" class="table-banglist">

						<tbody>

						<tr>

						<?php  $q=0;?>

						<?php  if(is_array($user_amount)) { foreach($user_amount as $kee => $vaa) { ?>

							<td style="width:4.5rem;" class="banglist-num banglistnum">

							   <?php  if($q==0) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-1.png" class="banglist-tag">

								<?php  } else if($q ==1) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-2.png" class="banglist-tag">

								<?php  } else if($q ==2) { ?>

								<img src="<?php echo MODULE_URL;?>template/mobile/images/list-3.png" class="banglist-tag">

								<?php  } else { ?>

								<?php  echo ($q+1)?>

								<?php  } ?>

							</td>

							<?php  $q++;?>

							<td  style="width:6rem;">

								<img src="<?php  echo $vaa['headimgurl'];?>" class="banglist-photo shangzhubo" data-hostimg="<?php  echo $vaa['headimgurl'];?>" data-hostuserid="1278913" data-hostusername="<?php  echo $vaa['nickname'];?>">

							</td>

							<td width="30%"><span class="banglist-nickname"><?php  echo $vaa['nickname'];?></span></td>

							<td align="left">

								<span class="banglist-money">

										<em>¥<?php  echo ($vaa['amount']/100)?>元</em>

								</span>

							</td>

						</tr>

						<?php  } } ?>

						

			</tbody></table>

		</div>

	</div>

	<?php  } else if($vv=='我的助力') { ?>

	<div class="swiper-slide swiper-slide-next">

		<div id="giftuserlist" class="content-slide">

			<table border="0" cellpadding="0" cellspacing="0"  class="table-banglist">

						<tbody>

						<?php  $w=0;?>

						<?php  if(is_array($help_user)) { foreach($help_user as $key => $v) { ?>

						<tr>

							<td   style="width:4.5rem;" class="banglist-num banglistnum">

							<?php  if($w==0) { ?>

							<img src="<?php echo MODULE_URL;?>template/mobile/images/list-1.png" class="banglist-tag">

							<?php  } else if($w ==1) { ?>

							<img src="<?php echo MODULE_URL;?>template/mobile/images/list-2.png" class="banglist-tag">

							<?php  } else if($w ==2) { ?>

							<img src="<?php echo MODULE_URL;?>template/mobile/images/list-3.png" class="banglist-tag">

							<?php  } else { ?>

							<?php  echo ($w+1)?>

							<?php  } ?>

							</td>

							<?php  $w++;?>

							<td  style="width:6rem;">

								<img src="<?php  echo $v['headimgurl'];?>" class="banglist-photo">

							</td>

							<td width="50%"><span class="banglist-nickname"><?php  echo $v['nickname'];?></span></td>

							<td align="left">

								<span class="banglist-money">

										<em>¥<?php  echo ($v['amount']/100)?>元</em>

								</span>

							</td>

						</tr>

						<?php  } } ?>

						

			</tbody></table>

		</div>

	</div>

	<?php  } ?>

	<?php  } } ?>

    </div>

  </div>

</div>

<?php  } ?>

</div>
</div>

				

				

	

	<?php  } } ?>



	<!--图文直播--->

	<style>

	.live{position:relative;padding:45px 12px 20px 45px;background:url(<?php echo MODULE_URL;?>template/mobile/img/live_line.png) repeat-y 21px top;}

	.live_ico{ display:inline-block; width:23px; height:30px; background:url(<?php echo MODULE_URL;?>template/mobile/img/live_ico.png) no-repeat 0 top; position:absolute; left:0; top:0; margin-left:10px; background-size:23px 30px}

	.detail::before { background: #fff;content: "";display: block;height: 7px;left: -5px;position: absolute;top: 18px;width: 7px;border-top: 1px solid #e0e0e0;border-left: 1px solid #e0e0e0;border-right: none;border-bottom: none;transform: rotate(-45deg);-webkit-transform: rotate(-45deg);-moz-transform: rotate(-45deg);}

	.detail::after {background: #5b96e5; border:2px solid #fff;border-radius: 6px; content: "";display: block;height: 6px; left: -29px; position: absolute;top: 16px;width: 6px;z-index: 200;}

	.detail{ padding:15px 2%; background:#fff; border-radius:4px; position:relative;border:1px solid #e0e0e0;margin-bottom:20px}

	.live_title h3{ font-weight:normal; font-size:20px; line-height:30px; float:left; width:70%}

	.live_title .time{ display:inline-block; float:right; line-height:30px; color:#999;width:28%; text-align:right}

	.detail figure{color:#818181; line-height:30px}

	.detail figure img{ width:100%}

	

	.refresh{ position:fixed; right:10px; bottom:20%;}

	.no_more{ text-align: center; font-size: 16px}

	

	.refresh_warning {position: fixed;left: 0;top: 0;width: 100%;height: 100%;background:rgba(0,0,0,0.5);z-index: 1002;}

	.refresh_warning_block {width: 200px;margin: 350px auto 0;height: 55px;background: #fff;border: 5px solid #e0e0e0;position: relative;}

	.refresh_warning_block p {text-align: center;font-size: 18px;overflow: hidden;height: 30px;line-height: 30px;margin-top: 12px;vertical-align: top;}

	.refresh_warning_block p i {background: url(../img/ico_warn.png) no-repeat -99px 0;display: inline-block;width: 36px;height: 24px;}

		

	</style> 
	</div>
</div>

<script>
var tabsSwiper='';
function _tabsswiper(){
	tabsSwiper = new Swiper('.rank-content',{
		onlyExternal : true,
		speed:500
	})
	$(".ranksss li").on('click',function(e){
		e.preventDefault()
		var _this =$(this),_index=_this.index(),_tr,_htr,_indextr;
		$(".ranksss .on").removeClass('on');
		_this.addClass('on');
		_tr=$('.swiper-slide').eq(_index).find('tr');
		_htr=_tr.innerHeight();
		_indextr=_tr.length;
		tabsSwiper.slideTo(_index);
		$('.swiper-slide').height(_htr*_indextr);
		$('.swiper-wrapper').height(_htr*_indextr);
	})
}


function tab(pid){
 var tabs=["tab1","tab2","tab3","tab4","tab5","tab6"];
 var navs=["news_tab_menu1","news_tab_menu2","news_tab_menu3","news_tab_menu4","news_tab_menu5","news_tab_menu6"];

 for(var i=0;i<<?php  echo $menunums;?>;i++){ 
 if(tabs[i]==pid){
	var type = document.getElementById(navs[i]).getAttribute('data-type');
	document.getElementById(tabs[i]).style.display="block";
	document.getElementById(navs[i]).className="flex on";

	 <?php  if(($ifr && $ifr>0)) { ?>
		if(pid=='tab<?php  echo $ifr;?>'){
			var ifr_url = $("#news_tab_menu<?php  echo $ifr;?>").attr('data-url');
			$("#iftype").attr('height',$(window).height());
			$("#iftype").attr('src',ifr_url);
		}
	 <?php  } ?>
	 <?php  if(($rankkey && $rankkey>0)) { ?>
		if(tabsSwiper==''&&pid=='tab<?php  echo $rankkey;?>'){
			_tabsswiper();
		}
	 <?php  } ?>
	    //商城底部购物车显示
	   if(type == 7){
			$("#cart-wrap").show();
	   }else{
			$("#cart-wrap").hide();
	   }
		
	}else{    

	document.getElementById(tabs[i]).style.display="none"; 

	document.getElementById(navs[i]).className="flex";

	}
   }  

   }
   $(function(){
		<?php  if(($rankkey && $rankkey>0)) { ?>
			if($('#tab<?php  echo $rankkey;?>').css('display')=='block'){
				_tabsswiper();
			}
		<?php  } ?>
   })
</script> 

<style>



#password{ box-sizing: border-box; padding: 10px; background-color: #FCFCFC; color: #666; border-radius: 6px; width: 90%; margin: 20px auto; font-size: 14px; border: 1px #E9E9E9 solid; }



</style>

<?php  if($uid=='-1') { ?>
<div id="guanzhu_pop" class="pop" style="display:block;z-index:99999">

	<div class="erweimahink">

		<div style="position:absolute; width:34px; height:32px;  right:0px;"></div>

		<h3 style="text-align:center">长按二维码关注！</h3>

		<div class="inputqy" style="    padding-bottom: 10px;">

			<div class="jpimg"><img id="jpimg" src="<?php  echo tomedia($setting['attention_code'])?>" width="70%" style=" padding-bottom: 10px;"/></div>

		</div>

	</div>

	<div style="position:absolute; width:100%; height:100%;" ></div>

</div>
<?php  } ?>


<div id="guanzhu_pop" class="pop" style="display:none;z-index:99999">

	<div class="erweimahink">

		<div style="position:absolute; width:34px; height:32px;  right:0px;" onClick="jQuery('#guanzhu_pop').hide()"><img src="<?php echo MODULE_URL;?>template/mobile/img/close_hongbao.png" style="width:17px; height:auto;" /></div>

		<h3 style="text-align:center">长按二维码关注！</h3>

		<div class="inputqy">

			<div class="jpimg"><img id="jpimg" src="<?php  echo tomedia($setting['attention_code'])?>" width="100%"/></div>

		</div>

	</div>

	<div style="position:absolute; width:100%; height:100%;" onClick="jQuery('#guanzhu_pop').hide()"></div>

</div>

<div class="on_div_01" style="position:fixed; top:0; left:0; width:100%; height:100%;background:rgba(0, 0, 0, 0.8); display:none; z-index:2000;">

	<div style="width:90%; position:relative; margin-top:10%; margin-left:5%; z-index:10000;">

		<img src="<?php echo MODULE_URL;?>template/mobile/img/08e93ba8812e40e5d5053187ec70d588.png" width="100%" height="auto" />

		<div style="position:absolute; width:34px; height:32px; top:4px; left:8px;" onClick="jQuery('.on_div_01').hide()"><img src="<?php echo MODULE_URL;?>template/mobile/img/close_hongbao.png" style="width:17px; height:auto;" /></div>

		<div style="text-align:center; width:100%; position:absolute; top:2.4rem; left:0;">

			<img src="<?php  echo tomedia($packet['logo'])?>" width="15%" height="15%" />

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;"><?php  echo $packet['sname'];?></p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;">给你发了一个红包</p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;"><?php  echo $packet['wishing'];?></p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;;font-size:12px;">你现在共获得<?php  echo $viewer['amount']/100?>元,已提现<?php  echo ($viewer['deposit'])/100?>元</p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;;font-size:12px;">还剩<?php  echo ($viewer['amount']-$viewer['deposit'])/100?>元没有提现</p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;font-size:12px;">（满<?php  echo $packet['withdraw_min']/100?>元可以提现）</p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:10%;"><img src="<?php echo MODULE_URL;?>template/mobile/img/hb_kai.png" width="30%" height="30%" onclick='send_fee();'/></p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;"><?php  echo $packet['packet_rule'];?></p>

		</div>

	<div style="position:absolute; width:100%; height:100%;" onClick="jQuery('.on_div_01').hide()"></div>

	</div>

	

</div>



<div class="on_liaotian_hb" style="position:fixed; top:0; left:0; width:100%; height:100%;background:rgba(0, 0, 0, 0.8); display:none; z-index:2000;">

	<div style="width:90%; position:relative; margin-top:10%; margin-left:5%; z-index:10000;">

		<img src="<?php echo MODULE_URL;?>template/mobile/img/08e93ba8812e40e5d5053187ec70d588.png" width="100%" height="auto" />

		

		<div style="text-align:center; width:100%; position:absolute; top:2.4rem; left:0;">

			<img src="<?php  echo tomedia($packet['logo'])?>" width="15%" height="15%" />

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;"><?php  echo $packet['sname'];?></p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;">给你发了一个红包</p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:5%;"><?php  echo $packet['wishing'];?></p>

			<p style=" color:#ffe2b1; line-height:1.2rem; display:block; margin-top:10%;"><img src="<?php echo MODULE_URL;?>template/mobile/img/hb_kai.png" width="30%" height="30%" id="donghua_hongbao" onclick='send_fees();'/><input type='hidden' id='hb_money'></p>


		</div>

		<div style="position:absolute; width:34px; height:32px; top:4px; left:8px;" onClick="jQuery('.on_liaotian_hb').hide()"><img src="<?php echo MODULE_URL;?>template/mobile/img/close_hongbao.png" style="width:17px; height:auto;" /></div>

	<div style="position:absolute; width:100%; height:100%;" onClick="jQuery('.on_liaotian_hb').hide()"></div>

	</div>

	

</div>



<div class="in_liaotian_hb" style="position:fixed; top:0; left:0; width:100%; height:100%;background:rgba(0, 0, 0, 0.8); display:none; z-index:2000;">

	<div style="width:90%; position:relative; margin:10% auto 0;z-index:10000;background-color:#eeeeee;">

		<div><img src="<?php echo MODULE_URL;?>template/mobile/img/hongbao_top_bg.png" style="width:100%; height:auto;"></div>

		<div style="text-align:center; padding-top:20px; background-color:#eeeeee;">

			<p style="font-size:14px" id="sned_name">微小智的红包</p>

			<p style="font-size:12px; color:#999999;">恭喜发财，大吉大利</p>

			<h2 style="font-size:36px; font-weight:700; margin-top:10px; margin-bottom:10px;" ><font id="revice_amount">0.85</font><span style="font-size:12px;"> 元</span></h2>

		</div>

		<div style="width:100%; background-color:#FFFFFF;">

			<div style="color:#999999; font-size:12px; line-height:30px; padding-left:20px; " id="send_num">领取1/2个</div>

			<div class="hongbao_list_box">

				<ul id="sned_log">

					<li>

						<div class="hongbao_list_heard"><img src="<?php echo MODULE_URL;?>template/mobile/img/hb_img_0001.png" /></div>

						<div class="hongbao_list_font">0.85元</div>

						<div style="padding-left:70px; line-height:40px; font-size:14px;">水滴</div>

					</li>

				</ul>

			</div>

		</div>

		<div style="width:60px; height:60px; border-radius:6px; border:1px solid #fdfce1; position:absolute; top:40px; left:39%; overflow:hidden;"><img src="<?php echo MODULE_URL;?>template/mobile/img/hb_img_0001.png" id='send_headurl' style="width:59px;height:59px;"/></div>

		<div style="position:absolute; width:34px; height:32px; top:4px; left:8px;" onClick="jQuery('.in_liaotian_hb').hide()"><img src="<?php echo MODULE_URL;?>template/mobile/img/close_hongbao.png" style="width:17px; height:auto;" /></div>

	</div>

	<div style="position:absolute; width:100%; height:100%;" onClick="jQuery('.in_liaotian_hb').hide()"></div>

</div>

<!--红包--->

<style>

.hongbao_list_box{ padding:0 10px; height:130px; overflow-y:scroll;}

.hongbao_list_box ul li{padding:10px 10px; position:relative; border-bottom:1px solid #ccc;}

.hongbao_list_heard{ width:40px; height:40px; float:left; border-radius:50%; overflow:hidden;}

.hongbao_list_font{height:40px; line-height:40px; float:right; font-size:14px;}



#tips {

    display: none;

    position: fixed;

    padding: 9px 15px;

    background-color: #333;

    z-index:999999999999999;

    border-radius: 5px;

	font-size: 15px;

    color: #ffffff;

    line-height: 25px;

    text-align: center;

}

</style>



<!--红包--->

<script>



function middles(){

	var left = ($(window).width() - $("#tips").outerWidth()) / 2 + "px";

	$("#tips").css({

            "top": "50%",

            "left": left

     });

}



function showtips(text){

	middles();

	$("#tips").html(text);

	$("#tips").show();

	$("#tips").bind("authheight",middles());

	setTimeout(function() {

		hidetips();

	}, 2000);

}



function hidetips(){

	$("#tips").hide();

    $("#tips").unbind("authheight");

}

$(function(){	

	

	function authheight(){

		if($(window).height()>=600){

			player_height = player_height + 50;

		}

		$('#wrap,#player').height(player_height);

		$('#wrap iframe').height(player_height);

		$('#play').height(player_height);
		//商品列表页
		var tabHeight = $(window).innerHeight() - $('#tab').offset().top;
		$('#tab').height( tabHeight);
	}

		authheight();
		//$('#chat-msglist').scrollTop($('#chat-msglist')[0].scrollHeight);

		$("#chat-msglist").scrollTop('100%');
	
		$('#ent_focus').click(function(){

		$("#guanzhu_pop").show();



	});

	

	

})

</script>
<?php  if($limit && $item['limit'] == 1 && $item['password'] != $viewer['password']) { ?>
<div class="redbag_box redbagBox" style="z-index:100;display:block;" id="limit1">
    <div class="main_box_4 redbag centerwin" id="redbag" style="height:25%;">
        <div class="redbag_inbox">
			<h1 style="font-size:2rem;">密码</h1>
    		<div class="inputqy">
			  <input type="text" id="password" placeholder="请填入观看密码" />
            </div>
            <div class="but_con" style="margin-bottom: 1rem;">
                <button class="button_yes btn btn-success" onClick="limit(<?php  echo $item['limit'];?>)" style="display: block;margin: 0 auto; width: 60px; background: #5cb85c; color: #FFF;  height: 2rem; line-height: 1.1rem;  padding: 6px 0;  border-radius: 3px;  font-weight: 200;">确定</button>
            </div>
        </div>
    </div>
</div>
<?php  } else if($limit && (($item['limit'] == 2 && $paylog['status']!=1) || ($item['limit'] == 3 && $paylog['status']!=1 && ($limit_time - time())<0))) { ?>
<div class="redbag_box redbagBox" style="z-index:100;display:block;" id="limit2">
    <div class="main_box_4 redbag centerwin" id="redbag" style="height:25%;width:22rem;">
        <div class="redbag_inbox">
			<h1 style="font-size:2rem;">付费</h1>
    		<div class="inputqy">
			  <h4 style="text-align:center;margin:10px 0 10px 0">该直播需付费<font color=red><?php  echo ($item['amount']/100)?></font>元才可观看</h4>
            </div>
            <div class="but_con" style="margin-bottom: 1rem;">
                <button class="button_yes btn btn-success" onClick="limit(<?php  echo $item['limit'];?>)" style="display: block;margin: 0 auto; width: 60px; background: #5cb85c; color: #FFF;  height: 2rem; line-height: 1.1rem;  padding: 6px 0;  border-radius: 3px;  font-weight: 200;">支付</button>
            </div>
        </div>
    </div>
</div>
<?php  } else if($limit && ($item['limit']==4 && ($item['password'] != $viewer['password'] || $paylog['status']!=1))) { ?>
<div class="redbag_box redbagBox" style="z-index:100;display:block;" id="limit4">
    <div class="main_box_4 redbag centerwin" id="redbag" style="height:25%;">
        <div class="redbag_inbox">
			<h1 style="font-size:2rem;">密码付费</h1>
    		<div class="inputqy">
				<input type="text" id="password" placeholder="请填入观看密码" />
			  <h4 style="text-align:center;margin:10px 0 10px 0">该直播需付费<font color=red><?php  echo ($item['amount']/100)?></font>元才可观看</h4>
            </div>
            <div class="but_con" style="margin-bottom: 1rem;">
                <button class="button_yes btn btn-success" onClick="limit(<?php  echo $item['limit'];?>)" style="display: block;margin: 0 auto; width: 85px; background: #5cb85c; color: #FFF;  height: 2rem; line-height: 1.1rem;  padding: 6px 0;  border-radius: 3px;  font-weight: 200;">确定并支付</button>
            </div>
        </div>
    </div>
</div>
<?php  } ?>
<?php  $settings = iunserializer($dashangsetting['settings'])?>
<div class="redbag_box redbagBox dashang" style="z-index:100;">
    <div class="main_box_4 redbag centerwin" id="redbag">
        <div class="redbag_inbox">
			<div style="position:absolute; width:34px; height:32px; top:4px; right:0px;" onClick="jQuery('.dashang').hide()"><img src="<?php echo MODULE_URL;?>template/mobile/img/close_hongbao.png" style="width:17px; height:auto;" /></div>
            <div class="live_redbag">
                <a href="javascript:;" class="gene_btn redbag_cancel"></a>
                <div class="live_headpic"><img src="<?php  echo tomedia($dashangsetting['logo'])?>"></div>
                <div class="live_towho"></div>
                <div class="live_towhy"><?php  echo $dashangsetting['content'];?></div>
                <div class="live_redbaglist">
                    <ul class="clearfix">
						<input type="hidden" id="dsvalue" value="">
                        <li><a class="rglist dsmoney" href="javascript:;"><var class="rglist " style="font-size:2.1rem;"><?php  echo ($settings['one']/100)?></var>元</a></li>
                        <li><a class="rglist dsmoney" href="javascript:;"><var class="rglist " style="font-size:2.1rem;"><?php  echo ($settings['two']/100)?></var>元</a></li>
                        <li><a class="rglist dsmoney" href="javascript:;"><var class="rglist " style="font-size:2.1rem;"><?php  echo ($settings['three']/100)?></var>元</a></li>
                        <li><a class="rglist dsmoney" href="javascript:;"><var class="rglist " style="font-size:2.1rem;"><?php  echo ($settings['four']/100)?></var>元</a></li>
                        <li><a class="rglist dsmoney" href="javascript:;"><var class="rglist " style="font-size:2.1rem;"><?php  echo ($settings['five']/100)?></var>元</a></li>
                        <li><a class="rglist dsmoney" href="javascript:;"><var class="rglist " style="font-size:2.1rem;"><?php  echo ($settings['six']/100)?></var>元</a></li>
                    </ul>
                </div>
                <!-- <div class="live_othermoney"><a href="javascript:;" class="rglist" id="pay"> 赏 </a></div> -->
            </div>
        </div>
    </div>
</div>

<script>

$(function(){
	
	$(".dsmoney").click(function(){
		var money = $(this).find('.rglist').text();
		if(isNaN(Number(money))){
			showtips('请输入正常的打赏金额');
			return false;
		}
		if(Number(money)=='' || Number(money)<=0){
			showtips('请输入正常的打赏金额');
			return false;
		}else if(Number(money)>200){
			showtips('打赏金额不能大于200元');
			return false;
		}

		$.ajax({
			type:'post',
			data:{'amount':money},
			url:"<?php  echo $this->createMobileurl('ds',array('rid'=>$rid))?>",
			dataType:"json",
			//async:false,
			success: function(json){
				if(json.s=='1'){
					var e = json.msg;
					WeixinJSBridge.invoke(
					   'getBrandWCPayRequest', {
						   "appId":e.appId,         
						   "timeStamp": ""+e.timeStamp ,             
						   "nonceStr": e.nonceStr,   
						   "package":e.package,     
						   "signType":e.signType,             
						   "paySign":e.paySign
					   },
					   function(res){  
							if(res.err_msg == "get_brand_wcpay_request:ok") {
								$(".dashang").hide();
							}else{
								if(res.err_msg == "get_brand_wcpay_request:cancel"){
									var tips = '你取消了支付';
								}else{
									var tips = '支付失败';
								}
								$(".dashang").hide();
								showtips(tips);	
							}
					   }
				   );   
				}else{
					showtips(json.msg);
				}
			}	
		})
	})
})

</script>




<div class="toolmenu" style="display: block;     z-index: 2; height: 5rem;  margin: auto;   bottom: 118px;   right: 15px;">

	<div class="rel side-icon" style="text-align:center;">

		<?php  if((($item['reward']==1 && $packet['type']==2) || $item['tx']==1) && strpos($user_agent, 'MicroMessenger') !== false) { ?>

		<img src="<?php echo MODULE_URL;?>template/mobile/images/qianghongbao.png" style="width:3.5rem;display:block;right: 0px; position: absolute;top:53px;" class="animation-shake qianghongbao resizefit" onClick="$('.on_div_01').show()">

		<?php  } ?>

		<?php  if($dashangsetting['isshow']== 1 && strpos($user_agent, 'MicroMessenger') !== false) { ?>
		<a class="shangzhubo onlybtn icon-live-shang"  onClick="$('.dashang').show();"><img src="<?php echo MODULE_URL;?>template/mobile/img/shang.png" style="width:3.5rem;display:block;right: 0px; position: absolute;top:10px;" class="animation-shake qianghongbao resizefit"></a><?php  } ?>
	</div>

</div>





<script>

$(function(){

	

    $('.send_msg').click(function(){

		var content = $(this).parent().parent().find(".content_msg").val();

		var id = $(this).parent().parent().find(".msg_id").val();

		if(content==''){

			showtips("评论内容不能为空！");

			return false;

		}

		$(this).parent().parent().find(".content_msg").val('');

		$(this).parent().parent().find(".msg_id").val('');

		$(this).parent().parent().find(".content_msg").attr('placeholder','我要说两句');

         $.ajax({

             type: "POST",

             url: "<?php  echo $this->createMobileurl('sub',array('rid'=>$rid))?>",

             data: {content:content,toid:id},

             dataType: "json",

             success: function(data){

				 if(data != '提交成功'){

					 showtips(data);

				 }

             }

           });

    });

});

$(function(){ 

	setTimeout("livepic()",8000);

}); 

function livepic(){

	var lastid=$('#lastid').val();

	var replyid=$('#replyid').val();

	$.ajax({

        url: '<?php  echo $this->createMobileUrl('getlivepic', array('rid'=>$rid,'randomaa'=>mt_rand(1000, 9999)))?>',

        type: 'POST',

        dataType: 'json',

        data: {replyid: replyid,lastid:lastid,randomshu:Math.random()},

        success: function (result) {
        	if(result.status==1){
        		$('#livepic').prepend(result.lhtml);
				
        		$('#chat-msglist').prepend(result.rhtml);

        		$('#lastid').val(result.lastid);

        		$('#replyid').val(result.replyid);

				if(result.mrhtml){
					$.each( result.mrhtml, function( key, val ) {
					console.log('#hongbao_'+key);
					console.log(val);
					$('#msg_'+key).append(val);
					});
				}
				//scrollContentBox();
        	}
        	dingshi2=setTimeout("livepic()",5000);

        }

    });

}



function send_fees(){

	var hb_id = $("#hb_money").val();



	$.ajax({

		 type: "GET",

		 url: "<?php  echo $this->createMobileUrl('sends',array('rid'=>$rid))?>",

		 data:{ hb_id: hb_id },

		 dataType: "json",

		 success: function(data){

			 if(data.type == -10){

				layer.open({

				  content: data.msg+"<br><br><img src='<?php  echo tomedia($setting['attention_code'])?>' style='width:200px'><br><font style='font-size:12px'>长按识别二维码，可快速关注</font>"

				  ,style: 'background-color:#FFF; color:#000; border:none;font-size:20px;width:auto;' //自定风格

				  ,time: 2

				});

				

			 }else{

				 if(data.type!=1){

					showtips(data.msg);

				 }else{

					

					$("#sned_name").html(data.name+'的红包');

					$("#revice_amount").html(data.amount);

					$("#send_num").html('领取'+data.num+'个');

					$("#sned_log").html(data.hhtml);

					$("#send_headurl").attr('src',data.headimgurl);

					$("#hongbao_"+hb_id).prepend(data.html);

					$("#selecthongbao_"+hb_id).attr('onClick',"jQuery('.in_liaotian_hb').show();");



					$("#donghua_hongbao").addClass("new_class_hongbao");



					

				setTimeout(function () {$('.in_liaotian_hb').fadeIn(); }, 1000);



					

				setTimeout(function () {$('.on_liaotian_hb').fadeOut(); }, 1300);



					

				setTimeout(function () {$('#donghua_hongbao').removeClass("new_class_hongbao"); }, 1300);

	

				 }

				 

			 }

			 

		 }

	 });

}



function gethbshow(hb_id){

	$.ajax({

		 type: "GET",

		 url: "<?php  echo $this->createMobileUrl('gethb',array('rid'=>$rid))?>",

		 data:{ hb_id: hb_id },

		 dataType: "json",

		 success: function(data){

			$("#sned_name").html(data.name+'的红包');

			$("#revice_amount").html(data.amount);

			$("#send_num").html('领取'+data.num+'个');

			$("#sned_log").html(data.hhtml);

			$("#send_headurl").attr('src',data.headimgurl);

			$('.in_liaotian_hb').show();

		 }

	 });

}



function send_fee(){

	$.ajax({

		 type: "GET",

		 url: "<?php  echo $this->createMobileUrl('send',array('rid'=>$rid,'type'=>2))?>",

		 dataType: "json",

		 success: function(data){
			
		
			if(data.type == -10){

				layer.open({

				  content: data.msg+"<br><br><img src='<?php  echo tomedia($setting['attention_code'])?>' style='width:200px'><br><font style='font-size:12px'>长按识别二维码，可快速关注</font>"

				  ,style: 'background-color:#FFF; color:#000; border:none;font-size:20px;width:auto;' //自定风格

				  ,time: 2

				});

			 }else{
				

			 if(data.type !=1){
					

				$("#donghua_hongbao").unbind();
	

				showtips(data.msg);	

			}else{
					

				layer.open({

				  content: data.msg

				  ,style: 'background-color:#FFF; color:#000; border:none;font-size:20px;width:auto;' //自定风格

				  ,time: 2

				});		

				}
				

			 }
		 }

	 });

}

</script>

<!-- 规格弹框start -->
<div class="j-mutimask mask" style="display:none;"></div>
<div id="muti-dialog" class="simpledialog mutidialog" style="display: none;">
	<span id="muti-close" class="muti-close"></span>
	<div class="j-muti-wrap muti-wrap" style="max-height: 533.6px;">
		<div class="muti-food-title"></div>
		<div class="j-muti-cont muti-cont">
			<div class="muti-cont-inner" style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
				<div class="muti-sec">
				</div>
			</div>
		</div>
		<div class="muti-choose">
			<div class="muti-oprt" data-id="">
				<div class="muti-cart-btn" onclick="muti_cart_btn()">加入购物车</div>
			</div>
			<div class="muti-info"><span class="muti-price">¥</span><!--<span class="muti-type">(香草)</span>-->
			</div>
		</div>
	</div>
</div>
<!-- 底部购物车 -->
<div id="cart-wrap" style="display:none;">
	<div id="cart" class="cart">
		<div class="cart-tip">
			<?php  if($cart_total['number'] > 0) { ?>
			<div class="j-cart-icon cart-icon">
				<i class="j-ico-cart ico-cart ico-cart-active"></i>
				<div class="j-cart-num cart-num"><?php  echo $cart_total['number'];?></div>
			</div>
			<div class="j-cart-noempty cart-noempty">
				<span class="j-cart-price cart-price">¥<?php  echo $cart_total['amount'];?></span>
				<br>
				<span class="cart-shipping">配送费以订单为准</span>
			</div>
			<?php  } else { ?>
			<div class="j-cart-icon cart-icon">
				<i class="j-ico-cart ico-cart"></i>
			</div>
			<div class="j-cart-empty cart-empty">购物车空空如也～</div>
			<?php  } ?>
		</div>
		<div class="cart-btns" style="<?php  if($cart_total['number'] == 0) { ?>display:none;<?php  } ?>">
			<a class="cart-btn-confirm j-cart-btn-confirm" href="<?php  echo murl('entry//checkout',array('m'=>'wxz_store', 'mfrom' => 'wzb', 'wrid' => $rid),true)?>" data-resource="1"><span class="inner">去结算</span></a>
			
		</div>
	</div>
</div>
<style>
.pop{
	z-index:99999;
}
</style>
<!--end-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('share2', TEMPLATE_INCLUDEPATH)) : (include template('share2', TEMPLATE_INCLUDEPATH));?>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=wxz_wzb"></script></body>

</html>



