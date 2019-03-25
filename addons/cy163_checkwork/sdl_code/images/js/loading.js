/**
 * Created by win7 on 2016/6/27.
 */
//加载动画
$(function(){
    $(".box1").height($(document).height());
    $(".box1").hide();
    var sdl_boot = function() {
        var time = window.setTimeout(function(){
            $('.load').hide();
            $(".box1").show();
            $("body").css("height","auto");
            var h=$(".M2center ul").height()+10;
            $(".M2foot").height(h);

            // $("body").css("background","transparent");
        },500);
        var time = window.setTimeout(function(){
            $('.p1_4').css("-webkit-animation","largen2 2s 0s infinite linear both");
        },4000);
    };
    function now () {
        return Date.now ? Date.now() : +new Date();
    }
    var sdl = function(imgs) {
        if (imgs.length === 0) return sdl_boot();
        var requestAnimationFrame =
            window.requestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.msRequestAnimationFrame ||
            function (callback) { window.setTimeout(callback, 1000 / 60); };
        var logo = document.getElementById('logo');
        var loading_figure = document.getElementById('loading_figure');
        var startTime = now();
        var minTime = 1000; //loading出现的最小时间。
        var count = 0;
        var total = imgs.length;
        var starting = false;
        for (var i = 0, len = imgs.length; i < len; i++) {
            var dom = sdl.cache[imgs[i]] = new Image();
            dom.onload = (function(dom, src) {
                return function() {
                    count += 1;
                    dom.onload = null;
                    delete sdl.cache[src]
                }
            }(dom, imgs[i]));
            dom.src = imgs[i];
        }
        function loopCheck () {
            if (starting) return;
            var fakePst = Math.min((now() - startTime) / minTime, 1);
            var pst = (fakePst + count / total) / 2;
            loading_figure.innerHTML = Math.round(pst * 100) + '%';
            if (pst >= 1) {
                sdl_boot();
                starting = true;
            } else {
                requestAnimationFrame(loopCheck);
            }
        }
        loopCheck();
    }
    sdl.cache = {};


    var page_info = {
        image_list: [
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/bj1.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/fx.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/sing.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/sing2.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/arrow.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/bj2.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/bj3.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/bj4.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/bj5.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/bj6.jpg',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/1-1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/1-2.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/1-3.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/1-4.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/2-1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/3-1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/4-1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/5-1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/6-1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/6-2.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/6-3.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/6-4.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/6-5.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/6-6.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/text1.png',
            'http://wx.3po.com.cn/wzlthink/app/djgchy5/imgs/text2.png',

        ]
    }
    sdl(page_info['image_list']);
})
