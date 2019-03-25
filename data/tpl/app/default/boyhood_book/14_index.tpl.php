<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?php  echo $rule['title'];?></title>
  <!-- Set render engine for 360 browser -->
  <meta name="renderer" content="webkit">
  <!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <!-- 下面是所用文件 -->
  <script src="<?php echo RES;?>js/jquery.js"></script>
  <script src="<?php echo RES;?>js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo RES;?>css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo RES;?>css/fangzi_list.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo RES;?>css/DateTimePicker.css" />
  <script type="text/javascript" src="<?php echo RES;?>js/DateTimePicker.js"></script>
  <style>
  pre{
  	margin: 0;
  	padding: 0;
	font-size: inherit;
	color: inherit;
	word-break: break-all;
	word-wrap: break-word;
	background-color: transparent;
	border: 0;
	border-radius: 0;
	line-height: inherit;
	font-family: '微软雅黑';
  }
  </style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="clearfix">
				<img class="col-xs-12" src="<?php  echo toimage($rule['thumb'])?>" />
			</div>
			<?php  if(is_array($list)) { foreach($list as $l) { ?>
			<div class="info-wrap clearfix">
				<a href="<?php  echo $this->createMobileUrl('img',array('lid'=>$l['id']))?>"><img src="<?php  echo toimage($l['thumb'])?>" /></a>
				<ul class="info">
					<li>
						<s>原价:￥<?php  echo number_format($l['oprice'],2)?></s>
						<a href="#" class="pull-right btn btn-golden" onclick="$('#lid').val('<?php  echo $l["id"];?>')" data-toggle="modal" data-target="#myModal">预定</a>
					</li>
					<li>
						特价:￥<?php  echo number_format($l['nprice'],2)?>
					</li>
					<li><pre><?php  echo $l['content'];?></pre></li>
				</ul>				
			</div>
			<?php  } } ?>
		</div>
	</div>
	<!-- Modal -->	
	<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
		<form method="post" action="<?php  echo $this->createMobileUrl('record',array('rid'=>$rid))?>">
			<input type="hidden" name="lid" id="lid">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">预约信息</h4>
			  </div>
			  <div class="modal-body">
				<ul class="form-list">
					<li><label>真实姓名:</label><input type="text" placeholder="请输入姓名" name="realname" required="required" /></li>
					<li><label>手机号码:</label><input type="tel" maxlength="11" placeholder="请输入手机号码" name="mobile" required="required" /></li>
					<li><label>预约人数:</label><input type="text" placeholder="请输入预约人数" name="num" required="required" /></li>
					<li><label>到访时间:</label><input type="text" placeholder="点击选择时间" data-field="datetime" name="visitetime" readonly><div id="dtBox"></div></li>
				</ul>
			  </div>
			  <div class="modal-footer">
				<a type="button" class="btn btn-default" data-dismiss="modal">取消</a>
				<button type="submit" class="btn btn-golden">确定</button>
			  </div>
			</div>
		</form>
	  </div>
	</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=boyhood_book"></script></body>
<script type="text/javascript">

$(document).ready(function(){
	$("#dtBox").DateTimePicker({
		dateFormat: "yyyy-MM-dd",
		dateTimeFormat: "yyyy-MM-dd HH:mm:ss",
		timeFormat: "HH:mm",
		shortDayNames: ["日", "一", "二", "三", "四", "五", "六"],
		fullDayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
		shortMonthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
		fullMonthNames:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],			
		titleContentDate: "设置日期",
		titleContentTime: "设置时间",
		titleContentDateTime: "设置日期和时间",					
		buttonsToDisplay: ["HeaderCloseButton", "SetButton", "ClearButton"],
		setButtonContent: "确定",
		clearButtonContent: "取消"
	});
});

</script>
</html>