(function($) {
    /**
     * [baiduPosition 百度定位功能插件]
     * 调用示例
     * $.baiduPosition({listDom:".store-list li",listDomDistance:".distance",callback:function(e){alert(e);}});
     * 注意:
     * 必须提前引入百度接口的js 例如: https://api.map.baidu.com/api?v=2.0&ak=5PESLgvMcSbSUbPjmDKgvGZ3
     * 变换距离值的dom 必须绑定自定义属性(来自后台) data-lng="{item['lng']}" 经度  data-lat="{item['lat']}" 纬度
     */
    $.fn.extend({
        baiduPosition: function(options) {
            //初始化
            var defaults = {
                lng:"",//默认经度
                lat:"",//默认纬度
                listDom: ".store-list li", //渲染的循环列表的dom的类名或id
                listDomDistance: ".distance", //渲染列表中的距离的类名或id(包含)
                type:1,//1表示用js渲染dom 2表示用php渲染dom
                callback: null //回调函数 返回百度接口数据
            }
            var options = $.extend(defaults, options);
            
            if(options.lat && options.lng){
                //已知经度和纬度渲染dom
                if(options.type == 1){
                    //渲染列表
                    $(options.listDom).each(function() {
                        var itemLng = $(options.listDom + ' ' + options.listDomDistance).attr('data-lng'); //绑定 lng经度
                        var itemLat = $(options.listDom + ' ' + options.listDomDistance).attr('data-lat'); //绑定 lat纬度
                        var distance = distanceByLnglat(options.lng, options.lat,itemLng, itemLat); //距离
                        $(this).find(options.listDomDistance).html(distance + "km");
                    });
                    options.callback && options.callback(data); //执行回调函数
                }
            }else{
                //百度地图实例化
                var geolocation = new BMap.Geolocation();

                var locLng, locLat, locCity, locProvince;        
                geolocation.getCurrentPosition(function(r) {
                    var _this = this;
                    //关于状态码
                    //BMAP_STATUS_SUCCESS   检索成功。对应数值“0”。
                    //BMAP_STATUS_CITY_LIST 城市列表。对应数值“1”。
                    //BMAP_STATUS_UNKNOWN_LOCATION  位置结果未知。对应数值“2”。
                    //BMAP_STATUS_UNKNOWN_ROUTE 导航结果未知。对应数值“3”。
                    //BMAP_STATUS_INVALID_KEY   非法密钥。对应数值“4”。
                    //BMAP_STATUS_INVALID_REQUEST   非法请求。对应数值“5”。
                    //BMAP_STATUS_PERMISSION_DENIED 没有权限。对应数值“6”。(自 1.1 新增)
                    //BMAP_STATUS_SERVICE_UNAVAILABLE   服务不可用。对应数值“7”。(自 1.1 新增)
                    //BMAP_STATUS_TIMEOUT   超时。对应数值“8”。(自 1.1 新增)  
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        //返回成功
                        var mk = new BMap.Marker(r.point);

                        locLng = r.point.lng; //经度
                        locLat = r.point.lat; //纬度
                        locCity = r.address.city; //定位城市
                        locProvince = r.address.province.replace('市',''); //定位省
                        if(options.type == 1){
                            //渲染列表
                            $(options.listDom).each(function() {
                                var itemLng = $(options.listDom + ' ' + options.listDomDistance).attr('data-lng'); //绑定 lng经度
                                var itemLat = $(options.listDom + ' ' + options.listDomDistance).attr('data-lat'); //绑定 lat纬度
                                var distance = distanceByLnglat(locLng, locLat, itemLng, itemLat); //距离
                                $(this).find(options.listDomDistance).html(distance + "km");
                            });
                        }

                        var data = {lng:locLng,lat:locLat,city:locCity,province:locProvince};//百度接口数据

                        options.callback && options.callback(data); //执行回调函数
                    } else {
                        alert("无法获取距离" + _this.getStatus()); //调用接口失败返回值
                    }
                }, {
                    enableHighAccuracy: true
                });
            }

            //工具函数
            function Rad(d) {
                return d * Math.PI / 180.0
            };

            /**
             * [算出两个坐标之间的距离(前端)]
             * @param  {[type]} lng1 [第一个坐标的经度]
             * @param  {[type]} lat1 [第一个坐标的纬度]
             * @param  {[type]} lng2 [第二个坐标的经度]
             * @param  {[type]} lat2 [第二个坐标的纬度]
             * @return {[float]}      [距离]
             */
            function distanceByLnglat(lng1, lat1, lng2, lat2) {
                var radLat1 = Rad(lat1);
                var radLat2 = Rad(lat2);
                var a = radLat1 - radLat2;
                var b = Rad(lng1) - Rad(lng2);
                var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a / 2), 2) + Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(b / 2), 2)));
                s = s * 6378137.0;
                s = Math.round(s * 10000) / 10000000;
                s = s.toFixed(2);
                return s;
            }
        }
    });

})(window.jQuery);