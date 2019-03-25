<?php defined('IN_IA') or exit('Access Denied');?><html lang="en"><head>
	<meta charset="UTF-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
	<title><?php  echo $cfg['UI']['find'];?></title>
	<link rel="stylesheet" href="<?php echo RES;?>css/media.css?v=052809457">
	<style type="text/css">
	*{
	  padding: 0;
	  margin:0;
	  -webkit-appearance:none;
	  list-style: none;
		text-decoration: none;
	}
	*: not(input, textarea) {
	    -webkit - touch - callout: none;
	    -webkit - user - select: none;
	}
	body {
	  padding: 0;
	  border: 0;
	  margin: 0;
	  height: 100%;
	  font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
	  background-color: #F9F9F7;
	  cursor:pointer;
	  text-shadow: none;
	   -webkit-tap-highlight-color:rgba(0,0,0,0); 
	}
	input{
		border:0;
		outline:none;
	}
	html {
	  overflow:scroll;
	  font-family: "黑体", arial, helvetica, sans-serif !important;
	}
	.match_top {
	  width: 100%;
	  height: 2rem;
	  position: relative;
	  background: #FFFFFF;
	  box-shadow: 0px 1px 0px 0px #E0E0E0;
	  display: block;
	}
	.match_top>p{
	font-size: 0.825rem;
	  color: #2DC8DA;
	  text-indent: 51%;
	  line-height: 2.1rem;
	}

	.match_top .match_img {
	  height: 1.2rem;
	  width: auto;
	  position: absolute;
	  left: 39%;
	  top: 50%;
	  margin-top: -0.6rem;
	}
	.match_article {
	  width: 93%;
	  height: 5rem;
	  border-radius: 8px;
	  margin: 0 auto;
	  margin-top: 0.4rem;
	  position: relative;
	  display: block;
	}
	.new_btn {
	  width: 1.2rem;
	  height: 1.2rem;
	  position: absolute;
	  right: 20%;
	  border-radius: 50%;
	  bottom: 5%;
	  z-index: 999;
	  overflow: hidden;
	}
	.match_article .article_title {
		    font-size: 0.725rem;
  /* top: 24%; */
  position: absolute;
  left: 80%;
  bottom: 8%;
  color: white;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  z-index: 1;
	}
	.article_dec{
  width: 90%;
  height: 2.5rem;
  margin: 0 auto;
  color: white;
  font-size: 1rem;
  font-family: PingFangSC-Medium;
  font-size: 19px;
  color: #FFFFFF;
  /* letter-spacing: 0.23px; */
  padding-top: 0.625rem;
  position: absolute;
  left: 5%;
  z-index: 1;
	}
	.articles_container{
		margin-bottom:1rem;
	}


	.loading {
	  width: 100%;
	  height: 2.45rem;
	  position: relative;
	  color:#A8A8A8;
	  display: none;
	  margin-top:10px;
	}
	.loading>p{
	  font-size: 0.825rem;
	  text-indent: 45%;
	  line-height: 2.45rem;
	}

	.loading .loading_img {
	  height:1.47rem;
	  width: auto;
	  position: absolute;
	  left: 30%;
	  top: 50%;
	  margin-top:-0.735rem;
	  -webkit-animation: reverseRotataZ 2s linear infinite;
	}
	@-webkit-keyframes reverseRotataZ{
	  0%{
	    -webkit-transform: rotateZ(0deg);
	  }
	  100%{
	    -webkit-transform: rotateZ(360deg);
	  }
	}
	.zhezhao{
		width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.29);
  position: absolute;
  top: 0; 
	}
	</style>
</head>
<body>
<div class="match_top">
	<img src="<?php  echo toimage($cfg['UI']['findimg'])?>" class="match_img">
	<p><?php  echo $cfg['UI']['find'];?></p>
</div>
<div class="articles_container">
	<?php  if(is_array($list)) { foreach($list as $item) { ?>
	<div class="match_article" data="niyuanyi" style="background:url(<?php  echo $item['cover'];?>) no-repeat;  background-position: center;background-repeat: no-repeat;background-size: cover;">
		<a href="<?php  echo $this->createMobileUrl('MyWorks',array('mid'=>$item['mid']))?>">
			<img src="<?php  echo $item['avatar'];?>" alt="" class="new_btn">
			<div class="article_title"><?php  echo $item['nickname'];?></div>
		</a>
		<a href="<?php  echo $this->createMobileUrl('MyWorks',array('wid'=>$item['id']))?>&faxianShow=true"><p class="article_dec"><?php  echo $item['title'];?></p></a>
		<div class="zhezhao"></div>
	</div>
	<?php  } } ?>
</div>
<div class="loading" style="display: none;">
	<img src="<?php echo RES;?>images/loading.png" class="loading_img">
	<p>加载中...</p>
</div>	
<script src="<?php echo RES;?>js/jquery.min.js?v=052809457"></script>
<script type="text/javascript">
var page = 3;
var ajax = false;
$(window).scroll(function(){
　　var scrollTop = $(this).scrollTop();
　　var scrollHeight = $(document).height();
　　var windowHeight = $(this).height();
　　if(scrollTop + windowHeight == scrollHeight){
		if(ajax) return ;
		ajax = true;
　　　　$('.loading').show();
		page++;
		//加载
		$.post("<?php  echo $this->createMobileUrl('FindList')?>",
		    {
		      page:page
		    },
		    function(data){
		      if(data.status == "ok"){
		      	  var list = data.list;
			      var content = "";
			      for(var i=0;i<list.length;i++){
		            content += "<div class='match_article' data='niyuanyi' style='background:url("+list[i].cover+") no-repeat;background-position: center;background-repeat: no-repeat;background-size: cover;'>";
		            content += "<a href='<?php  echo $this->createMobileUrl('MyWorks')?>&mid="+list[i].mid+"' ><img src='"+list[i].avatar+"' alt='' class='new_btn'>";
		            content += "<div class='article_title' >"+list[i].nickname+"</div></a>";
		            content += "<a href='<?php  echo $this->createMobileUrl('MyWorks')?>&wid="+list[i].id+"&faxianShow=true'><p class='article_dec'>"+list[i].title+"</p></a>";
		            content += "<div class='zhezhao'></div>"; 
		            content += "</div>"; 
	        	  }
	        	  $('.articles_container').append(content);
	        	  $('.loading').hide();
	        	  ajax = false;
		      }else{
		      	$('.loading').hide();
		      	ajax = true;
		      	return;
		      }
	    	},"json"
	    );
　　}
});
</script>	
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=20150120"></script>
<script type="text/javascript">
        var shareData = {
        	      title: "<?php  echo $cfg['qs_title'];?>",
        	      link: "<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=findlist&m=junsion_simpledaily",
        	      desc: "<?php  echo $cfg['qs_desc'];?>",
                  imgUrl: "<?php  echo toimage($cfg['qs_thumb'])?>",
        	   };
        jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || { jsApiList:[] };
        jssdkconfig.debug = false;
        jssdkconfig.jsApiList = ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','showOptionMenu','chooseWXPay'];
    	wx.config(jssdkconfig);
        	wx.ready(function () {
        	    wx.onMenuShareAppMessage(shareData);
        	    wx.onMenuShareTimeline(shareData);
        	    wx.onMenuShareQQ(shareData);
        	    wx.onMenuShareWeibo(shareData);
        	    
        	});
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=junsion_simpledaily"></script></body>
</html>