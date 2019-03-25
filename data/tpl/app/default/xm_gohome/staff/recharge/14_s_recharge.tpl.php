<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div><i class="iconfont icon-licaishouyi t-yel" style="font-size:5rem"></i> </div>
        <div class="umar-t ulev1 t-yel">余额充值</div>
        
    </div>
    <div class="ub-f1">
    	<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="<?php  echo $this->createMobileUrl('staffrecharge', array('foo'=>'ok'))?>" method="post" onSubmit="return checkform()">
        <input type="hidden" name="staff_id" id="staff_id" value="<?php  echo $id;?>">

        <div class="uinn8 umar-t1 tx-c">
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-licaishouyi ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="money" id="money" placeholder="充值金额" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
    	</div>
        <div class="uinn8 ub">
            <input name="submit" type="submit" value="充值" class="c-gre3 uc-a1 ub-f1 btnn block t-wh ulev0" style="padding:0.75rem 3rem" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
        </form>
    </div>
    
    <div class="" style="height:3.125rem"></div>
    <div id="footer" class="fix0 c-foot" style="width:100%; bottom:0; z-index:999">
        <div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('Validate', array())?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-shouye ulev1"></i> 
                    <span class="block ulev-1" style="">首页</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('stafforder', array('foo'=>'order1', 'id'=>$id))?>" class="ub ub-pc block t-gre1 t-wh" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-dingdan ulev1 t-gre1"></i> 
                    <span class="block ulev-1 t-gre1" style="">订单</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('staffmoney', array('foo'=>'index', 'id'=>$id))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-licaishouyi ulev1"></i> 
                    <span class="block ulev-1" style="">财务</span>
                </div>
            </a>
        </div>
    </div>
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
function checkform(){
	var money = document.getElementById('money').value;			
	if(money == ''){
		alert("请输入充值金额");
		return false;
	}
    if(money<= 0){
        alert("充值金额必须大于0！");
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
