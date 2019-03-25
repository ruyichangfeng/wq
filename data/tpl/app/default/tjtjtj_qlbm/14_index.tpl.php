<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <title><?php  echo $setting['title']?></title>

    <script>
		$(".fontsinput").bind("focus",function(){ isAndroid(); if(isAndroid){ $(".fonts").css("position","fixed"); }else{ $(".fonts").css("position","absolute"); } })
    </script>
    <script>
    	document.getelementbytagename(input)
    </script>

</head>

<body style="background-color:#e8467d; margin:0; color:#fff67f">

	<div class="dingimg">
		<img src="<?php  echo $_W['siteroot'].'attachment/'.$setting['dingimg']?>" width="100%" height="auto" >
	</div>
	
	
	<div class="form" style="margin-right:10%">
	
		<form name="form" method="post" action="" style="">

			<table cellpadding="0" cellspacing="0" border="0" class="tables" align:center>
				<tr>
					<td width="30%" height="35" align="right">姓&nbsp;&nbsp;名:</td>

					<td width="30%" align="left">
						<input type="text" name="sex" id="name" class="dinput" style="color:#FFFFFF;">
					</td>
				</tr>
				<tr>
					<td width="30%" align="right" height="35">姓&nbsp;&nbsp;别:</td>

					<td width="30%" align="left">
						<input type="radio" class="inputr" name="sex" class="" value="1" >&nbsp;男&nbsp;&nbsp;<input type="radio" class="inputr" name="sex" class="" value="0" >女
					</td>
				</tr>
				<tr>
					<td width="30%" align="right" height="35">年&nbsp;&nbsp;龄:</td>

					<td width="30%" align="left">
						<input type="number" name="name" id="age" class="dinput" style="color:#FFFFFF;">
					</td>
				</tr>
				<tr>
					<td width="30%" align="right" height="35">婚姻状况:</td>

					<td width="30%" align="left">
						<input type="radio" class="inputr" name="hyzk" value="1">&nbsp;已婚&nbsp;&nbsp;<input type="radio" class="inputr" name="hyzk"  value="0" >未婚
					</td>
				</tr>
				<tr>
					<td width="30%" align="right" height="35">联系方式:</td>

					<td width="30%" align="left">
						<input type="number" nmae="name" id="phone" class="dinput" style="color:#FFFFFF;">
					</td>
				</tr>
				<tr>
					<td width="30%" align="right" height="35">单&nbsp;&nbsp;位:</td>

					<td width="30%" align="left">
						<input type="text" nmae="name" id="danwei" class="dinput" style="color:#FFFFFF;">
					</td>
				</tr>
			</table>
		</form>
	
	</div>


	<div class="xuimg">
		<img src="<?php  echo $_W['siteroot'].'attachment/'.$setting['xuimg']?>" width="100%" height="auto" >
	</div>

	<div class="baoimg" style="margin-bottom:30px; margin-top:50px;" >
		<div align="center">
		<?php  if(time() > $setting['start_time'] && time() < $setting['end_time']) { ?>
		<img id="save" src="<?php  echo $_W['siteroot'].'attachment/'.$setting['baoimg']?>" width="70%" height="auto" onclick="this.disabled=true">
		<?php  } else { ?>
		<img src="<?php  echo $_W['siteroot'].'attachment/'.$setting['jieimg']?>" width="70%" height="auto">
		<?php  } ?>

	      </div>
		
	</div>


<style>
	.tables{
		color: #FFF67F
	}
		.dinput{
			width: 170px;height: auto;margin-left: 10px;border:solid 1px #FFF67F;border-color: #FFF67F;background-color: #E0477C
		}
		.inputr{
			margin-left: 10px;background-color: #FFF67F
		}
	</style>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=tjtjtj_qlbm"></script></body>
</html>


<script>
	$(document).ready(function(){
		$("#save").click(function(){
			if($("#name").val() == "")
			{
				alert("用户名不能为空!");
				return false;
			}
			var sex1 = $("input[name='sex']:checked").val();
		
			if(sex1 == null)
			{
				alert("请选择性别!");
				return false;
			}
			if($("#age").val() == "")
			{
				alert("年龄不能为空！");
				return false;
			}
			var sex = $("input[name='hyzk']:checked").val();

			if(sex == null)
			{
				alert("请选择婚姻状况!");
				return false;
			}
			if($("#phone").val() == "")
			{
				alert("联系方式不能为空！");
				return false;
			}
			if(!$("#phone").val().match(/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/))
			{
				alert("手机号格式不正确!");
				return false;
			}
			if($("#phone").val() == "")
			{
				alert("请勿重复提交！");
				return false;
			}
			
			
			if($("#danwei").val() == "")
			{
				alert("单位不能为空！");
				return false;
			}



			$.ajax({
				url : "<?php  echo $this->createMobileUrl('Dosave')?>",
				type:"post",
				data:{
					name : $("#name").val(),
					sex : $("input[name='sex']:checked").val(),
					age: $("#age").val(),
					hyzk: $("input[name='hyzk']:checked").val(),
					phone : $("#phone").val(),
					danwei: $("#danwei").val(),
				},
				success:function(res)
				{
					var data = $.parseJSON(res);

					if(data.status == 1)
					{
						alert(data.text);
						//window.location.href="url";
					}
					if(data.status == 0)
					{
						alert(data.text);
					}

					if(data.status == -1)
					{
						alert(data.text);
					}
					
				}
			});

				

		});
	});
</script>
