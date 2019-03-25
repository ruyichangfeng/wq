function init_1() {
	//平台、设备和操作系统 
	var system = {
		win: false,
		mac: false,
		xll: false,
		ipad: false
	};
	//检测平台 
	var p = navigator.platform;
	system.win = p.indexOf("Win") == 0;
	system.mac = p.indexOf("Mac") == 0;
	system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);
	system.ipad = (navigator.userAgent.match(/iPad/i) != null) ? true : false;
	//跳转语句，如果是手机访问就自动跳转到wap.baidu.com页面 
	if (system.win || system.mac || system.xll || system.ipad) {
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
	document.getElementById('fadr').value = loc.poiname + '（' + loc.poiaddress + '）';
	closePe()
}, false);



//弹出地图层
$(".closealert").click(function() {
	$(".mban").animate({
		top: '1500px'
	})
	$(".loginmask").fadeOut(500);
});

function openPe() {
	$(".loginmask").fadeIn(500), $(".mban").animate({
		top: '0px'
	});
};

function closePe() {
	$(".mban").animate({
		top: '1500px'
	})
	$(".loginmask").fadeOut(500);
};

/*
function upload() {
	wx.chooseImage({
		count: 1,
		sizeType: ["original", "compressed"],
		sourceType: ["album", "camera"],
		success: function(res) {
			var localIds = res.localIds;
			wx.uploadImage({
				localId: "" + localIds + "",
				isShowProgressTips: 1,
				success: function(res) {
					var serverId = res.serverId;
					var suiji = document.getElementById("random").value;
					$.ajax({
						url: document.getElementById("picurl").value,
						type: "POST",
						data: {
							"random": suiji,
							"serverId": serverId
						},
						dataType: "json",
						success: function(data) {
							if (data == 0) {
								alert("上传图片失败");
							} else {
								var pic = "";
								var getstr = eval(data);
								for (var i = 0; i < getstr.length; i++) {
									pic = pic + "<li class=weui_uploader_file style=background-image:url({attachur}gohome/pic/" + getstr[i].pic + ") onclick=delpic(" + getstr[i].id + ")></li>";
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

function delpic(a) {
	if (window.confirm("确定删除该图片吗？")) {
		var suiji = document.getElementById("random").value;
		$.ajax({
			url: document.getElementById("delpic").value,
			type: "POST",
			data: {
				"random": suiji,
				"id": a
			},
			dataType: "json",
			success: function(data) {
				if (data == 0) {
					alert("删除图片失败");
					return false;
				} else if (data == 1) {
					document.getElementById("pic_show").innerHTML = "";
				} else {
					var pic = "";
					var getstr = eval(data);
					for (var i = 0; i < getstr.length; i++) {
						pic = pic + "<li class=weui_uploader_file style=background-image:url({attachur}gohome/pic/" + getstr[i].pic + ")  onclick=delpic(" + getstr[i].id + ")></li>";
					}
					document.getElementById("pic_show").innerHTML = pic;
				}
			}
		});
	} else {
		return false;
	}
}
*/