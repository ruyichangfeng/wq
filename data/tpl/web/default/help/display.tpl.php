<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($do == 'system') { ?>
<div style="z-index: 1;" class="iframe-div">
	<iframe src="//s.we7.cc/index.php?c=wiki&a=view&id=2&list=29&simple=1<?php  if($_W['isfounder'] && !user_is_vice_founder()) { ?>&role=admin<?php  } ?>" marginheight="0" marginwidth="0" frameborder="0" width="100%" height="100%" allowTransparency="true"></iframe>
</div>
<?php  } ?>
<?php  if($do == 'custom') { ?>
<div style="z-index: 1;" class="iframe-div">
	<?php  if(!empty($wiki_id)) { ?>
	<iframe src="//s.we7.cc/index.php?c=wiki&a=view&id=<?php  echo $wiki_id;?>&simple=1" marginheight="0" marginwidth="0" frameborder="0" width="100%" height="100%" allowTransparency="true"></iframe>
	<?php  } else { ?>
	<div class="we7-margin-vertical text-center font-lg">ÔÝÎÞÄÚÈÝ</div>
	<?php  } ?>
</div>
<?php  } ?>
<script>
    var targetOrigin = "<?php  echo $_W['sitescheme']?>" + 's.we7.cc';
    function _mainFrame() {
        window.frames[0].postMessage('getHeight', targetOrigin);
    }
    window.addEventListener('message',function(e) {
        var canvasHeight = e.data;
        $('.iframe-div').css({'height': canvasHeight + 'px', 'overflow': 'hidden'});
    })
    window.setInterval("_mainFrame()", 100);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>