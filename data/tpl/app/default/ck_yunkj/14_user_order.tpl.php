<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>服务项目进度查询 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
</head>
<body >
<!--分页-->
<link href="./resource/css/bootstrap.min.css" rel="stylesheet">
<!--分页-->
<style>
	.form-control_pp{width:180px;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}
	.tab_menu li a{ color:#666666; display:block;}
	.tab_menu .selected a{ color:#FFFFFF;}
</style>

<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $this->createMobileUrl('user_index')?>">
	 <em class="return"><</em>
	 <span class="fanhui">返回</span>
	</a>
	
	<!--搜索 start-->
	<div style="float:right;">
	<form action="./index.php" method="get" class="form-inline" role="form">
	<input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
	<input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
	<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
	<input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
	<input type="txt" class="form-control_pp" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键字">
	<input type="submit" class="btn btn-default" value="搜索">
	</form>
	</div>
	<!--搜索 end-->
   </div>
</div>

<div id="content">
  
   <div class="tab-bd clearFix" id="tab">
	   <ul class="tab_menu clearFix">
		<li <?php  if($_GPC['type']=='') { ?>class="selected"<?php  } ?>><a href="<?php  echo $urltk;?>">未处理</a></li>
		<li <?php  if($_GPC['type']=='1') { ?>class="selected"<?php  } ?>><a href="<?php  echo $urltk;?>&type=1">处理中</a></li>
		<li <?php  if($_GPC['type']=='2') { ?>class="selected"<?php  } ?>><a href="<?php  echo $urltk;?>&type=2">已完成</a></li>
	   </ul>
	   <div class="tab_box">
		  <div class="ser-orderlist">
		  
			  <ul class="orderlist">
				<?php  if(is_array($list)) { foreach($list as $key => $value) { ?>
				<li>
				   <div class="picbox">
				   <a href="<?php  echo $this->createMobileUrl('fw_show', array('id' => $value['sid']))?>" class="pic">
					<?php  if($value['imgurl']) { ?>
					<img src="<?php  echo tomedia($value['imgurl']);?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='缩略图片未上传.'" />
					<?php  } else { ?>
					<img src="../addons/<?php  echo $_GPC['m'];?>/template/no_image.gif" />
					<?php  } ?>
				   </a>
				   </div>
				  <div class="orderinfo">
					  <h3 class="htit"><?php  echo $value['titlename'];?></h3>
					  <p class="pinfo">
						<span>单价：￥<?php  echo $value['price'];?></span>
						<span>数量 <?php  echo $value['number'];?></span>
						<span>实收款</span>
						<span class="price">￥<?php  echo $value['paymoney'];?></span>
					  </p>
					  <p>买家：<?php  echo $value['compname'];?></p>
					  <p>
						状态：
						<?php  if($value['paystatus']) { ?>
							已付款，
							<?php  if($value['ygcomplete']) { ?>
								已完成，
								<?php  if($value['pjstate']) { ?>已评价
								<?php  } else { ?><font color="#CC0000">未评价</font>
								<?php  } ?>
							<?php  } else { ?>
								<?php  if($value['yguid']) { ?><font color="#006600">处理中...</font>
								<?php  } else { ?><font color="#CC0000">未被处理</font>
								<?php  } ?>
							<?php  } ?>
						<?php  } else { ?>
							<font color="#CC0000">未付款</font>
						<?php  } ?>
					  </p>
					  <p class="clearFix">
					   <a href="<?php  echo $urltk;?>&op=view&id=<?php  echo $value['id'];?>" class="btnpt btn-look">查看详情</a>
					   <?php  if($value['paystatus'] && $value['yguid']) { ?>
					   <a href="<?php  echo $urltk;?>&op=progress&id=<?php  echo $value['id'];?>" class="btnpt btn-du">进度管理</a>
					   <?php  } ?>
					   
					   <?php  if($value['paystatus']==0) { ?>
					   <a href="<?php  echo $this->createMobileUrl('fw_pay', array('orderid' => $value['id']))?>" class="btnpt btn-du">我要付款</a>
					   <a href="<?php  echo $urltk;?>&op=delete&id=<?php  echo $value['id'];?>" class="btnpt btn-du">删除</a>
					   <?php  } ?>
						
						<?php  if($value['paystatus'] && $value['ygcomplete'] && $value['pjstate']==0) { ?>
						<a href="<?php  echo $urltk;?>&op=wypj&id=<?php  echo $value['id'];?>" class="btnpt btn-du">我要评价</a>
						<?php  } ?>
						
					  </p>
				  </div>
				</li>
				<?php  } } ?>
			  </ul>
			  <div style="padding: 0 10px; text-align:center;">
				<style>
					.pagination {margin-top: 0px;}
				</style>
				<?php  echo $pager;?>
			  </div>
			 </div>
	   
	  </div>
  
	</div>
   
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('user_footer', TEMPLATE_INCLUDEPATH)) : (include template('user_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
