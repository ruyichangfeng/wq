<?php defined('IN_IA') or exit('Access Denied');?><script src="../addons/wxz_wzb/template/mobile/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
    wx.config({
        debug: false,
        appId: "<?php  echo $_W['account']['jssdkconfig']['appId'];?>",
        timestamp: "<?php  echo $_W['account']['jssdkconfig']['timestamp'];?>",
        nonceStr: "<?php  echo $_W['account']['jssdkconfig']['nonceStr'];?>",
        signature: "<?php  echo $_W['account']['jssdkconfig']['signature'];?>",
        jsApiList: ["onMenuShareAppMessage", "onMenuShareTimeline", "onMenuShareQQ"]
    });
    wx.ready(function () {
        sharedata = {
            title: "<?php  echo $setting['list_share_title'];?>",
            desc: "<?php  echo $setting['list_share_desc'];?>",
			link:"<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('index',array('share_uid' => $uid)))?>",
            imgUrl: "<?php  echo $_W['attachurl'].$setting['list_share_img']?>",
            success: function () {
				$.post("<?php  echo $_W['siteroot'].str_replace('./','app/',$this->createMobileurl('share'))?>", function(data) {
				  layer.open({
					  content: data.msg
					  ,style: 'background-color:#cc3333; color:#ffff66; border:none;font-size:20px;width:auto;' //自定风格
					  ,time: 2
					});
				},'json');
            },
            cancel: function () {
                //                        alert('分享取消');
            }
        };
        //            wx.onMenuShareAppMessage(sharedata);
        wx.onMenuShareTimeline(sharedata);
        wx.onMenuShareAppMessage(sharedata);
		wx.onMenuShareQQ(sharedata);
		
        //            wx.onMenuShareQQ(sharedata);
    });
</script>
<div style="display:none;">
<script src="https://s13.cnzz.com/z_stat.php?id=1273392991&web_id=1273392991" language="JavaScript"></script>
</div>