<?php defined('IN_IA') or exit('Access Denied');?><style>
    .footer_fixed {
        min-width: 320px;
        width: 100%;
        max-width: 640px;
        position: fixed;
        bottom: 0;
        background-color: #16506E;
    }

    .footer_fixed li {
        float: left;
        width: 50%;
        border-right: 1px solid #252525;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }

    .footer_fixed .icon {
        width: 100%;
        margin: 0;
        text-align: center;
        font-size: 0;
        padding-top: 4px;
    }
    .footer_fixed .icon img {
        width: 20%;
    }
    .footer_fixed .bt {
        width: 100%;
        text-align: center;
        color: #fff;
        height: 16px;
        padding-bottom: 2px;
        float: none;
        font-size: 12px;
    }

</style>
<?php  if($xkwkj['show_index_enable']) { ?>
<!--<div class="footer_fixed">-->
    <!--<li><a href="<?php  echo $this->createMobileUrl('HomeIndex', array(), true)?>">-->
        <!--<div class="icon"><img src="<?php echo MON_XKWKJ_RES;?>images/foot_icon2.png" alt=""></div>-->
        <!--<div class="bt"> 逛逛其他砍价</div>-->
    <!--</a></li>-->
    <!--<li><a href="<?php  echo $this->createMobileUrl ( 'auth',array('au'=>Value::$REDIRECT_MY_KJ))?>">-->
        <!--<div class="icon"><img src="<?php echo MON_XKWKJ_RES;?>images/foot_icon3.png" alt=""></div>-->
        <!--<div class="bt">我的砍价</div>-->
    <!--</a></li>-->
<!--</div>-->
<?php  } ?>