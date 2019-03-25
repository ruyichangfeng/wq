<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
    .mui-bar-tab {
        bottom: 0;
        display: table;
        width: 100%;
        height: 50px;
        padding: 0;
        table-layout: fixed;
        border-top: 0;
        border-bottom: 0;
        -webkit-touch-callout: none;
    }
    .mui-bar {
        position: fixed;
        z-index: 10;
        right: 0;
        left: 0;
        height: 44px;
        padding-right: 10px;
        padding-left: 10px;
        border-bottom: 0;
        background-color: #f7f7f7;
        -webkit-box-shadow: 0 0 1px rgba(0,0,0,.85);
        box-shadow: 0 0 1px rgba(0,0,0,.85);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
    }
    .mui-bar-tab .mui-tab-item.mui-active {
        color: <?php  echo $html['config']['theme_color'];?>;
    }
    .mui-bar-tab .mui-tab-item {
        display: table-cell;
        overflow: hidden;
        width: 1%;
        height: 50px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #666;
    }
</style>
<?php  if($html['tabs']) { ?>
<nav class="mui-bar mui-bar-tab ">
    <?php  if(is_array($html['tabs'])) { foreach($html['tabs'] as $tab) { ?>
    <a class="mui-tab-item" href="<?php  echo $tab['url'];?>"><?php  echo $tab['name'];?></a>
    <?php  } } ?>
</nav>
<?php  } ?>