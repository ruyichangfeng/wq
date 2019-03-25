require.config({
    baseUrl: '{ZSK_STATIC}',
    paths: {
        datetimepicker: "../../components/datetimepicker/jquery.datetimepicker",
        daterangepicker: "../../components/daterangepicker/daterangepicker",
        colorpicker: '/static/dsg/js/spectrum' webuploader: "../../components/webuploader/webuploader.min",
        fileUploader: "../../components/fileuploader/fileuploader.min",
        clockpicker: "../../components/clockpicker/clockpicker.min",
        district: "../lib/district",
        moment: "../lib/moment",
        emoji: "../../components/emoji/emoji",
        fontawesome: "../../components/fontawesome/fontawesome",
        material: "../../components/material/material",
        trade: "../../components/trade/trade",
        hammer: "../lib/hammer.min",
        "bootstrap.switch": "../../components/switch/bootstrap-switch.min",
        validator: "../lib/bootstrapValidator.min",
        bootstrap: "../lib/bootstrap.min",
        "jquery.ui": "../lib/jquery-ui-1.10.3.min",
        "jquery.caret": "../lib/jquery.caret",
        "jquery.jplayer": "../../components/jplayer/jquery.jplayer.min",
        "jquery.zclip": "../../components/zclip/jquery.zclip.min",
        "jquery.wookmark": "../lib/jquery.wookmark.min",
        "jquery.qrcode": "../lib/jquery.qrcode.min",
        "jquery.jplayer": "../../components/jplayer/jquery.jplayer.min",
        underscore: "../lib/underscore-min",
        biz: "../lib/biz",
        util: '/static/js/util.min',
        ueditor: "../../components/ueditor/ueditor.all.min",
        angular: "../lib/angular.min",
        "angular.sanitize": "../lib/angular-sanitize.min",
        "angular.hotkeys": "../lib/angular.hotkeys",
        loadcss: "../lib/loadcss.min",
        css: "../lib/css.min",
        clipboard: "../lib/clipboard.min",
        "we7.check": "../lib/we7.check"
    },
    shim: {
        ueditor: {
            deps: ["./resource/components/ueditor/third-party/zeroclipboard/ZeroClipboard.min.js", "./resource/components/ueditor/ueditor.config.js"],
            exports: "UE",
            init: function (a) {
                window.ZeroClipboard = a
            }
        },
        util: {exports: "util"},
        daterangepicker: {deps: ["moment", "loadcss!../../components/daterangepicker/daterangepicker.css"]},
        datetimepicker: {deps: ["loadcss!../../components/datetimepicker/jquery.datetimepicker.css"]},
        colorpicker: {deps: ["loadcss!../../components/colorpicker/spectrum.css"]},
        map: {exports: "BMap"},
        bootstrap: {exports: "$"},
        "jquery.wookmark": {exports: "$"},
        "jquery.ui": {exports: "$"},
        "jquery.caret": {exports: "$"},
        "bootstrap.switch": {deps: ["bootstrap", "loadcss!../../components/switch/bootstrap-switch.min.css"]},
        fileUploader: {deps: ["webuploader", "jquery.jplayer", "loadcss!../../components/webuploader/webuploader.css", "loadcss!../../components/webuploader/style.css"]},
        clockpicker: {exports: "$", deps: ["loadcss!../../components/clockpicker/clockpicker.min.css"]},
        district: {exports: "$"},
        "jquery.toast": {deps: ["loadcss!../../components/toast/toastr.min.css"]},
        emoji: {deps: ["loadcss!../../components/emoji/emotions.css"]},
        fontawesome: {deps: ["loadcss!../../components/fontawesome/style.css"]},
        angular: {exports: "angular", deps: ["jquery"]},
        "angular.sanitize": {exports: "angular", deps: ["angular"]},
        "angular.hotkeys": {exports: "angular", deps: ["angular"]}
    }
}), define("jquery", [], function () {
    return jQuery
});