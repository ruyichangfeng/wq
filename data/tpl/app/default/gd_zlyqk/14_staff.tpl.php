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
            <div class="ui-m-item"><?php  echo $adminInfo['name'];?></div>
            <div class="ui-m-item">[<?php  echo $dpInfo['name'];?>]</div>
        </div>
    </div>
    <div class="weui-flex__item">
        <div class="member-infos">
            <div class="text">积分</div>
            <div class="number"><?php  echo $wqInfo['credit1'];?></div>
        </div>
    </div>
    <a href="" class="m-account"></a>
</div>
<div class="weui-cells weui-cells-member">
    <a class="weui-cell weui-cell_access" href="<?php  echo $this->createMobileUrl('articles')?>">
        <div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/heart.png" class="ui-m-icon" alt=""></div>
        <div class="weui-cell__bd">
            <p>公告通知</p>
        </div>
        <div class="weui-cell__ft">查看</div>
    </a>
</div>
<div class="weui-cells weui-cells-member">
    <div class="work-wrap">
        <div class="work-cell-hd">
            <div class="work-cell">
                <div class="work-bd"><div class="wk-tit">我的工作台</div></div>
                <div class="work-end"><a href="<?php  echo $this->createMobileUrl('msg')?>">查看全部</a></div>
            </div>
        </div>
        <div class="work-cell-bd">
            <div class="work-cell">
                <div class="work-bd"><span class="eye-text">总数据单数</span></div>
            </div>
            <div class="work-lg-number">&nbsp;&nbsp;<?php  echo $total['0'];?></div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <div class="weui-flex flex-echart-info">
                    <span class="dot" style="background: #fba62e;"></span>
                    <span class="text">待接单</span>
                    <div class="weui-flex__item"><?php  echo $total['1'];?></div>
                </div>
                <div class="weui-flex flex-echart-info">
                    <span class="dot" style="background: #f26a55;"></span>
                    <span class="text">待处理</span>
                    <div class="weui-flex__item"><?php  echo $total['2'];?></div>
                </div>
                <div class="weui-flex flex-echart-info">
                    <span class="dot" style="background: #08ef0e;"></span>
                    <span class="text">流转中</span>
                    <div class="weui-flex__item"><?php  echo $total['3'];?></div>
                </div>
                <div class="weui-flex flex-echart-info">
                    <span class="dot" style="background: #029805;"></span>
                    <span class="text">已完成</span>
                    <div class="weui-flex__item"><?php  echo $total['4'];?></div>
                </div>
                <div class="weui-flex flex-echart-info">
                    <span class="dot" style="background: #f26c8c;"></span>
                    <span class="text">已终止</span>
                    <div class="weui-flex__item"><?php  echo $total['5'];?></div>
                </div>
                <div class="weui-flex flex-echart-info">
                    <span class="dot" style="background: #fa0740;"></span>
                    <span class="text">已撤销</span>
                    <div class="weui-flex__item"><?php  echo $total['6'];?></div>
                </div>
            </div>
            <div class="cell-chart" style="display: none">
                <img src="<?php echo MODULE_URL;?>/static/new/images/chart.jpg" alt="" />
            </div>
        </div>
    </div>
</div>
<div class="weui-cells weui-cells-member">
    <a class="weui-cell weui-cell_access" href="<?php  echo $this->createMobileUrl('memberInfo')?>">
        <div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/infoico.png" class="ui-m-icon" alt=""></div>
        <div class="weui-cell__bd">
            <p>基本信息</p>
        </div>
        <div class="weui-cell__ft">查看</div>
    </a>
</div>
<!--<div class="weui-cells weui-cells-member">-->
    <!--<a class="weui-cell weui-cell_access" href="javascript:;">-->
        <!--<div class="weui-cell__hd"><img src="<?php echo MODULE_URL;?>/static/new/images/icon/infoico.png" class="ui-m-icon" alt=""></div>-->
        <!--<div class="weui-cell__bd">-->
            <!--<p>员工信息</p>-->
        <!--</div>-->
        <!--<div class="weui-cell__ft">查看</div>-->
    <!--</a>-->
<!--</div>-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
