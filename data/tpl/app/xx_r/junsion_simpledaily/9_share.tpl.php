<?php defined('IN_IA') or exit('Access Denied');?><?php  echo register_jssdk(false);?>
<script type="text/javascript">
wx.ready(function () {
	shareData = {
		title: "<?php  echo $stitle;?>",
		link: "<?php  echo $surl;?>",
		desc: "<?php  echo $desc;?>",
		imgUrl: "<?php  echo $thumb;?>"
	   };

	    wx.onMenuShareAppMessage(shareData);
	    wx.onMenuShareTimeline(shareData);
	    wx.onMenuShareQQ(shareData);
	    wx.onMenuShareWeibo(shareData);
});
</script>