<?php defined('IN_IA') or exit('Access Denied');?><html><head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" id="viewport">
		<meta name="viewport" content="target-densitydpi=get-target-densitydpi, width=device-width, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		
		<title><?php  echo $item['title'];?></title>
		<link href="<?php echo MODULE_URL;?>template/mobile/2/css/common.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/2/css/mui.css">
		<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>template/mobile/2/css/swiper.min.css">
		<link rel="stylesheet" href="<?php echo MODULE_URL;?>template/mobile/2/css/indexstyle.css">
		<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>template/mobile/2/css/indexstyleadd.css">
		<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>template/mobile/2/css/reset.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>template/mobile/2/css/main.css"/>
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src=" https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/tis-api-1.1.js"></script>
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/tis-1.1.js"></script>
		<script>
		window.alert = function (e) {  
			if (e != null && e.indexOf("提示内容")>-1){  
			}else {  
			}     
		};

			function getQueryStr(str) {
				var LocString = String(window.document.location.href);
				var rs = new RegExp("(^|)" + str + "=([^&]*)(&|$)", "gi").exec(LocString), tmp;
				if (tmp = rs) {
					return decodeURIComponent(tmp[2]);
				}
				return "";
			}
		var pageTimer={};
		function enter(msg,timer){
			for(var each in pageTimer){
				clearInterval(pageTimer[each]);
			}
			if ( $(".gun").length > 0 ) {
				$(".left-enter").css("top",2+"rem");
			}else{
				$(".left-enter").css("top",0);
			}
			$(".left-enter").css("display","block");
			document.getElementById('enter-name').innerText = msg;
			pageTimer["timer1"]=setTimeout(function () {
				$(".left-enter").css("display","none");
			},timer)
		}
			$(function () {
				var api = TISAPI.New("<?php  echo $this->createMobileUrl('interface')?>", { tisId: getQueryStr("tisId") }, false);
				console.log(api);
				window.tis = TIS(".tis-container", {
					api: api,                               //必须
					useSSL: <?php  echo intval($_W['ishttps'])?>,
					//clientid:"clientId1"                  //可选，默认随机生成
					name: '<?php  echo $user["nickname"];?>',                           //可选，默认为Anonymous
					image: '<?php  echo $user["headimgurl"];?>',          //可选，默认未定义
					generateUserEvent: true,             //可选，默认为true
					template:           {onReceiveMessage: onReceiveMessage},     //界面模版
					//以下均可选
					failure: function (error, when) {       //某个操作失败时调用
						if (typeof error != "string") {
							if (when == "sendMsg" && error.code == 400 && error.error == "instance closed") {
								alert("TIS实例已关闭");
								return;
							}
							alert(when + "操作失败");
						} else {
							alert("操作失败：" + error);
						}
					},
					onSendSuccess: function (data) {
						//当发送消息成功时调用
						console.log("消息发送成功");
					},
					onReconnect: function () {
						//当需要与服务器重新连接时调用
						console.log("正在与服务器重连");
					},
					onConnect: function () {
						//当与服务器连接成功时调用
						loginInfo.type = 'into';
						tis.SendMessage('<?php  echo $user["nickname"];?>','',JSON.stringify(loginInfo));
						
						console.log("与服务器重连接成功");
					},
					onLoadComponent: function () {
						//当组件加载完成时调用
						console.log("组件加载完成");
					},
					updateUser: function (total, clientId) {
						//当generateUserEvent=true,并且在线人数发生变化时调用
						console.log("在线人数:",total);
					}
				});
				
			});

		</script>
	</head>

	<body >
	<?php  $ditu = 0;?>
	<?php  $gn = iunserializer($item['gn'])?>
		<style>
		.nav-btn1, .nav-btn2, .nav-btn3, .nav-btn4 , .nav-btn5 , .nav-btn7 {
			float: left;
			display: block;
			width: 50%;
			height: 36px;
			line-height: 36px;
			margin: 14px 0 6px;
			text-align: center;
			-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
			cursor: pointer;
		}
		.nav-btn1 {
			border-top-left-radius: 4px;
			border-bottom-left-radius: 4px;
		}
		.nav-btn7 {
			border-top-right-radius: 4px;
			border-bottom-right-radius: 4px;
		}
		.nav-box {
			width: 74%;
			margin: 0 auto;
		}
		.nav-select {
			background: #31ac84;
			color: #fff;
			box-shadow: 0 0 1px #31ac84;
		}
		.nav-unselect {
			box-shadow: 0 0 1px #31ac84;
			color: #31ac84;
		}
		</style>

		<?php  if($item['limit'] == 1 && $item['password'] != $viewer['password']  && $limit) { ?>
		
		<div class="grap-qz" style="cursor: pointer;display:block; z-index: 245;"><div class="focus-on layui-m-anim-scale qrcode-qz" style="display:block;     display: block;
    left: 50%;
	margin:-200px 0 0 -120px;
    position: fixed;
    top: 50%;
	
    z-index: 235;"><span class = "focus-on-click" style="display:none;">+</span><img src="<?php echo MODULE_URL;?>template/mobile/2/image/suo.jpg"><p>直播间限制观看需输入密码</p>
		<p><input type="text" id="password" placeholder="请填入观看密码" /></p><p><button type="button" class="mui-btn mui-btn-success" data-loading-icon-position="right" onClick="limit(<?php  echo $item['limit'];?>)">确定</button></p></div></div>
		<?php  } else if(($item['limit'] == 2 && $paylog['status']!=1  && $limit) || ($item['limit'] == 3  && $limit && $paylog['status']!=1 && ($limit_time - time())<0)) { ?>
		<script>
		$(function(){
			var height = $(window).height()/2;
			var width = $(window).width()/2;
			$('focus-on').css('margin','-'+height+' 0 0 -'+width);
		})
		</script>
		<div class="grap-qz" style="cursor: pointer;display:block; z-index: 245;"><div class="focus-on layui-m-anim-scale qrcode-qz" style="display:block;    display: block;
    left: 50%;
margin:-200px 0 0 -120px;
    position: fixed;
    top: 50%;
    z-index: 235;"><span class = "focus-on-click" style="display:none;">+</span><img src="<?php echo MODULE_URL;?>template/mobile/2/image/money.jpg"><p>直播间限制观看需支付<font color=red><?php  echo ($item['amount']/100)?></font>元</p><p><button type="button" class="mui-btn mui-btn-success" data-loading-icon-position="right" onClick="limit(<?php  echo $item['limit'];?>)">确定</button></p></div></div>
		<?php  } ?>

		<script>
$(document).ready(function(){
<?php  if(($item['limit'] == 3  && $limit && $paylog['status']!=1 && ($limit_time - time())>0)) { ?>
	$(".limitcount").show();
	intDiffs = parseInt(<?php  echo ($limit_time - time())?>);
	countlimit(intDiffs);
	function countlimit(nowtime){
		
		se=setInterval(function() {
			if (nowtime >= 0) {
				var str = nowtime;
			}
			else {
				$(".limitcount").hide();
				window.location.reload();
			}
			$(".limitcount").html(nowtime);
			nowtime--;
		},1000);
	}
<?php  } ?>
})
</script>

<?php  if(($_W['fans']['follow']==0 || $uid<0) && $setting['gz_must']==1) { ?>
		<div class="grap-qz" style="cursor: pointer;display:block; z-index: 245;"><div class="focus-on layui-m-anim-scale qrcode-qz" style="display:block;"><span class = "focus-on-click" style="display:none;">+</span><img src="<?php  echo tomedia($setting['attention_code'])?>"><p>长按二维码关注公众号</p><p>"关注后可掌握直播最新动态哦"</p></div></div>
		<?php  } ?>
		<input type="hidden" id="pid" value="<?php  echo $pid['id'];?>">
		<div class="main">
		<?php  if($item['theme']) { ?>
			<div class="swiper-container advertising swiper-container-horizontal">
				<div class="swiper-wrapper" style="height:auto;">
					<div class="swiper-slide swiper-slide-duplicate swiper-slide-next" style="height:auto;">
						<img src="<?php  echo tomedia($item['theme'])?>">
					</div>
					<div class="swiper-slide swiper-slide-prev" style="height:auto;">
						<img src="<?php  echo tomedia($item['theme'])?>">					
					</div>				    
					<div class="swiper-slide swiper-slide-duplicate swiper-slide-active" style="height:auto;">
						<img src="<?php  echo tomedia($item['theme'])?>">						
					</div>
				</div>
				<div class="swiper-pagination swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
			</div>	
		<?php  } ?>
				<section class="content">
				<div class="fixedfile">
					<div class="all-vide">
						<section class="block_video" id="play" style="height: 210px;">
						<?php  if(($uid=='-1') || ($item['limit'] == 1 && $item['password'] != $viewer['password']) || ($item['limit'] == 2 && $paylog['status']!=1) || ($item['limit'] == 3 && $paylog['status']!=1 && ($limit_time - time())<0) || ($item['limit']==4 && ($item['password'] != $viewer['password'] || $paylog['status']!=1))) { ?>
								<?php  if($list['type']=='6') { ?>
									<img src="<?php  echo tomedia($list['settings']['limg'])?>" style="width:100%;height:210px">
																	<?php  } else if($list['type']=='3') { ?>
									
									<?php  } else if($list['type']=='7') { ?>
									<?php  echo $list['settings']['images'];?>
									<?php  } else { ?>
									<img src="<?php  echo tomedia($list['settings']['img'])?>" style="width:100%;height:210px">
			
									<?php  } ?>
						<?php  } else { ?>
						
						<?php  if($list['type']=='6') { ?>
						<?php  if((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)) { ?>

<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/1.9.9/skins/default/index.css" />
<script type="text/javascript" src="https://g.alicdn.com/de/prismplayer/1.5.6/prism-min.js"></script>
<div id="play" class="prism-player"></div>
<script>
    // 初始化播放器
    var player = new prismplayer({
        id: "play", // 容器id
        source: "<?php  echo $list['settings']['lrtmp'];?>",// 视频地址
		cover: "<?php  echo tomedia($list['settings']['limg'])?>",
        autoplay: false,    //自动播放：否
        width: "100%",       // 播放器宽度
        height: "210px"      // 播放器高度
    });
    var clickDom = document.getElementById("J_clickToPlay");

</script>

<?php  } ?>

						<?php  } else if($list['type']=='3') { ?>
						<?php  echo $list['settings']['daima'];?>
						<?php  } else if($list['type']=='7') { ?>
						<?php  echo $list['settings']['images'];?>
						<?php  } else { ?>
						
						<?php  } ?>
						<?php  } ?>
						</section>
					<i class="max-start"></i>
					<p class="limitcount" id="limitcount" style="display:none;"></p>
					<p class="header-an"><?php  echo $item['title'];?></p>
					<div class="schedule">
						<p class="iconfont sche-start"></p>
						<p class="sche-nowtime">00:00</p>
						<div class="process">
					        <div class="process-bar"></div>
					        <span class="bar" id="mybar"></span>
					    </div>
						<p class="sche-alltime">00:00</p>
					</div>
					<div class="watermark" id="watermark">
						<?php  if($item['snposition']==1) { ?>
							<style>
							#livesn{
								bottom: 0.9rem;
								left: 6px;
								height: 20px;
								line-height: 18px;
							}
							</style>
						<?php  } else if($item['snposition']==2) { ?>
							<style>
							#livesn{
								top: 0.9rem;
								right: 6px;
								height: 20px;
								line-height: 18px;
							}
							</style>
						<?php  } else if($item['snposition']==3) { ?>
							<style>
							#livesn{
								bottom:0.9rem;
								right: 6px;
								height: 20px;
								line-height: 18px;
							}
							</style>
						<?php  } else { ?>
							<style>
							#livesn{
								top: 0.9rem;
								left: 6px;
								height: 20px;
								line-height: 18px;
							}
							</style>
						<?php  } ?>

						<?php  if($item['livenum']==1) { ?>
							<style>
								#liveflnum{
									bottom: 0.2rem;
									left: 0.3rem;
								}
							</style>
						<?php  } else if($item['livenum']==2) { ?>
							<style>
								#liveflnum{
									top: 0.2rem;
									left: 0.3rem;
									height: 20px;
									line-height: 18px;
								}
							</style>
						<?php  } else if($item['livenum']==3) { ?>
							<style>
								#liveflnum{
									bottom: 0.2rem;
									right: 0.3rem;
									height: 20px;
									line-height: 18px;
								}
							</style>
						<?php  } else { ?>
							<style>
							#liveflnum{
								top: 0.2rem;
								right: 0.3rem;
								height: 20px;
								line-height: 18px;
							}
							</style>
						<?php  } ?>

						
						<p id="livesn"><?php  echo $item['logo'];?></p>
						<div class="fl vp" id="liveflnum">
							 <i class="iconfont"></i>
							 <span id="browsenum">
							 <?php  if($item['istruenum']==1) { ?>
							<?php  echo $item['real_num'];?>
							<?php  } else { ?>
							<?php  echo $item['total_num'];?>
							<?php  } ?></span>
						</div>
						
					</div>
					<style>
						.timeover {
							display: none;
							position: absolute;
							top: 60%;
							left: 26%;
							width: 320px;
							height: 100px;
							background: url('<?php echo MODULE_URL;?>template/mobile/2/image/timeover.png') no-repeat;
							background-size: 100% 100%;
							z-index: 112;
						}
						.timeoverin {
							position: absolute;
							bottom: 4px;
							left: 52px;
							width: 300px;
							height: 40px;
							line-height: 40px;
							font-size: 32px;
							color: #fff;
						}
						.overnum {
							position: relative;
						}
						.overch {
							position: absolute;
							top: -15px;
							right: -10px;
							font-size: 12px;
							font-style: inherit;
						}
						@media screen and (max-width: 520px) {
							.timeover {
								top: 56%;
								left: 16%;
								width: 268px;
								height: 80px;
							}
							.timeoverin {
								bottom: 0px;
								left: 38px;
								width: 240px;
								font-size: 28px;
							}
						}
						@media screen and (max-width: 320px) {
							.timeover {
								top: 57%;
								left: 15%;
								width: 220px;
								height: 68px;
							}
							.timeoverin {
								bottom: 0px;
								left: 25px;
								width: 200px;
								font-size: 24px;
							}
						}
						.left-enter {
							position: absolute;
							background: url(http://w.weiya.in/Public/Home1/image/tip.png) no-repeat 20% 40%;
							padding: 0.3rem;
							padding-top: 0.6rem;
							padding-right: 2rem;
							background-size: 100% 100%;
							/* top: 5%; */
							color: #fff;
							z-index: 3;
							display: none;
							font-size: 0.9375rem;
						}
						.enter-detail {
							padding-left: 2rem;
							background: url(http://w.weiya.in/Public/Home1/image/ic_hg.png) no-repeat -1%;
							background-size: 2rem 1.4rem;
							height:25px;
							line-height: 28px;
							color:#FFF;
							text-align: center;
						}
					</style>
					<div class="timeover" style="display: none;">
					  <p class="timeoverin"> <span class="overnum overnumday">00<em class="overch">天</em></span> <span class="overclip">:</span> <span class="overnum overnumhour">00<em class="overch">时</em></span> <span class="overclip">:</span> <span class="overnum overnummin">00<em class="overch">分</em></span> <span class="overclip">:</span> <span class="overnum overnumsecond">00<em class="overch">秒</em></span> </p>
					</div>
				</div>
					<ul class="TAstate borb" style="position:relative">
					<?php  if(is_array($menusss)) { foreach($menusss as $key => $value) { ?>
						<li class="<?php  if($key==0) { ?> currentli <?php  } ?>" data-type=<?php  echo $value['type'];?>><?php  echo $value['name'];?></li>
					<?php  } } ?>
					</ul>
				</div>
				<section class="contents">
					<div class="left-enter" style="display: none;">
						<p class="enter-detail">欢迎<span id="enter-name">null</span>进入直播间</p>
					</div>
					<?php  if($roll && $roll['type']==1) { ?>
					<section class="width640 gun">
						<marquee scrollamount="3"><?php  echo $roll['content'];?></marquee>
						<!-- <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="8" scrolldelay="160" direction="left" width="100%" loop="-1" behavior="scroll" height="25px"><?php  echo $roll['content'];?></marquee> -->
					</section>
					<?php  } ?>
					<?php  if(is_array($menusss)) { foreach($menusss as $key => $value) { ?>
					<?php  if($value['type']=='3') { ?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> live">
						<div class="grap" style="cursor: pointer; display: none; z-index: 5;"></div>
						<ul class="chat_title" style="cursor: pointer;">
							<p class="tishis" style="margin-top: 30px;">您已进入直播房间，请文明聊天，营造和谐上网环境人人有责</p>
							<!-- <p class="tishis">直播已结束</p> -->
							<p id="msghistory">
								<?php  if(!empty($Comments)) { ?>
									<?php  if(is_array($Comments)) { foreach($Comments as $c => $comment) { ?>
										<?php  if(in_array(array('uid'=>$comment['uid']),$roomadmins)) { ?>
											<?php  $adminstr = '<span class="sec"> (管理员) </span>'?>
										<?php  } else { ?>
											<?php  if($limit) { ?> 
											<?php  $adminstr = ''?>
											<?php  } else { ?>
											<?php  $adminstr = '<span class="sec"> (会员) </span>'?>
											<?php  } ?>
										<?php  } ?>
										<?php  if($comment['type']=='comment') { ?>
											<?php  if($comment['ispic']==1) { ?>
												<li><div class="chat_left"><div class="head_portrait"><img src="<?php  echo $comment['headimgurl'];?>"></div><?php  if($dashangsetting['isshow']== 1) { ?><i class="iconfont" value="user_<?php  echo $comment['uid'];?>"></i><?php  } ?></div><div class="chat_right"><div class="char_name"><?php  echo mb_substr($comment['nickname'], 0, 5, 'utf-8')?><?php  echo $adminstr;?><span style="display:block;color:gray;font-size:12px;"><?php  echo date('Y-m-d H:i:s',$comment['dateline'])?></span></div><div class="char_message"><img src="<?php  echo $comment['content'];?>" style="CURSOR: hand" id="215" bigimgurl="<?php  echo $comment['content'];?>" onclick="imageClick(this)"><div class="send"></div></div></div></li>
											<?php  } else { ?>
												<li><div class="chat_left"><div class="head_portrait"><img src="<?php  echo $comment['headimgurl'];?>"></div><?php  if($dashangsetting['isshow']== 1) { ?><i class="iconfont" value="user_<?php  echo $comment['uid'];?>"></i><?php  } ?></div><div class="chat_right"><div class="char_name"><?php  echo mb_substr($comment['nickname'], 0, 5, 'utf-8')?><?php  echo $adminstr;?><span style="display:block;color:gray;font-size:12px;"><?php  echo date('Y-m-d H:i:s',$comment['dateline'])?></span></div><div class="char_message"><?php  echo $comment['content'];?><div class="send"></div></div></div></li>

											<?php  } ?>
										<?php  } else if($comment['type']=='gift') { ?>
											<p class="red-tishi">
												<i class="iconfont" value="user_<?php  echo $comment['uid'];?>"></i>
												<?php  echo $comment['content'];?>
											</p>
										<?php  } else if($comment['type']=='reward') { ?>
											<p class="red-tishi"><?php  echo $comment['content'];?></p>
										<?php  } else if($comment['type']=='grouppacket') { ?>
											<li class="redbao"><div class="chat_left"><div class="head_portrait"><img src="<?php  echo $comment['headimgurl'];?>"></div><?php  if($dashangsetting['isshow']== 1) { ?><i class="iconfont" value="user_<?php  echo $comment['uid'];?>"></i><?php  } ?></div><div class="chat_right"><div class="char_name" username="<?php  echo $comment['nickname'];?>"><?php  echo mb_substr($comment['nickname'], 0, 5, 'utf-8')?><?php  echo $adminstr;?><span style="display:block;color:gray;font-size:12px;"><?php  echo date('Y-m-d H:i:s',$comment['dateline'])?></span></div><div class="char_message red_message"><div class="red-red" value="<?php  echo $comment['id'];?>"><img src="http://hefei.hfwxz.com/addons/wxz_wzb/template/mobile/2/image/hongbao.png" height="45px"><div class="red-cent"><p class="red-title">恭喜发财！</p><p>领取红包</p></div></div><div class="send"></div><div class="red_name"><span class="red_name1">直播间</span><span class="red_name2">红包</span></div></div></div></li>
										<?php  } ?>
									<?php  } } ?>
								<?php  } ?>
							</p>
							
						</ul>
						<div class="footer">
							<div class="allgift">
								<ul class="gift-list">
									<?php  if(($item['reward']==1 && strpos($user_agent, 'MicroMessenger') !== false)) { ?>
									<li class='giftReward' id="giftReward">
										<p><img src="<?php echo MODULE_URL;?>template/mobile/2/image/hongbao1.png"></p>
										<p>群发红包</p>
									</li>
									<?php  } ?>
									<?php  if($dashangsetting['isshow']== 1 && strpos($user_agent, 'MicroMessenger') !== false) { ?>
									<li class='giftDs'  id="giftDs">
										<p><img src="<?php echo MODULE_URL;?>template/mobile/2/image/dashang.png"></p>
										<p>打赏主播</p>
									</li>
									<?php  } ?>
									<?php  if(is_array($gift)) { foreach($gift as $value) { ?>
									<li data-id="<?php  echo $value['id'];?>"  class='giftlist'>
										<p><img src="<?php  echo $value['pic'];?>"></p>
										<p><?php  echo $value['name'];?></p>
										<p><span class="moneynum"><?php  echo $value['amount']/100?></span>元</p>
									</li>
									<?php  } } ?>
									
								</ul>
								<!--数量加减-->
								<div class="zhuang">
									<div class="countes">数量</div>
									<div class="moneymag">
										<p class="jian" style="cursor: pointer;"><em class="iconfont jianicon">-</em></p>
										<input type="text" id="count" name="count" value="1" class="countKuang" readonly="">
										<input type="hidden" name="gift_id" value="" id="gift_id">
										<p class="jia" style="cursor: pointer;"><em class="iconfont jiaicon">+</em></p>
									</div>
									<div class="allmoney">合计:<span class="money"></span><button type="button" class="give">赠送</button></div>
								</div>
							</div>
							<!--底部-->
							<div class="footer-bar">
								<div class="footer-left">
									<a class="btnicont iconfont face" style="cursor: pointer;"></a>
									<input type="text" class="text-input" id="send_msg_text" placeholder="和大伙说点什么吧">
									<a class="btnicont gift iconfont" style="cursor: pointer;"></a>
								</div>
								<div class="footer-right">
									<!-- <a class="btnicont iconfont showfun" style="cursor: pointer;">&#xe612;</a> -->
									<!-- <a class="btn-sub">发送</a> -->
									<a id="mune" class="iconfont showfun" style="cursor: pointer;"></a>
								</div>
							</div>
							<!--表情-->
							<ul class="browlist">
	
							</ul>
							<ul class="showfunction">
								<?php  if(in_array('主页',$gn)) { ?><li class="index-list">
									<a href="<?php  echo $this->createMobileUrl('index')?>">
										<p>
											<i class="iconfont"></i>
										</p>
										<p>首页</p>
									</a>
								</li><?php  } ?>
								<?php  if(in_array('图片',$gn)) { ?><li>
									<p>
										<i class="iconfont"></i>
									</p>
									<p>图片</p>
									<form name="form1" id="upform1">
									<input type="file" class="input-files" id="up" onchange="upimage('<?php  echo $this->createMobileUrl('headupload',array('rid' => $rid))?>');">
									</form>
								</li><?php  } ?>
								<?php  if(in_array('提现',$gn)) { ?><li>
									<a href="<?php  echo $this->createMobileUrl('withdraw',array('rid' => $rid))?>">
										<p>
											<i class="iconfont"></i>
										</p>
										<p>提现</p>
									</a>
								</li><?php  } ?>
							</ul>
						</div>
						<!--禁言管理star-->
						<div class="function-all Bannedmages ">
								<div class="Banned-list">
									<span>全员禁言</span>
									 <span class="bannerdbtn" style="background-color: rgb(204, 204, 204);">
									  		<input type="checkbox" style="" id="allcheck">
									 	<em class="btn-movel">
									 	</em>
									 </span>
								</div>
								<!-- <div class="Banned-list">
									<span>禁止上传图片</span>
									 <span class="bannerdbtn checkbtn" style="background-color: rgb(204, 204, 204);">
									  		<input type="checkbox" style="" id="disimg">
									 	<em class="btn-movel">
									 	</em>
									 </span>
								</div> -->
								<div class="colose">
									关闭
								</div>
						</div>
						<!--功能展示star-->
						<!-- <div class="function-all">
							<div class="function-file">
								<div>
									<img src="<?php echo MODULE_URL;?>template/mobile/2/image/ico.png" />
									<section>
										<p>直播间名称</p>
										<p>创建人：林小酒</p>
									</section>
								</div>
								<div>
									<img src="<?php echo MODULE_URL;?>template/mobile/2/image/head.png" />
									<section>
										<p>林小酒</p>
										<p>当前主播</p>
									</section>
								</div>
							</div>
							<div class="function-live">
								<ul>
									<li class="collection-on">
										<i class="iconfont">&#xe625;</i>
										<p>收藏</p>
									</li>
									<li>
										<i class="iconfont">&#xe60f;</i>
										<p>关注</p>
									</li>
									<li>
										<i class="iconfont">&#xe627;</i>
										<p>直播介绍</p>
									</li>
									<li>
										<i class="iconfont">&#xe610;</i>
										<p>直播间</p>
									</li>
								</ul>
							</div>
						</div> -->
						<!--关注公众号-->
						<?php  if($item['copyrightshow']==1) { ?>
						<div class="" style="
							height: 20px;
							position: relative;
							bottom: 18px;
							text-align: center;
							line-height: 20px;
							color: #aaaaaa;
						"><?php  echo $item['copyright'];?></div><?php  } ?>
						
						<div class="focus-on layui-m-anim-scale qrcode"><img src="<?php  echo tomedia($setting['attention_code'])?>"><p>长按二维码关注公众号</p><p>"关注后可掌握直播最新动态哦"</p></div>
						<!--收藏-->
						<div class="collection">
							<img src="<?php echo MODULE_URL;?>template/mobile/2/image/collection.png">
						</div>
						<!--操作-->
						<div class="operation width640">
							<ul>
								<li id="shutup"></li>
								<!-- <li id="black"></li> -->
								<li class="opclose">关闭</li>
							</ul>
						</div>
					</div>
					<!--红包列表-->
					<div class="redlist width640 layui-m-anim-scale">
						<div class="masks"></div>
						<div class="overflow">
							<div class="redcenters width640 ovredlist">
							<div class="hiders">
								<div class="HeadTop">
									<i class="iconfont cose" id="redlistcose"></i>
								</div>
								<!--红包信息-->
								<div class="RedPack_Info">
									<div class="packimgs">
										<!-- <img src="<?php echo MODULE_URL;?>template/mobile/2/image/ico.png"> -->
									</div>
									<p class="FromWho text_flow">的红包<i class="iconfont"></i></p>
									<p class="qm text_flow">恭喜发财，大吉大利！</p>
									<p class="qm text_flow rednull"></p>
								</div>
							</div>
							<ul class="alllist">
								<h5></h5>

							</ul>
						</div>
						</div>
					</div>
					<!--开-->
					<div class="open width640 layui-m-anim-scale">
						<div class="masks"></div>
						<div class="redcenters width640 ovredlist">
							<div class="hiders">
								<div class="open-red"></div>
								<div class="HeadTop">
								</div>
								<i class="iconfont cose" id="guan"></i>
								<!--红包信息-->
								<div class="RedPack_Info">
									<div class="packimgs">
										<img src="">
									</div>
									<p class="qm text_flow"></p>
									<p class="qm text_flow"></p>
									<p class="FromWho text_flow"></p>
								</div>
								<div class="openkai">
									<div class="openkais">
										開
									</div>
								</div>
							</div>
							<p class="text_flow mar10">查看大家的手气 &gt;</p>
						</div>
					</div>
					<!--全员禁言-->
					<div class="width640 Banned layui-m-anim-scale">
						<div class="mask"></div>
						<div class="redcenters">
							<h5>禁言列表</h5>
							<i class="iconfont cose"></i>
							<ul class="alllist shutuplist">
								
								
							</ul>
						</div>
					</div>
					<!--打赏红包-->
					<?php  $settings = iunserializer($dashangsetting['settings'])?>
					<section class="redenvelope width640 layui-m-anim-scale">
						<div class="mask"></div>
						<div class="redcenters width640">
							<div class="hiders">
								<div class="HeadTop">
									<i class="iconfont cose"></i>
								</div>
								<!--红包信息-->
								<div class="RedPack_Info">
									<div class="packimgs">
										<img src="<?php  echo tomedia($dashangsetting['logo'])?>">
									</div>
									<p class="FromWho text_flow"></p>
									<p class="qm text_flow"><?php  echo $dashangsetting['content'];?></p>
								</div>
							</div>
							<ul class="c-money">
								<li data-money="<?php  echo $settings['one'];?>">
									<a href="javascript:;">
										<p><?php  echo $settings['remark1'];?></p>
										<p>（<?php  echo ($settings['one']/100)?>元）</p>
									</a>
								</li>
								<li data-money="<?php  echo $settings['two'];?>">
									<a href="javascript:;">
										<p><?php  echo $settings['remark2'];?></p>
										<p>（<?php  echo ($settings['two']/100)?>元）</p>
									</a>
								</li>
								<li data-money="<?php  echo $settings['three'];?>">
									<a href="javascript:;">
										<p><?php  echo $settings['remark3'];?></p>
										<p>（<?php  echo ($settings['three']/100)?>元）</p>
									</a>
								</li>
								<li data-money="<?php  echo $settings['four'];?>">
									<a href="javascript:;">
										<p><?php  echo $settings['remark4'];?></p>
										<p>（<?php  echo ($settings['four']/100)?>元）</p>
									</a>
								</li>
								<li data-money="<?php  echo $settings['five'];?>">
									<a href="javascript:;">
										<p><?php  echo $settings['remark5'];?></p>
										<p>（<?php  echo ($settings['five']/100)?>元）</p>
									</a>
								</li>
								<li data-money="<?php  echo $settings['six'];?>">
									<a href="javascript:;">
										<p><?php  echo $settings['remark6'];?></p>
										<p>（<?php  echo ($settings['six']/100)?>元）</p>
									</a>
								</li>
							</ul>
							<p class="other-m">其他金额</p>
						</div>
	
						<div class="two-top width640 layui-m-anim-scale">
							<div class="masks"></div>
							<div class="dshang-m width640">
								<h1 class="ttitles font-s">其它金额 </h1>
								<div class="p-money">
									<span>金额(元)</span>
									<input type="number" name="money" id="othermoney" placeholder="0.01-1000之间">
								</div>
								<p class="ttitles t-btns"><button disabled="disabled" class="font-s">完成</button></p>
							</div>
						</div>
					</section>
					<!--右侧-->
					
					<ul class="cont-right <?php  echo $value['type'];?>" <?php  if($value['type']=='3') { ?> style="display:block;" <?php  } else { ?> style="display:none;" <?php  } ?>>
						<?php  if(in_array('主页',$gn)) { ?><a href="<?php  echo $this->createMobileUrl('index')?>"><li><i class="iconfont">&#xe63d;</i></li></a><?php  } ?>
						<?php  if(in_array('关注',$gn)) { ?><li class="focus-onto"><i class="iconfont"></i></li><?php  } ?>
						<!-- <a ><li><i class="iconfont icon-ding"></i></li></a> -->
						<?php  if(in_array('邀请卡',$gn)) { ?><a href="<?php  echo $this->createMobileUrl('invitation',array('rid'=>$rid))?>"><li><i class="iconfont"></i></li></a><?php  } ?>
						<?php  if(in_array('刷新',$gn)) { ?><a href="javascript:;" onclick="window.location.reload();"><li><i class="iconfont"></i></li></a><?php  } ?>
						<!-- <li class="functions"><i class="iconfont">&#xe628;</i></li> -->
						<?php  if(in_array('点赞',$gn)) { ?><div class="zan-box">
							<a class="zan-click" href="javascript:void(0);" style="display:block;"><li class="zan"><i class="iconfont"></i><em class="zan-num"><?php  echo $totalzannum;?></em></li></a>
							<div class="love"></div>
						</div><?php  } ?>
					</ul>
					<!-- <p class="history" onclick="history();">查看历史消息^</p> -->
					<?php  } else if($value['type']=='2') { ?>
						<?php  $settings = iunserializer($value['settings'])?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> minh">
						<div class="allconts">
							<?php  echo $settings['content'];?>
						</div>
						<?php  if($item['copyrightshow']==1) { ?><div class="pl-nomore line-top" style="
							height: 20px;
							text-align: center;
							line-height: 20px;
							color: #aaaaaa;
						"><?php  echo $item['copyright'];?></div><?php  } ?>
					</div>	
					<?php  } else if($value['type']=='6') { ?>
						<?php  $ditu = 1;?>
						<?php  $settings = iunserializer($value['settings'])?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> minh">
						<div class="allconts">


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
						
						</div>
						<?php  if($item['copyrightshow']==1) { ?><div class="pl-nomore line-top" style="
							height: 20px;
							text-align: center;
							line-height: 20px;
							color: #aaaaaa;
						"><?php  echo $item['copyright'];?></div><?php  } ?>
					</div>	
					<?php  } else if($value['type']=='5') { ?>
						<?php  $settings = iunserializer($value['settings'])?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> minh hidediv3">
						<div class="allconts rankpm">
							<div class="nav-box clearfix">
							<?php  $i=1;$j=count($settings['list']);?>
		
							<?php  if(is_array($settings['list'])) { foreach($settings['list'] as $kk => $vv) { ?>
								<?php  if($i==1) { ?><?php  $rankid = $kk;?><?php  } ?>
								<p class="nav-btn<?php  echo $kk?> <?php  if($i==$j) { ?> nav-btn7 <?php  } ?><?php  if($i==1) { ?> nav-select <?php  } else { ?> nav-unselect <?php  } ?>" onclick="rank(<?php  echo $kk;?>,<?php  echo $j;?>);"><?php  echo $vv;?></p>
							<?php  $i++;?>
							<?php  } } ?>
								
							</div>
							<div class="totip">
								<?php  $i=1;$j=count($settings['list']);?>
								<?php  if(is_array($settings['list'])) { foreach($settings['list'] as $kk => $vv) { ?>
								<ul id="rank<?php  echo $kk;?>" <?php  if($i!=1) { ?>style="display: none"<?php  } ?> class="rankcontent"></ul>
								<?php  $i++;?>
								<?php  } } ?>
								
								
							</div>
						</div>
						<?php  if($item['copyrightshow']==1) { ?><div class="pl-nomore line-top" style="
							height: 20px;
							text-align: center;
							line-height: 20px;
							color: #aaaaaa;
						"><?php  echo $item['copyright'];?></div><?php  } ?>
					</div>	
					<?php  } else if($value['type']=='7') { ?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> minh">
						<div class="goods-box allconts">
						</div>
						<?php  if($item['copyrightshow']==1) { ?><div class="pl-nomore line-top" style="
							height: 20px;
							text-align: center;
							line-height: 20px;
							color: #aaaaaa;
						"><?php  echo $item['copyright'];?></div><?php  } ?>
					</div>	
					<?php  } else if($value['type']=='1') { ?>
					<?php  $settings = iunserializer($value['settings'])?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> minh">
						<iframe src="<?php  echo $settings['iframe'];?>" frameborder="no" marginheight="0" marginwidth="0" width="100%" height="100%" allowTransparency="true" style="overflow-y:auto"></iframe>
					</div>
					<?php  } else if($value['type']=='4') { ?>
					<div class="showthisd <?php  if($key !=0) { ?> hidediv <?php  } ?> minh">
						<div class="allconts tw">
						<div id="section">
	<div id="panels" class="panels">
				<?php  if(is_array($LivePic)) { foreach($LivePic as $key => $valu) { ?>
				<div class="item">
					<!--左侧图标-->
					<div class="leftpng">
						<img src="<?php  echo tomedia($valu['images'])?>" width="100%"/>
					</div>
					<div class="title">
						<strong><span><?php  if($valu['publisher']) { ?><?php  echo $valu['publisher'];?><?php  } else { ?>主持人<?php  } ?></span></strong>
						<span><?php  echo date('Y-m-d H:i:s',$valu['dateline'])?></span>
					</div>
					<div class="content">
						<?php  if($valu['title']) { ?><div align="center"><font face="黑体"><font ><?php  echo $valu['title'];?></font></font></div><?php  } ?>
						<?php  if($valu['pic']) { ?>
							<?php  $pic = json_decode($valu['pic'])?>
							<?php  if(is_array($pic)) { foreach($pic as $key => $val) { ?>
							<div align="center">
								<img src='<?php  echo tomedia($val)?>'>
							</div><br />
							<?php  } } ?>
						<?php  } ?>
						<?php  if($valu['content']) { ?><font face="黑体"><font ><?php  echo $valu['content'];?></font></font><?php  } ?>
					</div>
				</div>
				<?php  } } ?>
				
			</div>
			<?php  if($item['copyrightshow']==1) { ?><div class="pl-nomore line-top" style="
							height: 20px;
							text-align: center;
							line-height: 20px;
							color: #aaaaaa;
						"><?php  echo $item['copyright'];?></div><?php  } ?>
		
	</div></div>
					</div>
					<?php  } ?>
					<?php  } } ?>
								
								
				</section>
			</section>
			<div class="reading">
				<div class="stargrap"></div>
				<i class="iconfont readcolse"></i>
				<a href="">
					<!-- <img src="<?php echo MODULE_URL;?>template/mobile/2/image/111.jpg"> -->
				</a>

			</div>
		</div>

		<!--红包层-->
		<style>
			.sendredbagwin {
				position: fixed !important;
				bottom: 0;
				width: 100%;
				height: 100%;
				margin: auto;
				left: 0;
				right: 0;
				z-index: 10;
				display: none;
			}
			
			.redbagmask {
				position: fixed;
				background-color: rgba(0, 0, 0, .5);
				width: 100%;
				height: 100%;
				z-index: 11;
			}
			
			.sendredbagwinmain {
				position: fixed;
				margin: auto;
				max-width: 640px;
				left: 0;
				right: 0;
				bottom: 0;
				z-index: 12;
				background-color: rgb(255, 245, 245);
				height: 365px;
			}
			.sendredbagwin .inputs{
				vertical-align: middle !important;
				margin-bottom: 0 !important;
				padding: 4px 2px !important;
			}
			.fl {
				float: left;
			}
			
			.fr {
				float: right;
			}
			
			.clearfix:after {
				content: "";
				display: block;
				clear: both;
			}
			/*发红包*/
			
			.main-wrap {
				padding: 1rem;
				font-size: 1.4rem;
			}
			
			.sendredbagwin li {
				margin-top: 1rem;
				width: 100%;
			}
			
			.sendredbagwin .line span {
				display: block;
				font-size: 15px;
			}
			
			.sendredbagwin .line {
				padding: 0rem 1rem;
				background-color: #fff;
				margin-top: 1rem;
				height: 42px;
				margin: 21px 0px;
				line-height: 40px;
			}
					.sendredbagwin	input::-webkit-input-placeholder { /* WebKit browsers */
			  vertical-align: middle;
			  padding: 6px 0px;
			}
			
			.sendredbagwin .inputbox {
				margin-right: .5rem;
				height: 3rem;
				text-align: right;
				border: 0;
				margin-bottom: 0px;
				padding: 12px 2px;
				
			}
			
			.sendredbagwin .redtype {
				font-size: 1.2rem;
				padding-left: 1rem;
			}
			
			.sendredbagwin em {
				color: #31ac84;
				cursor: pointer;
				font-style: normal;
			}
			
			.sendredbagwin .remark {
				resize: none;
			}
			
			.sendredbagwin .redmoney {}
			
			.sendredbagwin .livebtn {
				border: 0;
				color: #fff;
				width: 100%;
				height: 3.5rem;
				line-height: 3.5rem;
				font-size: 1.6rem;
				border-radius: .5rem;
				text-align: center;
				cursor: pointer;
				display: block;
				cursor: pointer;
				font-family: 14/1 "微软雅黑";
			}
			
			.sendredbagwinmain ul li:last-child {
				margin-top: 17px;
			}
			
			.sendredbagwinmain input::-webkit-input-placeholder,
			textarea::-webkit-input-placeholder {
				color: #d8d8d8;
				font: 14px/1 微软雅黑 !important;
				line-height: 21px;
			}
			
			.livebtn.red {
				background-color: #d84e43;
			}
			
			.livebtn.red[disabled] {
				background-color: rgba(216, 78, 67, .7);
				color: (255, 255, 255, 0.81);
				font: 14px/1 微软雅黑 !important;
				font-family: 14/1 "微软雅黑";
			}
			
			.vcenter {
				/* -webkit-box-pack: center; */
				-moz-box-pack: center;
				-ms-flex-align: center;
				/* IE 10 */
				-webkit-align-items: center;
				-moz-align-items: center;
				/* align-items: center; */
			}
			
			.livebtn.blue {
				background-color: rgba(0, 172, 255, .5);
			}
			
			.totalmoney i {
				font-size: 1.2rem;
				font-size: 17px;
				color: #31ac84;
				font-style: normal;
				padding: .1rem .1rem .2rem .1rem;
				margin-left: .3rem;
			}
			
			#msg-tipbar {
				height: 3rem;
				line-height: 3rem;
				text-align: center;
				background-color: #E64340;
				color: #fff;
				width: 100%;
				left: 0;
				top: 0;
				display: none;
			}
			
			.d-flex {
				display: -webkit-box;
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
			}
			
			.flex {
				-webkit-box-flex: 1;
				-webkit-flex: 1;
				-ms-flex: 1;
				flex: 1;
			}
			
			@-webkit-keyframes layui-m-anim-scale {
				0% {
					opacity: 0;
					-webkit-transform: scale(.5);
					transform: scale(.5);
				}
				100% {
					opacity: 1;
					-webkit-transform: scale(1);
					transform: scale(1);
				}
			}
			
			@keyframes layui-m-anim-scale {
				0% {
					opacity: 0;
					-webkit-transform: scale(.5);
					transform: scale(.5);
				}
				100% {
					opacity: 1;
					-webkit-transform: scale(1);
					transform: scale(1);
				}
			}
			
			.layui-m-anim-scale {
				animation-name: layui-m-anim-scale;
				-webkit-animation-name: layui-m-anim-scale;
				animation-duration: .2s;
				-webkit-animation-duration: .2s;
				animation-fill-mode: both;
				-webkit-animation-fill-mode: both;
			}
			
			.min_tips_box .bg {
				position: fixed;
				z-index: 1005;
				left: 0;
				top: 0;
				content: "";
				width: 100%;
				height: 100%;
				background: #000000;
				opacity: 0.3;
				filter: alpha(opacity=5);
			}
			
			.min_tips_box .tips_content {
				position: fixed;
				z-index: 1006;
				max-width: 80%;
				min-width: 10rem;
				line-height: 2rem;
				margin-top: -2.3rem;
				margin-left: -50%;
				padding: 1.2rem 1rem;
				left: 50%;
				top: 50%;
				background: #000000;
				border-radius: 5px;
				text-align: center;
				color: #fff;
				box-shadow: 0 0 5px #000000;
				word-break: break-all;
			}
			
		</style>
		<div class="sendredbagwin" style="display: none;">
			<div class="redbagmask" style="cursor:pointer;"></div>
			<div class="sendredbagwinmain layui-m-anim-scale">
				<div id="msg-tipbar">
				</div>
				<ul style=" padding: 0 1rem 1rem 1rem;">
					<li class="d-flex line vcenter">
						<span>红包个数</span>
						<input type="tel" placeholder="填写个数" class="flex inputbox" id="bagAmount" min="0">
						<span>个</span>
					</li>
					<li class="d-flex line vcenter">
						<span class="totalmoney">总金额<i class="iconfont"></i></span>
						<input type="number" placeholder="填写金额" class="flex inputbox inputs" id="bagMoney" min="0">
						<span>元</span>
					</li>
					<li class="redtype">
						<div class="clearfix">
							<div class="fl">
								<span class="typemsg">金额随机</span>，
								<em id="changeRedType">改为普通红包</em>
							</div>
							<div class="fr redmoney">
								<!-- ￥<span class="bag-money-show">0.00</span><span class="service-money">+<em></em>(2%手续费)</span> -->
								￥<span class="bag-money-show">0.00</span><span class="service-money"><em></em></span>
							</div>
						</div>

					</li>
					<li class="d-flex line vcenter">
						<span>留言</span>
						<input type="text" class="flex remark inputbox" id="bagMessage" placeholder="恭喜发财！">
					</li>
					<li>
						<input type="button" disabled="disabled" class="livebtn red" id="btnSendRedBag" value="塞钱进红包">
					</li>
					<li>
						<a href="javascript:;" class="livebtn blue btn-cancel">取消</a>
					</li>
				</ul>

			</div>
		</div>
		
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/fastclick.js"></script>
		<script type="text/javascript">FastClick.attach(document.body);</script>
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/mui.min.js"></script>

		
		<!--<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/dropload/dropload1.js"></script>-->
				<?php  if(($list['type']==6 && ((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)))) { ?>
<?php  } else { ?>
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/ady.js?v=1"></script>
		<?php  } ?>
		
		
		<script type="text/javascript" src="<?php echo MODULE_URL;?>template/mobile/2/js/demo_base.js"></script>
		<?php  if($item['theme']) { ?>
		<script type="text/javascript">
			// 广告轮播
			var mySwiper = new Swiper ('.swiper-container', {
			    // 如果需要分页器
			    pagination: '.swiper-pagination',
			    loop : true,
			  })
			setInterval("mySwiper.slideNext()", 4000);
		</script>		
		<?php  } ?>

		<script>
			$(function() {
				<?php  if(($setting['gz_must']==2)) { ?>
				if(getCookie('qrshow'+loginInfo.rid)!=2)
					{
						if("<?php  echo $_W['fans']['follow'];?>"!=1)
						{
						  
							  $('.grap').show();	
						      $('.qrcode').html('<span class = "focus-on-click">+</span><img src="<?php  echo tomedia($setting['attention_code'])?>"/><p>长按二维码关注公众号</p><p>"关注后可掌握直播最新动态哦"</p>');
						      $('.qrcode').show();
						      setCookie('qrshow'+loginInfo.rid,2,<?php  if($setting['days']) { ?><?php  echo $setting['days'];?><?php  } else { ?> 0 <?php  } ?>);
					     
						}
					  
					}
				<?php  } ?>
					<?php  if($list['type']=='6') { ?>
					var liveurl = "<?php  echo $list['settings']['lrtmp'];?>";
					var livehttp = "<?php  echo $list['settings']['lhls'];?>";
					<?php  } else if($list['type']=='3') { ?>
					var liveurl = "";
					var livehttp = "";
					<?php  } else if($list['type']=='7') { ?>
					var liveurl = "";
					var livehttp = "";
					<?php  } else { ?>
					var liveurl = "<?php  echo $list['settings']['rtmp'];?>";
					var livehttp = "<?php  echo $list['settings']['hls'];?>";
					<?php  } ?>
					
					var linum = $(".TAstate li").length;
					if (linum==1) {
						$(".TAstate li").width("100%");
					}else if(linum==2){
						$(".TAstate li").width("50%");
					}else if(linum==3){
						$(".TAstate li").width("33%");
					}else if(linum==4){
						$(".TAstate li").width("25%");
					}else if(linum==5){
						$(".TAstate li").width("20%");
					}
					var ranknum = $(".rankpm div p").length;
					if (ranknum==1) {
						$(".rankpm div p").width("100%");
					}else if(ranknum==2){
						$(".rankpm div p").width("50%");
					}else if(ranknum==3){
						$(".rankpm div p").width("33%");
					}else if(ranknum==4){
						$(".rankpm div p").width("25%");
					}else if(ranknum==5){
						$(".rankpm div p").width("20%");
					}
		    wx.config({
		        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		        appId: "<?php  echo $_W['account']['jssdkconfig']['appId'];?>",
		        timestamp: "<?php  echo $_W['account']['jssdkconfig']['timestamp'];?>",
		        nonceStr: "<?php  echo $_W['account']['jssdkconfig']['nonceStr'];?>",
		        signature: "<?php  echo $_W['account']['jssdkconfig']['signature'];?>",
		        jsApiList: ['getLocation','onMenuShareAppMessage','onMenuShareTimeline', "onMenuShareQQ",'hideMenuItems','previewImage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		    });
		    wx.ready(function(){
		      wx.onMenuShareAppMessage({
		          title: "<?php  echo $setting['share_title'];?>",
		          desc: "<?php  echo $setting['share_desc'];?>",
		          link: "<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('index2',array('share_uid' => $uid,'rid'=>$rid)))?>",
		          imgUrl: "<?php  echo $_W['attachurl'].$setting['share_img']?>",
		          success: function () { 
						$.post("<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('mobileshare',array('rid'=>$rid)))?>", function(data) {
						  
						},'json');
		          },
		          cancel: function () { 
		          }
		      });
		      wx.onMenuShareTimeline({
		          title: "<?php  echo $setting['share_title'];?>",
				  desc: "<?php  echo $setting['share_desc'];?>",
				  link:"<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('index2',array('share_uid' => $uid,'rid'=>$rid)))?>",
				  imgUrl: "<?php  echo $_W['attachurl'].$setting['share_img']?>",
		          success: function () {
						$.post("<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('mobileshare',array('rid'=>$rid)))?>", function(data) {
						  
						},'json');
		          },
		          cancel: function () { 
		          }
		      });
		      wx.hideMenuItems({
		          menuList: [
		              'menuItem:readMode', 
		              'menuItem:openWithSafari',
		              'menuItem:copyUrl',
		              'menuItem:exposeArticle',
		              'menuItem:share:qq',
		              'menuItem:profile',
		              'menuItem:addContact',
		              'menuItem:share:QZone',
		          ]
		      });
		      $('body').on('click', '.char_message>img', function(event) {
		      	event.preventDefault();

			      	var imgArray = [];
			      	var thisimg = $(this).attr('src');
			      	$('.char_message>img').each(function(index, el) {
			      		var itemSrc = $(this).attr('src');
		            	imgArray.push(itemSrc);
			      	});
			      	// alert(thisimg);
			      	wx.previewImage({
				      current: thisimg,
				      urls: imgArray
				    });	      		
		      });
			      
		      });

function isWX() {
    var u = navigator.userAgent, app = navigator.appVersion;
    return u.indexOf("MicroMessenger") > -1;
}



                var founder = {
                    uid:"<?php  echo $dashangsetting['uid'];?>",
                    nickname:"<?php  echo $dashangsetting['nickname'];?>",
                    headurl:"<?php  echo tomedia($dashangsetting['logo'])?>"
                }


				var tid='2201';

				var minMoney = 0.01; //每人最小金额1元
				var zbRedBag = {
					randomBtn: '改为拼手气红包',
					fixedBtn: '改为普通红包',
					randomText: '金额随机',
					fixedText: '金额固定',
					bagMessage: '恭喜发财！',
					msg1: '至少需要设置1个红包',
					msg2: '平均每人不能少于' + minMoney + '元'

				};
				var msgbar = $("#msg-tipbar");
				var bag_money_show = $(".bag-money-show");

				var pd = {
					bagAmount: 0,
					bagMoney: 0,
					bagType: 1, //1随机，默认  2固定
					bagMessage: zbRedBag.bagMessage,
					bagServiceMoney: 0, //平台服务费0%
				};
				var red = {
					redid:0,
					redtitle:'恭喜发财',
					toredName:'',
					toredHead:'',
					redMoney:0,
					rednum:0
				};
				var personal = {
					uid:0,
					nickname:'',
					headurl:''
				}
				//聊天框
				$(document).on('click', '.chat_title', function(event) {
					event.preventDefault();
					$(".allgift").slideUp('fast');
					$(".browlist").slideUp('fast');
					$(".showfunction").slideUp('fast');
					hideflag = true;
					//表情
				}).on('click', '.face', function(event) {
					event.preventDefault();
					if(loginInfo.shutup==1&&loginInfo.isadmin!=1)
					{
						showtipsbox('发消息失败：您已被禁言');
						return false;
					}
					$('.grap').hide();
					if(hideflag) {
						$(".browlist").slideDown('fast');
						hideflag = false;
					} else {
						if($('.showfunction').css('display') == 'block' || $('.allgift').css('display') == 'block') {
							$(".allgift").slideUp('fast');
							$(".showfunction").slideUp('fast');
							$(".browlist").slideDown('fast');
							hideflag = false;
						} else {
							$(".browlist").slideUp('fast');
							hideflag = true;
						}
					}
					//加号
				}).on('click', '.showfun', function(event) {
					event.preventDefault();
					$('.grap').hide();
					if(hideflag) {
						$('.showfunction').slideDown('fast');
						hideflag = false;
					} else {
						if($('.allgift').css('display') == 'block' || $('.browlist').css('display') == 'block') {
							$(".allgift").slideUp('fast');
							$(".browlist").slideUp('fast');
							$('.showfunction').slideDown('fast');
							hideflag = false;
						} else {
							$('.showfunction').slideUp('fast');
							hideflag = true;
						}
					}
					//礼物
				}).on('click', '.gift', function(event) {
					event.preventDefault();
					$('.grap').show().css("z-index", "4");
					$('.gift-list li').each(function(index, el) {
						if($(this).hasClass('select')) {
							var summoney = $('.countKuang').val() * parseInt($(this).find('.moneynum').html());
							
							$('.money').html('￥' + summoney);
						} else {
							$('.countKuang').val('1');
						}
					});
					if(hideflag) {
						$(".allgift").slideDown('fast');
						hideflag = false;
					} else {
						if($('.browlist').css('display') == 'block' || $('.showfunction').css('display') == 'block') {
							$(".browlist").slideUp('fast');
							$('.showfunction').slideUp('fast');
							$(".allgift").slideDown('fast');
							hideflag = false;
						} else {
							$(".allgift").slideUp('fast');
							$('.grap').hide();
							hideflag = true;
						}
					}
					//获得焦点
				}).on('focus', '.text-input', function(event) {
					loginInfo.pop=1;
					event.preventDefault();
					if ($(this).val().length >= 1 ) {
						$("#mune").empty().removeClass('iconfont showfun').addClass('btn-sub').html('发送');
					};
					$(".allgift").slideUp('fast');
					$(".browlist").slideUp('fast');
					$(".showfunction").slideUp('fast');
					$(".grap").slideUp('fast');
					hideflag = true;
				//发送消息按钮
				}).on('click', '.btn-sub', function(event) {
					event.preventDefault();
					if ($('.text-input').val().length == 0 || $('.text-input').val().match(/^\s+$/g)) {
						$(document).minTipsBox({
							tipsContent: '请输入内容',
							tipsTime: 1
						});
						$('.text-input').val('');
					}else{
						if(('a'+$('.text-input').val()).indexOf('http://')>0)
                       {
                       	$(document).minTipsBox({
							tipsContent: '不能发送超链接',
							tipsTime: 1
						});
						$('.text-input').val('');
						return false;
                       }
						//alert($('.text-input').val());
						onSendMsg("<?php  echo $this->createMobileurl('addcomment',array('rid'=>$rid))?>");
					}
				//失去焦点
				}).on('blur', '.text-input', function(event) {
					loginInfo.pop=1;
					event.preventDefault();
					if($('.text-input').val() == '') {
						$('.btn-sub').one('click', function(e) {
							e.preventDefault();
							if ($.trim($('.text-input').val()) === '') {
								$(document).minTipsBox({
									tipsContent: '请输入内容',
									tipsTime: 1
								});
								return false;
							}
						});
						$("#mune").empty().removeClass('btn-sub').addClass('iconfont showfun').html('&#xe63b;');
					}
				//礼物列表
				}).on('click', '.gift-list li', function(event) {
					event.preventDefault();
					var $this = $(this);
					var item = $this.index();
					var idName = $this.attr('id');
					$this.addClass("select").siblings().removeClass("select");
					
					if(idName == 'giftReward') {
						$(".sendredbagwin").show();
						$(".zhuang").slideUp('fast');
						$(".allgift").slideUp('fast');
						hideflag = true;
					}else if(idName == 'giftDs'){
						//将主播信息赋值
						personal.uid = founder.uid;
						personal.nickname = founder.nickname;
						personal.headurl = founder.headurl;
						$('.redenvelope .RedPack_Info').find('.packimgs').children('img').attr('src',personal.headurl);
						$('.redenvelope .RedPack_Info').find('p').eq(0).html(personal.nickname);
						//主播红包
						$(".redenvelope").show();
						$(".zhuang").slideUp('fast');
						$(".allgift").slideUp('fast');
						hideflag = true;
					} else {
						//var onemoney = parseInt($this.find('.moneynum').html());
						var onemoney = ($this.find('.moneynum').html());
						
						$('#gift_id').val($this.attr('data-id'));
						$('.countKuang').val(1);
						$(".zhuang").slideDown('fast');
						$('.money').html('￥' + onemoney);
					}
					//加
				}).on('click', '.jia', function(event) {
					var num = $('.countKuang').val();
					$('.countKuang').val(++num);
					$('.gift-list li').each(function(index, el) {
						if($(this).hasClass('select')) {
							var thismoney = parseInt($(this).find('.moneynum').html());
							//var thismoney = ($(this).find('.moneynum').html());
							$('.money').html('￥' + thismoney * num);
						}
					});
					//减
				}).on('click', '.jian', function(event) {
					var num = $('.countKuang').val();
					--num;
					if(num < 2) {
						num = 1;
						$('.countKuang').val(num);
					} else {
						$('.countKuang').val(num);
					}
					$('.countKuang').val(num);
					$('.gift-list li').each(function(index, el) {
						if($(this).hasClass('select')) {
							var thismoney = parseInt($(this).find('.moneynum').html());
							var thismoney = ($(this).find('.moneynum').html());
							$('.money').html('￥' + thismoney * num);
						}
					});
					//更多
				}).on('click', '.functions', function(event) {
					event.preventDefault();
					$(".grap").toggle().css("z-index", "5");
					$(".function-all").slideDown('fast');
					//红包个数
				}).on("input", "#bagAmount", function() {
					calc();
					//总金额
				}).on("input", "#bagMoney", function() {
					calc();
					//留言
				}).on("input", "#bagMessage", function() {
					var _val = $(this).val();
					if(_val.length > 25) {
						$(this).val(_val.substring(0, 25));
					}
					calc();
					//群红包类型
				}).on("click", "#changeRedType", function() {
					pd.bagType = pd.bagType == 1 ? 2 : 1;
					if(pd.bagType == 1) {
						$(".redtype .typemsg").html(zbRedBag.randomText);
						$("#changeRedType").html(zbRedBag.fixedBtn);
						// $(".totalmoney i").show();
						$(".totalmoney").html('总金额<i class="iconfont">&#xe631;</i>');
						calc();
					} else if(pd.bagType == 2) {
						$(".redtype .typemsg").html(zbRedBag.fixedText);
						$("#changeRedType").html(zbRedBag.randomBtn);
						// $(".totalmoney i").hide();
						$(".totalmoney").html('单个金额');
						calc();
					}
					//群红包遮罩
				}).on("click", ".redbagmask", function() {
					$(".sendredbagwin").hide();
					$('.grap').hide();
					//群红包取消
				}).on("click", ".btn-cancel", function() {
					$(".sendredbagwin").hide();
					$('.grap').hide();
					//群红包确认支付
				}).on("click", "#btnSendRedBag", function() {
					calc();
					var ispost = false;
					if(!ispost) {
						pd.bagMessage = $("#bagMessage").val() || $("#bagMessage").attr("placeholder");
						var dbjson = {
							topicId: tid || 0, //话题id
							total_fee: pd.bagMoney, //金额
							byUserId: 1015310, //用户id
							rtype: pd.bagType, //红包类型
							focus: 0,
							nums: pd.bagAmount, //红包数量
							note: pd.bagMessage //红包留言
						};

						ispost = true;

						$.ajax({
							type: "POST",
							url: "<?php  echo $this->createMobileUrl('setpacket',array('rid' => $rid))?>",
							data: dbjson,
							dataType: 'json',
							success: function(result) {
								if(result.s == 1 && result.isweixin == 1) {
									callPay(result.msg,result, dbjson);
								} else if(result.isweixin == 0) {
									$(document).minTipsBox({
										tipsContent: result.tip,
										tipsTime: 1
									});
								} else {
									$(document).minTipsBox({
										tipsContent: result.msg || result.tip,
										tipsTime: 1
									});
								}
							},
							error: function() {
								ispost = false;
								$(document).minTipsBox({
									tipsContent: 'error',
									tipsTime: 1
								});
							}
						});
					}
				//单个红包(列表)
				}).on('click', '.chat_left .iconfont', function(event) {
					personal.uid = $(this).attr('value').split('_')[1];
					personal.nickname = $(this).parents('.chat_left').next().find('.char_name').html().split('<span')[0];
					personal.headurl = $(this).prev().children('img').attr('src');
					$('.redenvelope .RedPack_Info').find('.packimgs').children('img').attr('src',personal.headurl);
					$('.redenvelope .RedPack_Info').find('p').eq(0).html(personal.nickname);
					$(".mask").show();
					$(".redenvelope").show();
				//红包遮罩层关闭
				}).on('click', '.mask', function(event) {
					$(".redenvelope").hide();
					$(".Banned").hide();
					$(".grap").hide();
				//单人红包关闭
				}).on('click', '.cose', function(event) {
					$(".redenvelope").hide();
				//禁言管理关闭
				}).on('click', '.colose', function(event) {
					$(".Bannedmages").hide();
					$(".showfunction").slideUp('fast');
					$(".grap").hide();
					hideflag = true;
				//其他金额弹出
				}).on('click', '.other-m', function(event) {
					$(".two-top").show();
				//其他金额遮罩层关闭
				}).on('click', '.masks', function(event) {
					$(".two-top").hide();
					$('.redlist').hide();
				//头像点击底部向上滑动(拉黑、禁言)
				}).on('click', '.clickhead', function(event) {
					event.preventDefault();
					var user=$(this).attr('user');
					var username=$(this).attr("username");
					$.ajax({
						type: "POST",
						url: "<?php  echo $this->createMobileUrl('getshut',array('rid' => $rid))?>",
						dataType: 'json',
						success: function(result) {
							var ShuttedUinList = result.msg;
							console.log(ShuttedUinList);
							console.log(user);
							console.log(ShuttedUinList.indexOf('"'+user+'"'));
							if(ShuttedUinList.indexOf('"'+user+'"')>0){
								  $('#shutup').attr('onclick','cancelshutup("<?php  echo $this->createMobileUrl('setshut',array('rid' => $rid,'type'=>2))?>","'+user+'","'+username+'")');
								  $('#shutup').html('取消禁言');
							}else{
								  $('#shutup').attr('onclick','shutup("<?php  echo $this->createMobileUrl('setshut',array('rid' => $rid,'type'=>1))?>","'+user+'","'+username+'")');
								  $('#shutup').html('禁言');
							}
						},
						error: function() {
							ispost = false;
							$(document).minTipsBox({
								tipsContent: 'error',
								tipsTime: 1
							});
						}
					});
					
					//$('#black').attr('onclick','black("'+user+'")');
					//$('#black').html('拉黑');
      				$(".grap").show();
					$(".operation").slideDown('fast');
				//关闭底部
				}).on('click', '.opclose', function(event) {
					$(".grap").hide();
					$(".operation").slideUp('fast');
				//最外遮罩层关闭事件
				}).on('click', '.grap', function(event) {
					$('.Banned').hide();
					$(".function-all").slideUp('fast');
					$(".showfunction").slideUp('fast');
					$(".focus-on").hide();
					$(".collection").hide();
					$(".operation").slideUp('fast');
					$('.Banned').hide();
					$(this).removeClass("graps").hide();
					$(".allgift").slideUp('fast');
					hideflag = true;
				//公众号关注弹出
				}).on('click', '.focus-onto', function(event) {
					$(".grap").toggle().css("z-index","5");
					$(".focus-on").toggle();
					$('.qrcode').html('<span class = "focus-on-click">+</span><img src="<?php  echo tomedia($setting['attention_code'])?>"/><p>长按二维码关注公众号</p><p>"关注后可掌握直播最新动态哦"</p>');     
					$('.qrcode').show();
				//公众号关注关闭
				}).on('click','.focus-on-click',function(){
					$(".grap").toggle().css("z-index","5");
					$(".focus-on").toggle();
				//消息取消、撤回
				}).on('click', '.close', function(event) {
					$(this).parents("li").remove();
	
					var str=$(this).parents(".char_message").html().split('<div class="send">');
					if(str[0]!='')
					{
						$.ajax({
                        type: "POST",
                        url: "./deletemsg",
                        data: {tid:loginInfo.tid,msg:str[0],uid:loginInfo.uid},
                        dataType: "json",
                        success: function(data) {
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                           
                        }
                    });
					}
					 
					//sendclose($(this).parents("li")[0].id.replace('seq',''));
				//收藏
				}).on('click', '.function-live ul li', function(event) {
					var item = $(this).index();
					if (item == 0) {
						$(".grap").show().addClass("graps");
						$(".collection").toggle();
					}else if(item == 3){
						
					}else if(item == 1){
						$(".grap").show();
						$(".focus-on").show();
						$(".function-all").slideUp('fast');
					}
				}).on('input', '.text-input', function(event) {
					event.preventDefault();
					if ($(this).val().length >= 1) {
						$("#mune").empty().removeClass('iconfont showfun').addClass('btn-sub').html('发送');
					}else{
						$("#mune").empty().removeClass('btn-sub').addClass('iconfont showfun').html('&#xe63b;');
					}
				//点击红包(显示)
				}).on('click', '.red_message,.lookred', function(event) {
					event.preventDefault();
					var $this = $(this);
					$('.redlist').find('.alllist').children('h5').nextAll().remove();
					if ($this.hasClass('red_message')) {
						red.redid = $this.find('.red-red').attr('value');
						red.toredName = $this.prev().attr('username');
						red.toredHead = $this.parents('.redbao').find('.head_portrait').children('img').attr('src');
					}else if($this.hasClass('lookred')){
						red.redid = $this.attr('value');
					}
					if (red.redid > 0) {
						$.ajax({
							url: "<?php  echo $this->createMobileUrl('checkpacket',array('rid' => $rid))?>",
							type: 'POST',
							dataType: 'json',
							data: {sendid: red.redid},
							success:function(json){
								if(json.status==-1)
								{
							        $(document).minTipsBox({
									tipsContent: json.msg,
									tipsTime: 1
								});
								    return false;
							     }
								red.redtitle = json.redinfo.title;
								red.redtype = json.redinfo.type==1?'随机':'固定';
								red.redMoney = json.redinfo.money;
								red.rednum = json.redinfo.num;
							
								if ($this.hasClass('lookred')) {
									red.toredName = json.redinfo.nickname;
									red.toredHead = json.redinfo.headurl;
								};
								if(json.status==-2)
								{
							        $('.open').find('.packimgs').children('img').attr('src',red.toredHead);
									$('.open').find('.RedPack_Info').children('p').eq(0).html(red.toredName);
									$('.open').find('.openkai').hide();
									$('.open').find('.RedPack_Info').children('p').eq(2).html('该红包已过期');
									$('.open').show();
								    return false;
							     }
								else if (json.status == 0) 
								{
									$('.open').show();
									$('.open').find('.packimgs').children('img').attr('src',red.toredHead);
									$('.open').find('.RedPack_Info').children('p').eq(0).html(red.toredName);
									$('.open').find('.RedPack_Info').children('p').eq(1).html('发了一个红包，金额'+red.redtype+'');
									$('.open').find('.openkai').hide();
									$('.open').find('.RedPack_Info').children('p').eq(2).html('手慢了,红包派完了');	
								}
								else if(json.status==1)
								{
									$('.open').show();
									$('.open').find('.packimgs').children('img').attr('src',red.toredHead);
									$('.open').find('.RedPack_Info').children('p').eq(0).html(red.toredName);
									$('.open').find('.RedPack_Info').children('p').eq(1).html('发了一个红包，金额'+red.redtype+'');
									loginInfo.red=1;
									$('.open').find('.openkai').show();
									$('.open').find('.RedPack_Info').children('p').eq(2).html(red.redtitle);
								}
								else{
									$('.open').hide();
									$('.redlist').show();
									$('.redlist').find('.alllist').children('h5').nextAll().remove();
									$('.redlist').find('.packimgs').children('img').attr('src',red.toredHead);
									var type = red.redtype==1?'<i class="iconfont">&#xe631;</i>':'';
									$('.redlist').find('.RedPack_Info').children('p').eq(0).html(red.toredName+'的红包'+type);
									$('.redlist').find('.RedPack_Info').children('p').eq(1).html(red.redtitle);
									// $('.redlist').find('.RedPack_Info').children('p').eq(2).html();
									$('.redlist').find('.alllist').children('h5').html(red.rednum+'个红包,共'+(red.redMoney/100)+'元');
									var str = '';
									if (json.redlist.length > 0) {
										$.each(json.redlist,function(index, value) {
											if (value.uid == loginInfo.uid) {
												$('.redlist').find('.RedPack_Info').children('p').eq(2).html((value.amount/100)+'元');
											}
											var start = new Date(value.dateline * 1000);
											var times = (start.getMonth() + 1) + '-' + start.getDate() + ' ' + (start.getHours() < 10 ? '0' + start.getHours() : start.getHours()) + ':' + (start.getMinutes() < 10 ? '0' + start.getMinutes() : start.getMinutes());
											str+='<li><img src="'+value.headimgurl+'"><div><p>'+value.nickname.substr(0,5)+'</p><p>'+times+'</p></div><span>'+(value.amount/100)+'元</span></li>';
										});
										$('.redlist').find('.alllist').children('h5').after(str);
									}
								}
							},
							error:function(){
								$(document).minTipsBox({
									tipsContent: 'error',
									tipsTime: 1
								});
							}
						});
					}else{
						$(document).minTipsBox({
							tipsContent: 'error',
							tipsTime: 1
						});
					}
				}).on('click', '.redcenters .cose', function(event) {
					$('.Banned').hide();
					$('.grap').removeClass("graps").hide();
				});
				$(document).on('focus', '#up', function(event) {
					event.preventDefault();
					loginInfo.pop=1;
				}).on('blur', '#up', function(event) {
					event.preventDefault();
					loginInfo.pop=1;
				});;
				// $('.text-input').on('keydown', function(event) {
				// 	event.preventDefault();
				// 	if (event.keyCode == 13) {
				// 		onSendMsg();
				// 	}else{
				// 		return;
				// 	}
				// })
				$(".text-input").keyup(function(event){
			        if(event.keyCode == 13){
			        	if ($('.text-input').val().length == 0 || $('.text-input').val().match(/^\s+$/g)) {
							$(document).minTipsBox({
								tipsContent: '请输入内容',
								tipsTime: 1
							});
							$('.text-input').val('');
						}else{
							//alert($('.text-input').val());
							onSendMsg();
						}
			        }
			    });
               
               $("#allcheck").change(function(){
               	
               	if ($("#allcheck").prop('checked')==true) {
               		allshutup(1);
               	}
               	else
               	{
               		allshutup(0);
               	}
               });
               $("#disimg").change(function(){
               	
               	if ($("#disimg").prop('checked')==true) {
               		disimg(0);
               	}
               	else
               	{
               		disimg(1);
               	}
               });
				//红包(关)
				$('.main').on('click', '#guan', function(event) {
					$('.open').hide();
				//红包开
				}).on('click', '.openkai', function(event) {
					if(loginInfo.red!=1)
						{
							return false;
						}
						loginInfo.red=0;
					$(this).addClass('rey');
					$('.redlist').find('.alllist').children('h5').nextAll().remove();
					var type = red.redtype==1?'<i class="iconfont">&#xe631;</i>':'';
					$('.redlist').find('.packimgs').children('img').attr('src',red.toredHead);
					$('.redlist').find('.RedPack_Info').children('p').eq(0).html(red.toredName+'的红包'+type);
					$('.redlist').find('.RedPack_Info').children('p').eq(1).html(red.redtitle);
					$('.redlist').find('.alllist').children('h5').html(red.rednum+'个红包,共'+(red.redMoney/100)+'元');
					if (red.redid > 0) {
						$.ajax({
							url: "<?php  echo $this->createMobileUrl('getpacket',array('rid' => $rid))?>",
							type: 'POST',
							dataType: 'json',
							data: {sendid: red.redid},
							success:function(json){
								var str = '';
								if(json.status==-2)
								{
									$('.open').find('.RedPack_Info').children('p').eq(2).html('该红包已过期');
									$('.openkai').hide();
								}
								else if(json.status==-1)
								{
								  	 $(document).minTipsBox({
									tipsContent: '出错了',
									tipsTime: 1
								});
								    return false;
								}
								else if(json.status==0)
								{
                                    $('.open').show();
									$('.open').find('.openkai').hide();
									$('.open').find('.RedPack_Info').children('p').eq(2).html('手慢了,红包派完了');	
								}
								else if(json.status==2)
								{
									if (json.redlist.length > 0) {
										$.each(json.redlist,function(index, value) {
											
											if (value.uid == loginInfo.uid) {
												$('.redlist').find('.RedPack_Info').children('p').eq(2).html((value.amount/100)+'元');
											}
											var start = new Date(value.dateline * 1000);
											var times = (start.getMonth() + 1) + '-' + start.getDate() + ' ' + (start.getHours() < 10 ? '0' + start.getHours() : start.getHours()) + ':' + (start.getMinutes() < 10 ? '0' + start.getMinutes() : start.getMinutes()) ;
											str+='<li><img src="'+value.headimgurl+'"><div><p>'+value.nickname+'</p><p>'+times+'</p></div><span>'+(value.amount/100)+'元</span></li>';
										});
										$('.redlist').find('.alllist').children('h5').after(str);
									}
								$('.open').hide();	
								$('.redlist').show();
								}

								$('.openkai').removeClass('rey');
								
							},
							error:function(){
								$(document).minTipsBox({
									tipsContent: 'error',
									tipsTime: 1
								});
							}
						});
					}else{
						$(document).minTipsBox({
							tipsContent: 'error',
							tipsTime: 1
						});
					}
					
				//关闭抢红包列表
				}).on('click', '#redlistcose', function(event) {
					$('.redlist').hide();
				}).on('click', '.mar10', function(event) {
					event.preventDefault();
					$('.open').hide();
					$('.redlist').show();
				//查看红包领取情况(查看而已)
				}).on('click', '.mar10', function(event) {
					event.preventDefault();
					$('.rednull').html('');
					$('.open').hide();
					$('.redlist').show();
					$('.redlist').find('.alllist').children('h5').nextAll().remove();
					$('.redlist').find('.packimgs').children('img').attr('src',red.toredHead);
					var type = red.redtype==1?'<i class="iconfont">&#xe631;</i>':'';
					$('.redlist').find('.RedPack_Info').children('p').eq(0).html(red.toredName+'的红包'+type);
					$('.redlist').find('.RedPack_Info').children('p').eq(1).html(red.redtitle);
					// $('.redlist').find('.RedPack_Info').children('p').eq(2).html();
					$('.redlist').find('.alllist').children('h5').html(red.rednum+'个红包,共'+(red.redMoney/100)+'元');
					$.ajax({
						url: "<?php  echo $this->createMobileUrl('checkpacket',array('rid' => $rid))?>",
						type: 'POST',
						dataType: 'json',
						data: {sendid: red.redid},
						success:function(json){
							var str = '';
							if (json.redlist.length > 0) {
								$.each(json.redlist,function(index, value) {
									if (value.uid == loginInfo.uid) {
										$('.redlist').find('.RedPack_Info').children('p').eq(2).html((value.amount/100)+'元');
									}
									var start = new Date(value.dateline * 1000);
									var times = (start.getMonth() + 1) + '-' + start.getDate() + ' ' + (start.getHours() < 10 ? '0' + start.getHours() : start.getHours()) + ':' + (start.getMinutes() < 10 ? '0' + start.getMinutes() : start.getMinutes());
									str+='<li><img src="'+value.headimgurl+'"><div><p>'+value.nickname+'</p><p>'+times+'</p></div><span>'+(value.amount/100)+'元</span></li>';
								});
								$('.redlist').find('.alllist').children('h5').after(str);
							}
						},
						error:function(){
							$(document).minTipsBox({
								tipsContent: 'error',
								tipsTime: 1
							});
						}
					});
				});

				$('.c-money li').on('click', function(event) {
					event.preventDefault();
					var $this = $(this);
					// personal.uid = _str.split('_')[1];
					
					var rewardjson1 = {
						money: $this.attr('data-money') || 0,
						touid: personal.uid || 0,  
						type: '1',
						tonickname: personal.nickname || '',
						toheadurl: personal.headurl || '',
						tid: tid || 0
					};
					$.ajax({
						url: "<?php  echo $this->createMobileUrl('setreward',array('rid' => $rid))?>",
						type: 'POST',
						dataType: 'json',
						data: rewardjson1,
						success:function(result){
							if(result.s == 1 && result.isweixin == 1) {
								callPay(result.msg,result);
							} else if(result.isweixin == 0) {
								$(document).minTipsBox({
									tipsContent: result.tip,
									tipsTime: 1
								});
							} else {
								$(document).minTipsBox({
									tipsContent: result.msg || result.tip,
									tipsTime: 1
								});
							}
						},
						error: function() {
							$(document).minTipsBox({
								tipsContent: 'error',
								tipsTime: 1
							});
						}
					});
				});

				//其他金额(输入框)
				$('#othermoney').on('input', function(event) {
					var money = $(this).val();
					if (/\s+/.test(money)) {
						return;
					};
					if (money >= 0.01 && money <= 1000) {
						$('.font-s').removeAttr('disabled');
					}else{
						$(".font-s").attr("disabled", "disabled");
					}
				});
				//其他金额确认按钮
				$('.font-s').on('click', function(event) {
					var rewardjson2 = {
						money: parseFloat($('#othermoney').val()).toFixed(2) || 0.01,
						touid: personal.uid || 0,  //打赏人uid/主播uid
						type: '2',
						tonickname: personal.nickname || '',
						toheadurl: personal.headurl || '',
						tid: tid || 0
					};
					$.ajax({
						url: "<?php  echo $this->createMobileUrl('setreward',array('rid' => $rid))?>",
						type: 'POST',
						dataType: 'json',
						data: rewardjson2,
						success:function(result){
							if(result.s == 1 && result.isweixin == 1) {
								
								callPay(result.msg,result);
							} else if(result.isweixin == 0) {
								$(document).minTipsBox({
									tipsContent: result.tip,
									tipsTime: 1
								});
							} else {
								$(document).minTipsBox({
									tipsContent: result.msg || result.tip,
									tipsTime: 1
								});
							}
						},
						error: function() {
							$(document).minTipsBox({
								tipsContent: 'error',
								tipsTime: 1
							});
						}
					});
				});
				//礼物支付
				$('.give').on('click', function(event) {
					var i = 0;
					$('.gift-list li').each(function(index, el) {
						if ($(this).hasClass('select')) {
							i++;
							var giftjson = {
								num: parseInt($('.countKuang').val()) || 1,
								item: index,
								id: $("#gift_id").val(),
								touid: founder.uid || 0,
								tid: tid || 0
							};
							$.ajax({
								url: "<?php  echo $this->createMobileUrl('setgift',array('rid' => $rid))?>",
								type: 'POST',
								dataType: 'json',
								data: giftjson,
								success:function(result){
									if(result.s == 1 && result.isweixin == 1) {
										
										callPay(result.msg,result);
									} else if(result.isweixin == 0) {
										$(document).minTipsBox({
											tipsContent: result.tip,
											tipsTime: 1
										});
									} else {
										$(document).minTipsBox({
											tipsContent: result.msg || result.tip,
											tipsTime: 1
										});
									}
								},
								error: function() {
									$(document).minTipsBox({
										tipsContent: 'error',
										tipsTime: 1
									});
								}
							});
						}
					});
					//无选中状态
					if (i < 1) {
						$(document).minTipsBox({
							tipsContent: '请选中礼物',
							tipsTime: 1
						});
					};
				});
				//支付
				function callPay(json,data, otherdata) {
					
					if(typeof WeixinJSBridge == "undefined") {
					
						if(document.addEventListener) {
							document.addEventListener('WeixinJSBridgeReady', jsApiCall(json, otherdata), false);
						} else if(document.attachEvent) {
							document.attachEvent('WeixinJSBridgeReady', jsApiCall(json, otherdata));
							document.attachEvent('onWeixinJSBridgeReady', jsApiCall(json, otherdata));
						}
					} else {
					
						jsApiCall(json,data, otherdata);
					}
				}
				//支付
				function jsApiCall(obj,data, otherdata) {
					if(obj.status == 1) {
						console.log(data);
						WeixinJSBridge.invoke(
							'getBrandWCPayRequest', {
								"appId": "" + obj.appId + "",
								"timeStamp": "" + obj.timeStamp + "",
								"nonceStr": "" + obj.nonceStr + "",
								"package": "" + obj.package + "",
								"signType": "" + obj.signType + "",
								"paySign": "" + obj.paySign + "",
							},
							function(res) {
								if(res.err_msg == 'get_brand_wcpay_request:ok') {
                                    $('.grap').hide();
									$(".two-top").hide();
									$(".redenvelope").hide();
									$(".zhuang").slideUp('fast');
									$(".allgift").slideUp('fast');
									loginInfo.type=data.type;
									if(data.type=='grouppacket'){
										$.ajax({
											url: "<?php  echo $this->createMobileUrl('singlep',array('rid' => $rid))?>",
											type: 'POST',
											dataType: 'json',
											data: {'id':data.id},
											success:function(r){
												if(r.s == 1) {
													loginInfo.id=r.id;
													tis.SendMessage(r.content,'',JSON.stringify(loginInfo));
												}
											}
										});
									}else if(data.type=='gift'){
										$.ajax({
											url: "<?php  echo $this->createMobileUrl('singleg',array('rid' => $rid))?>",
											type: 'POST',
											dataType: 'json',
											data: {'id':data.id},
											success:function(r){
												if(r.s == 1) {
													loginInfo.id=r.id;
													tis.SendMessage(r.content,'',JSON.stringify(loginInfo));
												}
											}
										});
									}else{
										loginInfo.id=data.id;
										tis.SendMessage(data.content,'',JSON.stringify(loginInfo));
									}
									
									
									
									$(document).minTipsBox({
										tipsContent: "红包发送成功",
										tipsTime: 1
									});
									$(".sendredbagwin").hide();
								} else if(res.err_msg != "get_brand_wcpay_request:cancel") {
									//失败调起扫码
									setTimeout(function() {
										qrpay(otherdata)
									}, 500);
								}
							}
						);
					} else {
						alert(obj.res);
					}
				}
				//扫码支付
				function qrpay(otherdata) {
					$(document).minTipsBox({
						tipsContent: "准备付款",
						tipsTime: 1
					});

					$.ajax({
						type: "POST",
						url: "/Index/redpay?type=qr",
						data: otherdata,
						dataType: "json",
						success: function(data) {
							if(data.isok) {
								// $(".redbagBox").hide();
								// $("#payqrcode").attr("src", "/live/nt?data=" + data.Msg);
								// $(".QRcodePay").show();
							} else {
								$(document).minTipsBox({
									tipsContent: data.Msg,
									tipsTime: 1
								});
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							$(document).minTipsBox({
								tipsContent: "支付失败",
								tipsTime: 1
							});
						}
					});
				}
				//群红包输入框判断
				function calc() {
					var amountline = $("#bagAmount").closest(".line");
					var moneyline = $("#bagMoney").closest(".line");
					var servicemoneyline = $(".service-money");
					if(/\s+/.test($("#bagAmount").val()) || /\s+/.test($("#bagMoney").val())) {
						return;
					}
					// if (/^0{1}([.]\d{1,2})?$|^[1-9]\d*([.]{1}[0-9]{1,2})?$/.test($("#bagMoney").val()) == false) {
					// 	$("#bagMoney").val($("#bagMoney").val().substring(0,$("#bagMoney").val().length-1));
					// }

					var bagamount = parseInt($("#bagAmount").val()) || 0;
					var bagmoney = parseFloat($("#bagMoney").val()) || 0;
					//随机
					if (pd.bagType == 1) {
						pd.bagMoney = bagmoney.toFixed(2);
					//固定
					}else if(pd.bagType == 2){
						pd.bagMoney = parseFloat((bagamount*bagmoney).toFixed(2));
					}
					pd.bagAmount = bagamount;
					

					if(bagamount <= 0) {
						amountline.addClass("line-error");
						msgbar.html(zbRedBag.msg1).show();

					} else {
						amountline.removeClass("line-error");
						msgbar.html("").hide();
					}

					if (pd.bagType == 1) {
						if((pd.bagMoney / pd.bagAmount) < minMoney) {
							moneyline.addClass("line-error");
							msgbar.html(zbRedBag.msg2).show();
						} else {
							moneyline.removeClass("line-error");
							msgbar.html("").hide();

						}
					}else{
						if (pd.bagMoney < 0.01) {
							moneyline.addClass("line-error");
							msgbar.html(zbRedBag.msg2).show();
						}
					}
					// pd.bagServiceMoney=pd.bagMoney*0.02;
					// pd.bagServiceMoney = pd.bagMoney*0;
					bag_money_show.text(pd.bagMoney);

					if(pd.bagAmount > 0 && pd.bagMoney > 0 ) {
						if (pd.bagType == 1) {
							if ((pd.bagMoney / pd.bagAmount) >= minMoney) {
								$("#btnSendRedBag").removeAttr("disabled");
							} else {
								$("#btnSendRedBag").attr("disabled", "disabled");
							}
						}else{
							if (bagmoney >= 0.01) {
								$("#btnSendRedBag").removeAttr("disabled");
							} else {
								$("#btnSendRedBag").attr("disabled", "disabled");
							}
						}
						
					} else {
						$("#btnSendRedBag").attr("disabled", "disabled");

					}
					// $(".service-money em").text(parseFloat(pd.bagServiceMoney).toFixed(2));
					// pd.bagServiceMoney > 0 ? servicemoneyline.show() : servicemoneyline.hide();
				}
				//弹窗提示
				(function($) {
					$.fn.extend({
						"minTipsBox": function(options) {
							options = $.extend({
								tipsContent: "", //提示内容
								tipsTime: 1 //停留时间 , 1 等于 1秒
							}, options);
							var $minTipsBox = ".min_tips_box";
							var $tipsContent = ".min_tips_box .tips_content";
							var $tipsTime = parseFloat(options.tipsTime) * 1000;
							//弹出框html代码
							var $minTipsBoxHtml = '<div class="min_tips_box">' +
								'<b class="bg"></b>' +
								'<span class="tips_content"></span>' +
								'</div>';
							//判断是否有提示框
							if($($minTipsBox).length > 0) {
								$($minTipsBox).show();
								resetBox();
								setTimeout(function() {
									$($minTipsBox).hide();
								}, $tipsTime);
							} else {
								$($minTipsBoxHtml).appendTo("body");
								resetBox();
								setTimeout(function() {
									$($minTipsBox).hide();
								}, $tipsTime);
							}
							//重置提示框属性
							function resetBox() {

								$($tipsContent).html(options.tipsContent);
								var tipsBoxLeft = $($tipsContent).width() / 2 + 10;
								$($tipsContent).css("margin-left", "-" + tipsBoxLeft + "px");
							}
						}
					});
				})(jQuery);

				var rankflag = true;
				//tab切换
				$(".TAstate").find("li").each(function(index) {
					$(this).click(function() {
						$(this).addClass("currentli").siblings().removeClass("currentli");
						$(".showthisd").eq($(this).index()).show().siblings(".showthisd").hide();
						if ($(this).index() > 0) {
							//$('.cont-right').hide();
							$('.gun').hide();
						}else{
							//$('.cont-right').show();
							$('.gun').show();
						}
						if($(this).attr('data-type')=='3'){
							$('.cont-right').show();
						}else{
							$('.cont-right').hide();
						}
	
						if($(this).attr('data-type')=='5')
						{
							<?php  if($rankid) { ?>
							rank(<?php  echo $rankid;?>,$(".rankpm div p").length);
							
							<?php  } ?>
						}
						if($(this).attr('data-type')=='7')
						{
							panic();
						}
					})
				});
				//进来广告
				$(".readcolse").click(function() {
					$(".reading").hide();
				})

			})
		</script>
		<script>


			///var accountMode = 1;
			//var sdkAppID = '1400016757';
			//var accountType = 7911;

			//var avChatRoomId = 'group_2201'; //'49'; 

			//if(webim.Tool.getQueryString("groupid")) {
			//	avChatRoomId = webim.Tool.getQueryString("groupid");
			//}

			//var selType = webim.SESSION_TYPE.GROUP;
			//var selToID = avChatRoomId;
			//var selSess = null;

			//默认群组头像(选填)
			var selSessHeadUrl = 'img/2017.jpg';
			var friendHeadUrl = 'img/2017.jpg';

			var nickname;
            var isadmin=0;
            var roomadmin='<?php  echo $roomadmin;?>';
            //var ShuttedUinList='[{"uid":"1647"},{"uid":"1115"},{"uid":"97"}]';

            if(roomadmin.indexOf('"'+'<?php  echo $user["id"];?>'+'"')>0)
            {
               isadmin=1;
			   $('.showfunction').append('<li><a href="<?php  echo $this->createMobileUrl("pictv",array("rid"=>$rid))?>"><p><i class="iconfont"></i></p><p>图文直播</p></a></li><li class="functions"><p><i class="iconfont">&#xe61e;</i></p><p>禁言管理</p></li><li onclick="showshutup();"><p><i class="iconfont">&#xe632;</i></p><p>禁言列表</p></li>');	
               
                             	 $('#send_msg_text').removeAttr('readonly');
								$('#send_msg_text').attr('placeholder','和大伙说点什么吧');
                         
            }
			//当前用户身份
			var loginInfo = {
				'identifier': 'user_<?php  echo $user["id"];?>', //当前用户ID,必须是否字符串类型，选填
				'uid':'<?php  echo $user["id"];?>',
				'identifierNick': '<?php  echo $user["nickname"];?>', //当前用户昵称，选填
				'headurl': '<?php  echo $user["headimgurl"];?>', //当前用户默认头像，选填
				'isadmin':isadmin,
				'i':"<?php  echo $_W['uniacid'];?>",
				'total':"<?php  echo $item['real_num'];?>",
				'xtotal':"<?php  echo $item['total_num'];?>",
				'rid':'<?php  echo $rid;?>',
				'allshutup':'<?php  echo $item["isallshutup"];?>',
				'disimg':'0',
				'pop':0,
				'limit':"<?php  echo $limit;?>",
				'shutup':<?php  echo $shutup;?>,
				'zantime':10,
				'reward':"<?php  echo intval($dashangsetting['isshow'])?>",
				'siteroot':"<?php  echo $_W['siteroot'];?>",
				'zanN':<?php  echo $totalzannum;?>
			};
			


			function imageClick(obj) {
			
			}

			var page = 1;

			$('.chat_title').on('scroll', function(event) {

				var $this =$(this),  
				viewH =$(this).height(),//可见高度  
				contentH =$(this).get(0).scrollHeight,//内容高度  
				scrollTop =$(this).scrollTop();//滚动高度  

				var h = contentH-viewH;
				if (scrollTop == 0) {
				$.post("<?php  echo $this->createMobileurl('commentpage',array('rid'=>$rid))?>",{page:page}, function(data) {
					
					if(data.s==1){
						var str = '';
						$.each(data.content, function(index, value) {
							var start = new Date(value.dateline * 1000);
							var times = start.getFullYear() + '-' + (start.getMonth() + 1) + '-' + start.getDate() + ' ' + (start.getHours() < 10 ? '0' + start.getHours() : start.getHours()) + ':' + (start.getMinutes() < 10 ? '0' + start.getMinutes() : start.getMinutes()) + ':' + (start.getSeconds() < 10 ? '0' + start.getSeconds() : start.getSeconds());
							var adminstr='';	
							var identifierUser="user_"+value.uid;	
							if(roomadmin.indexOf('"'+identifierUser.replace('user_','')+'"')>0)
							{
								adminstr='<span class="sec"> (管理员) </span>';  
							}else{
								<?php  if($limit==0) { ?>
								adminstr='<span class="sec"> (会员) </span>';  
								<?php  } ?>
							}
							switch (value.type) {
								case 'comment':
									str+='<li><div class="chat_left">';  
									if(value.ispic==1){
										if(roomadmin.indexOf('"'+identifierUser.replace('user_','')+'"')>0){
											str+='<div class="head_portrait"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+value.uid+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname+adminstr+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertImageMsgToHtml(value)+'<div class="send"></div></div></div></li>';
										}else{
											if(loginInfo.isadmin==1){
												str+='<div class="head_portrait clickhead" user="user_'+value.uid+'" username="'+value.nickname+'"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+value.uid+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname.substr(0,5)+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertImageMsgToHtml(value)+'<div class="send"></div></div></div></li>'; 
											}else{
												str+='<div class="head_portrait"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+value.uid+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname.substr(0,5)+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertImageMsgToHtml(value)+'<div class="send"></div></div></div></li>';
											}
										}   
									}else{
										if(identifierUser==loginInfo.identifier){
											str+='<div class="head_portrait"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+identifierUser+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname.substr(0,5)+adminstr+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertTextMsgToHtml(value.content)+'<div class="send"></div></div></div></li>'; 
										}else{
											if(roomadmin.indexOf('"'+identifierUser.replace('user_','')+'"')>0){
												str+='<div class="head_portrait"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+identifierUser+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname.substr(0,5)+adminstr+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertTextMsgToHtml(value.content)+'<div class="send"></div></div></div></li>';
											}else{
												if(loginInfo.isadmin==1){
													str+='<div class="head_portrait clickhead" user="'+identifierUser+'" username="'+value.nickname+'"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+identifierUser+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname.substr(0,5)+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertTextMsgToHtml(value.content)+'<div class="send"></div></div></div></li>'; 
												}else{
													str+='<div class="head_portrait"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+identifierUser+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name">'+value.nickname.substr(0,5)+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message">'+convertTextMsgToHtml(value.content)+'<div class="send"></div></div></div></li>';
												}
											}
										}   
									}
									break;
								case 'gift':
									str+='<p class="red-tishi">';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+identifierUser+'">&#xe8be;</i>';
											}
											str+=''+value.content+'</p>';
									break;
								case 'reward':
									str+='<p class="red-tishi">'+value.content+'</p>';
									break;
								case 'grouppacket':
									str+='<li class="redbao"><div class="chat_left"><div class="head_portrait"><img src="'+value.headimgurl+'"></div>';
											if(loginInfo.reward==1){
												str+='<i class="iconfont" value="'+identifierUser+'">&#xe8be;</i>';
											}
											str+='</div><div class="chat_right"><div class="char_name" username="'+value.nickname+'">'+value.nickname.substr(0,5)+adminstr+'<span style="display:block;color:gray;font-size:12px;">'+times+'</span></div><div class="char_message red_message"><div class="red-red" value="'+value.id+'"><img src="<?php echo MODULE_URL;?>template/mobile/2/image/hongbao.png" height="45px"><div class="red-cent"><p class="red-title">'+value.content+'</p><p>领取红包</p></div></div><div class="send"></div><div class="red_name"><span class = "red_name1">直播间</span><span class = "red_name2">红包</span></div></div></div></li>';
									break;
							};
						});
						$('#msghistory').prepend(str);

						$('.chat_title').scrollTop(($this.get(0).scrollHeight-$this.height())-h);
						page++;
					}
					
					
				},'json');
				
				}
			});
            
function shutuplist(url) {
    $('.shutuplist').html('');
	$.ajax({
		type: "POST",
		url: url,
		dataType: 'json',
		success: function(result) {
			var str='';
			console.log(result.list.length);
			for(var i=0;i<result.list.length;i++){
				str+='<li><img src="'+result.list[i].headimgurl+'"/><div><p>'+result.list[i].nickname+'</p></div><span onclick=cancelshutup("<?php  echo $this->createMobileUrl('setshut',array('rid' => $rid,'type'=>2))?>","user_'+result.list[i].touid+'","'+result.list[i].nickname+'")>移除</span></li>';
			}
			$('.shutuplist').append(str);
		},
		error: function() {
			ispost = false;
			$(document).minTipsBox({
				tipsContent: 'error',
				tipsTime: 1
			});
		}
	});
}
function showshutup()
{
	shutuplist("<?php  echo $this->createMobileUrl('getshut',array('rid' => $rid))?>");
	$('.Banned').show();
	$(".function-all").slideUp('fast');										
	$(".showfunction").slideUp('fast');		
	hideflag = true;								
}
function allshutup(type)
{
    $.ajax({
                        url: "<?php  echo $this->createMobileUrl('setallshut',array('rid' => $rid))?>",
                        type: 'POST',
                        dataType: 'json',
                        data: {allshutup:type},
                        success:function(result){
							if(type == 1) {
							//sendallshutup();
								loginInfo.type = 'allshutup';
								loginInfo.allshutup=1;
								tis.SendMessage('全员禁言中','',JSON.stringify(loginInfo));
								if(loginInfo.isadmin!=1)
								{
									$('#send_msg_text').attr('readonly','true');
									$('#send_msg_text').attr('placeholder','全员禁言中');
								}

							}
							else
							{
								loginInfo.type = 'cancelallshutup';
								loginInfo.allshutup=0;
								tis.SendMessage('全员禁言中','',JSON.stringify(loginInfo));
								$('#send_msg_text').removeAttr('readonly');
								$('#send_msg_text').attr('placeholder','和大伙说点什么吧');
								
							}
                        }
                    });
    
}	
function disimg(type)
{

    $.ajax({
                        url: './disimg',
                        type: 'POST',
                        dataType: 'json',
                        data: {tid:'2201',disimg:type},
                        success:function(result){
                            if(result.status == 1) {
                             senddisimg();
       loginInfo.disimg=1;
                            }
                            else
                            {
                             sendimgcancel();
       loginInfo.disimg=0;
                            }
                        }
                    });
    
}			

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
	<script>
	window.onload = function(){
		//$('.chat_title').scrollTop($('.chat_title').get(0).scrollHeight-$('.chat_title').height());
		if(<?php  echo $ditu;?>==1){
			init();
		}
		if(<?php  echo $shutup;?>){
			$('#send_msg_text').attr('readonly','true');
			$('#send_msg_text').attr('placeholder','您已被禁言');
		}

		if("<?php  echo $item['isallshutup'];?>"==1){
			$("#allcheck").prop("checked", true);
			if(loginInfo.isadmin !=1){
				$('#send_msg_text').attr('readonly','true');
				$('#send_msg_text').attr('placeholder','全员禁言中');  
			}
		}else{
			$("#allcheck").prop("checked", false);
		}
		if("<?php  echo $menusss[0]['type'];?>"==7){
			panic();
		}
		if("<?php  echo $menusss[0]['type'];?>"==3){
			$(".cont-right ").show();
		}
		//switch开关
		if ("<?php  echo $item['isallshutup'];?>"==1) {
			$(".bannerdbtn").children('em').removeClass('btn-movel').addClass('btn-mover').parent().css({backgroundColor: '#31ac82'});
		} else{
			 $(".bannerdbtn").children('em').removeClass('btn-mover').addClass('btn-movel').parent().css({backgroundColor: '#ccc'});
		}

		$(".bannerdbtn").on('click', function(event) {
			if ($(this).children('em').hasClass('btn-mover')) {
				$(this).children('em').removeClass('btn-mover').addClass('btn-movel').parent().css({backgroundColor: '#ccc'});
			}
			else {
				$(this).children('em').removeClass('btn-movel').addClass('btn-mover').parent().css({backgroundColor: '#31ac82'});
			};

		});

	}	
	</script>
<script>
$(function(){ 
	initEmotionUL();
	//setInterval("showMsg('<?php  echo $this->createMobileurl('getmsg',array('rid'=>$rid))?>')", 5000);
	setInterval("showPic('<?php  echo $this->createMobileurl('getpictv',array('rid'=>$rid))?>')", 6000);
}); 
</script>
<script type="text/javascript">
var body= $(".main").width();
var vedio=body*0.56;
$(".block_video").height(vedio);
var image = "<?php  echo tomedia($list['settings']['img'])?>";//封面图片
var a=0;
var se;
var u = navigator.userAgent;
var video_status = null;
var vedio_an = vedio+52;

var isandroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
       if(isandroid==true)
       {
window.onresize = function(){
if(loginInfo.pop==1)
{
	loginInfo.pop=0;
	return false;
}
$('.watermark p').css("top","66px");
$('.watermark .vp').css("top","56px");
$(".block_video").height(vedio_an);
$('#html5Media2').css("object-position","0px 52px");
$(".header-an").show();
if (video_status == 0) {
	var timer1 = setTimeout(function() {
			$(".schedule").hide();
		}, 5000)
	$(".all-vide").on('click',function(event) {
		event.preventDefault();
		if ($(".schedule").css("display") == "none") {
			$(".schedule").show();
			timer1 = setTimeout(function() {
				$(".schedule").hide();
			}, 5000)
		} else {
			$(".schedule").hide();
		}
		$(".schedule").on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			clearTimeout(timer1);
			$(".schedule").show();
			timer1 = setTimeout(function() {
				$(".schedule").hide();
			}, 6000)
		});
	});
};
$('#html5Media2').attr('width',$(window).width()+'px');
$('#html5Media2').attr('height',$(window).height()+'px');
$('.advertising').hide();
var height = $(window).height();//窗口可视高度1019
var foot=$(".footer").height(); //底部固定高度
var TAstate=$(".TAstate").height() //tab切换高度
// var gun=$(".gun").height(); //文字滚动的高度
$(".live").css("height",height-vedio_an-foot-TAstate);
var bj=height-vedio-TAstate;
$('.TAstate').css('z-index','3');
if(a==0){
	a=1;
	$('.max-start').hide();
	if(loginInfo.isend==1)
	{
	 $('.schedule').show();
	}
	$('#html5Media2').attr('x5-video-player-type','h5');
	$('#html5Media2').attr('x5-video-player-fullscreen',true);
	$(".minh .allconts").css({'overflow':'scroll', 'overflow-x':'hidden','height':bj,'background-color':'#fff','padding-bottom':'30px'});
}else{
	a=0;
	$('.schedule').hide();
	$('#html5Media2').attr('x5-video-player-type','h5');
	$('#html5Media2').attr('x5-video-player-fullscreen',true);
	$(".minh .allconts").css({'overflow':'', 'overflow-x':'','height': '','background-color':'','padding-bottom':''});
}

}
}
function panic()
{
	$('.goods-box').hide();
	$('.goods-box').html('');
	var nowtime=0;
	$.ajax({
								url: "<?php  echo $this->createMobileurl('store',array('rid'=>$rid))?>",
								type: 'POST',
								dataType: 'json',
								data: {tid:'2201'},
								success:function(json){
									var str = '';
									$.each(json.msg,function(index,value) {

										str+='<div class="goods-list clearfix"><div class="list-l"><img src="'+value.img+'"/></div><div class="list-r"><p class="r-name">'+value.title+'</p><div class="r-bottom clearfix"><p class="r-price"><span>￥</span><em>'+value.price+'</em></p>';
										if(index==0)
						                   {
						                    nowtime=value.nowtime;
						                   }
                                        if(value.endtime < nowtime)
                                         {
                                          str+='<a class="r-sub r-sub2" href="javascript:void(0);">已结束</a>';
                                           }
								        else
								        {  
								        	if(value.startime>nowtime)
								        	{
                                             str+='<a class="r-sub r-sub2 panic" href="javascript:void(0);" value="'+value.startime+'" hashref="'+value.link+'"></a>';
								        	}
								        	else
								        	{
								        		str+='<a class="r-sub r-sub2" href="'+value.link+'">马上买</a>';
								        	}
								        	
								        }
											str+='</div></div></div>';	
										    
											});
                                            $('.goods-box').append(str);
											var gW = $(".TAstate").width()*0.36;
											var gH = parseInt(gW*0.58);
											$(".list-l").height(gH);
											$(".list-r").height(gH);
											$('.goods-box').show();
											window.clearInterval(se);
											countdown(nowtime*1000);
								         }
								     });				
}
function countdown(nowtime){

	se=setInterval(function() {
   nowtime=parseInt(nowtime)+100;
	$(".panic").each(function() { 
		if(parseInt($(this).attr('value'))>100)
		{
	 var endTime = new Date(parseInt($(this).attr('value')) * 1000); 
            var nMS = endTime.getTime() - nowtime; 

             //console.log(endTime.getTime() +'==='+ nowtime);
            var myD = Math.floor(nMS / (1000 * 60 * 60 * 24)); 
            var myH = (Math.floor(nMS / (1000 * 60 * 60)) % 24 + myD*24)<10?"0"+(Math.floor(nMS / (1000 * 60 * 60)) % 24 + myD*24):(Math.floor(nMS / (1000 * 60 * 60)) % 24 + myD*24);
            var myM = (Math.floor(nMS / (1000 * 60)) % 60)<10?"0"+(Math.floor(nMS / (1000 * 60)) % 60):(Math.floor(nMS / (1000 * 60)) % 60); 
            var myS = (Math.floor(nMS / 1000) % 60)<10?"0"+(Math.floor(nMS / 1000) % 60):(Math.floor(nMS / 1000) % 60); 
            var myMS = Math.floor(nMS / 100) % 10; 
                  
            if (myD >= 0) { 
                var str = myH + ":" + myM + ":" + myS + ":" + myMS; 
             }
            else { 
                var str = "马上抢"; 
                $(this).attr('href',$(this).attr('hashref'));
            } 

          $(this).html(str); 
}})},100);
}
function fullscreen()
{
	$('#html5Media2').attr('x5-video-player-type','');
	$('#html5Media2').attr('x5-video-player-fullscreen',false);
	document.getElementById('html5Media2').play();
}
function rank(num,i){

	if(num==1){
		if(i==1){
			$('.nav-btn1').attr('class','nav-btn1 nav-btn7  nav-select');
		}else{
			$('.nav-btn1').attr('class','nav-btn1 nav-select');
		}
		$('.nav-btn1').attr('class','nav-btn1 nav-select');
		$('.nav-btn2').attr('class','nav-btn2 nav-unselect');
		$('.nav-btn3').attr('class','nav-btn3 nav-unselect');
		$('.nav-btn4').attr('class','nav-btn4 nav-unselect');
		$('.nav-btn5').attr('class','nav-btn5 nav-unselect');
	}else if(num==2){
		$('.nav-btn1').attr('class','nav-btn1 nav-unselect');
		if(i==2){
			$('.nav-btn2').attr('class','nav-btn2 nav-btn7  nav-select');
		}else{
			$('.nav-btn2').attr('class','nav-btn2 nav-select');
		}
		$('.nav-btn3').attr('class','nav-btn3 nav-unselect');
		$('.nav-btn4').attr('class','nav-btn4 nav-unselect');
		$('.nav-btn5').attr('class','nav-btn5 nav-unselect');
	}else if(num==3){
		$('.nav-btn1').attr('class','nav-btn1 nav-unselect');
		$('.nav-btn2').attr('class','nav-btn2 nav-unselect');
		if(i==3){
			$('.nav-btn3').attr('class','nav-btn3 nav-btn7  nav-select');
		}else{
			$('.nav-btn3').attr('class','nav-btn3 nav-select');
		}
		$('.nav-btn4').attr('class','nav-btn4 nav-unselect');
		$('.nav-btn5').attr('class','nav-btn5 nav-unselect');
	}else if(num==4){
		$('.nav-btn1').attr('class','nav-btn1 nav-unselect');
		$('.nav-btn2').attr('class','nav-btn2 nav-unselect');
		$('.nav-btn3').attr('class','nav-btn3 nav-unselect');
		if(i==4){
			$('.nav-btn4').attr('class','nav-btn4 nav-btn7  nav-select');
		}else{
			$('.nav-btn4').attr('class','nav-btn4 nav-select');
		}
		$('.nav-btn5').attr('class','nav-btn5 nav-unselect');
	}else if(num==5){
		$('.nav-btn1').attr('class','nav-btn1 nav-unselect');
		$('.nav-btn2').attr('class','nav-btn2 nav-unselect');
		$('.nav-btn3').attr('class','nav-btn3 nav-unselect');
		$('.nav-btn4').attr('class','nav-btn4 nav-unselect');
		if(i==5){
			$('.nav-btn5').attr('class','nav-btn5 nav-btn7  nav-select');
		}else{
			$('.nav-btn5').attr('class','nav-btn5 nav-select');
		}

	}
	
	$('#rank'+num).html('');
	$.ajax({
		url: "<?php  echo $this->createMobileurl('rank',array('rid'=>$rid))?>",
		type: 'POST',
		dataType: 'json',
		data: {type:num},
		success:function(json){
			
			var str = '';
			str +='<li style="text-align:center;"><span></span><em class="names" style="text-align:right;">总计</em>';
			if(num==1){
				str+='邀请<i class="iconfont men">'+json.total+'</i>人';
			}else if(num==2){
				str+='¥<i class="iconfont men">'+(json.total)+'</i>元';
			}else if(num==3){
				str+='¥<i class="iconfont men">'+(json.total)+'</i>元';
			}else if(num==4){
				str+='¥<i class="iconfont men">'+(json.total)+'</i>元';
			}else if(num==5){
				str+='点赞<i class="iconfont men">'+(json.total)+'</i>次';
			}
			str+='</li>';
			$('#rank'+num).attr('value',1);
			$.each(json.msg,function(index, el) {
				str+='<li>';
				if (index == 0) {
					str+='<span style="margin-top:10px;"><img src="<?php echo MODULE_URL;?>template/mobile/2/image/1.png" width="30px"></span>';
				}else if(index == 1){
					str+='<span style="margin-top:10px;"><img src="<?php echo MODULE_URL;?>template/mobile/2/image/2.png" width="30px"></span>';
				}else if(index == 2){
					str+='<span style="margin-top:10px;"><img src="<?php echo MODULE_URL;?>template/mobile/2/image/3.png" width="30px"></span>';
				}else{
					str+='<span>'+(parseInt(index)+1)+'</span>';
				}
				str+='<img src="'+el.headimgurl+'" width="35px" height="35px"> <em class="names">'+el.nickname+'</em>';

				if(num==1){
					str+='邀请<i class="iconfont men">'+el.c+'</i>人';
				}else if(num==2){
					str+='¥<i class="iconfont men">'+(el.fee)+'</i>元';
				}else if(num==3){
					str+='¥<i class="iconfont men">'+(el.amount)+'</i>元';
				}else if(num==4){
					str+='¥<i class="iconfont men">'+(el.amount)+'</i>元';
				}else if(num==5){
					str+='点赞<i class="iconfont men">'+(el.num)+'</i>次';
				}
				
				str+='</li>';	
			});
			$('#rank1').hide();
			$('#rank2').hide();
			$('#rank3').hide();
			$('#rank4').hide();
			$('#rank5').hide();
			$('#rank'+num).show();
			$('#rank'+num).html(str);
			
		}
	});
	

	};
		video_status = 0;
		var w = "100%";//视频宽度
var h = vedio;//视频高度
<?php  if($list['type']=='6') { ?>
var rtmpUrl = "<?php  echo $list['settings']['lrtmp'];?>";
var url = "<?php  echo $list['settings']['lhls'];?>";
var image = "<?php  echo tomedia($list['settings']['limg'])?>";
<?php  } else { ?>
var rtmpUrl = "<?php  echo $list['settings']['rtmp'];?>";
var url = "<?php  echo $list['settings']['hls'];?>";
<?php  } ?>
loginInfo.isend=1;


	var objectPlayer=new aodianPlayer({
  container:'play',//播放器容器ID，必要参数
  rtmpUrl: rtmpUrl,//控制台开通的APP rtmp地址，必要参数
  hlsUrl: url,//控制台开通的APP hls地址，必要参数
  /* 以下为可选参数*/
  width: w,//播放器宽度，可用数字、百分比等
  height: h,//播放器高度，可用数字、百分比等
  autostart: true,//是否自动播放，默认为false
  controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
 // adveDeAddr: image,//封面图片链接

 adveDeAddr : image,
  adveWidth: w,//封面图宽度
  adveHeight: h,//封面图高度
nowtime:<?php  echo time();?>,
startime:"<?php  echo $item['start_at'];?>",
  //adveReAddr: ''//封面图点击链接

});



			
				var $h_height=$(".advertising").height();//顶部广告高度
				var videoheight=$(".fixedfile").height();//视频到tab高度
				var height = $(window).height();//窗口可视高度1019
				var foot=$(".footer").height(); //底部固定高度
				// var gun=$(".gun").height()||0; //文字滚动的高度
				var noloock = $('.main').get(0).scrollHeight;//窗口内容高度1125
				var TAstate=$(".TAstate").height() //tab切换高度
				var sheihgt =height-videoheight-foot-$h_height;
//				$(".chat_title").css("height", sheihgt);
				
				 var allvt=vedio+TAstate; //视频到tab高度
				var intsheihgt ;

				intsheihgt =height-allvt-foot;
				$(".live").css("height", intsheihgt); //计算高度
				        



if($h_height>height){
	$(".footer-bar").hide();
}
	$(document).scroll(function(){
				var ssss=$(window).scrollTop();
//				console.log(ssss);
//				console.log($h_height);
				var hidt=$h_height-200;
				if($h_height>height){
						if(ssss>=hidt){
						$(".footer-bar").show();
	//					console.log(13);
					}else{
						$(".footer-bar").hide();
					}	
				}
				})


//点赞
goJudge(clickLovePC,clickLoveMO);
// 移动PC端判断
function goJudge(fnPC,fnMO) {
	if ((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
		fnMO();
	}
	else {
		fnPC();
	}
}
function clickLovePC() {
	$(".zan-click").on('mousedown', function(event) {
		$(".cont-right .zan-box i").css('color','rgb(245, 28, 48)');
	});
	$(".zan-click").on('mouseup', function(event) {
		$(".cont-right .zan-box i").css('color','#ff3d03');
	});
}
function clickLoveMO() {
	$(".zan-click").on('touchstart', function(event) {
		$(".cont-right .zan-box i").css('color','rgb(245, 28, 48)');
	});
	$(".zan-click").on('touchend', function(event) {
		$(".cont-right .zan-box i").css('color','#ff3d03');
	});
}
var picArr =<?php  echo $pics?>;
$(".zan-click").on('click', function(event) {
	if(new Date().getTime()>loginInfo.zantime+300)
	{
		var index = Math.floor((Math.random()*picArr.length)); 
		$.ajax({
			type: 'POST',
			url: "<?php  echo $this->createMobileurl('setzan',array('rid'=>$rid))?>",
			dataType: 'json',
			async: false,
			success: function(data) {
				
				loginInfo.zanN = data.num;
			}
		});
		loginInfo.type='zan';
		tis.SendMessage(picArr[index],'',JSON.stringify(loginInfo));
	}
	loginInfo.zantime=new Date().getTime();
});


function sendLove(pic,num) {
	
	sendLoves('.love','100','7','200',pic,num);
	var sl1 = setTimeout(function(){
		sendLoves('.love','100','7','200',pic,num);
		var sl2 = setTimeout(function(){
			sendLoves('.love','100','7','200',pic,num);

			clearTimeout(sl2);
		}, 200)
		clearTimeout(sl1);
	}, 200)
}
function sendLoves(obj,ow,on,oh,pic,num) {
	$(".zan-num").html(num);
	var i=$(obj).children('img').length;
	var w = parseInt(Math.random() * ow);
	$(obj).append("<img class = 'loveimg' src=''>");
	$(obj).children().eq(i).attr('src',pic);
	if (w < ow/3) {
		$(".loveimg").animate({
			bottom: oh,
			opacity:"0",
			left: -w,
			width: 40,
			height: 40,
		},2500,function(){
			$(this).remove();
		});
	};
	if (w > 2*ow/3) {
		$(".loveimg").animate({
			bottom: oh,
			opacity:"0",
			left: -w,
			width: 36,
			height: 36,
		},3500,function(){
			$(this).remove();
		});
	};
	if (w >= ow/3 || w <= 2*ow/3) {
		$(".loveimg").animate({
			bottom: oh,
			opacity: "0",
			left: -w,
			width: 32,
			height: 32,
		},3000,function(){
			$(this).remove();
		});
	};
}
		</script>
		<?php  if(($list['type']==6 && ((strpos($user_agent, 'MicroMessenger') === false) || (strpos($user_agent, 'Windows') !== false)))) { ?>
<?php  } else { ?>
		<script type="text/javascript" charset="UTF-8" src="<?php echo MODULE_URL;?>template/mobile/2/js/htmlplay.js"></script>
		<?php  } ?>
		<div style="display:none;">
<script src="https://s13.cnzz.com/z_stat.php?id=1273392991&web_id=1273392991" language="JavaScript"></script>
</div>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=wxz_wzb"></script></body></html>