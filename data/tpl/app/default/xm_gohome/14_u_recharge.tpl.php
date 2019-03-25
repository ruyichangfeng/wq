<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div class="ub ub-ver bga page" id="page0"> 

  <div class="recharge">
    <div class="hd ub-f1 tx-c c-wh ubb b-bla01">
      <div class="ub ub-ver ub-ac ub-pc">
      <div class="ulev-4 ub-f1">可用余额</div>
      <div class="ulev3 font-b t-red1 ub-f1">￥<?php  echo $item['credit2'];?></div>
      
      </div>
    </div>
    <!--充值表单-->
    <form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="<?php  echo $this->createMobileUrl('recharge', array('foo'=>'rechargeok'))?>" method="post" onSubmit="return checkform()">
  	  <div class="bd">
  		  <div class="weui_cells weui_cells_form">
  		    <div class="weui_cell">
  		      <div class="weui_cell_hd">
  		        <label class="weui_label" style="width:4rem">金额</label>
  		      </div>
  		      <div class="weui_cell_bd weui_cell_primary">
  		        <input class="weui_input" type="text" name="money" id="money" placeholder="请输入金额[小数两位]">
  		      </div>
  		    </div>
  		  </div>
  	  	<div class="umar-b1 umar-l umar-r umar-t1">
  	  		<input name="submit" type="submit" value="充值" class="weui_btn weui_btn_primary pc_btn" />
              <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
  	  		<!--<a href="#" class="weui_btn weui_btn_primary pc_btn">充值</a>--> 
  	  	</div>
  	  </div>
    </form>	  
  </div>
  <!--手机端底部-->
  <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
  <!--手机端底部-->
  
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
function checkform(){
	var money = document.getElementById('money').value;	
				
	if(money == ''){
		alert("请输入充值金额");
		return false;
	}	
	if(money <= 0){
		alert("充值金额必须大于0");
		return false;
	}
  if (!/^\d{1,12}(?:\.\d{1,2})?$/.test(money)) {
      alert('充值金额格式不对！');
      return false;
  }		
}
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
