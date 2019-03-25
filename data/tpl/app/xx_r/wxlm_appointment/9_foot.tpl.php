<?php defined('IN_IA') or exit('Access Denied');?><ul class="footer">
    <?php  if($_SESSION['index'] == 2) { ?>
    <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> ">
        <a href="<?php  echo $this->createMobileUrl('other', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon01.png">
            <span>首页</span>
        </a>
    </li>
    <?php  } else { ?>
    <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> ">
        <a href="<?php  echo $this->createMobileUrl('index', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon01.png">
            <span>首页</span>
        </a>
    </li>
    <?php  } ?>
    <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?>">
        <a href="<?php  echo $this->createMobileUrl('mine', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon02.png">
            <span>个人中心</span>
        </a>
    </li>
    <?php  if($this->config['show_state'] == 2) { ?>
    <li class="col-xs-4">
        <a href="<?php  echo $this->createMobileUrl('show', array())?>">
            <img src="<?php echo RES;?>mobile/images/icon03.png">
            <span>作品</span>
        </a>
    </li>
    <?php  } ?>
</ul>