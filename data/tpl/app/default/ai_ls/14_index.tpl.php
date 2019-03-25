<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<script src="//cdn.bootcss.com/jquery/2.0.2/jquery.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.0.3/js/bootstrap.js"></script>
	<link href="//cdn.bootcss.com/bootstrap/3.0.3/css/bootstrap.css" rel="stylesheet">
	<title>律师查询</title>
	<style type="text/css">
		*{margin:0;padding:0;}
		button{font-size: 10px !important;}
		.term-btn{padding-right: 15px;overflow: hidden;}
		.term-top-btn{margin-top: 15px;float: left;}
		.term-bot-btn{padding-top: 15px;float: left;}
		.keyword-btn{margin-top: 20px;}
		.keyword{overflow: hidden;}
		.center{line-height: 34px;}
		body {
    background-color: #eee;
		}
		
		.carousel-inner{
		  width:100%;
		  max-height: 200px !important;
		}
	</style>
</head>
<body>
	<div class="container-builder">
		<div class="head-banner">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			    <!-- Indicators -->
				<ol class="carousel-indicators">
					<?php  for($i=0;$i<count($images)-1;$i++){
				?>
					<li data-target="#carousel-example-generic" data-slide-to="<?php  echo $i;?>"></li>
				<?php 
				}?>

				</ol>

		  		<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
				<?php  for($i=0;$i<count($images)-1;$i++){
				?>
					<div class="item active" id="ban">
				      <img src="/attachment/<?php  echo $images[$i]; ?>">
				    </div>
				<?php 
				}?>
				</div>

				  <!-- Controls -->
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				    <span class="sr-only">Previous</span>
				</a>
		    	<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			    	<span class="glyphicon glyphicon-chevron-right"></span>
			    	<span class="sr-only">Next</span>
		  		</a>
			</div>
		</div>
		<div class="term-btn">
			<div class="term-top-btn top-dis">
				<div class="col-xs-3">
					<button type="button" class="btn btn-default">按姓名查询</button>
				</div>
			</div>

		</div>

		<div class="keyword-btn">
			<div class="keyword">
				<div class="term col-xs-3 center">
					<p class="term text-center">姓名</p>
				</div>
				<div class="form-group col-xs-9">
					<input  type="text" class="form-control" id="name" placeholder="请输入查询条件">
				</div>

			</div>
			<button id="so" type="button" class="btn btn-primary btn-block center-block" style="width: 60%">搜索</button>
		</div>
       <div id="result" style="margin-left:15px;"></div>
		
	</div>

	<!-- Standard button -->
<script>
$('#so').click(function(){
	n=$('#name').val();
	$.ajax({
		type:'GET',
		url:'/app/index.php?i=1&c=entry&do=getls&m=ai_ls',
		data:{name:n},
		success:function(data){
			$("#result").html("");
			var a = eval("("+data+")");
			if (a.error_code==0) {
				 var json=a.result;
				 $.each(json, function (index, item) {  
                 //循环获取数据    
                 var name = json[index].name;
                 var mobile = json[index].mobile;
                 var idno = json[index].idno;
                 var province = json[index].province;
                 var city = json[index].city;
                 var area = json[index].area;
                 var corp = json[index].corp;
                 var addr = json[index].addr;
                 var spec = json[index].spec;
                 $("#result").html($("#result").html() + "<p>姓名：" + name + "</p><p>手机号：" + mobile + "</p><p>执业证号：" + idno + "</p>" + "<p>省份：" + province + "</p><p>城市：" + city + "</p><p>区县：" + area + "</p>"+ "<p>执业机构：" + corp + "</p><p>地址：" + addr + "</p><p>专长领域：" + spec + "</p><br>");  
             	});  
			}else if(a.error_code==208300){
				$('#result').html('网络异常请重试');
			}else if(a.error_code==208302){
				$('#result').html('无查询结果');
			}
		

		},
		error:function(data){
		},
    beforeSend: function(){
    	$("#result").html("请稍后正在加载");
    }
	});
});
	
</script>

<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ai_ls"></script></body>
</html>
