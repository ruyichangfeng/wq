<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("notice", TEMPLATE_INCLUDEPATH)) : (include template("notice", TEMPLATE_INCLUDEPATH));?>
<style>
    .list_close{position:absolute;margin-left:71px;margin-top:-9px;width: 18px;}
</style>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script type="text/javascript">
wx.config({
    debug: false,
    appId: "<?php  echo $jsSign['appId'];?>",
    timestamp:<?php  echo $jsSign['timestamp'];?>,
    nonceStr: "<?php  echo $jsSign['nonceStr'];?>",
    signature: "<?php  echo $jsSign['signature'];?>",
     jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'onVoicePlayEnd',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay'
      ]
});
</script>

