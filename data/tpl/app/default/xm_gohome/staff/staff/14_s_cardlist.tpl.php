<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div class="umar-t ulev1 t-yel">提交证件</div>
        <div class="absolute tx-c ulev-4 t-yel ubt b-bla01" style="left:0; bottom:0;width:100%; padding:0.5rem 0">有效证件能提高抢单成功率与审核通过率</div>
    </div>
    <div class="ub-f1">
    	<div class="uinn ulev-1 t-gra tx-c">已上传证件</div>
        <?php  if($item['license_pic'] != '') { ?>
        <ul class="ub-f1 uinn8 c-wh">
            <div class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem 0">
                <div class="ub-f1 ub ub-ver" style=" padding:0.3rem 0.5rem">
                    <div class="ub ub-ac">
                        <div class="ulev-4 t-sbla">执照号码:<?php  echo $item['license'];?></div>
                    </div>
                    <div class="ulev-4 t-gra" style="padding:0.3rem 0">
                        <?php  if(substr($item['license_pic'],0,6) == 'images') { ?>
                            <a href="<?php  echo $_W['attachurl'];?><?php  echo $item['license_pic'];?>">
                                <img src="<?php  echo $_W['attachurl'];?><?php  echo $item['license_pic'];?>" style="width:80px; height:40px;">
                            </a>
                        <?php  } else { ?>
                            <a href="<?php  echo $_W['attachurl'];?>gohome/license/<?php  echo $item['license_pic'];?>">
                                <img src="<?php  echo $_W['attachurl'];?>gohome/license/<?php  echo $item['license_pic'];?>" style="width:80px; height:40px;">
                            </a>    
                        <?php  } ?>
                    </div>
                </div>
            </div>
        </ul>
        <?php  } ?>

        <?php  if($list[0]['id'] == '') { ?>
            <?php  if($mark != 1) { ?>
                <div class="tx-c">未上传证件照片</div>
            <?php  } ?>
        <?php  } else { ?>
			<?php  if(is_array($list)) { foreach($list as $vo) { ?>
			<ul class="ub-f1 uinn8 c-wh">
					<div class="uba b-bla01 uc-a15 ub ub-ac umar-b" style="padding:0.2rem 0">
						<div class="ub-f1 ub ub-ver" style=" padding:0.3rem 0.5rem">
								<div class="ub ub-ac">
									<div class="ulev-4 t-sbla"><?php  echo $vo['card_name'];?></div>
								</div>
								<div class="ulev-4 t-gra" style="padding:0.3rem 0">
									<?php  if(substr($vo['pic1'],0,6) == 'images') { ?>
                                    <a href="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic1'];?>">
                                    	<img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic1'];?>" style="width:80px; height:40px;">
                                    </a>
                                    <?php  } else { ?>
                                    <a href="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic1'];?>">
                                    	<img src="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic1'];?>" style="width:80px; height:40px;">
                                    </a>    
                                    <?php  } ?>
                                    
                                    <?php  if($vo['pic2'] != '') { ?>
                                        <?php  if(substr($vo['pic2'],0,6) == 'images') { ?>
                                        <a href="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic2'];?>">
                                        	<img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic2'];?>" style="width:80px; height:40px;">
                                        </a>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic2'];?>">
                                        	<img src="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic2'];?>" style="width:80px; height:40px;">
                                        </a>
                                        <?php  } ?>
                                    <?php  } ?>
                                    
                                    <?php  if($vo['pic3'] != '') { ?>
                                        <?php  if(substr($vo['pic3'],0,6) == 'images') { ?>
                                        <a href="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic3'];?>">
                                        	<img src="<?php  echo $_W['attachurl'];?><?php  echo $vo['pic3'];?>" style="width:80px; height:40px;">
                                        </a>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic3'];?>">
                                        	<img src="<?php  echo $_W['attachurl'];?>gohome/cardpic/<?php  echo $vo['pic3'];?>" style="width:80px; height:40px;">
                                        </a>
                                        <?php  } ?>
                                    <?php  } ?>
								</div>
							</div>
					</div>
			</ul>
			<?php  } } ?>
		<?php  } ?>
    </div>
    
    <div class="ub-f1">
        <?php  if($mark == 1) { ?>
            <div class="uinn ulev-1 t-gra tx-l umar-t1">
            你是公司加盟，请上传公司相关证件照片
            </div>
        <?php  } else { ?>
            <?php  if($this->getStaffPro($id) != '') { ?>
        	<div class="uinn ulev-1 t-gra tx-l umar-t1">
                你选择了:<?php  echo $this->getStaffPro($id)?>
                <br/>
                需要上传:<?php  echo $this->getProCard($id)?>
            </div>
            <?php  } ?>
        <?php  } ?>
    </div>
     
    <div class="ub-f1">
    	<div class="uinn ulev-1 t-gra tx-c umar-t1">添加证件照片</div>
        <form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="<?php  echo $this->createMobileUrl('staff',array('foo'=>'cardaddok'))?>" method="post" onsubmit="return submit1()">
        <input type="hidden" name="staff_id" value="<?php  echo $id;?>" >

        <div class="uinn8 tx-c" style="padding-top:0">
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        证件名称
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="card_name" id="card_name" placeholder="证件名称" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        照片1
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" onClick="upload(1)" placeholder="点击上传照片" class="uinn ulev0 ub-f1 block" readonly />
							<input type="hidden" name="pic1" id="pic1">
                        </div>
                    </div>
                </li>
            </ul>
			
			<ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem">
                           
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <img id="img1" src="" style="width:80px; height:50px;">
                            </div>
                        </div>
                    </li>
                </ul> 
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        照片2
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text"  onClick="upload(2)" placeholder="点击上传照片" class="uinn ulev0 ub-f1 block" readonly />
							<input type="hidden" name="pic2" id="pic2">
                        </div>
                    </div>
                </li>
            </ul>
			
			<ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem">
                           
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <img id="img2" src="" style="width:80px; height:50px;">
                            </div>
                        </div>
                    </li>
                </ul> 
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem">
                        照片3
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" onClick="upload(3)" placeholder="点击上传照片" class="uinn ulev0 ub-f1 block" readonly />
							<input type="hidden" name="pic3" id="pic3"> 
                        </div>
                    </div>
                </li>
            </ul>
			
			<ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem">
                           
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <img id="img3" src="" style="width:80px; height:50px;">
                            </div>
                        </div>
                    </li>
                </ul> 
    	</div>
        <div class="uinn8 ub">
        	<input name="submit" type="submit" value="提交" class="c-gre3 ulev0 uc-a1 ub-f1 btnn block t-wh" style="margin-bottom:0.5em; padding:0.75rem 3rem" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
        
        <div class="uinn8 ub" style="padding-top:0">
        	<a href="<?php  echo $this->createMobileUrl('Validate',array())?>" class="uba b-gre1 t-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem">返回</a>
        </div>
        </form>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<script type="text/javascript">
	jssdkconfig = <?php  echo json_encode($_W['account']['jssdkconfig']);?> || {};
	
	// 是否启用调试
	jssdkconfig.debug = false;
	
	jssdkconfig.jsApiList = [
		'checkJsApi',
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
	
	//获取当前地理位置
	function upload(id){
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
						var id_name = "pic"+id;
						var id_name1 = "img"+id;
						document.getElementById(''+id_name+'').value = serverId;
						document.getElementById(''+id_name1+'').src = localIds;
					}
				});
			}
		});
	}
</script>

<script type="text/javascript">
function submit1(){
	var card_name = document.getElementById('card_name').value;	
	var pic1 = document.getElementById('pic1').value;	
				
	if(card_name == ''){
		alert("请输入证件名称");
		return false;
	}
	if(pic1 == ''){
		alert("请上传一张图片,且必须为照片1");
		return false;
	}
}
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
