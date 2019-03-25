<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="zh-cn">
	<head>
		<meta charset="UTF-8">
		<title><?php  echo $lyp_other['title']?></title>
		<meta name="keywords" content="<?php  echo $lyp_other['keywords'];?>" />
		<meta name="description" content="<?php  echo $lyp_other['description'];?>" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
		<link rel="shortcut icon" href="<?php  echo tomedia($lyp_other['favicon']);?>" />
		<link href="<?php echo MODULE_URL;?>resource/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo MODULE_URL;?>resource/css/index.css" rel="stylesheet" />
		<script src="<?php echo MODULE_URL;?>resource/js/jquery.min.js"></script>
		<script src="<?php echo MODULE_URL;?>resource/js/index.min.js"></script>
	</head>
	<style>
		div.welcome p {
			display: block;
			position: absolute;
			margin: 0px;
			padding: 0px;
			width: 370px;
			height: 30px;
			padding-top: 240px;
			top: 50%;
			left: 50%;
			margin-top: -135px;
			margin-left: -185px;
			color: #2fd0b5;
			font-size: 20px;
			text-align: center;
			background-image: url("<?php  echo tomedia($home['logo'])?>");
			background-size: 220px;
			background-repeat: no-repeat;
			background-position: 75px 20px;
			overflow: hidden;
		}
		.video .nth1 .line{
			display: none;
		}
		.quality .list-inline {
			width: auto !important;
		}
		<?php  if(!empty($home['backgroundimg'])) { ?>
			div.welcome {
				background: url("<?php  echo tomedia($home['backgroundimg'])?>") 30% 80%;
				background-color: white;
				-moz-background-size: cover;
				background-size: 100% 100%;
			}
		<?php  } ?>
		<?php  if(!empty($home['logo'])) { ?>
			div.welcome p {
				background-image: url("<?php  echo tomedia($home['logo'])?>");
				background-size: 220px;
				background-repeat: no-repeat;
				background-position: 50px 20px;
			}
		<?php  } ?>
		<?php  if(!empty($home['slide1']['logo'])) { ?>
			.video .swiper-container .nth1 {
				background-image: url("<?php  echo tomedia($home['slide1']['logo'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($home['slide2']['logo'])) { ?>
			.video .swiper-container .nth2 {
				background: url("<?php  echo tomedia($home['slide2']['logo'])?>") 50% 20%;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($home['slide3']['logo'])) { ?>
			.video .swiper-container .nth3 {
				background: url("<?php  echo tomedia($home['slide3']['logo'])?>") 50% center;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($home['slide4']['logo'])) { ?>
			.video .swiper-container .nth4 {
				background: url("<?php  echo tomedia($home['slide4']['logo'])?>") 50% top;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($business['backgroundimg'])) { ?>
			section.business {
				background: url("<?php  echo tomedia($business['backgroundimg'])?>") 50% bottom;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($case['backgroundimg'])) { ?>
			section.cases {
				background: url("<?php  echo tomedia($case['backgroundimg'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['backgroundimg'])) { ?>
			section.quality {
				background: url("<?php  echo tomedia($technology['backgroundimg'])?>") 50% 10%;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['backgroundimg'])) { ?>
			section.marketing {
				background: url("<?php  echo tomedia($marketing['backgroundimg'])?>") 50% 45%;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($about['backgroundimg'])) { ?>
			section.aboutus {
				position: relative;
				background: url("<?php  echo tomedia($about['backgroundimg'])?>") 50% 60%;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($connect['backgroundimg'])) { ?>
			section.contact {
				position: relative;
				background: url("<?php  echo tomedia($connect['backgroundimg'])?>") 50% bottom;
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column1']) && is_array($technology['column1']['thumb']) && !empty($technology['column1']['thumb']['0'])) { ?>
			.quality .box .swiper-slide ul li.mobi {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column1']['thumb']['0'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column1']) && is_array($technology['column1']['thumb']) && !empty($technology['column1']['thumb']['1'])) { ?>
			.quality .box .swiper-slide ul li.pad {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column1']['thumb']['1'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column1']) && is_array($technology['column1']['thumb']) && !empty($technology['column1']['thumb']['2'])) { ?>
			.quality .box .swiper-slide ul li.pc {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column1']['thumb']['2'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column2']) && is_array($technology['column2']['thumb']) && !empty($technology['column2']['thumb']['0'])) { ?>
			.quality .box .swiper-slide ul li.ie {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column2']['thumb']['0'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column2']) && is_array($technology['column2']['thumb']) && !empty($technology['column2']['thumb']['1'])) { ?>
			.quality .box .swiper-slide ul li.chrome {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column2']['thumb']['1'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column2']) && is_array($technology['column2']['thumb']) && !empty($technology['column2']['thumb']['2'])) { ?>
			.quality .box .swiper-slide ul li.firefox {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column2']['thumb']['2'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column3']) && is_array($technology['column3']['thumb']) && !empty($technology['column3']['thumb']['0'])) { ?>
			.quality .box .swiper-slide ul li.windows {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column3']['thumb']['0'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column3']) && is_array($technology['column3']['thumb']) && !empty($technology['column3']['thumb']['1'])) { ?>
			.quality .box .swiper-slide ul li.ios {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column3']['thumb']['1'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($technology['column3']) && is_array($technology['column3']['thumb']) && !empty($technology['column3']['thumb']['2'])) { ?>
			.quality .box .swiper-slide ul li.andriod {
				width: 30px;
				height: 30px;
				background: url("<?php  echo tomedia($technology['column3']['thumb']['2'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['column1']) && !empty($marketing['column1']['thumb'])) { ?>
			.marketing .box ul.items li.se i {
				width: 70px;
				height: 70px;
				background: url("<?php  echo tomedia($marketing['column1']['thumb'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['column2']) && !empty($marketing['column2']['thumb'])) { ?>
			.marketing .box ul.items li.weixin i {
				width: 70px;
				height: 70px;
				background: url("<?php  echo tomedia($marketing['column2']['thumb'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['column3']) && !empty($marketing['column3']['thumb'])) { ?>
			.marketing .box ul.items li.weibo i {
				width: 70px;
				height: 70px;
				background: url("<?php  echo tomedia($marketing['column3']['thumb'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['column4']) && !empty($marketing['column4']['thumb'])) { ?>
			.marketing .box ul.items li.sms i {
				width: 70px;
				height: 70px;
				background: url("<?php  echo tomedia($marketing['column4']['thumb'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['column5']) && !empty($marketing['column5']['thumb'])) { ?>
			.marketing .box ul.items li.pay i {
				width: 70px;
				height: 70px;
				background: url("<?php  echo tomedia($marketing['column5']['thumb'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
		<?php  if(!empty($marketing['column6']) && !empty($marketing['column6']['thumb'])) { ?>
			.marketing .box ul.items li.wxapp i {
				width: 70px;
				height: 70px;
				background: url("<?php  echo tomedia($marketing['column6']['thumb'])?>");
				-moz-background-size: cover;
				background-size: cover;
			}
		<?php  } ?>
	</style>
<body>
	<header>
		<div class="logo">
			<img src="<?php  echo tomedia($home['logo'])?>" class="pull-left" width="110px" height="35px" alt="noimg" class="img-responsive" />
		</div>
		<nav class="menu">
			<ul class="list-inline">
				<li class="active"><a><?php  if(!empty($home['title'])) { ?><?php  echo $home['title'];?><?php  } else { ?>首页<?php  } ?></a></li>
				<li><a><?php  if(!empty($business['title'])) { ?><?php  echo $business['title'];?><?php  } else { ?>业务<?php  } ?></a></li>
				<li><a><?php  if(!empty($case['title'])) { ?><?php  echo $case['title'];?><?php  } else { ?>案例<?php  } ?></a></li>
				<li><a><?php  if(!empty($technology['title'])) { ?><?php  echo $technology['title'];?><?php  } else { ?>技术<?php  } ?></a></li>
				<li><a><?php  if(!empty($marketing['title'])) { ?><?php  echo $marketing['title'];?><?php  } else { ?>营销<?php  } ?></a></li>
				<li><a><?php  if(!empty($about['title'])) { ?><?php  echo $about['title'];?><?php  } else { ?>关于<?php  } ?></a></li>
				<li><a><?php  if(!empty($connect['title'])) { ?><?php  echo $connect['title'];?><?php  } else { ?>联系<?php  } ?></a></li>
				<?php  if(!empty($topmenu)) { ?>
				<?php  if(is_array($topmenu)) { foreach($topmenu as $item) { ?>
					<li><a href="<?php  echo $item['link'];?>" target="_blank"><?php  echo $item['name'];?></a></li>
				<?php  } } ?>
				<?php  } ?>
			</ul>
		</nav>
		<div class="hotline">
			<a href="tel:<?php  echo $connect['phone'];?>" title="商务合作咨询热线"><span><?php  echo $connect['phone'];?></span></a><u></u>
		</div>
		<div class="menu-icon">
			<a href="tel:<?php  echo $connect['phone'];?>" title="点击直拨咨询热线"><span class="glyphicon glyphicon-earphone"></span></a>
			<span class="glyphicon glyphicon-th-large"></span>
		</div>
	</header>

	<div class="welcome <?php  if($home['hideloading'] == 1) { ?>hidden<?php  } ?>"><p>Loading . . .</p></div>

	<section class="video">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide nth1">
					<div class="box">
						<div class="right">
							<span><?php  if(!empty($home['slide1']) && !empty($home['slide1']['title'])) { ?><?php  echo $home['slide1']['title'];?><?php  } else { ?>专注，互联网+<?php  } ?></span><i></i>
							<p><?php  if(!empty($home['slide1']) && !empty($home['slide1']['subtitleone'])) { ?><?php  echo $home['slide1']['subtitleone'];?><?php  } else { ?>始于2018，展望未来<?php  } ?><br /><?php  if(!empty($home['slide1']) && !empty($home['slide1']['subtitletwo'])) { ?><?php  echo $home['slide1']['subtitletwo'];?><?php  } else { ?>专注于设计体验，专注于解决方案<?php  } ?></p>
						</div>
					</div>
				</div>
				<div class="swiper-slide nth2">
					<div class="box">
						<span><?php  if(!empty($home['slide2']) && !empty($home['slide2']['title'])) { ?><?php  echo $home['slide2']['title'];?><?php  } else { ?>微信公众号定制开发<?php  } ?></span><i></i>
						<p><?php  if(!empty($home['slide2']) && !empty($home['slide2']['subtitleone'])) { ?><?php  echo $home['slide2']['subtitleone'];?><?php  } else { ?>不是非要高大上，只是醉心于设计<?php  } ?><br /><?php  if(!empty($home['slide2']) && !empty($home['slide2']['subtitletwo'])) { ?><?php  echo $home['slide2']['subtitletwo'];?><?php  } else { ?>我们想，再上一个好案例<?php  } ?></p>
					</div>
				</div>
				<div class="swiper-slide nth3">
					<div class="box">
						<div class="top"><?php  if(!empty($home['slide3']) && !empty($home['slide3']['title'])) { ?><?php  echo $home['slide3']['title'];?><?php  } else { ?>技术派，论研发<?php  } ?></div>
						<div class="mid"></div>
						<div class="bottom"><?php  if(!empty($home['slide3']) && !empty($home['slide3']['subtitleone'])) { ?><?php  echo $home['slide3']['subtitleone'];?><?php  } else { ?>我说，业界没有最好的技术，只有最棒的技术开发者<?php  } ?><br /><?php  if(!empty($home['slide3']) && !empty($home['slide3']['subtitletwo'])) { ?><?php  echo $home['slide3']['subtitletwo'];?><?php  } else { ?>定制研发，为您的客户和团队<?php  } ?></div>
					</div>
				</div>
				<div class="swiper-slide nth4">
					<div class="box">
						<div class="top"><span><?php  if(!empty($home['slide4']) && !empty($home['slide4']['title'])) { ?><?php  echo $home['slide4']['title'];?><?php  } else { ?>先入为主，布局未来<?php  } ?></span><i></i></div>
						<div class="bottom"><?php  if(!empty($home['slide4']) && !empty($home['slide4']['subtitleone'])) { ?><?php  echo $home['slide4']['subtitleone'];?><?php  } else { ?>全面布局PC端与手机端<?php  } ?><br /><?php  if(!empty($home['slide4']) && !empty($home['slide4']['subtitletwo'])) { ?><?php  echo $home['slide4']['subtitletwo'];?><?php  } else { ?>基于HTML5响应式布局，智能识别多种终端设备<?php  } ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="innerBox">
			<div class="news">
			</div>
			<div class="guide"></div>
			<a class="movedown"></a>
		</div>
	</section>
	
	<section class="business">
		<div class="box">
			<div class="caption">
				<?php  if(!empty($business['pagetitle'])) { ?>
					<?php  if(!empty($business['pagetitle']['en_title'])) { ?>
					<span style="display:block;padding: 10px;font-size: 40px; color: #00dfb9;"><?php  echo $business['pagetitle']['en_title'];?></span>
					<?php  } else { ?>
					<i></i>
					<?php  } ?>
					<?php  if(!empty($business['pagetitle']['ch_title'])) { ?>
					<span><?php  echo $business['pagetitle']['ch_title'];?></span>
					<?php  } else { ?>
					<span>我们能做什么</span>
					<?php  } ?>
				<?php  } else { ?>
					<i></i><span>我们能做什么</span>
				<?php  } ?>
				<br class="clear" />
			</div>
			<ul class="items list-inline">
				<li class="pc">
					<i></i><strong><?php  if(!empty($business['business1']) && !empty($business['business1']['title'])) { ?><?php  echo $business['business1']['title'];?><?php  } else { ?>公众号定制开发<?php  } ?></strong>
					<p><?php  if(!empty($business['business1']) && !empty($business['business1']['subtitleone'])) { ?><?php  echo $business['business1']['subtitleone'];?><?php  } else { ?>吸粉靠服务<?php  } ?><br /><?php  if(!empty($business['business1']) && !empty($business['business1']['subtitletwo'])) { ?><?php  echo $business['business1']['subtitletwo'];?><?php  } else { ?>变现靠技术<?php  } ?></p>
				</li>
				<li class="mobi">
					<i></i><strong><?php  if(!empty($business['business2']) && !empty($business['business2']['title'])) { ?><?php  echo $business['business2']['title'];?><?php  } else { ?>移动网站建设<?php  } ?></strong>
					<p><?php  if(!empty($business['business2']) && !empty($business['business2']['subtitleone'])) { ?><?php  echo $business['business2']['subtitleone'];?><?php  } else { ?>定制手机网站 / 微网站制作<?php  } ?><br /><?php  if(!empty($business['business2']) && !empty($business['business2']['subtitletwo'])) { ?><?php  echo $business['business2']['subtitletwo'];?><?php  } else { ?>布局移动互联网<?php  } ?></p>
				</li>
				<li class="sys">
					<i></i><strong><?php  if(!empty($business['business3']) && !empty($business['business3']['title'])) { ?><?php  echo $business['business3']['title'];?><?php  } else { ?>微信广告投放<?php  } ?></strong>
					<p><?php  if(!empty($business['business3']) && !empty($business['business3']['subtitleone'])) { ?><?php  echo $business['business3']['subtitleone'];?><?php  } else { ?>精准投放广告<?php  } ?><br /><?php  if(!empty($business['business3']) && !empty($business['business3']['subtitletwo'])) { ?><?php  echo $business['business3']['subtitletwo'];?><?php  } else { ?>效益提升看得见<?php  } ?></p>
				</li>
				<li class="app">
					<i></i><strong><?php  if(!empty($business['business4']) && !empty($business['business4']['title'])) { ?><?php  echo $business['business4']['title'];?><?php  } else { ?>营销活动策划<?php  } ?></strong>
					<p><?php  if(!empty($business['business4']) && !empty($business['business4']['subtitleone'])) { ?><?php  echo $business['business4']['subtitleone'];?><?php  } else { ?>百场O2O活动策划经验<?php  } ?><br /><?php  if(!empty($business['business4']) && !empty($business['business4']['subtitletwo'])) { ?><?php  echo $business['business4']['subtitletwo'];?><?php  } else { ?>抓住热点，引爆市场<?php  } ?></p>
				</li>
				<li class="host">
					<i></i><strong><?php  if(!empty($business['business5']) && !empty($business['business5']['title'])) { ?><?php  echo $business['business5']['title'];?><?php  } else { ?>小程序开发<?php  } ?></strong>
					<p><?php  if(!empty($business['business5']) && !empty($business['business5']['subtitleone'])) { ?><?php  echo $business['business5']['subtitleone'];?><?php  } else { ?>微信小程序<?php  } ?><br /><?php  if(!empty($business['business5']) && !empty($business['business5']['subtitletwo'])) { ?><?php  echo $business['business5']['subtitletwo'];?><?php  } else { ?>未来互联网大趋势<?php  } ?></p>
				</li>
			</ul>
		</div>
	</section>
	
	<section class="cases">
		<div class="box">
			<div class="caption">
				<?php  if(!empty($case['pagetitle'])) { ?>
					<?php  if(!empty($case['pagetitle']['en_title'])) { ?>
					<span style="display:block;padding: 10px;font-size: 40px; color: #00dfb9;"><?php  echo $case['pagetitle']['en_title'];?></span>
					<?php  } else { ?>
					<i></i>
					<?php  } ?>
					<?php  if(!empty($case['pagetitle']['ch_title'])) { ?>
					<span><?php  echo $case['pagetitle']['ch_title'];?></span>
					<?php  } else { ?>
					<span>成功案例欣赏</span>
					<?php  } ?>
				<?php  } else { ?>
					<i></i><span>成功案例欣赏</span>
				<?php  } ?>
				<br class="clear" />
			</div>
			<div class="swiper-container items">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<a href="<?php  echo $case['case1']['link'];?>" target="_blank">
							<img src="<?php  echo tomedia($case['case1']['thumb']);?>" alt="暂无图片"/>
							<p>
								<?php  if(!empty($case['case1']['category'])) { ?><?php  echo $case['case1']['category'];?><?php  } else { ?>公众号开发<?php  } ?><br />
								<strong><?php  if(!empty($case['case1']['title'])) { ?><?php  echo $case['case1']['title'];?><?php  } else { ?>八之味外卖系统<?php  } ?></strong><br />
								<?php  if(!empty($case['case1']['description'])) { ?><?php  echo $case['case1']['description'];?><?php  } else { ?>微外卖,多店版<?php  } ?>
							</p>
						</a>
					</div>
					<div class="swiper-slide">
						<a href="<?php  echo $case['case2']['link'];?>" target="_blank">
							<img src="<?php  echo tomedia($case['case2']['thumb']);?>" alt="暂无图片"/>
							<p>
								<?php  if(!empty($case['case2']['category'])) { ?><?php  echo $case['case2']['category'];?><?php  } else { ?>小程序开发<?php  } ?><br />
								<strong><?php  if(!empty($case['case2']['title'])) { ?><?php  echo $case['case2']['title'];?><?php  } else { ?>百万红包你来领<?php  } ?></strong><br />
								<?php  if(!empty($case['case2']['description'])) { ?><?php  echo $case['case2']['description'];?><?php  } else { ?>O2O活动,推广营销<?php  } ?>
							</p>
						</a>
					</div>
					<div class="swiper-slide">
						<a href="<?php  echo $case['case3']['link'];?>" target="_blank">
							<img src="<?php  echo tomedia($case['case3']['thumb']);?>" alt="暂无图片"/>
							<p>
								<?php  if(!empty($case['case3']['category'])) { ?><?php  echo $case['case3']['category'];?><?php  } else { ?>企业站设计<?php  } ?><br />
								<strong><?php  if(!empty($case['case3']['title'])) { ?><?php  echo $case['case3']['title'];?><?php  } else { ?>雪峰大型冷库设备安装维修<?php  } ?></strong><br />
								<?php  if(!empty($case['case3']['description'])) { ?><?php  echo $case['case3']['description'];?><?php  } else { ?>企业站，官网<?php  } ?>
							</p>
						</a>
					</div>
				</div>
			</div>
			<a href="<?php  echo $_W['siteroot'] . 'web/' . $this->createWebUrl('category_detail', array('direct' => 1, 'uniacid' => $_W['uniacid'], 'm' => $_W['current_module']))?>" class="more-case">更多案例</a>
		</div>
	</section>

	<section class="quality">
		<div class="box">
			<div class="caption">
				<?php  if(!empty($technology['pagetitle'])) { ?>
					<?php  if(!empty($technology['pagetitle']['en_title'])) { ?>
					<span style="display:block;padding: 10px;font-size: 40px; color: #00dfb9;"><?php  echo $technology['pagetitle']['en_title'];?></span>
					<?php  } else { ?>
					<i></i>
					<?php  } ?>
					<?php  if(!empty($technology['pagetitle']['ch_title'])) { ?>
					<span><?php  echo $technology['pagetitle']['ch_title'];?></span>
					<?php  } else { ?>
					<span>多重组合，给您精彩</span>
					<?php  } ?>
				<?php  } else { ?>
					<i></i><span>多重组合，给您精彩</span>
				<?php  } ?>
				<br class="clear" />
			</div>
			<div class="swiper-container items">
				<div class="swiper-wrapper">
					<div class="swiper-slide nth1">
						<ul class="list-inline">
							<li class="mobi"><span>1</span></li>
							<li class="pad"><span>1</span></li>
							<li class="pc"><span>1</span></li>
						</ul>
						<p>
							<?php  if(!empty($technology['column1']) && !empty($technology['column1']['titleone'])) { ?><?php  echo $technology['column1']['titleone'];?><?php  } else { ?>触及视觉灵魂的公众号内页<?php  } ?><br/>
							<?php  if(!empty($technology['column1']) && !empty($technology['column1']['titletwo'])) { ?><?php  echo $technology['column1']['titletwo'];?><?php  } else { ?>快速裂变的粉丝互动系统<?php  } ?><br/>
							<?php  if(!empty($technology['column1']) && !empty($technology['column1']['titlethree'])) { ?><?php  echo $technology['column1']['titlethree'];?><?php  } else { ?>方便快捷的订单系统<?php  } ?><br/>
						</p>
					</div>
					<div class="swiper-slide nth2">
						<ul class="list-inline">
							<li class="ie"><span>2</span></li>
							<li class="chrome"><span>2</span></li>
							<li class="firefox"><span>2</span></li>
						</ul>
						<p>
							<?php  if(!empty($technology['column2']) && !empty($technology['column2']['titleone'])) { ?><?php  echo $technology['column2']['titleone'];?><?php  } else { ?>Html5微官网制作<?php  } ?><br/>
							<?php  if(!empty($technology['column2']) && !empty($technology['column2']['titletwo'])) { ?><?php  echo $technology['column2']['titletwo'];?><?php  } else { ?>卓越的浏览器兼容性<?php  } ?><br/>
							<?php  if(!empty($technology['column2']) && !empty($technology['column2']['titlethree'])) { ?><?php  echo $technology['column2']['titlethree'];?><?php  } else { ?>因为高端，所以出众<?php  } ?><br/>
						</p>
					</div>
					<div class="swiper-slide nth3">
						<ul class="list-inline">
							<li class="windows"><span>3</span></li>
							<li class="ios"><span>3</span></li>
							<li class="andriod"><span>3</span></li>
						</ul>
						<p>
							<?php  if(!empty($technology['column3']) && !empty($technology['column3']['titleone'])) { ?><?php  echo $technology['column3']['titleone'];?><?php  } else { ?>基于 B/S 架构的网站建设<?php  } ?><br/>
							<?php  if(!empty($technology['column3']) && !empty($technology['column3']['titletwo'])) { ?><?php  echo $technology['column3']['titletwo'];?><?php  } else { ?>无障碍的跨平台应用<?php  } ?><br/>
							<?php  if(!empty($technology['column3']) && !empty($technology['column3']['titlethree'])) { ?><?php  echo $technology['column3']['titlethree'];?><?php  } else { ?>独立后台便捷管理<?php  } ?><br/>
						</p>
					</div>
				</div>
			</div>
			<a href="javascript:;" class="lookall hidden">你以为看到了网站的全部？</a>
		</div>
	</section>

	<section class="marketing">
		<div class="box">
			<div class="caption">
				<?php  if(!empty($marketing['pagetitle'])) { ?>
					<?php  if(!empty($marketing['pagetitle']['en_title'])) { ?>
					<span style="display:block;padding: 10px;font-size: 40px; color: #00dfb9;"><?php  echo $marketing['pagetitle']['en_title'];?></span>
					<?php  } else { ?>
					<i></i>
					<?php  } ?>
					<?php  if(!empty($marketing['pagetitle']['ch_title'])) { ?>
					<span><?php  echo $marketing['pagetitle']['ch_title'];?></span>
					<?php  } else { ?>
					<span>流量就是力量</span>
					<?php  } ?>
				<?php  } else { ?>
					<i></i><span>流量就是力量</span>
				<?php  } ?>
				<br class="clear" />
			</div>
			<ul class="items list-inline">
				<li class="se">
					<i></i><strong><?php  if(!empty($marketing['column1']) && !empty($marketing['column1']['titleone'])) { ?><?php  echo $marketing['column1']['titleone'];?><?php  } else { ?>搜索引擎<?php  } ?></strong>
					<p>
						<?php  if(!empty($marketing['column1']) && !empty($marketing['column1']['titletwo'])) { ?><?php  echo $marketing['column1']['titletwo'];?><?php  } else { ?>SEO 优化<?php  } ?><br />
						<?php  if(!empty($marketing['column1']) && !empty($marketing['column1']['titlethree'])) { ?><?php  echo $marketing['column1']['titlethree'];?><?php  } else { ?>搜索引擎竞价<?php  } ?>
					</p>
				</li>
				<li class="weixin">
					<i></i><strong><?php  if(!empty($marketing['column2']) && !empty($marketing['column2']['titleone'])) { ?><?php  echo $marketing['column2']['titleone'];?><?php  } else { ?>微信营销<?php  } ?></strong>
					<p>
						<?php  if(!empty($marketing['column2']) && !empty($marketing['column2']['titletwo'])) { ?><?php  echo $marketing['column2']['titletwo'];?><?php  } else { ?>公众账号 / 微网站<?php  } ?><br />
						<?php  if(!empty($marketing['column2']) && !empty($marketing['column2']['titlethree'])) { ?><?php  echo $marketing['column2']['titlethree'];?><?php  } else { ?>粉丝经济<?php  } ?>
					</p>
				</li>
				<li class="weibo">
					<i></i><strong><?php  if(!empty($marketing['column3']) && !empty($marketing['column3']['titleone'])) { ?><?php  echo $marketing['column3']['titleone'];?><?php  } else { ?>微博互动<?php  } ?></strong>
					<p>
						<?php  if(!empty($marketing['column3']) && !empty($marketing['column3']['titletwo'])) { ?><?php  echo $marketing['column3']['titletwo'];?><?php  } else { ?>微博头条<?php  } ?><br />
						<?php  if(!empty($marketing['column3']) && !empty($marketing['column3']['titlethree'])) { ?><?php  echo $marketing['column3']['titlethree'];?><?php  } else { ?>官V认证，粉丝互动<?php  } ?>
					</p>
				</li>
				<li class="sms">
					<i></i><strong><?php  if(!empty($marketing['column4']) && !empty($marketing['column4']['titleone'])) { ?><?php  echo $marketing['column4']['titleone'];?><?php  } else { ?>消息推送<?php  } ?></strong>
					<p>
						<?php  if(!empty($marketing['column4']) && !empty($marketing['column4']['titletwo'])) { ?><?php  echo $marketing['column4']['titletwo'];?><?php  } else { ?>短信平台接口<?php  } ?><br />
						<?php  if(!empty($marketing['column4']) && !empty($marketing['column4']['titlethree'])) { ?><?php  echo $marketing['column4']['titlethree'];?><?php  } else { ?>微信图文推送<?php  } ?>
					</p>
				</li>
				<li class="pay">
					<i></i><strong><?php  if(!empty($marketing['column5']) && !empty($marketing['column5']['titleone'])) { ?><?php  echo $marketing['column5']['titleone'];?><?php  } else { ?>在线支付<?php  } ?></strong>
					<p>
						<?php  if(!empty($marketing['column5']) && !empty($marketing['column5']['titletwo'])) { ?><?php  echo $marketing['column5']['titletwo'];?><?php  } else { ?>支付宝、微信<?php  } ?><br />
						<?php  if(!empty($marketing['column5']) && !empty($marketing['column5']['titlethree'])) { ?><?php  echo $marketing['column5']['titlethree'];?><?php  } else { ?>在线便捷支付<?php  } ?>
					</p>
				</li>
				<li class="wxapp">
					<i></i><strong><?php  if(!empty($marketing['column6']) && !empty($marketing['column6']['titleone'])) { ?><?php  echo $marketing['column6']['titleone'];?><?php  } else { ?>小程序<?php  } ?></strong>
					<p>
						<?php  if(!empty($marketing['column6']) && !empty($marketing['column6']['titletwo'])) { ?><?php  echo $marketing['column6']['titletwo'];?><?php  } else { ?>无需技术<?php  } ?><br />
						<?php  if(!empty($marketing['column6']) && !empty($marketing['column6']['titlethree'])) { ?><?php  echo $marketing['column6']['titlethree'];?><?php  } else { ?>人人都会运营<?php  } ?>
					</p>
				</li>
			</ul>
		</div>
	</section>

	<section class="aboutus">
		<ul class="menu">
			<li><?php  if(!empty($about['about1']) && !empty($about['about1']['category'])) { ?><?php  echo $about['about1']['category'];?><?php  } else { ?>关于<?php  } ?></li>
			<li><?php  if(!empty($about['about2']) && !empty($about['about2']['category'])) { ?><?php  echo $about['about2']['category'];?><?php  } else { ?>思想<?php  } ?></li>
			<li><?php  if(!empty($about['about3']) && !empty($about['about3']['category'])) { ?><?php  echo $about['about3']['category'];?><?php  } else { ?>招聘<?php  } ?></li>
		</ul>
		<div class="swiper-container items">
			<div class="swiper-wrapper">
				<div class="swiper-slide nth1">
					<strong><?php  if(!empty($about['about1']) && !empty($about['about1']['title'])) { ?><?php  echo $about['about1']['title'];?><?php  } else { ?>公司<?php  } ?></strong>
					<?php  if(!empty($about['about1']) && !empty($about['about1']['content'])) { ?>
						<p><?php  echo $about['about1']['content'];?></p>
					<?php  } else { ?>
					  <p>成立于2018年，坐落于美丽的城市海口，是中国优秀的互联网服务提供商。自成立以来，专注于高端网站建设、移动互联应用、B/S架构系统研发、云服务器部署和运维，为企业客户的互联网应用提供一站式服务。</p>
					<?php  } ?>
				</div>
				<div class="swiper-slide nth2">
					<strong><?php  if(!empty($about['about2']) && !empty($about['about2']['title'])) { ?><?php  echo $about['about2']['title'];?><?php  } else { ?>来，关注我们<?php  } ?></strong>
					<?php  if(!empty($about['about2']) && !empty($about['about2']['content'])) { ?>
						<p><?php  echo $about['about2']['content'];?></p>
					<?php  } else { ?>
						<p>登上峰顶，不是为了饱览风光，是为了寻找更高的山峰<br/>日出东方，告别了昨天的荣耀，将光芒照向更远的地方<br/>一路上，我们更在意如何积累和沉淀</p>
						<p>下一秒，让你看，我们到底有多强</p>
					<?php  } ?>
				</div>
				<div class="swiper-slide nth3">
					<strong><?php  if(!empty($about['about3']) && !empty($about['about3']['title'])) { ?><?php  echo $about['about3']['title'];?><?php  } else { ?>来，征服我们<?php  } ?></strong>
					<ul>
					<?php  if(!empty($about['about3']) && !empty($about['about3']['content1'])) { ?>
						<li><?php  echo $about['about3']['content1'];?></li>
					<?php  } else { ?>
						<li>软文编辑人员<u>-</u>视野宽，思维快，网罗天下，编织佳话。</li>
					<?php  } ?>
					<?php  if(!empty($about['about3']) && !empty($about['about3']['content2'])) { ?>
						<li><?php  echo $about['about3']['content2'];?></li>
					<?php  } else { ?>
						<li>程序员鼓励师<u>-</u>懂幽默，接地气，一语惊人，笑出泪花。</li>
					<?php  } ?>
					<?php  if(!empty($about['about3']) && !empty($about['about3']['content3'])) { ?>
						<li><?php  echo $about['about3']['content3'];?></li>
					<?php  } else { ?>
						<li>产品运营经理<u>-</u>人脉多，资源广，运筹帷幄，营造未来。</li>
					<?php  } ?>
					</ul>
				</div>
			</div>
		</div>
		<table class="exp">
			<tr>
				<td><u>诚信</u>诚信赢天下</td>
				<td><u>团队</u>没有完美的个人</td>
				<td><u>执行</u>言必行，行必果</td>
				<td><u>创新</u>不走寻常路</td>
				<td><u>梦想</u>人总要有梦想</td>
			</tr>
		</table>
	</section>

	<section class="contact">
		<div class="box">
			<div class="above">
				<div class="wechat"><img src="<?php  echo tomedia($connect['thumb']);?>" alt=""/></div>
				<div class="left" style="width: 400px">
					<p><span>联系人：<?php  if(!empty($connect['person'])) { ?><?php  echo $connect['person'];?><?php  } else { ?>---<?php  } ?></span><br>
						<span>QQ：<?php  if(!empty($connect['qq'])) { ?><?php  echo $connect['qq'];?><?php  } else { ?>---<?php  } ?></span><br>
						<span>电话：<?php  if(!empty($connect['phone'])) { ?><?php  echo $connect['phone'];?><?php  } else { ?>---<?php  } ?></span><br>
						<span>公司：<?php  if(!empty($connect['company'])) { ?><?php  echo $connect['company'];?><?php  } else { ?>---<?php  } ?></span><br>
						<span><a>Email：<?php  if(!empty($connect['email'])) { ?><?php  echo $connect['email'];?><?php  } else { ?>---<?php  } ?></a></span><br />
						<span>地址：<?php  if(!empty($connect['address'])) { ?><?php  echo $connect['address'];?><?php  } else { ?>---<?php  } ?></span><br />
						<span>备案：<?php  if(!empty($connect['icp'])) { ?><a href="http://www.miitbeian.gov.cn" target="_blank"><?php  echo $connect['icp'];?></a><?php  } else { ?>---<?php  } ?></span><br />
					</p>
				</div>
			</div>
		</div>
		<div class="map col-xs-5" style="position:absolute;width:70%;height:300px;bottom:30px;left:15%">
			<div class="img" style="width:100%; height:300px; border:#ccc solid 1px;" id="baidumap"></div>
		</div>
	</section>


	<div class="dock">
		<ul class="icons">
			<li class="up"><i></i></li>
			<li class="im">
				<i></i><p>合作咨询<br />投诉建议，请点我<a href="tencent://message/?uin=<?php  echo $connect['qq'];?>&Menu=yes">在线咨询</a></p>
			</li>
			<li class="tel">
				<i></i><p>合作咨询热线：<br /><?php  echo $connect['phone'];?><br />售后服务热线：<br /><?php  echo $connect['phone'];?></p>
			</li>
			<li class="wechat">
				<i></i><p><img src="<?php  echo tomedia($connect['thumb']);?>" alt="扫描联系商务合作微信" /></p>
			</li>
			<li class="down"><i></i></li>
		</ul>
		<a class="switch"></a>
	</div>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=26&c=utility&a=visit&do=showjs&m=lyp_welcomefullpage"></script></body>
<script type="text/javascript" src="//api.map.baidu.com/api?v=3.0&ak=z97lflBFroURBdgKazV1i05X"></script>
<script>
	var bmap = {
		'option' : {
			'lock' : false,
			'container' : 'baidumap',
			'infoWindow' : {'width' : 250, 'height' : 100, 'title' : ''},
			'point' : {'lng' : '<?php  echo $connect['baidumap']['lng'];?>', 'lat' : '<?php  echo $connect['baidumap']['lat'];?>'}
		},
		'init' : function(option) {
			var $this = this;
			$this.option = $.extend({},$this.option,option);
			$this.option.defaultPoint = new BMap.Point($this.option.point.lng, $this.option.point.lat);
			$this.bgeo = new BMap.Geocoder();
			$this.bmap = new BMap.Map($this.option.container);
			$this.bmap.centerAndZoom($this.option.defaultPoint, 15);
			$this.bmap.enableScrollWheelZoom();
			$this.bmap.enableDragging();
			$this.bmap.enableContinuousZoom();
			$this.bmap.addControl(new BMap.NavigationControl());
			$this.bmap.addControl(new BMap.OverviewMapControl());
			//添加标注
			$this.marker = new BMap.Marker($this.option.defaultPoint);
			$this.marker.enableDragging();
			$this.bmap.addOverlay($this.marker);
			$this.marker.setAnimation(BMAP_ANIMATION_BOUNCE);
		},
		'setMarkerCenter' : function() {
			var $this = this;
			var center = $this.bmap.getCenter();
			$this.marker.setPosition(new BMap.Point(center.lng, center.lat));
			$this.showPointValue();
			$this.showAddress();
		}
	};
	$(function(){
		var option = {};
		option = {'point' : {'lng' : '<?php  echo $connect['baidumap']['lng'];?>', 'lat' : '<?php  echo $connect['baidumap']['lat'];?>'}}
		bmap.init(option);
	});
</script>
</html>