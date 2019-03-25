<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('inc/header', TEMPLATE_INCLUDEPATH)) : (include template('inc/header', TEMPLATE_INCLUDEPATH));?>
<style>
	@-webkit-keyframes hd{
		0%{
			-webkit-transform:scale(0.8,0.8);
    		-moz-transform:scale(0.8,0.8);
    		-transform:scale(0.8,0.8);
    	}
    	50%{
    		-webkit-transform:scale(1.0,1.0);
    		-moz-transform:scale(1.0,1.0);
    		-transform:scale(1.0,1.0);
    	}
    	100%{
    		-webkit-transform:scale(1.2,1.2);
    		-moz-transform:scale(1.2,1.2);
    		-transform:scale(1.2,1.2);
    	}
	}
	@-moz-keyframes hd{
		0%{
			-webkit-transform:scale(0.8,0.8);
    		-moz-transform:scale(0.8,0.8);
    		-transform:scale(0.8,0.8);
    	}
    	50%{
    		-webkit-transform:scale(1.0,1.0);
    		-moz-transform:scale(1.0,1.0);
    		-transform:scale(1.0,1.0);
    	}
    	100%{
    		-webkit-transform:scale(1.2,1.2);
    		-moz-transform:scale(1.2,1.2);
    		-transform:scale(1.2,1.2);
    	}
	}
	@keyframes hd{
		0%{
			-webkit-transform:scale(0.8,0.8);
    		-moz-transform:scale(0.8,0.8);
    		-transform:scale(0.8,0.8);
    	}
    	50%{
    		-webkit-transform:scale(1.0,1.0);
    		-moz-transform:scale(1.0,1.0);
    		-transform:scale(1.0,1.0);
    	}
    	100%{
    		-webkit-transform:scale(1.2,1.2);
    		-moz-transform:scale(1.2,1.2);
    		-transform:scale(1.2,1.2);
    	}
	}
	
	.business-img{
		-webkit-animation:hd 3s infinite ease-in-out;
		-moz-animation:hd 3s infinite ease-in-out;
		animation:hd 3s infinite ease-in-out;
		
	}
</style>
<script type="text/javascript">
<?php  if($_SESSION['posi']=='') { ?>
$(function(){
	if(<?php echo WEIXIN;?>==1){
		wx.ready(function() {
		   wx.getLocation({
		        type: 'wgs84',// 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
		        success: function (res) {
		            var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		            var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。

		            if(latitude&&longitude){
			            $.ajax({
			            	type: 'POST',
				    		url: "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('getlalo'),2)?>"+"&rad="+Math.random(),
					    	data: {latitude:latitude,longitude:longitude},
					    	success:function(datas){
					    		if(datas.statue==1){
					    			window.location.href="<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('showDetail',array('id'=>$id)),2)?>";
					    		}
					    	},
					    	error:function(datas){

						    },
					    	dataType:'json',
			            })
			        }
		    	},
		    	error: function(res){
		    	}
	    });

	 });
	}
})
<?php  } ?>
</script>
<body>
	<header class="swiper-container">
		<div class="swiper-wrapper">
			<?php  if(is_array($infos['thumb'])) { foreach($infos['thumb'] as $item) { ?>
				<div class="swiper-slide"><img src="<?php  echo tomedia($item)?>" width="100%"></div>
			<?php  } } ?>
        </div>
        <div class="showname"><?php  echo $title;?></div>
        <div class="showtype"><?php  echo $typename['catename'];?></div>
	</header>
	<section>
		<div class="storeinfo">
			<div class="s-name">
				<div class="nm" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>">基本信息</div>
				<div class="star">
					<ul>
						<?php  for($i=1;$i<=$infos['xj'];$i++){?>
						<li><img src="<?php echo NEARBY_IMAGE;?>x.png" width="100%"></li>
						<?php  }?>
					</ul>
				</div>
			</div>
			<div class="poi">
				<div class="pi"><img src="<?php echo NEARBY_IMAGE;?>dd.png" width="100%"></div>
				<div class="txt"><?php  echo $infos['province'];?><?php  echo $infos['city'];?><?php  echo $infos['address'];?></div>
			</div>
			<div class="poi" style="margin-top:5px;">
				<div class="pi" style="margin-left:3px;"><img src="<?php echo NEARBY_IMAGE;?>tel2.png" width="80%"></div>
				<div class="txt" style="margin-left:-3px;"><?php  echo $infos['tel'];?></div>
			</div>
			<?php  if($infos['pcharge']) { ?>
			<div class="poi" style="margin-top:5px;">
				<div class="pi" style="margin-left:3px;"><img src="<?php echo NEARBY_IMAGE;?>pcharge.png" width="80%"></div>
				<div class="txt" style="margin-left:-3px;">负责人：<?php  echo $infos['pcharge'];?></div>
			</div>
			<?php  } ?>

			<?php  if($infos['ptel']) { ?>
			<div class="poi" style="margin-top:5px;">
				<div class="pi" style="margin-left:3px;"><img src="<?php echo NEARBY_IMAGE;?>ptel.png" width="80%"></div>
				<div class="txt" style="margin-left:-3px;">负责人电话：<?php  echo $infos['ptel'];?></div>
			</div>
			<?php  } ?>

		</div>
		
		<?php  if($infos['isopenm']==1) { ?>
		<div class="showopen">
			<div class="s-name">
				<?php  if($infos['mdwz']) { ?>
				<div class="nm" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>"><?php  echo $infos['mdwz'];?></div>
				<?php  } else { ?>
				<div class="nm" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>">推广信息</div>
				<?php  } ?>
			</div>
		</div>
		<?php  if(is_array($all)) { foreach($all as $it) { ?>
		<a href="<?php  echo $it['url'];?>">
		<div class="showopenm">
			<div class="ctn"><?php  echo $it['content'];?></div>
			<div class="btw" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>"><?php  echo $it['btncon'];?></div>
		</div>
		</a>
		<?php  } } ?>
		<?php  } ?>

		<div class="showcontent">
			<div class="title" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>" >详细信息</div>
			<div class="content">
				<?php  echo htmlspecialchars_decode($infos['remark']);?>
			</div>
		</div>

		<?php  if($setting['is_commen'] == 1) { ?>
		<div class="showcontent">
			<div>全部评论</div>
			<div class="comment_box" style="width:100%;height:auto;">
				<?php  if(is_array($commen_list)) { foreach($commen_list as $com) { ?>
					<div style="width:100%;height:auto;float:left;border-bottom:1px solid #cdcdcd;">
						<div style="width:15%;float:left;margin-top:10px;margin-bottom:10px;">
							<img src="<?php  echo $com['avatar'];?>" class="img_box" width="90%" style="width:90%;max-width:50px;border-radius:50%;" />
						</div>
						<div style="width:83%;margin-left:2%;float:left;margin-top:10px;margin-bottom:10px;">
							<div style="width:100%;"><?php  echo $com['nickname'];?></div>
							<div style="width:100%;margin-top:5px;"><?php  echo $com['content'];?></div>
						</div>
					</div>
				<?php  } } ?>
			</div>
			<div style="clear:both;"></div>
			<div style="width:100%;height:100px;margin-top:10px;">
				<textarea style="width:94%;height:100px;border-radius:10px;line-height:28px;padding-left:3%;padding-right:3%;border:1px solid #F3F3F2;" id="store_common" placeholder="说点神马吧"></textarea>
			</div>
			<div style="width:100%;height:30px;">
				<div id="send_comment" style="width:100%;height:35px;line-height:35px;text-align:center;background-color:<?php  echo $setting['color'];?>;color:#ffffff;margin-top:10px;border-radius:20px;">发表评论</div>
			</div>
		</div>
		<?php  } ?>
	</section>
	<div class="copyright" style="background-color:#ffffff;margin-top:-10px;"><a href="<?php  echo $setting['copyrighturl'];?>" style="<?php  if($setting['color']) { ?> color:<?php  echo $setting['color'];?>; <?php  } ?>" >&copy<?php  echo $setting['copyright'];?></a></div>
	<footer>
		<?php 
				$infos['remark']= htmlspecialchars_decode($infos['remark']);
				$infos['remark']= preg_replace("/<(.*?)>/","",$infos['remark']); 
		?>
		<?php  if($setting['is_menu'] == 0) { ?>
		<?php  if(!empty($infos['menuone'])) { ?>
			<a href="<?php  echo $infos['menuurlone'];?>">
				<div class="nav" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>">
					<div class="abc">
						<?php  if(!empty($infos['menuonelogo'])) { ?>
							<img src="<?php  echo tomedia($infos['menuonelogo'])?>">
						<?php  } else { ?>
							<img src="<?php echo NEARBY_IMAGE;?>dww.png">
						<?php  } ?>
					<?php  echo $infos['menuone'];?></div>
				</div>
			</a>
		<?php  } else { ?>
			<?php  if($infos['lat']&&$infos['lng']) { ?>
			<a href="http://api.map.baidu.com/marker?location=<?php  echo $infos['lat'];?>,<?php  echo $infos['lng'];?>&title=<?php  echo $infos['storename'];?>&name=<?php  echo $infos['storename'];?>&content=<?php  echo $infos['storename'];?>&output=html&src=weiba|weiweb" >
			<!-- <a href="<?php  echo $this->createMobileUrl('map',array('lat'=>$infos['lat'],'lng'=>$infos['lng']));?>" data-la="<?php  echo $infos['lat'];?>" data-lg="<?php  echo $infos['lng'];?>"> -->
				<div class="nav" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>">
					<div class="abc"><img src="<?php echo NEARBY_IMAGE;?>dww.png">
					一键导航</div>
				</div>
			</a>
			<?php  } else { ?>
			<div class="nav nodh" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>">
				<div class="abc"><img src="<?php echo NEARBY_IMAGE;?>dww.png">
				一键导航</div>
			</div>
			<?php  } ?>
		<?php  } ?>

		<?php  if(!empty($infos['menutwo'])) { ?>
		<a href="<?php  echo $infos['menuurltwo'];?>" >
			<div class="tels" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>">
				<div class="abc">
				<?php  if(!empty($infos['menutwologo'])) { ?>
					<img src="<?php  echo tomedia($infos['menutwologo'])?>">
				<?php  } else { ?>
					<img src="<?php echo NEARBY_IMAGE;?>telw.png">
				<?php  } ?>
				<?php  echo $infos['menutwo'];?></div>
			</div>
		</a>
		<?php  } else { ?>
		<a data="<?php  echo $infos['tel'];?>" class="tele">
			<div class="tels" style="<?php  if($setting['color']) { ?> background-color:<?php  echo $setting['color'];?>; <?php  } ?>">
				<div class="abc">
				<img src="<?php echo NEARBY_IMAGE;?>telw.png">
				一键拨号</div>
			</div>
		</a>
		<?php  } ?>
		<?php  } ?>
	</footer>
	<?php  if($setting['index_back'] == 1) { ?>
	<a href="<?php  echo $this->createMobileUrl('index');?>">
		<div style="position:fixed;bottom:10%;left:5px;">
			<?php  if(!empty($setting['index_back_thumb'])) { ?>
			<img width="50" class="business-img" src="<?php  echo tomedia($setting['index_back_thumb']);?>" />
			<?php  } else { ?>
			<img width="50" class="business-img" src="<?php echo NEARBY_IMAGE;?>index_one.png" />
			<?php  } ?>
		</div>
	</a>
	<?php  } ?>
	<?php  if($setting['is_menu'] == 1) { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('menu', TEMPLATE_INCLUDEPATH)) : (include template('menu', TEMPLATE_INCLUDEPATH));?>
	<?php  } ?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=jy_nearby"></script></body>
<script src="<?php echo NEARBY_JS;?>swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container');

    $(".tele").click(function(){
    	var a = $(this).attr("data");
    	if(a){
    		window.location.href = "tel:"+a;
    	}else{
    		swal('商家很懒，未标明电话号码!');
    	}
    })

    $(".nodh").click(function(){
    	swal('商家很懒，未标明地址!');
    })


</script>
<script type="text/javascript">
var params = {
    <?php  if(empty($infos['storename'])) { ?>
    title: "<?php  echo $setting['sharetitle'];?>",
    <?php  } else { ?>
    title: "<?php  echo $infos['storename'];?>",
    <?php  } ?>
    <?php  if(empty($setting['sharedesc'])) { ?>
    desc: "附近门店",
    <?php  } else { ?>
    desc: "<?php  echo $setting['sharedesc'];?>",
    <?php  } ?>
    <?php  if(empty($infos['storelogo'])) { ?>
    imgUrl: "<?php  echo tomedia($setting['sharelogo'])?>",
    <?php  } else { ?>
    imgUrl: "<?php  echo tomedia($infos['storelogo'])?>",
    <?php  } ?>
};
wx.ready(function () {
    wx.showOptionMenu();
    wx.onMenuShareAppMessage.call(this, params);
    wx.onMenuShareTimeline.call(this, params);
});

//发表评论
$('#send_comment').bind('click',function(){
	var storeid = "<?php  echo $id;?>";
	var content = $('#store_common').val();
	$.ajax({
        url : "<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('addcommen'),2)?>",
        type : 'post',
        async: false,
        data : {'storeid':storeid,'content':content},
        dataType: "json",
        success : function(data){
        	
            if(data.status == 1){
            	swal('评论成功');
            	$('.comment_box').prepend('<div style="width:100%;height:auto;float:left;border-bottom:1px solid #cdcdcd;"><div style="width:15%;float:left;margin-top:10px;margin-bottom:10px;"><img src="'+data.avatar+'" style="width:90%;border-radius:50%;" /></div><div style="width:83%;margin-left:2%;float:left;margin-top:10px;margin-bottom:10px;"><div style="width:100%;">'+data.nickname+'</div><div style="width:100%;margin-top:5px;">'+content+'</div></div></div>');
            	$('#store_common').val('');
            }else{
            	swal(data.mess);
            	return false;
            }
        },
        fail:function(){
        }
    });
});
</script>
</html>