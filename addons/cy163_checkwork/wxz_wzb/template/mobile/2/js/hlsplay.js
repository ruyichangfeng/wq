var swfobject=function(){var D="undefined",r="object",T="Shockwave Flash",Z="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",S="SWFObjectExprInst",x="onreadystatechange",Q=window,h=document,t=navigator,V=false,X=[],o=[],P=[],K=[],I,p,E,B,L=false,a=false,m,G,j=true,l=false,O=function(){var ad=typeof h.getElementById!=D&&typeof h.getElementsByTagName!=D&&typeof h.createElement!=D,ak=t.userAgent.toLowerCase(),ab=t.platform.toLowerCase(),ah=ab?/win/.test(ab):/win/.test(ak),af=ab?/mac/.test(ab):/mac/.test(ak),ai=/webkit/.test(ak)?parseFloat(ak.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,aa=t.appName==="Microsoft Internet Explorer",aj=[0,0,0],ae=null;if(typeof t.plugins!=D&&typeof t.plugins[T]==r){ae=t.plugins[T].description;if(ae&&(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&t.mimeTypes[q].enabledPlugin)){V=true;aa=false;ae=ae.replace(/^.*\s+(\S+\s+\S+$)/,"$1");aj[0]=n(ae.replace(/^(.*)\..*$/,"$1"));aj[1]=n(ae.replace(/^.*\.(.*)\s.*$/,"$1"));aj[2]=/[a-zA-Z]/.test(ae)?n(ae.replace(/^.*[a-zA-Z]+(.*)$/,"$1")):0}}else{if(typeof Q.ActiveXObject!=D){try{var ag=new ActiveXObject(Z);if(ag){ae=ag.GetVariable("$version");if(ae){aa=true;ae=ae.split(" ")[1].split(",");aj=[n(ae[0]),n(ae[1]),n(ae[2])]}}}catch(ac){}}}return{w3:ad,pv:aj,wk:ai,ie:aa,win:ah,mac:af}}(),i=function(){if(!O.w3){return}if((typeof h.readyState!=D&&(h.readyState==="complete"||h.readyState==="interactive"))||(typeof h.readyState==D&&(h.getElementsByTagName("body")[0]||h.body))){f()}if(!L){if(typeof h.addEventListener!=D){h.addEventListener("DOMContentLoaded",f,false)}if(O.ie){h.attachEvent(x,function aa(){if(h.readyState=="complete"){h.detachEvent(x,aa);f()}});if(Q==top){(function ac(){if(L){return}try{h.documentElement.doScroll("left")}catch(ad){setTimeout(ac,0);return}f()}())}}if(O.wk){(function ab(){if(L){return}if(!/loaded|complete/.test(h.readyState)){setTimeout(ab,0);return}f()}())}}}();function f(){if(L||!document.getElementsByTagName("body")[0]){return}try{var ac,ad=C("span");ad.style.display="none";ac=h.getElementsByTagName("body")[0].appendChild(ad);ac.parentNode.removeChild(ac);ac=null;ad=null}catch(ae){return}L=true;var aa=X.length;for(var ab=0;ab<aa;ab++){X[ab]()}}function M(aa){if(L){aa()}else{X[X.length]=aa}}function s(ab){if(typeof Q.addEventListener!=D){Q.addEventListener("load",ab,false)}else{if(typeof h.addEventListener!=D){h.addEventListener("load",ab,false)}else{if(typeof Q.attachEvent!=D){g(Q,"onload",ab)}else{if(typeof Q.onload=="function"){var aa=Q.onload;Q.onload=function(){aa();ab()}}else{Q.onload=ab}}}}}function Y(){var aa=h.getElementsByTagName("body")[0];var ae=C(r);ae.setAttribute("style","visibility: hidden;");ae.setAttribute("type",q);var ad=aa.appendChild(ae);if(ad){var ac=0;(function ab(){if(typeof ad.GetVariable!=D){try{var ag=ad.GetVariable("$version");if(ag){ag=ag.split(" ")[1].split(",");O.pv=[n(ag[0]),n(ag[1]),n(ag[2])]}}catch(af){O.pv=[8,0,0]}}else{if(ac<10){ac++;setTimeout(ab,10);return}}aa.removeChild(ae);ad=null;H()}())}else{H()}}function H(){var aj=o.length;if(aj>0){for(var ai=0;ai<aj;ai++){var ab=o[ai].id;var ae=o[ai].callbackFn;var ad={success:false,id:ab};if(O.pv[0]>0){var ah=c(ab);if(ah){if(F(o[ai].swfVersion)&&!(O.wk&&O.wk<312)){w(ab,true);if(ae){ad.success=true;ad.ref=z(ab);ad.id=ab;ae(ad)}}else{if(o[ai].expressInstall&&A()){var al={};al.data=o[ai].expressInstall;al.width=ah.getAttribute("width")||"0";al.height=ah.getAttribute("height")||"0";if(ah.getAttribute("class")){al.styleclass=ah.getAttribute("class")}if(ah.getAttribute("align")){al.align=ah.getAttribute("align")}var ak={};var aa=ah.getElementsByTagName("param");var af=aa.length;for(var ag=0;ag<af;ag++){if(aa[ag].getAttribute("name").toLowerCase()!="movie"){ak[aa[ag].getAttribute("name")]=aa[ag].getAttribute("value")}}R(al,ak,ab,ae)}else{b(ah);if(ae){ae(ad)}}}}}else{w(ab,true);if(ae){var ac=z(ab);if(ac&&typeof ac.SetVariable!=D){ad.success=true;ad.ref=ac;ad.id=ac.id}ae(ad)}}}}}X[0]=function(){if(V){Y()}else{H()}};function z(ac){var aa=null,ab=c(ac);if(ab&&ab.nodeName.toUpperCase()==="OBJECT"){if(typeof ab.SetVariable!==D){aa=ab}else{aa=ab.getElementsByTagName(r)[0]||ab}}return aa}function A(){return !a&&F("6.0.65")&&(O.win||O.mac)&&!(O.wk&&O.wk<312)}function R(ad,ae,aa,ac){var ah=c(aa);aa=W(aa);a=true;E=ac||null;B={success:false,id:aa};if(ah){if(ah.nodeName.toUpperCase()=="OBJECT"){I=J(ah);p=null}else{I=ah;p=aa}ad.id=S;if(typeof ad.width==D||(!/%$/.test(ad.width)&&n(ad.width)<310)){ad.width="310"}if(typeof ad.height==D||(!/%$/.test(ad.height)&&n(ad.height)<137)){ad.height="137"}var ag=O.ie?"ActiveX":"PlugIn",af="MMredirectURL="+encodeURIComponent(Q.location.toString().replace(/&/g,"%26"))+"&MMplayerType="+ag+"&MMdoctitle="+encodeURIComponent(h.title.slice(0,47)+" - Flash Player Installation");if(typeof ae.flashvars!=D){ae.flashvars+="&"+af}else{ae.flashvars=af}if(O.ie&&ah.readyState!=4){var ab=C("div");
aa+="SWFObjectNew";ab.setAttribute("id",aa);ah.parentNode.insertBefore(ab,ah);ah.style.display="none";y(ah)}u(ad,ae,aa)}}function b(ab){if(O.ie&&ab.readyState!=4){ab.style.display="none";var aa=C("div");ab.parentNode.insertBefore(aa,ab);aa.parentNode.replaceChild(J(ab),aa);y(ab)}else{ab.parentNode.replaceChild(J(ab),ab)}}function J(af){var ae=C("div");if(O.win&&O.ie){ae.innerHTML=af.innerHTML}else{var ab=af.getElementsByTagName(r)[0];if(ab){var ag=ab.childNodes;if(ag){var aa=ag.length;for(var ad=0;ad<aa;ad++){if(!(ag[ad].nodeType==1&&ag[ad].nodeName=="PARAM")&&!(ag[ad].nodeType==8)){ae.appendChild(ag[ad].cloneNode(true))}}}}}return ae}function k(aa,ab){var ac=C("div");ac.innerHTML="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'><param name='movie' value='"+aa+"'>"+ab+"</object>";return ac.firstChild}function u(ai,ag,ab){var aa,ad=c(ab);ab=W(ab);if(O.wk&&O.wk<312){return aa}if(ad){var ac=(O.ie)?C("div"):C(r),af,ah,ae;if(typeof ai.id==D){ai.id=ab}for(ae in ag){if(ag.hasOwnProperty(ae)&&ae.toLowerCase()!=="movie"){e(ac,ae,ag[ae])}}if(O.ie){ac=k(ai.data,ac.innerHTML)}for(af in ai){if(ai.hasOwnProperty(af)){ah=af.toLowerCase();if(ah==="styleclass"){ac.setAttribute("class",ai[af])}else{if(ah!=="classid"&&ah!=="data"){ac.setAttribute(af,ai[af])}}}}if(O.ie){P[P.length]=ai.id}else{ac.setAttribute("type",q);ac.setAttribute("data",ai.data)}ad.parentNode.replaceChild(ac,ad);aa=ac}return aa}function e(ac,aa,ab){var ad=C("param");ad.setAttribute("name",aa);ad.setAttribute("value",ab);ac.appendChild(ad)}function y(ac){var ab=c(ac);if(ab&&ab.nodeName.toUpperCase()=="OBJECT"){if(O.ie){ab.style.display="none";(function aa(){if(ab.readyState==4){for(var ad in ab){if(typeof ab[ad]=="function"){ab[ad]=null}}ab.parentNode.removeChild(ab)}else{setTimeout(aa,10)}}())}else{ab.parentNode.removeChild(ab)}}}function U(aa){return(aa&&aa.nodeType&&aa.nodeType===1)}function W(aa){return(U(aa))?aa.id:aa}function c(ac){if(U(ac)){return ac}var aa=null;try{aa=h.getElementById(ac)}catch(ab){}return aa}function C(aa){return h.createElement(aa)}function n(aa){return parseInt(aa,10)}function g(ac,aa,ab){ac.attachEvent(aa,ab);K[K.length]=[ac,aa,ab]}function F(ac){ac+="";var ab=O.pv,aa=ac.split(".");aa[0]=n(aa[0]);aa[1]=n(aa[1])||0;aa[2]=n(aa[2])||0;return(ab[0]>aa[0]||(ab[0]==aa[0]&&ab[1]>aa[1])||(ab[0]==aa[0]&&ab[1]==aa[1]&&ab[2]>=aa[2]))?true:false}function v(af,ab,ag,ae){var ad=h.getElementsByTagName("head")[0];if(!ad){return}var aa=(typeof ag=="string")?ag:"screen";if(ae){m=null;G=null}if(!m||G!=aa){var ac=C("style");ac.setAttribute("type","text/css");ac.setAttribute("media",aa);m=ad.appendChild(ac);if(O.ie&&typeof h.styleSheets!=D&&h.styleSheets.length>0){m=h.styleSheets[h.styleSheets.length-1]}G=aa}if(m){if(typeof m.addRule!=D){m.addRule(af,ab)}else{if(typeof h.createTextNode!=D){m.appendChild(h.createTextNode(af+" {"+ab+"}"))}}}}function w(ad,aa){if(!j){return}var ab=aa?"visible":"hidden",ac=c(ad);if(L&&ac){ac.style.visibility=ab}else{if(typeof ad==="string"){v("#"+ad,"visibility:"+ab)}}}function N(ab){var ac=/[\\\"<>\.;]/;var aa=ac.exec(ab)!=null;return aa&&typeof encodeURIComponent!=D?encodeURIComponent(ab):ab}var d=function(){if(O.ie){window.attachEvent("onunload",function(){var af=K.length;for(var ae=0;ae<af;ae++){K[ae][0].detachEvent(K[ae][1],K[ae][2])}var ac=P.length;for(var ad=0;ad<ac;ad++){y(P[ad])}for(var ab in O){O[ab]=null}O=null;for(var aa in swfobject){swfobject[aa]=null}swfobject=null})}}();return{registerObject:function(ae,aa,ad,ac){if(O.w3&&ae&&aa){var ab={};ab.id=ae;ab.swfVersion=aa;ab.expressInstall=ad;ab.callbackFn=ac;o[o.length]=ab;w(ae,false)}else{if(ac){ac({success:false,id:ae})}}},getObjectById:function(aa){if(O.w3){return z(aa)}},embedSWF:function(af,al,ai,ak,ab,ae,ad,ah,aj,ag){var ac=W(al),aa={success:false,id:ac};if(O.w3&&!(O.wk&&O.wk<312)&&af&&al&&ai&&ak&&ab){w(ac,false);M(function(){ai+="";ak+="";var an={};if(aj&&typeof aj===r){for(var aq in aj){an[aq]=aj[aq]}}an.data=af;an.width=ai;an.height=ak;var ar={};if(ah&&typeof ah===r){for(var ao in ah){ar[ao]=ah[ao]}}if(ad&&typeof ad===r){for(var am in ad){if(ad.hasOwnProperty(am)){var ap=(l)?encodeURIComponent(am):am,at=(l)?encodeURIComponent(ad[am]):ad[am];if(typeof ar.flashvars!=D){ar.flashvars+="&"+ap+"="+at}else{ar.flashvars=ap+"="+at}}}}if(F(ab)){var au=u(an,ar,al);if(an.id==ac){w(ac,true)}aa.success=true;aa.ref=au;aa.id=au.id}else{if(ae&&A()){an.data=ae;R(an,ar,al,ag);return}else{w(ac,true)}}if(ag){ag(aa)}})}else{if(ag){ag(aa)}}},switchOffAutoHideShow:function(){j=false},enableUriEncoding:function(aa){l=(typeof aa===D)?true:aa},ua:O,getFlashPlayerVersion:function(){return{major:O.pv[0],minor:O.pv[1],release:O.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(ac,ab,aa){if(O.w3){return u(ac,ab,aa)}else{return undefined}},showExpressInstall:function(ac,ad,aa,ab){if(O.w3&&A()){R(ac,ad,aa,ab)}},removeSWF:function(aa){if(O.w3){y(aa)}},createCSS:function(ad,ac,ab,aa){if(O.w3){v(ad,ac,ab,aa)}},addDomLoadEvent:M,addLoadEvent:s,getQueryParamValue:function(ad){var ac=h.location.search||h.location.hash;
if(ac){if(/\?/.test(ac)){ac=ac.split("?")[1]}if(ad==null){return N(ac)}var ab=ac.split("&");for(var aa=0;aa<ab.length;aa++){if(ab[aa].substring(0,ab[aa].indexOf("="))==ad){return N(ab[aa].substring((ab[aa].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var aa=c(S);if(aa&&I){aa.parentNode.replaceChild(I,aa);if(p){w(p,true);if(O.ie){I.style.display="block"}}if(E){E(B)}}a=false}},version:"2.3"}}();

var UUID_BASE = 0;
var globalUUID_CallbackFuncMap = {};
var globalUUID_OnSwfReadyFuncMap = {};
var THISHLS_SWF_NAME = null;
var xiSwfUrlStr = null;

// play Event
function hlsplayerRun(conf){
	var HLS_MEDIA_READY = "hlsmedia.meady";
	var HLS_MEDIA_ERROR = "hlsmedia.error";
	var HLS_PLAYSTREAM  = "hlsPlayStream";
	var HLS_CLOSESTREAM = "hlsCloseStream";
	var HLS_NETSTREAM_RESUME = "hlsNetStream.resume";
	var HLS_NETSTREAM_PAUSE = "hlsNetStream.pause"; 
	var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://");
	var html = '<p>To view this page ensure that Adobe Flash Player version 11.0.0 or greater is installed.</p><a href="http://www.adobe.com/go/getflashplayer"><img src="' + pageHost + '"www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>';
	var mode = /^\d{0,6}(\%)?$/;
	var width = mode.test(conf.width) ? conf.width : '100%';
	var height = mode.test(conf.height) ? conf.height : '100%';	
	var _showdataid = null;
	$('#'+conf.mediaid).html(html);	
	var mode = /^\d+(\.\d+)?$/;	
	this.autostart = typeof(conf.autostart)=='boolean'?conf.autostart:false;
	this._openaddress= typeof(conf.openaddress)=='boolean'?conf.openaddress:false;//���ŵ�ַ

	this._adveDeAddr = conf.adveDeAddr ? conf.adveDeAddr : '';//����ǰ��ʾͼƬ��ַ
	this._adveWidth = conf.adveWidth ? conf.adveWidth : '';//ͼƬ��Ĭ��Ϊ 320
	this._adveHeight = conf.adveHeight ? conf.adveHeight : '';//ͼƬ�ߣ�Ĭ��Ϊ 240
	this._logoAddr = conf.logoAddr ? conf.logoAddr : '';//logo
    this._logoPosition = conf.logoPosition ? conf.logoPosition : 'left';//logoλ��
    this._adveReAddr = conf.adveReAddr ? conf.adveReAddr : '';//���ͼƬ������

    this._watermark = conf.watermark ? conf.watermark : '';//ˮӡ
    this._watermarkPosition = conf.watermarkPosition ? conf.watermarkPosition : 'leftupper';//ˮӡλ��
    this._watermark2 = conf.watermark2 ? conf.watermark2 : '';//ˮӡ2
    this._watermarkPosition2 = conf.watermarkPosition2 ? conf.watermarkPosition2 : 'leftupper';//ˮӡ2λ��

    this._buffertitle = conf.buffertitle ? conf.buffertitle : '';//����Ƭͷ
    this._backgroundimage = conf.backgroundimage ? conf.backgroundimage : '';//����ͼƬ
    this._supernatantword = conf.supernatantword ? conf.supernatantword : '';      //��������
	this._displayfrequen = conf.displayfrequen ? conf.displayfrequen : '5min';     //��ʾƵ��
	this._scrollposition = conf.scrollposition ? conf.scrollposition : 'upperpart';//����λ��

	this._bufferTime = mode.test(conf.bufferlength) ? parseInt(conf.bufferlength) : 3;
    this._maxbufferTime = mode.test(conf.maxbufferlength) ? parseInt(conf.maxbufferlength) : 3;
    this._password = conf.password ? conf.password : undefined;//��������
	mode = /([1,2,3]){1,1}/;
	this.stretching = mode.test(conf.stretching) ? parseInt(conf.stretching) : 1;
	//����������ǰ������
	
	this._volume = conf.volume ? conf.volume : 80;//����	
	this._isMute = false;//�Ƿ���
	this._playReady = false;
	
	var id=conf.mediaid;
	if (typeof id == "number") {id = parseInt(id).toString();} 
	else if(typeof id == "string"){}
	else{return;}	
	this.id /*string*/ = id;
	UUID_BASE++;// ����ȫ��UUID ע�⣺�����������ַ���. - + * \ /
	this.uuid  /*string*/ = 'hlsMedia' + UUID_BASE;
	this.width /*string*/ = width;
	this.height /*string*/ = height;
	this.params /*object*/ = null;
	this.handle = null;
	var _this = this;
	this._hlsUrl=conf.hlsUrl;
	this._controlbardisplay = conf.controlbardisplay ? conf.controlbardisplay : 'enable';//��������ʾ��ȡֵ��"enable" �� "disable"�� Ĭ��Ϊdisable
	
    this._hlsConnect =""; //�����Ƿ�ɹ�
    this._hlsPlay = "";   //�����Ƿ�ɹ�

	//THISHLS_SWF_NAME = 'http://'+ conf.uin +'.long-vod.cdn.aodianyun.com/mpsv1/player.swf?v=' + new Date().getTime();
	//xiSwfUrlStr = 'http://'+ conf.uin +'.long-vod.cdn.aodianyun.com/mps/playerProductInstall.swf?v=' + new Date().getTime();

    THISHLS_SWF_NAME = 'http://cdn.aodianyun.com/lss/aodianplay/player.swf?v=12121212';// + new Date().getTime();
	xiSwfUrlStr = 'http://cdn.aodianyun.com/lss/aodianplay/playerProductInstall.swf?v=1222';// + new Date().getTime();

	hlsCreateSWFVideo(this.id, this.uuid, this.width, this.height, this.params);	
	var callbackFunc =function(info){	
		 if(typeof(conf.listencallback) != 'undefined'){
		 	conf.listencallback(info);	
		 }
		 switch(info)
                     {
                       case HLS_MEDIA_READY:
      						_this.onSwfReady();   
      						_this.initArgc(_this._adveDeAddr,_this._adveWidth,_this._adveHeight,_this._logoAddr,_this._logoPosition,_this._adveReAddr,_this._watermark,
      							_this._watermarkPosition,_this._watermark2,_this._watermarkPosition2,_this._buffertitle,_this._backgroundimage,
      							_this._supernatantword, _this._displayfrequen, _this._scrollposition);
                            _this.initConnect(_this._hlsUrl,_this._controlbardisplay,_this._openaddress);
      						_playReady=true;     
      						  if(_this.autostart == true)
					              _this.startPlay();
				        
				             if(conf.onReady) conf.onReady();

      						if(typeof(conf.lssCallBackFunction) == 'function'){
								conf.lssCallBackFunction();}
                            break;
                       case HLS_PLAYSTREAM:
                            if(typeof _this.handle.startPlayCallback == 'function'){
						      _this.handle.startPlayCallback();
						  	}
                            break;
                       case "hlsslider.start":
                            console.log(info);
                               if(typeof _this.handle.SliderstartCallback == 'function'){
						      _this.handle.SliderstartCallback();
						  	}
                            break;
                       case "hlsslider.end":
                            console.log(info);
                               if(typeof _this.handle.SliderendPlayCallback == 'function'){
						      _this.handle.SliderendPlayCallback();
						  	}
                            break;
                       case "Play.Stop":
                           if(typeof _this.handle.playStopCallback == 'function'){
						      _this.handle.playStopCallback();
						  	}
                            break;         
                       case "NetStream.Buffer.Empty":
                            console.log(info);
                               if(typeof _this.handle.emptyPlayCallback == 'function'){
						      _this.handle.emptyPlayCallback();
						  	}
                            break; 
                       case "NetStream.Buffer.Full":
                            console.log(info);
                               if(typeof _this.handle.fullPlayCallback == 'function'){
						      _this.handle.fullPlayCallback();
						  	}
                            _this._hlsConnect ="success";
                            _this._hlsPlay = "success";  
                            break;     
                       case HLS_CLOSESTREAM:
                            if(typeof _this.handle.stopPlayCallback == 'function'){
			                  _this.handle.stopPlayCallback();
			                }
                            break;
                       case HLS_NETSTREAM_RESUME:
                            if(typeof _this.handle.resumePlayCallback == 'function'){
			                  _this.handle.resumePlayCallback();
			              	}
                            break;
                       case HLS_NETSTREAM_PAUSE:
                            if(typeof _this.handle.pausePlayCallback == 'function'){
						      _this.handle.pausePlayCallback();
						  	}
                            break;         
                       case HLS_MEDIA_ERROR:
                            break;
                       default:
                            break;
                     }		
		 
	};

    
    this.sendRecordInfo = function(){
      
       if(this.timeIndex == null)
           this.timeIndex = 0;

           this.timeIndex++;
       if(this.timeIndex == 60 || this.timeIndex == 1800 || this.timeIndex == 3600){
     
          this.waitTime = this.totalwaittime();
       	  this.fluent = ( 1 - this.waitTime / (this.timeIndex * 1000) ).toFixed(6);
          var objroortRecordInfo = {};
    	      objroortRecordInfo.App = conf.lssApp;                                 //app
			  objroortRecordInfo.Stream = conf.lssStream;                           //strteam
			  objroortRecordInfo.PlayDomainName = conf.hlsDomain;                   //���ŵ�����
			  objroortRecordInfo.MPSId = conf.appId;                                //mpsʵ��id
			  objroortRecordInfo.PlayerId = conf.mpsId;                             //������id
			  objroortRecordInfo.Website = window.location.href;                    //���ŵ�ҳ������
			  objroortRecordInfo.FlashPlayerVersion = this.getClientVersion();      //flash �汾��
			  objroortRecordInfo.ConnectStatus = _this._hlsConnect;          	    //����״̬�ɹ�����ʧ��
			  objroortRecordInfo.PlayStatus = _this._hlsPlay;          	 		    //�����Ƿ�ɹ���������������������� ����ɹ���ֻ������ʧ��
			  objroortRecordInfo.PlayTimeLength = this.timeIndex * 1000;            //60��1800 ��3600���˳���ʱ��ʱ��  ���ŵ�����
			  objroortRecordInfo.RtmpInitTime = this.getbeforetime();               //��һ�λ���ʱ��//rtmp��ʼ����ʱ��
			  objroortRecordInfo.FluencyPercent = this.fluent;                      //������
			  objroortRecordInfo.EmptyTimes = this.getfullcount();                  //���ٴ���
			  objroortRecordInfo.AudioMaxBufferTime = this.getaudioBufferLength();  //��Ƶ��󻺳���
			  objroortRecordInfo.VideoMaxBufferTime = this.getvideoBufferLength();  //��Ƶ��󻺳���
			  objroortRecordInfo.SetMaxBufferTime = '';                             //���õ���󻺳���
			  objroortRecordInfo.SetPlayBufferTime = '';                            //���õĿ�ʼ���Ż�����
			  objroortRecordInfo.AverageBitrate = '';                               //ƽ������
			  objroortRecordInfo.BrowserType = this.getBrowserInfo();               //���������
			  objroortRecordInfo.ADUin = conf.uin;                                  //�µ����˺ŵ�id
			  objroortRecordInfo.SrcIp = '';                                        //�û�id
			  objroortRecordInfo.Cur_Time = '';                                     //ʱ���
          
              $.ajax({
                	type: "POST",
                	crossDomain: true,
                	contentType:"application/json",
                	url: "http://pushmq.aodianyun.com/v1/collect/Mps_RecordInfo",
                	data: JSON.stringify(objroortRecordInfo),
                	dataType: "json",
                	complete: function (resp) {
                     	if (resp.status == 201) {}
                        	//console.log(resp.status);
                     	else 
                        	console.log(resp.status);
                	},
                	success:function(data){
	            	}
              });

          if(this.timeIndex == 3600)
             clearInterval(_showdataid);
        }
    }


	globalUUID_CallbackFuncMap[this.uuid] = callbackFunc;

	// SWF���������Ϣ
	this.onSwfReady = function () {	

		this.handle = document.getElementById(this.uuid);
		if (this.handle) {
            
            if(typeof _this.handle.playerloadCallback == 'function')
			   _this.handle.playerloadCallback();

		    var endTime = new Date().getTime();
		  //  console.log(endTime - _startTime);
		  //  this.sendBegainInfo(endTime - _startTime);
		  //  var self = this;
		  //  _showdataid = setInterval(function(){self.sendRecordInfo()},1000);
		}
		else {alert("can't find swf");}
	}	
    
     //������ɷ�������
    this.sendBegainInfo = function(loadtime){

        var objroortBegainInfo = {};
	    	objroortBegainInfo.App = conf.lssApp;                             //app
			objroortBegainInfo.Stream = conf.lssStream;                       //stream
			objroortBegainInfo.PlayDomainName = conf.hlsDomain;      	      //���ŵ�����
			objroortBegainInfo.MPSId = conf.appId;               	 		  //mpsʵ��id
			objroortBegainInfo.PlayerId = conf.mpsId;            	 		  //������id
			objroortBegainInfo.PlayerLoadTime = loadtime;      	 			  //����������ʱ��
			objroortBegainInfo.Website = window.location.href;             	  //���ŵ�ҳ������
			//objroortBegainInfo.PlayStatus = 'success';          	 		  //�����Ƿ�ɹ���������������������� ����ɹ���ֻ������ʧ��
			objroortBegainInfo.ProtocolType = 'hls';       				      //rtmp or hls
			objroortBegainInfo.FlashPlayerVersion = this.getClientVersion();  //flash �汾��
			objroortBegainInfo.BrowserType = this.getBrowserInfo();           //���������
			objroortBegainInfo.ADUin = conf.uin;                   			  //�µ����˺ŵ�id
			objroortBegainInfo.SrcIp = '';                                    //�û�id
			objroortBegainInfo.Cur_Time = '';                                 //ʱ���

			$.ajax({
                type: "POST",
                crossDomain: true,
                contentType:"application/json",
                url: "http://pushmq.aodianyun.com/v1/collect/Mps_BegainInfo",
                data: JSON.stringify(objroortBegainInfo),
                dataType: "json",
                complete: function (resp) {
                     if (resp.status == 201) {}
                        //console.log(resp.status);
                     else 
                        console.log(resp.status);
                },
                success:function(data){
	            }
            });
    }

    //��ȡ�������Ϣ
    this.getBrowserInfo = function(){

      	 var item, token, ua, _i, _len;
            ua = navigator.userAgent;
		    token = ["Opera", "Chrome", "Safari", "IE 6", "IE 7", "IE 8", "IE 9", "IE 10", "IE 11", "Firefox"];
		    for (_i = 0, _len = token.length; _i < _len; _i++) {
		      item = token[_i];
		      if (ua.indexOf(item) > -1) {
		        return item.replace(" ", "");
		      }
		    }
		 return "Other";
    }

	this.initArgc = function (adveDeAddr,adveWidth,adveHeight,logoAddr,logoPosition,adveReAddr,watermark,
      							watermarkPosition,watermark2,watermarkPosition2,buffertitle,backgroundimage,supernatantword,displayfrequen,scrollposition) {	

		if (this.handle) {
			this.handle.initArgc(adveDeAddr,adveWidth,adveHeight,logoAddr,logoPosition,adveReAddr,watermark,
      							watermarkPosition,watermark2,watermarkPosition2,buffertitle,backgroundimage,supernatantword,displayfrequen,scrollposition);
		}

	}	
    
    this.initConnect = function(hlsUrl,controlbardisplay,openaddress){

    	if (this.handle) {
			this.handle.initConnect(hlsUrl,controlbardisplay,openaddress);
		}
    }

    /*��һ�λ���ʱ��*/
    this.getbeforetime=function(){
        if (this.handle) {
	        return this.handle.getbeforetime();
	    }
	}
    
    /*���ٴ���*/
    this.getfullcount=function(){
        if (this.handle) {
	        return this.handle.getfullcount();
	    }
	}

	/*�ܵȴ�ʱ��*/
    this.totalwaittime=function(){
        if (this.handle) {
	        return this.handle.totalwaittime();
	    }
	}
    
    //�㲥��ȡʵʱ��ǰʱ��
    this.currenttime=function(){
    	if (this.handle) {
            return this.handle.currenttime();}
    }

    /*��Ƶ������ʱ��*/
    this.getaudioBufferLength=function(){

        if (this.handle) {
	        return this.handle.getaudioBufferLength();
	    }
	}

	/*��Ƶ������ʱ��*/
    this.getvideoBufferLength=function(){
    	
        if (this.handle) {
	        return this.handle.getvideoBufferLength();
	    }
	}

    //flash�汾��
    this.getClientVersion=function(){
        if (this.handle) {
	        return this.handle.getClientVersion();
	    }
	}

	//��ȡ״̬
	this.getPlayReady = function(callback){
		if(typeof callback != 'undefined'){callback();}
		return _playReady;
	}
	// ����
	this.startPlay = function(callback){
		if (this.handle) {
			if(typeof callback != 'undefined'){callback();}
		    this.handle.startPlay("");}
		    return "hlsPlayStream";
		}
	
	// ��ͣ����
	this.pausePlay = function (callback) {
		if (this.handle) {
			if(typeof callback != 'undefined'){callback();}
			this.handle.pause();}
			return "hlsNetStream.pause";
	}
		//�ָ�����
	this.resumePlay = function (callback) {
		if (this.handle) {
			if(typeof callback != 'undefined'){callback();}
			this.handle.resume();}
			return "hlsNetStream.resume";
	}
	// ֹͣ����
	this.stopPlay = function (callback) {
		if (this.handle) {
			if(typeof callback != 'undefined'){callback();}
		    this.handle.onstop();}
            return "hlsCloseStream";
	}

    //�㲥����ĳ��ʱ�俪ʼ����
	this.setcurrentTime=function(curren,bool){
        if (this.handle) {
	        this.handle.setcurrentTime(curren,bool);}
	}

	//��̬�л�Դ
	this.changePlayer=function(_url){
        if (this.handle) {
	        this.handle.changePlayer(_url);}
	}
	// ����������initConnect()֮�������Ч
	this.setVolume = function (volume) {
		if (this.handle) {
			if (typeof volume == "number" || typeof volume == "string") {
				volume = parseInt(volume);
			}else{return;}

		this.handle.setvolume(volume);
		}
	}
	// �����Ƿ�����initConnect()֮�������Ч
	this.setMute = function (isMute) {
		if (this.handle) {
			if (typeof isMute != "boolean"){return;}
			if(isMute)
        {
           this.handle.setvolume(0);
        }
        else
        {
           this.handle.setvolume(80);
        }
		}

	}		
	//����ȫ��ģʽ,initConnect()֮�������Ч
	this.setFullScreenMode = function (fullScreenMode) {
		if (this.handle) 
			if (typeof fullScreenMode == "number" || typeof fullScreenMode == "string") {
				fullScreenMode = parseInt(fullScreenMode);
			}else{return;}
		
	 	if(fullScreenMode == 1)
	      {
	        this.handle.keepratio();   
	      }
      	else if(fullScreenMode == 2)
	      { 
	        this.handle.fillscreen();
	      }
      	else if(fullScreenMode == 3)
	      {
	        this.handle.fullscreen();
	      }
	}
	
	// ��ӻص�
	this.addEventListener = function (callbackFunc) {
		if (typeof callbackFunc == "function") {
			globalUUID_CallbackFuncMap[this.uuid] = callbackFunc;
		}
	}

	this.addPlayerCallback = function(events, callback){
		if(events == 'ready'){
            this.handle.playerloadCallback = callback; 
		}else if(events == 'start'){
			this.handle.startPlayCallback = callback;
		}else if(events == 'pause'){
			this.handle.pausePlayCallback = callback;
		}else if(events == 'resume'){
			this.handle.resumePlayCallback = callback;
		}else if(events == 'stop'){
			this.handle.stopPlayCallback = callback;
		}else if(events == 'empty'){
			this.handle.emptyPlayCallback = callback;
		}else if(events == 'full'){
			this.handle.fullPlayCallback = callback;
		}else if(events == 'slider.start'){
			this.handle.SliderstartCallback = callback;
		}else if(events == 'slider.end'){
			this.handle.SliderendPlayCallback = callback;
		}else if (events == 'play.stop') {
			this.handle.playStopCallback = callback;
		}
	}
}
// �ص���Ϣ
function lssCallBack(flashid,info) {
	
	if (globalUUID_CallbackFuncMap[flashid]){
		globalUUID_CallbackFuncMap[flashid](info);
	}
}
// ���з��͸�flash���ַ��������뾭���˷�������
function lssEncodeFlashDatas(str) {
  str = str.toString().replace(/\\/g, '\\\\');
  str = str.replace(/&/g, '__FLASH__AMPERSAND');
  return str;

}
// ����SWF����
function hlsCreateSWFVideo(id, uuid, width, height, param,controlbardisplay,openaddress){
	param = param || {};
	var displayid = id.toString();
	var swfVersionStr = "10.2.0";
	var flashvars = {};	
	flashvars.align="middle";
	flashvars.flashId=uuid;
	//flashvars.url=url;
	flashvars.width=width;
	flashvars.height=height;
	/*flashvars.controlbardisplay=controlbardisplay;
	flashvars.openaddress=openaddress;
	flashvars.password=password;
	flashvars.adveDeAddr=adveDeAddr;
	flashvars.adveWidth=adveWidth;
	flashvars.adveHeight=adveHeight;
	flashvars.logoAddr=logoAddr;
	flashvars.logoPosition=logoPosition;
	flashvars.adveReAddr=adveReAddr;
	flashvars.watermark=watermark;
	flashvars.watermarkPosition=watermarkPosition;
	flashvars.watermark2=watermark2;
	flashvars.watermarkPosition2=watermarkPosition2;
	flashvars.buffertitle=buffertitle;
	flashvars.backgroundimage=backgroundimage;
	flashvars.CallBacklss=function(flashid,info){lssCallBack(flashid,info);};*/ 
	
	var params = {};		
	params.quality = param["quality"] || "high";
	params.bgcolor = param["bgcolor"] || "#000000";
	params.allowfullscreen ="true";
	params.allowScriptaccess = "always";
	params.wmode = param["wmode"] || "Transparent";
	var attributes = {};
	attributes.id = uuid;
	attributes.name = uuid;
	attributes.align = param["align"] || "middle";

	swfobject.embedSWF(
		THISHLS_SWF_NAME, displayid,
		width, height,
		swfVersionStr, xiSwfUrlStr,
		flashvars, params, attributes);
	swfobject.createCSS("#flashContent", "display:block;text-align:left;");
}
