<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
	<div class="ub ub-ver bga page" id="page0">
  
	<!--头部区域-->
	<?php  if($catch_bg == '') { ?>
	<div class="ub c-wh ub-ver ub-ac ub-pc ub-img1" style=" padding:0 0rem 1rem 0; background-image:url(<?php echo MODULE_URL;?>static/images/bus_bg.jpg) ">
	<?php  } else { ?>
	<div class="ub c-wh ub-ver ub-ac ub-pc ub-img1" style=" padding:0 0rem 1rem 0; background-image:url(<?php  echo $_W['attachurl'];?><?php  echo $catch_bg;?>) ">
	<?php  } ?>
	    <div class="bid_header">
	      <div class="uc-a15 t-yel absolute ulev-4" style="left:0.5rem; top:0.5rem;">
	      	<?php  if(strpos($item['card_all'], '身份证') !== false) { ?>
	      	<div class="tx-c" style="padding:0.3rem 0.5rem"> <i class="iconfont icon-shimingrenzheng ulev3"></i>
	              <div class="ulev-2"><span>实名认证</span></div>
	        </div>
	        <?php  } ?>
	      </div>
	      <div>
	      	
	      </div>
	      <!--
	      <a href="#" class="block"><span class="uc-a15 t-yel uba b-yel absolute ulev-4" style="right:1rem; top:8.5rem; padding:0.2rem 0.5rem;"> <i class="iconfont icon-shoucangweishoucang ulev-1"></i> <span class="ulev-4">收藏</span></span></a>
	      -->
	    </div>
	    
    	<div class="ub ub-ac ub-pc " style="margin-top:2rem">
    		<?php  if($item['avatar'] != '') { ?>
            	<?php  if(substr($item['avatar'],0,6) == 'images') { ?>
            		<img src="<?php  echo $_W['attachurl'];?><?php  echo $item['avatar'];?>" style="width: 5rem; height: 5rem;" class="imgbox ub-img1 rod-imgbox4 uba2 b-wh30 uc-a50">
                <?php  } else { ?>
                	<img src="<?php  echo $_W['attachurl'];?>gohome/avatar/<?php  echo $item['avatar'];?>" style="width: 5rem; height: 5rem;" class="imgbox ub-img1 rod-imgbox4 uba2 b-wh30 uc-a50">
                <?php  } ?>
            <?php  } ?>
    	</div>
    	<div class="umar-t ulev1 t-yel font-b"><?php  echo $item['staff_name'];?></div>
    	<div class="tx-c" style="padding-bottom:0.5rem">
    		<?php  if($this->getStaffFen($item['id']) == 1) { ?>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<?php  } ?>
    		<?php  if($this->getStaffFen($item['id']) == 2) { ?>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<?php  } ?>
    		<?php  if($this->getStaffFen($item['id']) == 3) { ?>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<?php  } ?>
    		<?php  if($this->getStaffFen($item['id']) == 4) { ?>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-dgra"></i>
    		<?php  } ?>
    		<?php  if($this->getStaffFen($item['id']) == 5) { ?>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<i class="iconfont icon-wujiaoxing ulev0 t-yel"></i>
    		<?php  } ?>
        </div>
  	</div>
  	<!--头部区域-->
  	
  	<div class="bid_body">
	  	<div class="tx-c c-gra1">
	          <div class="ubb b-bla01 ub"  style="padding: 0.5rem 0">
	            <div class="ub-f1 ubr b-bla01">
	              <div class="t-org"><?php  echo $item['get_order'];?></div>
	              <div class="ulev-4">总接单</div>
	            </div>
	            <div class="ub-f1 ubr b-bla01">
	              <div class="t-red1"><?php  echo $item['good'];?></div>
	              <div class="ulev-4">好评</div>
	            </div>
	            <div class="ub-f1 ubr b-bla01">
	              <div><?php  echo $item['center'];?></div>
	              <div class="ulev-4">中评</div>
	            </div>
	            <div class="ub-f1">
	              <div class="t-gra"><?php  echo $item['bad'];?></div>
	              <div class="ulev-4">差评</div>
	            </div>
	          </div>
	    </div>
	    
	    <ul class="ulev-4 uinn t-gra" style="padding-top:0">
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="ub-f1 ub">
	              <div class="tx-r uinn3" style="width:4.5rem">年龄：</div>
	              <div class="ub-f1 uinn3"><?php  echo $item['age'];?>岁</div>
	            </div>
	            <div class="ub-f1 ub">
	              <div class="tx-r uinn3" style="">性别：</div>
	              <div class="ub-f1 uinn3"><?php  if($item['sex'] == 1) { ?>男<?php  } else { ?>女<?php  } ?></div>
	            </div>
	            <div class="ub-f1 ub">
	              <div class="tx-r uinn3" style="">工龄：</div>
	              <div class="ub-f1 uinn3"><?php  echo $item['year'];?>个月</div>
	            </div>
	          </li>
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="tx-r uinn3" style="width:4.5rem">服务项目：</div>
	            <div class="ub-f1 uinn3"><?php  echo $this->getStaffPro($item['id'])?></div>
	          </li>
	          
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="tx-r uinn3" style="width:4.5rem">服务保障：</div>
	            <?php  if($item['company_name'] == '') { ?>
	            	<?php  if($item['grade_money'] > 0) { ?>
		            	<div class="ub-f1 uinn3"><?php  echo $this->getGradeInfo($item['grade_id'], 'grade_name')?>[已缴纳<?php  echo $item['grade_money'];?>元服务保证金]</div>
		          	<?php  } else { ?>
		          		<div class="ub-f1 uinn3">未缴纳服务保证金</div>
		          	<?php  } ?>
	            <?php  } else { ?>
	            	<?php  if($this->getGrade($item['company_name'],$item['openid'],'grade_money') > 0) { ?>
	            		<div class="ub-f1 uinn3">
	            			<?php  echo $this->getGradeInfo($this->getGrade($item['company_name'],$item['openid'], 'grade_id'), 'grade_name')?>
	            			[已缴纳<?php  echo $this->getGrade($item['company_name'],$item['openid'],'grade_money')?>元服务保证金]
	            		</div>
		          	<?php  } else { ?>
		          		<div class="ub-f1 uinn3">未缴纳服务保证金</div>
		          	<?php  } ?>
	            <?php  } ?>
	          </li>
	          
	          <!--
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="tx-r uinn3" style="width:4.5rem">已投保险：</div>
	            <div class="ub-f1 uinn3">100万意外险 / 10万财产险</div>
	          </li>
	          -->
	          
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="tx-r uinn3" style="width:4.5rem">健康证明：</div>
	            <div class="ub-f1 uinn3">
	            	<?php  if(strpos($item['card_all'], '健康证') !== false) { ?>已核验<?php  } else { ?>未核验<?php  } ?>
	            </div>
	          </li>
	          
	          <?php  if($item['company_name'] == '') { ?>
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="tx-r uinn3" style="width:4.5rem">个人接单：</div>
	            <div class="ub-f1 uinn3">是</div>
	          </li>
	          <?php  } else { ?>
	          <li class="uinn3 ubb b-bla01 ub">
	            <div class="tx-r uinn3" style="width:4.5rem">所属公司：</div>
	            <div class="ub-f1 uinn3"><?php  echo $item['company_name'];?></div>
	          </li>
	          <?php  } ?>
	          
	          <li class="uinn3 ubb b-bla01 ub">
	          	<div class="tx-r uinn3" style="width:4.5rem">工人介绍：</div>
	                <div class="ub-f1 uinn3">
	                <?php  if($item['remark'] != '') { ?>
	                    <?php  echo $item['remark'];?>
	                <?php  } else { ?>
	                                        什么介绍都没有
	                <?php  } ?>
	            </div>
	          </li>
	          
	    </ul>
	    
	    <!--项目范围-->
	    <div class="ub-f1">
	    	<div class="ub ub-ac uinn11">
	            	<div class="ubb b-bla01 ub-f1"></div>
	                <div class="ulev-1 t-dgra" style="padding:0 0.5rem">项目范围</div>
	                <div class="ubb b-bla01 ub-f1"></div>
	        </div>
	        <ul class="class_ul ulev-4 tx-c c-wh ubb ubt b-bla01">
		        <?php  echo $this->getStaffProject($item['id'])?>
	        	<div class="clear"></div>
	      	</ul>
	    </div>
	        
	   	<div class="ub-f1 c-wh ubb ubt b-bla01">
	        <ul class="ub-f1 ub-ver">
	        <?php  if($list[0]['id'] != '') { ?>	
	  		<!--循环开始-->
	  			<?php  if(is_array($list)) { foreach($list as $vo) { ?>
	  			<li class="ub-fl ubb ubt b-bla01 uinn ub-ver ubb umar-t c-wh">
	  				<div class="ub-fl ub ubb b-gra5 block ub-ac ub-pc">
	  					<div class="ub t-gra ulev-4 uinn3 ub-f1">
	  						<div class="umar-r ub ub-ac ub-pc tx-c">
	  							<?php  if($this->getMemberInfo($vo['openid'], 'avatar') != '') { ?>
	  								<img src="<?php  echo $this->getMemberInfo($vo['openid'], 'avatar')?>" width="200" height="200" class="rod-imgbox3 imgbox uba b-gra5 uc-a50">
	  							<?php  } ?>
	  						</div> 
	  						<span class="block-in" style="padding-top:0.4rem"><?php  echo $this->getMemberInfo($vo['openid'], 'nickname')?></span>
	  					</div>
	  					<div class="ub">
	  						<?php  if($vo['xing'] == 1) { ?>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	  						<?php  } ?>
	  						<?php  if($vo['xing'] == 2) { ?>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	  						<?php  } ?>
	  						<?php  if($vo['xing'] == 3) { ?>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	  						<?php  } ?>
	  						<?php  if($vo['xing'] == 4) { ?>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	                        <i class="iconfont icon-wujiaoxing ulev-1 t-dgra"></i>
	  						<?php  } ?>
	  						<?php  if($vo['xing'] == 5) { ?>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
	  						<?php  } ?>
	                    </div>
	  				</div>
	  				<div class="ub-f1 uinn ulev0">
	  					<?php  if($vo['comment'] == '') { ?>
	  						他很懒，什么都没说！
	  					<?php  } else { ?>
	  						<?php  echo $vo['comment'];?>
	  					<?php  } ?>
	  				</div>
	  				<div class="ub-fl uinn ulev-4 ub-ac ub-pc ub">
	  					<div class=" t-dgra ub-f1 tx-r"><?php  echo $vo['addtime'];?></div>
	  				</div>
	  			</li>
	  			<?php  } } ?>
	  		<!--循环结束-->	
	        </ul>
	        
		        <?php  if(count($list) > 7) { ?>
		        <a class="ub-fl ub ubb b-gra5 block ub-ac ub-pc uinn1" href="<?php  echo $this->createMobileUrl('catch', array('foo'=>'commentlist', 'id'=>$id))?>">
		        	<div class="ub t-gra ulev-4 uinn212 ub-f1">
		        		<span class="block-in t-blu" style="padding-top:0.4rem">查看全部评论</span></div>
		        		<div class="ub"><i class="iconfont icon-chevron-right t-gra ulev1"></i></div>
		        </a>
		        <?php  } ?>
	        <?php  } ?>
	    </div>
    </div>
    
    <div class="hbt"></div>
  	<!--手机端底部-->
  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>	
  	<!--手机端底部-->
    
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
$(document).ready(function(){
	localStorage['type_id'] = '';
});
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
