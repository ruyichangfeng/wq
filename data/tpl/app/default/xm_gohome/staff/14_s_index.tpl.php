<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:1rem 0rem 3rem 0rem ">
        <?php  if($isCheck == 0) { ?>
        <div style="position:absolute; right:0.5rem; top:0.5rem; padding:0.2rem 0.5rem" class="uba b-wh uc-a15 ulev-4 t-wh"  data-toggle="modal" data-target="#myModal">加盟须知</div>
        <?php  } ?>

    	<?php  if($item['company_flag'] == 1) { ?>
        	<?php  if($item1['avatar'] == '') { ?>
                <div class="uc-a50 c-gra ub-img1 uba3 b-wh50" style="height:4em; width:4em; background-image:url(<?php echo MODULE_URL;?>static/takeout/images/nopic.jpg)"></div>
            <?php  } else { ?>
                <?php  if(strstr($item1['avatar'],'images')) { ?>
                <div class="uc-a50 c-gra ub-img1 uba3 b-wh50" style="height:4em; width:4em; background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $item1['avatar'];?>)"></div>
                <?php  } else { ?>
                <div class="uc-a100 c-gra ub-img1 uba3 b-wh50" style="background-image:url(<?php  echo $_W['attachurl'];?>gohome/avatar/<?php  echo $item1['avatar'];?>); height:4rem; width:4rem;" ></div>
                <?php  } ?>
            <?php  } ?>
        <?php  } else { ?>
        	<?php  if($item['avatar'] == '') { ?>
                <div class="uc-a50 c-gra ub-img1 uba3 b-wh50" style="height:4em; width:4em; background-image:url(<?php echo MODULE_URL;?>static/takeout/images/nopic.jpg)"></div>
            <?php  } else { ?>
                <?php  if(strstr($item['avatar'],'images')) { ?>
                <div class="uc-a50 c-gra ub-img1 uba3 b-wh50" style="height:4em; width:4em; background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $item['avatar'];?>)"></div>
                <?php  } else { ?>
                <div class="uc-a100 c-gra ub-img1 uba3 b-wh50" style="background-image:url(<?php  echo $_W['attachurl'];?>gohome/avatar/<?php  echo $item['avatar'];?>); height:4rem; width:4rem;" ></div>
                <?php  } ?>
            <?php  } ?>
        <?php  } ?>
        
        <?php  if($isCheck != 0) { ?>
            <?php  if($item['company_flag'] == 0) { ?>
                <div class="umar-t ulev1 t-yel"><?php  echo $item['staff_name'];?></div>
                <div class="ub-f1 ub ub-ac umar-t ub-pc ulev-2 t-yel">
                <div class="ub-f1">用户余额：<font class="t-wh font-b ulev-1"><?php  echo $item['money'];?></font>元&nbsp;&nbsp; [未结算<?php  echo $yucount;?>元&nbsp;&nbsp;充值<?php  echo $rcount;?>元]</div>
				<div class="ub-f1 umar-l1">保证金：<font class="t-wh font-b ulev-1"><?php  echo $item['grade_money'];?></font>元</div>
                </div>
            <?php  } else { ?>
                <div class="umar-t ulev1 t-yel ub-f1"><?php  echo $item1['company_name'];?></div>
                <div class="ub-f1 ub ub-ac umar-t ulev-2  ub-pc t-yel">
                <div class="ub-f1">用户余额：<font class="t-wh font-b ulev-4"><?php  echo $item1['money'];?></font>元&nbsp;&nbsp;[未结算<?php  echo $yucount;?>元&nbsp;&nbsp;充值<?php  echo $rcount;?>元]</div>
				<div class="ub-f1 umar-l1">保证金：<font class="t-wh font-b ulev-1"><?php  echo $item1['grade_money'];?></font>元</div>
                </div>
            <?php  } ?>
            	<!--
                <div class="umar-t ulev-4 t-yel">未结算金额：<?php  echo $yucount;?>元</div>
                -->
                <div class="ub-f1 ub ub-ac umar-t ulev-2 t-yel ub-pc">
                <div class="ub-f1">已结算未提现金额：<font class="t-wh font-b ulev-1"><?php  echo $weicount;?></font>元</div>
                <div class="ub-f1 umar-l1">累积单数：<font class="t-wh font-b ulev-1"><?php  echo $ordercount;?></font>单</div>
                <div class="ub-f1 umar-l1">今日收入：<font class="t-wh font-b ulev-1"><?php  echo $daycount;?></font>元</div>
                </div>
        <?php  } ?>
      
        <div class="absolute tx-c ulev-4 t-bla04 ubt b-bla01" style="left:0; bottom:0;width:100%; padding:0.5rem 0">管理中心</div>
    </div>

    <div class="ub-f1 hnav">
        <?php  if($isCheck == 0) { ?>
        	<a href="<?php  echo $this->createMobileUrl('auth',array('foo'=>'staffAuth'));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                <div class="ub ub-ac ub-pc ">
                    <i class="iconfont icon-65 ulev2 t-blu"></i> 
                </div>
                <div class="t-gra ub-f1 umar-l">绑定验证</div>
                <div class="ub"><i class="iconfont icon-xiangyou t-gra ulev-1"></i></div>
            </a>
        
        	<a href="<?php  echo $this->createMobileUrl('staffreg',array('foo'=>'staffReg'));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
            	<div class="ub ub-ac ub-pc">
                	<i class="iconfont icon-mubiaowancheng ulev2 t-org"></i> 
                </div>
                <div class="t-gra ub-f1 umar-l">个人加盟</div>
                <div class="ub"><i class="iconfont icon-xiangyou t-gra ulev1"></i></div>
            </a>
         
        	<a href="<?php  echo $this->createMobileUrl('staffreg',array('foo'=>'companyReg'));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
            	<div class="ub ub-ac ub-pc">
                	<i class="iconfont icon-mubiaowancheng ulev2 t-red1"></i> 
                </div>
                <div class="t-gra ub-f1 umar-l">公司加盟</div>
                <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
            </a>
        <?php  } ?>
        
        <?php  if($isCheck == 2) { ?>
                <div class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" >
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-mubiaowancheng ulev2 t-gre1"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">等待审核</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </div>
            
            <?php  if($item['company_flag'] == 1) { ?>
                <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'cardlist', 'id'=>$item1['id'], 'mark'=>1));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-dingdan ulev2 t-orgs"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">上传证件</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>
            <?php  } else { ?>
                <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'cardlist', 'id'=>$item['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-dingdan ulev2 t-orgs"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">上传证件</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>
            <?php  } ?>
        <?php  } ?>
            
        <?php  if($isCheck == 1) { ?>
            <?php  if($item['company_flag'] == 1) { ?>
                <a href="<?php  echo $this->createMobileUrl('Stafforder',array('foo'=>'order1', 'merchant_state'=>$item1['merchant_state'], 'id'=>$item1['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-dingdan ulev2 t-orgs"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">订单管理</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>

                <?php  if($item1['merchant_state'] == 1) { ?>
                    <a href="<?php  echo $this->createMobileUrl('staffneed',array('foo'=>'order1', 'merchant_state'=>$item1['merchant_state'], 'id'=>$item1['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-dingdan ulev2 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">竞价管理</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } ?>

                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-licaishouyi ulev2 t-red"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">财务管理</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>

                <div id="collapseThree" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staffmoney',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-sort ulev1 t-blu2"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">财务日志</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('tixian',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-dingzhipeisongyaoqiu ulev1 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">申请提现</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('tixian',array('foo'=>'list', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-news ulev0 t-orgs"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">提现日志</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>

                <?php  if($item1['stop'] == 1) { ?>
                    <a href="<?php  echo $this->createMobileUrl('gowork',array('openid'=>$item1['openid'], 'flag'=>0));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-gexinghuatuisong ulev2 t-dblu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">下班</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } else { ?>
                    <a href="<?php  echo $this->createMobileUrl('gowork',array('openid'=>$item1['openid'], 'flag'=>1));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-shijian ulev2 t-org"></i>
                        </div>
                        <div class="t-gra ub-f1 umar-l">上班</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } ?>

            <?php  } else { ?>
                <a href="<?php  echo $this->createMobileUrl('stafforder',array('foo'=>'order1', 'merchant_state'=>$item['merchant_state'], 'id'=>$item['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-dingdan ulev2 t-orgs"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">订单管理</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>

                <?php  if($item['merchant_state'] == 1) { ?>
                    <a href="<?php  echo $this->createMobileUrl('staffneed',array('foo'=>'order1', 'merchant_state'=>$item1['merchant_state'], 'id'=>$item1['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-dingdan ulev2 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">竞价管理</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } ?>

                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-licaishouyi ulev2 t-red"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">财务管理</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>
                <div id="collapseThree" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staffmoney',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-sort ulev1 t-blu2"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">财务日志</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('tixian',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-dingzhipeisongyaoqiu ulev1 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">申请提现</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('tixian',array('foo'=>'list', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-news ulev0 t-org"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">提现日志</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>
            <?php  } ?>

            <?php  if($item['company_flag'] == 1) { ?>
                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree1">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-shezhi ulev2 t-blu"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">系统充值</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>

                <div id="collapseThree1" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staffrecharge',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh ">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-licaishouyi ulev2 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">余额充值</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('baozheng',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-iconpay ulev2 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">保证金</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>

                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree5">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-xingzhengshixiangweihu ulev2 t-blu2"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">基础操作</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>

                <div id="collapseThree5" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staffedit', array('foo'=>'staffmobile', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-shouji1 ulev2 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">更换手机</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('staffedit', array('foo'=>'info', 'staff_id'=>$item1['id'], 'type'=>'company'));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-xuexishuben ulev1 t-org"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">修改信息</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('staffcomment',array('foo'=>'gscomment', 'openid'=>$item1['openid'], 'id'=>$item1['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-pinglun3 ulev2 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">评论查看</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('invite',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-rencaituandui ulev2 t-blu2"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">伙伴儿</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>    
                
                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree3">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-5 ulev2 t-orgs"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">员工管理</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>

                <div id="collapseThree3" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'manager', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-tuandui1 ulev1 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">员工列表</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                
                    <a href="<?php  echo $this->createMobileUrl('fa',array('id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-licaishouyi ulev1 t-orgs"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">发放工资</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                
                    <a href="<?php  echo $this->createMobileUrl('falist',array('id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-mubiaowancheng ulev1 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">工资流水</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>    
                
                <?php  if($item1['merchant_state'] == 0) { ?>
                    <a href="<?php  echo $this->createMobileUrl('staffreg', array('foo'=>'merchantReg','id'=>$item1['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-icon02 ulev2 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">商铺申请</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } else { ?>
                    <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree4">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-shouye1 ulev2 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">商铺管理</div>
                        <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                    </a>

                    <div id="collapseThree4" class="panel-collapse collapse ub-fh">
                        <a href="<?php  echo $this->createMobileUrl('menu', array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                            <div class="ub ub-ac ub-pc umar-l1">
                                <i class="iconfont icon-quanbu1 ulev1 t-blu2"></i> 
                            </div>
                            <div class="t-gra ub-f1 umar-l ulev-1">商品类别</div>
                            <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                        </a>

                        <a href="<?php  echo $this->createMobileUrl('curry',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                            <div class="ub ub-ac ub-pc umar-l1">
                                <i class="iconfont icon-liwu ulev1 t-org"></i> 
                            </div>
                            <div class="t-gra ub-f1 umar-l ulev-1">商品管理</div>
                            <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                        </a>

                        <a href="<?php  echo $this->createMobileUrl('activity',array('foo'=>'index', 'id'=>$item1['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                            <div class="ub ub-ac ub-pc umar-l1">
                                <i class="iconfont icon-wodedianyingpiao ulev1 t-red"></i> 
                            </div>
                            <div class="t-gra ub-f1 umar-l ulev-1">优惠折扣</div>
                            <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                        </a>
                    </div>
                <?php  } ?>

                <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'cardlist', 'id'=>$item1['id'], 'mark'=>1));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-card ulev2 t-blu"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">上传证件</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>

            <?php  } else { ?>

                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree11">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-shezhi ulev2 t-blu"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">系统充值</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>

                <div id="collapseThree11" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staffrecharge',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-licaishouyi ulev1 t-red"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">余额充值</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('baozheng',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-iconpay ulev1 t-blu2"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">保证金</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>

                <?php  if($item['stop'] == 1) { ?>
                    <a href="<?php  echo $this->createMobileUrl('gowork',array('openid'=>$item['openid'], 'flag'=>0));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-gexinghuatuisong ulev1 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">下班</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } else { ?>
                    <a href="<?php  echo $this->createMobileUrl('gowork',array('openid'=>$item['openid'], 'flag'=>1));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-shijian ulev1 t-blu2"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">上班</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } ?>
                
                <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree12">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-xingzhengshixiangweihu ulev2 t-blu2"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">基础操作</div>
                    <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                </a>

                <div id="collapseThree12" class="panel-collapse collapse ub-fh">
                    <a href="<?php  echo $this->createMobileUrl('staffedit', array('foo'=>'staffmobile', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-shouji1 ulev1 t-org"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">更换手机</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('staffedit', array('foo'=>'info', 'staff_id'=>$item['id'], 'flag'=>'1'));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-xuexishuben ulev1 t-blu2"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">修改信息</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('staffcomment',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-pinglun3 ulev1 t-org"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">评论查看</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>

                    <a href="<?php  echo $this->createMobileUrl('invite',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                        <div class="ub ub-ac ub-pc umar-l1">
                            <i class="iconfont icon-rencaituandui ulev1 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l ulev-1">伙伴儿</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                </div>    
                
                <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'project', 'id'=>$item['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-dianji ulev2 t-red"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">项目申请</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>

                <?php  if($item['merchant_state'] == 0) { ?>
                    <a href="<?php  echo $this->createMobileUrl('staffreg',array('foo'=>'merchantReg','id'=>$item['id']));?>" class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-icon02 ulev2 t-blu"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">商铺申请</div>
                        <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                    </a>
                <?php  } else { ?>
                    <a class="ub-f1 ubb ubt b-bla01 uinn block ub ub-ac c-wh umar-t" data-toggle="collapse" data-parent="#accordion"  href="#collapseThree13">
                        <div class="ub ub-ac ub-pc">
                            <i class="iconfont icon-shouye1 ulev2 t-org"></i> 
                        </div>
                        <div class="t-gra ub-f1 umar-l">商铺管理</div>
                        <div class="ub"><i class="iconfont icon-xiangxia t-dgra ulev1"></i></div>
                    </a>

                    <div id="collapseThree13" class="panel-collapse collapse ub-fh">
                        <a href="<?php  echo $this->createMobileUrl('menu',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                            <div class="ub ub-ac ub-pc umar-l1">
                                <i class="iconfont icon-quanbu1 ulev1 t-red"></i> 
                            </div>
                            <div class="t-gra ub-f1 umar-l ulev-1">商品类别</div>
                            <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                        </a>

                        <a href="<?php  echo $this->createMobileUrl('curry',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                            <div class="ub ub-ac ub-pc umar-l1">
                                <i class="iconfont icon-liwu ulev1 t-org"></i> 
                            </div>
                            <div class="t-gra ub-f1 umar-l ulev-1">商品管理</div>
                            <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                        </a>

                        <a href="<?php  echo $this->createMobileUrl('activity',array('foo'=>'index', 'id'=>$item['id']));?>" class="ub-f1 ubb b-bla01 uinn block ub ub-ac c-wh">
                            <div class="ub ub-ac ub-pc umar-l1">
                                <i class="iconfont icon-wodedianyingpiao ulev1 t-red"></i> 
                            </div>
                            <div class="t-gra ub-f1 umar-l ulev-1">优惠折扣</div>
                            <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                        </a>
                    </div>
                <?php  } ?>

                <a href="<?php  echo $this->createMobileUrl('staff',array('foo'=>'cardlist', 'id'=>$item['id']));?>" class="ub-f1 ubt b-bla01 uinn block ub ub-ac c-wh umar-t">
                    <div class="ub ub-ac ub-pc">
                        <i class="iconfont icon-card ulev2 t-blu"></i> 
                    </div>
                    <div class="t-gra ub-f1 umar-l">上传证件</div>
                    <div class="ub"><i class="iconfont icon-xiangyou t-dgra ulev1"></i></div>
                </a>
            <?php  } ?>
        <?php  } ?>
    </div>
    <!--弹出框--> 
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true" style="top:30%">
   <div class="modal-dialog">
      <div class="modal-content">    
       <?php  if($isCheck == 0) { ?>
      <div class="ubt b-bla01 uinn8 ulev-4 tx-c">如果你已被运营者添加，请输入你的手机号码及给你验证密码进行绑定验证</div>
      <div class="ubt b-bla01 uinn8 ulev-4 tx-c">如果你是个人用户，请进行个人加盟</div>
      <div class="ubt b-bla01 uinn8 ulev-4 tx-c">如果你是公司机构，请进行公司加盟</div>
    <?php  } ?>     
      </div><!-- /.modal-content -->
   </div><!-- /.modal -->
   </div>
    
    <div class="ubt b-bla01 uinn8 ulev-4 tx-c t-dgra"><?php  echo $this->banquan;?></div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
function yesAuth(){
	alert('员工身份已验证');
	return false;
}
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
