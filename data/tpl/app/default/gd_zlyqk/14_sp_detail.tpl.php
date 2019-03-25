<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("header", TEMPLATE_INCLUDEPATH)) : (include template("header", TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/mp3/css/audioplayer.css" />
<style>
    .other img{width: 30px;height: 30px;}
    .img img{border-radius: 17.5px;}
</style>
<body ontouchstart>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">消息列表</div>
</header>
<div class="ui-content">
    <div class="weui-navbar weui-navbar-tabs">
        <a class="weui-navbar__item" href="<?php  echo $this->createMobileUrl('detail')?>&app_id=<?php  echo $appId;?>&id=<?php  echo $_GPC['id'];?>">
            数据报表
        </a>
        <a class="weui-navbar__item weui-bar__item--on" href="<?php  echo $this->createMobileUrl('sdetail')?>&app_id=<?php  echo $appId;?>&id=<?php  echo $_GPC['id'];?>">
            流程进程
        </a>
    </div>
    <?php  if(is_array($msgList)) { foreach($msgList as $index => $msg) { ?>
    <?php  if($labCom[$index]['is_end']==0) { ?>
    <?php  if($show) { ?>
    <?php  if($msg['is_abort']==0) { ?>
    <div class="progress-top">
        <div class="ft-button" style="float: none;">
            <?php  if($msg['is_remark']==0) { ?>
                <?php  if($appInfo['mods']==0) { ?>
                    <span class="weui-btn weui-btn_mini weui-btn_action remark " data-id="<?php  echo $msg['pool_id'];?>">标记</span>
                <?php  } ?>
            <?php  } else { ?>
            <?php  if($isAdmin['id']==$msg['mark_admin']) { ?>
                <?php  if(is_array($nodeStatus)) { foreach($nodeStatus as $status) { ?>
                <a class="weui-btn weui-btn_mini weui-btn_look" href="<?php  echo $this->createMobileUrl('acForm')?>&node_id=<?php  echo $status['node_id'];?>&line_id=<?php  echo $status['id'];?>&rd=<?php  echo $_GPC['id'];?>&app=<?php  echo $appInfo['id'];?>"><?php  echo $status['name'];?></a>
                <?php  } } ?>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
    <?php  } ?>
    <?php  } ?>
    <?php  } } ?>
    <div class="progress-wrap">
        <ul class="progress-list">
            <?php  if(is_array($noticeList)) { foreach($noticeList as $idx => $nts) { ?>
            <li <?php  if($idx==0) { ?> class="end"<?php  } ?>>
                <div class="progress-box">
                    <div class="progress-hd"><span class="bell"><?php  echo $labComAc[$idx]['node_name'];?><?php  if($labComAc[$idx]['status_name']) { ?>|<?php  echo $labComAc[$idx]['status_name'];?><?php  } ?></span></div>
                    <div class="progress-bd">
                        <?php  if(is_array($labSigAc[$idx])) { foreach($labSigAc[$idx] as $ms) { ?>
                        <p><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></p>
                        <?php  } } ?>
                        <?php  if(is_array($labInputAc[$idx])) { foreach($labInputAc[$idx] as $ms) { ?>
                        <p><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></p>
                        <?php  } } ?>
                        <?php  if(is_array($labAreaAc[$idx])) { foreach($labAreaAc[$idx] as $ms) { ?>
                        <p><?php  echo $ms['name'];?> : <?php  echo $ms['val'];?></p>
                        <?php  } } ?>
                        <?php  if(is_array($labChildAc[$idx])) { foreach($labChildAc[$idx] as $child) { ?>
                        <p><?php  echo $child['name'];?></p>
                        <?php  if(is_array($child['val'])) { foreach($child['val'] as $chd) { ?>
                        <p><?php  echo $chd['key'];?> : <?php  echo $chd['value'];?></p>
                        <?php  } } ?>
                        <?php  } } ?>
                        <p>
                        操作时间 : <?php  echo $labComAc[$idx]['create_time'];?>
                        </p>
                    </div>
                    <div class="progress-ft">
                        <span class="user"><?php  echo $labComAc[$idx]['member_name'];?></span>
                        <?php  if($labComAc[$idx]['photo'] || $labComAc[$idx]['address'] || $labComAc[$idx]['voice']) { ?>
                        <div class="notice_img" style="margin-top:10px;">
                        <?php  if($labComAc[$idx]['photo']) { ?>
                        <span class="img" style="margin-right:15px;">
                        <?php  if(is_array($labComAc[$idx]['photo']['url'])) { foreach($labComAc[$idx]['photo']['url'] as $ul) { ?>
                        <img src="<?php  echo $setting['niu_url'];?>/<?php  echo $ul;?>?imageView2/1/w/35/h/35" data-id="<?php  echo $setting['niu_url'];?>/<?php  echo $ul;?>">
                        <?php  } } ?>
                        </span>
                        <?php  } ?>
                        <span class="other">
                        <?php  if($labComAc[$idx]['address']) { ?>
                        <img src="<?php echo MODULE_URL;?>/static/mobile/images/lc1.png" data-lat="<?php  echo $labComAc[$idx]['address']['lat'];?>" class="notice_lc" data-lnt="<?php  echo $labComAc[$idx]['address']['lnt'];?>"  data-name="<?php  echo $labComAc[$idx]['address']['value'];?>">
                        <?php  } ?>
                        <?php  if($labComAc[$idx]['voice']) { ?>
                        <img  src="<?php echo MODULE_URL;?>/static/mobile/images/voice1.png" onclick="hidPlay('<?php  echo $setting['niu_url'];?>/<?php  echo $labComAc[$idx]['voice']['url'];?>')">
                        <?php  } ?>
                        </span>
                        </div>
                        <?php  } ?>
                    </div>
                </div>
            </li>
            <?php  } } ?>
            <li>
                <div class="progress-box">
                    <div class="progress-hd"><span class="bell">开始</span></div>
                    <div class="progress-bd">
                        <p>操作时间：<?php  echo date("Y-m-d H:i:s",$labCom[0]['create_time'])?></p>
                    </div>
                    <div class="progress-ft"><span class="user"><?php  echo $labCom[0]['member_name'];?></span></div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div id="wrapper" style="position:fixed !important;bottom: 0 !important;width: 80%;left:10%;display: none">
    <audio id="od" src="<?php echo MODULE_URL;?>/static/mp3/audio/seeyouagain.mp3" preload="auto" controls></audio>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("js", TEMPLATE_INCLUDEPATH)) : (include template("js", TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("wx_js", TEMPLATE_INCLUDEPATH)) : (include template("wx_js", TEMPLATE_INCLUDEPATH));?>
<script type='text/javascript' src='<?php echo MODULE_URL;?>/static/new/js/swiper.min.js' charset='utf-8'></script>
<script src="<?php echo MODULE_URL;?>/static/mp3/js/audioplayer.js"></script>
<script>
    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,//可选选项，自动滑动
        pagination : '.swiper-pagination',
        loop : true,
        prevButton:'.swiper-button-prev',
        nextButton:'.swiper-button-next',

    });

    $(".remark").click(function(){
        var id =$(this).attr('data-id');
        $.post("<?php  echo $this->createMobileUrl('remark')?>&id="+id,{},function(response){
            layer.open({
                content: response.msg
                ,skin: 'msg'
                ,time: 1
            });
            if(response.code==1){
                setTimeout(function(){
                    location.reload();
                },1000);
            }
        },"json");
    });

    //取消操作
    $(".cancel").click(function(){
        var id =$(this).attr('data-id');
        $.post("<?php  echo $this->createMobileUrl('cancel')?>&id="+id,{},function(response){
            layer.open({
                content: response.msg
                ,skin: 'msg'
                ,time: 1
            });
            if(response.code==1){
                setTimeout(function(){
                    location.reload();
                },1000);
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
<script>
    (function(doc){var addEvent='addEventListener',type='gesturestart',qsa='querySelectorAll',scales=[1,1],meta=qsa in doc?doc[qsa]('meta[name=viewport]'):[];function fix(){meta.content='width=device-width,minimum-scale='+scales[0]+',maximum-scale='+scales[1];doc.removeEventListener(type,fix,true);}if((meta=meta[meta.length-1])&&addEvent in doc){fix();scales=[.25,1.6];doc[addEvent](type,fix,true);}}(document));
</script>
<script>$( function() { $( 'audio' ).audioPlayer(); } );</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=gd_zlyqk"></script></body>
</html>
