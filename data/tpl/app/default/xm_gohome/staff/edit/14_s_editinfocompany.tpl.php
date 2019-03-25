<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div><i class="iconfont icon-tuandui1 t-yel" style="font-size:5rem"></i> </div>
        <div class="umar-t ulev1 t-yel">公司信息修改申请</div>
        <div class="absolute tx-c ulev-4 t-bla04 ubt b-bla01" style="left:0; bottom:0;width:100%; 

padding:0.5rem 0">请真实填写以下资料</div>
    </div>
    <div class="ub-f1">
    	<!--<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="javascript:;" method="post">-->
        <form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="<?php  echo $this->createMobileUrl('staffedit', array('foo'=>'companyeditok'))?>" method="post" onSubmit="return submit1()">
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>" >
        <div class="uinn8 umar-t1 tx-c">
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        公司名称
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="company_name" id="company_name" placeholder="" value="<?php  echo $item['company_name'];?>" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        联系电话
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="contact" id="contact" value="<?php  echo $item['contact'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        公司地址
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="address" id="address" value="<?php  echo $item['address'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        负责人
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="staff_name" id="staff_name" value="<?php  echo $item['staff_name'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <!--
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-location ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="staff_mobile" id="staff_mobile" value="<?php  echo $item['staff_mobile'];?>" placeholder="负责人手机号码" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            -->
            
            <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem">
                            开户银行
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="bank" id="bank" value="<?php  echo $item['bank'];?>" placeholder="持卡人必须为申请人" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem">
                            银行卡号
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="bank_num" id="bank_num" value="<?php  echo $item['bank_num'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem">
                            支付宝
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="alipay" id="alipay" value="<?php  echo $item['alipay'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                          
    	</div>
       
        
        <div class="uinn8 ub ub-f1">
            <input name="submit" type="submit" value="提交" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh" style="margin-bottom:0.5em; padding:0.75rem 3rem;" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
    	</div>
        
        </form>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
function submit1(){
	var company_name = document.getElementById('company_name').value;
	var contact = document.getElementById('contact').value;	
	var address = document.getElementById('address').value;
	var staff_name = document.getElementById('staff_name').value;
	var staff_mobile = document.getElementById('staff_mobile').value;
	//var license = document.getElementById('license').value;
	//var license_pic = document.getElementById('license_pic').value;
			
	if(company_name == ''){
		alert("请输入公司名称");
		return false;
	}
	if(contact == ''){
		alert("请输入联系电话");
		return false;
	}
	if(address == ''){
		alert("请输入公司地址");
		return false;
	}
	if(address == ''){
		alert("请输入公司地址");
		return false;
	}
	if(staff_name == ''){
		alert("请输入公司负责人");
		return false;
	}
	if(staff_mobile == ''){
		alert("请输入公司负责人手机号码");
		return false;
	}
}

</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>