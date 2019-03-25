<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('inc/header', TEMPLATE_INCLUDEPATH)) : (include template('inc/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	@-webkit-keyframes hd{
		0%{
			-webkit-transform:scale(0.8,0.8);
    		-moz-transform:scale(0.8,0.8);
    		-transform:scale(0.8,0.8);
    	}
    	50%{
    		-webkit-transform:scale(1.0,1.0);
    		-moz-transform:scale(1.0,1.0);
    		-transform:scale(1.0,1.0);
    	}
    	100%{
    		-webkit-transform:scale(1.2,1.2);
    		-moz-transform:scale(1.2,1.2);
    		-transform:scale(1.2,1.2);
    	}
	}
	@-moz-keyframes hd{
		0%{
			-webkit-transform:scale(0.8,0.8);
    		-moz-transform:scale(0.8,0.8);
    		-transform:scale(0.8,0.8);
    	}
    	50%{
    		-webkit-transform:scale(1.0,1.0);
    		-moz-transform:scale(1.0,1.0);
    		-transform:scale(1.0,1.0);
    	}
    	100%{
    		-webkit-transform:scale(1.2,1.2);
    		-moz-transform:scale(1.2,1.2);
    		-transform:scale(1.2,1.2);
    	}
	}
	@keyframes hd{
		0%{
			-webkit-transform:scale(0.8,0.8);
    		-moz-transform:scale(0.8,0.8);
    		-transform:scale(0.8,0.8);
    	}
    	50%{
    		-webkit-transform:scale(1.0,1.0);
    		-moz-transform:scale(1.0,1.0);
    		-transform:scale(1.0,1.0);
    	}
    	100%{
    		-webkit-transform:scale(1.2,1.2);
    		-moz-transform:scale(1.2,1.2);
    		-transform:scale(1.2,1.2);
    	}
	}
	
	.business-img{
		-webkit-animation:hd 3s infinite ease-in-out;
		-moz-animation:hd 3s infinite ease-in-out;
		animation:hd 3s infinite ease-in-out;
		
	}
	.sea-form{
		width:100%;
		max-width: 640px;
		margin:0 auto;
		height:38px;
		z-index:99999999;
		padding-top:8px;
		background-color:<?php  echo $setting['color'];?>;
	}
	.keyword{
		position:absolute;
		left:5%;
		width:75%;
		height:30px;
		padding-left:18px;
		z-index:99999999;
		border-radius:15px;
		border:none;}
	.btn-sub{
		position:absolute;
		right:5%;
		height:27px;
		z-index:99999999;			
		color:#ffffff;
		margin-top:2px;
		font-size:16px;
		text-align: center;
		border:none;
		-webkit-appearance: none;
		border-radius:0;
		background-color:<?php  echo $setting['color'];?>;
	}
	.pleft{
		width:49.5%;
		float:left;
		height:35px;
		line-height: 40px;
		text-align: center;
	}
	.pright{
		width:50%;
		float:left;
		height:35px;
		line-height: 40px;
		text-align: center;
	}
	.nowclass{
		<?php  if($setting['color']) { ?>color:<?php  echo $setting['color'];?>;<?php  } ?>
	}
</style>
<body>

	<!-- <div id="LoadingBar" style="position:fixed;width:100%;height:100%;top:0px;background-color:#fff;z-index:99999999999999;"> <img width="80%" style="text-align: center;margin-top: 40%;margin-left: 10%" src="<?php  echo tomedia($setting['loadding']);?>" ></div> -->


	<div class="sea-form">
		<form action="<?php  echo $this->createMobileUrl('showindex');?>" method="get" class="form-horizontal form"
		enctype="multipart/form-data">
			<input type="hidden" name="i" value="<?php  echo $weid;?>" />
			<input type="hidden" name="c" value="entry" />
	        <input type="hidden" name="m" value="jy_nearby" />
	        <input type="hidden" name="do" value="showindex" />
			<input type="input" id="keyword" class="keyword" name="keyword" value="" placeholder="搜索门店" />
			<input type="submit" name="submit" value="搜索" class="btn-sub" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</form>

	</div>
	<?php  if($baners) { ?>
	<header class="swiper-container">
		<div class="swiper-wrapper">
			<?php  if(is_array($baners)) { foreach($baners as $it) { ?>
				<?php  if($it['enabled']==2) { ?>
				<a href="<?php  echo $it['url'];?>" class="swiper-slide">
					<img src="<?php  echo tomedia($it['thumb']);?>" width="100%">
					<div class="indexname"><?php  echo $it['catename'];?></div>
				</a>
				<?php  } else if($it['enabled']==1) { ?>
				<?php  $content = htmlspecialchars_decode($it['content']);?>
				<div class="swiper-slide" id="showdetail" data-title="<?php  echo $it['catename'];?>" data-content="<?php  echo $content;?>">
					<img src="<?php  echo tomedia($it['thumb']);?>" width="100%">
					<div class="indexname"><?php  echo $it['catename'];?></div>
				</div>
				<?php  } else { ?>
				<div class="swiper-slide">
					<img src="<?php  echo tomedia($it['thumb']);?>" width="100%">
					<div class="indexname"><?php  echo $it['catename'];?></div>
				</div>
				<?php  } ?>

			<?php  } } ?>
        </div>
	</header>
	<?php  } ?>
	<section>
		<?php  if($types) { ?>
		<div class="type">
			<ul>
				<?php  if(is_array($types)) { foreach($types as $item) { ?>
					<li>
						<a href="<?php  echo $item['url'];?>">
						<img src="<?php  echo tomedia($item['thumb']);?>" >
						<?php  echo $item['catename'];?>
						</a>
					</li>
				<?php  } } ?>
			</ul>
		</div>
		<?php  } ?>
		<div class="notice">
			<div class="title" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>">
				<?php  if($setting['wdcx']) { ?><?php  echo $setting['wdcx'];?><?php  } else { ?>网点查询<?php  } ?>
			</div>
			<div class="content">
				<marquee behavior="scroll" scrollamount="5" onmouseout="this.start();"><?php  if($setting['notice']) { ?><?php  echo $setting['notice'];?><?php  } else { ?>暂无公告<?php  } ?></marquee>
			</div>
		</div>

		<div class="ppoint" style="height:40px;">
			<div class="point-div" style="height:40px;">
				<div  class="pleft" style=" <?php  if($setting['color']) { ?>border-bottom:1px solid <?php  echo $setting['color'];?>;border-right:1px solid <?php  echo $setting['color'];?>;<?php  } else { ?>border-bottom:1px solid #ff0000;border-right:1px solid #ff0000;<?php  } ?>;">
					<span id="getdistance" class="nowclass" style="font-size:16px;">距离</span>
				</div>


				<div  class="pright" style="border-bottom:1px solid <?php  if($setting['color']) { ?><?php  echo $setting['color'];?><?php  } else { ?>#ff0000<?php  } ?>;">
					<select id="newcate" style="border:none;font-size:14px;padding:1px 5px;border-style:none;-webkit-appearance: none;background-color:#fff;" name="cateid" onchange="getclass()">
						<option value="0" >全部分类</option>
						<?php  if(is_array($clist)) { foreach($clist as $row) { ?>
						<option value="<?php  echo $row['id'];?>" ><?php  echo $row['catename'];?></option>
						<?php  } } ?>
					</select>
					<img src="<?php echo NEARBY_IMAGE;?>jiantou.png" style="width:15px;" />
				</div>

			</div>
		</div>
		<div class="point">
			<?php  if(!empty($stores)) { ?>
			<?php  if(is_array($stores)) { foreach($stores as $sto) { ?>
			<div class="point-div">
				<div class="con">
					<a href="<?php  echo $this->createMobileUrl('showDetail',array('id'=>$sto['id']));?>">
					<div class="detail">
						<div class="pic">
							<?php  if($sto['storelogo']) { ?>
							<img src="<?php  echo tomedia($sto['storelogo']);?>" width="100%">
							<?php  } else if($setting['avar']) { ?>
							<img src="<?php  echo tomedia($setting['avar']);?>" width="100%">
							<?php  } else { ?>
							<img src="<?php echo NEARBY_IMAGE;?>123.png" width="100%">
							<?php  } ?>
						</div>
						<div class="title">
							<?php  $name =  mb_substr($sto['storename'],0,10,'utf-8');?>
							<h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?php  echo $sto['storename'];?></h3>
							<?php  $address=mb_substr($sto['province'].$sto['city'].$sto['address'],0,15,'utf-8')?>
							<p style="color:#AFADAD;"><?php  echo $address;?>...</p>
						</div>
						<?php  if($sto['disc']) { ?>
						<div class="disc" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>">
							<?php  echo $sto['disc'];?>km
						</div>
						<?php  } ?>
					</div>
					</a>
					<?php  if(empty($sto['custom_one']) && empty($sto['custom_two']) && empty($sto['custom_three']) && empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel">
							<a data="<?php  echo $sto['tel'];?>" >
								<div class="mid">
									<img src="<?php echo NEARBY_IMAGE;?>tel.png" width="25%" height="100%"><span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>">一键拨号</span>
								</div>
							</a>
						</div>
						<div class="nav">
							<?php
									$sto['remark']= htmlspecialchars_decode($sto['remark']);
									$sto['remark']= preg_replace("/<(.*?)>/","",$sto['remark']);
							?>
							<?php  if($sto['lat']&&$sto['lng']) { ?>
							<a href="http://api.map.baidu.com/marker?location=<?php  echo $sto['lat'];?>,<?php  echo $sto['lng'];?>&title=<?php  echo $sto['storename'];?>&content=<?php  echo $sto['storename'];?>&output=html&src=weiba|weiweb" data-la="<?php  echo $sto['lat'];?>" data-lg="<?php  echo $sto['lng'];?>">
							<!-- <a href="<?php  echo $this->createMobileUrl('map',array('lat'=>$sto['lat'],'lng'=>$sto['lng']));?>" data-la="<?php  echo $sto['lat'];?>" data-lg="<?php  echo $sto['lng'];?>"> -->
								<div class="mid">
									<img src="<?php echo NEARBY_IMAGE;?>dw.png" width="25%" height="100%"><span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>">一键导航</span>
								</div>
							</a>
							<?php  } else { ?>
								<div class="mid nodh">
									<img src="<?php echo NEARBY_IMAGE;?>dw.png" width="25%" height="100%"><span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>">一键导航</span>
								</div>
							<?php  } ?>
						</div>
					</div>
					<?php  } else if(!empty($sto['custom_one']) && empty($sto['custom_two']) && empty($sto['custom_three']) && empty($sto['custom_four'])) { ?>
					<div class="contact">
						
						<div class="tel" style="width:100%;border-right:none;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" style="width:14%;margin-top:3px;margin-left:20%;" width="14%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" style="width:14%;margin-top:3px;margin-left:20%;" width="14%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>

						
					</div>
					<?php  } else if(empty($sto['custom_one']) && !empty($sto['custom_two']) && empty($sto['custom_three']) && empty($sto['custom_four'])) { ?>
					<div class="contact">
						
						<div class="nav" style="width:100%;">
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" style="width:9%;margin-top:6px;margin-left:20%;" width="9%" >
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" style="width:9%;margin-top:6px;margin-left:20%;" width="9%" >
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>
					</div>
					<?php  } else if(!empty($sto['custom_one']) && !empty($sto['custom_two']) && empty($sto['custom_three']) && empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>
						
						<div class="nav" >
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>
					</div>
					<?php  } else if(!empty($sto['custom_one']) && !empty($sto['custom_two']) && !empty($sto['custom_three']) && empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>

						<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>

						
						<div class="nav" style="width:33%">
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>
					</div>
					<?php  } else if(!empty($sto['custom_one']) && !empty($sto['custom_two']) && empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">
						
						<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>


						<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:33%">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>
					</div>
					<?php  } else if(!empty($sto['custom_one']) && !empty($sto['custom_two']) && !empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="width:24.5%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>

						<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>


						<div class="nav" style="width:25%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:24.5%">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>
					</div>
					<?php  } else if(empty($sto['custom_one']) && empty($sto['custom_two']) && !empty($sto['custom_three']) && empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="width:100%;border-right:none;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" style="width:12%;margin-left:30%;">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" style="width:12%;margin-left:30%;">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>margin-top:5px;"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>
					</div>
					<?php  } else if(empty($sto['custom_one']) && empty($sto['custom_two']) && empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">

						<div class="nav" style="width:100%;border-right:none;">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" style="width:12%;margin-left:30%;">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" style="width:12%;margin-left:30%;">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>margin-top:5px;"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>

					</div>
					<?php  } else if(empty($sto['custom_one']) && empty($sto['custom_two']) && !empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="width:50%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:49.5%">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>

					</div>
					<?php  } else if(empty($sto['custom_one']) && !empty($sto['custom_two']) && !empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>

						<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:33%">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>

					</div>
					<?php  } else if(!empty($sto['custom_one']) && empty($sto['custom_two']) && !empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>

						<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:33%">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>

					</div>
					<?php  } else if(!empty($sto['custom_one']) && !empty($sto['custom_two']) && !empty($sto['custom_three']) && !empty($sto['custom_four'])) { ?>
					<div class="contact">
						<div class="tel" style="width:24.5%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_one'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_one'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_one']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_one'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:25%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_two'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_two'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_two']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_two'];?></span>
								</div>
							</a>
						</div>

						<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;">
							<a href="<?php  echo $sto['custom_url_three'];?>" >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_three'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_three']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_three'];?></span>
								</div>
							</a>
						</div>

						<div class="nav" style="width:24.5%">
							<a href="<?php  echo $sto['custom_url_four'];?>"  >
								<div class="mid">
									<?php  if(!empty($sto['custom_logo_four'])) { ?>
									<img src="<?php  echo tomedia($sto['custom_logo_four']);?>" width="25%" height="100%">
									<?php  } else { ?>
									<img src="<?php echo NEARBY_IMAGE;?>123.png" width="25%" height="100%">
									<?php  } ?>
									<span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>"><?php  echo $sto['custom_four'];?></span>
								</div>
							</a>
						</div>

					</div>
					<?php  } else { ?>
					<div class="contact">
						<div class="tel">
							<a data="<?php  echo $sto['tel'];?>" >
								<div class="mid">
									<img src="<?php echo NEARBY_IMAGE;?>tel.png" width="25%" height="100%"><span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>">一键拨号</span>
								</div>
							</a>
						</div>
						<div class="nav">
							<?php
									$sto['remark']= htmlspecialchars_decode($sto['remark']);
									$sto['remark']= preg_replace("/<(.*?)>/","",$sto['remark']);
							?>
							<?php  if($sto['lat']&&$sto['lng']) { ?>
							<a href="http://api.map.baidu.com/marker?location=<?php  echo $sto['lat'];?>,<?php  echo $sto['lng'];?>&title=<?php  echo $sto['storename'];?>&content=<?php  echo $sto['storename'];?>&output=html&src=weiba|weiweb" data-la="<?php  echo $sto['lat'];?>" data-lg="<?php  echo $sto['lng'];?>">
							<!-- <a href="<?php  echo $this->createMobileUrl('map',array('lat'=>$sto['lat'],'lng'=>$sto['lng']));?>" data-la="<?php  echo $sto['lat'];?>" data-lg="<?php  echo $sto['lng'];?>"> -->
								<div class="mid">
									<img src="<?php echo NEARBY_IMAGE;?>dw.png" width="25%" height="100%"><span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>">一键导航</span>
								</div>
							</a>
							<?php  } else { ?>
								<div class="mid nodh">
									<img src="<?php echo NEARBY_IMAGE;?>dw.png" width="25%" height="100%"><span style="<?php  if($setting['color']) { ?> color:#000; <?php  } ?>">一键导航</span>
								</div>
							<?php  } ?>
						</div>
					</div>
					<?php  } ?>
				</div>
			</div>
			<?php  } } ?>
			<?php  } else { ?>

			<?php  } ?>
		</div>
	</section>

	<div class="upload" style="display:none;" data-page="<?php  echo $page;?>">
		<div class="showindex" style="width:20%;margin:0 auto;">
			<img src="<?php echo NEARBY_IMAGE;?>123.gif" width="20px;">
			<div style="float:left;">加载中</div>
		</div>
	</div>
	<input id="page" type="hidden" name="page" value="<?php  if($pindex) { ?> <?php  echo $pindex;?> <?php  } else { ?>1<?php  } ?>">
	<input id="isscroll" type="hidden" name="page" value="1">

	<div class="copyright" style="padding:0;"><a href="<?php  echo $setting['copyrighturl'];?>" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>" >&copy<?php  echo $setting['copyright'];?></a></div>
	<div class="showdetail" style="display:none;">
		<div class="title" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>"></div>
		<div class="content"></div>
		<div class="return"></div>
	</div>
	<?php  if($setting['isopen']) { ?>
	<a href="<?php  echo $this->createMobileUrl('showform');?>">
		<div style="position:fixed;bottom:10%;left:5px;">
			<img width="50" class="business-img" src="<?php  echo tomedia($setting['openpic']);?>" />
		</div>
	</a>
	<?php  } ?>

	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('menu', TEMPLATE_INCLUDEPATH)) : (include template('menu', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=jy_nearby"></script></body>
<script src="<?php echo NEARBY_JS;?>swiper.min.js"></script>
<script>


	$(function(){
		$('#LoadingBar').hide();
	})


	var swiper = new Swiper('.swiper-container', {
        paginationClickable: true,
        spaceBetween: 0,
        centeredSlides: true,
        autoplay: 3500,
        autoplayDisableOnInteraction: false
    });
    </script>

<script>
    var swiper = new Swiper('.swiper-container');
    $(".tel a").click(function(){
    	var a = $(this).attr("data");
    	if(a){
    		window.location.href = "tel:"+a;
    	}else{
    		swal('商家很懒，未标明电话号码!');
    	}
    })

    $(".nav .nodh").click(function(){
    	swal('商家很懒，未标明地址!');
    })

    $("#showdetail").click(function(){
    	var title = $(this).data('title'),
    	content = $(this).data('content');
    	$(".showdetail").css('display','block');
    	$(".showdetail .title").html(title);
    	$(".showdetail .content").html(content);
    })

    $(".return").click(function(){
    	$(".showdetail").css('display','none');
    })

</script>
<script type="text/javascript">
var params = {
    <?php  if(!empty($setting['sharetitle'])) { ?>
    title: "<?php  echo $setting['sharetitle'];?>",
    <?php  } else if(!empty($setting['title'])) { ?>
    title: "<?php  echo $setting['storename'];?>",
    <?php  } else { ?>
    title: "附近门店",
    <?php  } ?>

    <?php  if(!empty($setting['sharedesc'])) { ?>
    desc: "<?php  echo $setting['sharedesc'];?>",
    <?php  } else if(!empty($setting['title'])) { ?>
    desc: "<?php  echo $setting['title'];?>",
    <?php  } else { ?>
    desc: "附近门店",
    <?php  } ?>

    <?php  if(!empty($setting['sharelogo'])) { ?>
    imgUrl: "<?php  echo tomedia($setting['sharelogo'])?>",
    <?php  } else { ?>
    imgUrl: "<?php  echo $_W['siteroot'];?>addons/jy_signup_a/icon.jpg",
    <?php  } ?>
};
wx.ready(function () {
    wx.showOptionMenu();
    wx.onMenuShareAppMessage.call(this, params);
    wx.onMenuShareTimeline.call(this, params);
});
</script>
<script type="text/javascript">
$(window).scroll(function(){
	var clid = $("select[name='cateid']").val();
	var page = parseInt($("#page").val())+1;
	var isscroll = $("#isscroll").val();
	var sta="<?php  echo $sta;?>";
	var url = "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('ajaxindex'),2)?>"+"&rad="+Math.random();
	if(isscroll==1){
		if ($(window).scrollTop() == $(document).height() - $(window).height()) {
			$(".upload").show();
			$("#isscroll").val(2);
			setTimeout(function(){
					$.ajax({
						type: 'POST',
			    		url: url,
				    	data: {doajax:1,page:page,sta:sta,clid:clid},
				    	success:function(datas){
				    		if(datas.statue==1){
				    			$(".point").append(datas.data);
					    		$("#page").val(datas.page);
					    		$("#isscroll").val(1);
					    		$(".upload").hide();
				    		}else{
				    			$("#isscroll").val(2);
				    			$(".showindex").html('已加载全部');
				    		}
				    	},
				    	error:function(datas){

					    },
				    	dataType:'json',
					})
				},1000);
		}
	}
})
</script>

<script type="text/javascript">
	$('#getdistance').bind('click',function(){
		$('#newcate').removeClass('nowclass');
		$('#getdistance').addClass('nowclass');

		$("select[name='cateid']").find("option[value='0']").attr("selected",'true');
		var url = "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('classinfo'),2)?>"+"&rad="+Math.random();
		$.ajax({
				type: 'POST',
	    		url: url,
		    	data: {clid:0},
		    	success:function(datas){
		    		if(datas.statue==1){
		    			$(".point").html('');
		    			$(".point").html(datas.data);
			    		
		    		}else{
		    			$(".point").html('');
		    			alert('没有查找到相关门店');
		    		}
		    	},
		    	error:function(datas){

			    },
		    	dataType:'json',
			})
	});
	function getclass(){
		var url = "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('classinfo'),2)?>"+"&rad="+Math.random();
		var clid = $("select[name='cateid']").val();
		$('#newcate').addClass('nowclass');
		$('#getdistance').removeClass('nowclass');
		
			$.ajax({
				type: 'POST',
	    		url: url,
		    	data: {clid:clid},
		    	success:function(datas){
		    		if(datas.statue==1){
		    			$(".point").html('');
		    			$(".point").html(datas.data);
			    		
		    		}else{
		    			alert('没有查找到相关门店');
		    		}
		    	},
		    	error:function(datas){

			    },
		    	dataType:'json',
			})
		
	}
</script>

<script type="text/javascript">
	<?php  if(empty($stores)) { ?>
	swal('没有找到附近商家！');
	<?php  } ?>
</script>
</html>