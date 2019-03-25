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
    <style>
        .item div{margin-bottom:10px;}
    </style>
</head>
<body>
<div class="layui-form-item" style="margin-left:50px;">
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
                <?php  if($labSig[$index]) { ?>
                <?php  if(is_array($labSig[$index])) { foreach($labSig[$index] as $area) { ?>
                <div class="txt"><?php  echo $area['name'];?> : <?php  echo $area['val'];?></div>
                <?php  } } ?>
                <?php  } ?>
                <?php  if($labInput[$index]) { ?>
                <?php  if(is_array($labInput[$index])) { foreach($labInput[$index] as $input) { ?>
                <div class="txt"><?php  echo $input['name'];?> : <?php  echo $input['val'];?></div>
                <?php  } } ?>
                <?php  } ?>
                <?php  if($labArea[$index]) { ?>
                <?php  if(is_array($labArea[$index])) { foreach($labArea[$index] as $area) { ?>
                <div class="txt"><?php  echo $area['name'];?> : <?php  echo $area['val'];?></div>
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
                        <?php  echo date("Y-m-d H:i:s",$labCom[$index]['create_time'])?><a style="margin-left:20px;"><?php  echo $labCom[$index]['member_name'];?></a>
                    </div>
                </div>
                <div class="swiper-container">
                    <?php  if($labPhoto[$index] ) { ?>
                    <div class="swiper-wrapper imgList">
                        <?php  if(is_array($labPhoto[$index])) { foreach($labPhoto[$index] as $photo) { ?>
                        <img src="<?php  echo $setting['niu_url'];?>/<?php  echo $photo;?>?imageView2/1/w/60/h/60"  layer-src="<?php  echo $setting['niu_url'];?>/<?php  echo $photo;?>">
                        <?php  } } ?>
                    </div>
                    <?php  } ?>
                </div>
                <div class="btm">
                    <audio id="audio" src="#" style="display: none"></audio>
                    <?php  if($labCom[$index]['lc_lat']) { ?>
                    <img  src="<?php echo MODULE_URL;?>/static/mobile/images/icon15.png" data-url="<?php  echo $this->createWebUrl('map',array('lat'=>$labCom[$index]['lc_lat'],'lnt'=>$labCom[$index]['lc_lnt']))?>" style="height:30px;margin-left:10px"  class="icon show_address mp">
                    <?php  } ?>
                    <?php  if($labVoice[$index]) { ?>
                    <i class="layui-icon" style="font-size: 30px !important;color:#FF5722;margin-left:10px;cursor:pointer" onclick="play('<?php  echo $setting['niu_url'];?>/<?php  echo $labVoice[$index];?>','plb_<?php  echo $index;?>')"></i><sub><?php  echo $labCom[$index]['voice_time'];?></sub>
                    <?php  } ?>
                    <?php  if($labCom[$index]['is_end']==0) { ?>
                    <div class="tags" style="position: absolute;right:2px;top:15px;">
                        <?php  if(is_array($nodeInfo['status_list'])) { foreach($nodeInfo['status_list'] as $node) { ?>
                        <span><a href="<?php  echo $this->createMobileUrl('acForm')?>&node_id=<?php  echo $nodeInfo['id'];?>&status=<?php  echo $node['do'];?>&status_name=<?php  echo $node['status'];?>&rd=<?php  echo $_GPC['id'];?>" style="color: white"><?php  echo $node['status'];?></a></span>
                        <?php  } } ?>
                    </div>
                    <?php  } ?>
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
            <?php  if(is_array($labSigAc[$idx])) { foreach($labSigAc[$idx] as $ms) { ?>
            <p><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></p>
            <?php  } } ?>
            <?php  if(is_array($labInputAc[$idx])) { foreach($labInputAc[$idx] as $ms) { ?>
            <p><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></p>
            <?php  } } ?>
            <?php  if(is_array($labAreaAc[$idx])) { foreach($labAreaAc[$idx] as $ms) { ?>
            <p><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></p>
            <?php  } } ?>
            <p>
                <?php  echo $labComAc[$idx]['create_time'];?>
                <a href="" class="btn-fp" style="margin-left:20px;"><?php  echo $labComAc[$idx]['member_name'];?></a>
            </p>
        </div>
    </li>
    <?php  } } ?>
</ul>
</div>
<script src="<?php echo MODULE_URL;?>/static/mobile/js/layer.js"></script>
<script>
    var audio = document.getElementById('audio');

    function play(url){
        audio.src=url;
        audio.play();
    }
    layui.use(['form','jquery','upload'], function() {
        var form = layui.form();
        var $ = layui.jquery;

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
        layui.layer.photos({
            photos: '.imgList'
            ,anim: 5
        });
    });
</script>
</body>
</html>