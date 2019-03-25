<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
</head>
<body onLoad="checks()">
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div><i class="iconfont icon-ayiluru t-yel" style="font-size:5rem"></i> </div>
        <a href="" class="umar-t ulev1 t-yel">个人信息修改</a>
        <div class="absolute tx-c ulev-4 t-yel ubt b-bla01" style="left:0; bottom:0;width:100%; 

padding:0.5rem 0">请真实填写以下资料</div>
    </div>
    
    <div class="ub-f1">
        <form class="form-horizontal" id="form1" action="<?php  echo $this->createMobileUrl('staffedit',array('foo'=>'personeditok'))?>" method="post" onSubmit="return submit1()">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" >
        <div class="uinn8 umar-t1">
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:4.5rem" class="tx-r">
                        姓名
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="staff_name" id="staff_name" value="<?php  echo $item['staff_name'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
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
                                <input name="sex" type="radio" id="aa1" value="2" <?php  if($item['sex']==2) { ?> checked <?php  } ?>>
                                <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="aa1">女士<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                <input name="sex" type="radio" id="aa2" value="1" <?php  if($item['sex']==1) { ?> checked <?php  } ?>>
                                <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="aa2">先生<i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            常住地址
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <textarea class="uinn ulev0 ub-f1 block" name="text_" id="text_" placeholder="常住地址[点击右侧搜索]" readonly onClick="openPe()"><?php  echo $item['permanent'];?></textarea>
                                
                            </div>
                            
                            <div onClick="openPe()" id="adr_1" class="uc-a1 block btnn t-gre1"><i class="iconfont icon-sousuo15 ulev3"></i></div>
                            
                        </div>
                    </li>
                </ul>
                               
                <input type="hidden" name="jw" id="jw" placeholder="经纬度" class="uinn ulev0 ub-f1 block"  />
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem" class="tx-r">
                            开户银行
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="bank" id="bank" value="<?php  echo $item['bank'];?>" placeholder="持卡人必须为申请人" class="uinn ulev0 ub-f1 block" />
                            </div>
                            
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
                                <input type="tel" name="bank_num" id="bank_num" value="<?php  echo $item['bank_num'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
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
                                <input type="text" name="alipay" id="alipay" value="<?php  echo $item['alipay'];?>" placeholder="" class="uinn ulev0 ub-f1 block" />
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
                                <input type="text" id="avatar" name="avatar" placeholder="点击上传头像"  class="uinn ulev0 ub-f1 block" onClick="open_pic()" readonly />
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
                            <?php  if(strstr($item['avatar'],'images')) { ?>
                            <img id="img1" src="<?php  echo $_W['attachurl'];?><?php  echo $item['avatar'];?>" style="width:80px; height:50px;">
                            <?php  } else { ?>
                            <img id="img1" src="<?php  echo $_W['attachurl'];?>gohome/avatar/<?php  echo $item['avatar'];?>" style="width:80px; height:50px;">
                            <?php  } ?>
                                
                            </div>
                        </div>
                    </li>
                </ul>
                
                <input type="hidden" name="flag" value="<?php  echo $flag;?>" />
                
                <?php  if($flag != 1) { ?>
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:4.5rem;" class="tx-r">申请项目</div>
                        <div class="ub-f1 ubb ubl b-bla01 kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem ">
                        	<table class="table">
                                <?php  $n=0;?>
                                <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                                <?php  $n+=1;?>
                                <thead>
                                    <tr class="info">
                                        <th colspan="6">
                                            <input name="servetype[]" type="checkbox" id="hh<?php  echo $n;?>" value="<?php  echo $vo['id'];?>" <?php  if($vo['child_num'] != 0) { ?> disabled <?php  } ?> <?php  if(in_array($vo['id'],$servetype)) { ?> checked <?php  } ?>>
                                            <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="hh<?php  echo $n;?>"><?php  echo $vo['type_name'];?><i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                        </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="system_platform">
                                    <tr>
                                    <?php  $a=0;?>
                                    <?php  if(is_array($this->getCheckbox($vo['id']))) { foreach($this->getCheckbox($vo['id']) as $val) { ?>
                                    <?php  $a+=1;?>
                                        <td width="10px;">
                                        </td>
                                        <td>
                                            <input name="servetype[]" type="checkbox" id="<?php  echo $n;?>cc<?php  echo $a;?>" value="<?php  echo $val['id'];?>" <?php  if(in_array($val['id'],$servetype)) { ?> checked <?php  } ?>>
                                            <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" for="<?php  echo $n;?>cc<?php  echo $a;?>"><?php  echo $val['type_name'];?><i class="iconfont icon-dagouxuanzhong ulev0 t-org"></i></label>
                                        </td>
                                        <?php  if($a%3==0) echo '</tr><tr>';?>
                                    <?php  } } ?>
                                    </tr>
                                </tbody>
                                <?php  } } ?>
                            </table>
                            <div class="clear"></div>
                        </div>
                    </li>
                </ul>
                <?php  } ?>
		</div>

        <div class="uinn8 ub">
            <input name="submit" type="submit" value="下一步" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh" style="margin-bottom:0.5em; padding:0.75rem 3rem;" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" /> 
    	</div>
        </form>
    </div>
</div>
<div style="height:3.125rem"></div>

<div class="loginmask c-bla80"><!--map open-->
	<div class="ub mban ub-ver" style="width:100%; height:100%; top:1500px">
    	<div class="closealert ub-f1"></div>
        <div class="ub">
            <div class="ulev-1 tx-c uinn5 c-wh ub-f1">请拖动地图选定您需要服务的位置</div>
            <div class="closealert c-gra" style="padding:0.3rem 0.5rem"><i class="iconfont icon-guanbi ulev2 t-gra"></i></div>
        </div>
        <div class="c-org uinn t-wh tx-c ubb b-wh" id="centerDiv_1"></div>
        <div class="c-org uinn t-wh tx-c" id="centerDiv_2"></div>
        <div class="c-wh"  id="container_1" style="height:60%; "></div>
    </div>
</div>
    
<div class="c-blu" id="container" style="display:none;">
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script type="text/javascript">
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
	middleControl.innerHTML ='<img style="height:40px;"  src="<?php echo MODULE_URL;?>static/takeout/images/dddw.png" />';
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
						document.getElementById("img1").src = localIds;
					}
				});
			}
		});
	}
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
</script>

<script type="text/javascript">
function submit1(){
	var staff_name = document.getElementById('staff_name').value;
	//var card = document.getElementById('card').value;	
	//var staff_mobile = document.getElementById('staff_mobile').value;
	var address = document.getElementById('text_').value;
	//var jw = document.getElementById('jw').value;
	//var age = document.getElementById('age').value;
	//var year = document.getElementById('year').value;
	var bank = document.getElementById('bank').value;
	var bank_num = document.getElementById('bank_num').value;
	if(staff_name == ''){
		alert("请输入姓名");
		return false;
	}
	
	if(address == ''){
		alert("请输入常住地址");
		return false;
	}
	
	/*
	if(jw == ''){
		alert("请获取经纬度");
		return false;
	}
	*/
	
	/*
	if(bank == ''){
		alert("请输入开户银行");
		return false;
	}
	
	if(bank_num == ''){
		alert("请输入开户银行卡号");
		return false;
	}
	*/
	
}
</script>



<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>