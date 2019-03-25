<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<body ontouchstart>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:void(0)" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">公告</div>
</header>
<div class="ui-content">
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__bd" style="padding: 10px;">
            <div><?php  echo $article['title'];?></div>
            <div style="font-size: 13px;"><span style="color: #f08500">来源: <?php  echo $article['public'];?></span>  <span style="color: #999999">发布: <?php  echo date("Y-m-d H:i:s",$article['create_time'])?></span></div>
            <br>
            <p>
                <?php  echo $article['content'];?>
            </p>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<script>
    $(function() {
    });
</script>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=13&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
