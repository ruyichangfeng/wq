<?php defined('IN_IA') or exit('Access Denied');?><script src="<?php echo MODULE_URL;?>/static/new/js/jquery-2.1.4.js"></script>
<!--<script src="<?php echo MODULE_URL;?>/static/new/js/fastclick.js"></script>-->
<script src="<?php echo MODULE_URL;?>/static/new/js/jquery-weui.js"></script>
<!--<script src="<?php echo MODULE_URL;?>/static/new/js/city-picker.min.js"></script>-->
<script src="<?php echo MODULE_URL;?>/static/mobile/js/layer.js"></script>
<script>
    //员工和个人
    function goHome(){
        <?php  if($isAdmin) { ?>
        location.href="<?php  echo $this->createMobileUrl('staff')?>";
        <?php  } else { ?>
        location.href="<?php  echo $this->createMobileUrl('member')?>";
        <?php  } ?>
        return false;
    }

    //跳转到消息列表
    function goMemberList(){
        location.href="<?php  echo $this->createMobileUrl('category')?>";
        return false;
    }

    //跳转到工作台
    function goStaffList(){
        location.href="<?php  echo $this->createMobileUrl('msg')?>";
        return false;
    }

    //普通后退
    function goBack(){
        if(window.history.length > 1){
            window.history.go( -1 );
        }else{
           goHome();
        }
        return false;
    }

    $(document).ready(function(){
        $(".icon-back").click(function(){
            goBack();
        });
    });
</script>