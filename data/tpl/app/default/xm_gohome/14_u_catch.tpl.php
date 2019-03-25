<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>static/js/artDialog/skins/twitter.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>

<body>
	<!--加载进度开始-->
    <div id="pageLoader" class="weui_loading_toast">
       <div class="weui_mask_transparent"></div>
       <div class="weui_toast">
           <div class="weui_loading">
               <!-- :) -->
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
           <p class="weui_toast_content">数据加载中...</p>
       </div>
    </div>
    <!--加载进度结束-->
    
<div class="ub ub-ver bga page" id="page0"> 
<!--显示地理位置-->
	<div class="top_menu">
		<div class="c-wh ub t-dgra fixed ub-fh" style="top:0; left:0; z-index:9999;">
	    	<div class="c-bla30 ub ub-ac ub-pc" style="height:3rem; width:3rem" onClick="getAdr()"><i class="iconfont icon-dingwei ulev2 t-wh"></i></div>
	        <div class="ub-f1 ulev-4 t-wh uinn c-bla50 ub ub-ac" style="height:3rem">
	        	<div id="adr">位置获取中...</div>
	        </div>
	    	<div class="c-bla30 ub ub-ac ub-pc" onClick="openPe()" style="height:3rem; width:3rem"><i class="iconfont icon-iconzhenghe31 ulev2 t-wh"></i></div>
	    </div>
	</div>
	
    <div class="wap_index">
	    <div class="uinn11 ubb c-gra1 ub tx-c top-tab b-bla01 class_list">
	    	<!--
	    	<a href="<?php  echo $this->createMobileUrl('find',array())?>" class="ubr b-bla01 ub-f1 uinn t-gra block ">项目</a>
	        <a href="<?php  echo $this->createMobileUrl('catch',array())?>" class=" ub-f1 uinn t-gra block active">人</a>
	   		-->
	    </div>
	   
	   
  		<!--家政服务列表-->
  		<div class="bid_body">
  			<ul id="show" class="ub-f1 c-wh">
			  	<!--循环开始-->
			  	
			    <!--循环结束-->
    		</ul>
    		
    		<div id="more" style="display:none;">
		    	<div class="ub ub-pc uc-a1 ub-f1 btnn" onClick="getMore()" style="margin-bottom:0.5em; height:2em; line-height:2em;" type="submit"><span class="ulev0 tx-c">点击加载更多</span>
		        </div>
		    </div>
		    
    	</div>
    </div>
    
    <input type="hidden" name="mapkey" id="mapkey" value="<?php  echo $this->getBase('qq_ak');?>">

    <div class="hbt"></div>
  	
  	<!--手机端底部-->
  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  	<!--手机端底部-->
    <!--全部项目-->
    <div class="loginmask c-bla80">
    	<div class="ub ub-ac ub-pc mban" style="width:100%; min-height:100%;top:-800px">
      		<div class="class c-wh mask_box">
	      		<div class="ub bga uc-t15 uinn ub-ac">
	                <div style="width:2rem"></div>
	                <div class="tx-c font-b ub-f1">全部项目</div>
	                <div class="closealert"  style="padding:0.3rem 0.5rem"><i class="iconfont icon-guanbi ulev2 t-gra"></i></div>
	            </div>
	        	<ul class="t-line12 ub-fh ubt b-gra5" style="height:400px; overflow-y:scroll">
		          	<!--循环开始-->
		          	<?php  if(is_array($list1)) { foreach($list1 as $vo1) { ?>
		          	<li>
		          		<div onClick="check(<?php  echo $vo1['id'];?>)" class="block ubb ubr b-gra5 uinn">
		            		<?php  if($vo1['icon'] == '') { ?>
                                <p><img src="<?php echo MODULE_URL;?>static/images/nopic.png" width="60" height="60"></p> 
                            <?php  } else { ?>
                                <p><img src="<?php  echo $_W['attachurl'];?><?php  echo $vo1['icon'];?>" width="60" height="60"></p>
                            <?php  } ?>
		            		<p class="title ulev-4"><?php  echo $vo1['type_name'];?></p>
		            	</div>
		          	</li>
		          	<?php  } } ?>
		          	<!--循环结束-->
	        	</ul>
        	<div class="clear"></div>
      		</div>
    	</div>
  	</div>
  
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/baidutmp.js"></script>

<script id='near' type="text/template">
	<!-- 模板部分 -->
	<%if(json != 0){%>
		<%for(var i=0;i<json.length;i++){%>
			<li class="uinn5 ub ubb b-bla01">
				<a href="<%=json[i].url%>" class="block ub">
					<div class="ub-img1 ub ub-ver imgbox1 ub-img1 imgbox">
			            <div class="ub-f1"><img src="<%=json[i].avatar%>" style="height: 4em;"></div>
			            <div class="tx-c ulev-4 c-bla50 t-wh" style="padding:3px">资料</div>
			        </div>
			    </a>
			    <div class="ub-f1 uinn1 ub ub-ver">
			        <div class="ub-f1 ub">
			            <div class="ub-f1 t-gre1"><%=json[i].staff_name%>
				            <%if(json[i].bao == 1){%>
				            	<img src="<%=json[i].grade_icon%>" width="60" height="60" style="width:1.2rem; height:1.2rem">
				            <%}%>
			            </div>
			            <div class="ulev-2 t-gra"><%=json[i].juli%></div>
			        </div>
			        <div class="ub-f1 ub">
			            <div class="ulev-4 t-gra ub-f1">
			            	<%if(json[i].shiming == 1){%>
			            		<span class="uinn3 c-blu t-wh uc-a1 ulev-2">
		                    		实名认证
		                    	</span>
							<%}%> 
			            </div>
			            <div class="ulev-2 t-gra"><%=json[i].company_name%></div>
			        </div>
			        <div class="ulev-4 t-gra ub">
			        	<div class="umar-r uba b-blu t-line10 uc-a15 t-blu" style="padding:3px">接单 <%=json[i].get_order%></div>
			            <div class="umar-r uba b-org t-line10 uc-a15 t-org" style="padding:3px">好评 <%=json[i].good%></div>
			            <input type="hidden" id="jump<%=json[i].id%>" value="<%=json[i].jump%>" />
			            
			            	<div onclick="show_pro(<%=json[i].id%>)" class="umar-r uba b-gra t-line10 uc-a15 t-gra" style="padding:3px">预约<%=json[i].sex%></div>
			            
			        </div>
			    </div>
			    <div class="ub ub-ac ub-pc">
			    	<a href="<%=json[i].url%>" class="block"><i class="iconfont icon-chevron-right t-gra ulev1"></i></a>
			    </div>        
			</li>
		<%}%>
	<%}else{%>
        <!--无记录-->
        <div class="weui_msg">
			<div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div>
			<div class="weui_text_area">
		  		<h2 class="weui_msg_title">没有发现</h2>
			</div>
		</div>
  		<!--无记录-->
    <%}%>    
    <!-- 模板结束 -->
</script>

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

wx.ready(function () {
	$("#adr").html(localStorage['adr']);
    getInit();
    setTimeout('getAdr()', 1000);
});

function getAdr(){
	wx.getLocation({
      type: 'gcj02',
      success: function (res) {
        var lat = res.latitude;
        var lng = res.longitude;
        localStorage['lat'] = lat;
        localStorage['lng'] = lng;
        var mapkey = $("#mapkey").val();
        if(mapkey == ''){
        	 alert('获取地址失败，腾讯地图密钥未设置！');
        }
        $.ajax({
          url:"http://cloud.n3.cn/gohome/address.php",
          type:"POST",
          data:{"lat":lat,"lng":lng,"mapkey":mapkey},
          dataType:"jsonp",
          jsonp:"jsoncallback",
          success:function(res){
          	var address = res.readdress;
            $("#adr").html(address);
            localStorage['adr'] = address;
            getInit();
          },
          error:function(){
            alert('error!');
          }
        });
      } 
    });
}

var forumPage = 1;
function getInit(){
	forumPage = 1;
  
	var data = {};
    data['forumPage'] = forumPage;
	data['lng'] = localStorage['lng'];
    data['lat'] = localStorage['lat'];
	var type_id = localStorage['type_id'];		
	if(type_id != '' || type_id != 'undefined' || type_id != null){
		data['type_id'] = type_id;
	}
	
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('catch', array('foo'=>'getInfo'));?>",
		type:"POST",
		data: data,
		dataType:"json",
		success: function(res){
			if(res == 0){
				document.getElementById('pageLoader').style.display = 'none';
				document.getElementById('show').innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div><div class="weui_text_area"><h2 class="weui_msg_title">没有发现</h2></div></div>';
			}else{
				var json = eval(res);
                var near = baidu.template("near",{json:json});
                document.getElementById('show').innerHTML = near;
                document.getElementById('pageLoader').style.display = 'none';
				if(json.length == 10){
					document.getElementById('more').style.display = "block";  
				}
			}
		}
	});
}

function getMore(){
	forumPage = forumPage + 1;
    
	var data = {};
    data['forumPage'] = forumPage;
	data['lng'] = localStorage['lng'];
    data['lat'] = localStorage['lat'];
	var type_id = localStorage['type_id'];		
	if(type_id != '' || type_id != 'undefined' || type_id != null){
		data['type_id'] = type_id;
	}
	
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('catch', array('foo'=>'getInfo'));?>",
		type:"POST",
		data: data,
		dataType:"json",
		success: function(res){
			if(res == "0"){
				document.getElementById('more').innerHTML = '已无数据';
			}else{
				var json = eval(res);
				var near = baidu.template("near",{json:json});
                $("#show").append(near); 
				if(json.length<10){
					document.getElementById('more').innerHTML = "<div class='tx-c'>已无数据</div>";  
				}else{
					document.getElementById('more').style.display = "block";  
				}
			}
		}
	});
}

function check(id){
	localStorage['type_id'] = id;
	location.reload();
}

function show_pro(id){
	var url = document.getElementById('jump'+''+id+'').value;
	art.dialog.open(url,{
		id:'diaOrder',
		title:'项目范围',
		width:'80%',
		height:'50%',	
	});
}
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
