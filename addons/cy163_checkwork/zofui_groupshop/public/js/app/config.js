/**
 * 存放对 msui 的 config，需在 zepto 之后 msui 之前加载
 *
 * Created by bd on 15/12/21.
 */
$.config = {
    router : false,
    // 路由功能开关过滤器，返回 false 表示当前点击链接不使用路由
    routerFilter: function($link) {
    	var u = navigator.userAgent;
    	var ios = u.indexOf('iPhone') > -1 || u.indexOf('iPad') > -1; 

        // 某个区域的 使用路由功能
        if ( ios && $link.is('.router a') ) {
            return true;
        }

        return false;
    },
};
