<?php defined('IN_IA') or exit('Access Denied');?><link rel="stylesheet" href="<?php echo STYLE_PATH;?>/css/swiper-3.4.2.min.css" />
<script type="text/Javascript" src="<?php echo STYLE_PATH;?>/js/swiper-3.4.2.min.js"></script>
<style>
.swiper-container {
width: 100%; max-height:250px;
}
.swiper-slide {
text-align: center; font-size: 18px; display: -webkit-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center;
}
.swiper-slide img{width:100%;max-height:250px;}
</style>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<?php  if(is_array($slide)) { foreach($slide as $index => $item) { ?>
		<div class="swiper-slide">
			<a href="<?php  echo $item['img_urls'];?>">
				<img src="<?php  echo tomedia($item['img']);?>">
			</a>
		</div>
		<?php  } } ?>
	</div>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
	<!-- Add Arrows -->
    <!-- <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div> -->
</div>

<script>
	$(function() {
		var mySwiper = new Swiper('.swiper-container', 
			{ loop : true, speed : 1800, autoplay : 3000, autoplayDisableOnInteraction : false, pagination : '.swiper-pagination',paginationClickable: '.swiper-pagination' });
	});
	//,nextButton: '.swiper-button-next', prevButton: '.swiper-button-prev'
</script>
