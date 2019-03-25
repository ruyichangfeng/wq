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
        <div class="col-xs-8 text01-c">订单详情</div>
    </div>
	<div class="cont">
		<div class="order-con">
        	<ul class="order-con01">
        		<li>预约人：<span><?php  echo $order['order_username'];?></span></li>
        		<li>门店：<span><?php  echo $store['store_name'];?></span></li>
                <li>项目：<span><?php  echo $project['project_name'];?></span></li>
                <li>服务人员：<span><?php  echo $staff['staff_name'];?></span></li>
                <li>预约时间：<span><?php  echo $order['order_dating_day'];?> <?php  echo $order['order_dating_start'];?>-<?php  echo $order['order_dating_end'];?></span></li>
                <li>提交日期：<span><?php  echo $order['order_time_add'];?></span></li>
                <li>订单状态：<span><?php  if($order['order_state'] == 1) { ?>待付款<?php  } else if($order['order_state'] == 2) { ?>已付款<?php  } else if($order['order_state'] == 3) { ?>已完成<?php  } else if($order['order_state'] == 4) { ?>已关闭{else $order['order_state'] == 5}已失效<?php  } ?></span></li>
                <?php  if($order['order_state'] == 2) { ?>
                <div class="order-code">
                    <a href="<?php  echo $this->createMobileUrl('code', array('order_id'=>$order['order_id']))?>" class="order-info-code">
                        <img src="<?php echo RES;?>mobile/images/order-info-code.png" height="18px" alt="">
                        核销二维码
                    </a>

                </div>
                <?php  } ?>
        	</ul>
            <div class="order-con02">
        		<div class="order-con02-t">
                    <div class="order-text01">温馨提示</div>
                </div>
                <div class="order-con02-b">
                	<div class="order-text02"><?php  echo $this->config['system_remind']?></div>
                </div>
        	</div>
        </div>
    </div>
   <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('foot', TEMPLATE_INCLUDEPATH)) : (include template('foot', TEMPLATE_INCLUDEPATH));?>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>
