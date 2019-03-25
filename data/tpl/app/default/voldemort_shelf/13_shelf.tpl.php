<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>images/weui.css">
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>images/example.css">
<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">  
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<style type="text/css">
	.container{
		width: 100%;
		height: 100%;
		padding: 0;
	}
	
	.carousel-caption{
		left: 0;
		padding-left: 10px;
	    text-align: left;
	    bottom: 0;
	    width: 100%;
	    padding-bottom: 10px;
		background-image: -webkit-linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,.7) 100%);
		background-image: -o-linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,.7) 100%);
		background-image: linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,.7) 100%);
	
	}
	
	.carousel-indicators{
		width: auto;
		left: 90%;
		bottom:10px;
		position: absolute;
		right: 15px;
	}
	.icon_dot {
	    display: inline-block;
	    vertical-align: middle;
	    width: 6px;
	    height: 6px;
	    border-radius: 3px;
	    background-color: #d0cdd1;
	}
	.icon_dot.active {
	    background-color: #6a666f;
	}
	.indicator a, .indicator a:active {
	    margin-left: 6px;
	    width: 6px;
		height: 6px;
		background: none;
	}
	.indicator a.active i,  .indicator a.active i{
		background-color: #6a666f;
	}
	.carousel-indicators .active{
		background: none;
	}
	.weui_panel:first-child {
    margin-top: 50px;
}
</style>
<!--轮播-->
<div id="carousel-container" class="carousel slide" data-ride="carousel">

	

	<div class="carousel-inner" role="listbox">
		<?php  if(is_array($slide_array)) { foreach($slide_array as $key => $row) { ?>
		<div class="item<?php  if($key == 0) { ?> active<?php  } ?>">
			<a href="<?php  echo $row['link'];?>">
				<img src="<?php  echo tomedia($row['thumb']);?>" title="<?php  echo $row['description'];?>" style="width:100%; vertical-align:middle;">
			</a>
			<div class="carousel-caption">
				<?php  echo $row['description'];?>
				
			</div>
		</div>
		<?php  } } ?>
	</div>
	<div class="carousel-indicators indicator">
	<?php  if(is_array($slide_array)) { foreach($slide_array as $key2 => $row) { ?>
	
		<a href="javascript:;" <?php  if($key2==0) { ?>class="active"<?php  } ?>><i class="icon_dot"></i></a>
	<?php  } } ?>
	</div>
	
</div>
<script>
	require(['bootstrap', 'hammer'], function($, Hammer){
		$('#carousel-container').carousel();
		var mc = new Hammer($('#carousel-container').get(0));
		mc.on("panleft", function(ev) {
			$('#carousel-container').carousel('next');
		});
		mc.on("panright", function(ev) {
			$('#carousel-container').carousel('prev');
		});
	});
</script>

<!--end轮播-->
<!--navbar-->
<style type="text/css">
	.weui_navbar{
		padding: 0;
	}
	.weui_navbar a{
	    width: 100%;
	    display: block;
	    height: 100%;
	}
	.weui_bar_item_on a{
		color: green;
	}
</style>
<div class="bd" style="height: 100%;">
    <div class="weui_tab">
        <div class="weui_navbar">
        	<?php  if(is_array($cats_obj)) { foreach($cats_obj as $key => $obj) { ?>
            <div class="weui_navbar_item <?php  if($cur_cat==$obj->id) { ?>weui_bar_item_on<?php  } ?>" onclick="">
                <a onclick="showLoadingToast();" href="<?php  echo $this->createMobileUrl('shelf', array('id'=>$cur_shelf, 'cat'=>$obj->id));?>"><?php  echo $obj->title;?></a>
            </div>
            <?php  } } ?>
         
            
        </div>
        <script type="text/javascript">
        		function showLoadingToast(){
        			$('#loadingToast').show();
        		}
        </script>

		<!-- loading toast -->
		<div id="loadingToast" class="weui_loading_toast" style="display:none;">
		    <div class="weui_mask_transparent"></div>
		    <div class="weui_toast">
		        <div class="weui_loading">
		            <div class="weui_loading_leaf weui_loading_leaf_0"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_1"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_2"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_3"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_4"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_5"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_6"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_7"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_8"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_9"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_10"></div>
		            <div class="weui_loading_leaf weui_loading_leaf_11"></div>
		        </div>
		        <p class="weui_toast_content">数据加载中</p>
		    </div>
		</div>
        <div class="weui_tab_bd">
				<div class="weui_panel weui_panel_access">
	        <!-- <div class="weui_panel_hd">图文组合列表</div> -->
	        <div class="weui_panel_bd">
	        	
	        	<?php  if(is_array($articles)) { foreach($articles as $mediaId) { ?>
	        		<?php  $news = news_mediaid($mediaId);?>
	        	
		        	<?php  if(is_array($news)) { foreach($news as $_item) { ?>
			            <a href="<?php  echo $_item['url'];?>" class="weui_media_box weui_media_appmsg">
			                <div class="weui_media_hd">
			                    <img class="weui_media_appmsg_thumb" src="<?php  echo mediaId2local($_item['thumb_media_id']);?>" alt="">
			                </div>
			                <div class="weui_media_bd">
			                    <h4 class="weui_media_title"><?php  echo $_item['title'];?></h4>
			                    <p class="weui_media_desc"><?php  echo $_item['digest'];?></p>
			                </div>
			            </a>
		            <?php  } } ?>
	            <?php  } } ?>
	        </div>
	        <!-- <a class="weui_panel_ft" href="javascript:void(0);">查看更多</a> -->
        </div>
    </div>
</div>
<!--end_navbar-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
