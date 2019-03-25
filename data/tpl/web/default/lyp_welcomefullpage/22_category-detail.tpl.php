<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset=utf-8"UTF-8" />
	<title><?php  echo $other['title'];?></title>
	<meta name="keywords" content="<?php  echo $other['keywords'];?>">
	<meta name="description" content="<?php  echo $other['description'];?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
	<link href="<?php echo MODULE_URL;?>resource/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo MODULE_URL;?>resource/css/inner.min.css" rel="stylesheet" />
	<script src="<?php echo MODULE_URL;?>resource/js/jquery.min.js"></script>
	<script src="<?php echo MODULE_URL;?>resource/js/bootstrap.min.js"></script>
	<script src="<?php echo MODULE_URL;?>resource/js/inner.min.js"></script>
	<style>
		.artlist ul.items li span.date {
			float: left;
			display: block;
			padding-top: 2px;
			width: 58px;
			height: 66px;
			background: url(<?php echo MODULE_URL;?>resource/images/icons.png) no-repeat 0 -32pc;
			color: #fff;
			text-align: center;
			font-size: 24px
		}
	</style>
</head>

<body>
	<header>
		<div class="box">
			<a href="javascript:;"><img src="<?php  echo tomedia($welcomeinfo['home']['logo'])?>" alt="noimg" width="150px"></a>
			<div class="wechat">
				<img src="<?php  echo tomedia($welcomeinfo['connect']['thumb']);?>" alt="noimg" class="wechat"><p>扫一扫微信二维码<i></i></p>
			</div>
			<nav>
			<ul>
				<li><a href="<?php  echo $welcomeurl;?>">观看首页</a></li>
				<li class='active'><a href="">案例集合</a></li>
			</ul>
			</nav>
		</div>
		<footer>
			高端定制，品牌设计<br /><span><?php  echo $welcomeinfo['connect']['company'];?></span>
		</footer>
	</header>
	
	<section class="toolbar">
		<a href="<?php  echo $welcomeurl;?>" title="返回首页" class="homelink"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<span class="switch glyphicon glyphicon-th-list"></span>
		<div class="category btn-group">
			<?php  if(defined('SYSTEM_WELCOME_MODULE')) { ?>
				<a href="<?php  echo $this->createWebUrl('category_detail', array('direct' => 1, 'uniacid' => $uniacid, 'm' => $_W['current_module'], 'module_type' => 'system_welcome'))?>" class="btn btn-default <?php  if(empty($_GPC['category_id'])) { ?>btn-primary<?php  } ?>">全部</a>
				<?php  if(!empty($category_list)) { ?>
					<?php  if(is_array($category_list)) { foreach($category_list as $category) { ?>
					<a href="<?php  echo $this->createWebUrl('category_detail', array('direct' => 1, 'uniacid' => $uniacid, 'category_id' => $category['id'], 'm' => $_W['current_module'], 'module_type' => 'system_welcome'))?>" class="btn btn-default <?php  if($category['id'] == $category_id) { ?>btn-primary<?php  } ?>"><?php  echo $category['title'];?></a>
					<?php  } } ?>
				<?php  } ?>
			<?php  } else { ?>
				<a href="<?php  echo $this->createWebUrl('category_detail', array('direct' => 1, 'uniacid' => $uniacid, 'm' => $_W['current_module']))?>" class="btn btn-default <?php  if(empty($_GPC['category_id'])) { ?>btn-primary<?php  } ?>">全部</a>
				<?php  if(!empty($category_list)) { ?>
					<?php  if(is_array($category_list)) { foreach($category_list as $category) { ?>
					<a href="<?php  echo $this->createWebUrl('category_detail', array('direct' => 1, 'uniacid' => $uniacid, 'category_id' => $category['id'], 'm' => $_W['current_module']))?>" class="btn btn-default <?php  if($category['id'] == $category_id) { ?>btn-primary<?php  } ?>"><?php  echo $category['title'];?></a>
					<?php  } } ?>
				<?php  } ?>
			<?php  } ?>
		</div>
	</section>
	
	<section class="artlist content">
		<ul class="items">
			<?php  if(!empty($article_list)) { ?>
				<?php  if(is_array($article_list)) { foreach($article_list as $article) { ?>
				<li>
					<p class="left">
					<span class="date"><?php  echo $article['create_day'];?><u><?php  echo $article['create_month'];?></u></span>
					<a href="<?php  echo $article['link'];?>" target="_blank" class="thumb"><img src="<?php  echo tomedia($article['thumb']);?>" alt="noimg" width="230px"></a>
					</p>
					<p class="right">
					<span class="title"><a href="<?php  echo $article['link'];?>" target="_blank"><?php  echo $article['title'];?></a></span>
					<span class="rel"><?php  echo $article['create_date'];?><u>•</u><?php  echo $article['author'];?></span>
					<span class="summary"><?php  echo $article['digest'];?>. . .</span>
					<span class="tags">
						<span class="glyphicon glyphicon-tag"></span>
						<a href="javascript:;"><?php  echo $article['category'];?></a>&nbsp; 
					</span>
					</p>
				</li>
				<?php  } } ?>
			<?php  } ?>
		</ul>
		<style>

		</style>
		 <div id="paging">
		 	<?php  echo $pager;?>
		 </div>
	</section>
	
	<div class="dock">
		<ul class="icons">
			<li class="up"><i></i></li>
			<li class="tel">
				<i></i><p>建站咨询热线<br /><?php  echo $welcomeinfo['connect']['phone'];?></p>
			</li>
			<li class="im">
				<i></i><p><a href="tencent://message/?uin=<?php  echo $welcomeinfo['connect']['qq'];?>&Menu=yes">点我，建站咨询</a></p>
			</li>
		</ul>
	</div>
</body>
</html>