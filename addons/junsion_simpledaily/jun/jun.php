<?php
function WXLimit(){
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	if (!strpos($userAgent, 'MicroMessenger')) {
		die('
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<meta name="viewport"
					content="width=device-width, initial-scale=1, user-scalable=0">
				<title>抱歉，出错了</title>
				<meta charset="utf-8">
				<meta name="viewport"
					content="width=device-width, initial-scale=1, user-scalable=0">
				<link rel="stylesheet" type="text/css"
					href="https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css">
				</head>
				<body>
					<div class="page_msg">
						<div class="inner">
							<span class="msg_icon_wrp"><i class="icon80_smile"></i></span>
							<div class="msg_content">
								<h4>请在微信客户端打开链接</h4>
							</div>
						</div>
					</div>

				</body>
				</html>
				');
	}
}

function MSG($txt,$redirect = "",$status){
	$moduleurl = MODULE_ROOT;
	$moduleurl = str_replace(IA_ROOT, "..", $moduleurl);
	if ($redirect && empty($status)) $status = 's';
	
	$color = "#b51c1c";
	if ($status == 'w') $color = "#f0ad4e";
	elseif ($status == 's') $color = "#60ce3a";
	
	$img = 'failure.png';
	if ($status == 'w') $img = "warning.png";
	elseif ($status == 's') $img = "succed.png";
	$img = $moduleurl."/jun/img/".$img;
	
	if (!empty($redirect))
		$action = "
			<div class='promptMain'>
						<p>如果你的浏览器没有自动跳转</p>
						<div class='promptMain_icon'>
							<span></span>
						</div>
						<div class='prompt_btns'>
							<a href='{$redirect}'>点我跳转</a>
						</div>
					</div>
					<script type='text/javascript'>
						setTimeout(function () {
							location.href = '{$redirect}';
						}, 3000);
					</script>	
		";
	else $action = "
			<div class='promptMain'>
					<div class='prompt_btns'>
						<a href='javascript:history.go(-1);'>返回</a>
					</div>
				</div>
			";
	
	
	$html = "
				<meta name='viewport'
					content='width=device-width, initial-scale=1, user-scalable=0'>
			<style>
				html,body{ width: 100%; height: 100%; overflow: hidden; background: #fff; font-size: 12px; font-family: '微软雅黑'; color: #333;}
				.outer{ width: 100%; height: 100%; overflow: hidden; position: relative; z-index: 10;}	
				.promptTop{ width: 100%; height: auto; overflow: hidden; position: absolute; z-index: 20; top: 15%; left: 0%;}
				.promptTop span{ display: block; margin: 0px auto;width: 25%; max-width: 200px; height: auto; overflow: hidden; display: block;}
				.promptTop img{ width: 100%; height: auto; display: block;}
				.promptTop p{ width: 90%;padding: 0 10px; font-size: 24px; color:{$color}; text-align: center;}	
				.promptMain{ width: 100%; height: auto; overflow: hidden; position: absolute; z-index: 20; left: 0px; bottom: 15%;}	
				.promptMain p{ width: 100%; height: auto; overflow: hidden; color: #909090; font-size: 16px; text-align: center;}	
				.promptMain_icon{ width: 100%; height:60px; overflow: hidden; position: relative; z-index: 10;}
				.promptMain_icon span{ display: block; position: absolute; z-index: 20; width:24px; height: 30px; background: url({$moduleurl}/jun/img/iconfont-xiangxia_03.png) center center no-repeat; background-size: 100% 100%; top: 10px; left: 50%; margin-left: -10px; animation: myAnimation .5s linear infinite; -webkit-animation: myAnimation .5s linear infinite; -moz-animation: myAnimation .5s linear infinite;}	
				@-webkit-keyframes myAnimation{
					0%{top: 10px;}
					50%{top: 20px;}
					100%{top: 10px;}
				}
				@keyframes myAnimation{
					0%{top: 10px;}
					50%{top: 20px;}
					100%{top: 10px;}
				}
				@-moz-keyframes myAnimation{
					0%{top: 10px;}
					50%{top: 20px;}
					100%{top: 10px;}
				}
				.prompt_btns{ width: 100%; height: auto; overflow: hidden;}
				.prompt_btns a{ width: 80%; height: 40px; text-align: center; line-height: 40px; display: block; overflow: hidden; background: {$color}; font-size: 14px; color: #fff; margin: 0px auto; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px;}
			</style>
			<div class='outer'>
				<div class='promptTop'>
					<span>
						<img src='{$img}' />
					</span>
					<p>{$txt}</p>
				</div>
				{$action}
			</div>			
		";
		die($html);
}