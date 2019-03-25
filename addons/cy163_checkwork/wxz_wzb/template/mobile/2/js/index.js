var vstatus = 0;
 //视频高度确定
function getVideoHeight(hkey) {
    var viewboxH = $('body').width()*0.56;
    

    if (hkey == 0) {
		var headnameH = $(".head-name").height();
        $(".video-box").height(viewboxH);
    } else {
		$(".head-name").css('zIndex', '100');
		$(".head-name").css('display', 'block');
		var headnameH = $(".head-name").height();
        $(".video-box").height(viewboxH + headnameH);
    };
    //互动高度确定
    var bodyH = $("body").height();
    var adH = $(".swiper-container").height();
    var viewH = $(".view").height();
    var tabH = $(".tab").height();
    var importH = $(".import").height();
    var rolladH = $(".ad-word").height();
    $(".interact-in").height(bodyH - viewH - tabH - importH - rolladH + 1);
    // $(".zan-num").html($(".view").height());
    if (hkey == 0) {
        $(".introduce,.cooperation,.shop").css({minHeight: bodyH - viewH - tabH});
        $(".rank").css({minHeight: bodyH - viewH - tabH - 0.5*rolladH});
        $(".introduce,.cooperation,.shop").css({height: 'auto',overflow:null});
        $(".rank").css({height: 'auto',overflow:null});
    } else {
        $(".introduce,.cooperation,.shop").css({height: bodyH - viewH - tabH,overflow:'auto'});
        $(".rank").css({height: bodyH - viewH - tabH - 0.5*rolladH,overflow:'auto'});
    };
    // $("#msghistory").html("bodyH" + bodyH + "adH" + adH + "viewH" + viewH + "tabH" + tabH + "importH" + importH + "rolladH" + rolladH + "viewboxH" + viewboxH);
}
getVideoHeight(0);
if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
    iphoneVideo();
} else if (/(Android)/i.test(navigator.userAgent)) {
    androidVideo();
} else {
    pcVideo();
};
function pcVideo() {
    $(".live-full,.ad-start,.avideo").hide();
    var timera = setInterval(function(){
        ntime ++;
        console.log(stime);
        console.log(ntime);
        if (ntime > stime) {
            console.log("开始");
            clearInterval(timera);
            $(".ad-video").remove();
            $(".mask-ad").hide();
            $("#play").show();
            oPlayer=new play({
                container:'play',//播放器容器ID，必要参数
                rtmpUrl: rtmpurl,//控制台开通的APP rtmp地址，必要参数
                hlsUrl: hlsurl,//控制台开通的APP hls地址，必要参数
                /* 以下为可选参数*/
                width: '100%',//播放器宽度，可用数字、百分比等
                height: '100%',//播放器高度，可用数字、百分比等
                autostart: true,//是否自动播放，默认为false
                bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
                maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
                stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
                controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
                //adveDeAddr: '',//封面图片链接
                //adveWidth: 320,//封面图宽度
                //adveHeight: 240,//封面图高度
                //adveReAddr: '',//封面图点击链接
                //isclickplay: false,//是否单击播放，默认为false
                isfullscreen: true//是否双击全屏，默认为true
            });
        } else {
            console.log("未开始");
            if (ready != '') {
                $(".mask-ad").hide();
                $(".ad-video").show();
                $("#play").hide();
            };
        }
    }, 1000)
}
function iphoneVideo() {
    $(".live-full,.ad-start,.avideo").hide();
    $("#play").hide();
    var timera = setInterval(function(){
        ntime ++;
        if (ntime > stime) {
            console.log("开始");
            clearInterval(timera);
            $(".ad-video").remove();
            $(".mask-ad").hide();
            $(".ivideo").show();
            $("#livideos").attr("src",iphoneVideourl);
            $("#livideos").attr("type","application/x-mpegURL");
            // $(".ad-start").show();
        } else {
            console.log("未开始");
            if (ready != '') {
                $(".mask-ad").hide();
                $(".ad-video").show();
                $(".ivideo").hide();
            };
        }
    }, 1000)
    if (ready != '') {
        document.addEventListener('DOMContentLoaded', function () {
            function audioAutoPlay() {
                play_video();//调用播放函数
                document.addEventListener("WeixinJSBridgeReady", function () {
                    play_video();//调用播放函数
                }, false);
            }
            audioAutoPlay();
        });
        function play_video() {
            $('.ad-video')[0].play();
        }
    }
    $(document).on('click', '.ad-start', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(".mask-ad,.ad-start").hide();
        $("#livideos")[0].play();
    });
}
function androidVideo() {
    if (vstatus == 1) {
        var timera = setInterval(function(){
            ntime ++;
            console.log(stime);
            console.log(ntime);
            if (ntime > stime) {
                clearInterval(timera);
                console.log("开始");
                $(".ad-video,.ad-start").remove();
                $(".mask-ad").hide();
                $(".avideo").show();
                $(".schedulev").hide();
                controlVideo();
            } else {
                if (ready != '') {
                    // $(".mask-ad").hide();
                    $(".ad-video").show();
                    $(".avideo").hide();
                    controlAdvideo();
                    console.log(ready + '我的ready');
                } else {
                    $(".ad-video,.ad-start").remove();
                    console.log(ready + '我的ready');
                }
            }
        }, 1000)
        setTimeout(function() {
            $(".schedulev").hide();
            $(".live-full").hide();
        }, 200)
    } else {
        $(".ad-video,.ad-start").remove();
        $(".live-full").hide();
        $(".mask-ad").remove();
        $(".avideo").show();
        $(".schedulev").hide();
        controlVideo()
    };
    $("#play").hide();
}
function controlAdvideo() {
    var inkey = 0;
    window.onresize = function() {
        infinite();
		console.log(inkey);
        if (inkey == 0) {
            $(".ad-start").show();
            $('#ad-video')[0].style.width = window.innerWidth + "px";
            $('#ad-video')[0].style.height = window.innerHeight + "px";
            $('#ad-video')[0].style["object-position"] = "0 0";
            $(".head-name").css('zIndex', '-100');
			console.log(111);
			$(".head-name").css('display', 'none');
            $(".page-view,.logo-word,.logo-img,.fff").css('top', '0.4rem');
            getVideoHeight(0);
        } else {
            $(".ad-start").hide();
            $('#ad-video')[0].style.width = window.innerWidth + "px";
            $('#ad-video')[0].style.height = window.innerHeight + "px";
            $('#ad-video')[0].style["object-position"] = "0px 3rem";
            $(".head-name").css('zIndex', '100');
			$(".head-name").css('display', 'block');
            $(".page-view,.logo-word,.logo-img,.fff").css('top', '4.4rem');
            getVideoHeight(1);
        }
    }
    $('#ad-video')[0].addEventListener("x5videoenterfullscreen", function() {
        inkey = 1;
    })
    $('#ad-video')[0].addEventListener("x5videoexitfullscreen", function() {
        inkey = 0;
    })
    $(document).on('click', '.ad-start', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(".mask-ad").hide();
        $(".ad-video")[0].play();
    });
    $(document).one('click', '.ad-start', function(event) {
        $(".ad-start").hide();
    });
}
function controlVideo() {
    var fkey = 0;  //判断退出进入全屏
    var vkey = 0;  //判断全屏或者退出
    var hkey = 0;  //判断进入全屏退出全屏和进入同层退出同层
    //直播判断
    var flivekey = 0;   //进入全屏
    var livekey = 0; //进入同层
    window.onresize = function() {
        infinite();
        my_video_a.style.width = window.innerWidth + "px";
        my_video_a.style.height = window.innerHeight + "px";
        if (hkey == 0) {
            $('#my_video_a')[0].style["object-position"] = "0 0";
            $(".head-name").css('zIndex', '-100');
			$(".head-name").css('display', 'none');
			console.log(333);
            $(".page-view,.logo-word,.logo-img,.fff").css('top', '0.4rem');
        } else {
            $('#my_video_a')[0].style["object-position"] = "0px 3rem";
            $(".head-name").css('zIndex', '100');
			$(".head-name").css('display', 'block');
            var vh = $(".video-box").height();
            var hh = $(".head-name").height();
			console.log(444);
            $(".page-view,.logo-word,.logo-img,.fff").css('top', '4.4rem');
        };
        getVideoHeight(hkey);
        carePrW();
    }
    my_video_a.addEventListener("x5videoenterfullscreen", function() {
        $(".swiper1").hide();
        $(".v-start").hide();
        if (vstatus == 1) {
            $(".live-full").show(); 
        } else {
            $(".live-full").hide(); 
        }
        fkey = 1;
        hkey = 1;
        livekey = 1;
    })
    my_video_a.addEventListener("x5videoexitfullscreen", function() {
        $(".swiper-container").show();
        $(".import").show();
        $(".v-start").show();
        $(".live-full").hide();
        my_video_a.setAttribute("x5-video-orientation", "portrait");
        $("#my_video_a").css('zIndex', '0');
        $(".sche-full").html('&#xe637;');
		$(".footer").css('display', 'block');
        $(".sche-startv").html('&#xe674;');
        $(".sche-startv").css('lineHeight', '2rem');
        fkey = 0;
        hkey = 0;
        livekey =0;
    })
    //播放
    $(document).on('click', '.v-start',function(event) {
        var height1 = $(window).height();//窗口可视高度1019
        var videoH2 = $('.all-vide').height();
        var conheight = height1-videoH2 +80;
        $('.newscroll').css("height",conheight);
        console.log(999,conheight)
		console.log(11);
		$(".swiper-container").hide();
        event.preventDefault();
        event.stopPropagation();
        my_video_a.play();
    });
    $(document).one('click', '.v-start',function(event) {
		$(".swiper-container").hide();
        $(".v-start").hide();
        if (vstatus == 1) {
            $(".schedulev").hide();
        } else {
            $(".schedulev").show();
        };
        $(".sche-startv").html('&#xe6d2;');
        $(".sche-startv").css('lineHeight', '2.2rem');
        setTimeout(function() {
            getVideoHeight(1);
            $('#my_video_a')[0].style["object-position"] = "0px 3rem";
        }, 500)
        carePrW();
        //控制视频窗口按钮显示隐藏
        var schtimer = null;
        var showkey = 0;
        $(document).on('click', '.view', function(event) {
            if (showkey == 0) {
                $(".view-btn,.schedulev").hide();
                showkey = 1;
                clearTimeout(schtimer);
            } else {
                $(".view-btn").fadeIn(500);
                if (vstatus == 1) {
                    $(".schedulev").hide();
                } else {
                    $(".schedulev").fadeIn(500);
                };
                showkey = 0;
                clearTimeout(schtimer);
                schtimer = setTimeout(function() {
                    $(".schedulev").hide();
                    showkey = 1;
                }, 15000);
            };
        }).on('click', '.schedulev', function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
        schtimer = setTimeout(function() {
            $(".schedulev").hide();
            showkey = 1;
        }, 15000);
        $(".schedulev").on('touchstart', function(event) {
            clearTimeout(schtimer);
        });
        $(".schedulev").on('touchend', function(event) {
             schtimer = setTimeout(function() {
                $(".schedulev").hide();
                showkey = 1;
            }, 15000);
        });
    });
    //开始暂停
    $(document).on('click', '.sche-startv',function(event) {
        event.preventDefault();
        event.stopPropagation();
        if (my_video_a.paused) {
            my_video_a.play();
            $(".sche-startv").html('&#xe6d2;');
            $(".sche-startv").css('lineHeight', '2.2rem');
        } else {
            my_video_a.pause();
            $(".sche-startv").html('&#xe674;');
            $(".sche-startv").css('lineHeight', '2rem');
        }
    });

    // 全屏与退出
    $(document).on('click', '.sche-full',function(event) {

        event.preventDefault();
        event.stopPropagation();
        carePrW();
        if (fkey == 0) {
            return false;
        } else {
            if (vkey == 0) {
                landscape();
                hkey = 0;
            } else {
                portrait();
                hkey = 1;
            };
        };
    });
    $(document).on('click', '.live-full',function(event) {
        event.preventDefault();
        event.stopPropagation();
        if (livekey == 0) {
            return false;
        } else {
            if (flivekey == 0) {
                landscape();
                flivekey = 1;
                hkey = 0;
            } else {
                portrait();
                flivekey = 0;
                hkey = 1;
            };
        };
    });
    function portrait(){
        vkey = 0;
		$(".footer").css('display', 'block');
        $(".import").show();
        $("#my_video_a").css('zIndex', '0');
        my_video_a.setAttribute("x5-video-orientation", "portrait");
        $(".sche-full").html('&#xe637;');
    }
    function landscape(){
        vkey = 1;

        $(".import").hide();
        $("#my_video_a").css('position', 'relative');
        $("#my_video_a").css('zIndex', '1');
		$(".footer").css('display', 'none');
        my_video_a.setAttribute("x5-video-orientation", "landscape");
        $(".sche-full").html('&#xe6ac;');
    }
    // 进度条宽度确认
    carePrW();
    function carePrW() {
        var oW = $(".processv").width();
        var bW = $(".pr-bar").width();
        var iW = oW - bW;
        $(".pr-in").css({"width":iW,"padding-right": bW/2});
        $(".pr-block").css({"width": bW/2});
    }
    // 移动
    voicest(".processv");
    function voicest(o) {
        var box = $(o).children('.pr-in');
        var bg = box.children('.pr-bg');
        var bgcolor = bg.children('.pr-bgcolor');
        var btn = box.children('.pr-bar');
        // var text = $(o).children('.text');
        var btnW = box.children('.pr-bar').width();
        var bgW = box.children('.pr-bg').width();
        var key = 0;
        var sp = null;
        var ep = null;
        var op = null;
        var m = null;
        var cp = btn.offset().left - btnW/2;
        //接数据
        var valltime = null;
        var vnowtime = null;
        var vpersent = null;
        btn.on('touchstart', function(event) {
            my_video_a.pause();
            $(".sche-startv").html('&#xe674;');
            $(".sche-startv").css('lineHeight', '2rem');
            btnW = box.children('.pr-bar').width();
            bgW = box.children('.pr-bg').width();
            event.preventDefault();
            event.stopPropagation();
            sp = event.originalEvent.targetTouches[0].pageX;
            op = btn.position().left;
            key = 1;
        });
        box.on('touchstart',function(event) {
            my_video_a.pause();
            $(".sche-startv").html('&#xe674;');
            $(".sche-startv").css('lineHeight', '2rem');
            btnW = box.children('.pr-bar').width();
            bgW = box.children('.pr-bg').width();
            event.preventDefault();
            event.stopPropagation();
            sp = event.originalEvent.targetTouches[0].pageX;
            m = sp - cp - btnW;
            btn.css("left", m);
            bgcolor.width(m);
            // text.html(parseInt(m/(bgW/100)));
            op = btn.position().left;
            key = 1;
        });
        box.on('touchend',function(event) {
            if (key ==1) {
                my_video_a.play();
                $(".sche-startv").html('&#xe6d2;');
                $(".sche-startv").css('lineHeight', '2.2rem');
                my_video_a.currentTime = valltime*vpersent;
            };
            key = 0;
        });
        box.on('touchmove', function(event) {
            event.preventDefault();
            event.stopPropagation();
            if (key == 1) {
                ep = event.originalEvent.targetTouches[0].pageX;
                m = ep - sp + op;
                // $(".sche-nowtimev").html(ep);
                if (m < 0) {
                    m = 0;
                };
                if (m > bgW) {
                    m = bgW;
                };
                btn.css("left", m);
                bgcolor.width(m);
                vpersent = m/bgW;
            };
        });
        my_video_a.addEventListener("timeupdate",function(){
            btnW = box.children('.pr-bar').width();
            bgW = box.children('.pr-bg').width();
            vnowtime = my_video_a.currentTime;
            valltime = my_video_a.duration;
            var ww = vnowtime/valltime;
            var www = parseInt(bgW*ww);
            btn.css("left", www);
            bgcolor.width(www);
            getshowtime(vnowtime,valltime);
            // $(".sche-nowtimev").html(vnowtime);
            // $(".sche-alltimev").html(valltime);
        });
        // 监控PC进度条
        function getshowtime(atime,ctime) {
			
            ch=ctime/3600>=10?Math.floor(ctime/3600):'0'+Math.floor(ctime/3600);
            cm=ctime%3600/60>=10?Math.floor(ctime%3600/60):'0'+Math.floor(ctime%3600/60);
            cs=ctime%3600%60>=10?Math.floor(ctime%3600%60):'0'+Math.floor(ctime%3600%60);
            ah=atime/3600>=10?Math.floor(atime/3600):'0'+Math.floor(atime/3600);
            am=atime%3600/60>=10?Math.floor(atime%3600/60):'0'+Math.floor(atime%3600/60);
            as=atime%3600%60>=10?Math.floor(atime%3600%60):'0'+Math.floor(atime%3600%60);
			
            if (ch == '0NaN' || ch == 'Infinity') {
                //$(".sche-alltimev").html('00:00:00');
				$(".sche-nowtimev").html(ah+':'+am+':'+as);
            } else {
                $(".sche-alltimev").html(ch+':'+cm+':'+cs);
            }
            if (ah == '0NaN' || ah == 'Infinity') {
                $(".sche-nowtimev").html('00:00:00');
            } else {
                $(".sche-nowtimev").html(ah+':'+am+':'+as);
            }
        }
    }
}
//安卓video播放与高度判定 end
//提示
function tips(msg,timer){
    document.getElementById('tips').style.display='block';
    document.getElementById('tips').innerText = msg;
    setTimeout(function () {
        document.getElementById('tips').style.display='none';
    },timer)
}

//按钮显示隐藏
$(document).on('click', '.video-box', function(event) {
    event.preventDefault();
    if($(".view-btn").is(":hidden")){
        $(".view-btn").show();
    }else{
        $(".view-btn").hide();
    }
});
