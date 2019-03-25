<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_header', TEMPLATE_INCLUDEPATH)) : (include template('common_header', TEMPLATE_INCLUDEPATH));?>
 <?php  if($operation=='display') { ?>
    <!--main开始-->
    <div class="g-main"> 
 		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_search', TEMPLATE_INCLUDEPATH)) : (include template('common_search', TEMPLATE_INCLUDEPATH));?> 
        <div class="m-player">
           <ul class="grid effect-1" id="grid" > 
           		<?php  if(is_array($items)) { foreach($items as $item) { ?> 
		               <li class="player">
		                   <div class="list-player-box">
		                       <div class="list-player">
		                           <div class="num-player"><p><?php  echo $item['no'];?></p></div>
		                           <div class="img-player">
		                               <a href="<?php  echo $this->createMobileUrl('item',array('op'=>'info','id'=>$activity['id'],'iid'=>$item['id']))?>">
		                               			<img src="<?php echo (!empty($item['thumb0'])?tomedia($item['thumb0']):tomedia($item['thumb']))?>" />
		                               	 </a>
		                           </div>
		                           <div class="des-player">
		                               <div class="f-fl">
		                                   <p><?php  echo $item['name'];?></p>
		                                   <p><span class="col-red votenums"><?php  echo $item['num'];?></span>票 </p>
		                               </div>
		                               <div class="f-fr">
		                                   <a href="javascript:void(0)" data-iid="<?php  echo $item['id'];?>" data-aid="<?php  echo $activity['id'];?>" class="btn-toupiao">
		                                       <div class="tp">
		                                           <h4>投票</h4>
		                                       </div>
		                                   </a>
		                               </div>
		                           </div>
		                       </div>
		                   </div>
		                   <!--list-player-->
		               </li>
               <?php  } } ?> 
           </ul>
        </div>
        <!--m-player--> 
        <?php  if($pages>1) { ?>
		        <div class='m-page'>
				            <ul class="list-page"> 
				            		<?php  if($pre_page>0) { ?>
				                			<li><a href="<?php  echo $this->createMobileUrl('index',array('id'=>$activity['id'],'page'=>$pre_page))?>">上一页</a></li>
				                	<?php  } ?>
				                	<?php  if($next_page<=$pages) { ?>
				               	    		<li><a href="<?php  echo $this->createMobileUrl('index',array('id'=>$activity['id'],'page'=>$next_page))?>">下一页</a></li>
				               	    <?php  } ?>
				            </ul>
		        </div>  
        <?php  } ?>
    </div> 
     <script src="<?php  echo $this->staticPath?>/app/js/masonry.pkgd.min.js"></script> 
    <script src="<?php  echo $this->staticPath?>/app/js/imagesloaded.js"></script> 
    <script src="<?php  echo $this->staticPath?>/app/js/classie.js"></script> 
    <script src="<?php  echo $this->staticPath?>/app/js/AnimOnScroll.js"></script>  
    <script>  
	    var openid = "<?php  echo $openid;?>";
		var must_guanzhu="<?php  echo $activity['must_guanzhu'];?>";
	    var is_fans = "<?php  echo $is_fans;?>"; 
        var click_url = "<?php  echo $this->createMobileUrl('item',array('op'=>'click'))?>";  
        new AnimOnScroll( document.getElementById( 'grid' ), { 
            minDuration : 0.4, 
            maxDuration : 0.7, 
            viewportFactor : 0.2 
        } );
        $(function(){ 
        	   $(".btn-toupiao").on("click",function(){
        		      var activity_id = $(this).attr("data-aid");
        		      var iid = $(this).attr("data-iid");
        		      var element_votenums = $(this).parents(".player").find(".votenums");
        		      var votenums = element_votenums.html();
	 			      if(must_guanzhu=="1" && is_fans=="0"){
					    	  layer.open({
					    		    content: "<?php  echo $guanzhu_content;?>"
					    		    ,btn: ['确定', '取消']
					    		    ,yes: function(index){
		    			    		      location.href="<?php  echo $activity['guanzhu_url'];?>";
		    			    		      layer.close(index);
					    		    },no:function(index){ 
					    		    	 layer.close(index);
					    		    }
					    		  });
				      }else{
				    	     $.ajax({type:'POST',dataType:'json',url:click_url,data:{id:activity_id,iid:iid},success:function(data){
				    	    	  if(data.code==1){
				    	    		  		 element_votenums.html(data.num); 
					    	    	    	 layer.open({
									    		    content: data.msg
									    		    ,btn: ['确定']
									    		    ,yes: function(index){  
						    			    		      layer.close(index); 
									    		     } 
									    		  }); 
			    	    		 }else{
			    	    			   layer.open({
							    		    content: data.msg
							    		    ,btn: ['确定']
							    		    ,yes: function(index){ 
				    			    		      layer.close(index); 
							    		     } 
							    		  }); 
			    	    		 }    
				    	     }})
				      }
        	   })
        })
    </script> 
    <!--g-main结束-->
<?php  } else if($operation=='info') { ?> 
    <!--main开始-->
    <div class="g-main">  
          <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_search', TEMPLATE_INCLUDEPATH)) : (include template('common_search', TEMPLATE_INCLUDEPATH));?>
        <!--m-center-->
        <div class="m-center"> 
            <div class="center-bt">
               	 <h2>★赛事说明★</h2>
            </div>
            <div class="event"> 
            	 <?php  if($activity['description']!='') { ?>
                <div class="event-list">
                    <h3>活动介绍</h3>
                     <P><?php  echo htmlspecialchars_decode($activity['description'])?></P>
                </div> 
                <?php  } ?>
                 <?php  if($activity['flow']!='') { ?>
		                <div class="event-list">
		                    <h3>活动流程</h3>
		                     <?php  echo htmlspecialchars_decode($activity['flow'])?>
		                </div>
                <?php  } ?>
                 <?php  if($activity['competition_rules']!='') { ?>
		                <div class="event-list">
		                    <h3>活动规则</h3>
		                     <?php  echo htmlspecialchars_decode($activity['competition_rules'])?>
		                </div>
                  <?php  } ?>
                   <?php  if($activity['voterule']!='') { ?>
		                <div class="event-list">
		                    <h3>投票规则</h3>
		                     <?php  echo htmlspecialchars_decode($activity['voterule'])?>
		                </div>
                <?php  } ?>
			     <?php  if($activity['awards']!='') { ?>
		                <div class="event-list">
		                    <h3>奖项设置</h3>
		                     <?php  echo htmlspecialchars_decode($activity['awards'])?>
		                </div>
                <?php  } ?>
            </div> 
        </div> 
    </div> 
<?php  } else if($operation=='rank') { ?>
    <!--main开始-->
    	<div class="g-main">  
		 <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_search', TEMPLATE_INCLUDEPATH)) : (include template('common_search', TEMPLATE_INCLUDEPATH));?>
        <div class="m-center"> 
            <div class="center-bt">
                		<h2> ★排行榜★ </h2>
            </div> 
            <table class="table text-center">
               <thead>
			                  <tr>
					                <td><strong>序号</strong></td>
				                    <td><strong>编号</strong></td>
				                    <td class="td-name"><strong>选手</strong></td>
				                    <td><strong>票数</strong></td> 
			                </tr>
                </thead>
                <body>
	                <?php  if(is_array($items)) { foreach($items as $item) { ?>
			                <tr>
			                    <td><?php  echo $item['rank_no'];?></td>
			                    <td><?php  echo $item['no'];?></td>
			                    <td class="td-name"><?php  echo $item['name'];?></td>
			                    <td><?php  echo $item['num'];?></td>
			                </tr>
	                <?php  } } ?> 
	               <script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=numa_vote"></script></body>
	            </table> 
			            <!--m-player--> 
			        <?php  if($pages>1) { ?>
					        <div class='m-page'>
							            <ul class="list-page"> 
							            		<?php  if($pre_page>0) { ?>
							                			<li><a href="<?php  echo $this->createMobileUrl('index',array('op'=>'rank','id'=>$activity['id'],'page'=>$pre_page))?>">上一页</a></li>
							                	<?php  } ?>
							                	<?php  if($next_page<=$pages) { ?>
							               	    		<li><a href="<?php  echo $this->createMobileUrl('index',array('op'=>'rank','id'=>$activity['id'],'page'=>$next_page))?>">下一页</a></li>
							               	    <?php  } ?>
							            </ul>
					        </div>  
			        <?php  } ?>
        </div>  
    </div>
    <!--g-main结束-->
<?php  } else if($operation=='myvote') { ?>
    <!--main开始-->
    	<div class="g-main">  
		 <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_search', TEMPLATE_INCLUDEPATH)) : (include template('common_search', TEMPLATE_INCLUDEPATH));?>
        <div class="m-center"> 
            <div class="center-bt">
                		<h2> ★我的投票★ </h2>
            </div> 
            <table class="table text-center">
               <thead>
			                  <tr>
					                <td><strong>时间</strong></td>
				                    <td><strong>投票给</strong></td> 
			                  </tr>
                </thead>
                <body>
	                <?php  if(is_array($items)) { foreach($items as $item) { ?>
			                <tr>
			                    <td><?php  echo $item['logtime'];?></td>
			                    <td><?php  echo $item['item_name'];?></td> 
			                </tr>
	                <?php  } } ?> 
	               <script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=numa_vote"></script></body>
	            </table> 
			            <!--m-player--> 
			        <?php  if($pages>1) { ?>
					        <div class='m-page'>
							            <ul class="list-page"> 
							            		<?php  if($pre_page>0) { ?>
							                			<li><a href="<?php  echo $this->createMobileUrl('index',array('op'=>'myvote','id'=>$activity['id'],'page'=>$pre_page))?>">上一页</a></li>
							                	<?php  } ?>
							                	<?php  if($next_page<=$pages) { ?>
							               	    		<li><a href="<?php  echo $this->createMobileUrl('index',array('op'=>'myvote','id'=>$activity['id'],'page'=>$next_page))?>">下一页</a></li>
							               	    <?php  } ?>
							            </ul>
					        </div>  
			        <?php  } ?>
        </div>  
    </div>
    <!--g-main结束-->
<?php  } ?>
<?php  if($activity['adv_open']==1 && $activity['adv_type']==1 && $activity['adv_image']!='') { ?>
<style type="text/css">
	.guanggao{padding:0.2rem}
	.guanggao img{height:2.2rem}
</style>
<div class="guanggao">
	<a href="<?php  echo $activity['adv_url'];?>">
		<img src="<?php  echo tomedia($activity['adv_image'])?>" alt="" />
	</a>
</div>
<?php  } else if($activity['adv_open']==1 && $activity['adv_type']==2 && $activity['adv_video']!='') { ?>
<link rel="stylesheet" type="text/css" href="<?php  echo $this->staticPath?>/app/css/zy.media.min.css" />
<script type="text/javascript" src="<?php  echo $this->staticPath?>/app/js/zy.media.min.js"></script>
<style type="text/css">
	#modelView{z-index:0;opacity:0.7;width: 100%;;position: relative;}
	.playvideo{padding-top: auto;z-index: 9999;position: relative;padding:0.2rem;width:100%}
	.zy_media{z-index: 999999999}
</style>
<div class="playvideo">
	<div class="zy_media">
		<video preload="auto" autoplay="autoplay" poster="" data-config='{"mediaTitle": ""}'>
			<source src="<?php  echo $activity['adv_video'];?>" type="video/mp4">
			您的浏览器不支持HTML5视频
		</video>
	</div>
	<div id="modelView">&nbsp;</div>
</div>
<script type="text/javascript">
    $(function(){
        zymedia('video',{autoplay: true});
    })
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_footer', TEMPLATE_INCLUDEPATH)) : (include template('common_footer', TEMPLATE_INCLUDEPATH));?>