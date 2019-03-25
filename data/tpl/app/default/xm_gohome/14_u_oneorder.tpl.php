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
	      		抢单中
	      	</div>
	      	
	      	<?php  if($item['state'] == 0) { ?>
	      		<a href="#" onClick="del(<?php  echo $id;?>)" class="block"><span class="uc-a15 t-yel uba b-yel absolute ulev-4" style="right:1rem; top:1rem; padding:0.2rem 0.5rem;">取消订单</span></a>
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
    
    <ul class="uc-a15 c-wh ubt b-bla01">
    	<li class="uinn3 ubb-blaimg ub">
            <div class="tx-r uinn3 t-gra" style="width:4.5rem">联系人</div>
            <div class="ub-f1 uinn3">
               <?php  echo $item['fname'];?>
            </div>
        </li>
    </ul>

    <ul class="uc-a15 c-wh ubt b-bla01">
    	<li class="uinn3 ubb-blaimg ub">
            <div class="tx-r uinn3 t-gra" style="width:4.5rem">联系电话</div>
            <div class="ub-f1 uinn3">
               <?php  echo $item['fmobile'];?>
            </div>
        </li>
    </ul>

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
      		<div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba2 b-bla02 t-yel block" style="height:4rem; width:4rem; top:-1.125rem">
	      		<i class="iconfont icon-sheweihouxuanren ulev2 t-yel"></i> 
	            <span class="block ulev-1" style="">抢单中</span>
	        </div>
        </div>
      	
      	<a href ="<?php  echo $this->createMobileUrl('Myinfo',array())?>" class="ub ub-pc block" style="width:33.33%">
      		<div class="ub ub-ver ub-ac ub-pc"> <i class="iconfont icon-wode ulev1"></i>
      			<span class="block ulev-1">我的</span>
      		</div>
      	</a>
  	</div>
  </div>
  
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
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
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
