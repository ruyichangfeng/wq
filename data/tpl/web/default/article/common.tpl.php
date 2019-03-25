<?php defined('IN_IA') or exit('Access Denied');?><ul class="we7-page-tab">
    <?php  if($action == 'news') { ?>
        <li <?php  if($action == 'news' && $do == 'list') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/news/list');?>">新闻列表</a></li>
        <li <?php  if($action == 'news' && $do == 'category') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/news/category');?>">新闻分类</a></li>
    <?php  } ?>
    <?php  if($action == 'notice') { ?>
        <li <?php  if($action == 'notice' && $do == 'list') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/notice/list');?>">公告列表</a></li>
        <li <?php  if($action == 'notice' && $do == 'category') { ?> class="active"<?php  } ?>><a href="<?php  echo url('article/notice/category');?>">公告分类</a></li>
    <?php  } ?>
</ul>