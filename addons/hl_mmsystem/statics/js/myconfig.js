var version = +new Date();
var myconfig = {
    path: '../addons/feng_commmunity/static/js/',
    alias: {
        'jquery': 'lib/jquery.min',
        'clockpicker': 'lib/clockpicker',
        'jquery.metisMenu': 'lib/metisMenu/jquery.metisMenu',
        'jquery.slimscroll': 'lib/slimscroll/jquery.slimscroll.min',
        'layer': 'lib/layer/layer.min',
        'hplus': 'lib/hplus',
        'contabs':'lib/contabs',
        'bootstrap-datepicker': 'lib/datapicker/bootstrap-datepicker',
        'switchery': 'lib/switchery/switchery',
        'cropper': 'lib/cropper/cropper',
        'form-advanced-demo': 'lib/form-advanced-demo',
        'pace': 'lib/pace/pace.min',
    },
    map: {
        'js': '.js?v=' + version,
        'css': '.css?v=' + version
    },
    css: {
        'switchery': 'lib/switchery/switchery'
    }
    , preload: ['jquery']

};

var myrequire = function (arr, callback) {
    var newarr = [];
    $.each(arr, function () {
        var js = this;

        if (myconfig.css[js]) {
            var css = myconfig.css[js].split(',');
            $.each(css, function () {
                if(typeof myrequire.systemVersion !== 'undefined'){
                    if (myrequire.systemVersion === '1.0.0' || myrequire.systemVersion <= '0.8')
                    {
                        newarr.push("css!" + myconfig.path + this + myconfig.map['css']);
                    }
                    else
                    {
                        newarr.push("loadcss!" + myconfig.path + this + myconfig.map['css']);
                    }
                }else{
                    newarr.push("css!" + myconfig.path + this + myconfig.map['css']);
                }
            });


        }

        var jsitem = this;
        if (myconfig.alias[js]) {
            jsitem = myconfig.alias[js];

        }
        newarr.push(myconfig.path + jsitem + myconfig.map['js']);
    });
    require(newarr, callback);
}
