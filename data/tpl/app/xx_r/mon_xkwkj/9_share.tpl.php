<?php defined('IN_IA') or exit('Access Denied');?><?php  echo register_jssdk(false);?>


<script type="text/javascript">
  
    <?php  if(empty($xkwkj['locationlimit'])) { ?>
          var inlimitLocation = true;
    <?php  } else { ?>
    	  var inlimitLocation = false;
    <?php  } ?>

    wx.ready(function () {
        sharedata = {
            title: "<?php  echo str_replace('#name',$userInfo['nickname'],str_replace('#price',$user['price'],$xkwkj['share_title']))?>",
            desc: "<?php  echo str_replace('#name',$userInfo['nickname'],str_replace('#price',$user['price'],$xkwkj['share_content']))?>",
            link: "<?php  echo $this->getShareUrl($xkwkj['id'], $user['id'])?>",
            imgUrl: "<?php  echo $_W['attachurl'];?><?php  echo $xkwkj['share_icon'];?>",
            success: function(){

                $.post("<?php  echo $this->createMobileUrl('UserShare',array('kid'=>$xkwkj['id']),true)?>",function(res) {

                });
            },
            cancel: function(){
                // alert("分享失败，可能是网络问题，一会儿再试试？");
            }
        };
        wx.onMenuShareAppMessage(sharedata);
        wx.onMenuShareTimeline(sharedata);

        <?php  if(!empty($xkwkj['locationlimit'])) { ?>
            getlocaltion();
         <?php  } else { ?>
            inlimitLocation = true;
          <?php  } ?>
    });

            function getlocaltion() {
                wx.getLocation({
                    type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                    success: function (res) {
                        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                        var speed = res.speed; // 速度，以米/每秒计
                        var accuracy = res.accuracy; // 位置精度
                        var location = latitude + "," + longitude;
                        //百度接口，一天可以调用100w次
                        var url = "http://api.map.baidu.com/geocoder/v2/" + "?ak=2WUgR2cnnF4WGBVpNLzvS8HS&callback=renderReverse&location=" + location + "&output=json&pois=0";

                        $.ajax({
                            type: "get",
                            async: false,
                            url: url,
                            dataType: "jsonp",
                            jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(默认为:callback)
                            jsonpCallback: "renderReverse",//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名
                            success: function (json) {

                                if (json.status == "0") {


                                    var address = json.result.addressComponent;
                                    var str = address.province + "," + address.city + "," + address.district;
                                    var limitLocations = "<?php  echo $xkwkj['locationlimit'];?>".split(",");

                                    for (var index = 0; index < limitLocations.length; index++) {
                                        if (str.indexOf(limitLocations[index]) > -1) {
                                            inlimitLocation = true;
                                            break;
                                        }
                                    }


                                    if (!inlimitLocation) {
                                      //  alert("对不起，您不在参与地区限制范围内，感谢您的参与！");
                                    }

                                } else {
                                    alert("获取定位失败");
                                }
                            },
                            error: function () {
                                alert('获取定位失败');
                            }
                        });
                    }
                });
            }
</script>
