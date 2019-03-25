<?php defined('IN_IA') or exit('Access Denied');?><div id="toast_error" style="display: none;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-icon-warn weui-icon_toast" style="font-size: 45px;color:#f08500;margin-bottom: 5px;"></i>
        <p class="weui-toast__content"></p>
    </div>
</div>
<div id="toast_success" style="display: none;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-icon-success-no-circle " style="font-size: 45px;color:#f08500;margin-bottom: 5px;margin-top:24px;"></i>
        <p class="weui-toast__content"></p>
    </div>
</div>

<script>
    //成功提示信息
    function successMsg(msg){
        var $toast = $('#toast_success');
        if ($toast.css('display') != 'none') return;
        $toast.find(".weui-toast__content").html(msg);
        $toast.fadeIn(100);
        setTimeout(function () {
            $toast.fadeOut(100);
        }, 2000);
    }

    //成功提示信息
    function errorMsg(msg){
        var $toast = $('#toast_error');
        if ($toast.css('display') != 'none') return;
        $toast.find(".weui-toast__content").html(msg);
        $toast.fadeIn(100);
        setTimeout(function () {
            $toast.fadeOut(100);
        }, 2000);
    }
</script>