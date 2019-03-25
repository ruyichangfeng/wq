<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/template/mobile/css/iconfont/iconfont.css">
</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <ul class="ub-f1 uinn8 c-wh">
        <a class="ubb b-bla01 c-wh uinn umar-b1 ub ub-ac ub-pc" href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'add'))?>">
            <div class="ub-f1"><i class="iconfont icon-jia umar-r"></i> 添加员工</div>
            <div class="ub"><i class="iconfont icon-xiangyou t-dgra"></i></div>
        </a>
    	
        <?php  if($list[0]['id'] == '') { ?>
        	<div class="weui_msg">
                <div class="weui_icon_area">
                    <i class="weui_icon_msg weui_icon_warn"></i>
                </div>
                <div class="weui_text_area">
                    <h2 class="weui_msg_title">暂无数据</h2>
                </div>
            </div>
            
            <!--<a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'add'))?>">添加员工</a>-->
        <?php  } else { ?>
        	<?php  if(is_array($list)) { foreach($list as $vo) { ?>
                <div class="uba b-bla01 uc-a15 ub ub-ac umar-b">
                    <div class="ub ub-ver ub-ac ub-pc tx-c uinn1">
                        <div class="uc-a100 c-blu" style="height:2rem; width:2rem;" >
                            <?php  if($vo['avatar'] == '') { ?>
                            <div class="uc-a100 ub-img1 c-check" style="width:2rem; height:2rem; background-image:url(<?php echo MODULE_URL;?>/template/mobile/images/icon-can.png);"></div>  
                            <?php  } else { ?>
                            	<?php  if(substr($vo['avatar'],0,6) == 'images') { ?>
                                <div class="uc-a100 ub-img1 c-check" style="width:2rem; height:2rem; background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $vo['avatar'];?>);"></div>
                                <?php  } else { ?>
                                <div class="uc-a100 ub-img1" style="background-image:url(<?php  echo $_W['attachurl'];?>/gohome/avatar/<?php  echo $vo['avatar'];?>); height:2rem; width:2rem;" ></div>
                                <?php  } ?>
                            <?php  } ?>
                        </div>
                        <div class="ulev-2 t-gre1 umar-t"><?php  echo $vo['staff_name'];?></div>
                    </div>
                    <div class="ub-f1 ub ub-ver ubl b-bla01 ubr" style="padding:0.3rem 0">
                        <div class="ub ub-ac ubb b-bla01 ub-f1 uinn1">
                            <div class="ulev-4 t-sbla">电话号码</div>
                            <div class="ub-f1 tx-r ulev-1 t-gre1"></div>
                            <div class="t-gre1"><span class=" ulev0"><?php  echo $vo['staff_mobile'];?></span></div>
                        </div>
                        <div class="ubb b-bla01" style="margin:0.3rem 0; padding:0.3rem 0.5rem">
                            <div class="ulev-4 t-sbla">年龄:<?php  echo $vo['age'];?>岁&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;工龄:<?php  echo $vo['year'];?>个月</div>
                        </div>
                        
                        <div class="ubb b-bla01" style="margin:0.3rem 0; padding:0.3rem 0.5rem">
                            <div class="ulev-4 t-sbla">好评:<?php  echo $vo['good'];?>&nbsp;&nbsp;&nbsp;&nbsp;中评<?php  echo $vo['center'];?>&nbsp;&nbsp;&nbsp;&nbsp;差评:<?php  echo $vo['bad'];?></div>
                        </div>
                        
                        <div class="ulev-4 t-gra uinn1">
                            <div>认证证件：<?php  echo $vo['card_all'];?></div>
                        </div>
                        
                    </div>
                    <div class="ub ub-ver ub-ac ub-pc uinn213">
                        <a href="<?php  echo $this->createMobileUrl('staffedit',array('foo'=>'info', 'staff_id'=>$vo['id']))?>">
                        	<div class="ulev-4 t-org umar-t">修改信息</div>
                        </a>
                        <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'cardlist','id'=>$vo['id']))?>">
                        	<div class="ulev-4 t-gre1 umar-t">证件添加</div>
                        </a>
                        <a href="<?php  echo $this->createMobileUrl('falist',array('id'=>$vo['id']))?>">
                        	<div class="ulev-4 t-blu2 umar-t">工资流水</div>
                        </a>
                        <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'delete','id'=>$vo['id']))?>" onClick="return confirm('确认删除该员工?');">
                        	<div class="ulev-4 t-dgra umar-t">删除员工</div>
                        </a>
                        <!--
                        <a href="<?php  echo $this->createMobileUrl('delstaff',array('id'=>$vo['id']))?>">
                        	<div class="ulev-4 t-gre1 umar-t">移除公司</div>
                        </a>
                        -->
                    </div>
                </div>
             <?php  } } ?>   
        <?php  } ?>
    </ul>
    
    <div class="" style="height:3.125rem"></div>
    <div id="footer" class="fix0 c-foot" style="width:100%; bottom:0; z-index:999">
        <div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('Validate', array())?>" class="ub ub-pc block t-gre1" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-shouye ulev1 t-gre1"></i> 
                    <span class="block ulev-1 t-gre1" style="">首页</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order1', 'id'=>$id))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-dingdan ulev1"></i> 
                    <span class="block ulev-1" style="">订单</span>
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

<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/jquery_min.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/main.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/mobile/js/baidutemp.js"></script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
