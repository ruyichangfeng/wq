<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/slide', TEMPLATE_INCLUDEPATH)) : (include template('common/slide', TEMPLATE_INCLUDEPATH));?>
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_o/css/xui.css" rel="stylesheet">
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_o/css/home.css" rel="stylesheet">
<style>
	body{
		background-color: <?php  echo $_W['styles']['indexbgcolor'];?>;	
	}
	a,a:hover,a:active,a:visited{
		color: <?php  echo $_W['styles']['linkcolor'];?>;
	}
	.carousel-indicators,.carousel-caption	{
		display: none;
	}
</style>
<div class="x-navs">
<?php  if(!empty($navs)) { ?>
	<?php  if(is_array($navs)) { foreach($navs as $index => $nav) { ?>
	<a class="x-cell x-cf" href="<?php  echo $nav['url'];?>" >
		<div class="x-cell-pic">
			<?php  if(!empty($nav['icon'])) { ?>
			<img src="<?php  echo $_W['attachurl'];?><?php  echo $nav['icon'];?>" class="x-img">
			<?php  } else { ?>
			<i class="x-i <?php  echo $nav['css']['icon']['icon'];?>" style="color:<?php  echo $nav['css']['icon']['color'];?>"></i>
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
	</a>
	<?php  } } ?>
<?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
