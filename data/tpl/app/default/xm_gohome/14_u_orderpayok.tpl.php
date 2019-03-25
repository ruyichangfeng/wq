<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div id="page0" class="ub ub-ver bga">
    <div class="ub-f1 ub ub-ac ub-pc ub-ver tx-c">
    	<div><i class="iconfont icon-icon4 t-gre1" style="font-size:5rem"></i> </div>
        <div class="umar-t1">付款提交成功</div>
        <div class="uinn8">去给服务人员评个分吧</div>
        <div class="uinn8 ub">
            <!--
            <a href="<?php  echo $url_order;?>" class="uba b-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem"><span class="ulev0 t-gre1">现在就去</span></a>
            <a href="<?php  echo $url_index;?>" class="uba b-gre1 ub ub-pc uc-a1 ub-f1 btnn" style=" margin-left:0.5em; margin-bottom:0.5em; padding:0.75rem 3rem"><span class="ulev0 t-gre1">回到主页</span></a>
            -->
            
            <a href="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&id=<?php  echo $order_id;?>&c=entry&do=order&foo=orderinfo&m=xm_gohome" class="uba b-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem"><span class="ulev0 t-gre1">评分</span></a>
            <a href="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=Index&m=xm_gohome" class="uba b-gre1 ub ub-pc uc-a1 ub-f1 btnn" style=" margin-left:0.5em; margin-bottom:0.5em; padding:0.75rem 3rem"><span class="ulev0 t-gre1">主页</span></a>
            
        </div>
    </div>
    <div class="" style="height:3.125rem"></div>
    
    <input type="hidden" id="order_id" value="<?php  echo $order_id;?>" >
    <input type="hidden" id="staff_id" value="<?php  echo $staff_id;?>" >
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
window.history.forward(1);

$(document).ready(function(){  
	var order_id = document.getElementById('order_id').value;
	var staff_id = document.getElementById('staff_id').value;
	
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('payok', array('foo'=>'getprintinfo'));?>",
		type:"POST",
		data:{"order_id":order_id,"staff_id":staff_id},
		dataType:"json",
		success: function(json){
			/*
			alert(json);
			alert(json.posturl);
			alert(json.app);
			alert(json.printer_sn);
			alert(json.key_info);
			alert(json.key_print);
			alert(json.pages);
			alert(json.xiaopiao);
			*/
			var data = {};
    		data['app'] 	  = json.app;
    		data['print_sn']  = json.printer_sn;
    		data['key'] 	  = json.key_info;
    		data['printkey']  = json.key_print;
    		data['pages'] 	  = json.pages;
    		data['printbody'] = json.xiaopiao;
			if(json != 0){
				$.ajax({
					url: json.posturl,
					type:"POST",
					data:data,
					dataType:"json",
					success: function(res){
						
					}
				});
			}
		}
	});
}); 
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
