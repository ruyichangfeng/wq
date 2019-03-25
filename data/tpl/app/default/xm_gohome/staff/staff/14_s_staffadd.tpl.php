<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div><i class="iconfont icon-ayiluru t-yel" style="font-size:5rem"></i> </div>
        <div class="umar-t ulev1 t-yel">添加员工</div>
        <div class="absolute tx-c ulev-4 t-yel ubt b-bla01" style="left:0; bottom:0;width:100%; 

padding:0.5rem 0">请真实填写以下资料</div>
    </div>
    <div class="ub-f1">
    	<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="<?php  echo $this->createMobileUrl('staff',array('foo'=>'addok'))?>" method="post" onSubmit="return submit1()">
        
		<input type="hidden" name="openid" value="<?php  echo $item['openid'];?>" >
		<input type="hidden" name="company_name" value="<?php  echo $item['company_name'];?>" >
        <input type="hidden" name="stop" value="<?php  echo $item['stop'];?>" >
		
        <div class="uinn8 umar-t1 tx-c">
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-nan ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="staff_name" id="staff_name" placeholder="姓名" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-icon02 ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="card" id="card" placeholder="身份证号"  class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-phone ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="tel" name="staff_mobile" id="staff_mobile" placeholder="手机号" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-caikejilu ulev2 umar-r1 umar-l1 t-gre1"></i>
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
                        <div style="width:3.5rem">
                            <i class="iconfont icon-location ulev3 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <textarea class="uinn ulev0 ub-f1 block" name="text_" id="text_" placeholder="常住地址[点击右侧搜索]"></textarea>
                            </div>
                           
                            <div onClick="openPe()" id="adr_1" class="uc-a1 block btnn t-gre1"><i class="iconfont icon-sousuo15 ulev3"></i></div>
                            
                        </div>
                    </li>
                </ul>
                
                <input type="hidden" name="jw" id="jw" class="uinn ulev0 ub-f1 block" />
                
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-card ulev2 umar-r1 umar-l1 t-gre1"></i>
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
                    <div style="width:3.5rem">
                        <i class="iconfont icon-dianji ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="tel" name="year" id="year" placeholder="工龄[月数]" class="uinn ulev0 ub-f1 block" />
                        </div>
                        <span class="help-block">填入月数：12、24、</span>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:3.5rem">
                            <i class="iconfont icon-card ulev2 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="bank" id="bank" placeholder="开户银行" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block">持卡人必须为申请人</span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:3.5rem">
                            <i class="iconfont icon-dingzhipeisongyaoqiu ulev2 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="tel" name="bank_num" id="bank_num" placeholder="银行卡号" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:3.5rem">
                            <i class="iconfont icon-anquanbaozhang ulev2 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="alipay" id="alipay" placeholder="支付宝账号" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </li>
                </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-shangchuanzhuanzhangpingzheng ulev2 umar-r1 umar-l1 t-gre1"></i>
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
                    <div style="width:3.5rem">
                       
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
                        <div style="width:4rem; padding:0 1rem" class="tx-c t-gra ulev-1">申请项目</div>
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
                
    	</div>
        
        <div class="uinn8 ub">
        	<input name="submit" type="submit" value="下一步" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh" style="margin-bottom:0.5em; padding:0.75rem 3rem;" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            <!--            
            <button class="c-gre3 ub ub-pc uc-a1 ub-f1 btnn block" onClick="submit1()" style="margin-bottom:0.5em;padding:0.75rem 3rem" type="submit"><span class="ulev0 t-wh">下一步</span></button>
            -->
        </div>
        <div class="uinn8 ub" style="padding-top:0">
            <a href="<?php  echo $this->createMobileUrl('Validate',array())?>" class="uba b-gre1 t-gre1 ub ub-pc uc-a1 ub-f1 btnn" style="margin-bottom:0.5em; padding:0.75rem 3rem">返回</a>
        </div>
        </form>
    </div>
</div>

<div class="loginmask c-bla80"><!--map open-->
	<div class="ub mban ub-ver" style="width:100%; height:100%; top:1500px">
    	<div class="closealert ub-f1"></div>
        <div class="ub ub-ac">
            <div class="ulev-1 tx-c uinn5 c-wh ub-f1">请拖动地图选定您需要服务的位置</div>
            <div class="closealert c-gra ub uinn5 ulev-1" >确定</div>
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
		// 地图的中心地理坐标
		//center: new qq.maps.LatLng(39.916527, 116.397128),
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
						document.getElementById("img1").src = localIds;
					}
				});
			}
		});
	}
</script>

<script type="text/javascript">
function submit1(){
	var staff_name = document.getElementById('staff_name').value;
	var staff_mobile = document.getElementById('staff_mobile').value;	
	var address = document.getElementById('text_').value;
	var jw = document.getElementById('jw').value;
	var card = document.getElementById('card').value;	
	var age = document.getElementById('age').value;	
	var year = document.getElementById('year').value;	
			
	if(staff_name == ''){
		alert("请输入姓名");
		return false;
	}
	/*
	if(card == ''){
		alert("请输入身份证号");
		return false;
	}
	*/
	if(staff_mobile == ''){
		alert("请输入手机号码");
		return false;
	}
	if (!/^1[34578]{1}[0-9]{9}/.test(staff_mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	if(address == ''){
		alert("常住地址不能为空");
		return false;
	}
	if(age == ''){
		alert('请输入年龄');
		return false;
	}
	if(year == ''){
		alert('请输入工龄');
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

</script>

</html>