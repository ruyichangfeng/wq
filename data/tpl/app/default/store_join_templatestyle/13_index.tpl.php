<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php  echo $items['top_title']?></title>
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="<?php echo CSS_URL;?>mui.min.css">
		<link rel="stylesheet" href="<?php echo CSS_URL;?>style.css">
		<link rel="stylesheet" href="<?php echo CSS_URL;?>join.css">
		<link rel="stylesheet" href="<?php echo CSS_URL;?>sweetalert.css">
		<?php  echo register_jssdk(false);?>
		<script src="../app/resource/js/require.js"></script>
        <script src="../app/resource/js/app/config.js"></script>
        <script type="text/javascript" src="<?php echo JS_URL;?>jweixin-1.0.0.js"></script>
		<script type="text/javascript" src="<?php echo JS_URL;?>jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo JS_URL;?>sweetalert.min.js"></script>
	    
	</head>

	<style>
	
	</style>

	<body style="margin: 0;padding: 0;overflow:hidden;">
		<div class="mypage1">
			<img src="<?php  echo tomedia($items['background_images']);?>" width="100%" height="220px;">
		</div>
		<div class="mypage2">
          
           
			<!--LOGO-->
			<div class="face">
				<div style="position:relative;z-index:99;">
				
					<a href="<?php  echo $items['nav_url'];?>"><img class="" src="<?php  echo tomedia($items['nav_icon']);?>"  onerror="this.src='http://7xvfxg.com1.z0.glb.clouddn.com/nav.png'" width="35" height="35"  size="200" style="margin-left: -103%;margin-top: 32%;text-align: right;z-index:99999999;background-color: <?php  echo $items['button_color']?>;" /></a>
				</div>
				<button type="button" class="am-btn am-btn-default am-round" style="margin-left: -82%; border-radius:0px 1000px 1000px 0px;margin-top:-48%;text-align:center;font-size:15px;width: 80px;height: 30px;padding: 0em 0.5em;background-color: <?php  echo $items['button_color']?>;color:<?php  echo $items['link_color1']?>;"><?php  echo $items['nav_link']?></button>

				<img src="<?php  echo tomedia($items['logo']);?>" width="100%" height="119px;">

				<div style="position:relative;z-index:99;">
					<?php  if(empty($items['tel_icon'])) { ?>
					
					<a  href="tel:<?php  echo $items['tel_url'];?>"><img  src="http://7xvfxg.com1.z0.glb.clouddn.com/tel.png"  width="35" height="35" style="margin-left: 175%;margin-top: -69%;background-color: <?php  echo $items['button_color']?>;" /></a>
					<?php  } else { ?>
					<a  href="tel:<?php  echo $items['tel_url'];?>"><img  src="<?php  echo tomedia($items['tel_icon']);?>" width="35" height="35" style="margin-left: 175%;margin-top: -69%;background-color: <?php  echo $items['button_color']?>;" /></a>
					<?php  } ?>
				</div>
				<button type="button" class="am-btn am-btn-default am-round" style=" border-radius:1000px 0px 0px 1000px;margin-left: 115%;text-align:center;font-size:15px;margin-top:-48%;width: 80px;height: 30px;padding: 0em 0.2em;font-family:'微软雅黑';background-color: <?php  echo $items['button_color']?>;color:<?php  echo $items['link_color1']?>"><?php  echo $items['tel_link']?></button>
                
			</div>
			<!---->
		</div>

		<!--公告-->
		<p style="20px;">
			<div class="notice" style="margin: 0px auto;padding: 0px;width: 97%;margin-top:40px;border-radius: 5px;">
				<div class="title">
					<span style="background-color:<?php  echo $items['button_color']?>;color: #fff;border-radius: 10%;padding: 0px 5px;">公告</span>
				</div>
				<div class="content" style="width: 80%;">
					<marquee class="tip" scrollamount="5" style="color: red;font-size: 15px;height: 30px;line-height: 30px;font-family:'微软雅黑';color:<?php  echo $items['link_color']?>"><?php  echo $items['context']?></marquee>
				</div>
			</div>
		</p>

		<section class="ui-container ui-center" style="border-radius: 2%;background-color: #ffffff;height:300px;margin-top: -20px;width: 97%;margin: 0 auto;padding: 0px;margin-top: 10px;">
			<br>
		<ul>
			<li class="mui-table-view-cell" style="text-align: center;list-style: none;margin-top: -15px;">
				<span style="font-size: 20px;margin-top:-15px;font-family:'微软雅黑'">
					 <?php  echo $items['title1']?>		</span>
				<span style="font-size: 15px;color: #BDBDBD;font-family:'微软雅黑'">
					  <?php  echo $items['title2']?>				</span>

				<hr />
			</li>
       </ul>
			<p><input type="text" id="zname" name="zname" class="am-form-field am-round" style="width: 80%;border-color: #d3d5d2;margin-left: 10%;font-family:'微软雅黑'" placeholder="请输入你的姓名" /></p>
			<p><input type="text" id="zphone" name="zphone" class="am-form-field am-round" style="width: 80%;border-color: #d3d5d2;margin-left: 10%;font-family:'微软雅黑'" placeholder="请输入你的联系电话" onclick="demo()"/></p>
			<p><input type="text" id="ds"  name="zmessage" class="am-form-field am-round" style="width: 80%;border-color: #d3d5d2;margin-left: 10%;font-family:'微软雅黑'" readonly="true"  placeholder="请输入你的留言" onclick="show();" /></p>
			<p><input type="button"  class="am-form-field am-round" style="width: 80%;height:40px;font-size:15px;margin-left: 10%;color:#fff;background-color:<?php  echo $items['button_color']?>;border-color: <?php  echo $items['button_color']?> ;font-family:'微软雅黑'" readonly="true"  value="马上提交" onClick="chang();" /></p>

			<div class="mui-content-padded" style="text-align: center;">
				<p style="color: #b1b1b1; font-size: 12px;font-family:'微软雅黑'"><?php  echo $items['copyright']?></p>
			</div>
			
			
			<div class="mui-content-padded" id="tan" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 200px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<img src="<?php echo IMAGES_URL;?>close.png" width="45" height="45"  style="margin: 0px;padding: 0px;float: right;" onclick="demo()">
					<textarea class="mui-btn mui-btn-outlined" id="zmessage" onfocus="if(value=='请在此处输入您的留言 …'){value=''}"
   					 onblur="if (value ==''){value='请在此处输入您的留言 …'}" style="background-color: #fff;width:96%;height: 100px; margin-top: 0px;">请在此处输入您的留言 …</textarea>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #fff;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="find()">
					确 认 提 交
				    </button>

				</div>
			</div>
			
			<div class="mui-content-padded" id="succee" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 220px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<br />
					<div id="zmessage" style="background-color: #f6f6f6;width: 95%;height: 135px;margin: 0 auto;position:relative;z-index: 99999;margin-top: 10px;">
						<img src="<?php echo IMAGES_URL;?>succee.png" width="90" height="90" style="float: cent;color: <?php  echo $items['button_color']?>;background-color:<?php  echo $items['button_color']?> ;" >
					<div style="margin-top: 20px;"><span style="text-align: center;font-size:12px;color: <?php  echo $items['button_color']?>">您已提交成功，请耐心等候回复！</span></div>
					</div>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #f6f6f6;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="back()">
					确认
				  </button>
				</div>
			</div>
			
			<div class="mui-content-padded" id="fail" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 220px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<br />
					<div id="zmessage" style="background-color: #f6f6f6;width: 95%;height: 135px;margin: 0 auto;position:relative;z-index: 99999;margin-top: 10px;">
						<img src="<?php echo IMAGES_URL;?>fail.png" width="90" height="90" style="float: cent;color: <?php  echo $items['button_color']?>;background-color:<?php  echo $items['button_color']?> ;" >
					<div style="margin-top: 20px;"><span style="text-align: center;font-size:12px;color: <?php  echo $items['button_color']?>">提交失败，请返回填写完整内容。</span></div>
					</div>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #f6f6f6;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="back_name()">
					确认
				  </button>
				</div>
			</div>
			
			<div class="mui-content-padded" id="tel" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 220px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<br />
					<div id="zmessage" style="background-color: #f6f6f6;width: 95%;height: 135px;margin: 0 auto;position:relative;z-index: 99999;margin-top: 10px;">
						<img src="<?php echo IMAGES_URL;?>fail.png" width="90" height="90" style="float: cent;color: <?php  echo $items['button_color']?>;background-color:<?php  echo $items['button_color']?> ;" >
					<div style="margin-top: 20px;"><span style="text-align: center;font-size:12px;color: <?php  echo $items['button_color']?>">请输入正确的手机号！</span></div>
					</div>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #f6f6f6;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="back_tel()">
					确认
				  </button>
				</div>
			</div>
			
			<div class="mui-content-padded" id="fail_name" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 220px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<br />
					<div id="zmessage" style="background-color: #f6f6f6;width: 95%;height: 135px;margin: 0 auto;position:relative;z-index: 99999;margin-top: 10px;">
						<img src="<?php echo IMAGES_URL;?>fail.png" width="90" height="90" style="float: cent;color: <?php  echo $items['button_color']?>;background-color:<?php  echo $items['button_color']?> ;" >
					<div style="margin-top: 20px;"><span style="text-align: center;font-size:12px;color: <?php  echo $items['button_color']?>">请输入姓名！</span></div>
					</div>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #f6f6f6;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="back_name()">
					确认
				  </button>
				</div>
			</div>
			
			<div class="mui-content-padded" id="con" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 220px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<br />
					<div id="zmessage" style="background-color: #f6f6f6;width: 95%;height: 135px;margin: 0 auto;position:relative;z-index: 99999;margin-top: 10px;">
						<img src="<?php echo IMAGES_URL;?>fail.png" width="90" height="90" style="float: cent;color: <?php  echo $items['button_color']?>;background-color:<?php  echo $items['button_color']?> ;" >
					<div style="margin-top: 20px;"><span style="text-align: center;font-size:12px;color: <?php  echo $items['button_color']?>">请输入您的留言!</span></div>
					</div>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #f6f6f6;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="back_con()">
					确认
				  </button>
				</div>
			</div>
			
			<div class="mui-content-padded" id="fails" style="display: none;text-align: center;background-color:<?php  echo $items['button_color']?>;width: 95%;height: 220px;opacity: 0.8;
				filter:alpha(opacity=80);position:relative;z-index: 99999;margin-top: -400px;margin-left: 2%;">
				<div>
					<br />
					<div id="zmessage" style="background-color: #f6f6f6;width: 95%;height: 135px;margin: 0 auto;position:relative;z-index: 99999;margin-top: 10px;">
						<img src="<?php echo IMAGES_URL;?>fail.png" width="90" height="90" style="float: cent;color: <?php  echo $items['button_color']?>;background-color:<?php  echo $items['button_color']?> ;" >
					<div style="margin-top: 20px;"><span style="text-align: center;font-size:12px;color: <?php  echo $items['button_color']?>">请输入您的留言!</span></div>
					</div>
					<button type="button" class="mui-btn mui-btn-outlined" style="margin-top:5px;background-color: #f6f6f6;width: 95%;padding: 10px;font-family:'微软雅黑';color: <?php  echo $items['button_color']?>;" onclick="fails()">
					确认
				  </button>
				</div>
			</div>
  
		</section>
 
 		<div id="ma" style="display: none;text-align: center;background-color:#f6f6f6;width: 100%;height: 100%;opacity: 0;z-index: 888888;margin: 0 auto;padding: 0px;margin-top: -161%;">
				
			</div>
			<input type="hidden" value="<?php  echo $openid;?>" id="open"/>
			<input type="hidden" value="<?php  echo $items['top_title'];?>" id="title"/>
</html>

<script>
		function show() {
			var input = document.getElementById("ds");
            input.blur();
            document.getElementById("ma").style.display = "";
			document.getElementById("tan").style.display = "";
		}
		
		function demo() {
			document.getElementById("tan").style.display = "none";
			 document.getElementById("ma").style.display = "none";
		}
		
		function back() {
			window.location.href = "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('index'),2)?>";
		}
		
		
		function back_tel() {
			document.getElementById("tel").style.display = "none";
			document.getElementById("ma").style.display = "none";
		}
		
		function back_name() {
			document.getElementById("fail_name").style.display = "none";
			document.getElementById("ma").style.display = "none";
		}
		
		function back_con() {
			document.getElementById("con").style.display = "none";
			document.getElementById("ma").style.display = "none";
			document.getElementById("tan").style.display = "";
		}
		
		function fails() {
			document.getElementById("fails").style.display = "none";
			document.getElementById("ma").style.display = "none";
			document.getElementById("tan").style.display = "";
		}

	function find() {
		var zname = $('#zname').val();
		var zphone = $('#zphone').val();
		var zmessage = $('#zmessage').val();
		var open = $('#open').val();
        var title = $('#title').val();
        if(zname==''){	
					document.getElementById("tan").style.display = "none";
			        document.getElementById("ma").style.display = "";
					document.getElementById("fail_name").style.display = "";
        }else if(!(/^1[3|4|5|7|8]\d{9}$/.test(zphone))){
        			document.getElementById("tan").style.display = "none";
					document.getElementById("ma").style.display = "";
					document.getElementById("tel").style.display = "";
        }else{
		$.ajax({
			url: "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('message'),2)?>",
			data: {
				zname: zname,
				zphone: zphone,
				zmessage: zmessage,
				open:open,
				title:title,
			},
			dataType: 'text',
			type: 'post',
			success: function(data) {
				if(data == 1) {
					document.getElementById("tan").style.display = "none";
					document.getElementById("ma").style.display = "";
					document.getElementById("succee").style.display = "";
				} else {
					document.getElementById("tan").style.display = "none";
					document.getElementById("ma").style.display = "";
					document.getElementById("fails").style.display = "";
				}
				
			},
			
			error: function() {
				swal("失败");
			}
			
		});
	}
	}
	
	
	function chang() {
		var zname = $('#zname').val();
		var zphone = $('#zphone').val();
		var zmessage = $('#zmessage').val();
		if(zname==""){
		document.getElementById("ma").style.display = "";
		document.getElementById("fail_name").style.display = "";
		}else if(zphone==""){
		document.getElementById("ma").style.display = "";
		document.getElementById("tel").style.display = "";
		}else{
		document.getElementById("ma").style.display = "";
		document.getElementById("con").style.display = "";
		}
	
	}
	
	  var sharedata = {
                            title: '<?php  echo $items['share_title'];?>',
                                    desc: '<?php  echo $items['share_context'];?>',
                                    link: window.location.href,
                                    imgUrl: '<?php  echo tomedia($items['share_logo']);?>',
                                    success: function() {
                                    alter("分享成功");
                                    },
                                    cancel: function() {
                                    alter("分享失败");
                                    }
                            };
                            wx.ready(function() {
                            wx.onMenuShareAppMessage(sharedata); //分享给朋友
                                    wx.onMenuShareTimeline(sharedata); //分享到朋友圈
                                    wx.onMenuShareQQ(sharedata); //分享到QQ
                                    wx.onMenuShareWeibo(sharedata); //分享到腾讯微博
                                    wx.onMenuShareQZone(sharedata); //分享到QQ空间
                            });


	
</script>

<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script> 

   