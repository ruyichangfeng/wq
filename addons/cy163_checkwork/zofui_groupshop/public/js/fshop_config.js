require.config({
	urlArgs: "v=" +  (new Date()).getTime(), //getHours 
    baseUrl: '/addons/zofui_groupshop/public/js/',
    paths: {
		'zepto' : '//g.alicdn.com/sj/lib/zepto/zepto.min',
		'weixinJs':  '/addons/zofui_groupshop/public/js/lib/weixinJs',
		'common':  '/addons/zofui_groupshop/public/js/lib/common',
		'lazyLoad':  '/addons/zofui_groupshop/public/js/lib/jquery.lazyload',		
		'familyshop':  '/addons/zofui_groupshop/public/js/app/familyshop',
		'good':  '/addons/zofui_groupshop/public/js/app/good',
		'sm' : '//g.alicdn.com/msui/sm/0.6.2/js/sm.min',
		'smex' : '//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min'		
		
    },
	shim:{
        'sm':{
            deps:['zepto']
        },	
        'smex':{
            deps:['zepto']
        }
		
	}
});
