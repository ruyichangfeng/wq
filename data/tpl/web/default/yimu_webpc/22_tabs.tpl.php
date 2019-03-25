<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($_GPC['do']=='anliindex') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('anliindex');?>">顶部大图</a></li>
	<li <?php  if($_GPC['do']=='anli') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('anli');?>">案例管理</a></li>
	<li <?php  if($_GPC['do']=='intanli') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('intanli');?>">添加案例</a></li>
	
</ul>