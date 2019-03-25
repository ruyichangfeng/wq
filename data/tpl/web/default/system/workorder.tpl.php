<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" language="javascript">
	if(window.addEventListener) {
		window.addEventListener('message', function(e){
			$('#iframepage').height(e.data.height+200); //选中图片导致高度又变高了
		});
	}
</script>
<iframe src="<?php  echo $iframe_url;?>" frameborder="0" width="100%"  id="iframepage" scrolling="no">

</iframe>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>