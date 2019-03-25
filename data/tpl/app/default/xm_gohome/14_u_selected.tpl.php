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
 <div class="ub c-red1 ub-ver ub-ac ub-pc ub-img1" style="padding:0 0rem 3rem 0rem; background-image:url(<?php echo MODULE_URL;?>static/images/u-center-bg.jpg)">
	    <div class="bid_header ub">
	    	<?php  if(in_array(1,$idStr)==0) { ?>
	    	<a href="<?php  echo $this->createMobileUrl('order',array('foo'=>'oneorder', 'id' => $id))?>" class="block"><span class="uc-a15 t-yel uba b-yel absolute ulev-4" style="left:1rem; top:1rem; padding:0.2rem 0.5rem;">查看订单</span></a>
	        
	        <a onClick="orderDel(<?php  echo $id;?>)" class="block"><span class="uc-a15 t-yel uba b-yel absolute ulev-4" style="right:1rem; top:1rem; padding:0.2rem 0.5rem;">取消订单</span></a>
	        <?php  } ?>
	    </div>
	        
	    <div class="ub ub-ver" style="width:5rem; height:5rem; margin-top:2rem">
	       	<div class="loadaaa absolute" style="left:0; top:0;width:100%; height:100%"></div>
	        <div class="ub-f1 tx-c ub ub-ver ub-pc">
	            <div class="t-yel"><span class="ulev4" id="num"></span></div>
	        </div>
	    </div>
	    
	    <div class="t-wh umar-t">已有竞单人</div>
	    <div class="absolute tx-c ulev-4 t-yel ubt b-bla01" style="left:0; bottom:0;width:100%; padding:0.5rem 0">请从以下竞单人中选定接单人</div>
    </div>
    
    <!--无记录-->
    <div class="weui_msg" style="display:none">
    	<div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div>
    	<div class="weui_text_area">
      		<h2 class="weui_msg_title">暂无竞单</h2>
    	</div>
  	</div>
  	<!--无记录-->
  	
  	<form class="ub-f1 blcok connn" action="<?php  echo $this->createMobileUrl('selected',array('foo'=>'selectedsure'))?>" method="post" onSubmit="return checkform()">
  		<input type="hidden" name="order_id" value="<?php  echo $id;?>" />
	  	<div class="bid_body ub-fl">
	    <!--竞单列表-->
	    	<ul id="show" class="ub-f1 uinn8 ww-check">
		    	
	    	</ul>
	    	<div class="ulev-4 t-dgra tx-c uinn1">系统将通知您选定的接单人上门服务</div>
	    	<div class="umar-b1 umar-l umar-r umar-t1">
	    		<?php  if(count($list) != 0) { ?>
		        	<?php  if(in_array(1,$idStr)==0) { ?>
		            	<input name="submit" type="submit" value="选定接单人" class="weui_btn weui_btn_warn"  />
		            	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		            <?php  } ?>
		            
		            <?php  if(in_array(1,$idStr)==1) { ?>
		            	<span class="weui_btn weui_btn_default block" onClick="sureok()">已选定人员</span>
		            <?php  } ?>
		        <?php  } ?>
	    	</div>
	    </div>
    </form>
   
    <div class="" style="height:3.3rem"></div>
  	
  	<!--手机端底部-->
  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  	<!--手机端底部-->
    
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/baidutmp.js"></script>

<script id='near' type="text/template">
	<!-- 模板部分 -->
	<%if(json != 0){%>
		<%for(var i=0;i<json.length;i++){%>
		<%var pic = json[i].pic;%>
		<%var strs = new Array();%>
		<%strs = pic.split(",");%>
			<li class="uba b-bla01 uc-a15 ub umar-b ub-ver">
		        <div class="ub-f1 ub ub-ac ub-pc">
		        	<div class="uinn ub ub-ver tx-c">
		            	<div class="uc-a50 ub ub-ac ub-pc tx-c rod-imgbox uba b-gra5 imgbox ub-img1" >
		                	<img src="<%=json[i].face%>" class="uc-a50" style="height: 3em;"> 
		                </div>
		                <a href="<%=json[i].url%>" onClick="openPe()" class="block uba b-gre1 uinn3 ulev-4 t-gre1 uc-a15 umar-t">资料</a>
		            </div>
		            <div class="ub-f1 uinn ubl b-bla01 ubr" style="">
		            	<div class="ub ub-ac">
		                	<div class=""><%=json[i].staff_name%></div>
		                    <div class="ub-f1 ulev-2 tx-r">
		                        <%if(json[i].fen == 1){%>
		                    		<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        <%}%>
		                    	<%if(json[i].fen == 2){%>
		                    		<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        <%}%>
		                    	<%if(json[i].fen == 3){%>
		                    		<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        <%}%>
		                    	<%if(json[i].fen == 4){%>
		                    		<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        <%}%>
		                    	<%if(json[i].fen == 5){%>
		                    		<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        	<i class="iconfont icon-wujiaoxing ulev-1 t-org"></i>
		                        <%}%>
		                    </div>
		                </div>
		                <div class="ulev-4 t-gra">
		                	<div class="ub">报价：
		                		<%if(json[i].offer == ''){%>
		                			无报价
		                		<%}else{%>
		                			<%=json[i].offer%>元
		                		<%}%>
		                	</div>
		                	<div class="ub">
		                        <div class="ub-f1">工龄：<%=json[i].year%>个月</div>
		                        <div class="ub-f1">年龄：<%=json[i].age%>岁</div>
		                    </div>
		                    <div>单位：
		                    	<%if(json[i].company_name == ''){%>
		                    		无(个人)
		                    		<%if(json[i].geren == 1){%>
		                    		<span class="uinn3 c-blu t-wh uc-a1 ulev-2 umar-l">
		                    			个人认证
		                    		</span>
		                    		<%}%>
		                    	<%}else{%>
		                    		<%=json[i].company_name%>
		                    		<%if(json[i].fuwu == 1){%>
		                    			<span class="uinn3 c-org t-wh uc-a1 ulev-2 umar-l">
		                    				企业认证
		                    			</span>
		                    		<%}%>
		                    	<%}%>
							</div>
		                </div>
		                <div class="ubt b-bla01 ub  " style="margin-top:0.2rem; padding:0.2rem 0 0 0">
		                    <div class="ulev-1 umar-r t-blu">接单<%=json[i].get_order%></div>
		                    <div class="ulev-4 t-gra ub-f1"><font class="t-red1">好<%=json[i].good%></font> / 中<%=json[i].center%> / 差<%=json[i].bad%></div>
		                </div>
		            </div>
		            <div class="ub ub-ac ub-ver">
		            <input name="radio_v" type="radio" id="ww<%=i%>" value="<%=json[i].id%>|<%=json[i].staff_id%>" >
		            <label class="ub ub-ac ub-pc block" for="ww<%=i%>" style="padding:0.5rem 0.75rem">
		            	<i class="iconfont icon-xuanzhong ulev2 t-dgra"></i>
		            </label>
		            <a class="block uba b-bla01 uinn31 ulev-2 umar-a uc-a15" data-toggle="collapse" data-parent="#accordion" 
		          href="#collapse<%=i%>">查看</a>
		            </div>
		        </div>

		        <div id="collapse<%=i%>" class="panel-collapse collapse ub-f1 ubt b-bla01">
		        	<%if(json[i].piccount>0){%>
		        	<div class="panel-body ulev-4 ubb b-bla01 clearfix">
			          <span class="t-gra ufl umar-r">报价图片：</span>
			          
			          	<%for(var j=0;j<json[i].piccount;j++){%>
			          		<img src="<?php  echo $_W['attachurl'];?>gohome/pic/<%=strs[j]%>" onclick="showpic('<?php  echo $_W['attachurl'];?>gohome/pic/<%=strs[j]%>')" width="200" height="200" class="imgbox2 uba b-bla01 ufl umar-r1"> 
			          	<%}%>
			          
		          	</div>
		          	<%}%>
			        <div class="panel-body ulev-4 clearfix">
			          <span class="t-gra umar-r">报价说明：</span><%=json[i].remark%>
			        </div>
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
function addsz(){
	document.getElementById('num').innerHTML++;
}

//进页面加载数据
$(document).ready(function(){
	getInit();
	setInterval('getInit()',15000);
}); 

var forumPage = 1;
function getInit(){
	forumPage = 1;
    
	var id = "<?php  echo $id;?>";
	var data = {};
    data['forumPage'] = forumPage;
	data['id'] = id;
    
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('selected', array('foo'=>'getselected'));?>",
		type:"POST",
		data: data,
		dataType:"json",
		success: function(res){
			
			if(res == 0){
				document.getElementById('num').innerHTML = 0;
				document.getElementById('pageLoader').style.display = 'none';
				document.getElementById('show').innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_warn weui_icon_msg"></i></div><div class="weui_text_area"><h2 class="weui_msg_title">暂无竞单</h2></div></div>';
			}else{
				var json = eval(res);
                var near = baidu.template("near",{json:json});
                document.getElementById('show').innerHTML = near;
                document.getElementById('pageLoader').style.display = 'none';
                document.getElementById('num').innerHTML = json.length; 
                
			}
		}
	});
}

function checkform(){
	var radio=document.getElementsByName("radio_v");
	var selectvalue=null;   //  selectvalue为radio中选中的值
    for(var i=0;i<radio.length;i++){
		if(radio[i].checked==true) {
			selectvalue=radio[i].value;
			break;
		}
	}
	
	if(selectvalue == '' || selectvalue == null){
		alert('请选择一个竞单人');
		return false;
	}
}

function orderDel(id){
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

function sureok(){
	alert('您已选定服务人员');
}

function showpic(a){
	art.dialog({
	    padding: 0,
	    title: '',
	    content: '<img src="'+a+'" width="100%" height="100%" />',
	    lock: true
	});
}
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
