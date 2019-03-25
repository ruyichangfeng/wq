<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body class="bga">
<div id="page0" class="ub ub-ver bga">
	
    <div class="ub-f1 ub ub-ac ub-pc ub-ver tx-c bga">
    	<div><i class="iconfont icon-iconfont44 t-gre1" style="font-size:5rem"></i> </div>
        <div class="umar-t1">审核中</div>
        <div class="uinn8 tx-l">&nbsp;&nbsp;&nbsp;&nbsp;本系统需要管理员审核用户信息后才能提交订单，请耐心等候管理员审核！</div>
        <div class="uinn8 ub">
            <a href="<?php  echo $this->createMobileUrl('Index',array())?>" class="uba b-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem"><span class="ulev0 t-gre1">返回首页</span></a>
        </div>
    </div>
    
    <div class="" style="height:3.125rem"></div>
    
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
    
</div>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
