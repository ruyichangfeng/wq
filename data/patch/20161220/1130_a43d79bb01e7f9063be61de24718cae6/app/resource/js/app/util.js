!function(window){var util={};util.dialog=function(a,b,c,d){d||(d={}),d.containerName||(d.containerName="modal-message");var e=$("#"+d.containerName);0==e.length&&($(document.body).append('<div id="'+d.containerName+'" class="modal animated" tabindex="-1" role="dialog" aria-hidden="true"></div>'),e=$("#"+d.containerName));var f='<div class="modal-dialog modal-sm">	<div class="modal-content">';if(a&&(f+='<div class="modal-header">	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	<h3>'+a+"</h3></div>"),b&&(f+=$.isArray(b)?'<div class="modal-body">正在加载中</div>':'<div class="modal-body">'+b+"</div>"),c&&(f+='<div class="modal-footer">'+c+"</div>"),f+="	</div></div>",e.html(f),b&&$.isArray(b)){var g=function(a){e.find(".modal-body").html(a)};2==b.length?$.post(b[0],b[1]).success(g):$.get(b[0]).success(g)}return e},util.image=function(a,b,c){require(["webuploader","cropper","previewer"],function(d){var e,f,g,h=util.querystring("i"),i=util.querystring("j");defaultOptions={pick:{id:"#filePicker",label:"点击选择图片",multiple:!1},auto:!0,swf:"./resource/componets/webuploader/Uploader.swf",server:"./index.php?i="+h+"&j="+i+"&c=utility&a=file&do=upload&type=image&thumb=0",chunked:!1,compress:!1,fileNumLimit:1,fileSizeLimit:4194304,fileSingleSizeLimit:4194304,crop:!1,preview:!1},"android"==util.agent()&&(defaultOptions.sendAsBinary=!0),c=$.extend({},defaultOptions,c),a&&(a=$(a),c.pick={id:a,multiple:c.pick.multiple}),c.multiple&&(c.pick.multiple=c.multiple,c.fileNumLimit=8),c.crop&&(c.auto=!1,c.pick.multiple=!1,c.preview=!1,d.Uploader.register({"before-send-file":"cropImage"},{cropImage:function(a){if(!a||!a._cropData)return!1;var b,c,e=a._cropData;return a=this.request("get-file",a),c=d.Deferred(),b=new d.Lib.Image,c.always(function(){b.destroy(),b=null}),b.once("error",c.reject),b.once("load",function(){b.crop(e.x,e.y,e.width,e.height,e.scale)}),b.once("complete",function(){var d,e;try{d=b.getAsBlob(),e=a.size,a.source=d,a.size=d.size,a.trigger("resize",d.size,e),c.resolve()}catch(f){c.resolve()}}),a._info&&b.info(a._info),a._meta&&b.meta(a._meta),b.loadFromBlob(a.source),c.promise()}})),f=d.create(c),a.data("uploader",f),c.preview&&(g=mui.previewImage({footer:window.util.templates["image.preview.html"]}),$(g.element).find(".js-cancel").click(function(){g.close()}),$(document).on("click",".js-submit",function(a){var b=$(g.element).find(".mui-slider-group .mui-active").index();if(g.groups.__IMG_UPLOAD&&g.groups.__IMG_UPLOAD[b]&&g.groups.__IMG_UPLOAD[b].el){var c="./index.php?i="+h+"&j="+i+"&c=utility&a=file&do=delete&type=image",d=$(g.groups.__IMG_UPLOAD[b].el).data("id");$.post(c,{id:d},function(a){var a=$.parseJSON(a);$(g.groups.__IMG_UPLOAD[b].el).remove(),g.close()})}return a.stopPropagation(),!1})),f.on("fileQueued",function(a){util.loading().show(),c.crop&&f.makeThumb(a,function(b,c){f.file=a,b||e.preview(c)},1,1)}),f.on("uploadSuccess",function(a,d){if(d.error&&d.error.message)util.toast(d.error.message,"error");else{f.on("uploadFinished",function(){util.loading().close(),f.reset(),e.reset()});var h=$('<img src="'+d.url+'" data-preview-src="" data-preview-group="'+c.preview+'" />');c.preview&&g.addImage(h[0]),$.isFunction(b)&&b(d)}}),f.onError=function(a){return e.reset(),util.loading().close(),"Q_EXCEED_SIZE_LIMIT"==a?void alert("错误信息: 图片大于 4M 无法上传."):"Q_EXCEED_NUM_LIMIT"==a?void util.toast("单次最多上传8张"):void alert("错误信息: "+a)},e=function(){var a,b;return{preview:function(d){return a=$(window.util.templates["avatar.preview.html"]),a.css("height",$(window).height()),$(document.body).prepend(a),b=a.find("img"),b.attr("src",d),b.cropper({aspectRatio:c.aspectRatio?c.aspectRatio:1,viewMode:1,dragMode:"move",autoCropArea:1,restore:!1,guides:!1,highlight:!1,cropBoxMovable:!1,cropBoxResizable:!1}),a.find(".js-submit").on("click",function(){var a=b.cropper("getData"),c=e.getImageSize().width/f.file._info.width;a.scale=c,f.file._cropData={x:a.x,y:a.y,width:a.width,height:a.height,scale:a.scale},f.upload()}),a.find(".js-cancel").one("click",function(){a.remove(),f.reset()}),util.loading().close(),this},getImageSize:function(){var a=b.get(0);return{width:a.naturalWidth,height:a.naturalHeight}},reset:function(){return $(".js-avatar-preview").remove(),f.reset(),this}}}()})},util.map=function(a,b){require(["map"],function(c){function d(a){f.getPoint(a,function(a){map.panTo(a),marker.setPosition(a),marker.setAnimation(BMAP_ANIMATION_BOUNCE),setTimeout(function(){marker.setAnimation(null)},3600)})}a||(a={}),a.lng||(a.lng=116.403851),a.lat||(a.lat=39.915177);var e=new c.Point(a.lng,a.lat),f=new c.Geocoder,g=$("#map-dialog");if(0==g.length){var h='<div class="form-group"><div class="input-group"><input type="text" class="form-control" placeholder="请输入地址来直接查找相关位置"><div class="input-group-btn"><button class="btn btn-default"><i class="icon-search"></i> 搜索</button></div></div></div><div id="map-container" style="height:400px;"></div>',i='<button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="button" class="btn btn-primary">确认</button>';g=util.dialog("请选择地点",h,i,{containerName:"map-dialog"}),g.find(".modal-dialog").css("width","80%"),g.modal({keyboard:!1}),map=util.map.instance=new c.Map("map-container"),map.centerAndZoom(e,12),map.enableScrollWheelZoom(),map.enableDragging(),map.enableContinuousZoom(),map.addControl(new c.NavigationControl),map.addControl(new c.OverviewMapControl),marker=util.map.marker=new c.Marker(e),marker.setLabel(new c.Label("请您移动此标记，选择您的坐标！",{offset:new c.Size(10,-20)})),map.addOverlay(marker),marker.enableDragging(),marker.addEventListener("dragend",function(a){var b=marker.getPosition();f.getLocation(b,function(a){g.find(".input-group :text").val(a.address)})}),g.find(".input-group :text").keydown(function(a){if(13==a.keyCode){var b=$(this).val();d(b)}}),g.find(".input-group button").click(function(){var a=$(this).parent().prev().val();d(a)})}g.off("shown.bs.modal"),g.on("shown.bs.modal",function(){marker.setPosition(e),map.panTo(marker.getPosition())}),g.find("button.btn-primary").off("click"),g.find("button.btn-primary").on("click",function(){if($.isFunction(b)){var a=util.map.marker.getPosition();f.getLocation(a,function(c){var d={lng:a.lng,lat:a.lat,label:c.address};b(d)})}g.modal("hide")}),g.modal("show")})},util.toast=function(a,b,c){if(c&&"success"!=c){if("error"==c)var d=mui.toast('<div class="mui-toast-icon"><span class="fa fa-exclamation-circle"></span></div>'+a)}else var d=mui.toast('<div class="mui-toast-icon"><span class="fa fa-check"></span></div>'+a);if(b)var e=3,f=setInterval(function(){return 0>=e?(clearInterval(f),void(location.href=b)):void e--},1e3);return d},util.loading=function(a){var a=a?a:"show",b={},c=$(".js-toast-loading");if(c.size()<=0)var c=$('<div class="mui-toast-container mui-active js-toast-loading"><div class="mui-toast-message"><div class="mui-toast-icon"><span class="fa fa-spinner fa-spin"></span></div>加载中</div></div>');return b.show=function(){document.body.appendChild(c[0])},b.close=function(){c.remove()},b.hide=function(){c.remove()},"show"==a?b.show():"close"==a&&b.close(),b},util.message=function(a,b,c,d){var e=$("<div>"+window.util.templates["message.html"]+"</div>");if(e.attr("class","mui-content fadeInUpBig animated "+mui.className("backdrop")),e.on(mui.EVENT_MOVE,mui.preventDefault),e.css("background-color","#efeff4"),d&&e.find(".mui-desc").html(d),b){var f=b.replace("##auto");if(e.find(".mui-btn-success").attr("href",f),b.indexOf("##auto")>-1)var g=5,h=setInterval(function(){return 0>=g?(clearInterval(h),void(location.href=f)):(e.find(".mui-btn-success").html(g+"秒后自动跳转"),void g--)},1e3)}e.find(".mui-btn-success").click(function(){if(b){var a=b.replace("##auto");location.href=a}else history.go(-1)}),c&&"success"!=c?(c="error")&&(e.find(".title").html(a),e.find(".mui-message-icon span").attr("class","mui-msg-error")):(e.find(".title").html(a),e.find(".mui-message-icon span").attr("class","mui-msg-success")),document.body.appendChild(e[0])},util.alert=function(a,b,c,d){return mui.alert(a,b,c,d)},util.confirm=function(a,b,c,d){return mui.confirm(a,b,c,d)},util.pay=function(option){var defaultOptions={enabledMethod:[],defaultMethod:"wechat",payMethod:"wechat",orderTitle:"",orderTid:"",success:function(){},faild:function(){},finish:function(){}};if(option=$.extend({},defaultOptions,option),!option.orderFee||option.orderFee<=0)return void util.toast("请确认支付金额","","error");!option.defaultMethod&&option.payMethod&&(option.defaultMethod=option.payMethod);var CLASS_ACTIVE=mui.className("active"),CLASS_BACKDROP=mui.className("backdrop"),paypanel=$("#pay-detail-modal").size()>0?$("#pay-detail-modal"):$('<div class="mui-modal '+CLASS_ACTIVE+' js-pay-detail-modal" id="pay-detail-modal"></div>'),removeBackdropTimer,fixedModalScroll=function(a){a?($(".mui-content")[0].setAttribute("style","overflow:hidden;"),document.body.setAttribute("style","overflow:hidden;")):($(".mui-content")[0].setAttribute("style",""),document.body.setAttribute("style",""))},backdrop=function(){var a=document.createElement("div");return a.classList.add(CLASS_BACKDROP),a.addEventListener(mui.EVENT_MOVE,mui.preventDefault),a.addEventListener("click",function(a){return paypanel?(paypanel.remove(),$(backdrop).remove(),document.body.setAttribute("style",""),!1):void 0}),a}(),switchmodal=function(a){"main"==a?(paypanel.find(".js-main-modal").show().addClass("fadeInRight animated"),paypanel.find(".js-switch-pay-modal").hide(),paypanel.find(".js-switch-modal").hide()):"pay"==a&&(paypanel.find(".js-main-modal").hide(),paypanel.find(".js-switch-pay-modal").show().addClass("fadeInRight animated"),paypanel.find(".js-switch-modal").show())},dopaywechat=function(){$.post("index.php?i="+window.sysinfo.uniacid+"&j="+window.sysinfo.acid+"&c=entry&m=core&do=pay",{method:option.payMethod,tid:option.orderTid,title:option.orderTitle,fee:option.orderFee,module:option.module},function(a){if(util.loading().hide(),a=$.parseJSON(a),a.message.errno){var b={errno:a.message.errno,message:a.message.message};return option.fail(b),void option.complete(b)}payment=a.message.message,WeixinJSBridge.invoke("getBrandWCPayRequest",{appId:payment.appId,timeStamp:payment.timeStamp,nonceStr:payment.nonceStr,"package":payment["package"],signType:payment.signType,paySign:payment.paySign},function(a){if("get_brand_wcpay_request:ok"==a.err_msg){var b={errno:0,message:a.err_msg};option.success(b),option.complete(b)}else if("get_brand_wcpay_request:cancel"==a.err_msg){var b={errno:-1,message:a.err_msg};option.complete(b)}else{var b={errno:-2,message:a.err_msg};option.fail(b),option.complete(b)}})})},dopayalipay=function(){util.loading().hide(),$.post("index.php?i="+window.sysinfo.uniacid+"&j="+window.sysinfo.acid+"&c=entry&m=core&do=pay",{method:option.payMethod,tid:option.orderTid,title:option.orderTitle,fee:option.orderFee,module:option.module},function(a){util.loading().hide(),a=$.parseJSON(a),require(["../payment/alipay/ap.js"],function(){_AP.pay(a.message.message)})})},dopay=function(){util.loading().hide(),$.post("index.php?i="+window.sysinfo.uniacid+"&j="+window.sysinfo.acid+"&c=entry&m=core&do=pay",{method:option.payMethod,tid:option.orderTid,title:option.orderTitle,fee:option.orderFee,module:option.module},function(a){a=$.parseJSON(a),util.loading().hide(),location.href=a.message.message})};return util.loading().show(),option.enabledMethod&&option.enabledMethod.length>1?$.post("index.php?i="+window.sysinfo.uniacid+"&j="+window.sysinfo.acid+"&c=entry&m=core&do=paymethod",{module:option.module,tid:option.orderTid,title:option.orderTitle,fee:option.orderFee},function(a){if(util.loading().hide(),paypanel.html(a),backdrop.setAttribute("style",""),$(document.body).append(paypanel),$(document.body).append(backdrop),fixedModalScroll(!0),paypanel.find(".js-switch-modal").click(function(){switchmodal("main")}),paypanel.find(".js-switch-pay").click(function(){switchmodal("pay")}),paypanel.find(".js-switch-pay-close").click(function(){paypanel.remove(),$(backdrop).remove(),document.body.setAttribute("style","")}),paypanel.find(".js-order-title").html(option.orderTitle),paypanel.find(".js-pay-fee").html(option.orderFee),!(paypanel.find(".js-switch-pay-modal li").size()>0))return util.toast("暂无有效支付方式"),paypanel.remove(),$(backdrop).remove(),document.body.setAttribute("style",""),!1;if(option.enabledMethod&&option.enabledMethod.length>0?paypanel.find(".js-switch-pay-modal li").each(function(){-1==$.inArray($(this).data("method"),option.enabledMethod)&&$(this).remove()}):paypanel.find(".js-switch-pay-modal li").each(function(){option.enabledMethod.push($(this).data("method"))}),option.defaultMethod&&$.inArray(option.defaultMethod,option.enabledMethod)>-1)var b=paypanel.find(".js-switch-pay-modal li[data-method="+option.defaultMethod+"]");else var b=$(paypanel.find(".js-switch-pay-modal li:first"));return 0==b.size()?(util.toast("暂无有效支付方式"),paypanel.remove(),$(backdrop).remove(),document.body.setAttribute("style",""),!1):(paypanel.find(".js-pay-default-method").html(b.data("title")),void paypanel.find(".js-dopay").click(function(){dopay(b.data("title"),b.data("method"))}))}):"function"==typeof typeof("dopay"+option.payMethod)?eval("dopay"+option.payMethod+"();"):dopay(),!0},util.poppicker=function(a,b){require(["mui.datepicker"],function(){mui.ready(function(){var c=new mui.PopPicker({layer:a.layer||1});c.setData(a.data),c.show(function(a){$.isFunction(b)&&b(a),c.dispose()})})})},util.districtpicker=function(a){require(["mui.districtpicker"],function(b){mui.ready(function(){var c={layer:3,data:b};util.poppicker(c,a)})})},util.datepicker=function(a,b){require(["mui.datepicker"],function(){mui.ready(function(){var c;c=new mui.DtPicker(a),c.show(function(a){$.isFunction(b)&&b(a),c.dispose()})})})},util.querystring=function(a){var b=location.search.match(new RegExp("[?&]"+a+"=([^&]+)","i"));return null==b||b.length<1?"":b[1]},util.tomedia=function(a,b){if(!a)return"";if(0==a.indexOf("./addons"))return window.sysinfo.siteroot+a.replace("./","");-1!=a.indexOf(window.sysinfo.siteroot)&&-1==a.indexOf("/addons/")&&(a=a.substr(a.indexOf("images/"))),0==a.indexOf("./resource")&&(a="app/"+a.substr(2));var c=a.toLowerCase();return-1!=c.indexOf("http://")||-1!=c.indexOf("https://")?a:a=b||!window.sysinfo.attachurl_remote?window.sysinfo.attachurl_local+a:window.sysinfo.attachurl_remote+a},util.sendCode=function(a,b){var c={btnElement:"",showElement:"",showTips:"%s秒后重新获取",btnTips:"重新获取验证码",successCallback:arguments[3]};if("object"!=typeof arguments[1]){var d=a,a=b;b={btnElement:$(d),showElement:$(d),showTips:"%s秒后重新获取",btnTips:"重新获取验证码",successCallback:arguments[2]}}else b=$.extend({},c,b);if(!a)return b.successCallback("1","请填写正确的手机号");if(!/^1[3|4|5|7|8][0-9]{9}$/.test(a))return b.successCallback("1","手机格式错误");var e=60;b.showElement.html(b.showTips.replace("%s",e)),b.showElement.attr("disabled",!0);var f=setInterval(function(){e--,0>=e?(clearInterval(f),e=60,b.showElement.html(b.btnTips),b.showElement.attr("disabled",!1)):b.showElement.html(b.showTips.replace("%s",e))},1e3),g={};g.receiver=a,g.uniacid=window.sysinfo.uniacid,$.post("../web/index.php?c=utility&a=verifycode",g).success(function(a){return"success"==a?b.successCallback("0","验证码发送成功"):b.successCallback("1",a)})},util.loading1=function(){var a="modal-loading",b=$("#"+a);return 0==b.length&&($(document.body).append('<div id="'+a+'" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>'),b=$("#"+a),html='<div class="modal-dialog">	<div style="text-align:center; background-color: transparent;">		<img style="width:48px; height:48px; margin-top:100px;" src="../attachment/images/global/loading.gif" title="正在努力加载...">	</div></div>',b.html(html)),b.modal("show"),b.next().css("z-index",999999),b},util.loaded1=function(){var a="modal-loading",b=$("#"+a);b.length>0&&b.modal("hide")},util.cookie={prefix:"",set:function(a,b,c){expires=new Date,expires.setTime(expires.getTime()+1e3*c),document.cookie=this.name(a)+"="+escape(b)+"; expires="+expires.toGMTString()+"; path=/"},get:function(a){for(cookie_name=this.name(a)+"=",cookie_length=document.cookie.length,cookie_begin=0;cookie_begin<cookie_length;){if(value_begin=cookie_begin+cookie_name.length,document.cookie.substring(cookie_begin,value_begin)==cookie_name){var b=document.cookie.indexOf(";",value_begin);return-1==b&&(b=cookie_length),unescape(document.cookie.substring(value_begin,b))}if(cookie_begin=document.cookie.indexOf(" ",cookie_begin)+1,0==cookie_begin)break}return null},del:function(a){new Date;document.cookie=this.name(a)+"=; expires=Thu, 01-Jan-70 00:00:01 GMT; path=/"},name:function(a){return this.prefix+a}},util.agent=function(){var a=navigator.userAgent,b=a.indexOf("Android")>-1||a.indexOf("Linux")>-1,c=!!a.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);return b?"android":c?"ios":"unknown"},util.removeHTMLTag=function(a){return"string"==typeof a?(a=a.replace(/<script[^>]*?>[\s\S]*?<\/script>/g,""),a=a.replace(/<style[^>]*?>[\s\S]*?<\/style>/g,""),a=a.replace(/<\/?[^>]*>/g,""),a=a.replace(/\s+/g,""),a=a.replace(/&nbsp;/gi,"")):void 0},util.card=function(){$.post("./index.php?c=utility&a=card",{uniacid:window.sysinfo.uniacid,acid:window.sysinfo.acid},function(a){util.loading().hide();var a=$.parseJSON(a);return 0==a.message.errno?(util.message("没有开通会员卡功能","","info"),!1):(1==a.message.errno&&wx.ready(function(){wx.openCard({cardList:[{cardId:a.message.message.card_id,code:a.message.message.code}]})}),2==a.message.errno&&(location.href="./index.php?i="+window.sysinfo.uniacid+"&c=mc&a=card&do=mycard"),void(3==a.message.errno&&(alert("由于会员卡升级到微信官方会员卡，需要您重新领取并激活会员卡"),wx.ready(function(){wx.addCard({cardList:[{cardId:a.message.message.card_id,cardExt:a.message.message.card_ext}],success:function(a){}})}))))})},"function"==typeof define&&define.amd?define(function(){return util}):window.util=util}(window),function(a,b){a["avatar.preview.html"]='<div class="fadeInDownBig animated js-avatar-preview avatar-preview" style="position:relative; width:100%;z-index:9999"><img src="" alt="" class="cropper-hidden"><div class="bar-action mui-clearfix"><a href="javascript:;" class="mui-pull-left js-cancel">取消</a> <a href="javascript:;" class="mui-pull-right mui-text-right js-submit">选取</a></div></div>',a["image.preview.html"]='<div class="bar-action mui-clearfix"><a href="javascript:;" class="mui-pull-left js-cancel">取消</a> <a href="javascript:;" class="mui-pull-right mui-text-right js-submit">删除</a></div>',a["message.html"]='<div class="mui-content-padded"><div class="mui-message"><div class="mui-message-icon"><span></span></div><h4 class="title"></h4><p class="mui-desc"></p><div class="mui-button-area"><a href="javascript:;" class="mui-btn mui-btn-success mui-btn-block">确定</a></div></div></div>'}(this.window.util.templates=this.window.util.templates||{});