<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<body ontouchstart>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("thems", TEMPLATE_INCLUDEPATH)) : (include template("thems", TEMPLATE_INCLUDEPATH));?>
<div class="ui-member">
    <div class="weui-flex__item">
        <div class="member-infos">
            <div class="text">余额</div>
            <div class="number"><?php  echo $wqInfo['credit2'];?></div>
        </div>
    </div>
    <div class="weui-flex__item">
        <div class="ui-avatar">
            <img src="<?php  echo $fansInfo['avatar'];?>" class="avatar-head" alt="" />
            <div class="ui-m-item"><?php  echo $memberInfo['name'];?></div>
            <div class="ui-m-item">[<?php  echo $memberLabel['label_name'];?>]</div>
        </div>
    </div>
    <div class="weui-flex__item">
        <div class="member-infos">
            <div class="text">积分</div>
            <div class="number"><?php  echo $wqInfo['credit1'];?></div>
        </div>
    </div>
    <a href="<?php  echo $this->createMobileUrl('memberInfo')?>" class="m-account"></a>
</div>
<div class="weui-cells weui-cells-member">
    <a class="weui-cell weui-cell_access" href="<?php  echo $this->createMobileUrl('articles')?>">
        <div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/heart.png" class="ui-m-icon" alt=""></div>
        <div class="weui-cell__bd">
            <p>最新公告</p>
        </div>
        <div class="weui-cell__ft">查看</div>
    </a>
</div>
<div class="weui-cells weui-cells-member">
    <a class="weui-cell weui-cell_access" href="<?php  echo $this->createMobileUrl('category')?>">
        <div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/msgico.png" class="ui-m-icon" alt=""></div>
        <div class="weui-cell__bd">
            <p>最新消息</p>
        </div>
        <div class="weui-cell__ft">查看全部</div>
    </a>
    <div class="weui-cell weui-infos-cell">
        <div class="weui-flex__item">
            <a href="<?php  echo $this->createMobileUrl('category',array('id'=>0))?>" class="cell-infos">
                <div class="number"><?php  echo $msg['0'];?></div>
                <div class="sm-text"><?php  echo $lang['0'];?></div>
            </a>
        </div>
        <div class="weui-flex__item">
            <a href="<?php  echo $this->createMobileUrl('category',array('id'=>1))?>" class="cell-infos">
                <div class="number"><?php  echo $msg['1'];?></div>
                <div class="sm-text"><?php  echo $lang['1'];?></div>
            </a>
        </div>
        <div class="weui-flex__item">
            <a href="<?php  echo $this->createMobileUrl('category',array('id'=>2))?>" class="cell-infos">
                <div class="number"><?php  echo $msg['2'];?></div>
                <div class="sm-text"><?php  echo $lang['2'];?></div>
            </a>
        </div>
        <div class="weui-flex__item">
            <a href="<?php  echo $this->createMobileUrl('category',array('id'=>3))?>" class="cell-infos">
                <div class="number"><?php  echo $msg['3'];?></div>
                <div class="sm-text"><?php  echo $lang['3'];?></div>
            </a>
        </div>
    </div>
</div>
<div class="weui-cells weui-cells-member">
    <a class="weui-cell weui-cell_access" href="<?php  echo $this->createMobileUrl('memberInfo')?>">
        <div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/infoico.png" class="ui-m-icon" alt=""></div>
        <div class="weui-cell__bd">
            <p>个人信息</p>
        </div>
        <div class="weui-cell__ft">查看</div>
    </a>
</div>
<div class="weui-cells weui-cells-member">
    <?php  if($baseConfig['staff_in']==1) { ?>
    <a class="weui-cell weui-cell_access" href="<?php  echo $this->createMobileUrl('staffIn')?>">
        <div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/infoico.png" class="ui-m-icon" alt=""></div>
        <div class="weui-cell__bd">
            <p>员工入驻</p>
        </div>
        <div class="weui-cell__ft">立即注册</div>
    </a>
    <?php  } ?>
    <!--<a class="weui-cell weui-cell_access" href="javascript:;">-->
        <!--<div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/infoico.png" class="ui-m-icon" alt=""></div>-->
        <!--<div class="weui-cell__bd">-->
            <!--<p>自定义菜单</p>-->
        <!--</div>-->
        <!--<div class="weui-cell__ft">查看</div>-->
    <!--</a>-->
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
