<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_header', TEMPLATE_INCLUDEPATH)) : (include template('common_header', TEMPLATE_INCLUDEPATH));?>
<!--main开始-->
    <div class="g-main">
		 <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_search', TEMPLATE_INCLUDEPATH)) : (include template('common_search', TEMPLATE_INCLUDEPATH));?>   
        <!--m-center-->
        <div class="m-center">
            <div class="article-box">
                <div class="article-info">
                    <p><span class="col-white"><?php  echo $item['no'];?></span>号<span class="pad-left"><?php  echo $item['name'];?></span></p>
                    <p>选手排名：<span class="pad-left">第<span class="col-white"><?php  echo $item['rank_no'];?></span>名</span></p>
                    <p>票数：<span class="pad-left"><span class="col-white"><?php  echo $item['num'];?></span>票</span></p>
                	   <?php  if($item['desc']!='') { ?> <p>参赛宣言：<span class="pad-left"><?php  echo $item['desc'];?></span></p><?php  } ?>

                    <div class="btn-link">
                        <a href="<?php  echo $rank_url;?>"><button type="submit" class="btn btn-white">查看排行榜</button></a>
                    </div>
                </div>
            </div> 
            <div class="palyer-info"> 
                   <?php  if(empty($item_pics)) { ?>
                			<img src="<?php  echo tomedia($item['thumb'])?>">
                  <?php  } else { ?>
                           <?php  if(is_array($item_pics)) { foreach($item_pics as $pic) { ?>
                           		<img src="<?php  echo tomedia($pic)?>">
                           <?php  } } ?>
                   <?php  } ?>
            </div> 
            <div class="btn-link">
                		<a href="javascript:void(0)" class="btn-toupiao" data-enabled="1" data-iid="<?php  echo $item['id'];?>" data-aid="<?php  echo $activity['id'];?>"><button  type="submit" class="btn btn-red">投TA一票</button></a>
                		<a href="<?php  echo $add_url;?>"><button type="submit" class="btn btn-blue">我也要参加</button></a>
                		<a href="<?php  echo $index_url;?>"><button type="submit" class="btn btn-orange">看看其他选手</button></a>
            </div> 
        </div> 
    </div>
    <!--g-main结束-->
    <script type="text/javascript">
		    var openid = "<?php  echo $openid;?>";
			var must_guanzhu="<?php  echo $activity['must_guanzhu'];?>";
		    var is_fans = "<?php  echo $is_fans;?>";
		    var click_url = "<?php  echo $this->createMobileUrl('item',array('op'=>'click'))?>"; 
		    $(function(){
		    	   $(".btn-toupiao").on("click",function(){
		    		      var activity_id = $(this).attr("data-aid");
		    		      var iid = $(this).attr("data-iid");
		    		      var element_votenums = $(this).parents("player").find(".votenums");
		    		      var votenums = element_votenums.html();
		    		      var _this = $(this);
		    		      var is_can = $(this).attr("data-enabled");
		    		      if(is_can==1){
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
								    	     _this.attr("data-enabled",0);
								    	     $.ajax({type:'POST',dataType:'json',url:click_url,data:{id:activity_id,iid:iid},success:function(data){
								    	    	   if(data.code==1){
								    	    		     _this.attr("data-enabled",1);
								    	    	    	 layer.open({
												    		    content: data.msg
												    		    ,btn: ['确定']
												    		    ,yes: function(index){   
									    			    		      document.location.reload()
									    			    		      layer.close(index);
												    		     } 
												    		  }); 
								    	    		 }else{ 
								    	    			 _this.attr("data-enabled",1);
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
		    		         } 
		    	   })
		    }) 
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common_footer', TEMPLATE_INCLUDEPATH)) : (include template('common_footer', TEMPLATE_INCLUDEPATH));?>