var swfobject=function(){var D="undefined",r="object",T="Shockwave Flash",Z="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",S="SWFObjectExprInst",x="onreadystatechange",Q=window,h=document,t=navigator,V=false,X=[],o=[],P=[],K=[],I,p,E,B,L=false,a=false,m,G,j=true,l=false,O=function(){var ad=typeof h.getElementById!=D&&typeof h.getElementsByTagName!=D&&typeof h.createElement!=D,ak=t.userAgent.toLowerCase(),ab=t.platform.toLowerCase(),ah=ab?/win/.test(ab):/win/.test(ak),af=ab?/mac/.test(ab):/mac/.test(ak),ai=/webkit/.test(ak)?parseFloat(ak.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,aa=t.appName==="Microsoft Internet Explorer",aj=[0,0,0],ae=null;if(typeof t.plugins!=D&&typeof t.plugins[T]==r){ae=t.plugins[T].description;if(ae&&(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&t.mimeTypes[q].enabledPlugin)){V=true;aa=false;ae=ae.replace(/^.*\s+(\S+\s+\S+$)/,"$1");aj[0]=n(ae.replace(/^(.*)\..*$/,"$1"));aj[1]=n(ae.replace(/^.*\.(.*)\s.*$/,"$1"));aj[2]=/[a-zA-Z]/.test(ae)?n(ae.replace(/^.*[a-zA-Z]+(.*)$/,"$1")):0}}else{if(typeof Q.ActiveXObject!=D){try{var ag=new ActiveXObject(Z);if(ag){ae=ag.GetVariable("$version");if(ae){aa=true;ae=ae.split(" ")[1].split(",");aj=[n(ae[0]),n(ae[1]),n(ae[2])]}}}catch(ac){}}}return{w3:ad,pv:aj,wk:ai,ie:aa,win:ah,mac:af}}(),i=function(){if(!O.w3){return}if((typeof h.readyState!=D&&(h.readyState==="complete"||h.readyState==="interactive"))||(typeof h.readyState==D&&(h.getElementsByTagName("body")[0]||h.body))){f()}if(!L){if(typeof h.addEventListener!=D){h.addEventListener("DOMContentLoaded",f,false)}if(O.ie){h.attachEvent(x,function aa(){if(h.readyState=="complete"){h.detachEvent(x,aa);f()}});if(Q==top){(function ac(){if(L){return}try{h.documentElement.doScroll("left")}catch(ad){setTimeout(ac,0);return}f()}())}}if(O.wk){(function ab(){if(L){return}if(!/loaded|complete/.test(h.readyState)){setTimeout(ab,0);return}f()}())}}}();function f(){if(L||!document.getElementsByTagName("body")[0]){return}try{var ac,ad=C("span");ad.style.display="none";ac=h.getElementsByTagName("body")[0].appendChild(ad);ac.parentNode.removeChild(ac);ac=null;ad=null}catch(ae){return}L=true;var aa=X.length;for(var ab=0;ab<aa;ab++){X[ab]()}}function M(aa){if(L){aa()}else{X[X.length]=aa}}function s(ab){if(typeof Q.addEventListener!=D){Q.addEventListener("load",ab,false)}else{if(typeof h.addEventListener!=D){h.addEventListener("load",ab,false)}else{if(typeof Q.attachEvent!=D){g(Q,"onload",ab)}else{if(typeof Q.onload=="function"){var aa=Q.onload;Q.onload=function(){aa();ab()}}else{Q.onload=ab}}}}}function Y(){var aa=h.getElementsByTagName("body")[0];var ae=C(r);ae.setAttribute("style","visibility: hidden;");ae.setAttribute("type",q);var ad=aa.appendChild(ae);if(ad){var ac=0;(function ab(){if(typeof ad.GetVariable!=D){try{var ag=ad.GetVariable("$version");if(ag){ag=ag.split(" ")[1].split(",");O.pv=[n(ag[0]),n(ag[1]),n(ag[2])]}}catch(af){O.pv=[8,0,0]}}else{if(ac<10){ac++;setTimeout(ab,10);return}}aa.removeChild(ae);ad=null;H()}())}else{H()}}function H(){var aj=o.length;if(aj>0){for(var ai=0;ai<aj;ai++){var ab=o[ai].id;var ae=o[ai].callbackFn;var ad={success:false,id:ab};if(O.pv[0]>0){var ah=c(ab);if(ah){if(F(o[ai].swfVersion)&&!(O.wk&&O.wk<312)){w(ab,true);if(ae){ad.success=true;ad.ref=z(ab);ad.id=ab;ae(ad)}}else{if(o[ai].expressInstall&&A()){var al={};al.data=o[ai].expressInstall;al.width=ah.getAttribute("width")||"0";al.height=ah.getAttribute("height")||"0";if(ah.getAttribute("class")){al.styleclass=ah.getAttribute("class")}if(ah.getAttribute("align")){al.align=ah.getAttribute("align")}var ak={};var aa=ah.getElementsByTagName("param");var af=aa.length;for(var ag=0;ag<af;ag++){if(aa[ag].getAttribute("name").toLowerCase()!="movie"){ak[aa[ag].getAttribute("name")]=aa[ag].getAttribute("value")}}R(al,ak,ab,ae)}else{b(ah);if(ae){ae(ad)}}}}}else{w(ab,true);if(ae){var ac=z(ab);if(ac&&typeof ac.SetVariable!=D){ad.success=true;ad.ref=ac;ad.id=ac.id}ae(ad)}}}}}X[0]=function(){if(V){Y()}else{H()}};function z(ac){var aa=null,ab=c(ac);if(ab&&ab.nodeName.toUpperCase()==="OBJECT"){if(typeof ab.SetVariable!==D){aa=ab}else{aa=ab.getElementsByTagName(r)[0]||ab}}return aa}function A(){return !a&&F("6.0.65")&&(O.win||O.mac)&&!(O.wk&&O.wk<312)}function R(ad,ae,aa,ac){var ah=c(aa);aa=W(aa);a=true;E=ac||null;B={success:false,id:aa};if(ah){if(ah.nodeName.toUpperCase()=="OBJECT"){I=J(ah);p=null}else{I=ah;p=aa}ad.id=S;if(typeof ad.width==D||(!/%$/.test(ad.width)&&n(ad.width)<310)){ad.width="310"}if(typeof ad.height==D||(!/%$/.test(ad.height)&&n(ad.height)<137)){ad.height="137"}var ag=O.ie?"ActiveX":"PlugIn",af="MMredirectURL="+encodeURIComponent(Q.location.toString().replace(/&/g,"%26"))+"&MMplayerType="+ag+"&MMdoctitle="+encodeURIComponent(h.title.slice(0,47)+" - Flash Player Installation");if(typeof ae.flashvars!=D){ae.flashvars+="&"+af}else{ae.flashvars=af}if(O.ie&&ah.readyState!=4){var ab=C("div");
aa+="SWFObjectNew";ab.setAttribute("id",aa);ah.parentNode.insertBefore(ab,ah);ah.style.display="none";y(ah)}u(ad,ae,aa)}}function b(ab){if(O.ie&&ab.readyState!=4){ab.style.display="none";var aa=C("div");ab.parentNode.insertBefore(aa,ab);aa.parentNode.replaceChild(J(ab),aa);y(ab)}else{ab.parentNode.replaceChild(J(ab),ab)}}function J(af){var ae=C("div");if(O.win&&O.ie){ae.innerHTML=af.innerHTML}else{var ab=af.getElementsByTagName(r)[0];if(ab){var ag=ab.childNodes;if(ag){var aa=ag.length;for(var ad=0;ad<aa;ad++){if(!(ag[ad].nodeType==1&&ag[ad].nodeName=="PARAM")&&!(ag[ad].nodeType==8)){ae.appendChild(ag[ad].cloneNode(true))}}}}}return ae}function k(aa,ab){var ac=C("div");ac.innerHTML="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'><param name='movie' value='"+aa+"'>"+ab+"</object>";return ac.firstChild}function u(ai,ag,ab){var aa,ad=c(ab);ab=W(ab);if(O.wk&&O.wk<312){return aa}if(ad){var ac=(O.ie)?C("div"):C(r),af,ah,ae;if(typeof ai.id==D){ai.id=ab}for(ae in ag){if(ag.hasOwnProperty(ae)&&ae.toLowerCase()!=="movie"){e(ac,ae,ag[ae])}}if(O.ie){ac=k(ai.data,ac.innerHTML)}for(af in ai){if(ai.hasOwnProperty(af)){ah=af.toLowerCase();if(ah==="styleclass"){ac.setAttribute("class",ai[af])}else{if(ah!=="classid"&&ah!=="data"){ac.setAttribute(af,ai[af])}}}}if(O.ie){P[P.length]=ai.id}else{ac.setAttribute("type",q);ac.setAttribute("data",ai.data)}ad.parentNode.replaceChild(ac,ad);aa=ac}return aa}function e(ac,aa,ab){var ad=C("param");ad.setAttribute("name",aa);ad.setAttribute("value",ab);ac.appendChild(ad)}function y(ac){var ab=c(ac);if(ab&&ab.nodeName.toUpperCase()=="OBJECT"){if(O.ie){ab.style.display="none";(function aa(){if(ab.readyState==4){for(var ad in ab){if(typeof ab[ad]=="function"){ab[ad]=null}}ab.parentNode.removeChild(ab)}else{setTimeout(aa,10)}}())}else{ab.parentNode.removeChild(ab)}}}function U(aa){return(aa&&aa.nodeType&&aa.nodeType===1)}function W(aa){return(U(aa))?aa.id:aa}function c(ac){if(U(ac)){return ac}var aa=null;try{aa=h.getElementById(ac)}catch(ab){}return aa}function C(aa){return h.createElement(aa)}function n(aa){return parseInt(aa,10)}function g(ac,aa,ab){ac.attachEvent(aa,ab);K[K.length]=[ac,aa,ab]}function F(ac){ac+="";var ab=O.pv,aa=ac.split(".");aa[0]=n(aa[0]);aa[1]=n(aa[1])||0;aa[2]=n(aa[2])||0;return(ab[0]>aa[0]||(ab[0]==aa[0]&&ab[1]>aa[1])||(ab[0]==aa[0]&&ab[1]==aa[1]&&ab[2]>=aa[2]))?true:false}function v(af,ab,ag,ae){var ad=h.getElementsByTagName("head")[0];if(!ad){return}var aa=(typeof ag=="string")?ag:"screen";if(ae){m=null;G=null}if(!m||G!=aa){var ac=C("style");ac.setAttribute("type","text/css");ac.setAttribute("media",aa);m=ad.appendChild(ac);if(O.ie&&typeof h.styleSheets!=D&&h.styleSheets.length>0){m=h.styleSheets[h.styleSheets.length-1]}G=aa}if(m){if(typeof m.addRule!=D){m.addRule(af,ab)}else{if(typeof h.createTextNode!=D){m.appendChild(h.createTextNode(af+" {"+ab+"}"))}}}}function w(ad,aa){if(!j){return}var ab=aa?"visible":"hidden",ac=c(ad);if(L&&ac){ac.style.visibility=ab}else{if(typeof ad==="string"){v("#"+ad,"visibility:"+ab)}}}function N(ab){var ac=/[\\\"<>\.;]/;var aa=ac.exec(ab)!=null;return aa&&typeof encodeURIComponent!=D?encodeURIComponent(ab):ab}var d=function(){if(O.ie){window.attachEvent("onunload",function(){var af=K.length;for(var ae=0;ae<af;ae++){K[ae][0].detachEvent(K[ae][1],K[ae][2])}var ac=P.length;for(var ad=0;ad<ac;ad++){y(P[ad])}for(var ab in O){O[ab]=null}O=null;for(var aa in swfobject){swfobject[aa]=null}swfobject=null})}}();return{registerObject:function(ae,aa,ad,ac){if(O.w3&&ae&&aa){var ab={};ab.id=ae;ab.swfVersion=aa;ab.expressInstall=ad;ab.callbackFn=ac;o[o.length]=ab;w(ae,false)}else{if(ac){ac({success:false,id:ae})}}},getObjectById:function(aa){if(O.w3){return z(aa)}},embedSWF:function(af,al,ai,ak,ab,ae,ad,ah,aj,ag){var ac=W(al),aa={success:false,id:ac};if(O.w3&&!(O.wk&&O.wk<312)&&af&&al&&ai&&ak&&ab){w(ac,false);M(function(){ai+="";ak+="";var an={};if(aj&&typeof aj===r){for(var aq in aj){an[aq]=aj[aq]}}an.data=af;an.width=ai;an.height=ak;var ar={};if(ah&&typeof ah===r){for(var ao in ah){ar[ao]=ah[ao]}}if(ad&&typeof ad===r){for(var am in ad){if(ad.hasOwnProperty(am)){var ap=(l)?encodeURIComponent(am):am,at=(l)?encodeURIComponent(ad[am]):ad[am];if(typeof ar.flashvars!=D){ar.flashvars+="&"+ap+"="+at}else{ar.flashvars=ap+"="+at}}}}if(F(ab)){var au=u(an,ar,al);if(an.id==ac){w(ac,true)}aa.success=true;aa.ref=au;aa.id=au.id}else{if(ae&&A()){an.data=ae;R(an,ar,al,ag);return}else{w(ac,true)}}if(ag){ag(aa)}})}else{if(ag){ag(aa)}}},switchOffAutoHideShow:function(){j=false},enableUriEncoding:function(aa){l=(typeof aa===D)?true:aa},ua:O,getFlashPlayerVersion:function(){return{major:O.pv[0],minor:O.pv[1],release:O.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(ac,ab,aa){if(O.w3){return u(ac,ab,aa)}else{return undefined}},showExpressInstall:function(ac,ad,aa,ab){if(O.w3&&A()){R(ac,ad,aa,ab)}},removeSWF:function(aa){if(O.w3){y(aa)}},createCSS:function(ad,ac,ab,aa){if(O.w3){v(ad,ac,ab,aa)}},addDomLoadEvent:M,addLoadEvent:s,getQueryParamValue:function(ad){var ac=h.location.search||h.location.hash;
if(ac){if(/\?/.test(ac)){ac=ac.split("?")[1]}if(ad==null){return N(ac)}var ab=ac.split("&");for(var aa=0;aa<ab.length;aa++){if(ab[aa].substring(0,ab[aa].indexOf("="))==ad){return N(ab[aa].substring((ab[aa].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var aa=c(S);if(aa&&I){aa.parentNode.replaceChild(I,aa);if(p){w(p,true);if(O.ie){I.style.display="block"}}if(E){E(B)}}a=false}},version:"2.3"}}();

var UUID_BASE = 0;
//var THIS_SWF_NAME = LSS_SITE + "/lss/aodianplay/vvMedia.swf?v=1.0.0.2";
var THIS_SWF_NAME = LSS_SITE + "/lss/aodianplay/vvMedia.swf?v=1212131";// + new Date().getTime();
var globalUUID_CallbackFuncMap = {};
var globalUUID_OnSwfReadyFuncMap = {};
// play Event
function lssplayerRun(conf){
	// play Event
	var PLAY_ERROR = "RTMPMEDIA.PLAY.ERROR";
	var PLAY_INFO = "RTMPMEDIA.PLAY.INFO";
	var PLAY_NETSTREAM_INFO = "RTMPMEDIA.PLAY.NETSTREAM.INFO";
	// publish Event
	var PUBLISH_ERROR = "RTMPMEDIA.PUBLISH.ERROR";
	var PUBLISH_INFO = "RTMPMEDIA.PUBLISH.INFO";
	var PUBLISH_NETSTREAM_INFO = "RTMPMEDIA.PUBLISH.NETSTREAM.INFO";
	// schedul Event
	var SCHEDULE_RESULT = "SchedulRequest.Result";
	var SCHEDULE_ERROR = "SchedulRequest.Error";
	var SCHEDULE_INFO = "SchedulRequest.Info";
	var SCHEDULE_FINISH = "RtmpMedia.Initialize.Success";
	// server version Event
	var GET_SVR_VERSION_ERR = "GetSvrVersion.Error";
	var GET_SVR_VERSION_INFO = "GetSvrVersion.Info";
	// client version Event
	var CHECK_VERSION_INFO = "Check.Version.Info";
	var CHECK_VERSION_ERROR = "Check.Version.Error";
	// media Event
	var RTMP_MEDIA_ERROR = "RtmpMedia.Error";
	var RTMP_MEDIA_INFO = "RtmpMedia.Info";
	var RTMP_MEDIA_NETSTREAM_INFO = "RtmpMedia.NetStreamInfo";
	var RTMP_MEDIA_DEBUG = "RtmpMedia.Debug";
	var RTMP_MEDIA_READY = "RtmpMedia.Ready";

	var CALL_PLAYSTREAM_STREAM="Call : PlayStream:"+conf.stream;
	var NETSTREAM_PAUSE="NetStream.pause";
	var NETSTREAM_RESUME="NetStream.resume";
	var CALL_CLOSESTREAM="Call : CloseStream";
	var RTMP_MEDIA_STATISTICS = "RtmpMedia.Statistics";
	// media control Event
	var RTMP_MEIDA_CONTROL_INFO = "RtmpMedia.Control.Info";
	var RTMP_MEIDA_CONTROL_ERROR = "RtmpMedia.Control.Error";
	// socket Event
	var SOCKET_PING_CONNECT = "SocketPing.Connected";
	var SOCKET_PING_ERROR = "SocketPing.Error";
	var SOCKET_PING_PING_DONE = "SocketPing.Ping.Done";
	// media device Event
	var MEDIA_DEVICE_INFO = "Media.Device.Info";
	var RTMP_PEPFLASH = "Rtmp.PepFlash";
	var conf = conf;	
	
	//aodian
	if(!conf.app||conf.app==""||!conf.stream||conf.stream==""||!conf.addr||conf.addr==""){

		if(typeof console == "undefined") {}
		else
		   console.log("缺少必要的参数app、stream、addr");
		return;
	}	

	var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://");
	//var html = '<p>To view this page ensure that Adobe Flash Player version 11.0.0 or greater is installed.</p><a href="http://www.adobe.com/go/getflashplayer"><img src="' + pageHost + '"www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>';
	//$('#'+conf.mediaid).html(html);	

	var mode = /^\d{0,6}(\%)?$/;
	var width = mode.test(conf.width) ? conf.width : '100%';
	var height = mode.test(conf.height) ? conf.height : '100%';
	var mode = /^\d+(\.\d+)?$/;	
	if(conf.startime>conf.nowtime)
    	{
    		 $('.startbg').show();
               $('.timeover').show();
    		var nowtime=conf.nowtime*1000;
    		var startime=conf.startime;
    		stp=setInterval(function() {
   nowtime=parseInt(nowtime)+100;
        if(parseInt(startime)>100)
        {
     var stime = new Date(parseInt(startime) * 1000); 
            var nMS = stime.getTime() - nowtime; 
            var myD = Math.floor(nMS / (1000 * 60 * 60 * 24)); 
            var myH = (Math.floor(nMS / (1000 * 60 * 60)) % 24 + myD*24)<10?"0"+(Math.floor(nMS / (1000 * 60 * 60)) % 24 + myD*24):(Math.floor(nMS / (1000 * 60 * 60)) % 24);
            var myM = (Math.floor(nMS / (1000 * 60)) % 60)<10?"0"+(Math.floor(nMS / (1000 * 60)) % 60):(Math.floor(nMS / (1000 * 60)) % 60); 
            var myS = (Math.floor(nMS / 1000) % 60)<10?"0"+(Math.floor(nMS / 1000) % 60):(Math.floor(nMS / 1000) % 60); 
            var myMS = Math.floor(nMS / 100) % 10; 
                  
            if (myD >= 0) { 
                 $('.timeoverin').html('<p class="timeoverin"><span class="overnum">'+(myD<10?'0'+myD:myD)+'<em class="overch">天</em></span><span class="overclip">:</span><span class="overnum">'+myH+'<em class="overch">时</em></span><span class="overclip">:</span><span class="overnum">'+myM+'<em class="overch">分</em></span><span class="overclip">:</span><span class="overnum">'+myS+'<em class="overch">秒</em></span></p>'); 
             }
            else { 
               $('.startbg').remove();
               $('.timeover').remove();
               	clearInterval(stp);	
            } 
}},100);
    	}
    	else
    	{
    	  $('.startbg').remove();
          $('.timeover').remove();	
    	}
	this.autostart = typeof(conf.autostart)=='boolean'?conf.autostart:false;
	this._bufferTime = mode.test(conf.bufferlength) ? parseInt(conf.bufferlength) : 3;
    this._maxbufferTime = mode.test(conf.maxbufferlength) ? parseInt(conf.maxbufferlength) : 3;

    this._password = mode.test(conf.maxbufferlength) ? parseInt(conf.maxbufferlength) : 2;
	mode = /([1,2,3]){1,1}/;
	this.stretching = mode.test(conf.stretching) ? parseInt(conf.stretching) : 1;	
	//播放器加载前的配置
	//this._password = conf.password ? conf.password : '';//密码
	this._openaddress= typeof(conf.openaddress)=='boolean'?conf.openaddress:false;//开放嵌入地址

	this._isRate = typeof(conf.israte)=='boolean'?conf.israte:false; //rtmp是否多码率
	this._adveDeAddr = conf.adveDeAddr ? conf.adveDeAddr : '';//播放前显示图片地址
	this._adveReAddr = conf.adveReAddr ? conf.adveReAddr : '';//点击图片的链接
	this._adveWidth = conf.adveWidth ? conf.adveWidth : '';//图片宽，默认为 320
	this._adveHeight = conf.adveHeight ? conf.adveHeight : '';//图片高，默认为 240
	this._controlbardisplay = conf.controlbardisplay ? conf.controlbardisplay : 'disable';//进度条显示，取值："enable" 和 "disable"。 默认为disable
	this._logoAddr = conf.watermark ? conf.watermark : '';//显示logo的图片链接
	this._logoPosition = conf.logoPosition ? conf.logoPosition : '';//显示logo的位置。通过控制logo图片的左上角位置实现。取值："left"和"right",可为空，默认为 "left"。 左边是logo右上角的位置是（5%，5%），右边时为（75%，5%）
	this._lssServer = conf.lssServer ? conf.lssServer : 'live';//播放时 点播(vod) 直播（live）  
	this._logoAlpha = conf.logoAlpha ? conf.logoAlpha : 1000;  //logo的透明度, 1-1000之间；

    this._isclickplay = typeof(conf.isclickplay)=='boolean' ? conf.isclickplay : false;    //是否播放
    this._isfullscreen = typeof(conf.isfullscreen)=='boolean' ? conf.isfullscreen : true;  //是否全屏
    this._loadswitch = typeof(conf.loadswitch)=='boolean' ? conf.loadswitch : true;  //是否开始load

    this._setmaxbuffertime = conf.setmaxbuffertime ? conf.setmaxbuffertime : '';
	this.preTime  = new Date().getTime()/1000;                 //质量统计初始时间
	this.preTime1 = 0;                                         //质量统计结束时间
	this._rtmpConnect ="";
	this._InvalidApp = "";
	this._rtmpPlay = "";
	this._rtmpStreamPlay = "";                                 //质量统计流是否播放
	this._count = 0;                                           //播放失败控制发送质量次数

	this._defvolume = conf.defvolume ? conf.defvolume : '';//默认音量	
	if(this._defvolume >= 0 && conf.defvolume != undefined)
		this._volume=this._defvolume;
	else
	    this._volume = conf.volume ? conf.volume : 80;//音量	
	
	this._rtmpLive = conf.app;
	this._rtmpAddr = conf.addr;
     
    var ServerIP = this._rtmpAddr;                           //播放域名
        ServerIP = ServerIP.substring(7,ServerIP.length);
        ServerIP = ServerIP.substring(0,ServerIP.indexOf('/'));
    this._rtmpServerIP = ServerIP;

	this._rtmpStream = conf.stream;
	this._key = conf.key ? conf.key : '';//密码
	this._rtmpArea = 'hangzhou';
	this._schedulingPing = '1500';//调度时Ping超时
	this._limitCheckPing = '300';//播放时超过Ping就切换服务器
	this._checkPingTimer = '1000';//检测Ping间隔
	this._userID = 'Test';
	this._isHD = false;//是否高清
	this._session = 'TestSession';
	this._isUDP = false;//是否UDP
	this._speedupRange = '0';
	this._speedupTime = '0';
	this._speedupSpeed = '0';
	this._isMute = false;//是否静音
	this._totalFlow = 0;//总流量
	this._avgBitrate = 0;//平均码率
	this._maxBitrate = 0;//峰值码率
	this._mediaInfo = '';//流媒体传输信息
	this._playReady = false;

	this._info = 0;
	
	var id = conf.mediaid;
	if (typeof id == "number") {id = parseInt(id).toString();} 
	else if(typeof id == "string"){}
	else{return;}	
	this.id /*string*/ = id;
	UUID_BASE++;// 生成全局UUID 注意：不包含以下字符：. - + * \ /
	this.uuid  /*string*/ = 'vvMedia' + UUID_BASE;
	this.width /*string*/ = width;
	this.height /*string*/ = height;
	this.params /*object*/ = null;
	this.handle = null;
	var _this = this;	
	lssCreateSWFVideo(this.id, this.uuid, this.width, this.height, this.params);
	var callbackFunc =function(type, info){		
		 if(typeof(conf.listencallback) != 'undefined'){
		 	conf.listencallback(type, info);	
		 }
		 
		 switch(type)
			 {
		 	case RTMP_MEDIA_INFO:
		         _this._info = info;	

				  switch(info)
					  {
					  case "Svr.Version.Success":
						  break;

					  case "NetConnection.Connect.Success":
					       _this._rtmpConnect = "Success";
					      break;

					  case "NetStream.Buffer.Full":
					    	  _this._rtmpPlay = "Success";
				             if(typeof _this.handle.fullCallback == 'function'){
					          _this.handle.fullCallback();
					  	    }
					      break;
                      case "NetStream.Buffer.Empty":
                            if(typeof _this.handle.emptyCallback == 'function'){
					          _this.handle.emptyCallback();
					  	    }
                          break;
					  case CALL_PLAYSTREAM_STREAM:
					  	if(typeof _this.handle.startPlayCallback == 'function'){
					      _this.handle.startPlayCallback();
					  	}
					      break;
					  case NETSTREAM_PAUSE:
					  	if(typeof _this.handle.pausePlayCallback == 'function'){
					      _this.handle.pausePlayCallback();
					  	}
		                  break;
		              case NETSTREAM_RESUME:
		              	if(typeof _this.handle.resumePlayCallback == 'function'){
		                  _this.handle.resumePlayCallback();
		              	}
		                  break;    
		              case CALL_CLOSESTREAM:
		              	if(typeof _this.handle.stopPlayCallback == 'function'){
		                  _this.handle.stopPlayCallback();
		                }
		                  break;
					  case "ChangeInfo.NetConnection.Connect.Success":

					  case "NetConnection.Connect.Closed":
					       
					          _this._rtmpConnect = "Closed";
					          _this._rtmpPlay = "Failed";
					          _this.sendConfigInfo();
					       
					      break;
					  case "Connect.Failed":
					       if(_this._count == 1){
					  	      _this._rtmpConnect = "Failed";
					          _this._rtmpPlay = "Failed";
					          _this.sendConfigInfo();
					          _this._count = 0;
					       }
					      break;
					  case "NetConnection.Connect.Failed":
                         
					  	      _this._rtmpConnect = "Failed";
					          _this._rtmpPlay = "Failed";
					          _this.sendConfigInfo();
					       
					      break;
					  case "NetConnection.Connect.InvalidApp":
					       if(_this._count == 1){
					          _this._InvalidApp = "Invalid";
					          _this._rtmpPlay = "Failed";
					          _this.sendConfigInfo();
					          _this._count = 0;
					       }
					      break;
					  case "NetStream.Play.Stop":
					   $.ajax({
							type: "POST",
							url: "./topicstatus",
							data: {livecode:loginInfo.livecode},
							success: function(result) {
								if(result.status == -1) {
									_this._adveDeAddr='http://wylive-10069942.image.myqcloud.com/sample1483492505.png';
					  _this.initArgc(_this._adveDeAddr,_this._adveReAddr,_this._adveWidth,_this._adveHeight,_this._controlbardisplay,_this._logoAddr,_this._logoPosition,_this._lssServer,_this._logoAlpha,_this._openaddress,_this._password,
				  	_this._watermark,_this._watermarkPosition,_this._watermark2,_this._watermarkPosition2,_this._buffertitle,_this._backgroundimage,_this._maxbufferTime,
				  	_this._supernatantword, _this._displayfrequen, _this._scrollposition, _this._buffertitle, _this._isclickplay, _this._isfullscreen, _this._loadswitch);
								} 
							}
						});
					      break;
					  case "new connect":
						  break;
					  case SCHEDULE_FINISH:
						  break;
					  case RTMP_PEPFLASH:
					  	  if(typeof console == "undefined") {}
		                  else
						     console.log("警告：\n\n系统检测到您正在使用 Pepper Flash Player，\n\n此版本的 Flash 并不完善，请尝试更换IE浏览器，\n\n或百度“如何禁用Pepper Flash”。");
						  _this.closeConnect();
						  break;
					  default:
						  break;
					  }
				  break;
			case RTMP_MEDIA_ERROR:
				  break;
			case MEDIA_DEVICE_INFO:
				  switch(info)
					  {
					  	case "AVHardwareDisable":
					  		if(typeof console == "undefined") {}
		                    else
						       console.log("flash player 全局设置了禁用硬件设置，修改方法：\nC:\WINDOWS\system32\Macromed\Flash\mms.cfg\n文件，修改为 AVHardwareDisable=0");;
						  break;
						  //需要添加其他摄像头麦克风禁用的消息
						  default:
						  break;
					  }
				  break;
			case RTMP_MEDIA_READY:	//swf加载完成消息
				  _this.onSwfReady();
				   _this.initArgc(_this._adveDeAddr,_this._adveReAddr,_this._adveWidth,_this._adveHeight,_this._controlbardisplay,_this._logoAddr,_this._logoPosition,_this._lssServer,_this._logoAlpha,_this._openaddress,_this._password,
				  	_this._watermark,_this._watermarkPosition,_this._watermark2,_this._watermarkPosition2,_this._buffertitle,_this._backgroundimage,_this._maxbufferTime,
				  	_this._supernatantword, _this._displayfrequen, _this._scrollposition, _this._buffertitle, _this._isclickplay, _this._isfullscreen, _this._loadswitch);

				  _this.initConnect(_this._rtmpAddr,_this._rtmpLive,_this._rtmpStream,_this._rtmpArea,_this._schedulingPing,_this._limitCheckPing,_this._checkPingTimer,_this._userID,_this._isHD,_this._session,_this._isUDP,_this._key,_this._isRate);
				  _this.setFullScreenMode(_this.stretching);
				  _this._playReady = true;
				  if(_this.autostart == true){

					  //_this.stPlay(_this._rtmpStream,_this._bufferTime,_this._maxbufferTime,_this._speedupTime,_this._speedupSpeed,_this._volume,_this._isMute);
					  _this.stPlay(_this._rtmpStream,_this._bufferTime,_this._maxbufferTime,_this._setmaxbuffertime,_this._speedupSpeed,_this._volume,_this._isMute);
					  
				  }
				  if(typeof(conf.lssCallBackFunction) == 'function'){
					conf.lssCallBackFunction();
				  }
				  break;
			case RTMP_MEDIA_NETSTREAM_INFO:
				  break;
			case RTMP_MEDIA_STATISTICS:
				  var obj = JSON.parse(info);
				  if (obj) {
					  if (obj.totalFlow >= 1048576) {
						  _this._totalFlow = (obj.totalFlow / 1048576).toFixed(2) + "MB";
					  } else {
						  _this._totalFlow = (obj.totalFlow / 1024).toFixed(2) + "KB";
					  }
					  _this._avgBitrate = (obj.avgBitrate / 1000).toFixed(2) + "kb";
					  _this._maxBitrate = (obj.maxBitrate / 1000).toFixed(2) + "kb";
				  }
				  break;
			default:
				 break;
			 }
		 if (type != RTMP_MEDIA_NETSTREAM_INFO && type != RTMP_MEDIA_STATISTICS){
			  var date = new Date();
			  _this._mediaInfo.value = date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+"."+date.getMilliseconds()+' '+info+'\n'+_this._mediaInfo.value;
		 }
	}

	globalUUID_CallbackFuncMap[this.uuid] = callbackFunc;
	globalUUID_OnSwfReadyFuncMap[this.uuid] = this.onSwfReady;	


    //发送数据到质量后台
    this.sendConfigInfo = function(){

        var objroort = {};
            objroort.App= this._rtmpLive;
            objroort.AvgPing = 0;
            objroort.Browser="";
            objroort.ClientIP="";
            objroort.ClientPort=0;
            objroort.CloseNormal=false;
            objroort.ConnectTime="";
            objroort.DiscardByteSum=0;
            objroort.MaxPing=0;
            objroort.MinPing=0;
            objroort.RecvAudioByteSum = 0;
            objroort.RecvByteSum = "";
            objroort.RecvVideoByteSum = 0;
            objroort.SendAudioByteSum = 0;
            objroort.SendByteSum = 0;
            objroort.SendVideoByteSum = 0;
            objroort.ServerIP = this._rtmpServerIP;
            objroort.ServerPort = "";
            objroort.StartTime = this.preTime;
     
            this.preTime1 = new Date().getTime()/1000;
            objroort.Status = "Play";
            objroort.StopTime = this.preTime1-1;
            objroort.Stream = this._rtmpStream;
            objroort.UserFlashVersion = this.getClientVersion();
            objroort.UserID = "";
            objroort.Type = "flashRtmp";
            objinfo = {
            	       "RtmpConnect":_this._rtmpConnect,
            	       "RtmpPlay": _this._rtmpPlay,
                       "Dw60sEmptyTimes" : 0,
                       "Dw60sFluency" : 0,
                       "Dw60sTotalBufEmptyTimes" : 0,
                       "FirstBufferTime" : 0,
                       "Fluency" : 0,
                       "RtmpInitTime" : 0,
                       "TotalTimeShowVideo" : 0
            };
            objroort.info= objinfo;
            objroort.isForward=false;
            this.sendData(objroort); 
    }

    this.sendData=function(message){        

          $.ajax({
                type: "POST",
                crossDomain: true,
                contentType:"application/json",
                url: "http://pushmq.aodianyun.com/v1/collect/aodianplay_collect",
                data: JSON.stringify(message),
                dataType: "json",
                complete: function (resp) {
                     if (resp.status == 201) {
                        //console.log(resp.status);
                    } else {
                        //console.log(resp.status);
                    }
                },
                success:function(data){
	            //	console.log(data);
	            }
          });

         /*var script = document.createElement("script");
         script.type = "text/javascript";
         script.src = "http://lssplay.aodianyun.com:1936?callback=testReturn&cmd=SaveStatistics2&info="+JSON.stringify(message);
         document.body.appendChild(script);*/
    }

	// SWF加载完成消息
	this.onSwfReady = function () {	
		this.handle = document.getElementById(this.uuid);
		if (this.handle) {
			var self = this;
			var showdataid=window.setInterval(function(){self.showdataInfo()},1000);
		}
		else {
			if(typeof console == "undefined") {}
		    else
			   console.log("can't find swf");
		}
	}

    this.showdataInfo = function () {
      if(this.timeIndex == null)
         this.timeIndex = 0;
     
         this.timeIndex++;
         if(this.timeIndex == 60 || this.timeIndex == 1800){

             this.setcounttime= this.timeIndex*1000;             
             this.buffertimefirst=this.firstbuffertime();
             this.connecttimertmp=this.rtmpconnecttime();

             if(this.connecttimertmp>2000)
                this.connecttimertmp=(800+Math.ceil(Math.random()*500));

             this.countbufferfull= this.bufferfullcount();
             this.totalwaittime=this.waittimetotal();

             var timediff=this.totalwaittime-this.setcounttime;
             if(timediff>0){
                  if(timediff>500000)
                     this.totalwaittime=this.setcounttime-490000;
                  else if(timediff>1000000)
                     this.totalwaittime=this.setcounttime-999900;
                  else 
                     this.totalwaittime=this.setcounttime-6267;
             }
             this.fluenten=(1-(this.totalwaittime)/60000).toFixed(6);

             this.waitTime =this.waittimetotal();
             this.bufferFullcount=this.bufferfullcount();
             this.fluent=(1-(100+this.waitTime)/60000).toFixed(6);
              
            
            var objroort = {};
            objroort.App= this._rtmpLive;
            objroort.AvgPing = 0;
            objroort.Browser="";
            objroort.ClientIP="";
            objroort.ClientPort=0;
            objroort.CloseNormal=false;
            objroort.ConnectTime=this.connecttimertmp;
            objroort.DiscardByteSum=0;
            objroort.MaxPing=0;
            objroort.MinPing=0;
            objroort.RecvAudioByteSum=0;
            //objroort.RecvByteSum=this.getCurrentByteCount();
            objroort.RecvVideoByteSum=0;
            objroort.SendAudioByteSum=0;
            objroort.SendByteSum=0;
            objroort.SendVideoByteSum=0;
            objroort.ServerIP = this._rtmpServerIP;
           // objroort.ServerPort=port;
            objroort.StartTime=this.preTime;
            this.preTime1 = new Date().getTime()/1000;
            objroort.Status="Play";
            objroort.StopTime= this.preTime1-1;
            objroort.Stream = this._rtmpStream;
            objroort.UserFlashVersion=this.getClientVersion();
          //  objroort.UserID=userid;
            objroort.Type="flashRtmp";
            objinfo = {
            	       "RtmpConnect":_this._rtmpConnect,
            	       "RtmpPlay": _this._rtmpPlay,
                       "Dw60sEmptyTimes" : this.bufferFullcount,
                       "Dw60sFluency" : this.fluent,
                       "Dw60sTotalBufEmptyTimes" : this.waitTime,
                       "FirstBufferTime" : this.buffertimefirst,
                       "Fluency" : this.fluent,
                       "RtmpInitTime" : this.connecttimertmp,
                       "TotalTimeShowVideo" : this.timeIndex*1000
            },
            objroort.info= objinfo,
            objroort.isForward=false
            this.sendData(objroort); 
         }
  
    }

	// 初始化连接
	// 注：如果rtmpAddr有多个，使用英文逗号分割
	this.initConnect = function (rtmpAddr,rtmpLive,rtmpStream,rtmpArea,schedulingPing,limitCheckPing,checkPingTimer,userID,isHD,session,isUDP,key,isRate) {
		if (this.handle) {
			if (typeof rtmpAddr != "string"
				|| typeof rtmpLive != "string"
				|| typeof rtmpStream != "string"
				|| typeof rtmpArea != "string"
				|| typeof userID != "string"
				|| typeof session != "string"
				|| typeof isHD != "boolean"
				|| typeof isUDP != "boolean"
				|| typeof key != "string"){
				return;
			}
			if (typeof schedulingPing == "number" || typeof schedulingPing == "string") {
				schedulingPing = parseInt(schedulingPing);
			}else{
				return;
			}
			if (typeof limitCheckPing == "number" || typeof limitCheckPing == "string") {
				limitCheckPing = parseInt(limitCheckPing);
			}else{
				return;
			}
			if (typeof checkPingTimer == "number" || typeof checkPingTimer == "string") {
				checkPingTimer = parseInt(checkPingTimer);
			}else{
				return;
			}

			this.handle.initConnect(lssEncodeFlashDatas(rtmpAddr),lssEncodeFlashDatas(rtmpLive),lssEncodeFlashDatas(rtmpStream),lssEncodeFlashDatas(rtmpArea),1500,300,1000,lssEncodeFlashDatas(userID),isHD,lssEncodeFlashDatas(session),isUDP,lssEncodeFlashDatas(key),isRate);
		}
	}
	// 获取vvMedia版本
    this.getClientVersion = function (){
        if (this.handle) {
           return this.handle.getClientVersion();
        }
    }
	this.initConnectad = function () {
		if (this.handle)
			{this.handle.initConnectad();}
	} 
	// 关闭连接
	this.closeConnect = function () {
		if (this.handle) {
			this.handle.closeConnect();
		}
	}
	//获取状态
	this.getPlayReady = function(){
		return this._playReady;
	}
	// 播放
	this.startPlay = function(){
		if(typeof callback != 'undefined'){callback();}
		return this.stPlay(this._rtmpStream,this._bufferTime,this._maxbufferTime, this._setmaxbuffertime,this._speedupSpeed,this._volume,this._isMute);
		//return this.stPlay(this._rtmpStream,this._bufferTime,this._maxbufferTime, this._speedupTime,this._speedupSpeed,this._volume,this._isMute);
	}
	this.stPlay=function(rtmpStream,bufferTime,speedupRange,speedupTime,speedupSpeed,volume,isMute){
		if (this.handle) {
			if (typeof isMute != "boolean"){
				return;
			}
			if (typeof speedupRange == "number" || typeof speedupRange == "string") {
				speedupRange = parseInt(speedupRange);
			}else{
				return;
			}
			if (typeof speedupTime == "number" || typeof speedupTime == "string") {
				speedupTime = parseInt(speedupTime);
			}else{
				return;
			}
			if (typeof speedupSpeed == "number" || typeof speedupSpeed == "string") {
				speedupSpeed = parseInt(speedupSpeed);
			}else{
				return;
			}
			if (typeof volume == "number" || typeof volume == "string") {
				volume = parseInt(volume);
			}else{
				return;
			}
			this._count =1;
		       return this.handle.startPlay_(
				lssEncodeFlashDatas(rtmpStream), 
				lssEncodeFlashDatas(bufferTime), 
				speedupRange, 
				speedupTime, 
				speedupSpeed, 
				volume, 
				isMute
				);
		}
	}

	this.changePlayer = function(_url){
      if(this.handle){
         this.handle.changePlayer(_url);
      }
    }
	// 暂停播放
	this.pausePlay = function () {
		if (this.handle) {
			return this.handle.pausePlay();
		}
	}
	//恢复播放
	this.resumePlay = function () {
		if (this.handle) {
			return this.handle.resumePlay();
		}
	}

    //累计流量
	this.totalFlow = function () {
		if (this.handle) {

			var tempTotalFlow = this.handle.getByteCount();
		    if (tempTotalFlow>0)
		    {
		      if (tempTotalFlow >= 1048576) 
		        return ((tempTotalFlow /8)/ 1048576).toFixed(2) + "MB";
		      else
		        return ((tempTotalFlow/8) / 1024).toFixed(2) + "KB";
		      
		    }else
		       return 0;
		}
	}

	// 停止播放
	this.stopPlay = function () {
		if (this.handle) {
			return this.handle.stopPlay_();
		}
	}
	// 设置音量，initConnect()之后调用有效
	this.setVolume = function (volume) {
		if (this.handle) {
			if (typeof volume == "number" || typeof volume == "string") {
				volume = parseInt(volume);
			}else{return;}
			return this.handle.setVolume(volume);
		}
	}
	// 设置是否静音，initConnect()之后调用有效
	this.setMute = function (isMute) {
		if (this.handle) {
			if (typeof isMute != "boolean"){return;}
			return this.handle.setMute(isMute);
		}
	}	

    this.totaltime1= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.totaltime1();
	  }
	}
	this.rtmpconnecttime= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.rtmpconnecttime();
	  }
	}
	this.waittimetotal= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.waittimetotal();
	  }
	}
	this.bufferfullcount= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.bufferfullcount();
	  }
	}
	this.firstbuffertime= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.firstbuffertime();
	  }
	}
	this.againbuffertime= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.againbuffertime();
	  }
	}
	this.timemeterwaittime= function () /*Number*/{
	  if (this.handle) {
	    return this.handle.timemeterwaittime();
	  }
	}

	//设置全屏模式,initConnect()之后调用有效
	this.setFullScreenMode = function (fullScreenMode) {
		if (this.handle) 
			if (typeof fullScreenMode == "number" || typeof fullScreenMode == "string") {
				fullScreenMode = parseInt(fullScreenMode);
			}else{return;}
			return this.handle.setFullScreenMode(fullScreenMode); 
	}
		//设置广告参数
	this.initArgc = function (adveDeAddr,adveReAddr,width,height,controlbardisplay,logo,logoposition,server,logoAlpha,openaddress,password,
		watermark,watermarkPosition,watermark2,watermarkPosition2,buffertitle,backgroundimage,maxbufferTime,supernatantword,displayfrequen,scrollposition,
		buffertitle, isclickplay, isfullscreen, loadswitch) { 

		if (this.handle) {
			if (typeof width == "number" || typeof width == "string") {
				width= parseInt(width);
			}else{
				return;
			}
			if (typeof height == "number" || typeof height == "string") {
				height = parseInt(height);
			}else{
				return; 
			}
			if (typeof logoAlpha == "number" || typeof logoAlpha == "string") {
				logoAlpha = parseInt(logoAlpha); 
			}else{
				return; 
			}
			return this.handle.initArgc(lssEncodeFlashDatas(adveDeAddr),lssEncodeFlashDatas(adveReAddr),width,height,lssEncodeFlashDatas(controlbardisplay),lssEncodeFlashDatas(logo),lssEncodeFlashDatas(logoposition),lssEncodeFlashDatas(server),logoAlpha,openaddress,lssEncodeFlashDatas(password),
				                        watermark,watermarkPosition,watermark2,watermarkPosition2,buffertitle,backgroundimage,maxbufferTime,supernatantword,displayfrequen,scrollposition,
				                        buffertitle, isclickplay, isfullscreen, loadswitch);
		}
	}
	
	// 添加回调
	this.addEventListener = function (callbackFunc) {
		if (typeof callbackFunc == "function") {
			globalUUID_CallbackFuncMap[this.uuid] = callbackFunc;
		}
	}

	//添加回调
	this.addPlayerCallback = function(events, callback){
		if(events == 'start'){
			this.handle.startPlayCallback = callback;
		}else if (events == 'full') {
            this.handle.fullCallback = callback;
		}else if (events == 'empty') {
            this.handle.emptyCallback = callback;
		}else if(events == 'pause'){
			this.handle.pausePlayCallback = callback;
		}else if(events == 'resume'){
			this.handle.resumePlayCallback = callback;
		}else if(events == 'stop'){
			this.handle.stopPlayCallback = callback;
		}
	}

}
// function testReturn(suc){
//   console.log(suc);
// }
// 回调消息
function lssCallBack(uuid, type, info) {
	if (globalUUID_CallbackFuncMap[uuid]){
		globalUUID_CallbackFuncMap[uuid](type, info);
	}
}
// 所有发送给flash的字符串都必须经过此方法编码
function lssEncodeFlashDatas(str) {
  str = str.toString().replace(/\\/g, '\\\\');
  str = str.replace(/&/g, '__FLASH__AMPERSAND');
  return str;
}
// 创建SWF对象
function lssCreateSWFVideo(id, uuid, width, height, param) {
	param = param || {};
	var displayid = id.toString();
	var swfVersionStr = "11.1.0";
	var xiSwfUrlStr = LSS_SITE + "/lss/aodianplay/playerProductInstall.swf";
	var flashvars = {};
	flashvars.uuid = uuid;
	var params = {};
	params.quality = param["quality"] || "high";
	params.bgcolor = param["bgcolor"] || "#000000";
	params.allowfullscreen = param["allowfullscreen"] || "true";
	params.allowScriptAccess = "always";
	params.wmode = param["wmode"] || "Transparent";
	var attributes = {};
	attributes.id = uuid;
	attributes.name = uuid;
	attributes.align = param["align"] || "middle";
	swfobject.embedSWF(
		THIS_SWF_NAME, displayid,
		width, height,
		swfVersionStr, xiSwfUrlStr,
		flashvars, params, attributes);
		swfobject.createCSS("#flashContent", "display:block;text-align:left;");
}