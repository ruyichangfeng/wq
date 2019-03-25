<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
</head>
<body>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>

<script>
    wx.ready(function(){

        wx.getLocation({

            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                window.location.href = '<?php  echo $url;?>'+'&log='+longitude+'&lat='+latitude+'&op=main';
            },
            fail:function () {

                window.location.href = '<?php  echo $url;?>'+'&op=main';
            },
            cancel:function () {

                window.location.href = '<?php  echo $url;?>'+'&op=main';
            }
        });
    })

</script>
</html>