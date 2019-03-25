<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
    <li  <?php  if($_GPC['do']=="topicManage") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('topicManage',array('lid'=>$lid))?>">图片管理</a></li>
	<li  <?php  if($_GPC['do']=="video") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('video',array('lid'=>$lid))?>">短视频</a></li>
    <li  <?php  if($_GPC['do']=="comment") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('comment',array('lid'=>$lid))?>">评论列表</a></li>
    <li  <?php  if($_GPC['do']=="users") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('users',array('lid'=>$lid))?>">观众列表</a></li>
    <li  <?php  if($_GPC['do']=="indexManage") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('indexManage',array('lid'=>$lid))?>">聚合首页</a></li>
</ul>