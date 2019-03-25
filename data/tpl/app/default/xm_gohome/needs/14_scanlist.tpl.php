<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div class="ub ub-ver page bga" id="page0"> 
  <!--列表 star-->
  <div class="ub ub-ver ub-f1" >
    
    <div class="ub ub-f1 ub-ver  c-wh">
    <?php  if($list[0]['id'] == '' && $list1[0]['id'] == '') { ?>
    <div class="weui_msg">
       <div class="weui_icon_area"><i class="weui_icon_msg weui_icon_warn"></i></div>
       <div class="weui_text_area">
           <h2 class="weui_msg_title">暂无数据</h2>   
       </div>
    </div>
    <?php  } else { ?>
          <!--循环结束-->
          <ul class="fav_ul">
            <?php  if(is_array($list1)) { foreach($list1 as $vo1) { ?>
              <li class="uinn212 ubb b-bla01 ub-f1 ub ub-ac ub-pc">
                <a href="<?php  echo $this->createMobileUrl('takeout',array('foo'=>'page', 'id'=>$vo1['merchant_id']));?>" class="ub ub-f1 ub-ac ub-pc">
                  <?php  if($vo1['pic'] == '') { ?>
                    <div class="ub picbox ub-img1" style="background-image:url(<?php  echo $_W['MODULE_URL'];?>static/takeout/images/nopic.jpg)"></div>
                  <?php  } else { ?>
                    <?php  if(strstr($vo1['pic'],'images') == true) { ?>
                      <div class="ub picbox ub-img1" style="background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $vo1['pic'];?>)"></div>
                    <?php  } else { ?>
                      <div class="ub picbox ub-img1" style="background-image:url(<?php  echo $_W['attachurl'];?>gohome/currypic/<?php  echo $vo1['pic'];?>)"></div>
                    <?php  } ?>
                  <?php  } ?>
                  <div class="ub-f1 umar-l ub ub-ver" style="height:6rem">
                    <div class="ub-f1 ub ub-ac">
                      <div class="ub-f1 font-b"><?php  echo $vo1['curry_name'];?></div>
                      <div class="ub t-dgra ulev-4"><?php  echo $this->getMerchantInfo($vo1['merchant_id'], 'merchant_name')?></div>
                    </div>
                    <div class="ub-f1 line2stop t-line15 ulev-1 t-dgra uinn11 umar-t1" style="height:4rem"><?php  echo $vo1['remark'];?> </div>
                    <div class="ub-f1 ub ub-pc ub-ae umar-t1">
                      <div class="ub-f1"><font class="ulev2 t-blu2">￥<?php  echo $vo1['price'];?></font><span class="ulev-4 t-dgra"></span></div>
                      <div class="ub ulev-4 t-dgra">销量<font class="t-org"><?php  echo $vo1['allsum'];?></font>单</div>
                    </div>
                  </div>
                </a>
              </li>
            <?php  } } ?>          
          </ul>
    <?php  } ?>  
    </div>
    </div>
    <div style="height:3.5rem;"></div>

     <?php  if($list[0]['id'] =! '' || $list1[0]['id'] != '') { ?>
    <div class=" ub ub-f1 fixed c-wh ubt b-bla01 ub-fh ub-ac" style="bottom:0; left:0; z-index:999">
      <div class="ub ulev-1 uinn t-bla04">价格都不满意，怎么办？</div>
        <a href="<?php  echo $this->createMobileUrl('needs', array('foo'=>'index', 'id'=>$list1[0]['id']))?>" class="c-red1 uinn8 t-wh ub-f1 umar-l block tx-c">发起竞单</a>
    </div>
    <?php  } ?>
<!--列表end-->

 </div>
 <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
