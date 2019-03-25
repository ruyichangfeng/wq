<?php defined('IN_IA') or exit('Access Denied');?><span class="top-view">
<?php  if(!empty($selected_account)) { ?>
	<?php  if(in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH))) { ?>
		<a href="<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_CLERK) { ?>javascript:;<?php  } else { ?><?php  echo url('account/display/switch', array('uniacid' => $_W['uniacid'], 'type' => $_W['account']['type']))?><?php  } ?>" title="<?php  echo $_W['account']['name']?>" target="_blank">
			<i class="wi wi-wechat"></i><?php  echo $_W['account']['name'];?>
		</a>
		<?php  if(!empty($selected_account['version_info'])) { ?>
		<a href="<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_CLERK) { ?>javascript:;<?php  } else { ?><?php  echo url('account/display/switch', array('uniacid' => $selected_account['version_info']['uniacid'], 'version_id' => $selected_account['version_id'], 'type' => $_W['account']['type']))?><?php  } ?>" title="<?php  echo $account['wxapp_name']?>" target="_blank">
			<i class="wi wi-wxapp"></i><?php  echo $selected_account['wxapp_name'];?>
		</a>
		<?php  } ?>
	<?php  } ?>
	<?php  if(in_array($_W['account']['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_ALIAPP_NORMAL))) { ?>
		<?php  if($selected_account['version_info']['uniacid'] != $selected_account['uniacid']) { ?>
		<a href="<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_CLERK) { ?>javascript:;<?php  } else { ?><?php  echo url('account/display/switch', array('uniacid' => $selected_account['uniacid'], 'type' => $_W['account']['type']))?>" title="<?php  echo $_W['account']['name']?><?php  } ?>" target="_blank">
			<i class="wi wi-<?php  echo $_W['account']['type_sign']?>"></i><?php  echo $_W['account']['name'];?>
		</a>
		<?php  } ?>
		<a href="<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_CLERK) { ?>javascript:;<?php  } else { ?><?php  echo url('account/display/switch', array('uniacid' => $selected_account['version_info']['uniacid'], 'version_id' => $selected_account['version_id'], 'type' => $_W['account']['type']))?><?php  } ?>" title="<?php  echo $selected_account['wxapp_name']?>" target="_blank" class="hidden">
			<i class="wi wi-wxapp"></i><?php  echo $selected_account['wxapp_name'];?>
		</a>
	<?php  } ?>
<?php  } ?>
</span>
<span class="dropdown">
	<a href="javascript:;" class="dropdown-icon" data-toggle="dropdown" aria-expanded="false"><i class="wi wi-angle-down"></i></a>
	<ul class="dropdown-menu dropdown-menu-right" role="menu">
		<?php  if(is_array($accounts_list)) { foreach($accounts_list as $account) { ?>
		<li>
			<a href="<?php  echo $account['url']?>">
				<span>
					<?php  if($account['type_name'] == ACCOUNT_TYPE_SIGN) { ?>
					<i class="wi wi-wechat"></i>
					<?php  } else if($account['type_name'] == WXAPP_TYPE_SIGN) { ?>
					<i class="wi wi-wxapp"></i>
					<?php  } else if($account['type_name'] == WEBAPP_TYPE_SIGN) { ?>
					<i class="wi wi-pc"></i>
					<?php  } else if($account['type_name'] == PHONEAPP_TYPE_SIGN) { ?>
					<i class="wi wi-app"></i>
					<?php  } else if($account['type_name'] == XZAPP_TYPE_SIGN) { ?>
					<i class="wi wi-xzapp"></i>
					<?php  } else if($account['type_name'] == ALIAPP_TYPE_SIGN) { ?>
					<i class="wi wi-aliapp"></i>
					<?php  } ?>
					<?php  echo $account['account_name'];?>
				</span>
			</a>
		</li>
		<?php  } } ?>
	</ul>
</span>