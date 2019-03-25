<?php defined('IN_IA') or exit('Access Denied');?><img src="<?php  echo $_W['account']['logo'];?>" class="head-logo">
<span class="wxapp-name"><?php  echo $_W['account']['name'];?></span>
<span class="wxapp-version"><?php  echo $version_info['version'];?></span>
<div class="pull-right">
	<?php  if($_W['account']['type'] == ACCOUNT_TYPE_ALIAPP_NORMAL) { ?>
		<a href="<?php  echo url('miniapp/version/display')?>" class="color-default"><i class="wi wi-cut"></i>切换版本</a>
		<?php  if(in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
		<a href="<?php  echo url('miniapp/manage/display', array('uniacid' => $_W['uniacid']))?>" class="color-default"><i class="wi wi-text"></i>管理</a>
		<?php  } ?>
	<?php  } else { ?>
		<a href="<?php  echo url('wxapp/version/display')?>" class="color-default"><i class="wi wi-cut"></i>切换版本</a>
		<?php  if(in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
		<a href="<?php  echo url('wxapp/manage/display', array('uniacid' => $_W['uniacid']))?>" class="color-default"><i class="wi wi-text"></i>管理</a>
		<?php  } ?>	
	<?php  } ?>
	<a href="<?php  echo url('account/display', array('type' => 'all'))?>" class="color-default"><i class="wi wi-small-routine"></i>切换平台</a>
</div>