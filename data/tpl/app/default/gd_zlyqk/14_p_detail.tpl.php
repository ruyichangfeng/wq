<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<style>
    .other img{width: 30px;height: 30px;}
    .img img{border-radius: 17.5px;}
</style>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("thems", TEMPLATE_INCLUDEPATH)) : (include template("thems", TEMPLATE_INCLUDEPATH));?>
<body ontouchstart>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">消息列表</div>
</header>
<div class="ui-content">
    <div class="weui-navbar weui-navbar-tabs">
        <div class="weui-navbar weui-navbar-tabs">
            <a class="weui-navbar__item weui-bar__item--on" href="<?php  echo $this->createMobileUrl('pdetail')?>&app_id=<?php  echo $appId;?>&id=<?php  echo $_GPC['id'];?>">
                <?php  if($baseConfig['lcjc']) { ?><?php  echo $baseConfig['lcjc'];?><?php  } else { ?>流程进程<?php  } ?>
            </a>
            <a class="weui-navbar__item " href="<?php  echo $this->createMobileUrl('mdetail')?>&app_id=<?php  echo $appId;?>&id=<?php  echo $_GPC['id'];?>">
                <?php  if($baseConfig['sjbb']) { ?><?php  echo $baseConfig['sjbb'];?><?php  } else { ?>数据报表<?php  } ?>
            </a>
        </div>
    </div>
    <?php  if(is_array($msgList)) { foreach($msgList as $index => $msg) { ?>
    <?php  if($labCom[$index]['is_end']==0) { ?>
    <?php  if($show) { ?>
    <?php  if($msg['is_abort']==0) { ?>
    <?php  if($msg['who']==2) { ?>
    <div class="progress-top">
        <div class="ft-button" style="float: none;">
            <?php  if(is_array($nodeStatus)) { foreach($nodeStatus as $status) { ?>
            <a class="weui-btn weui-btn_mini weui-btn_look checkUrl" href="javascript:" data-url="<?php  echo $this->createMobileUrl('acForm')?>&node_id=<?php  echo $status['node_id'];?>&line_id=<?php  echo $status['id'];?>&rd=<?php  echo $_GPC['id'];?>&app=<?php  echo $appInfo['id'];?>"><?php  echo $status['name'];?></a>
            <?php  } } ?>
            <?php  if($isCancel) { ?>
            <span class="weui-btn weui-btn_mini weui-btn_action cancel" data-id="<?php  echo $msg['pool_id'];?>">取消</span>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
    <?php  } ?>
    <?php  } ?>
    <?php  } ?>
    <?php  } } ?>
    <div class="progress-wrap">
        <ul class="progress-list">
            <?php  if(is_array($noticeList)) { foreach($noticeList as $idx => $nts) { ?>
            <li <?php  if($idx==0) { ?> class="end"<?php  } ?>>
            <div class="progress-box">
                <div class="progress-hd"><span class=""><?php  echo $labComAc[$idx]['node_name'];?><?php  if($labComAc[$idx]['status_name']) { ?>|<?php  echo $labComAc[$idx]['status_name'];?><?php  } ?></span></div>
                <div class="progress-bd">
                    <?php  if(is_array($labInputAc[$idx])) { foreach($labInputAc[$idx] as $input) { ?>
                    <?php  if($input['type']=="photo") { ?>
                    <div class="txt">
                        <span style="display: inline-block;width: 100%;"><?php  echo $input['name'];?></span>
                        <div onclick="showImg($(this))" style="width: 100%;" >
                            <?php  if(is_array($input['img'])) { foreach($input['img'] as $pht) { ?>
                            <img data-url="<?php  echo $pht;?>" style="width:40px;height:40px;margin-bottom: 5px;margin-top:5px;margin-right:5px;" src="<?php  echo $pht;?>?imageView2/1/w/50/h/50">
                            <?php  } } ?>
                        </div>
                    </div>
                    <?php  } else if($input['type']=="sg") { ?>
                    <div class="txt">
                        <span style="display: inline-block;width: 100%;"><?php  echo $input['name'];?></span>
                        <div onclick="showImg($(this))" style="width: 100%;" >
                            <img data-url="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $input['val'];?>" style="width:40px;height:40px;margin-bottom: 5px;margin-top:5px;margin-right:5px;" src="/attachment/<?php  echo $input['val'];?>">
                        </div>
                    </div>
                    <?php  } else if($input['type']=="voice") { ?>
                    <p class="txt" style="height: 30px;line-height: 30px;clear: none"><span style="display: inline-block;float: left;margin-right:10px;"><?php  echo $input['name'];?></span><img onclick="hidPlay('<?php  echo $setting['niu_url'];?>/<?php  echo $input['val'];?>')"  style="width:30px;height:30px;" src="/addons/gd_zlyqk//static/mobile/images/voice1.png"></p>
                    <?php  } else if($input['type']=="local") { ?>
                    <p class="txt"><?php  echo $input['name'];?> : <?php  echo $input['val'];?> <img style="float: right;width: 20px;"  src="<?php echo MODULE_URL;?>/static/mobile/images/lc1.png"  data-lat="<?php  echo $input['lat'];?>"  data-lnt="<?php  echo $input['lnt'];?>" class="notice_lc"></p>
                    <?php  } else if($input['type']=="search") { ?>
                    <?php  if(is_array($input['val'])) { foreach($input['val'] as $sh) { ?>
                    <?php  if(isset($sh['show']) && $sh['show']==1) { ?>
                    <p class="txt"><?php  echo $sh['0'];?> : <?php  echo $sh['1'];?></p>
                    <?php  } ?>
                    <?php  } } ?>
                    <?php  } else { ?>
                    <p class="txt"><?php  echo $input['name'];?> : <?php  echo $input['val'];?></p>
                    <?php  } ?>
                    <?php  } } ?>
                    <p>
                        操作时间 : <?php  echo $labComAc[$idx]['create_time'];?>
                    </p>
                </div>
                <div class="progress-ft"><span class="user"><?php  echo $labComAc[$idx]['member_name'];?></span></div>
            </div>
            </li>
            <?php  } } ?>
            <li>
                <div class="progress-box">
                    <div class="progress-hd"><span class="">开始</span></div>
                    <div class="progress-bd">
                        <p>提交时间：<?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></p>
                    </div>
                    <div class="progress-ft"><span class="user"><?php  echo $recorder['member_name'];?></span></div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div id="wrapper" style="position:fixed !important;bottom: 0 !important;width: 80%;left:10%;display: none">
    <audio id="od" src="<?php echo MODULE_URL;?>/static/mp3/audio/seeyouagain.mp3" preload="auto" controls></audio>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("wx", TEMPLATE_INCLUDEPATH)) : (include template("wx", TEMPLATE_INCLUDEPATH));?>
<?php  if($baseConfig['msg_in']==1) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php  if($isAudio==1) { ?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/mp3/css/audioplayer.css" />
<script src="<?php echo MODULE_URL;?>/static/mp3/js/audioplayer.js"></script>
<script>
    (function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
    $( function() { $( 'audio' ).audioPlayer(); } );
</script>
<?php  } ?>
<script>
    function showImg(_this){
        var imgArr=new Array();
        imgList = _this.find("img");
        imgList.each(function () {
            imgArr.push($(this).attr("data-url"));
        });
        wx.previewImage({
            urls: imgArr
        });
    }

    $(".checkUrl").click(function(){
        var url = $(this).attr("data-url");
        $.post(url+"&check=1",{},function(response){
            if(response.code==1){
                location.href=url;
            }else{
                url ="<?php  echo $this->createMobileUrl('addInfo')?>";
                $.post(url,{post:response.data},function(result){
                    if(result.code==1){
                        successMsg(result.msg);
                        setTimeout(function () {
                            if(response.url==""){
                                location.reload();
                            }else{
                                location.href=response.url;
                            }
                        }, 1000);
                    }else{
                        errorMsg(result.msg);
                    }
                },"json");
            }
        },'json');
    });
    
    //取消操作
    $(".cancel").click(function(){
        var id =$(this).attr('data-id');
        $.post("<?php  echo $this->createMobileUrl('cancel')?>&id="+id,{},function(response){
            if(response.code==1){
                successMsg(response.msg);
                setTimeout(function(){
                    location.reload();
                },1000);
            }else{
                errorMsg(response.msg);
            }
        },"json");
    });

    //浏览图片
    $(".img").click(function(){
        var imgArr=new Array();
        imgList = $(this).find("img");
        imgList.each(function () {
            imgArr.push($(this).attr("data-id"));
        });
        wx.previewImage({
            urls: imgArr
        });
    });

    //查看地理位置
    $(".notice_lc").click(function(){
        wx.openLocation({
            latitude: Number($(this).attr("data-lat")),
            longitude: Number($(this).attr("data-lnt")),
            name: '位置',
            address: $(this).attr("data-name"),
            scale: 14
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
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
