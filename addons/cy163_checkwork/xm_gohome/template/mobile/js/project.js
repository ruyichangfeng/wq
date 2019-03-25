function init_1() {
	//平台、设备和操作系统 
    var system = {
		win: false, 
        mac: false, 
        xll: false, 
        ipad:false 
    }; 
    //检测平台 
    var p = navigator.platform; 
    system.win = p.indexOf("Win") == 0; 
    system.mac = p.indexOf("Mac") == 0; 
    system.x11 = (p == "X11") || (p.indexOf("Linux") == 0); 
    system.ipad = (navigator.userAgent.match(/iPad/i) != null)?true:false; 
    //跳转语句，如果是手机访问就自动跳转到wap.baidu.com页面 
    if (system.win || system.mac || system.xll||system.ipad) {
     	var lat_1 = document.getElementById('lat_v').value;
     	var lng_1 = document.getElementById('lng_v').value;
    } else {
		var lat_1 = localStorage['lat'];
		var lng_1 = localStorage['lng'];
		var fadr_1 = localStorage['fadr'];
    }
    document.getElementById('lat').value = lat_1;
	document.getElementById('lng').value = lng_1;
	document.getElementById('fadr').value = fadr_1;
}

window.addEventListener('message', function(event) {
	//接收位置信息，用户选择确认位置点后选点组件会触发该事件，回传用户的位置信息
    var loc = event.data;
	document.getElementById('lat').value = loc.latlng.lat;
	document.getElementById('lng').value = loc.latlng.lng;
	document.getElementById('fadr').value = loc.poiname + '（'+loc.poiaddress + '）';
	closePe()
}, false);

//弹出地图层
$(".closealert").click(function() {
	 $(".mban").animate({top:'1500px'})
	 $(".loginmask").fadeOut(500);
});

function openPe(){
	$(".loginmask").fadeIn(500), $(".mban").animate({top:'0px'});
};

function closePe(){
	$(".mban").animate({top:'1500px'})
	 $(".loginmask").fadeOut(500);
};

jssdkconfig = {php echo json_encode($_W['account']['jssdkconfig']);} || {};

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
	
//图片上传
function upload(){
	alert(1);
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
					var suiji = document.getElementById('random').value; 
						
					$.ajax({
						url: "{php echo $this->createMobileUrl('UploadPic', array());}",
						type:"POST",
						data:{"random":suiji,"serverId":serverId},
						dataType:"json",
						success: function(data){
							if(data== 0){
								alert('上传图片失败');
								return false;
							}else{
								var pic = "";
								var getstr = eval(data);
								for(var i=0;i<getstr.length;i++){
									pic = pic + '<li class="weui_uploader_file" style="background-image:url({$_W["attachurl"]}gohome/pic/'+getstr[i].pic+')" onclick="delpic('+getstr[i].id+')"></li>';
								}
								document.getElementById("pic_show").innerHTML = pic;
							}
						}
					});
				}
			});
		}
	});
}
	
	function delpic(a){
		if(window.confirm('确定删除该图片吗？')){
			var suiji = document.getElementById('random').value; 
			$.ajax({
				url: "{php echo $this->createMobileUrl('DeletePic', array());}",
				type:"POST",
				data:{"random":suiji,"id":a},
				dataType:"json",
				success: function(data){
					if(data== 0){
						alert('删除图片失败');
						return false;
					}else if(data == 1){
						document.getElementById("pic_show").innerHTML = '';
					}else{
						var pic = "";
						var getstr = eval(data);
						for(var i=0;i<getstr.length;i++){
							pic = pic + '<li class="weui_uploader_file" style="background-image:url({$_W["attachurl"]}gohome/pic/'+getstr[i].pic+')" onclick="delpic('+getstr[i].id+')"></li>';
						}
						document.getElementById("pic_show").innerHTML = pic;
					}
				}
			});
        }else{
			return false;
        }
	}