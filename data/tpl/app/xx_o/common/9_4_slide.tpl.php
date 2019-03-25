<?php defined('IN_IA') or exit('Access Denied');?><div id="carousel-container" class="carousel slide">
	<?php  $slides = app_slide(array('multiid'=>$multiid));?>
	<ol class="carousel-indicators">
		<?php  $slideNum = 0;?>
		<?php  if(is_array($slides)) { foreach($slides as $row) { ?>
		<li data-target="#carousel-container" data-slide-to="<?php  echo $slideNum;?>"<?php  if($slideNum == '0') { ?> class="active"<?php  } ?>></li>
		<?php  $slideNum++;?>
		<?php  } } ?>
	</ol>

	<div class="carousel-inner" role="listbox">
		<?php  if(is_array($slides)) { foreach($slides as $row) { ?>
		<div class="item<?php  if($slides['0'] == $row) { ?> active<?php  } ?>">
			<a href="<?php  echo $row['url'];?>">
				<img src="<?php  echo $row['thumb'];?>" title="<?php  echo $row['title'];?>" style="width:100%; vertical-align:middle;">
			</a>
			<div class="carousel-caption">
				<?php  echo $row['title'];?>
			</div>
		</div>
		<?php  } } ?>
	</div>
</div>
<script>
	require(['bootstrap', 'hammer'], function($, Hammer){
		$('#carousel-container').carousel();
		var mc = new Hammer($('#carousel-container').get(0));
		mc.on("panleft", function(ev) {
			$('#carousel-container').carousel('next');
		});
		mc.on("panright", function(ev) {
			$('#carousel-container').carousel('prev');
		});
	});
</script>
