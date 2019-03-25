<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($sitem['copyright'])) { ?>
<style type="text/css">
	.footerTxt{
        width: 100%;
        padding-top: 10px;
        padding-bottom: 10px;
        display: inline-block;
        text-align: center
    }
    @media screen and (max-width: 320px){
		.footerTxt{font-size:14px}
	}

</style>
<a class="footerTxt latecolor" <?php  if(!empty($sitem['copyrighturl'])) { ?>href="<?php  echo $sitem['copyrighturl'];?><?php  } else { ?>href="javascript:void(0);"<?php  } ?>">©<?php  echo $sitem['copyright'];?></a>
<?php  } ?>