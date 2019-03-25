<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<script>
    var currenturl = encodeURIComponent("<?php  echo $_W['siteurl'];?>");

    if(window.__wxjs_environment === 'miniprogram') {
        wx.ready(function(){
            wx.miniProgram.navigateTo({
                url: "/wxapp_web/pages/view/index?url="+currenturl+"&userinfo=1"
            })
        })

    } else {
        window.location.href = "<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=wxapp&a=home&do=oauth&url="+currenturl;
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>