<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

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
    
    <!--选项卡-->
    <div class="uinn11 ubb c-gra1 ub tx-c top-tab b-bla01">
    	<a href="<?php  echo $this->createMobileUrl('order', array('foo'=>'index'))?>" class="ubr b-bla01 ub-f1 uinn t-gra block active">
    		预约单
    	</a>
        <a href="<?php  echo $this->createMobileUrl('order', array('foo'=>'order2'))?>" class=" ub-f1 uinn t-gra block">	完工单
        </a>
    </div>
    
    <!--订单列表-->
    <div class="c-wh order_list_box">
    <ul id="show" class="ub-f1 uinn8">
    	
    </ul>
    
    <div id="more" style="display:none;">
  		<div class="ub ub-pc uc-a1 ub-f1 btnn" onClick="getMore()" style="margin-bottom:0.5em; height:2em; line-height:2em;" type="submit"><span class="ulev0 tx-c">点击加载更多</span>
	    </div>
	</div>

    </div>
    <div class="hbt"></div>
  	<!--手机端底部-->
  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  	<!--手机端底部-->
  	
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/baidutmp.js"></script>

<script id='near' type="text/template">
	<!-- 模板部分 -->
	<%if(json != 0){%>
		<%for(var i=0;i<json.length;i++){%>
			<div class="uba b-bla01 uc-a15 ub ub-ac umar-b">
	        	<div class="uinn ub ub-ver ub-ac tx-c">
	                <div class="ub-f1">
	                <%if(json[i].title != 1){%>
	                	<span class="uinn4 c-org t-wh uc-a15 ulev-2 block-in"><%=json[i].title%></span>
	                <%}%>
                    </div>    
	                <img src="<%=json[i].icon%>" class="uc-a50 rod-imgbox uba b-gra5 ub-img1 umar-t">
	                <div class="ulev-2 t-gre1 umar-t"><%=json[i].type_name%></div>
	            </div>
	            <div class="ub-f1 ub ub-ver ubl ubr b-bla01 uinn11">
	            	<div class="ub ub-ac uinn4">
	            		<%if(json[i].state == 0 || json[i].state == 3){%>
	            		<div class="ulev-4 t-sbla">预计费用</div>
	                    <div class="ub-f1 tx-r ulev-1 t-gre1">￥</div>
	                    <div class="t-gre1"><span class=" ulev1"><%=json[i].dealprice%></span></div>
	                    <%}else{%>
	                    <div class="ulev-4 t-sbla">竞单报价</div>
	                    <div class="ub-f1 tx-r ulev-1 t-gre1">￥</div>
	                    <div class="t-gre1"><span class=" ulev1"><%=json[i].offer%></span></div>
	                    <%}%>
	                </div>
	                <div class="ubt ubb b-bla01" style="margin:0.3rem 0; padding:0.3rem 0">
	                    <div class="ulev-4 t-sbla uinn4"><%=json[i].ftime%></div>
	                </div>
	                <div class="ulev-4 t-gra uinn4">
	                	<div><%=json[i].fadr%></div>
	                    <!--<div>胜利四路46号天心花园</div>-->
	                    <!--<div>3栋18楼1802房</div>-->
	                </div>
	            </div>
	            <%if(json[i].mode == 0){%>
	            	<%if(json[i].state == 0 || json[i].state == 3){%>
		            	<!--
                        	<div onclick="del(<%=json[i].id%>)" class="ub ub-ver ub-ac ub-pc uinn8 ">
                        -->
                        <a href="<%=json[i].i_url%>" class="ub ub-ver ub-ac ub-pc uinn8 ">
			                <i class="iconfont icon-sheweihouxuanren ulev2 t-gre1"></i>
			                <div class="ulev-4 t-gre1 umar-t">等待</div>
			            </a>
			         <%}else if(json[i].state == 4){%>
		            	<a href="<%=json[i].d_url%>" class="ub ub-ver ub-ac ub-pc uinn8 ">
			                <i class="iconfont icon-iconmingchengpaixu65 ulev2 t-gre1"></i>
			                <div class="ulev-4 t-gre1 umar-t">查看</div>
			            </a>    
		            <%}else{%>
		            	<a href="<%=json[i].i_url%>" class="ub ub-ver ub-ac ub-pc uinn8 ">
			                <i class="iconfont icon-iconmingchengpaixu65 ulev2 t-gre1"></i>
			                <div class="ulev-4 t-gre1 umar-t">查看</div>
			            </a>
		            <%}%>
	            <%}else{%>
	            	<%if(json[i].state == 0 || json[i].state == 3){%>
		            	<a href="<%=json[i].s_url%>" class="ub ub-ver ub-ac ub-pc uinn8 ">
			                <i class="iconfont icon-sheweihouxuanren ulev2 t-gre1"></i>
			                <div class="ulev-4 t-gre1 umar-t">选人</div>
			            </a>
		            <%}else if(json[i].state == 4){%>
		            		<a href="<%=json[i].d_url%>" class="ub ub-ver ub-ac ub-pc uinn8 ">
			                <i class="iconfont icon-iconmingchengpaixu65 ulev2 t-gre1"></i>
			                <div class="ulev-4 t-gre1 umar-t">查看</div>
			            </a>
		            <%}else{%>
		            	<a href="<%=json[i].i_url%>" class="ub ub-ver ub-ac ub-pc uinn8 ">
			                <i class="iconfont icon-iconmingchengpaixu65 ulev2 t-gre1"></i>
			                <div class="ulev-4 t-gre1 umar-t">查看</div>
			            </a>
		            <%}%>
	            <%}%>
	            <div class="absolute uinn3 ulev-2 c-org t-wh uc-b15 uc-bl1 uc-br1" style="right:0.4rem; top:0;"><%=json[i].state_text%></div>
	        </div>
		<%}%>
	<%}else{%>
        <!--无记录-->
        <div class="weui_msg">
			<div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div>
			<div class="weui_text_area">
		  		<h2 class="weui_msg_title">无订单</h2>
			</div>
		</div>
  		<!--无记录-->
    <%}%>    
    <!-- 模板结束 -->
</script>

<script type="text/javascript">
//进页面加载数据
$(document).ready(function(){ 
	getInit();
	localStorage['type_id'] = '';
}); 


var forumPage = 1;
function getInit(){
	forumPage = 1;
    
	var data = {};
    data['forumPage'] = forumPage;
	
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('order', array('foo'=>'getorder'));?>",
		type:"POST",
		data: data,
		dataType:"json",
		success: function(res){
			
			if(res == 0){
				document.getElementById('pageLoader').style.display = 'none';
				document.getElementById('show').innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div><div class="weui_text_area"><h2 class="weui_msg_title">无订单</h2></div></div>';
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
	
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('order', array('foo'=>'getorder'));?>",
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

function del(id){
	var a=confirm("你确定删除该订单吗？");
	if(a==true){
		var data = {};
    	data['id'] = id;
		$.ajax({
			url: "<?php  echo $this->createMobileUrl('order', array('foo'=>'delorder'));?>",
			type:"POST",
			data: data,
			dataType:"json",
			success: function(res){
				if(res == "1"){
					alert('删除成功！');
					window.location.reload(); 
				}else{
					alert('删除失败！');
				}
			}
		});
 	}
}

</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
