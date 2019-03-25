<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
<script src="<?php echo MODULE_URL;?>static/takeout/js/jquery-1.10.2.min.js"></script> 
<script src="<?php echo MODULE_URL;?>static/takeout/js/jquery.superslide.2.1.1.js"></script> 
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
</head>
<body onLoad="checks()">
<div id="page0" class="ub ub-ver bga min-h100">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div><i class="iconfont icon-ayiluru t-yel" style="font-size:5rem"></i> </div>
        <a href="" class="umar-t ulev1 t-yel">个人加盟申请</a>
        <div class="absolute tx-c ulev-4 t-yel ubt b-bla01" style="left:0; bottom:0;width:100%; 

padding:0.5rem 0">请真实填写以下资料</div>
    </div>
    
    <div class="ub-f1">
        <form class="form-horizontal" id="form1" action="<?php  echo $this->createMobileUrl('staffreg',array('foo'=>'staffRegOk'))?>" method="post" onSubmit="return submit1()">
        <div class="uinn8 umar-t1">
            <div class="uinn tx-c ulev1"><i class="iconfont icon-yonghuxinxi t-org ulev2"></i>基本信息</div>
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem" class="tx-r">
                        姓名
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="staff_name" id="staff_name" placeholder="" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            身份证号
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="card" id="card" placeholder=""  class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            性别
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem ">
                                <input name="sex" type="radio" id="aa1" value="2" checked>
                                <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="aa1">女士<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                <input name="sex" type="radio" id="aa2" value="1">
                                <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="aa2">先生<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            年龄
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="age" id="age" placeholder="年龄" class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>
                </ul> 
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            开户银行
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="bank" id="bank" placeholder="持卡人必须为申请人" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            银行卡号
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="bank_num" id="bank_num" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            支付宝
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="alipay" id="alipay" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            上传头像
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" placeholder="点击上传头像"  class="uinn ulev0 ub-f1 block" onClick="open_pic()" readonly />
								<input type="hidden" id="avatar" name="avatar" >
                            </div>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                           
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <img id="img" src="" style="width:80px; height:50px;">
                            </div>
                        </div>
                    </li>
                </ul>  
                <ul class="userlist c-wh uc-a15 umar-b">
					<li class="ub ub-ac">
						<div style="width:4.5rem">
							手机号码
						</div>
						<div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
							<div class="ub ulev0 ub-f1 ">
								<input type="tel" name="staff_mobile" id="staff_mobile" placeholder="" class="uinn ulev0 ub-f1 block" />
							</div>
						</div>
					</li>
				</ul> 
				
                <input type="hidden" id="sauthen" name="sauthen" value="<?php  echo $sauthen;?>" >
                
                <?php  if($sauthen == 1) { ?>
				<ul class="userlist c-wh uc-a15 umar-b">
					<li class="ub ub-ac">
						<div style="width:4.5rem">
							<i class="iconfont icon-nan ulev2 umar-r1 umar-l1 t-gre1"></i>
						</div>
						<div class="ub-f1 ub ub-ac ubb ubl b-bla01 uinn">
							<div class="ub ulev0 ub-f1 ">
								<input type="tel" name="code" id="code" placeholder="输入获取的验证码" class="uinn ulev0 block ub-f1" style="" />
							</div>
						</div>
						<div id="on" class="kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem " onClick="getCode()">
							<input type="button" id="btn" class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" value="免费获取验证码" />  
							<div class="clear"></div>
						</div>
					</li>
				</ul>
                <?php  } ?>
                <div class="slideTxtBox">
                
                <div class="hd umar-b">
                    <ul class="tx-c ulev1">
                        <li class="uinn11">
                            <span onClick="lei(1)"><i class="iconfont icon-jifenduihuan ulev2"></i>申请项目</span>
                        </li>
                        <li class="uinn11">
                            <span onClick="lei(2)"><i class="iconfont icon-shouye ulev2"></i>申请店铺</span>
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="leixing1" id="leixing1" value="1" >
                <input type="hidden" name="leixing2" id="leixing2" value="0" >
                <div class="bd">

                <ul class="userlist ">

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            常住地址
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <textarea class="uinn ulev0 ub-f1 block" name="text_" id="text_" placeholder="[点击右侧搜索]" readonly onClick="openPe()"></textarea>
                            </div>
                                
                            <div onClick="openPe()" id="adr_1" class="uc-a1 block btnn t-gre1"><i class="iconfont icon-sousuo15 ulev3"></i></div>
                                
                        </div>
                    </li>
                    
                    <input type="hidden" name="jw" id="jw" placeholder="经纬度" class="uinn ulev0 ub-f1 block"  />
                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            工龄
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="year" id="year" placeholder="[月数]" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block">填入月数</span>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem;" class="tx-r">申请项目</div>
                        <div class="ub-f1 ubb ubl b-bla01 kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem ">
                            <table class="table">
                                <?php  $n=0;?>
                                <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                                <?php  $n+=1;?>
                                <thead>
                                    <tr class="info">
                                        <th colspan="6">
                                            <input name="servetype[]" type="checkbox" id="hh<?php  echo $n;?>" value="<?php  echo $vo['id'];?>" <?php  if($vo['child_num'] != 0) { ?> disabled <?php  } ?>>
                                            <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="hh<?php  echo $n;?>"><?php  echo $vo['type_name'];?><i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                        </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="system_platform">
                                    
                                    <?php  $a=0;?>
                                    <?php  if(is_array($this->getCheckbox($vo['id']))) { foreach($this->getCheckbox($vo['id']) as $val) { ?>
                                    <?php  $a+=1;?>
                                    <tr>
                                        <td width="10px;">
                                        </td>
                                        <td>
                                            <input name="servetype[]" type="checkbox" id="<?php  echo $n;?>cc<?php  echo $a;?>" value="<?php  echo $val['id'];?>">
                                            <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="<?php  echo $n;?>cc<?php  echo $a;?>"><?php  echo $val['type_name'];?><i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                        </td>
                                        
                                    </tr>
                                    <?php  } } ?>
                                    
                                </tbody>
                                <?php  } } ?>
                            </table>
                            <div class="clear"></div>
                        </div>
                    </li>
                </ul>

                <ul class="userlist">
                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            商铺名称
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="merchant_name" id="merchant_name" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            所属地区
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <select name="adr_id" id="adr_id" class="uinn ulev0 ub-f1 block">
                                    <option value="">选择所属地区</option>
                                    <?php  if(is_array($list1)) { foreach($list1 as $vo1) { ?>
                                    <option value="<?php  echo $vo1['id'];?>"><?php  echo $vo1['adr_name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            所属商圈
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <select name="lido_id" id="lido_id" class="uinn ulev0 ub-f1 block">
                                    <option value="">选择所属商圈</option>
                                    <option value="0">无商圈</option>
                                    <?php  if(is_array($list2)) { foreach($list2 as $vo2) { ?>
                                    <option value="<?php  echo $vo2['id'];?>"><?php  echo $vo2['lido_name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            行业类别
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <select name="type_id" id="type_id" class="uinn ulev0 ub-f1 block">
                                    <option value="">选择行业类别</option>
                                    <?php  if(is_array($list3)) { foreach($list3 as $vo3) { ?>
                                    <option value="<?php  echo $vo3['id'];?>"><?php  echo $vo3['type_name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            商铺地址
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <textarea class="uinn ulev0 ub-f1 block" name="text1_" id="text1_" placeholder="[点击右侧搜索]" readonly onClick="openPe()"></textarea>
                            </div>
                                
                            <div onClick="openPe()" id="adr_1" class="uc-a1 block btnn t-gre1"><i class="iconfont icon-sousuo15 ulev3"></i></div>
                        </div>
                    </li>
                    <input type="hidden" name="jw1" id="jw1" placeholder="经纬度" class="uinn ulev0 ub-f1 block"  />
                    
                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem">
                            <i class="iconfont icon-shangchuanzhuanzhangpingzheng ulev2 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <img id="img1" src="" style="height:4rem;">
                            </div>
                        </div>
                        <div class="uinn uba b-gre1 uc-a15 ulev-4 umar-r t-gre1" onClick="open_pic1()">上传Logo</div>
                    </li>
                    <input type="hidden" name="coverpic" id="coverpic" value="">

                   
                        <li class="ub ub-ac c-wh uc-a15 umar-b">
                            <div style="width:4.5rem" class="tx-r">
                                联系电话
                            </div>
                            <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                                <div class="ub ulev0 ub-f1 ">
                                    <input type="tel" name="merchant_phone" id="merchant_phone" placeholder="" class="uinn ulev0 ub-f1 block" />
                                </div>
                            </div>
                        </li>

                    <ul class="userlist c-wh uc-a15 umar-b">
                        <li class="ub ub-ac">
                            <div style="width:4.5rem" class="tx-r">
                                    启动外链
                            </div>
                            <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                                <div class="kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem ">
                                    <input name="chao" type="radio" id="bb1" value="1" <?php  if($item['chao'] == 1) { ?> checked="" <?php  } ?>>
                                    <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="bb1">是<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                    <input name="chao" type="radio" id="bb2" value="0" <?php  if($item['chao'] == 1) { ?> checked="" <?php  } ?>>
                                    <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="bb2">否<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </li>
                    </ul>

                   
                    <ul class="userlist c-wh uc-a15 umar-b">
                        <li class="ub ub-ac">
                            <div style="width:4.5rem" class="tx-r">
                                外链地址
                            </div>
                            <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                                <div class="ub ulev0 ub-f1 ">
                                    <input type="text" name="chao_url" id="chao_url" value="<?php  echo $item['chao_url'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
                                </div>
                            </div>
                        </li>
                    </ul>
                        
                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            配送时间
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="merchant_time" id="merchant_time" placeholder="配送时间" class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            起送价格
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="merchant_price" id="merchant_price" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                            配送费
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="merchant_song" id="merchant_song" placeholder="" class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem" class="tx-r">
                                宵夜
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem ">
                                <input name="night" type="radio" id="cc1" value="1" checked>
                                <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="cc1">有<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                <input name="night" type="radio" id="cc2" value="0">
                                <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="cc2">没有<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem">
                          执照号码
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="license" id="license" placeholder="执照号或信用码"  class="uinn ulev0 ub-f1 block" />
                            </div>
                        </div>
                    </li>

                    <li class="ub ub-ac c-wh uc-a15 umar-b">
                        <div style="width:4.5rem">
                            <i class="iconfont icon-shangchuanzhuanzhangpingzheng ulev2 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <img id="img2" src="" style="height:4rem;">
                            </div>
                        </div>
                        <div class="uinn uba b-gre1 uc-a15 ulev-4 umar-r t-gre1" onClick="open_pic2()">上传证照</div>
                    </li>
                    <input type="hidden" name="license_pic" id="license_pic" value="">

                </ul>
              </div> 
			</div>
			<script type="text/javascript">jQuery(".slideTxtBox").slide({});</script>
            
            <ul class="userlist c-wh uc-a15 umar-b">
				<li class="ub ub-ac ff-check uinn">
					<input name="xieyi" type="checkbox" id="xieyi" value="1">
                    <label class="block" for="xieyi">
                        <i class="iconfont icon-zhengque32pt1 ulev2" onClick="check_xieyi()"></i>
                        <span class="umar-l ulev-1">我已阅读并同意
                            <a href="<?php  echo $this->createMobileUrl('staffreg', array('foo'=>'xieyi', 'type'=>1))?>">个人加盟协议</a>
                        </span>
                    </label>
				</li>
			</ul>
		</div>
        <div class="uinn8 ub-f1" id="show1" style="display:none;">
           <input name="submit" type="submit" value="提交" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh ub-fh" style="margin-bottom:0.5em; padding:0.75rem 3rem;" />
		</div>

        <div class="uinn8 ub-f1" id="show2" style="display:block;">
            <span class="c-gra ub-f1 uc-a1 block tx-c t-wh ub-fh" style="margin-bottom:0.5em; padding:0.75rem 3rem;">提交</span>
        </div>
        </form>
    </div>

</div>

<div class="loginmask c-bla80"><!--map open-->
	<div class="ub mban ub-ver" style="width:100%; height:100%; top:1500px">
    	<div class="closealert ub-f1"></div>
        <div class="ub ub-ac">
            <div class="ulev-1 tx-c uinn5 c-wh ub-f1">请拖动地图选定您需要服务的位置</div>
            <div class="closealert c-gra ub uinn5 ulev-1">确定</div>
        </div>
        <div class="c-org uinn t-wh tx-c ubb b-wh" id="centerDiv_1"></div>
        <div class="c-org uinn t-wh tx-c" id="centerDiv_2"></div>
        <div class="c-wh"  id="container_1" style="height:60%; "></div>
    </div>
</div>
    
<div class="c-blu" id="container" style="display:none;">
</div>


<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script type="text/javascript">
var HEIGHT = $('body').height();
        $(window).resize(function() {
            $('.page').height(HEIGHT);
        });
function getLocation(){
	//判断是否支持 获取本地位置
	if(navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(showPosition);
    }else{
		x.innerHTML="浏览器不支持定位.";
	}
}

function showPosition(position) {
	var lat_1 =position.coords.latitude; 
	var lng_1 =position.coords.longitude;
	//div容器
	var container_1 = document.getElementById("container_1");
	var centerDiv = document.getElementById("centerDiv_1");
	var centerDiv2 = document.getElementById("centerDiv_2");
	//初始化地图
	var map = new qq.maps.Map(container_1, {
		center: new qq.maps.LatLng(lat_1,lng_1),
		zoom: 16
	});
    //创建自定义控件
    var middleControl = document.createElement("div");
	middleControl.style.left="50%";
	middleControl.style.top="50%";
	middleControl.style.position="relative";
	middleControl.style.width="40px";
	middleControl.style.height="40px";
	middleControl.style.margin="-40px 0 0 -20px";
	middleControl.style.zIndex="100000";
    //middleControl.innerHTML ='<img src="https://www.cdlhome.com.sg/mobile_assets/images/icon-location.png" />';
	middleControl.innerHTML ='<img style="height:40px;" src="<?php echo MODULE_URL;?>static/takeout/images/dddw.png" />';
    document.getElementById("container_1").appendChild(middleControl);
	//返回地图当前中心点地理坐标
		centerDiv_1.innerHTML = "坐标:" + map.getCenter();
		var geocoder = new qq.maps.Geocoder();
		var latLng = new qq.maps.LatLng(map.getCenter().getLat(), map.getCenter().getLng());
        geocoder.getAddress(latLng);
		geocoder.setComplete(function(result) {
			centerDiv_2.innerHTML = "位置:" + result.detail.address;
        	//document.getElementById('jw').value = map.getCenter().getLng()+','+map.getCenter().getLat();
			//document.getElementById('text_').value = result.detail.address;
        });
	//当地图中心属性更改时触发事件
	qq.maps.event.addListener(map, 'center_changed', function() {
		centerDiv_1.innerHTML = "坐标:" + map.getCenter();
		var geocoder = new qq.maps.Geocoder();
		var latLng = new qq.maps.LatLng(map.getCenter().getLat(), map.getCenter().getLng());
        geocoder.getAddress(latLng);
		geocoder.setComplete(function(result) {
			centerDiv_2.innerHTML = "位置:" + result.detail.address;
        	document.getElementById('jw').value = map.getCenter().getLng()+','+map.getCenter().getLat();
			document.getElementById('text_').value = result.detail.address;

            document.getElementById('jw1').value = map.getCenter().getLng()+','+map.getCenter().getLat();
            document.getElementById('text1_').value = result.detail.address;
        });
	});
	
}

//弹出地图层
$(".closealert").click(function() {
	 $(".mban").animate({top:'1500px'})
	 $(".loginmask").fadeOut(500);
});
function openPe(){
	$(".loginmask").fadeIn(500), $(".mban").animate({top:'0px'});
};
</script>

<script type="text/javascript">
$(document).ready(function(){
	 getLocation();
});
</script>

<script type="text/javascript">
	jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || {};
	
	// 是否启用调试
	jssdkconfig.debug = false;
	
	jssdkconfig.jsApiList = [
		'checkJsApi',
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'chooseImage',
		'previewImage',
		'uploadImage',
		'downloadImage',
		'openLocation',
		'getLocation',
	];
	
	wx.config(jssdkconfig);
	
	wx.ready(function () {
		
	});
	
	//添加图片
	function open_pic(){
		wx.chooseImage({
			count: 1, // 默认9
			sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function (res) {
				var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				wx.uploadImage({
					localId: ''+localIds+'', // 需要上传的图片的本地ID，由chooseImage接口获得
					isShowProgressTips: 1, // 默认为1，显示进度提示
					success: function (res) {
						var serverId = res.serverId; // 返回图片的服务器端ID
						//var pic_url = "";
						document.getElementById('avatar').value = serverId;
						document.getElementById("img").src = localIds;
					}
				});
			}
		});
	}

    function open_pic1(){
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                wx.uploadImage({
                    localId: ''+localIds+'', // 需要上传的图片的本地ID，由chooseImage接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        var serverId = res.serverId; // 返回图片的服务器端ID
                        //var pic_url = "";
                        document.getElementById('coverpic').value = serverId;
                        document.getElementById("img1").src = localIds;
                    }
                });
            }
        });
    }

    function open_pic2(){
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                wx.uploadImage({
                    localId: ''+localIds+'', // 需要上传的图片的本地ID，由chooseImage接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        var serverId = res.serverId; // 返回图片的服务器端ID
                        //var pic_url = "";
                        document.getElementById('license_pic').value = serverId;
                        document.getElementById("img2").src = localIds;
                    }
                });
            }
        });
    }
</script>

<script type="text/javascript">
function submit1(){
	var staff_name = document.getElementById('staff_name').value;
	var card = document.getElementById('card').value;	
	var age = document.getElementById('age').value;
	
	var bank = document.getElementById('bank').value;
	var bank_num = document.getElementById('bank_num').value;
	var staff_mobile = document.getElementById('staff_mobile').value;
	var sauthen = document.getElementById('sauthen').value;
	var leixing1 = $("#leixing1").val();
    var leixing2 = $("#leixing2").val();

	if(staff_name == ''){
		alert("请输入姓名");
		return false;
	}
	
	if(card == ''){
		alert("请输入身份证号");
		return false;
	}
	
	if(card.length != 18){
		alert('身份证格式错误');
		return false;
	}
	
	if(age == ''){
		alert("请输入年龄");
		return false;
	}

    if(staff_mobile == ''){
        alert("请输入手机号码");
        return false;
    }
    
    if (!/^1[34578]{1}[0-9]{9}/.test(staff_mobile)) {
        alert('请输入正确的手机号码！');
        return false;
    }
    
    if(sauthen == 1){
        var code = document.getElementById('code').value;
        if(code == ''){
            alert('请输入验证码！');
            return false;
        }
    }
	
    if(leixing1 == 1){
        var address = document.getElementById('text_').value;
        var year = document.getElementById('year').value;
        if(address == ''){
            alert("请输入常住地址");
            return false;
        }

        if(year == ''){
            alert("请输入工龄");
            return false;
        }
        
        var str=document.getElementsByName("servetype[]");
        var objarray=str.length;
        var chestr="";
        for (i=0;i<objarray;i++)
        {
            if(str[i].checked == true)
            {
                chestr+=str[i].value+",";
            }
        }
                    
        if(chestr == "")
        {
            alert("请先选择申请项目！");
            return false;
        }
    }

    if(leixing2 == 1){
        var merchant_name = $("#merchant_name").val();
        var adr_id        = $("#adr_id").val();
        var type_id       = $("#type_id").val();
        var address1      = $("#text1_").val();
        var merchant_phone= $("#merchant_phone").val();
        var merchant_time = $("#merchant_time").val();
        var merchant_price= $("#merchant_price").val();
        var merchant_song = $("#merchant_song").val();

        if(merchant_name == ''){
            alert("请输入商铺名称");
            return false;
        }
        if(adr_id == ''){
            alert("请选择所属地区");
            return false;
        }
        if(type_id == ''){
            alert("请选择行业类别");
            return false;
        }
        if(address == ''){
            alert("商铺地址不能为空");
            return false;
        }
        if(merchant_phone == ''){
            alert("联系电话不能为空");
            return false;
        }
        if(merchant_time == ''){
            alert("配送时间不能为空");
            return false;
        }
        if(merchant_price == ''){
            alert("起送价格不能为空");
            return false;
        }
        /*
        if(merchant_song == ''){
            alert("配送费不能为空");
            return false;
        }
        */
    }
	
}

function getCode(){
	var mobile = document.getElementById('staff_mobile').value;
	if(mobile == ''){
		alert('请输入手机号码！');
		return false;
	}
	if (!/^1[34578]{1}[0-9]{9}/.test(mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('CodeOk', array());?>",
		type:"POST",
		data:{'mobile':mobile,'type':2},
		dataType:"json",
		success: function(res){

			if(res==1){
				var wait = "<?php  echo $timeout;?>";
				time(wait); 
				//document.getElementById('lable_text').innerHTML = '已发送';
				//document.getElementById('on').onclick = function(){}; 
			}else{
				alert('验证码发送失败！请重试');
				return false;
			}
		}
	});
}

function time(wait) {  
       if (wait == 0) {  
            document.getElementById("btn").removeAttribute("disabled");            
            document.getElementById("btn").value="免费获取验证码";  
            wait = <?php  echo $timeout;?>;  
        } else {  
            document.getElementById("btn").setAttribute("disabled", true);  
            document.getElementById("btn").value="重新发送(" + wait + ")";  
            wait--;  
            setTimeout(function() {  
                time(wait)  
            },  
            1000)  
        }  
    } 

function lei(id){
    if(id == 1){
        $("#leixing1").val(1);
        $("#leixing2").val(0);
    }else{
        $("#leixing1").val(0);
        $("#leixing2").val(1);
    }
}

function check_xieyi(){
    if(document.getElementById("xieyi").checked){
        $("#show1").css('display','none');
        $("#show2").css('display','block');
    }else{
        $("#show1").css('display','block');
        $("#show2").css('display','none');
    }
}

</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>