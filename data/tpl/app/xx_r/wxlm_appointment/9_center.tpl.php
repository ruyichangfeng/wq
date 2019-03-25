<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php  echo $this->config['system_name']?></title>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <link rel="stylesheet" href="<?php echo RES;?>mobile/css/dz_style.css">
</head>
<body style="background:#f3f3f3;">
        <div class="dz-center-head">
            <div class="dz-center-left">
                <img src="<?php  echo tomedia($archive['archive_avatar'])?>">
            </div>
            <div class="dz-center-right">
                <p><?php  echo $archive['archive_name'];?></p>
                <p><?php  echo $archive['archive_tel'];?></p>
            </div>
        </div>
        <div class="center-list">
            <a href="<?php  echo $this->createMobileUrl('mineOrder', array('op'=>'all'))?>">
                <li>
                    <div class="center-list-left">
                        <img src="<?php echo RES;?>mobile/images/qbdd.png">
                        全部预约
                    </div>
                    <div class="center-list-right">
                        查看全部订单
                        <img src="<?php echo RES;?>mobile/images/right.png">
                    </div>
                </li>
            </a>
            <ul class="dz-center-box">
                <a href="<?php  echo $this->createMobileUrl('mineOrder', array('op'=>'payok'))?>">
                    <li>
                        <img src="<?php echo RES;?>mobile/images/yzf.png">
                        <p>已预约</p>
                    </li>
                </a>
                <a href="<?php  echo $this->createMobileUrl('mineOrder', array('op'=>'payno'))?>">
                    <li>
                        <img src="<?php echo RES;?>mobile/images/dzf.png">
                        <p>待支付</p>
                    </li>
                </a>

                <a href="<?php  echo $this->createMobileUrl('mineOrder', array('op'=>'refund'))?>">
                        <li>
                            <img src="<?php echo RES;?>mobile/images/dtk.png">
                            <p>待退款</p>
                        </li>
                </a>
                <a href="<?php  echo $this->createMobileUrl('mineOrder', array('op'=>'finish'))?>">
                        <li>
                            <img src="<?php echo RES;?>mobile/images/ywc.png">
                            <p>已完成</p>
                        </li>
                </a>
                <div class="clear"></div>
            </ul>
            <a href="<?php  echo $this->createMobileUrl('collection')?>">
                    <li>
                        <div class="center-list-left">
                            <img src="<?php echo RES;?>mobile/images/xing01.png">
                            我的收藏
                        </div>
                        <div class="center-list-right">
                            查看全部收藏
                            <img src="<?php echo RES;?>mobile/images/right.png">
                        </div>
                    </li>
            </a>
            <a href="<?php  echo $this->createMobileUrl('mineScomment')?>">
                <li>
                    <div class="center-list-left">
                        <img src="<?php echo RES;?>mobile/images/wddp.png">
                        我的点评
                    </div>
                    <div class="center-list-right">
                        <img src="<?php echo RES;?>mobile/images/right.png">
                    </div>
                </li>
            </a>

        </div>
        <ul class="footer">
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
            <li class="<?php  if($this->config['show_state'] == 2) { ?>col-xs-4<?php  } else { ?>col-xs-6<?php  } ?> dq">
                <a href="<?php  echo $this->createMobileUrl('mine', array())?>">
                    <img src="<?php echo RES;?>mobile/images/icon002.png">
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
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>