//获取url中在参数
$.para = {
	set: function (para, value) {
		return this._set(window.location.href, para, value);
	},
	get: function (para) {
		return this._get(window.location.href, para);
	},
	remove: function (para) {
		return this._remove(window.location.href, para);
	},
	_set: function (url, para, value) {
		url = this._remove(url, para);
		var paras = para + "=" + value;
		var v = this.get(url, para);
		var _url = "";
		if (v == "") {
			if (url.substring(url.length - 1) == "?") {
				_url = url + paras;
			} else {
				_url = url + (url.indexOf("?") == -1 ? "?" : "&") + paras;
			}
		} else {
			_url = url.replace("&" + para + "=" + v, "&" + paras);
			_url = _url.replace("?" + para + "=" + v, "?" + paras);
		}
		return _url;
	},
	_get: function (url, para) {
		var value = "",
			_p = para + "=";
		var url = url.split("#!")[0] || "";
		if (url.indexOf("&" + _p) > -1) {
			value = url.split("&" + _p)[1].split("&")[0];
		}
		if (url.indexOf("?" + _p) > -1) {
			value = url.split("?" + _p)[1].split("&")[0];
		}
		if (url.indexOf("#" > -1)) {
			value = value.split("#")[0];
		}
		return value;
	},
	_remove: function (url, para) {
		if (!para) {
			return url;
		}
		var v = this._get(url, para);
		if (url.indexOf('&' + para + '=' + v) > -1) {
			url = url.replace('&' + para + '=' + v, '');
		} else if (url.indexOf('?' + para + '=' + v + '&') > -1) {
			url = url.replace(para + '=' + v + '&', '');
		} else {
			url = url.replace('?' + para + '=' + v, '');
		}
		return url;
	}
}

//替换
$.replace = function (temp, data, regexp) {
	if (!(Object.prototype.toString.call(data) === "[object Array]")) data = [data];
	var ret = [];
	for (var i = 0, j = data.length; i < j; i++) {
		ret.push(replaceAction(data[i]));
	}
	return ret.join("");

	function replaceAction(object) {
		return temp.replace(regexp || (/\\?\{([^}]+)\}/g), function (match, name) {
			if (match.charAt(0) == '\\') return match.slice(1);
			return (object[name] != undefined) ? object[name] : '';
		});
	}
};

//触屏点击（无延迟）
$.fn.ontouch = function (callback, bool) {
	var _x, _y, _s,
		_t = {
			s: function (event) {
				var t = getTouch(event);
				_x = t.clientX;
				_y = t.clientY;
				_s = true;
			},
			m: function (event) {
				if (_s) {
					var t = getTouch(event);
					if (_x != t.clientX || _y != t.clientY) {
						_s = false;
					}
				}
			},
			e: function (event) {
				if (_s) {
					callback.call(this);
					if (bool) {
						event.preventDefault();
						return false;
					}
				}
			}
		};

	function getTouch(event) {
		return event.originalEvent.touches[0] ? event.originalEvent.touches[0] : event;
	};

	this.bind({
		"touchstart": _t.s,
		"touchmove": _t.m,
		"touchend": _t.e
	});
	return this;
};

//触屏滑动切换：支持水平、垂直方向滑动，通过回调方法反馈业务结果
function touchTab(op) {
	this.stopMove = false;
	var that = this,
		status, start, client, dateOld,
		pct = op.pct || 20,
		touchClient = op.type ? "clientX" : "clientY",
		maxLength = op.maxLength || $(window).height(),
		getTouch = function (event) {
			return event.originalEvent.targetTouches && event.originalEvent.targetTouches[0];
		},
		touchMoev = {
			//开始
			start: function (event) {
				//重置
				client = 0;
				//滑动激活
				status = true;
				//记录开始时间
				dateOld = new Date();
				//记录初始坐标
				start = getTouch(event)[touchClient];
				op.startCallback && op.startCallback.call(op.obj, event);
			},
			//移动
			move: function (event) {
				var _y = getTouch(event)[touchClient] - start;
				if (status && !that.stopMove) {
					client = parseInt(_y / maxLength * 100);
					op.moveCallback && op.moveCallback.call(op.obj, _y, client);
					// console.log("滑动进度：" + client + "%");
				}
				if (!that.stopMove) {
					event.stopPropagation();
					event.preventDefault();
				}
			},
			//结束
			end: function (event) {
				var _re = 0,
					_client = client > 0 ? client : -(client),
					nd = new Date() - dateOld;
				//滑动激活
				if (status && !that.stopMove) {
					if (_client >= pct || (nd < 300 && _client >= pct / 2)) {
						if (client > 0) {
							_re = 1;
						} else {
							_re = 0;
						}
					} else {
						_re = 2;
						console.log("放弃切换");
					}
					op.endCallback && op.endCallback.call(op.obj, _re);
					status = false;
				}
				// event.stopPropagation();
				// event.preventDefault();
			}
		};

	op.obj.bind({
		"touchstart": touchMoev.start,
		"touchmove": touchMoev.move,
		"touchend": touchMoev.end
	});
};

//翻页：支持上下左右四个方向，使用css3处理动画过渡
function pageCore(op) {
	//定义基础参数配置
	var that = this,
		//场景预置
		scene = {
			"x": 0,
			"y": 0,
			"now": {}
		},
		sceneArr = [],
		sceneIndex = 0;

	for (var k in op) {
		if (op[k]) {
			sceneArr.push(k);
			scene[k] = op[k];
		}
	}

	this.getSceneName = function () {
		return scene.now.name || "";
	};

	this.next = function (type, callback) {
		var _index = sceneIndex + 1;
		if (_index < sceneArr.length) {
			this.tabScene(sceneArr[_index], type, callback);
		}
	};

	this.prev = function (type, callback) {
		var _index = sceneIndex - 1;
		if (_index >= 0) {
			this.tabScene(sceneArr[_index], type, callback);
		}
	};

	this.replay = function (type, callback) {
		this.tabScene(sceneArr[0], type, callback);
	};

	this.goto = function (index, type, callback) {
		this.tabScene(sceneArr[index], type, callback);
	};

	this.length = function () {
		return sceneArr.length;
	};

	this.index = function () {
		return sceneIndex;
	};

	//切换场景
	this.tabScene = function (name, type, callback) {
		if (name && typeof name === "string" && name in scene) {

			var tab = {
				"top": ["top", "↑"],
				"bottom": ["bottom", "↓"],
				"left": ["left", "→"],
				"right": ["right", "←"],
				"fade": ["fade", "淡入淡出"],
				"tab": ["tab", "普通切换"]
			};

			TabSceneAn(name, tab[type][0], callback);

			for (var i = 0; i < sceneArr.length; i++) {
				if (sceneArr[i] == name) {
					sceneIndex = i;
				}
			}

		}
	};

	//切换场景过程动画
	function TabSceneAn(name, type, callback) {
		var obj = scene[name].obj;

		if (scene.now && scene.now.name == name) {
			return false;
		}

		switch (type) {
			case "left":
				scene.x = 100;
				scene.y = 0;
				break;
			case "right":
				scene.x = -100;
				scene.y = 0;
				break;
			case "top":
				scene.y = -100;
				scene.x = 0;
				break;
			case "bottom":
				scene.y = 100;
				scene.x = 0;
				break;
			default:
				scene.x = 0;
				scene.y = 0;
		}

		obj.removeClass("transition").css({
			"-webkit-transform": "translate3d(" + scene.x + "%," + scene.y + "%,0)"
		});

		if (type == "fade") {
			obj.css({
				"opacity": "0",
				"pointer-events": "none"
			});
		} else if (type == "tab") {
			obj.css({
				"display": "none",
				"pointer-events": "none"
			});
		}

		setTimeout(function () {

			if (scene.now.name) {
				var _now = scene.now.name;
				obj.one("webkitTransitionEnd", function () {
					callback && callback(this, scene[_now].obj);
					scene[_now].obj.removeClass('transition');
					console.log("切换场景：" + scene[name].name, type);
				});
				// setTimeout(function(){
				obj.addClass(" transition show").css({
					"opacity": "1",
					"pointer-events": "auto",
					"-webkit-transform": "translate3d(0,0,0)"
				});
				// },100);
				if (type == "fade") {
					obj.css({
						"opacity": "1",
						"pointer-events": "auto"
					});
					scene[scene.now.name].obj.css({
						"opacity": "0",
						"pointer-events": "none"
					});
				} else if (type == "tab") {
					obj.css({
						"display": "block",
						"pointer-events": "auto"
					});
					scene[scene.now.name].obj.css({
						"display": "none",
						"pointer-events": "none"
					});
				}
				scene[scene.now.name].obj.removeClass("show").css({
					"-webkit-transform": "translate3d(" + -scene.x + "%," + -scene.y + "%,0)"
				});
			} else {
				if (type == "fade") {
					obj.css({
						"opacity": "1",
						"pointer-events": "auto"
					});
				} else if (type == "tab") {
					obj.css({
						"display": "block",
						"pointer-events": "auto"
					});
				}
				obj.css("-webkit-transform", "translate3d(0,0,0)");
				// setTimeout(function(){
				obj.addClass("transition show");
				callback && callback();
				console.log("切换场景：" + scene[name].name, type);
				// });
			}
			scene.now = {
				"name": name,
				"type": type
			};

		}, 100);
	};
};

//音乐载入&播放
var musicReady = false;

function setMusic(op) {
	var that = this,
		$music = document.createElement("audio");
	//获取audio对象
	this.getAudio = function () {
		return $music;
	};
	//开始播放
	this.play = function () {
		if ($music && ($music.paused || $music.ended)) {
			$music.play();
			if (!$music.paused) {
				musicReady = true;
				op.musicbox && op.musicbox.show().removeClass("music-paused");
			}
		}
	};
	//循环播放
	this.loopPlay = function () {
		$music.setAttribute("loop", true);
		this.play();
	};
	//结束播放
	this.stop = function () {
		op.musicbox && op.musicbox.hide();
		this.pause();
		$music.currentTime = 0.0;
	};
	//暂停播放
	this.pause = function () {
		op.musicbox && op.musicbox.addClass("music-paused");
		$music.pause();
	};
	//切换播放/暂停
	this.toggle = function () {
		if ($music.paused) {
			this.play();
		} else {
			this.pause();
		}
	};
	//重新开始播放
	this.rePlay = function () {
		$music.currentTime = 0.0;
	};
	//指定播放位置
	this.setVolume = function (num) {
		$music.volume = num;
	};
	//自动播放
	this.autoplay = function () {
		readplay();
		this.play();
	};
	//模拟主动触发一次
	function readplay() {
		//常规浏览器 主动触发播放
		function musicInBrowserHandler() {
			if (!musicReady) {
				that.play();
				that.pause();
			}
			document.body.removeEventListener('touchend', musicInBrowserHandler);
		}
		document.body.addEventListener('touchend', musicInBrowserHandler);
		//微信webview 自动播放
		document.addEventListener("WeixinJSBridgeReady", function () {
			that.play();
			if (!op.autoplay) {
				that.pause();
			}
		}, false);
		//微博webview 自动播放（测试中...暂时无效）
		document.addEventListener("WeiboJSBridgeReady", function () {
			that.play();
			if (!op.autoplay) {
				that.pause();
			}
		}, false);
	};
	op.musicbox && op.musicbox.show().addClass("music-paused");
	if (!$music.src) {
		if (op.url) {
			$music.setAttribute("src", op.url);
		}
		if (op.preload) {
			$music.setAttribute("preload", "preload");
		}
		if (op.loop) {
			$music.setAttribute("loop", "loop");
		}
		if (op.autoplay) {
			$music.setAttribute("autoplay", "autoplay");
			that.autoplay();
		}
		$music.setAttribute("id", "music");
	}
};

//REM自动适配器
window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", ___resize, false);
function ___resize() {
	var psd_w = 750,
		psd_h = 1206, //设计稿尺寸
		max_w = 768,
		min_w = 320, //最大、最小屏幕尺寸范围
		win_w = $(window).width(),
		win_h = $(window).height(), //浏览器尺寸
		psd_sp = psd_w / psd_h,
		win_sp = win_w / win_h;

	// if (win_sp > psd_sp) {
	// 	win_w *= psd_sp / win_sp;
	// }

	win_w = win_w > max_w ? max_w : win_w < min_w ? min_w : win_w;

	$("html").css({
		"fontSize": win_w / psd_w * 100 + "px"
	});
}
___resize();

$.fn.topage = function () {
	var outobj = $("section.active");

	if (outobj.attr("id") == this.attr("id")) return;

	outobj.addClass("activeout");

	setTimeout(function () {
		outobj.removeClass("transition");
		outobj.removeClass("active");
		outobj.removeClass("activeout");

		setTimeout(function () {
			outobj.addClass("transition");
		}, 300);
	}, 300);

	this.addClass("active");
}

$.fn.bindsubmitjoin = function () {
	var _ = this;

	_.find("#joinsubmit").ontouch(function (e) {
		
		if(!validate()){
			return;
		}

		var data = _.find("form").serialize();

		$.ajax({
			url: _.find("form").attr("action"),
			data: data,
			type: "POST",
			success: function (data) {
				console.log('啦啦啦');
				var result = $.parseJSON(data);
				console.log(result);
				if (result.code == "200") {
					$('#joinbox').children().hide();
					$('#joinbox div.joinok').show();
					$("#joinbox div.joinok .font-orange").html(result.data.id);
					myjoinid = result.data.id;
					myjoinstate = result.data.checkstate;
				} else {
					mui.alert(result.msg, '提示');
				}
			},
			error: function (xhr, textStatus) {
				console.log('错误')
				console.log(xhr)
				console.log(textStatus)
			},
			complete: function () {
				console.log('加载列表数据完毕')
			}
		});
	}, true);
}

function createdomobileurl(doname) {
	var url = rootpath + "/app/index.php?i=2&c=entry&do=" + doname + "&m="+ projectname;
	return url;
}

function initfooter(){
    $(".votefooter li").ontouch(function(){
		var name = $(this).attr("topage");
		
		$(".votefooter li").removeClass('font-orange');
		$(this).addClass('font-orange');

		if(name == "joinbox"){
			
			//初始化报名
			if(myjoinstate == 1) {	//待审核
				$('#joinbox').children().hide();
				$('#joinbox div.checking').show();
			}else if(myjoinstate == 2){	//审核通过
				$('#joinbox').children().hide();
				$('#joinbox div.detail').show();
				info(myjoinid);
			}else{
				$('#joinbox').children().hide();
				$('#joinbox div.join').show();
			}
		}

        $("#" + $(this).attr("topage")).topage();
    });
}

function createlistitem(data) {
	var tmp =
		'<div class="order">\
		<div class="orderimg">\
		<a href="javascript:info({id})">\
			<img src="{img}" />\
			</a>\
			<div class="info">{id}号&nbsp;{username}\
			</div>\
		</div>\
		<div class="orderfooter">\
			<p>{pollcount} 票</p>\
			<a href="javascript:vote({id})">投票</a>\
		</div>\
		<div style="clear:both;"></div>\
	</div>';

	//追加列表内容
	$(".list .orderlist").each(function () {
		var leftlist = $(this).find('.leftlist');
		var rightlist = $(this).find('.rightlist');

		listid = $(this).attr('id');
		
		var listdata = data[listid];
		
		$(listdata).each(function(i,o){
			(leftlist.height() > rightlist.height() ? rightlist: leftlist).append($.replace(tmp,o));
		});

	})
}

function loadlist() {
	$.ajax({
		url: createdomobileurl('index') + "&op=list&voteid=" + voteid + "&start=" + start + "&limit=" + limit,
		type: 'GET',
		async: false,
		dataType: 'json',
		success: function (data, textStatus, jqXHR) {
			console.log(data);
			if (data.code == 200) {
				if(data.data.newlist.length < limit){
					$('#list .load').hide();
				}else{
					$('#list .load').show();
				}
				start = start + data.data.newlist.length;
				createlistitem(data.data);
			}
		},
		error: function (xhr, textStatus) {
			console.log('错误')
			console.log(xhr)
			console.log(textStatus)
		},
		complete: function () {
			console.log('加载列表数据完毕')
		}
	})
}

//查看详情
function info(joinid) {	
	$.ajax({
		url: createdomobileurl('index')+"&op=info&voteid=" + voteid + "&joinid=" + joinid,
		type: 'GET',
		async: true,
		timeout: 5000,
		dataType: 'json',
		success: function (data, textStatus, jqXHR) {
            if(data.code == 200){
				$("section").removeClass("active");
				$("#joinbox").addClass("active");
				$("#joinbox").children().hide();
				$('#joinbox div.detail').show();
				$("#joinbox .detail .orderimg img").attr("src", data.data['image']);
				$("#joinbox .detail .orderimg .info").html("&nbsp;&nbsp;" + data.data['id']+"号&nbsp;&nbsp;" + data.data['username'] + "&nbsp;&nbsp;" + data.data['pollcount']+"票");
				$("#joinbox .detail .imgcss .desc").html(data.data['resume']);
				$(".votefooter li [topage='joinbox']").addClass('font-orange');
				$("#joinbox .detail .btn1").attr("href", "javascript:vote(" + joinid + ");")
				
				sharedata = {
					title: title,
					desc: data.data['resume'],
					link: createdomobileurl('index') + "&voteid=" + voteid + "&joinid=" + joinid,
					imgUrl: data.data['image'],
					success: function () {
						mui.alert('分享成功！', '提示');
					}
				};
				
				wx.ready(function () {
					wx.onMenuShareAppMessage(sharedata);
					wx.onMenuShareTimeline(sharedata);
					wx.onMenuShareQQ(sharedata);
					wx.onMenuShareWeibo(sharedata);
				});
            }else{
                console.log(data.msg);
            }
		},
		error: function (xhr, textStatus) {
			console.log('错误')
			console.log(xhr)
			console.log(textStatus)
		},
		complete: function () {
			console.log('结束')
		}
	})
}

 //投票
 function vote(joinid) {
	$.ajax({
		url: createdomobileurl('vote')+"&joinid=" + joinid + "&voteid=" + voteid,
		type: 'POST',
		async: true,
		timeout: 5000,
		dataType: 'json',
		success: function (data, textStatus, jqXHR) {
			mui.alert(data.msg, '提示');
		},
		error: function (xhr, textStatus) {
			console.log('错误')
			console.log(xhr)
			console.log(textStatus)
		},
		complete: function () {
			console.log('结束')
		}
	})
}

//表单验证
function validate(){
	var nameobj = $("input[name='username']").val()
	if(nameobj == null || nameobj.trim().length ==0){
		$("#txtname").focus();
		$("#spanname").html("*姓名不能为空");
		return false;
	}
	$("#spanname").html("");

	var telphone = $("input[name='telephone']").val();

	if((!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(telphone)))){
		$("#txttelphone").focus();
		$("#spanphone").html("*请输入正确的手机号码，方便联系您兑换奖品");
		return false;
	}
	$("#spanphone").html("");

	var imgobj = $("input[name='image']").val();
	if(imgobj == ""){
		$("#spanimg").html("*请选择图片");
		return false; 
	}
	if(!/\.jpeg|\.jpg|\.gif|\.png/gi.test(imgobj)){
		$("#spanimg").html("*图片格式有误");
		return false; 
	}
	$("#spanimg").html("");

	var textobj = $("textarea[name='resume']").val();
	if(textobj == "" || textobj.trim().length ==0){spantext
		$("#txtdescribe").focus();
		$("#spantext").html("*活动详情不能为空");
		return false;
	}
	$("#spantext").html("");

	return true;
}

$(function () {
	//修改标题
	document.title = title;
	
	$(".votefooter li").removeClass('font-orange');
	$(".votefooter li [topage='{$section}']").addClass('font-orange');
	
	initfooter();
	//绑定表单事件
	$("#joinbox").bindsubmitjoin();

	//参与选手列表切换效果
	$("#listmenu div").each(function (i) {
		$(this).click(function () {
			$("#listmenu div").removeClass("active");
			$(this).addClass("active");

			var _index = $(this).index();
			$("#listmenu").attr("class", "menu listmenuindex" + _index);
			$("#list").attr("class", "list active listindex" + _index);
		});
	});
	
	$('#list .load').hide();
	
	//加载列表
	loadlist();
	
	//默认选择首页
	$('.votefooter li').eq(0).addClass('font-orange');

	//判断是否跳转详情页面
	if(joinid != null && joinid != ""){
		info(joinid);
	}

	//分享帮助页面点击关闭
	$('.sharehelp').click(function(){
		$('.sharehelp').hide();
	})

	$('#searchbtn').click(function(){
		var txtjoinid = $("#txtjoinid").val().trim();
		
		$.ajax({
			url: createdomobileurl('index') + "&op=search&voteid=" + voteid + "&joinid=" + txtjoinid,
			type: 'GET',
			async: false,
			dataType: 'json',
			success: function (data, textStatus, jqXHR) {
				if(data.code == 200){
					if(!data.data){
						mui.alert('查询编号不存在！', '提示');
					}else{
						info(txtjoinid);
						$('#box').hide();$('#black').hide();
					}
				}
			}
		})
	})

	//得到屏幕高度
	var sheight = window.screen.height;
	$("#index").scroll(function() {
		if(sheight + $("#index").scrollTop() >= ($("#index")[0].scrollHeight - 2)){
			console.log("到底了。");
			$('#list .load').show();
			loadlist();
		}
	});

	sharedata = {
		title: title,
		desc: title,
		link: createdomobileurl('index') + "&voteid=" + voteid,
		imgUrl: imgurl,
		success: function(){
            mui.alert('分享成功', '提示');
		}
	};

	wx.ready(function () {
		wx.onMenuShareAppMessage(sharedata);
		wx.onMenuShareTimeline(sharedata);
		wx.onMenuShareQQ(sharedata);
		wx.onMenuShareWeibo(sharedata);
	});
});
