<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="ubb ubb-blaimg ub ub tx-c top-tab">
    	<a href="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'index', 'id'=>$id))?>" class="ubr b-bla01 ub-f1 uinn t-gra block active">收入</a>
        <a href="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'chu', 'id'=>$id))?>" div class="ubr b-bla01 ub-f1 uinn t-gra block">支出</a>
        <a href="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'log', 'id'=>$id))?>" div class="ubr b-bla01 ub-f1 uinn t-gra block">充值</a>
    </div>

    <div class="ubb ubb-blaimg ub ub tx-c top-tab">
        <a href="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'index', 'id'=>$id))?>" class="ubr b-bla01 ub-f1 uinn t-gra block active">项目收入</a>
        <a href="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'merchantindex', 'id'=>$id))?>" div class="ubr b-bla01 ub-f1 uinn t-gra block">商铺收入</a>
    </div>

    <ul class="ub-f1 uinn8 c-wh">
    	<?php  if($list[0]['id'] == '') { ?>
        	<div>
                <ul style="padding:60px 30px 50px 30px">
                    <li style="text-align:center">
                        <div class="wks ub-img1"></div>
                    </li>
                    <li class="t-gra" style="text-align:center; margin-top:30px">暂无数据</li>
                </ul>
            </div>
        <?php  } else { ?>
        	<div class="tx-c vleu-3 t-gra">你的订单收入金额[现金支付除外]已存入到你的账户余额中.</div><br/>
        	<?php  if(is_array($list)) { foreach($list as $vo) { ?>
            <div class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem">
            	<table width="100%" border="0">
                  <tr>
                    <td class="uinn3">收入：<span class="t-gra">￥<?php  echo $vo['getMoney'];?></span></td>
                    <td class="uinn3">服务人员：<span class="t-gra"><?php  echo $this->getStaffInfo($vo['staff_id'],'staff_name')?> </span></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="uinn3">支付方式：
                    <span class="t-gra">
                    <?php  if($vo['type'] == 1) { ?>
                    	现金支付[不计入余额]
                    <?php  } ?>
                    <?php  if($vo['type'] == 2) { ?>
                    	微信支付
                    <?php  } ?>
                    <?php  if($vo['type'] == 3) { ?>
                    	余额支付
                    <?php  } ?>
                    </span>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="uinn3">收入时间：<span class="t-gra"><?php  echo $vo['addtime'];?></span></td>
                  </tr>
                </table>
            </div>
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
            <a href ="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order1', 'id'=>$id))?>" class="ub ub-pc block t-gre1 t-wh" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-dingdan ulev1"></i> 
                    <span class="block ulev-1" style="">订单</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'index', 'id'=>$id))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-licaishouyi ulev1 t-gre1"></i> 
                    <span class="block ulev-1 t-gre1" style="">财务</span>
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