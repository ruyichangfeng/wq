<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <title><?php  echo $this->config['system_name']?></title>
</head>
<body>
<div class="box">
    <div class="tops">
        <div class="col-xs-2 text01-l">
            <a href="javascript:" onclick="history.back(); ">
                <img src="<?php echo RES;?>mobile/images/back-white.png">
            </a>
        </div>
        <div class="col-xs-8 text01-c">核销码</div>
    </div>
    <div class="code-content">
        <div class="code">
            <img src="<?php  echo $order['order_code'];?>" alt="" width="100%">
        </div>
        <div style="text-align: center">
            <p>请将此二维码出示给店员</p>
        </div>
    </div>

</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
<script>
    setInterval(runajax,3000);
    function runajax(){

        $.ajax({
            type:"GET",
            url: "<?php  echo $this->createMobileUrl('verification', array('order_id'=>$order['order_id']));?>",
            success:function(data){
                if(data == 2)
                {
                    var url="<?php  echo $this->createMobileUrl('mine', array('op'=>'finish'));?>";
                    window.location.href = url;

                }else{

                }
            }
        });
    }
</script>
</html>