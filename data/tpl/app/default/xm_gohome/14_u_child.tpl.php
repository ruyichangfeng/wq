<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
var pagename="index";
</script>
<style>
.hnav > div:nth-child(1n+1) .iconn{
	background-color:#8e5cd4;
}
.hnav > div:nth-child(2n+1) .iconn{
	background-color: #FF7C06;
}
.hnav > div:nth-child(3n+1) .iconn{
	background-color: #CC99CC;
}
.hnav > div:nth-child(4n+1) .iconn{
	background-color: #99CC33;
}
.hnav > div:nth-child(5n+1) .iconn{
	background-color: #F8976D;
}
.hnav > div .iconn img{
	opacity: .8;
}
.hnav > div{
	width:25%;
}


</style>
</head>
<body>

<div id="page0" class="ub ub-ver bga">
    <ul class="ub-f1 uinn">
    	<?php  if(is_array($list)) { foreach($list as $vo) { ?>
        <li class="ubb b-bla01" style="padding:0.75rem 0">
        	<a href="<?php  echo $this->createMobileUrl('templateok',array('foo'=>'index','id'=>$vo['id']))?>" class="ub ub-ac">
            	<div class="ub-img1" style="height:4rem; width:5rem; background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $vo['icon'];?>)"></div>
                <!--以下注释为调用分类小图标-->
                <div class="ub-f1 uinn">
                	<div class="t-bla"><?php  echo $vo['type_name'];?></div>
                    <div class="ulev-4 t-gra"><?php  echo $vo['jianshu'];?></div>
                </div>
                <div class="tx-r">
                	<div class="ulev2 t-gre1">
                    <?php  if($vo['price_unit'] > 0 ) { ?>
                    <span class="ulev-4">￥</span><?php  echo $vo['price_unit'];?>
                    <?php  } ?>
                    </div>
                    <?php  if($vo['unit'] != '') { ?>
                    <div class="t-gra ulev-4">/ <?php  echo $vo['unit'];?></div>
                    <?php  } ?>
                </div>
                <div style="padding-left:0.5rem"><i class="iconfont icon-xiangyou ulev1 t-gra"></i></div>
            </a>
        </li>
        <?php  } } ?>
    </ul>
   
    
    <div class="" style="height:3.125rem"></div>
    
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
