var HTML5_ID_BASE=0;
function html5playerRun(conf){

	var mode = /^\d{0,6}(\%)?$/;
	var width = mode.test(conf.width) ? conf.width : '100%';
	var height = mode.test(conf.height) ? conf.height : '100%';
	HTML5_ID_BASE++;
	this.uuid  /*string*/ = 'html5Media' + HTML5_ID_BASE;
	this.hlsUrl=conf.hlsUrl;
	this.container=conf.mediaid;
	this.autostart=conf.autostart;
	this.volume = conf.volume ? conf.volume : 80;            //音量	
	this.adveDeAddr = conf.adveDeAddr ? conf.adveDeAddr : '';//播放前显示图片地址
	this.isdisplay = conf.controlbardisplay ? conf.controlbardisplay : 'enable';//进度条显示，取值："enable" 和 "disable"。 默认为disable
	var _this=this;

    if(this.isdisplay == 'disable'){
	  var html='<video id="'+this.uuid+'" preload="auto" width="'+width+'" height="'+height+'" poster="'+this.adveDeAddr+'" webkit-playsinline  playsinline src="'+this.hlsUrl+'" type="application/x-mpegURL"></video>';
	  if(this.autostart == true)
		 html='<video id="'+this.uuid+'" autoplay preload="auto" width="'+width+'" height="'+height+'" poster="'+this.adveDeAddr+'" webkit-playsinline playsinline type="application/x-mpegURL" src="'+this.hlsUrl+'" ></video>';
    }
    else if(this.isdisplay == 'enable'){

      var html='<video id="'+this.uuid+'" controls preload="auto" width="'+width+'" height="'+height+'" poster="'+this.adveDeAddr+'" webkit-playsinline playsinline src="'+this.hlsUrl+'" type="application/x-mpegURL"></video>';
	  if(this.autostart == true)
		{ 
		 html='<video id="'+this.uuid+'" autoplay controls preload="auto" width="'+width+'" height="'+height+'" poster="'+this.adveDeAddr+'" webkit-playsinline playsinline type="application/x-mpegURL" src="'+this.hlsUrl+'" ></video>';
         }
         var u = navigator.userAgent;

var isandroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
       if(isandroid==true)
    	{
html='<video style="object-position:0px 0px" id="html5Media2"   width="'+width+'" height="'+height+'" poster="'+this.adveDeAddr+'" type="application/x-mpegURL" src="'+this.hlsUrl+'" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>';	
    	this.uuid='html5Media2';
    	this.autostart=false;
    	$('.max-start').show();
        $('.max-start').click(function(){
         $('.max-start').hide();
        
         document.getElementById(_this.uuid).play();
         if(loginInfo.isend==1)
         {
         	$('.schedule').show();
         $('.sche-start').click(function(){
        	if(document.getElementById(_this.uuid).paused)
        	{
            $('.sche-start').html('&#xe623;');
        	document.getElementById(_this.uuid).play();	
        	}
        	else
        	{
            $('.sche-start').html('&#xe672;');
        	document.getElementById(_this.uuid).pause();	
        	}
          
        });
         
         }
           
     
       
        });
        $(".process").click(function (e) {
        var mX = e.clientX;
        var l = mX-$(".process-bar").offset().left;
            console.log(mX+"+++++"+l);
            var fullwidth = $(".process").width();
            if(l<0){
                l=0;
            }else if(l>fullwidth){
                l=fullwidth;
            }
            clearInterval(pro);
            $("#mybar").css('left',l);
            var p = Math.floor(l*100/fullwidth);
            $(".process-bar").css('width',p+'%');
            var time=document.getElementById(_this.uuid).duration;
            document.getElementById(_this.uuid).currentTime=Math.floor(l*time/fullwidth);
            // var ctime=document.getElementById(_this.uuid).currentTime;
            // var ch=ctime/3600>10?Math.floor(ctime/3600):'0'+Math.floor(ctime/3600);
            // var cm=ctime%3600/60>10?Math.floor(ctime%3600/60):'0'+Math.floor(ctime%3600/60);
            // var cs=ctime%3600%60>10?Math.floor(ctime%3600%60):'0'+Math.floor(ctime%3600%60);
            //  $('.sche-nowtime').html(ch+':'+cm+':'+cs);
            
})
$("#mybar").on('touchstart', function(event) {
        
        // return false;
        
    $(".process").on("touchend", function () {
    	document.getElementById(_this.uuid).play();
    	
    })
    });  
    	}
        if(conf.startime>conf.nowtime)
        {
             $('.v-start').hide();
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
				$('.v-start').show();
                clearInterval(stp); 
            } 
}},100);
        }
        else
        {
          $('.startbg').remove();
          $('.timeover').remove();
			$('.v-start').show();
        }
   setInterval(outline, 3000);
    }
    function outline()
    {
        if(document.getElementById(_this.uuid).readyState==2)
         {

          $.ajax({
                            type: "POST",
                            url: "./topicstatus",
                            data: {livecode:loginInfo.livecode},
                            success: function(result) {
                                if(result.status == -1) {
                                 $('#'+_this.uuid).attr('poster','');
                                } 
                            }
                        });
    
    
            }
    }
    function getProgress(){
     		//alert(111);
                
            //alert(document.getElementById(_this.uuid).duration);
            var ctime=document.getElementById(_this.uuid).currentTime;
            var time=document.getElementById(_this.uuid).duration; 

			if(time== 'Infinity' || isNaN(time)){

				var percent =1;
				var h=0;
				var m=0;
				var s=0;
			}else{

				var percent =ctime /time;
				var h=time/3600>=10?Math.floor(time/3600):'0'+Math.floor(time/3600);
				var m=time%3600/60>=10?Math.floor(time%3600/60):'0'+Math.floor(time%3600/60);
				var s=time%3600%60>=10?Math.floor(time%3600%60):'0'+Math.floor(time%3600%60);
			}
            
           
            var ch=ctime/3600>=10?Math.floor(ctime/3600):'0'+Math.floor(ctime/3600);
            var cm=ctime%3600/60>=10?Math.floor(ctime%3600/60):'0'+Math.floor(ctime%3600/60);
            var cs=ctime%3600%60>=10?Math.floor(ctime%3600%60):'0'+Math.floor(ctime%3600%60);
			
            $('.sche-alltime').html(h+':'+m+':'+s);
              $('.process-bar').width((percent * 100).toFixed(1) + "%");
              $('.sche-nowtime').html(ch+':'+cm+':'+cs);
             $('#mybar').attr('style','left:'+($('.process').width()*percent-2)+'px');
            }
	document.getElementById(conf.container).innerHTML=html;
	if(this.autostart == true){
		var playset=setInterval(function(){
			if(document.getElementById(_this.uuid)){
						clearInterval(playset);						
						document.getElementById(_this.uuid).play();
					}
		},100);
	}	
	var volumeset=setInterval(function(){
		if(document.getElementById(_this.uuid)){
					clearInterval(volumeset);
					var volume=_this.volume;
					volume=(volume/100).toFixed(1);
					volume > 1 && (volume = 1);
					volume < 0 && (volume = 0);		
					document.getElementById(_this.uuid).volume=volume;
				}
	},100);
	
	if(typeof(conf.lssCallBackFunction) == 'function'){
		conf.lssCallBackFunction();}
    
    //if(conf.onReady) conf.onReady();
//---------------------------------------------------------------------------------------    

    this.addPlayerCallback = function(events, callback){
		/*if(events == 'ready'){
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
		}else */
		if (events == 'play.stop') {
			this.playStopCallback = callback;
		}
	}

	var self = this;
	document.getElementById(this.uuid).addEventListener("ended",function(){

        if(typeof self.playStopCallback == 'function'){
		   self.playStopCallback();
		}

    }, false);

    this.changePlayer = function(url){
    	document.getElementById(this.uuid).src = url;
    }
    //开始播放
	this.startPlay = function(){
		document.getElementById(this.uuid).play();
	}

    //恢复播放
    this.resumePlay = function(){
		document.getElementById(this.uuid).play();
	}

	// 暂停播放
	this.pausePlay = function () {
		document.getElementById(this.uuid).pause();
	}
	
    //html5video获取实时时间
    this.currenttime = function(){
    	
    	return document.getElementById(this.uuid).currentTime;
    }
 
	// 设置音量
	this.setVolume = function (volume) {
		volume=(volume/100).toFixed(1);
		volume > 1 && (volume = 1);
		volume < 0 && (volume = 0);		
		document.getElementById(this.uuid).volume=volume;
		
	}
	// 设置是否静音
	this.setMute = function (isMute) {		
		if (typeof isMute != "boolean"){return;}
		document.getElementById(this.uuid).muted=isMute;
	}
	if(conf.onReady) conf.onReady();
}
