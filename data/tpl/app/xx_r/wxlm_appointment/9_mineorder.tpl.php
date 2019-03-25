<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <title><?php  echo $this->config['system_name']?></title>
    <link rel="stylesheet" href="<?php echo RES;?>mobile/css/dz_style.css">
</head>
<style>
.center-con01 .col-xs-8{
        position: relative;
}
.center-con01-a img{
    width: 24px;
    height: 24px;
    position: absolute;
    right:20px;
    top:20px;
}

    .dianzan img
    {
        width: 20px;
        height: 20px;
    }

</style>

<body>
<div class="box ">
    <div class="dz-filehead">
        <a href="<?php  echo $this->createMobileUrl('mine')?>"><img src="<?php echo RES;?>mobile/images/left-new.png" class="goback"></a>
        <?php  if($op == 'all') { ?>全部订单<?php  } else if($op == 'payok') { ?>已支付<?php  } else if($op == 'payno') { ?>待支付<?php  } else if($op == 'refund') { ?>待退款<?php  } else if($op == 'finish') { ?>已完成<?php  } ?>
    </div>
	<div class="cont" style="">
		<div class="center-con">
            <!--<div class="center-con02">-->
                <!--<div class="center-con02-b">-->
                	<!--<a class="center-con02-b01" href="<?php  echo $this->createMobileUrl('mine', array('op'=>'all'))?>">-->
                    	<!--<img src="<?php echo RES;?>mobile/images/btn01.png">-->
                        <!--<div class="center-text04">全部预约</div>-->
                    <!--</a>-->
                    <!--<a class="center-con02-b01" href="<?php  echo $this->createMobileUrl('mine', array('op'=>'payok'))?>">-->
                    	<!--<img src="<?php echo RES;?>mobile/images/btn02.png">-->
                        <!--<div class="center-text04">已支付</div>-->
                    <!--</a>-->
                    <!--<a class="center-con02-b01" href="<?php  echo $this->createMobileUrl('mine', array('op'=>'payno'))?>">-->
                    	<!--<img src="<?php echo RES;?>mobile/images/btn03.png">-->
                        <!--<div class="center-text04">待支付</div>-->
                    <!--</a>-->
                    <!--<a class="center-con02-b01" href="<?php  echo $this->createMobileUrl('mine', array('op'=>'refund'))?>">-->
                    	<!--<img src="<?php echo RES;?>mobile/images/btn04.png">-->
                        <!--<div class="center-text04">待退款</div>-->
                    <!--</a>-->
                    <!--<a class="center-con02-b01" href="<?php  echo $this->createMobileUrl('mine', array('op'=>'finish'))?>">-->
                    	<!--<img src="<?php echo RES;?>mobile/images/btn05.png">-->
                        <!--<div class="center-text04">已完成</div>-->
                    <!--</a>-->
                <!--</div>-->
            <!--</div>-->
            <?php  if(is_array($orders)) { foreach($orders as $key => $item) { ?>
            <div class="center-con03">
            	<div class="center-con03-t">
                	<div class="center-text05">订单编号：<?php  echo $item['order_number'];?></div>
                    <div class="center-text06"><?php  if($item['order_state'] == 1) { ?>待付款<?php  } else if($item['order_state'] == 2 && empty($item['orderrefund_id'])) { ?>已付款<?php  } else if($item['order_state'] == 2 && !empty($item['orderrefund_id'])) { ?>退款中<?php  } else if($item['order_state'] == 3) { ?>已完成<?php  } else if($item['order_state'] == 4) { ?>已关闭<?php  } ?></div>
                </div>
                <div class="center-con03-c">
                	<div class="col-xs-4">
                    	<img src="<?php  echo tomedia($item['store_pic'])?>" width="100%">
                        <!--<div><?php  echo $item['store_name'];?></div>-->
                    </div>
                    <div class="col-xs-8">
                    	<div class="center-text07"><?php  echo $item['project_name'];?> <?php  if($item['order_state'] == 3) { ?><div class="dianzan" style="float: right;">
                            <img   id="dianzan_1_<?php  echo $item['order_id'];?>"  onclick="dianZan('<?php  echo $item['order_id'];?>')" src="<?php echo RES;?>mobile/images/xin03.png" <?php  if($item['fabulous'] == 2) { ?>style="display: none" <?php  } ?> >
                            <img  id="dianzan_2_<?php  echo $item['order_id'];?>"   src="<?php echo RES;?>mobile/images/xin02.png" <?php  if($item['fabulous'] == 1) { ?>style="display: none" <?php  } ?>>
                        </div>
                            <?php  } ?></div>
                    	<div class="center-text08">下单时间：<?php  echo $item['order_time_add'];?></div>
                    </div>
                </div>
                <div class="center-con03-b">
                	<div class="center-con03-b01">
                        <?php  if($item['order_state'] == 1) { ?>
                        <a  class="btn btn-success" href="<?php  echo $this->createMobileUrl('pay', array('order_number'=>$item['order_number']))?>">立即支付</a>
                        <?php  } ?>
                        <?php  if($item['order_state'] < 3) { ?>
                        <a class="btn btn-default" href="tel://<?php  echo $item['store_tel'];?>">联系客服</a>
                        <?php  } ?>
                        <?php  if($item['order_state'] == 2 && $item['order_refund'] == 1 && empty($item['orderrefund_id'])) { ?>
                        <a class="btn btn-warning" href="<?php  echo $this->createMobileUrl('Refund', array('order_id'=>$item['order_id']))?>">申请退款</a>
                        <?php  } ?>
                        <?php  if($item['order_state'] == 3 && $item['order_scomment'] == 1) { ?>
                        <a class="btn btn-default" href="<?php  echo $this->createMobileUrl('StaffComment', array('op' => 'create',  'orderid' => $item['order_id'], 'staffid' => $item['order_staffid']))?>">评价服务</a>
                        <?php  } ?>
                        <?php  if($item['order_state'] < 4) { ?>
                        <a class="btn btn-primary" href="<?php  echo $this->createMobileUrl('orderInfo', array('order_id'=>$item['order_id']))?>">订单详情</a>
                        <?php  } ?>

                        <?php  if($item['order_state'] == 5) { ?>
                        <a class="btn btn-danger" href="<?php  echo $this->createMobileUrl('orderInfo', array('order_id'=>$item['order_id']))?>">失效订单</a>
                        <?php  } ?>
					</div>
                </div>
            </div>
            <?php  } } ?>
            <?php  if(!empty($page)) { ?>
            <div style="text-align:center">
                <?php  echo $page;?>
            </div>
            <?php  } ?>
        </div>
    </div>

</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
<script>
    function dianZan(id) {

        if (id == '')
        {
            return false;
        }

        $.ajax({

            url:"<?php  echo $this->createMobileUrl('dianZan')?>" + "&orderid=" + id,
            type:"get",
            success:function (data) {


                if (data == 1)
                {
                  $('#dianzan_1_'+id).css('display', 'none');
                  $('#dianzan_2_'+id).css('display', 'block');

                } else if (data == 3)
                {
                    alert('您已为其点赞, 不可重复点赞!')

                } else if (data == 2)
                {
                    alert('点赞失败, 请稍后再试');
                }
            }
        })
    }
</script>
</html>
