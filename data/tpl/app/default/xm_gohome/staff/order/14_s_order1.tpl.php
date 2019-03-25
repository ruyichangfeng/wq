<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <?php  if($merchant_state == 1) { ?>
    <div class="ubb ubb-blaimg ub ub tx-c top-tab">
        <a href="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order1', 'merchant_state'=>$merchant_state, 'id'=>$id))?>" class="ubr b-bla01 ub-f1 uinn t-gra block active">服务订单</a>
        <a href="<?php  echo $this->createMobileUrl('merchant', array('foo'=>'order', 'merchant_state'=>$merchant_state, 'id'=>$id))?>" div class="ubr b-bla01 ub-f1 uinn t-gra block">商铺订单</a>
    </div>
    <?php  } ?>

    <div class="ubb ubb-blaimg ub ub tx-c top-tab">
    	<a href="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order1', 'merchant_state'=>$merchant_state, 'id'=>$id))?>" class="ubr b-bla01 ub-f1 uinn t-gra block active">待抢单</a>
        <a href="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order2', 'merchant_state'=>$merchant_state, 'id'=>$id))?>" div class="ubr b-bla01 ub-f1 uinn t-gra block">已抢单</a>
        <a href="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order3', 'merchant_state'=>$merchant_state, 'id'=>$id))?>" class=" ub-f1 uinn t-gra block">成功单</a>
    </div>
    <ul class="ub-f1 uinn8 c-wh">
    	<?php  if($list[0]['id'] == '') { ?>
        	<div class="weui_msg">
                <div class="weui_icon_area">
                    <i class="weui_icon_msg weui_icon_warn"></i>
                </div>
                <div class="weui_text_area">
                    <h2 class="weui_msg_title">暂无数据</h2>
                </div>
            </div>
        <?php  } else { ?>
        	<?php  if(is_array($list)) { foreach($list as $vo) { ?>
                <a href="<?php  echo $this->createMobileUrl('grab',array('id'=>$vo['order_id'],'staff_id'=>$vo['staff_id']))?>" class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem 0">
                    <div class="uinn ub ub-ver ub-ac ub-pc tx-c">
                        <?php  if($this->getUserTitle($vo['order_id']) != '') { ?>
                        <span class="uinn4 c-org t-wh uc-a15 ulev-2 block-in"><?php  echo $this->getUserTitle($vo['order_id'])?></span>
                        <?php  } ?>
                        <div class="uc-a100 c-blu" style="height:2.5rem; width:2.5rem;" >
                            <?php  if($this->getTypeIcon($vo['serve_type']) == '') { ?>
                                <img src="<?php  echo $_W['siteroot'];?>addons/xm_gohome/static/images/nopic.png" style="height:2.5rem; width:2.5rem;" class="uc-a50">
                            <?php  } else { ?>
                                <img src="<?php  echo $_W['attachurl'];?><?php  echo $this->getTypeIcon($vo['serve_type']);?>" style="height:2.5rem; width:2.5rem;" class="uc-a50"> 
                            <?php  } ?>  
                        </div>
                        <div class="ulev-2 t-gre1 umar-t"><?php  echo $this->getServeType($vo['serve_type']);?></div>
                    </div>
                    <div class="ub-f1 ub ub-ver ubl ubr b-bla01" style=" padding:0.3rem 0.5rem">
                        <div class="ub ub-ac">
                            <div class="ulev-4 t-sbla">预计费用</div>
                            <div class="ub-f1 tx-r ulev-1 t-gre1">￥</div>
                            <div class="t-gre1"><span class=" ulev1"><?php  echo $this->getOrderGrab($vo['order_id'],'dealprice')?></span></div>
                        </div>
                        <div class="ubt ubb b-bla01" style="margin:0.3rem 0; padding:0.3rem 0">
                            <div class="ulev-4 t-sbla"><?php  echo $this->getOrderGrab($vo['order_id'],'ftime')?></div>
                        </div>
                        
                        <div class="ulev-4 t-gra">
                            <div><?php  echo substr($this->getOrderGrab($vo['order_id'],'fadr'),0,24)?>...</div>
                        </div>
                        
                        <?php  if($this->getStaffCompany($vo['staff_id']) == 1) { ?>
                        <div class="ulev-4 t-gra">
                            <div><?php  echo $this->getStaffInfo($vo['staff_id'],'staff_name')?></div>
                        </div>
                        <?php  } ?>
                    </div>
                    <div class="ub ub-ver ub-ac ub-pc uinn213 ">
                        <div class="uc-a100 c-gre1 ub ub-ac ub-pc" style="height:2rem;width:2rem;">
                            <i class="iconfont icon-iconfontdianeps ulev1 t-wh"></i>
                        </div>
                        <div class="ulev-4 t-gre1 umar-t"><?php  echo $diygrab;?></div>
                    </div>
                </a>
             <?php  } } ?>   
        <?php  } ?>
    </ul>
    <div class="" style="height:3.125rem"></div>
    <div id="footer" class="fix0 c-foot" style="width:100%; bottom:0; z-index:999">
        <div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('Validate', array())?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-shouye ulev1"></i> 
                    <span class="block ulev-1" style="">首页</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('Stafforder', array('merchant_state'=>$merchant_state))?>" class="ub ub-pc block t-gre1 t-wh" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-dingdan ulev1 t-gre1"></i> 
                    <span class="block ulev-1 t-gre1" style="">订单</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('Staffmoney', array('foo'=>'index', 'id'=>$id))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-licaishouyi ulev1"></i> 
                    <span class="block ulev-1" style="">财务</span>
                </div>
            </a>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">

</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
