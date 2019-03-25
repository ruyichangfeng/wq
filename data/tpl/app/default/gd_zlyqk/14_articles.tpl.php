<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<body ontouchstart>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:void (0)" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">最新公告</div>
</header>
<div class="ui-content">
    <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" action="#">
            <div class="weui-search-bar__box">
                <i class="weui-icon-search"></i>
                <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索你要找的公告通知" required="">
                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
            </div>
            <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                <i class="weui-icon-search"></i>
                <span>搜索你要找的公告通知</span>
            </label>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
    </div>
    <?php  if($default) { ?>
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__bd">
            <a href="<?php  echo $this->createMobileUrl('article')?>&id=<?php  echo $default['id'];?>" class="weui-media-box weui-media-box_appmsg">
                <?php  if($default['icon']) { ?>
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="/<?php  echo $default['icon'];?>" alt="">
                </div>
                <?php  } ?>
                <div class="weui-media-box__bd">
                    <div class="weui-media-box__title"><?php  echo $default['title'];?></div>
                    <div class="weui-media_footer"><span class="pull-left"><i class="media-zd">[置顶]</i><?php  echo $default['public'];?></span><span class="pull-right"><?php  echo date("Y-m-d H:i:s",$default['create_time'])?></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php  } ?>
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__bd">
            <?php  if(is_array($articles)) { foreach($articles as $article) { ?>
            <a href="<?php  echo $this->createMobileUrl('article')?>&id=<?php  echo $article['id'];?>" class="weui-media-box weui-media-box_appmsg">
                <?php  if($article['icon']) { ?>
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="/<?php  echo $article['icon'];?>" alt="">
                </div>
                <?php  } ?>
                <div class="weui-media-box__bd">
                    <div class="weui-media-box__title"><?php  echo $article['title'];?></div>
                    <div class="weui-media_footer"><span class="pull-left"><?php  echo $article['public'];?></span><span class="pull-right"><?php  echo date("Y-m-d H:i:s",$default['create_time'])?></span>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
