<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title><?php  echo $setting['school_name'];?></title>
    <link rel="stylesheet" type="text/css" href="../addons/hc_credit_shopping/style/css/error.css"/>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
</head>
<body>
<div class="noticeBox">
    <div class="box">
        <header class="bgRed"><!-- bgWhite bgOrange bgGreenLight bgRed  -->
            <h3 id="err_title"></h3>
        </header>
        <article class="content">
            <div class="pages">
                <div class="page on">
                    <section class="padding_15" style="text-align: center">
                        <p id="errmsg"></p>
                    </section>
                </div>
            </div>
        </article>
        <article class="buttons">
            <ul><!-- li的样式  noBg bold arrow  -->
                <li class="noBg" id="close"><a style="display: none;">关闭</a></li>
                <li class="bold arrow" id="next"><a style="display: none;">返回</a></li>
            </ul>
        </article>
    </div>
</div>

<?php  if($msg['type'] == '1' || empty($msg['type']) ) { ?>
<script type="text/javascript">
 

var $data = {
    "msg": "<?php  echo $msg['msg'];?>", 
    "title": "<?php  echo $msg['title'];?>", 
    "btn": [
        {
            "text": "<?php  echo $msg['text'];?>", 
            "url": "<?php  echo $msg['url'];?>",
        }
    ]
}

<?php  if(empty($msg['url'])) { ?>

$('#close').click(function(){
    window.history.go(-1);
});

<?php  } ?>

</script>
<?php  } else if($msg['type'] == 2) { ?>
<script>


    var $data = {
        "msg" : "尚未完成报名,无法进入教务系统",
		"title" : "错误弹窗",
        "btn" : [{
            "text": "关闭",
            "url": "close", //按钮跳转事件 , 默认为 go(-1)[返回按钮], 微信关闭页面[关闭按钮]
            "index":0 // 控制显示的位置
        },{
            "text": "立即报名",
            "url": "http://test.expbox.cn", //按钮跳转事件 , 默认为 go(-1)[返回按钮], 微信关闭页面[关闭按钮]
            "index":1 // 控制显示的位置
        }]
    };



</script>
<?php  } ?>

<script>

    var btn = document.querySelectorAll(".buttons li a");

    $id("errmsg").innerHTML = $data.msg?$data.msg:'页面发生错误,请稍后重试';
    $id("err_title").innerHTML = $data.title?$data.title:'页面错误';

    if(!$data.btn) {
        document.querySelector("#close a").style.display = "block";
        document.querySelector("#next a").style.display = "block";
        etouch("#close",function() {
            if(typeof WeixinJSBridge != 'undefined') {
                WeixinJSBridge.call('closeWindow');
            } else {
                self.opener = null;
                self.close();
            }
        });
        etouch("#next", function () {
            history.go(-1);
        });
    } else {
        if($data.btn.length == 1) {
            var idx = $data.btn[0].index;
            if(!idx) idx = 0;
            btn[idx].style.display = "block";
            btn[idx].innerHTML = $data.btn[0].text;
            btn[idx].setAttribute("href",$data.btn[0].url);
        } else {
            for (var i = 0; i < $data.btn.length; i++) {
                var item = $data.btn[i];
                btn[i].style.display = "block";
                btn[i].innerHTML = item.text;
                btn[i].setAttribute("href",item.url);
            }
        }
    }

    function $id(id) {
        return document.getElementById(id);
    }
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=hc_credit_shopping"></script></body>
</html>