<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>

<div class="ub ub-ver bga page" id="page0">  
  <!--充值表单-->
  <div class="ub-f1 form_box">
  	<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="javascript:;" method="post">
  	<div class="bd c-wh">
  		<div class="ub-f1 font-b ulev2 tx-c ub-ac ub-pc" style="padding-top:1rem">修改信息</div>
  		<div class="weui_cells weui_cells_form  ulev-1">
  			<div class="weui_cell">
  				<div class="weui_cell_hd">
		        	<label class="weui_label" style="width:3rem">姓名：</label>
  				</div>
  				<div class="weui_cell_bd weui_cell_primary">
  					<input class="weui_input" type="text" name="realname" id="realname" placeholder="真实姓名" value="<?php  echo $item['realname'];?>">
  				</div>
  			</div>
  			<div class="weui_cell">
  				<div class="weui_cell_hd">
  					<label class="weui_label" style="width:3rem">地址：</label>
  				</div>
  				<div class="weui_cell_bd weui_cell_primary">
  					<input class="weui_input" type="text" name="residecity" id="residecity" placeholder="县/镇/市" value="<?php  echo $item['residecity'];?>">
  				</div>
      			<div class="weui_cell_ft"></div>
  			</div>
		    <div class="weui_cell">
			    <div class="weui_cell_hd">
			    	<label class="weui_label" style="width:3rem">楼栋：</label>
			    </div>
			    <div class="weui_cell_bd weui_cell_primary">
			        <input class="weui_input" type="text" name="residedist" id="residedist" placeholder="详细地址" value="<?php  echo $item['residedist'];?>">
			    </div>
			    <div class="weui_cell_ft"> </div>
		    </div>
           
  	</div>
  	<div class="umar-b1 umar-l umar-r umar-t1 pc_btn">
  		<div onClick="submit1()" class="weui_btn weui_btn_primary">提交</div>
  	</div>
    
  	</form>
  </div>
  
  <!--手机端底部-->
  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  <!--手机端底部-->
 
  
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
function submit1(){
	var realname   = document.getElementById('realname').value;
	var residecity = document.getElementById('residecity').value;
	var residedist = document.getElementById('residedist').value;
				
	if(realname == ''){
		alert('请输入真实姓名');
		return false;
	}			
			
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('myinfo', array('foo'=>'editinfook'));?>",
		type:"POST",
		data:{"realname":realname,"residecity":residecity,"residedist":residedist},
		dataType:"json",
		success: function(res){
			if(res == "1"){
				alert('修改信息成功！');
				window.location.href = "<?php  echo $this->createMobileUrl('myinfo', array('foo'=>'index'))?>"; 
			}else{
				alert('对不起,修改信息失败！'); 
				return false;
			}
		}
	});		
}
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
