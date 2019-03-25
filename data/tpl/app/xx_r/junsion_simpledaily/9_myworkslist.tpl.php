<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
	<title><?php  echo $mem['nickname'];?>的<?php  echo $cfg['UI']['work'];?></title>
	<link rel="stylesheet" href="<?php echo RES;?>css/media.css">
	<link rel="stylesheet" href="<?php echo RES;?>css/editChu.css">
	<script type="text/javascript">
	var count = "<?php  echo $count?>";
	</script>
	<style type="text/css">
		.loading {
		  width: 100%;
		  height: 2.45rem;
		  position: relative;
		  color:#A8A8A8;
		  display: none;
		  margin-top:10px;
		}
		.loading>p{
		  font-size: 0.825rem;
		  text-indent: 45%;
		  line-height: 2.45rem;
		}
	
		.loading .loading_img {
		  height:1.47rem;
		  width: auto;
		  position: absolute;
		  left: 30%;
		  top: 50%;
		  margin-top:-0.735rem;
		  -webkit-animation: reverseRotataZ 2s linear infinite;
		}
		@-webkit-keyframes reverseRotataZ{
		  0%{
		    -webkit-transform: rotateZ(0deg);
		  }
		  100%{
		    -webkit-transform: rotateZ(360deg);
		  }
		}
		.editisShow {
		  width: 2.73rem;
		  height: 2.73rem;
		  position: fixed;
		  bottom: 3%;
		  right: 5%;
		  z-index:999;
		}
		.editisShow input {
		  width: 100%;
		  height: 100%;
		  border-radius: 50%;
		  background-color: #2DC8DA;;
		  line-height: 2.73rem;
		  font-size: 0.75rem;
		  text-align: center;
		  border: none;
		  color: #fff;
		}
	</style>
</head>
<body>
	<!-- 我的作品 -->
	<div class="works">
		<div class="works_top">
			<img src="<?php echo RES;?>images/worksBtn.png" height="24" width="24" alt="">
			<p><?php  if($mid) { ?>他<?php  } else { ?>我<?php  } ?>的作品</p>
			<input type="button" class="top_btn" value="返回" style="display:none">
		</div>
		<div class="person">
			<div class="person_left">
				<p><?php  echo $mem['nickname'];?>的<?php  echo $cfg['UI']['work'];?></p>
				<p id="zp_count">作品总数：<?php  echo $count;?></p>
			</div>
			<div class="person_img">
				<img src="<?php  echo $mem['avatar'];?>" alt="">
			</div>
		</div>
		<div class="works_list">
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<div class="person_works" data-wid="<?php  echo $item['id'];?>">
					<div class="mask" style="background-image:url(<?php  echo $item['cover'];?>)" onclick="location.href='<?php  echo $this->createMobileUrl('myWorks',array('wid'=>$item['wid']))?>'"></div>
					<a style="text-decoration:none;">
						<p class="person_works_title"><?php  echo $item['title'];?></p>
					</a>
					<div class="person_works_bottom">
						<p><?php  echo $item['createtime'];?></p>
						<p>阅读数：<?php  echo $item['read'];?></p>
						<p>总赏金：<?php  echo $item['reward'];?></p>
					</div>
					<?php  if(!$mid) { ?><img src="<?php echo RES;?>images/delete.png" data-wid="<?php  echo $item['id'];?>" height="16" width="16" alt="" class="delete"><?php  } ?>	
			</div>
			<?php  } } ?>
		</div>
		<div style="width:100%;height:1rem;"></div>
	</div>
	<div class="works_bg">
	</div>
	<div class="works_delete">
			<p>确定删除此作品?</p>
			<div class="works_ok">
				<p class="works_cencle">取消</p>
				<p class="works_confirm">确定</p>
			</div>
	</div>
	<?php  if(!$mid && $cfg['isopenweb']) { ?>
	<div class="editisShow">
	    <input type="button" onclick="makeWorks()" value="创建">
	</div>
	<?php  } ?>
	<div class="loading" style="display: none;">
		<img src="<?php echo RES;?>images/loading.png" class="loading_img">
		<p>加载中...</p>
	</div>	
	<div class="loading_bg" style="position: fixed;width: 100%;height: 100%;background: rgba(0,0,0,.7);top: 0;z-index: 99999;display: none;">
	    <div class="loadding" style="display: block;">
	    	<img src="<?php echo RES;?>images/edit/loading.png" alt="">
	    	<p>作品上传中…</p>
	    </div>
    </div>
	<script type="text/javascript" src="<?php echo RES;?>js/zepto.min.js"></script>
	<script type="text/javascript">
		$('.top_btn').click(function(){
			if (history.length>0) {
				history.go(-1);
			}
		});
		var that
		$('.delete').click(function(){
			that=this;
			$('.works_bg').show();
			$('.works_delete').show();
		});
		$('.works_cencle').click(function(){
			$('.works_bg').hide();
			$('.works_delete').hide();
		});

		$('.works_confirm').click(function(){
			$.post("<?php  echo $this->createMobileUrl('deleteworks')?>",
				{
					wid:$(that).attr('data-wid')
				},
				function(data){
					if(data==1){
						$(that).parent().remove();
						$('.works_bg').hide();
						$('.works_delete').hide();
						//作品总数-1
						count--;
						$('#zp_count').text('作品总数：'+count);
					}
				}
			);
		});
		var page = 2;
		var ajax = false;
		$(window).scroll(function(){
		　　var scrollTop = $(this).scrollTop();
		　　var scrollHeight = $(document).height();
		　　var windowHeight = $(this).height();
		　　if(scrollTop + windowHeight == scrollHeight){
				if(ajax) return ;
				ajax = true;
		　　　　$('.loading').show();
				page++;
				//加载
				$.post("<?php  echo $this->createMobileUrl('AjaxWorks')?>",
				    {
				      page:page,
				      openid:"<?php  echo $mem['openid'];?>"
				    },
				    function(data){
				      //alert(data.data);//orderData = data.data;
				      if(data.status == "ok"){
				      	  var list = data.list;
					      var content = "";
					      for(var i=0;i<list.length;i++){
				            content += "<div class='person_works' data-wid="+list[i].id+">";
				            content += "<div class='mask' style='background-image:url("+list[i].cover+")'></div>";
				            content += "<a href='../app/index?i=<?php  echo $_W['uniacid'];?>&c=entry&do=myWorks&wid="+list[i].wid+"&m=junsion_simpledaily' style='text-decoration:none;'>";
				            content += "<a href='<?php  echo $this->createMobileUrl('MyWorks')?>&wid="+list[i].id+"'><p class='article_dec'>"+list[i].title+"</p></a>";
				            content += "<p class='person_works_title'>"+list[i].title+"</p>"; 
				            content += "</a>"; 
				            content += "<div class='person_works_bottom'>"; 
				            content += "<p>"+list[i].createtime+"</p>"; 
				            content += "<p>阅读数："+list[i].read+"</p>"; 
				            content += "<p>总赏金："+list[i].reward+"</p>"; 
				            content += "</div>"; 
				  <?php  if(!$mid) { ?>content += "<img src='<?php echo RES;?>images/delete.png' data-wid='"+list[i].id+"' height='16' width='16' alt='' class='delete'>";<?php  } ?> 
				            content += "</div>"; 
			        	  }
			        	  $('.works_list').append(content);
			        	  $('.loading').hide();
			        	  ajax = false;
				      }else{
				      	$('.loading').hide();
				      	ajax = true;
				      	return;
				      }
			    	},"json"
			    );
		　　}
		});
	</script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=20150120"></script>
<script type="text/javascript">
var shareData = {
	      title: "<?php  echo $cfg['ms_title'];?>",
	      link: "<?php  echo $surl;?>",
	      desc: "<?php  echo $cfg['ms_desc'];?>",
        imgUrl: "<?php  if($cfg['ms_thumb']) { ?><?php  echo toimage($cfg['ms_thumb'])?><?php  } else { ?><?php  echo $avatar;?><?php  } ?>",
	   };

jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || { jsApiList:[] };
jssdkconfig.debug = false;
jssdkconfig.jsApiList = ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','showOptionMenu','chooseImage','uploadImage'];
wx.config(jssdkconfig);
	wx.ready(function () {
	    wx.onMenuShareAppMessage(shareData);
	    wx.onMenuShareTimeline(shareData);
	    wx.onMenuShareQQ(shareData);
	    wx.onMenuShareWeibo(shareData);
	});

var imgIndex = 0;
var images = new Array();
var loadNum = 0;
var needLoadNum = 0;
function makeWorks(){
	<?php  if($_W['fans']['follow']!=1) { ?>
		window.location.href = "<?php  echo $cfg['leadurl'];?>";
		return false;
	<?php  } ?>
	//拍照或从手机相册中选图接口
	wx.chooseImage({
	    count: 9, // 默认9
	    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
	    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
	    success: function (res) {
	    	for(var i in res.localIds){
	    		needLoadNum++;
	    		images.push(res.localIds[i]); // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
	    	}
	    	$('.loadding>p').text("上传相片中("+0+"/"+needLoadNum+")");
	    	$('.loading_bg').show();
	    	upload();
	    }
	});
}
var pics = {};	
function upload(){
	wx.uploadImage({
		localId : images[imgIndex], // 需要上传的图片的本地ID，由chooseImage接口获得
		isShowProgressTips : 0, // 默认为1，显示进度提示
		success : function(res) {
			$.ajax({
				type:"POST",
				url:"<?php  echo $this->createMobileUrl('upload')?>",
				data:{imgid:res.serverId,type:'0'},
				cache:false,
				success:function(data){
					var data = $.parseJSON(data);
					if(data.code == 1){
						loadNum++;
						$('.loadding>p').text("上传相片中("+loadNum+"/"+needLoadNum+")");
						pics[imgIndex]={};
						pics[imgIndex]['content'] = '';
						pics[imgIndex++]['img'] = data.thumb;
						if(needLoadNum == loadNum){//最后一个图片
							$.post("<?php  echo $this->createMobileUrl('SaveWorks')?>",
									{
										title:'',
										music:'',
										cover:pics[0]['img'],
										pics:pics,
										wid:"0",
										op:'add'
									},
									function(state){
										$('.loading_bg').hide();
										if(state.error!=0){
											alert(state.msg);
										}else{
											window.location.href="<?php  echo $this->createMobileUrl('MyWorks',array('op'=>'edit'))?>&wid="+state.msg;
										}
								},"json");
							return false;
						}
					}
					upload();
				}
			});
		},
		fail: function(res){
		}
	});
	return false;
}	
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=junsion_simpledaily"></script></body>
</html>