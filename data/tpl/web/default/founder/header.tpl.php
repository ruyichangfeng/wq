<?php defined('IN_IA') or exit('Access Denied');?><div class="we7-page-title">副创始人管理 </div>
<ul class="we7-page-tab">
	<?php  if(permission_check_account_user('see_system_manage_vice_founder')) { ?>
		<li <?php  if($action == 'display') { ?> class="active"<?php  } ?>><a href="<?php  echo url('founder/display');?>">副创始人管理</a></li>
		<li <?php  if($action == 'group') { ?> class="active"<?php  } ?>><a href="<?php  echo url('founder/group');?>">副创始人权限组</a></li>
	<?php  } ?>
</ul>