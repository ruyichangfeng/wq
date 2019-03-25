<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <title><?php  echo $this->config['system_name']?></title>
</head>


<body>
<div class="box">
    <div class="tops">
        <div class="col-xs-2 text01-l">
            <a href="javascript:" onclick="history.back(); ">
                <img src="<?php echo RES;?>mobile/images/back-white.png">
            </a>
        </div>
        <div class="col-xs-8 text01-c">会员卡</div>
    </div>
    <div class="cont-box">
    	<ul class="cont">
        	<li>
            	<div class="cont-t">
                	<div class="cont-image01">
                        <img src="<?php  echo tomedia($card['card_pic'])?>" width="100%">
                    </div>
                </div>
                <div class="cont-c">
                	<div class="cont-text01"><?php  echo $card['card_title'];?></div>
                </div>
                <div class="wz">
                	<div class="wz-l">
                    	<div class="wz-l-image">
                        	<img src="<?php echo RES;?>mobile/images/card-money.png">
                        </div>
                        <div class="wz-l-text"><span style="color: #E6726D;font-size: 16px"><?php  echo $card['card_price'];?></span>&nbsp;元</div>
                    </div>
                	<div class="wz-l clear-fix">
                    	<div class="wz-l-image01">
                        	<img src="<?php echo RES;?>mobile/images/card-jifen.png">
                        </div>
                        <div class="wz-l-text"><span style="color: #E6726D;font-size: 16px"><?php  echo $card['card_credit1'];?></span></div>
                        <div class="center-con03-b01">当前积分:<?php  echo $credit['credit1'];?></div>
                    </div>
                </div>
            </li>
            <div class="explore01_show-con01">
                <div class="explore01_show-con01-t">
                    <div class="explore01_show-con01-image01">
                        <img src="<?php echo RES;?>mobile/images/card.png">
                    </div>
                    <div class="explore01_show-con01-text01">会员卡详情</div>
                </div>
                <div style="padding: 10px">
                    <?php  echo $card['card_info'];?>
                </div>
            </div>
        </ul>
        <div class="explore01_show-con02">
            <?php  if($credit['credit1'] >= $card['card_credit1']) { ?>
            <a href="<?php  echo $this->createMobileUrl('card', array('card_id'=>$card['card_id'], 'op'=>'card_order'))?>">立即购买</a>
            <?php  } else { ?>
            <a style="background-color: grey" href="javascript:void (0)">积分不足</a>
            <?php  } ?>
        </div>
    </div>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>
