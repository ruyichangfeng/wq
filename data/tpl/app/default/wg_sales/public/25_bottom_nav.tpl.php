<?php defined('IN_IA') or exit('Access Denied');?><div class="bottom-nav">
    <ul class="flex-box" id="botnav" style="background-image:url(<?php echo STATIC_ROOT;?>/images/T1AudbB5JT1RCvBVdK.png);">

        <?php  foreach($menu as $m){?>
        <li class="flex1">
            <a href="<?php  echo $m['url'];?>">
                <img src="<?php  echo $_W['attachurl'];?><?php  echo $m['unselect'];?>" alt="">
                <p class="tit"><?php  echo $m['name'];?></p>
            </a>
        </li>
        <?php  }?>
    </ul>
</div>