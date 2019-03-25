<?php defined('IN_IA') or exit('Access Denied');?><!--手机端底部-->
<div id="footer" class="fixed c-foot" style="width:100%; bottom:0; z-index:999">
    <div class="ub"> 
    	<a href ="<?php  echo $this->createMobileUrl('Index',array())?>" class="ub ub-pc block ufl">
    		<div class="ub ub-ver ub-ac ub-pc <?php  if($page == 'index') { ?> t-gre1 <?php  } ?>"><i class="iconfont icon-yuyue ulev1 "></i>
    			<span class="block ulev-1">
          <?php  if($this->getNav('nav1') == '') { ?>
            预约
          <?php  } else { ?>
            <?php  echo $this->getNav('nav1');?>
          <?php  } ?>
          </span>
    		</div>
    	</a> 
      	<a href ="<?php  echo $this->createMobileUrl('Catch',array())?>" class="ub ub-pc block ufl">
      		<div class="ub ub-ver ub-ac ub-pc <?php  if($page == 'catch') { ?> t-gre1 <?php  } ?>"> <i class="iconfont icon-comiisfaxian ulev1"></i>
      			<span class="block ulev-1">
            <?php  if($this->getNav('nav2') == '') { ?>
              发现
            <?php  } else { ?>
              <?php  echo $this->getNav('nav2');?>
            <?php  } ?>
            </span> 
      		</div>
      	</a> 
      	<a href ="<?php  echo $this->createMobileUrl('Order',array())?>" class="ub ub-pc block ufl">
      		<div class="ub ub-ver ub-ac ub-pc <?php  if($page == 'order') { ?> t-gre1 <?php  } ?>"> <i class="iconfont icon-dingdan ulev1"></i>
      			<span class="block ulev-1">
            <?php  if($this->getNav('nav3') == '') { ?>
              订单
            <?php  } else { ?>
              <?php  echo $this->getNav('nav3');?>
            <?php  } ?>
            </span>
      		</div>
      	</a> 
      	<a href ="<?php  echo $this->createMobileUrl('Myinfo',array())?>" class="ub ub-pc block ufl">
      		<div class="ub ub-ver ub-ac ub-pc <?php  if($page == 'my') { ?> t-gre1 <?php  } ?>"> <i class="iconfont icon-wode ulev1"></i>
      			<span class="block ulev-1">
            <?php  if($this->getNav('nav4') == '') { ?>
              我的
            <?php  } else { ?>
              <?php  echo $this->getNav('nav4');?>
            <?php  } ?>
            </span>
      		</div>
      	</a>
      	<div class="clear"></div>
    </div>
</div>
<!--手机端底部-->