<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Kcfo7IHPvRA75sKRElGLaLNQ"></script>
</head>
<body>
<div id="page0" class="ub ub-ver bga">
	<div class="c-gre1 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem">
    	<div class="uc-a15 t-yel uba b-org absolute ulev-4" style="left:1rem; top:1rem; padding:0.2rem 0.5rem;">
            <?php  if($item['state'] == 0 || $item['state'] == 3) { ?>
            抢单中
            <?php  } else if($item['state'] == 1) { ?>
            成功抢单
            <?php  } else { ?>
            已完工
            <?php  } ?>
        </div>
        <div><i class="iconfont icon-dingdan t-org" style="font-size:5rem"></i> </div>
        <div class="umar-t ulev1 t-yel font-b"><?php  echo $this->getServeType($item['serve_type']);?></div>
    </div>
    
    <div class="c-gre1 ubt b-bla01">
        <div class="ub ub-ac uinn11">
        	<div class="tx-c" style="width:50%">
            	<div class="ulev-4 t-bla04">上门时间</div>
                <div class="t-yel"><span class="ulev-1"></span><span class="ulev1"> <?php  echo $this->getOrderTime($item['table_name'],$item['other_id'],'ftime')?></span></div>
            </div>
            <div class="ubl b-bla01 tx-c" style="width:50%">
            	<div class="ulev-4 t-bla04">预计费用</div>
                <div class="t-yel"><span class="ulev-1">￥</span><span class="ulev1"><?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'dealprice')?></span></div>
            </div>
        </div>
    </div>
    
    <div class="ub-f1 uinn8">
    	<div class="umar-b c-wh ub uinn11 uc-a15">
        	<div class="ub-f1 tx-c ulev-2">
            	<div class="t-gra">已预约</div>
                <div class="ub ub-ac" style="padding:0.2rem 0">
                    <div class="ub-f1"></div>
                    <div class="uc-a50 uba2 b-bla02">
                        <div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
                    </div>
                    <div class="ub-f1 ubb b-gra"></div>
                </div>
                <div class="t-gra"><?php  echo substr($this->getOrderTime($item['table_name'],$item['other_id'],'addtime'),0,11)?></div>
            </div>
            <div class="ub-f1 tx-c ulev-2">
            	<div class="t-gra">竞单中</div>
                <div class="ub ub-ac" style="padding:0.2rem 0">
                    <div class="ub-f1 ubb b-gra"></div>
                    <div class="uc-a50 uba2 b-bla02">
                        <div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
                    </div>
                    <div class="ub-f1 ubb b-gra"></div>
                </div>
                <div class="t-gra"><?php  echo substr($this->getGrabOneTime($item['id'],'addtime'),5,11)?></div>
            </div>
            <div class="ub-f1 tx-c ulev-2">
            	<div class="t-gra">选定人</div>
                <div class="ub ub-ac" style="padding:0.2rem 0">
                    <div class="ub-f1 ubb b-gra"></div>
                    <div class="uc-a50 uba2 b-bla02">
                        <div class="uc-a50 c-gra" style="height:0.5rem; width:0.5rem;"></div>
                    </div>
                    <div class="ub-f1 ubb b-gra"></div>
                </div>
                <div class="t-gra"><?php  echo substr($this->getGrabInfo($item['id'],'selectedtime'),5,11)?></div>
            </div>
            <div class="ub-f1 tx-c ulev-2">
            	<div class="t-gra">服务中</div>
                <div class="ub ub-ac" style="padding:0.2rem 0">
                    <div class="ub-f1 ubb b-gra"></div>
                    <div class="uc-a50 uba2 b-bla02">
                        <div class="uc-a50 <?php  if($item['state'] == 1) { ?> c-gre1 <?php  } else { ?> c-gra <?php  } ?>" style="height:0.5rem; width:0.5rem;"></div>
                    </div>
                    <div class="ub-f1 ubb b-gra"></div>
                </div>
                <?php  if($item['state'] == 1 || $item['state'] == 2) { ?>
                <div class="t-gra"><?php  echo substr($this->getOrderTime($item['table_name'],$item['other_id'],'ftime'),0,11)?></div>
                <?php  } ?>
            </div>
            <div class="ub-f1 tx-c ulev-2">
            	<div class="t-gra">已完工</div>
                <div class="ub ub-ac" style="padding:0.2rem 0">
                    <div class="ub-f1 ubb b-gra"></div>
                    <div class="uc-a50 uba2 b-bla02">
                        <div class="uc-a50 <?php  if($item['state'] == 2) { ?> c-gre1 <?php  } else { ?> c-gra <?php  } ?>" style="height:0.5rem; width:0.5rem;"></div>
                    </div>
                    <div class="ub-f1"></div>
                </div>
                <div class="t-gra"><?php  echo substr($this->getOrderOver($item['id'],'overtime'),5,11)?></div>
            </div>
        </div>
        
        <ul class="uc-a15 c-wh uinn3 ulev-1" style="">
        	<?php  if(is_array($list)) { foreach($list as $vo) { ?>
            <li class="uinn3 ubb-blaimg ub">
                <div class="tx-r uinn3 t-gra" style="width:4.5rem">
                <?php  if($vo['input_type'] == 'radio' || $vo['input_type'] == 'checkbox' || $vo['input_type'] == 'select') { ?>
                  <?php  if($this->getOrderInfoValue($item['table_name'],$item['other_id'],''.$vo[input_name].'',$item['temp_id']) != '') { ?>
                    <?php  echo $vo['input_laber'];?>
                  <?php  } ?>
                <?php  } else { ?>
                  <?php  if($this->getOrderInfo($item['table_name'],$item['other_id'],''.$vo[input_name].'') != '') { ?>
                    <?php  echo $vo['input_laber'];?>
                  <?php  } ?>
                <?php  } ?>
                </div>
                
                <div class="ub-f1 uinn3">
                <?php  if($vo['input_type'] == 'radio' || $vo['input_type'] == 'checkbox' || $vo['input_type'] == 'select') { ?>
                <?php  echo $this->getOrderInfoValue($item['table_name'],$item['other_id'],''.$vo[input_name].'',$item['temp_id'])?>
                <?php  } else { ?>
                <?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],''.$vo[input_name].'')?>
                <?php  } ?>
                </div>
            </li>
            <?php  } } ?>
        </ul>
        
        <?php  if($listpic['0']['pic'] != '') { ?>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
            
                <?php  if(is_array($listpic)) { foreach($listpic as $vopic) { ?>
                <div class="ub ub-ver ub-ac block"  style="padding:0.5rem 0.5rem 0.3rem 0.5rem">
                	<div onClick="showpic('<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $vopic['pic'];?>')" class="uc-a1 c-blu ub ub-ac ub-pc iconn ub-img1 hide" style=" width:3rem; height:3rem; background-image:url(<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $vopic['pic'];?>)">
                    </div>
                </div>
                <?php  } } ?>
                
                <?php  $img = ''?>
                <?php  if(is_array($listpic)) { foreach($listpic as $row) { ?>
                <?php  $img .= "'".$_W['attachurl']."gohome/pic/".$row['pic']."',"?>
                <?php  } } ?>
                <script type="text/javascript">
                function showpic(a){
					wx.previewImage({
                      current: a,
                      urls: [<?php  echo $img;?>]
                    });
                }
                </script>
        </ul>
        <?php  } ?>
        
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
                <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">我的报价</div>
                <div class="ub ub-ac ubb ubl b-bla01 uinn">
                    <div class="ub ulev0 ub-f1 uinn">
                    	<?php  if($offer == '') { ?>
                    		0
                    	<?php  } else { ?>
                    		<?php  echo $offer;?>
                    	<?php  } ?>
                    </div>
                </div>
            </li>
        </ul>
        
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
                <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">接单人员</div>
                <div class="ub ub-ac ubb ubl b-bla01 uinn">
                    <div class="ub ulev0 ub-f1 uinn"><?php  echo $this->getStaffInfo($staff_id,'staff_name')?></div>
                </div>
            </li>
        </ul>
        
        <?php  if($listimg['0']['pic'] != '') { ?>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
            	<div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">报价图片</div>
                <div class="ub-f1 ubl b-bla01 uinn">
	                <?php  if(is_array($listimg)) { foreach($listimg as $voimg) { ?>
	                <div class="ufl"  style="width:25%">
	                	<div onClick="showimg('<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $voimg['pic'];?>')" class="uc-a1 c-blu ub ub-ac ub-pc iconn ub-img1 hide" style=" width:3rem; height:3rem; background-image:url(<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $voimg['pic'];?>); margin:0.5rem 0.5rem 0.3rem 0.5rem">
	                    </div>
	                </div>
	                <?php  } } ?>
                </div>
                
                <?php  $img1 = ''?>
                <?php  if(is_array($listimg)) { foreach($listimg as $row) { ?>
                <?php  $img1 .= "'".$_W['attachurl']."gohome/pic/".$row['pic']."',"?>
                <?php  } } ?>
                <script type="text/javascript">
                function showimg(a){
					wx.previewImage({
                      current: a,
                      urls: [<?php  echo $img1;?>]
                    });
                }
                </script> 
        </ul>
    	<?php  } ?>
    	
    	<?php  if($item_g['remark'] != '') { ?>
	    <ul class="userlist c-wh umar-t ubb ubt b-bla01">
	      <li class="ub ub-ac">
	        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">报价说明</div>
	        <div class="ub ub-f1 ub-ac ubl b-bla01 uinn">
	          <div class="ub ulev0 ub-f1 ">
	          	<textarea name="remark" id="remark" rows="3" class="uinn ulev-1 ub-f1 block uc-a15" style="width:6rem" readonly><?php  echo $item_g['remark'];?></textarea>
	          </div>
	        </div>
	      </li>
	    </ul>
	    <?php  } ?>
        
        <?php  if($item['state'] == 2) { ?>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
                <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">成交价格</div>
                <div class="ub ub-ac ubb ubl b-bla01 uinn">
                    <div class="ub ulev0 ub-f1 uinn"><?php  echo $this->getPayMoney($item['id'])?></div>
                </div>
                <div class="ulev-1 t-gra">
                元
                </div>
            </li>
        </ul>
        <?php  } ?>
        
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
                <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">客户姓名</div>
                <div class="ub ub-ac ubb ubl b-bla01 uinn">
                    <div class="ub ulev0 ub-f1 uinn"><?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fname')?></div>
                </div>
                <!--
                <div class="ulev-1 t-gra">
                <?php  if($this->getOrderInfo($item['table_name'],$item['other_id'],'fsex') == 1) { ?>先生<?php  } else { ?>女士<?php  } ?>
                </div>
                -->
            </li>
        </ul>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
                <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">客户电话</div>
                <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                    <div class="ub ulev0 ub-f1 uinn"><?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fmobile')?></div>
                </div>
                <div class="uinn">
                	<a href="tel:<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fmobile')?>" class="block uba b-gre1 ulev-4 t-gre1 uc-a15" style="padding:0.2rem 0.5rem">呼叫</a>
                </div>
            </li>
        </ul>
        <ul class="userlist c-wh uc-a15 umar-t">
            <li class="ub ub-ac">
                <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">详细地址</div>
                <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                    <div class="ub ulev-1 ub-f1 uinn"><?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fadr')?></div>
                </div>
                <!--<input type="hidden" id="adr" value="<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fadr')?>" >
                <div onClick="getMap()" class="uc-a1 block btnn t-gre1" style=""><i class="iconfont icon-dingweiicon01 ulev3"></i></div>-->
                <div class="uinn">
                    <a href="http://map.baidu.com/mobile/webapp/place/linesearch/foo=bar/from=place&end=word=<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fadr')?>&uid=&tab=line"class="block uba b-gre1 ulev-4 t-gre1 uc-a15" style="padding:0.2rem 0.5rem">导航
                    </a>
                </div>
            </li>
        </ul>
    </div> 
    <div class="" style="height:4.125rem"></div>
    <div id="footer" class="fix0 c-foot" style="width:100%; bottom:0; z-index:999">
        <div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('Validate', array())?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-shouye ulev1"></i> 
                    <span class="block ulev-1" style="">首页</span>
                </div>
            </a>
            <div class="ub ub-pc block t-gre1 t-wh" style="width:33.33%">
                    <?php  if($isCheck['suremoney'] == '') { ?>
                    	<div onClick="openPe()" class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba2 b-bla02 t-yel block" style="height:4rem; width:4rem; top:-1.125rem">
                            <i class="iconfont icon-iconfontdianeps ulev2"></i> 
                            <span class="block ulev-1" style=""><?php  echo $diyyes;?></span>
                        </div>
                    <?php  } else { ?>
                        <div class="ub ub-ver uc-a50 c-gre3 ub-ac ub-pc uba2 b-bla02 t-yel block" style="height:4rem; width:4rem; top:-1.125rem">
                            <i class="iconfont icon-succeed-dd ulev2"></i> 
                            <span class="block ulev-1" style="">成功</span>
                        </div>
                    <?php  } ?>
            </div>
            <a href ="<?php  echo $this->createMobileUrl('Stafforder', array())?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-dingdan ulev1"></i> 
                    <span class="block ulev-1" style="">订单</span>
                </div>
            </a>
        </div>
    </div>
	
	<div class="loginmask c-bla80"><!--支付弹出-->
        <div class="ub ub-ac ub-pc mban" style="width:100%; height:100%;top:-800px">
            <div class="c-wh uc-a15 ub ub-ver" style="height:80%; width:90%;">
                <div class="absolute c-wh uc-a100 uinn3" style="top:-2.1rem; left:50%; margin-left:-2.1rem; z-index:2">
                    <div class="uc-a100 c-gre1 t-yel tx-c" style="width:4rem; height:4rem;">
                        <i class="iconfont icon-succeed-dd" style=" font-size:2rem; line-height:4rem;"></i> 
                    </div>
                </div>
                <div class=" bga uc-t15" style="padding-bottom:1rem;">
                    <div class="ub" style="height:2.5rem">
                        <div class="ub-f1"></div>
                        <div class="closealert"  style="padding:0.3rem 0.5rem"><i class="iconfont icon-guanbi ulev2 t-gra"></i></div>
                    </div>
                    <div class="tx-c font-b">确认价格</div>
                </div>
                <form action="<?php  echo $this->createMobileUrl('stafforder',array('foo'=>'priceok'))?>" method="post" onSubmit="return checkfrom()">
				<input type="hidden" name="sorder_id" value="<?php  echo $item['id'];?>" />
                <div class="uinn8">
                    <div class="tx-c uinn11 ubb b-bla01 ulev-1 t-gra">请确认实际结算金额</div>
                    <ul class="userlist c-wh uc-a15 umar-t">
                        <li class="ub ub-ac">
                            <!--<div style="min-width:3rem; padding:0 1rem" class="tx-c t-gra ulev-1">我的报价</div>-->
                            <div class="ub-f1"></div>
                            <div class="ub ub-f1 ub-ac uinn">
                                <div class="tx-r" style="">￥</div>
                                <div class="ub ulev0 ub-f1 uba b-gre1 uc-a15">
                                    <input type="tel" name="suremoney" id="suremoney" placeholder="成交价格" value="<?php  echo $offer;?>" class="uinn ulev2 ub-f1 block t-gre1 uc-a15" style="width:5rem" />
                                </div>
                            </div>
                            <div class="ub-f1"></div>
                        </li>
                    </ul>
                    <div class="uinn8 ub">
       
                          
                                <input name="submit" type="submit" value="确认" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh" style="margin-bottom:0.5em; padding:0.75rem 1rem;" />
                                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                     
                     
                    </div>
                    
                </div> 
                </form>           
                <div class="ub-f1"></div>
            </div>
        </div>
    </div>
    
</div>

<input type="hidden" id="order_id" value="<?php  echo $item['id'];?>" />
<input type="hidden" id="serve_type" value="<?php  echo $item['serve_type'];?>" />

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>


<script type="text/javascript">
$(".closealert").click(function() {
	 $(".mban").animate({top:'-800px'})
	 $(".loginmask").fadeOut(500);
});

function openPe(){
	$(".loginmask").fadeIn(500), $(".mban").animate({top:'0px'})
}

function getMap(){
	var adr = document.getElementById('adr').value;
	localStorage['adr'] = adr;
	window.location.href = "<?php  echo $this->createMobileUrl('map', array('name'=>'xm_gohome'))?>";	
}

function checkfrom(){
	var suremoney = document.getElementById('suremoney').value;
	if(suremoney == ''){
		alert('请输入成交价格！');
		return false;
	}
}
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
