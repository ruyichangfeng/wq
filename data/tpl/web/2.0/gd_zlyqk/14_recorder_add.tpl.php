<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/admin/layui/css/layui-v2.css"  media="all">
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/layui/layui.js"></script>
    <link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/mp3/css/audioplayer.css" />
    <style>
        .item div{margin-bottom:10px;}
    </style>
</head>
<body>
<div class="layui-form-item" style="margin-left:50px;">
<button class="layui-btn btn-default print" style="line-height: 20px !important;height: 20px;!important;position: absolute;right:10px;margin-top:-10px;">打印</button>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <?php  if($appInfo['flow_id']) { ?>
    <legend>流程处理详情</legend>
    <?php  } else { ?>
    <legend>信息详情</legend>
    <?php  } ?>
</fieldset>
<ul class="layui-timeline">
    <li class="layui-timeline-item">
        <i class="layui-icon layui-timeline-axis"></i>
        <div class="layui-timeline-content layui-text">
            <?php  if($appInfo['flow_id']) { ?>
            <h3 class="layui-timeline-title">开始节点</h3>
            <?php  } else { ?>
            <h3 class="layui-timeline-title">详情</h3>
            <?php  } ?>
            <?php  if(is_array($msgList)) { foreach($msgList as $index => $msg) { ?>
            <div class="item item<?php  echo $index;?>">
                <?php  if($labInput[$index]) { ?>
                <?php  if(is_array($labInput[$index])) { foreach($labInput[$index] as $input) { ?>
                <?php  if($input['type']=="photo") { ?>
                <div class="txt"><?php  echo $input['name'];?> :
                    <div class="imgList">
                         <?php  if(is_array($input['img'])) { foreach($input['img'] as $pht) { ?>
                            <img  layer-src="<?php  echo $pht;?>" style="width:40px;height:40px;margin-bottom: 5px;margin-top:5px;margin-right:5px;" src="<?php  echo $pht;?>?imageView2/1/w/50/h/50">
                         <?php  } } ?>
                    </div>
                </div>
                <?php  } else if($input['type']=="sg") { ?>
                <div class="txt"><?php  echo $input['name'];?> :
                    <div class="imgList">
                        <img  layer-src="/attachment/<?php  echo $input['val'];?>" style="width:40px;height:40px;margin-bottom: 5px;margin-top:5px;margin-right:5px;" src="/attachment/<?php  echo $input['val'];?>">
                    </div>
                </div>
                <?php  } else if($input['type']=="voice") { ?>
                <p class="txt" style="height: 30px;line-height: 30px;clear: none"><span style="display: inline-block;float: left;margin-right:10px;"><?php  echo $input['name'];?></span><img onclick="hidPlay('<?php  echo $setting['niu_url'];?>/<?php  echo $input['val'];?>')"  style="width:30px;height:30px;" src="/addons/gd_zlyqk//static/mobile/images/voice1.png"></p>
                <?php  } else if($input['type']=="search") { ?>
                <?php  if(is_array($input['val'])) { foreach($input['val'] as $sh) { ?>
                <?php  if(isset($sh['show']) && $sh['show']==1) { ?>
                <div class="txt"><?php  echo $sh['0'];?> : <?php  echo $sh['1'];?></div>
                <?php  } ?>
                <?php  } } ?>
                <?php  } else { ?>
                <div class="txt"><?php  echo $input['name'];?> : <?php  echo $input['val'];?></div>
                <?php  } ?>
                <?php  } } ?>
                <?php  } ?>
                <div class="tags" style="margin-top:10px;">
                    <?php  if($labCom[$index]['node_name']) { ?>
                    <span style="color: #009688"><?php  echo $labCom[$index]['node_name'];?></span>
                    <?php  } ?>
                    <?php  if($labCom[$index]['status_name'] ) { ?>
                    | <span style="color: #009688"><?php  echo $labCom[$index]['status_name'];?></span>
                    <?php  } ?>
                    <div>
                        <?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?><a style="margin-left:20px;"><?php  if($recorder['member_name']) { ?><?php  echo $recorder['member_name'];?><?php  } else { ?><?php  echo $poolInfo['name'];?><?php  } ?></a>
                    </div>
                </div>
            </div>
            <?php  } } ?>
        </div>
    </li>
    <?php  $len=count($noticeList)-1?>
    <?php  if(is_array($noticeList)) { foreach($noticeList as $idx => $nts) { ?>
    <li class="layui-timeline-item">
        <i class="layui-icon layui-timeline-axis"></i>
        <div class="layui-timeline-content layui-text">
            <h3 class="layui-timeline-title"><?php  echo $labComAc[$idx]['node_name'];?>(<?php  echo $labComAc[$idx]['status_name'];?>)</h3>
            <?php  if(is_array($labInputAc[$idx])) { foreach($labInputAc[$idx] as $ms) { ?>
                <?php  if($ms['type']=="photo") { ?>
                <div class="txt"><?php  echo $ms['name'];?> :
                    <div class="imgList">
                        <?php  if(is_array($ms['img'])) { foreach($ms['img'] as $pht) { ?>
                        <img  layer-src="<?php  echo $pht;?>" style="width:40px;height:40px;margin-bottom: 5px;margin-top:5px;margin-right:5px;" src="<?php  echo $pht;?>?imageView2/1/w/50/h/50">
                        <?php  } } ?>
                    </div>
                </div>
                <?php  } else if($input['type']=="sg") { ?>
                <div class="txt"><?php  echo $input['name'];?> :
                    <div class="imgList">
                        <img  layer-src="/attachment/<?php  echo $ms['val'];?>" style="width:40px;height:40px;margin-bottom: 5px;margin-top:5px;margin-right:5px;" src="/attachment/<?php  echo $ms['val'];?>">
                    </div>
                </div>
                <?php  } else if($ms['type']=="voice") { ?>
                <p class="txt" style="height: 30px;line-height: 30px;clear: none"><span style="display: inline-block;float: left;margin-right:10px;"><?php  echo $ms['name'];?></span><img onclick="hidPlay('<?php  echo $setting['niu_url'];?>/<?php  echo $ms['val'];?>')"  style="width:30px;height:30px;" src="/addons/gd_zlyqk//static/mobile/images/voice1.png"></p>
                <?php  } else { ?>
                <div class="txt"><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></div>
                <?php  } ?>
            <?php  } } ?>
            <p>
                <?php  echo $labComAc[$idx]['create_time'];?>
                <a href="" class="btn-fp" style="margin-left:20px;"><?php  echo $labComAc[$idx]['member_name'];?></a>
            </p>
        </div>
    </li>
    <?php  } } ?>
</ul>
    <div id="wrapper" style="position:fixed !important;bottom: 0 !important;width: 80%;left:10%;display: none">
        <audio id="od" src="<?php echo MODULE_URL;?>/static/mp3/audio/seeyouagain.mp3" preload="auto" controls></audio>
    </div>
</div>
<script src="<?php echo MODULE_URL;?>/static/mobile/js/layer.js"></script>
<script src="<?php echo MODULE_URL;?>/static/mp3/js/audioplayer.js"></script>
<script>
    var $;
    layui.use(['form','jquery','upload'], function() {
        var form = layui.form();
        $ = layui.jquery;

        $(".mp").click(function(){
            var url = $(this).attr('data-url');
            var index = layui.layer.open({
                title : "地理位置",
                type : 2,
                content : url,
                area:["620px","550px"],
                success : function(layero, index){
                }
            });
        });

        $(".print").click(function(){
            window.print()
        });

        layui.layer.photos({
            photos: '.imgList'
            ,anim: 5
        });
    });



    function hidPlay(url){
        $("#wrapper").show();
        var aud = document.getElementById("od");
        aud.src=url;
        aud.play();
        aud.onended = function() {
            setTimeout(function(){
                $("#wrapper").hide();
            },1000);
        };
    }
</script>
<script>
    (function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
</script>
<script>$( function() { $( 'audio' ).audioPlayer(); } );</script>
</body>
</html>