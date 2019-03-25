<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
</head>
<body>
<div id="page0" class="ub ub-ver bga">
	<input type="hidden" id="posturl" value="<?php  echo $posturl;?>">
	<input type="hidden" id="app" value="<?php  echo $app;?>">
    <input type="hidden" id="plat_name" value="<?php  echo $msgbase['plat_name'];?>">
    <input type="hidden" id="plat_pwd" value="<?php  echo $msgbase['plat_pwd'];?>">
    <input type="hidden" id="message2" value="<?php  echo $msgbase['message2'];?>">
    <input type="hidden" id="phone" value="<?php  echo $mobile;?>">
    <input type="hidden" id="c" value="<?php  echo $c;?>">
    <div class="ub-f1 ub ub-ac ub-pc ub-ver tx-c">
    	<div><i class="iconfont icon-kafei t-gre1" style="font-size:5rem"></i> </div>
        <div class="umar-t1 ulev2 t-gre1">抢单报价成功</div>
        <div class="umar-t t-gre1">请耐心等候用户选定</div>
        <div class="uinn8">
        	<a href ="<?php  echo $this->createMobileUrl('Validate', array())?>" class="uba b-gre1 t-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="">返回首页</a>
        </div>
        <!--<div class="uinn8 ub">
            <div class="uba b-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem"><span class="ulev-1 t-gre1">服务人员可能会电话联系您<br>请您保持电话畅通</span></div>
        </div>-->
    </div>
    
    <div class="" style="height:3.125rem"></div>
    <div id="footer" class="fix0 c-foot" style="width:100%; bottom:0; z-index:999">
        <div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('Validate', array())?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-shouye ulev1"></i> 
                    <span class="block ulev-1" style="">首页</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order1'))?>" class="ub ub-pc block t-gre1 t-wh" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-dingdan ulev1 t-gre1"></i> 
                    <span class="block ulev-1 t-gre1" style="">订单</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('Money', array())?>" class="ub ub-pc block" style="width:33.33%">
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
