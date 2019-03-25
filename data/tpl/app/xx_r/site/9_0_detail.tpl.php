<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_r/css/xui.css" rel="stylesheet">
<link href="<?php  echo $_W['siteroot'];?>app/themes/xx_r/css/detail.css" rel="stylesheet">
<div class="x-box">
	<div class="x-title">
		<?php  echo $detail['title'];?>
	</div>
	<div class="x-info">
		<span>
			<?php  echo date("Y-m-d", $detail['createtime']);?> 
		</span> 
		<span>
			<?php  echo $detail['author'];?>  
		</span>
		<span class="x-name">
			<?php  echo $_W['account']['name'];?>
		</span>
	</div>
	<div class="x-gzh x_img">
		<img src="<?php  echo tomedia('qrcode_'.$_W['uniaccount']['uniacid'].'.jpg')?>?time=<?php  echo time()?>" class="gzh-pic" />
	</div>
	<div class="x-content">
		<?php  echo $detail['content'];?>
	</div>
	<div class="x-tool">
		<?php  if(!empty($detail['source'])) { ?><a href="<?php  echo $detail['source'];?>" class="x-source">阅读原文</a>
		<span><?php  } ?>阅读:<?php  echo $detail['click'];?></span>
	</div>
</div>
<script>
	$('.x-name').bind('click', function() {
		$('.x-gzh').toggle(500);		
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>