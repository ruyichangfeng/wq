<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>代记账查询 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
</head>
<body >
<div class="head">
	<div class="content-top clearFix">
    <a href="<?php  echo $this->createMobileUrl('user_index')?>">
	 <em class="return"><</em>
	 <span class="fanhui">返回</span>
	</a>
   </div>
</div>

<div id="content02">
  
  <div class="news-list-bd">
	  <form action="./index.php" method="get" class="form-inline" role="form">
	  <input type="hidden" name="i" value="<?php  echo $_GPC['i'];?>">
	  <input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
	  <input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
	  <input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
	  <input type="hidden" name="op" value="search">
      <div class="tally-top clearFix">
	     <div class="timesele">
		    <select name="years" class="select">
                <?php  echo $yearhtml;?>
            </select>
		 </div>
		 <div class="timesele">
		    <select name="month" class="select">
               <?php  echo $monthhtml;?>
            </select>
		 </div>
		 <input type="submit" name="search_submit" value="查 询" class="look-btn" style="border:0px;">
	   </div>
	   </form>
	   <div class="tally-comnent">
	      <h3 class="htit"><?php  echo $years;?> - <?php  echo $month;?></h3>
		  <?php  if($srdb) { ?>
		  <div class="ptxt">
		  	<?php  for($i=1;$i<=30;$i++):?>
			<?php  $config_key='a'.$i;$msg_key='message'.$i;?>
			<?php  if($cwgl_config[$config_key]) { ?>
			<p><?php  echo $cwgl_config[$config_key];?>：<font class="red"><?php  echo $srdb[$msg_key];?></font></p>
			<?php  } ?>
			<?php  endfor;?>
		  </div>
		  
		  <?php  } else { ?>
		  <div class="baosui">
			 <P class="sptxt" style="margin-top:15px; text-align:center; color:#FF6600;">未找到相应信息！</P>
		  </div>
		  <?php  } ?>
	   </div>
    
	 </div>
</div>

<!--footer star-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('user_footer', TEMPLATE_INCLUDEPATH)) : (include template('user_footer', TEMPLATE_INCLUDEPATH));?>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
