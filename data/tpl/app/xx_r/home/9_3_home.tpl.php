<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_r/css/xui.css" rel="stylesheet">
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_r/css/swiper.min.css" rel="stylesheet" >
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_r/css/home.css" rel="stylesheet">
<script src="<?php  echo $_W['siteroot'];?>app/themes/xx_r/css/swiper.min.js"></script>
<style>
html,body,.container-fill{
	height:100%;
}
body{
	background-image:url('<?php  echo $_W['styles']['indexbgimg'];?>');
	background-size:cover;
background-color:<?php  if(empty($_W['styles']['indexbgcolor'])) { ?>#4D4862<?php  } else { ?><?php  echo $_W['styles']['indexbgcolor'];?><?php  } ?>;
<?php  echo $_W['styles']['indexbgextra'];?>
}
</style>
<div class="x-top">
	<div class="x-site" style="color: <?php  echo $_W['styles']['fontcolor'];?>;font-size: <?php  echo $_W['styles']['fontsize'];?>;">
		<span class="x-name">
			<?php  echo $_W['styles']['name'];?>
		</span>
	</div>
</div>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<?php  if(!empty($navs)) { ?>
		<?php  if(is_array($navs)) { foreach($navs as $index => $nav) { ?>
		<div class="swiper-slide x-item">
			<a class="x-cell" href="<?php  echo $nav['url'];?>" >
				<div class="x-cell-pic">
					<?php  if(!empty($nav['icon'])) { ?>
					<img src="<?php  echo $_W['attachurl'];?><?php  echo $nav['icon'];?>" class="x-pic">
					<?php  } else { ?>
					<i class="x-icon <?php  echo $nav['css']['icon']['icon'];?>" style="background-color:<?php  echo $nav['css']['icon']['color'];?>"></i>
					<?php  } ?>
				</div>
				<div class="x-cell-txt">
					<div class="x-tit">
						<?php  echo $nav['name'];?>
					</div>
					<div class="x-des">
						<?php  echo $nav['description'];?>
					</div>
				</div>
				<div class="x-cell-ft">
					查看
				</div>
			</a>
		</div>
		<?php  } } ?>
		<?php  } ?>
	</div>
</div>
<script>
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 2,
		paginationClickable: true,
		spaceBetween: 15,
		freeMode: true
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
