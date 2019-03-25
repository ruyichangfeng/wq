<?php defined('IN_IA') or exit('Access Denied');?><img src="<?php  echo tomedia('headimg_'.$wxapp_info['acid'].'.jpg')?>?time=<?php  echo time()?>" class="head-logo">
<span class="wxapp-name"><?php  echo $account['name'];?></span>
<div class="pull-right">
	<?php  if(in_array($role, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
	<a href="<?php  echo url('account/post', array('uniacid' => $_W['account']['uniacid'], 'acid' => $_W['acid'], 'account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL))?>"><i class="wi wi-appsetting"></i>设置</a>
	<?php  } ?>
	<a href="<?php  echo url('account/display', array('type' => 'all'))?>" class="color-default"><i class="wi wi-small-routine"></i>切换平台</a>
</div>