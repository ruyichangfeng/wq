<?php
/**
 * zjhl_ad_marketing
 * 自定义移动端公共函数 
 * @author  liuxiaofan0@139.com
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 【表单控件】: 单张图片上传
 * @param string $name 表单input名称
 * @param string $value 表单input值
 * @return string
 */
function cus_tpl_app_form_field_image($name, $value = '',$tip) {
	$thumb = empty($value) ? 'images/global/nopic.jpg' : $value;
	$thumb = tomedia($thumb);
	$html = <<<EOF
<style>
.webuploader-pick {color:#333;}
</style>
<div class="input-group">
	<input type="hidden" name="$name" value="$value" class="form-control" autocomplete="off" readonly="readonly">
	<a class="btn btn-default js-image-{$name}">{$tip}</a>
	<span style='color:red;'>(建议尺寸640*128)<span>
</div>
<span class="help-block">
	<img src="$thumb" width="100%" height="100px">
</span>

<script>
	util.image($('.js-image-{$name}'), function(url){
		$('.js-image-{$name}').prev().val(url.attachment);
		$('.js-image-{$name}').parent().next().find('img').attr('src',url.url);
	}, {
		crop : true,
		multiple : false,
		aspectRatio:5/1
	});
</script>
EOF;
	return $html;
}

