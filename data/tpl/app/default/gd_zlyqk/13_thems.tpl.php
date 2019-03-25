<?php defined('IN_IA') or exit('Access Denied');?><?php 
    if (empty($baseConfig['app_color'])){
        $color="#F08500";
    }else{
        $color=$baseConfig['app_color'];
    }
?>
<style>
    .ui-member:after{background: <?php  echo $color;?> !important;}
    .wk-tit:after{background: <?php  echo $color;?> !important;}
    .work-end:after{border-color: <?php  echo $color;?> !important;}
    .bulletin{background: <?php  echo $color;?> !important;}
    .selectbar .text{color:<?php  echo $color;?> !important;}
    .msg-style li.active a{color:<?php  echo $color;?> !important;}
    .weui-media-box__end .end-status span{color:<?php  echo $color;?> !important;}
    .weui-panel__footer .ft-button .weui-btn_look{background: <?php  echo $color;?> !important;}
    .weui-navbar-tabs .weui-bar__item--on{color:<?php  echo $color;?> !important;}
    .weui-navbar-tabs .weui-bar__item--on:before{border-bottom: 2px solid <?php  echo $color;?> !important;}
    .progress-list:before{border: 4px solid <?php  echo $color;?> !important;}
    .progress-list li:after{border: 4px solid <?php  echo $color;?> !important;}
    .progress-list:after{background:<?php  echo $color;?> !important;}
    .cell-infos .number{color:<?php  echo $color;?> !important;}
    .m_sig .weui-btn_primary{background:<?php  echo $color;?> !important; }
    .m_sig .weui-btn_confirm{background:<?php  echo $color;?> !important; }
</style>