<?php defined('IN_IA') or exit('Access Denied');?> <div class="weui_tabbar" style="position:fixed;">
        <?php  if(is_array($menu)) { foreach($menu as $m) { ?>

            <a href="<?php  echo $m['url'];?>" class="weui_tabbar_item" style="border-right:1px solid #E3E3E3;">
                <div class="weui_tabbar_icon">
                <img src="<?php  echo tomedia($m['thumb'])?>" alt="">
                </div>
                <p class="weui_tabbar_label"><?php  echo $m['name'];?></p>
            </a>
        <?php  } } ?>

        </div>