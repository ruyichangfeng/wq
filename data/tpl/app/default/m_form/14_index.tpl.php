<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>活动报名</title>
	<meta name="format-detection" content="telephone=no, address=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-touch-fullscreen" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
</head>
<style type="text/css">
	body{
		padding: 0;
		margin: 0;
	}
	.main{
		width: 100%;
	}
	.center-block{
		display: block;
		width: 100%;
	}
	.form_sty{
		background-color: <?php  echo $contents['form_color'];?>;
	}
	#form{
		width:65%;
		margin: 0 auto;
	}
	input{
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 5px 10px;
		width: 60%;
	}
	.word_sty{
		width:70px;
		float:left;
	}
	.word_line{
		height: 35px;
		color: <?php  echo $contents['word_color'];?>;
	}
	.btn_sty{
		margin-top: 20px;
		background-repeat: no-repeat;
		width: 100%;
		border: none;
		background-image: url('<?php  echo tomedia($btn_img)?>');
		height: 110px;
		background-color: <?php  echo $contents['form_color'];?>;
	}
</style>
<body>
	<div class="main">
		<img class="center-block" src="<?php  echo tomedia($contents['theme_img'])?>" alt="theme_img">
		<div class="form_sty">
			 <form action="" method="post" id="form">
			    <div>
			  		<div class="word_line">
			  			<div class="word_sty">用户名:</div>
			  			<input type="text" name="username"/>
			  		</div>
			  		<div class="word_line">
			  			<div class="word_sty">性别:</div>
			  			男<input style="width:10px;" type="radio" name="sex" value="1">
			  			女<input style="width:10px;" type="radio" name="sex" value="2">
			  		</div>
					<div class="word_line">
			  			<div class="word_sty">联系方式:</div>
			  			<input type="text" name="phone" />
			  		</div>
			  	</div>
			  	 <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			  	<button type="submit" name="submit" class="btn_sty"></button>
			 </form>
		</div>
		<img class="center-block" src="<?php  echo tomedia($contents['rule_img'])?>" alt="rule_img">
	</div>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=m_form"></script></body>
</html>