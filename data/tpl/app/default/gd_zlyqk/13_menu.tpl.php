<?php defined('IN_IA') or exit('Access Denied');?><style>
    .weui-tabbar {
        position: fixed;
        background: #FFFFFF;
    }
    .weui-tabbar__item {
        display: block;
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
        padding: 5px 0 0;
        font-size: 0;
        color: #999;
        text-align: center;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    }
    .weui-tabbar .weui-tabbar__item img {
        display: block;
        width: 22px;
        height: 22px;
        margin: 0 auto;
    }
    a img {
        border: 0;
    }
</style>
<footer class="ui-footer">
    <div class="weui-tabbar">
        <?php  if(is_array($menus)) { foreach($menus as $menu) { ?>
        <a href="<?php  echo $menu['url'];?>" class="weui-tabbar__item">
            <img src="<?php  if(strstr($menu['unselect_cover'],'http')) { ?><?php  echo $menu['unselect_cover'];?><?php  } else { ?>/<?php  echo $menu['unselect_cover'];?><?php  } ?>" alt="" />
            <p class="weui-tabbar__label"><?php  echo $menu['title'];?></p>
        </a>
        <?php  } } ?>
    </div>
</footer>