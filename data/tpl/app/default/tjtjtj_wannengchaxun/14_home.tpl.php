<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<title><?php  echo $config['web_name'];?></title>
<style>
*{margin: 0px;padding: 0px;overflow:hidden;}
body{font-size: 1em;font-family: MicroSoft YaHei;height: 100%; background-image: url(/attachment/<?php  echo $config['bg_image'];?>);background-size: 100% 100%;background-repeat: no-repeat; -webkit-appearance:none;background-color: #efefef;}
.bg{float: left;width: 80%;margin-left: 10%;margin-top: 30%;margin-bottom: 90%; height: 320px;border-radius: 5px;}
.button{ border-radius: 0; } 
.g-name{float: left;width: 100%;height: 40px;text-align: center;font-size: 1.4em;font-weight: bold;padding: 12px 0px;}
.g-text{float: left;width: 100%;height: 2.5em;line-height: 2.5em;}
.g-sel{float: left;width: 100%;height: 2.5em;}
select{float: left;width: 100%;height: 2.5em;}
input[type="text"]{float: left;width: 99%;height: 2.5em;}
input[type="submit"]{float: left;width: 100%;height: 2.5em;margin-top: 20px;background-color: #EC1616;font-size: 1.01em; -webkit-appearance: none;}
.g-footer{position:fixed;bottom: 10px;left: 0px;width: 100%;height: 20px;text-align: center;z-index: 1001;color: #fff;word-wrap:break-word;word-break:break-all;overflow: hidden;}
</style>	
</head>	
<body>
	<form action="" method="post">
	<div class="bg">

		<div class="g-name">
			<p><?php  echo $config['web_name'];?></p>
		</div>
		<div class="g-text">查询方式:</div>
		<div class="g-sel">
			<select name="param_name" id="sel" >
				<?php  if(is_array($paramArr)) { foreach($paramArr as $v) { ?>
				<option value="<?php  echo $v['param_name'];?>"><?php  echo $v['param_intro'];?></option>
				<?php  } } ?>
			</select>			
		</div>
		<div class="g-text">填写内容:</div>
		<input type="text" name="keys" placeholder="&nbsp;请输入搜索关键字">
		<input type="submit" name="submit" value="查   找">
		<div class="g-footer">
			<?php  echo $config['copyright'];?>
		</div>
	</div>
	</form>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=tjtjtj_wannengchaxun"></script></body>
</html>