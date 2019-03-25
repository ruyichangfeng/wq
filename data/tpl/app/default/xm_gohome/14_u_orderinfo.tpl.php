<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<style>
img {
	vertical-align: middle;
}
#QuacorGrading input {
	background: url('<?php echo MODULE_URL;?>static/images/grading.png') no-repeat scroll right center;
	cursor: pointer;
	height: 30px;
	width: 30px;
	padding: 0;
	border: 0;
}
#QuacorGrading1 input {
	background: url('<?php echo MODULE_URL;?>static/images/grading.png') no-repeat scroll right center;
	cursor: pointer;
	height: 30px;
	width: 30px;
	padding: 0;
	border: 0;
}
</style>
<body>

<div class="ub ub-ver bga page" id="page0">
  <div class="ub c-red1 ub-ver ub-ac ub-pc ub-img1" style=" padding:0 0rem 1rem 0; background-image:url(<?php echo MODULE_URL;?>static/images/u-center-bg.jpg) ">
	    <div class="bid_header">
	    	<div class="uc-a15 t-yel uba b-yel absolute ulev-4" style="left:1rem; top:1rem; padding:0.2rem 0.5rem;">
	      		<?php  if($item['mode'] == 0) { ?>
	      			<?php  if($item['state'] == 0) { ?>待派单<?php  } ?>
	        		<?php  if($item['state'] == 1) { ?>服务中<?php  } ?>
	        		<?php  if($item['state'] == 2) { ?>已完工<?php  } ?>
	      		<?php  } else { ?>
	      			<?php  if($item['state'] == 1) { ?>服务中<?php  } ?>
	        		<?php  if($item['state'] == 2) { ?>已完工<?php  } ?>
	      		<?php  } ?>
	      	</div>
	      	
	      	<?php  if($item['state'] == 0) { ?>
	      		<a href="#" onClick="del(<?php  echo $id;?>)" class="block"><span class="uc-a15 t-yel uba b-yel absolute ulev-4" style="right:1rem; top:1rem; padding:0.2rem 0.5rem;">取消订单</span></a>
	      	<?php  } ?>
	      	<?php  if($item['state'] == 2) { ?>
	      		<a href="#" onClick="delOrder(<?php  echo $id;?>)" class="block"><span class="uc-a15 t-yel uba b-yel absolute ulev-4" style="right:1rem; top:1rem; padding:0.2rem 0.5rem;">删除订单</span></a>
	      	<?php  } ?>
	    </div>
    
	    <div class="ub ub-ac ub-pc" style="margin-top:2rem">
	    	<?php  if($this->getTypeIcon($item['serve_type']) != '') { ?>
	        	<img src="<?php  echo $_W['attachurl'];?><?php  echo $this->getTypeIcon($item['serve_type']);?>" class=" uc-a50 ub-img1 rod-imgbox4 uba2 b-wh50">
	        <?php  } else { ?>	
	        	<img src="<?php  echo $_W['siteroot'];?>addons/xm_gohome/static/images/nopic.png" class=" uc-a50 ub-img1 rod-imgbox4 uba2 b-wh50">
	        <?php  } ?>
	    </div>
    
    	<div class="umar-t ulev1 t-yel font-b"><?php  echo $this->getServeType($item['serve_type']);?></div>
  </div>
  
  <div class="c-red1 ubt b-bla01">
  	<div class="ub ub-ac uinn11 bid_header">
  		<div class="tx-c" style="width:49.9%">
        	<div class="ulev-4 t-wh80">上门时间</div>
        	<div class="t-yel"><span class="ulev-1"><?php  echo $this->getOrderTime($item['table_name'],$item['other_id'],'ftime')?></span><span class="ulev1"></span></div>
      	</div>
      	<div class="ubl b-bla01 tx-c" style="width:49.9%">
        	<div class="ulev-4 t-wh80">预计费用</div>
        	<div class="t-yel"><span class="ulev-1">￥</span><span class="ulev1"><?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'dealprice')?></span></div>
      	</div>
    </div>
  </div>
  
  <div class="ub-f1 bid_body">
  	<div class="umar-b c-wh ub uinn11 ubb b-bla01">
  		<div class="ub-f1 tx-c ulev-4">
        	<div class="t-gra">已预约</div>
        	<div class="ub ub-ac" style="padding:0.2rem 0">
          		<div class="ub-f1"></div>
          		<div class="uc-a50 uba2 b-bla02">
            		<div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
          		</div>
          		<div class="ub-f1 ubb b-gra"></div>
        	</div>
        	<div class="t-gra"><?php  echo substr($this->getOrderTime($item['table_name'],$item['other_id'],'addtime'),0,11)?></div>
      	</div>
      	
      	<?php  if($item['mode'] == 1) { ?>
	      	<div class="ub-f1 tx-c ulev-4">
	        	<div class="t-gra">竞单中</div>
	        	<div class="ub ub-ac" style="padding:0.2rem 0">
	          		<div class="ub-f1 ubb b-gra"></div>
	          		<div class="uc-a50 uba2 b-bla02">
	            		<div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
	          		</div>
	          		<div class="ub-f1 ubb b-gra"></div>
	        	</div>
	        	<div class="t-gra"><?php  echo substr($this->getGrabInfo($item['id'],'addtime'),5,11)?></div>
	      	</div>
	      	<div class="ub-f1 tx-c ulev-4">
	        	<div class="t-gra">选定人</div>
	        	<div class="ub ub-ac" style="padding:0.2rem 0">
	          		<div class="ub-f1 ubb b-gra"></div>
	          		<div class="uc-a50 uba2 b-bla02">
	            		<div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
	          		</div>
	          		<div class="ub-f1 ubb b-gra"></div>
	        	</div>
	        	<div class="t-gra"><?php  echo substr($this->getGrabInfo($item['id'],'selectedtime'),5,11)?></div>
	      	</div>
      	<?php  } else { ?>
	      	<div class="ub-f1 tx-c ulev-4">
	        	<div class="t-gra">待派单</div>
	        	<div class="ub ub-ac" style="padding:0.2rem 0">
	          		<div class="ub-f1 ubb b-gra"></div>
	          		<div class="uc-a50 uba2 b-bla02">
	            		<div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
	          		</div>
	          		<div class="ub-f1 ubb b-gra"></div>
	        	</div>
	        	<div class="t-gra"><?php  echo substr($this->getOrderTime($item['table_name'],$item['other_id'],'addtime'),0,11)?></div>
	      	</div>
	      	<div class="ub-f1 tx-c ulev-4">
	        	<div class="t-gra">已派单</div>
	        	<div class="ub ub-ac" style="padding:0.2rem 0">
	          		<div class="ub-f1 ubb b-gra"></div>
	          		<div class="uc-a50 uba2 b-bla02">
	            		<div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
	          		</div>
	          		<div class="ub-f1 ubb b-gra"></div>
	        	</div>
	        	<div class="t-gra"><?php  echo substr($this->getGrabInfo($item['id'],'selectedtime'),5,11)?></div>
	      	</div>
      	<?php  } ?>
      	
      	<div class="ub-f1 tx-c ulev-4">
        	<div class="t-gra">服务中</div>
        	<div class="ub ub-ac" style="padding:0.2rem 0">
          		<div class="ub-f1 ubb b-gra"></div>
          		<div class="uc-a50 uba2 b-bla02">
            		<div class="uc-a50 <?php  if($item['state'] == 1) { ?> c-gre1 <?php  } else { ?> c-gra <?php  } ?>" style="height:0.5rem; width:0.5rem;"></div>
          		</div>
          		<div class="ub-f1 ubb b-gra"></div>
        	</div>
        	<?php  if($item['mode'] == 0 && $item['state'] == 0) { ?>
        	<?php  } else { ?>
        		<div class="t-gra"><?php  echo substr($this->getOrderTime($item['table_name'],$item['other_id'],'ftime'),0,11)?></div>
        	<?php  } ?>	
      	</div>
      	
	    <div class="ub-f1 tx-c ulev-4">
	        <div class="t-gra">已完工</div>
	        <div class="ub ub-ac" style="padding:0.2rem 0">
	          	<div class="ub-f1 ubb b-gra"></div>
	          	<div class="uc-a50 uba2 b-bla02">
	            	<div class="uc-a50 <?php  if($item['state'] == 2) { ?> c-gre1 <?php  } else { ?> c-gra <?php  } ?>" style="height:0.5rem; width:0.5rem;"></div>
	          	</div>
	          	<div class="ub-f1"></div>
	        </div>
	        <div class="t-gra"><?php  echo substr($this->getOrderOver($item['id'],'overtime'),5,11)?></div>
	    </div>
    </div>
    
    <ul class="uc-a15 c-wh ubt b-bla01">
    	<?php  if(is_array($list)) { foreach($list as $vo) { ?>
            <li class="uinn3 ubb-blaimg ub">
                <div class="tx-r uinn3 t-gra" style="width:4.5rem">
                <?php  if($vo['input_type'] == 'radio' || $vo['input_type'] == 'checkbox' || $vo['input_type'] == 'select') { ?>
                	<?php  if($this->getOrderInfoValue($item['table_name'],$item['other_id'],''.$vo[input_name].'',$item['temp_id']) != '') { ?>
                		<?php  echo $vo['input_laber'];?>
                	<?php  } ?>
                <?php  } else { ?>
                	<?php  if($this->getOrderInfo($item['table_name'],$item['other_id'],''.$vo[input_name].'') != '') { ?>
                		<?php  echo $vo['input_laber'];?>
                	<?php  } ?>
                <?php  } ?>
                </div>
                
                <div class="ub-f1 uinn3">
                <?php  if($vo['input_type'] == 'radio' || $vo['input_type'] == 'checkbox' || $vo['input_type'] == 'select') { ?>
                	<?php  echo $this->getOrderInfoValue($item['table_name'],$item['other_id'],''.$vo[input_name].'',$item['temp_id'])?>
                <?php  } else { ?>
                	<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],''.$vo[input_name].'')?>
                <?php  } ?>
                </div>
            </li>
        <?php  } } ?>
    </ul>
    
    <?php  if($listpic['0']['pic'] != '') { ?>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
            
                <?php  if(is_array($listpic)) { foreach($listpic as $vopic) { ?>
                <div class="ub ub-ver ub-ac block"  style="padding:0.5rem 0.5rem 0.3rem 0.5rem">
                	<div onClick="showpic('<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $vopic['pic'];?>')" class="uc-a1 c-blu ub ub-ac ub-pc iconn ub-img1 hide" style=" width:3rem; height:3rem; background-image:url(<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $vopic['pic'];?>)">
                    </div>
                </div>
                <?php  } } ?>
                
                <?php  $img = ''?>
                <?php  if(is_array($listpic)) { foreach($listpic as $row) { ?>
                <?php  $img .= "'".$_W['attachurl']."gohome/pic/".$row['pic']."',"?>
                <?php  } } ?>
                <script type="text/javascript">
                function showpic(a){
					wx.previewImage({
                      current: a,
                      urls: [<?php  echo $img;?>]
                    });
                }
                </script> 
        </ul>
    <?php  } ?>
    
    <?php  if($item['mode'] == 0 && $item['state'] == 0 ) { ?>
    
    <?php  } else { ?>
	    <ul class="userlist c-wh umar-t ubb ubt b-bla01">
	      <li class="ub ub-ac">
	        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra">接单报价</div>
	        <div class="ub ub-f1 ub-ac ubl b-bla01 uinn">
	          <div>￥</div>
	          <div class="ub ulev1 ub-f1 t-org">
	          	<input type="tel" name="offer" placeholder="" value="<?php  echo $item_g['offer'];?>"  id="" class="uinn ulev0 ub-f1 block t-gre1" readonly />
	          </div>
	        </div>
	      </li>
	    </ul>
	    
	    <?php  if($item_g['suremoney'] != '') { ?>
	    <ul class="userlist c-wh umar-t ubb ubt b-bla01">
	      <li class="ub ub-ac">
	        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra">成交价格</div>
	        <div class="ub ub-f1 ub-ac ubl b-bla01 uinn">
	          <div>￥</div>
	          <div class="ub ulev1 ub-f1 t-org">
	          	<input type="tel" placeholder="" value="<?php  echo $item_g['suremoney'];?>"  id="" class="uinn ulev0 ub-f1 block t-gre1" readonly />
	          </div>
	        </div>
	      </li>
	    </ul>
	    <?php  } ?>
	    
	    <?php  if($listimg['0']['pic'] != '') { ?>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
            	<div style="width:4rem; padding:0 1rem" class="tx-c t-gra">报价图片</div>
                <div class="ub-f1 ubl b-bla01 uinn">
	                <?php  if(is_array($listimg)) { foreach($listimg as $voimg) { ?>
	                <div class="ufl"  style="width:25%">
	                	<div onClick="showimg('<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $voimg['pic'];?>')" class="uc-a1 c-blu ub ub-ac ub-pc iconn ub-img1 hide" style=" width:3rem; height:3rem; background-image:url(<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $voimg['pic'];?>);margin:0.5rem 0.5rem 0.3rem 0.5rem; ">
	                    </div>
	                </div>
	                <?php  } } ?>
                </div>
                
                <?php  $img1 = ''?>
                <?php  if(is_array($listimg)) { foreach($listimg as $row) { ?>
                <?php  $img1 .= "'".$_W['attachurl']."gohome/pic/".$row['pic']."',"?>
                <?php  } } ?>
                <script type="text/javascript">
                function showimg(a){
					wx.previewImage({
                      current: a,
                      urls: [<?php  echo $img1;?>]
                    });
                }
                </script> 
        </ul>
    	<?php  } ?>
    	
    	<?php  if($item_g['remark'] != '') { ?>
	    <ul class="userlist c-wh umar-t ubb ubt b-bla01">
	      <li class="ub ub-ac">
	        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra">报价说明</div>
	        <div class="ub ub-f1 ub-ac ubl b-bla01 uinn">
	          <div class="ub ulev0 ub-f1 ">
	          	<textarea name="remark" id="remark" rows="3" class="uinn ulev-1 ub-f1 block uc-a15" style="width:6rem" readonly><?php  echo $item_g['remark'];?></textarea>
	          </div>
	        </div>
	      </li>
	    </ul>
	    <?php  } ?>
	    
	    <ul class="userlist c-wh umar-t ubb ubt b-bla01">
	      <li class="ub ub-ac">
	        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra">接单人员</div>
	        <div class="ub ub-ac ubl b-bla01 uinn">
	          <div class="ub ulev0 ub-f1 uinn11"><?php  echo $this->getStaffInfo($item['staff_id'],'staff_name')?></div>
	        </div>
	        <div class="ulev-4 t-gra ub-f1">
	        	<?php  if($this->getStaffInfo($item['staff_id'],'sex') == '1') { ?>先生<?php  } else { ?>女士<?php  } ?>
	        </div>
	        <div class="uinn"> <a href="javascript:void(0)" onClick="openPe2()" class="block uba b-gre1 t-gre1 uc-a15" style="padding:0.2rem 0.5rem">资料</a> </div>
	      </li>
	    </ul>
	    
	    <ul class="userlist c-wh uc-a15 umar-t ubb ubt b-bla01">
	      <li class="ub ub-ac">
	        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra">服务电话</div>
	        <div class="ub ub-f1 ub-ac ubl b-bla01 uinn">
	          <div class="ub ulev0 ub-f1 uinn11"><?php  echo $this->getStaffInfo($item['staff_id'],'staff_mobile')?></div>
	        </div>
	        <div class="uinn"> <a href="tel:<?php  echo $this->getStaffInfo($item['staff_id'],'staff_mobile')?>" class="block uba b-gre1 t-gre1 uc-a15" style="padding:0.2rem 0.5rem">呼叫</a> </div>
	      </li>
	    </ul>
	<?php  } ?>    
    
    <ul class="userlist c-wh uc-a15 umar-t ubb ubt b-bla01">
      <li class="ub ub-ac">
        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra">详细地址</div>
        <div class="ub ub-f1 ub-ac ubl b-bla01 uinn">
          <div class="ub ub-f1 uinn11"><?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fadr')?></div>
        </div>
        <!--
        <div class="" style="padding-right:0.5rem">
        	<a href="http://apis.map.qq.com/tools/routeplan/eword=<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fadr')?>&epointx=<?php  echo $item['lng'];?>&epointy=<?php  echo $item['lat'];?>&footdetail=2&navibutton=2&condfilterset=0?referer=o2o&key=DEZBZ-EQKKJ-CBFFB-K2SOD-GGNA3-N7BKM" class="uc-a1 block btnn t-gre1" style=""><i class="iconfont icon-dingwei ulev3"></i></a>
        </div>
        -->
        <div class="uinn">
        	<a href="http://map.baidu.com/mobile/webapp/place/linesearch/foo=bar/from=place&end=word=<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fadr')?>&uid=&tab=line" class="block uba b-gre1 ulev-4 t-gre1 uc-a15" style="padding:0.2rem 0.5rem">导航</a>
        </div>
     
      </li>
    </ul>
 
  </div>
  <div class="hbt"></div>
  
  <!--手机端底部-->
  <div id="footer" class="fixed c-foot" style="width:100%; bottom:0; z-index:999">
  	<div class="ub">
  		<a href ="<?php  echo $this->createMobileUrl('Order',array())?>" class="ub ub-pc block" style="width:33.33%">
      		<div class="ub ub-ver ub-ac ub-pc"> <i class="iconfont icon-dingdan ulev1"></i>
      			<span class="block ulev-1">订单</span> 
      		</div>
      	</a>
      	<div class="ub ub-pc block t-gre1 t-wh" style="width:33.33%">
      		<?php  if($item['mode'] == 0 && $item['state'] == 0) { ?>
	      		<div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba2 b-bla02 t-yel block" style="height:4rem; width:4rem; top:-1.125rem">
	      			<i class="iconfont icon-sheweihouxuanren ulev2 t-yel"></i> 
	                <span class="block ulev-1" style="">等待派单</span>
	            </div>
	      	<?php  } else { ?>
	      		<?php  if($item['state'] == 1) { ?>
	                <?php  if($this->getGrabInfo($item['id'],'suremoney') == '') { ?>
	                   	<div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba2 b-bla02 t-yel block" style="height:4rem; width:4rem; top:-1.125rem">
	                   		<i class="iconfont icon-sheweihouxuanren ulev2 t-yel"></i> 
	                        <span class="block ulev-1" style=""><?php  echo $diywait;?></span>
	                    </div>
	                <?php  } else { ?>
	                	<div onClick="openPe()" class="t-yel block ub ub-ver" style="top:-1.3rem;">
	                		<div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba03em b-bla99" style="height:4rem; width:4rem;">
			                    <i class="iconfont icon-duigou ulev1"></i> 
			                    <span class="block ulev-1" style=""><?php  echo $diypay;?></span>
			                </div>
			            </div>
	                <?php  } ?>
	            <?php  } ?>
	                
	            <?php  if($item['state'] == 2) { ?>
	                <?php  if($check['id'] == '') { ?>
		                <div onClick="openPe3()" class="t-yel block ub ub-ver" style=" top:-1.3rem">
		                    <div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba03em b-bla99" style="height:4rem; width:4rem;">
		                    	<i class="iconfont icon-wodepinglun ulev2"></i> 
		                    	<span class="block ulev-1" style="">点评</span>
		                    </div>
		                </div>
	            	<?php  } else { ?>
		            	<div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba2 b-bla02 t-yel block" style="height:4rem; width:4rem; top:-1.125rem">
		                    <i class="iconfont icon-wodepinglun ulev2"></i>
		                    <span class="block ulev-1" style="">已点评</span>
		                </div>
	            	<?php  } ?>
	            <?php  } ?>
        	<?php  } ?>
        </div>
      	
      	<a href ="<?php  echo $this->createMobileUrl('Myinfo',array())?>" class="ub ub-pc block" style="width:33.33%">
      		<div class="ub ub-ver ub-ac ub-pc"> <i class="iconfont icon-wode ulev1"></i>
      			<span class="block ulev-1">我的</span>
      		</div>
      	</a>
  	</div>
  </div>
  
  <!--支付弹出开始-->
  <div class="loginmask c-bla80">
  	<div class="ub ub-ac ub-pc mban" style="width:100%; height:100%;top:-800px">
      <div class="c-wh uc-a15 ub ub-ver mask_box">
        <div class="absolute c-wh uc-a100 uinn3" style="top:-2.1rem; left:50%; margin-left:-2.1rem; z-index:2">
          <div class="uc-a100 c-red1 t-yel tx-c" style="width:4rem; height:4rem;">
          	<i class="iconfont icon-duigou" style=" font-size:2rem; line-height:4rem;"></i>
          </div>
        </div>

        <div class=" bga uc-t15" style="padding-bottom:1rem;">
          <div class="ub" style="height:2.5rem">
            <div class="ub-f1"></div>
            <div class="closealert"  style="padding:0.3rem 0.5rem"><i class="iconfont icon-guanbi ulev2 t-gra"></i></div>
          </div>
          <div class="tx-c font-b">完工结算</div>
          <div class="ulev-4 t-gra tx-c ">确认支付后将会获得超值积分</div>
        </div> 
        
        <form action="<?php  echo $this->createMobileUrl('payok', array())?>" method="post">
            <input type="hidden" name="order_id" id="order_id" value="<?php  echo $item['id'];?>" />
			<input type="hidden" name="staff_id" id="staff_id" value="<?php  echo $item['staff_id'];?>" />
			<input type="hidden" name="serve_type" id="serve_type" value="<?php  echo $item['serve_type'];?>" />
        	
        	<div class="uinn8">
          		<div class="tx-c uinn3 ubb b-bla01 ulev-1 t-gra">请确认实际结算金额</div>
          		<ul class="userlist c-wh uc-a15">
		            <li class="ub ub-ac"> 
		              <div class="ub-f1"></div>
		              <div class="ub ub-f1 ub-ac uinn">
		                <div class="tx-r" style="">金额</div>
		                <div class="ub ulev0 ub-f1 uba b-gre1 uc-a15">
		                <?php  if($yu == 1) { ?>
		                	<input type="tel" name="money" id="money" placeholder="" value="0" class="uinn ulev2 ub-f1 block t-gre1 uc-a15" style="width:6rem"  readonly/>
		                <?php  } else { ?>
		                	<input type="tel" name="money" id="money" placeholder="成交价格" value="<?php  echo $suremoney;?>" class="uinn ulev2 ub-f1 block t-gre1 uc-a15" style="width:6rem"  readonly/>
		                <?php  } ?>
		                	<input type="hidden" name="endmoney" id="endmoney" value="<?php  echo $endmoney;?>"/>
		                </div>
		              </div>
		              <div class="ub-f1"></div>
		            </li>
		            
		            <li class="ub ub-ac">
		            	<div class="ub-f1"></div>
                        <div class="ub ub-f1 ub-ac uinn">
                            <div class="tx-r" style="">备注</div>
                            <div class="ub ulev0 ub-f1 uba b-gre1 uc-a15">
                            	<textarea name="remark" id="remark" rows="3" class="uinn ulev-1 ub-f1 block uc-a15" style="width:6rem">
                            		 <?php  if($yu == 1) { ?>
                            		 多余<?php  echo $yu_money;?>预付款将存入你的余额
                            		 <?php  } ?>
                            	</textarea>
                            </div>
                        </div>
                        <div class="ub-f1"></div>
                    </li>
		        </ul>
          		
          		<div>
            		<div class="tx-c uinn11 ubt b-bla01 ulev-1 umar-t t-gra">选择支付方式</div>
		            <div class="ub ub-pc">
		              <div class=" kk-check t-gra">
		                <?php  if($cash == 1) { ?>
		                	<input name="zf_type" type="radio" id="cc1" value="1" checked>
		                	<label class="block uinn uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="cc1">现金支付
		                		<i class="iconfont icon-iconfontgou ulev0 t-org"></i>
		                	</label>
		                <?php  } ?>

		                <input name="zf_type" type="radio" id="cc2" value="2">
		                <label class="block uinn uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="cc2">微信支付<i class="iconfont icon-iconfontgou ulev0 t-org"></i></label>
		                
		                <input name="zf_type" type="radio" id="cc3" value="3">
		                <label class="block uinn uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="cc3">余额支付<i class="iconfont icon-iconfontgou ulev0 t-org"></i></label>
		                <div class="clear"></div>
		              </div>
		            </div>
          		</div>
          		
          		<div class="uinn8 ub ub-f1 ub-pc tx-c">
          			<input name="submit" type="submit" value="确认支付" class="c-gre3 ub ub-pc uc-a1 ub-f1 btnn t-wh tx-c block" style="margin-bottom:0.5em; padding:0.75rem 6rem" />
          			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
          			<!--
          			<a href="./order-view.html" class="c-gre3 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem"><span class="t-wh">确认支付</span></a>
          			-->
          		</div>
        	</div>
        </form>	
      </div>
    </div>
  </div>
  <!--支付弹出结束-->
  
  <!--资料弹出开始-->
  <div class="loginmask2 c-bla80">
  	<div class="ub ub-ac ub-pc mban2" style="width:100%; height:100%;top:-800px">
  		<div class="c-wh uc-a15 ub ub-ver mask_box">
        	<div class="absolute c-wh uc-a100 uinn3" style="top:-2.1rem; left:50%; margin-left:-2.1rem; z-index:2">
          		<div class="c-check">
          			<?php  if($this->getStaffInfo($item['staff_id'],'avatar') != '') { ?>
          				<?php  if(strpos($this->getStaffInfo($item['staff_id'],"avatar"), 'images') !== false) { ?>
          					<img src="<?php  echo $_W['attachurl'];?><?php  echo $this->getStaffInfo($item['staff_id'],'avatar');?>" style="width: 4rem; height: 4rem;" class=" imgbox rod-imgbox2 ub-img1 uc-a100 ubb b-bla01 " />
	                	<?php  } else { ?>
	                		<img src="<?php  echo $_W['attachurl'];?>gohome/avatar/<?php  echo $this->getStaffInfo($item['staff_id'],'avatar')?>" style="width: 4rem; height: 4rem;" class=" imgbox rod-imgbox2 ub-img1 uc-a100 ubb b-bla01 " />
	                    <?php  } ?>
          			<?php  } ?>
          		</div>
        	</div>
        	
        	<div class=" bga uc-t15">
          		<div class="ub" style="height:2.5rem">
          			<div class="tx-c" style="padding:0.3rem 0.5rem">
            			<?php  if(strpos($this->getStaffInfo($item['staff_id'],'card_all'), '身份证') !== false) { ?>
            			<i class="iconfont icon-shimingrenzheng ulev3 t-red1"></i>
              			<div class="ulev-2 t-red1"><span>实名认证</span></div>
              			<?php  } ?>
            		</div>
            		<div class="ub-f1"></div>
            		<div class="closealert2"  style="padding:0.3rem 0.5rem">
            			<i class="iconfont icon-guanbi ulev2 t-gra"></i>
            		</div>
          		</div>
          		<div class="tx-c font-b"><?php  echo $this->getStaffInfo($item['staff_id'],'staff_name')?></div>
          		
          		<div class="tx-c" style="padding-bottom:0.5rem">
          			<?php  if($this->getStaffFen($item['staff_id']) == 1) { ?>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<?php  } ?>
          			<?php  if($this->getStaffFen($item['staff_id']) == 2) { ?>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<?php  } ?>
          			<?php  if($this->getStaffFen($item['staff_id']) == 3) { ?>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<?php  } ?>
          			<?php  if($this->getStaffFen($item['staff_id']) == 4) { ?>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<?php  } ?>
          			<?php  if($this->getStaffFen($item['staff_id']) == 5) { ?>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<i class="iconfont icon-wujiaoxing ulev0 t-org"></i>
          			<?php  } ?>
          		</div>
        	</div>
        	
        <div class="tx-c" style="padding:0 0.5rem">
          <div class="ubb b-bla01 ub"  style="padding: 0.5rem 0">
            <div class="ub-f1 ubr b-bla01">
              <div><?php  echo $this->getStaffInfo($item['staff_id'],'get_order')?></div>
              <div class="ulev-4">总接单</div>
            </div>
            <div class="ub-f1 ubr b-bla01">
              <div><?php  echo $this->getStaffInfo($item['staff_id'],'good')?></div>
              <div class="ulev-4">好评</div>
            </div>
            <div class="ub-f1 ubr b-bla01">
              <div><?php  echo $this->getStaffInfo($item['staff_id'],'center')?></div>
              <div class="ulev-4">中评</div>
            </div>
            <div class="ub-f1">
              <div><?php  echo $this->getStaffInfo($item['staff_id'],'bad')?></div>
              <div class="ulev-4">差评</div>
            </div>
          </div>
        </div>
        
        <ul class="ulev-4 uinn t-gra" style="padding-top:0">
          	<li class="uinn3 ubb b-bla01 ub">
	            <div class="ub-f1 ub">
	              <div class="tx-r uinn3" style="width:4.5rem">年龄：</div>
	              <div class="ub-f1 uinn3"><?php  echo $this->getStaffInfo($item['staff_id'],'age')?>岁</div>
	            </div>
	            <div class="ub-f1 ub">
	              <div class="tx-r uinn3" style="">性别：</div>
	              <div class="ub-f1 uinn3">
	              	<?php  if($this->getStaffInfo($item['staff_id'],'sex')==1) { ?>男<?php  } else { ?>女<?php  } ?>
	              </div>
	            </div>
	            <div class="ub-f1 ub">
	              <div class="tx-r uinn3" style="">工龄：</div>
	              <div class="ub-f1 uinn3"><?php  echo $this->getStaffInfo($item['staff_id'],'year')?>个月</div>
	            </div>
          	</li>
          	
          	<li class="uinn3 ubb b-bla01 ub">
            	<div class="tx-r uinn3" style="width:4.5rem">服务项目：</div>
            	<div class="ub-f1 uinn3"><?php  echo $this->getStaffPro($item['staff_id'])?></div>
          	</li>
          
          	<?php  if($this->getStaffInfo($item['staff_id'],'grade_money') > 0) { ?>          
          	<li class="uinn3 ubb b-bla01 ub">
            	<div class="tx-r uinn3" style="width:4.5rem">服务保障：</div>

            	<div class="ub-f1 uinn3">已缴纳<?php  echo $this->getStaffInfo($item['staff_id'],'grade_money')?>元服务保证金</div>
          	</li>
          	<?php  } ?>
          	
          	<li class="uinn3 ubb b-bla01 ub">
            	<div class="tx-r uinn3" style="width:4.5rem">健康证明：</div>
            	<div class="ub-f1 uinn3">
            		<?php  if(strpos($this->getStaffInfo($item['staff_id'],'card_all'), '健康证') !== false) { ?>
            		已核验
            		<?php  } else { ?>
            		未核验
            		<?php  } ?>
            	</div>
          	</li>
          	
          	<li class="uinn3 ubb b-bla01 ub">
            	<div class="tx-r uinn3" style="width:4.5rem">所属公司：</div>
            	<div class="ub-f1 uinn3">
            		<?php  if($this->getStaffInfo($item['staff_id'],'company_name') == '') { ?>
            			无[个人]
            		<?php  } else { ?>
            			<?php  echo $this->getStaffInfo($item['staff_id'],'company_name') == ''?>
            		<?php  } ?>
            	</div>
          	</li>
        </ul>
        <div class="ub-f1"></div>
      </div>
    </div>
  </div>
  <!--资料弹出开始-->
  
  <!--点评弹出开始-->
  <div class="loginmask3 c-bla80">
    <div class="ub ub-ac ub-pc mban3" style="width:100%; height:100%;top:-800px">
      <form action="<?php  echo $this->createMobileUrl('payok', array('foo'=>'commentok'))?>" method="post" class="c-wh uc-a15 ub ub-ver block mask_box">
        <div class="absolute c-wh uc-a100 uinn3" style="top:-2.1rem; left:50%; margin-left:-2.1rem; z-index:2">
          <div class="uc-a100 c-gre1 t-yel tx-c" style="width:4rem; height:4rem;"> <i class="iconfont icon-wodepinglun" style=" font-size:2rem; line-height:4rem;"></i> </div>
        </div>
        <div class=" bga uc-t15" style="padding-bottom:1rem;">
          <div class="ub" style="height:2.5rem">
            <div class="ub-f1"></div>
            <div class="closealert3"  style="padding:0.3rem 0.5rem"><i class="iconfont icon-guanbi ulev2 t-gra"></i></div>
          </div>
          <div class="tx-c font-b">服务点评</div>
          <div class="ulev-4 t-gra tx-c ">请对本次服务给予评分</div>
        </div>
        <div class="uinn8"> 
          <!--<div class="tx-c uinn11 ubb b-bla01 ulev-1 t-gra">请对本次服务给予评分</div>-->
          <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac"> 
              <!--<div style="min-width:3rem; padding:0 1rem" class="tx-c t-gra ulev-1">我的报价</div>-->
              <div class="ub-f1"></div>
              <div class="uinn">
                <div class="ub ub-ac ub-pc">
                  <div class="t-org ulev3" id="QuacorGradingValue"><font>4</font></div>
                  <div>分</div>
                  <input type="hidden" name="xing" id="xing" value="" />
                  <input type="hidden" name="corder_id" id="corder_id" value="<?php  echo $item['id'];?>" />
				  <input type="hidden" name="cstaff_id" id="cstaff_id" value="<?php  echo $item['staff_id'];?>" />
                </div>
                <div class="tx-c" id="QuacorGrading">
                  <input name="1" type="button" />
                  <input name="2" type="button" />
                  <input name="3" type="button" />
                  <input name="4" type="button" />
                  <input name="5" type="button" />
                </div>
              </div>
              <div class="ub-f1"></div>
            </li>
          </ul>
          <div class="umar-t1"> 
            <!--<div class="tx-c uinn11 ubt b-bla01 ulev-1 umar-t t-gra">文字点评</div>-->
            <div class="ub ub-pc">
              <div class="ub ulev0 ub-f1 tx-c uba b-gra">
                <textarea name="comment" id="comment" rows="2" placeholder="请输入点评语" value="" class="uinn ulev0 ub-f1 block"></textarea>
              </div>
            </div>
          </div>
          <div class="uinn8 ub">
          	<input name="submit" type="submit" value="下一步" class="c-gre3 ub ub-pc uc-a1 ub-f1 btnn t-wh" style="margin-bottom:0.5em; padding:0.75rem 6rem"/>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />  
            <!--
            <button  onClick="goComment()" class="c-gre3 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem"><span class="t-wh ulev0">提交点评</span></button>
            -->
          </div>
        </div>
        <div class="ub-f1"></div>
      </form>
    </div>
  </div>
  <!--点评弹出结束-->
  
</div>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
$(".closealert").click(function() {
	 $(".mban").animate({top:'-800px'})
	 $(".loginmask").fadeOut(500);
});

function openPe(){
	$(".loginmask").fadeIn(500), $(".mban").animate({top:'0px'})
}

$(".closealert2").click(function() {
	 $(".mban2").animate({top:'-800px'})
	 $(".loginmask2").fadeOut(500);
});

function openPe2(){
	$(".loginmask2").fadeIn(500), $(".mban2").animate({top:'0px'})
}

$(".closealert3").click(function() {
	 $(".mban3").animate({top:'-800px'})
	 $(".loginmask3").fadeOut(500);
});

function openPe3(){
	$(".loginmask3").fadeIn(500), $(".mban3").animate({top:'0px'})
}
</script> 

<script type="text/javascript">
var GradList = document.getElementById("QuacorGrading").getElementsByTagName("input");
for(var di=0;di<parseInt(document.getElementById("QuacorGradingValue").getElementsByTagName("font")[0].innerHTML);di++){
	GradList[di].style.backgroundPosition = 'left center';
};

for(var i=0;i < GradList.length;i++){
	//GradList[i].onmouseover = function(){
	GradList[i].onclick = function(){
		for(var Qi=0;Qi<GradList.length;Qi++){
			GradList[Qi].style.backgroundPosition = 'right center';
		}
		for(var Qii=0;Qii<this.name;Qii++){
			GradList[Qii].style.backgroundPosition = 'left center';
		}
		document.getElementById("QuacorGradingValue").innerHTML = '<font>'+this.name+'</font>';
		document.getElementById("xing").value = this.name;
	}
};

function del(id){
	if(window.confirm('确定取消该订单？')){
		$.ajax({
			url: "<?php  echo $this->createMobileUrl('order', array('foo'=>'delorder'));?>",
			type:"POST",
			data:{'id':id},
			dataType:"json",
			success: function(res){
				if(res == "0"){
					alert('对不起,取消失败！请稍后再试');
				}else{
					window.location.href = "<?php  echo $this->createMobileUrl('order', array('foo'=>'index'))?>";
				}
			}
		});
    }else{
		return false;
	}
}

function delOrder(id){
	if(window.confirm('确定删除订单？')){
		$.ajax({
			url: "<?php  echo $this->createMobileUrl('order', array('foo'=>'delorder1'));?>",
			type:"POST",
			data:{'id':id},
			dataType:"json",
			success: function(res){
				if(res == "1"){
					window.location.href = "<?php  echo $this->createMobileUrl('order', array('foo'=>'index'))?>";
				}else{
					alert('对不起,删除订单失败！请稍后再试');
				}
			}
		});
    }else{
		return false;
	}
}

</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
