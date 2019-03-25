<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
<?php  if(!empty($sitem['color'])) { ?>
<?php  $color=$sitem['color'];?>
<?php  } else { ?>
<?php  $color='#46CEC0';?>
<?php  } ?>
	header{
		background-color:<?php  echo $color;?>;
	}
	.latecolor{
		color: <?php  echo $color;?>;
	}
	.latecolorbg{
		background-color: <?php  echo $color;?>;
	}
	.lateborder{border:1px solid <?php  echo $color;?>}
</style>