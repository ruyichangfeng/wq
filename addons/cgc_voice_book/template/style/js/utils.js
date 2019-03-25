var UTIL = {
    PAGE_TITLE: "天天有空",

    setTitle: function () {
        $('head').prepend('<title>' + UTIL.PAGE_TITLE + '</title>');
    },

    layerAlert: function (content) {
        layer.msg(content);
    },

    orientationChange: function (callback1, callback2) {
        // alert('111')
        window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", function () {
            if (window.orientation === 180 || window.orientation === 0) {
                // alert('222')
                callback1();
            }
            if (window.orientation === 90 || window.orientation === -90) {
                // alert('333')                
                callback2();
            }
        }, false);
    },

    /**
     *  改变微信顶部title
     */
    changeTitle :function (title) {
        document.title = title;
        // hack在微信等webview中无法修改document.title的情况
        var $iframe = $('<iframe class="none" src="/favicon.ico"></iframe>');
        $iframe.on('load', function () {
            setTimeout(function () {
                $iframe.off('load').remove();
            }, 0);
        }).appendTo($('body'));
    },

    /**
     * 判断是否为iphone
     */
    isIOS: function() {
      return /ip(hone|od)|ipad/i.test(navigator.userAgent);
    }
}