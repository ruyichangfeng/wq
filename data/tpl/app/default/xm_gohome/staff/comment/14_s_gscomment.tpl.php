<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
var pagename="orderlist";
</script>
</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="uba b-bla01 ub ub-ac umar-t umar-b c-wh">
     <div class="ub-f1 ubr b-bla01 uinn">好评：<span class="t-red"><?php  echo $item1['good'];?></span>次</div>
     <div class="ub-f1 ubr b-bla01 uinn">中评：<span class="t-blu"><?php  echo $item2['center'];?></span>次</div>
     <div class="ub-f1 uinn">差评：<span class="t-dgra"><?php  echo $item3['bad'];?></span>次</div>
    </div>
    <ul class="ub-f1 uinn8 c-wh connn">
    	<?php  if($list[0]['id'] == '') { ?>
        	<div> 
                <ul style="padding:60px 30px 50px 30px">
                    <li style="text-align:center">
                        <div class="wks ub-img1"></div>
                    </li>
                    <li class="t-gra" style="text-align:center; margin-top:30px">暂无评论</li>
                </ul>
            </div>
        <?php  } else { ?>
            <?php  if(is_array($list)) { foreach($list as $val) { ?>
            
            <div class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem 0">
                <div class="uinn ub ub-ver ub-ac ub-pc tx-c ddan1">
                    <div class="uc-a100 c-blu" style="height:2.5rem; width:2.5rem;" >    
                        <?php  if($this->getMemberInfo($val['openid'], 'avatar') == '' ) { ?>                    
                            <img src="<?php echo MODULE_URL;?>static/takeout/images/nopic.jpg" style="height:2.5rem; width:2.5rem;" class="uc-a50"> 
                        <?php  } else { ?>
                            <img src="<?php  echo $this->getMemberInfo($val['openid'], 'avatar')?>" style="height:2.5rem; width:2.5rem;" class="uc-a50"> 
                        <?php  } ?>
                    </div>
                    <div class="ulev-2 t-gre1 umar-t">
                        评论人:<br/>
                        <?php  echo $this->getMemberInfo($val['openid'], 'nickname')?>
                    </div>
                </div>
                <div class="ub-f1 ub ub-ver ubl ubr b-bla01" style=" padding:0.3rem 0.5rem">
                    
                    <div class="ub ub-ac">
                        <div class="ulev-4 t-sbla">
                        <?php  if($val['merchantid'] == '') { ?>
                            服务项目:<?php  echo $this->getServeName($val['order_id'])?>
                        <?php  } else { ?>
                            商铺名称:<?php  echo $this->getMerchantInfo($val['merchantid'], 'merchant_name')?>
                        <?php  } ?>
                        </div>
                        <div class="ub-f1 tx-r ulev-1 t-gre1"></div>
                        <div class="t-gre1"><span class=" ulev1"><?php  echo $val['xing'];?>星</span></div>
                    </div>
                    
                    <?php  if($val['merchantid'] == '') { ?>
                    <div class="ubt ubb b-bla01" style="margin:0.3rem 0; padding:0.3rem 0">
                    	<div class="ulev-4">员工姓名：<?php  echo $this->getStaffInfo($val['staff_id'],'staff_name')?></div>
                    </div>
                    <?php  } ?>
                    
                    <div class="ubb b-bla01" style="margin:0.3rem 0; padding:0.3rem 0">
                        <?php  if($val['comment'] == '') { ?>
                        	<div class="ulev-4 t-sbla">评论内容：什么都没写</div>
                        <?php  } else { ?>
                        	<div class="ulev-4 t-sbla">评论内容：<?php  echo $val['comment'];?></div>
                        <?php  } ?>
                    </div>
                    
                    <div class="ulev-4 t-gra">
                        <div>评论时间：<?php  echo $val['addtime'];?></div>
                    </div>
                </div>
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
                    <i class="iconfont icon-dingdan ulev1 t-gre1"></i> 
                    <span class="block ulev-1 t-gre1" style="">订单</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'index', 'id'=>$id))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-licaishouyi ulev1"></i> 
                    <span class="block ulev-1" style="">财务</span>
                </div>
            </a>
        </div>
    </div>
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>



<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>