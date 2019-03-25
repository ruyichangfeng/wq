<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
	<li <?php  if($_GPC['do']=='index') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('index');?>">首页设置</a></li>
	<li <?php  if($_GPC['do']=='function') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('function');?>">核心功能</a></li>
	<li <?php  if($_GPC['do']=='case') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('case');?>">精彩案例</a></li>
	<li <?php  if($_GPC['do']=='program') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('program');?>">小程序案例</a></li>
	<li <?php  if($_GPC['do']=='times') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('times');?>">小程序时代</a></li>
	
</ul>