<?php defined('IN_IA') or exit('Access Denied');?><style>
    .list_close{position:absolute;margin-left:71px;margin-top:-9px;width: 18px;}
    .weui-icon-warn{color:#f08500 !important;}
    .ldTp{margin-left:10px !important;}
</style>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<!--<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=VY3BZ-WRWWQ-WUP5C-GKZ6R-WNOSV-G3BZR"></script>-->
<script type="text/javascript">
    wx.config({
        debug: false,
        appId: "<?php  echo $jsSign['appId'];?>",
        timestamp:<?php  echo $jsSign['timestamp'];?>,
        nonceStr: "<?php  echo $jsSign['nonceStr'];?>",
        signature: "<?php  echo $jsSign['signature'];?>",
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onVoiceRecordEnd',
            'playVoice',
            'onVoicePlayEnd',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay'
        ]
    });
</script>
<script>

    var img;
    var voiceId;
    var timeLen;
    var geocoder;
    var playId;
    var cat=0;

    var curVal;
    var recorder;
    var startTime;

    var currVoice;
    var voiceTime=0;
    var playBtn=$(".play");
    var _body = $("body");

    window.onload=init;

    $("#form").on("click",".ldTp",function(){
        var that = $(this);
        if($(this).nextAll(".weui-cells").find(".weui-textarea:first").length){
            var i=0;
            $(this).nextAll(".weui-cells").find(".weui-textarea:first").each(function(){
                if(i==0){
                    $(this).val(that.html());
                }
                i++;
            });
        }
    });

    //开始录音
    $(".voice_btn").click(function(){
        currVoice = $(this);
        startRd();
    });

    exeOnce();
    sumMoney();

    $(document).on('ready', function () {
        if ($('.js-signature').length) {
            $('.js-signature').jqSignature();
        }
    });

    $("#s_cl").click(function(){
        $('.js-signature').jqSignature('clearCanvas');
    });


    //自动计算
    $('.cac_num').bind('input propertychange', function() {
        autoCac($(this));
    });

    $(".cac_num_radio").change(function(){
        autoCac($(this));
    });

    $(".cac_num_checkbox").click(function(){
        autoCac($(this));
    });

    //停止录音
    _body.on("click","#stop_rd",function(){
        stopRd();
    });

    $('.search_change').bind('input propertychange', function() {
        var search = new Object();
        search.id=$(this).attr("data-id");
        search.class=$(this).attr("data-class");
        search.val = $(this).val();
        $.post("<?php  echo $this->createMobileUrl('getData')?>",search,function(response){
            $("."+search.class).remove();
            $(".search_icon").show();
            if(response==""){
                $(".hd_icon").removeClass("weui-icon-success").addClass("weui-icon-warn");
                $(".form_submit").parent().hide();
            }else{
                $(".hd_icon").removeClass("weui-icon-warn").addClass("weui-icon-success");
                $(".form_submit").parent().show();
            }
            $(".search_box").after(response);
        });
    });

    _body.on("click",".ply",function(){
        playId =$(this).attr("data-local");
        wx.playVoice({
            localId: playId
        });
        recorder =layer.open({
            type: 1
            ,shade:0.9
            ,content: '<main style="z-index: 99999;"><div class="loader"><div class="loader-inner ball-scale-multiple" style="width: 100px;"><div></div><div></div><div></div></div></div><button class="weui-btn weui-btn_primary" id="close_rd">停止播放</button></main>'
        });
    });

    //开始录音
    function startRd(){
        wx.startRecord({
            success: function() {
                startTime = new Date().getTime();
                recorder =layer.open({
                    type: 1
                    ,shade:0.9
                    ,content: '<main style="z-index: 99999;"><div class="loader"><div class="loader-inner ball-scale-multiple" style="width: 100px;"><div></div><div></div><div></div></div></div><button class="weui-btn weui-btn_primary" id="stop_rd">停止录音</button></main>'
                });
                timeLen = setInterval(function(){
                    voiceTime +=1;
                },10);
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelector('main').className += 'loaded';
                });
            },
            cancel: function() {
                layerMsg("您拒绝授权");
            }
        });
    }

    //停止录音
    function stopRd(){
        if (new Date().getTime() - startTime < 300) {
            startTime = 0;
            clearTimeout(recordTimer);
            layerMsg("录音时间太短");
        }
        wx.stopRecord({
            success: function(res) {
                voiceId = res.localId;
                uploadVoice(voiceId);
            }
        });
        currVoice.html("[重录]");
        currVoice.css("text-align","right");
        currVoice.css("padding-right","3px");
        currVoice.css("line-height","140px");
        currVoice.css("color","#bbb");
        currVoice.css("font-size","12px");
        layer.close(recorder);
    }

    function init(){
        if($('#container').length>0){
            var center=new qq.maps.LatLng($('#container').attr("data-lnt"),$('#container').attr("data-lat"));
            var map=new qq.maps.Map(document.getElementById("container"),{
                center:center,
                zoom:16,
                mapTypeControl: false,
                draggable: false,
                panControl: false,
                zoomControl: false,
                disableDoubleClickZoom: true
            });
            //添加定时器
            setTimeout(function(){
                var marker=new qq.maps.Marker({
                    position:center,
                    animation:qq.maps.MarkerAnimation.DROP,
                    map:map
                });
                var label = new qq.maps.Label({
                    position: center,
                    map: map,
                    content:$('#container').attr("data-name")
                });
            },2000);
        }
    }

    //获取城市插件
    if($(".city").length>0){
        var area1 = new LArea();
        if($(".city").length>0){
            area1.init({
                'trigger': '.city',
                'keys': {
                    id: 'id',
                    name: 'name'
                },
                'type': 1,
                'data': LAreaData
            });
        }
    }


    //整合自定义表单值
    $(".form_submit").click(function(){
        $(".child-group").each(function(){
            //表单列
            var colVal="";
            var col =$(this).find(".fina_col");
            $(this).find(".weui-cell_vcode").each(function(){
                var head=$(this).find(".header").val();
                var body=$(this).find(".body").val();
                if(colVal==""){
                    colVal =head+"="+body
                }else{
                    colVal +="|"+head+"="+body;
                }
            });
            col.val(colVal);
        });
    });

    wx.ready(function () {
        var shareInfo ;
        $.post("<?php  echo $this->createMobileUrl('share')?>",{},function(response){
            shareInfo = response.data;
            wx.onMenuShareTimeline({
                title: shareInfo.title,
                desc: shareInfo.desc,
                link: shareInfo.link,
                imgUrl: shareInfo.imgUrl,
                success: function (res) {
                    successMsg("分享成功")
                },
                cancel: function (res) {
                    errorMsg("您取消了分享");
                },
                fail: function (res) {
                    errorMsg("分享失败");
                }
            });
            wx.onMenuShareAppMessage({
                title: shareInfo.title,
                desc: shareInfo.desc,
                link: shareInfo.link,
                imgUrl: shareInfo.imgUrl,
                success: function (res) {
                    successMsg("分享成功")
                },
                cancel: function (res) {
                    errorMsg("您取消了分享");
                },
                fail: function (res) {
                    errorMsg("分享失败");
                }
            });
        },"json");
    });

    function autoCac(obj){
        var bs =obj.attr("name");
        if(obj.hasClass("_select")){
            curVal = obj.find("option:selected").attr("data-id");
            eval(bs+"="+curVal);
        }else if(obj.hasClass("cac_num_radio")){
            curVal = obj.attr("data-id");
            eval(bs+"="+curVal);
        }else if(obj.hasClass("cac_num_checkbox")){
            var bs =obj.attr("data-name");
            var vl=obj.attr("data-id");
            if(obj.is(':checked')){
                eval(bs+"+="+vl);
            }else{
                eval(bs+"-="+vl);
            }
        }else{
            curVal = obj.val();
            if(curVal==""){
                curVal=0;
            }
            eval(bs+"="+curVal);
        }
        if(curVal==""){
            curVal=0;
            eval(bs+"="+curVal);
        }
        $(".cac_c").each(function(){
            var gsName=$(this).attr("data-gs");
            var gsList=gsName.split("##");
            if(gsList.length==1){
                var gsLs=gsName.split("|");
                if(gsLs.length==2 && gsLs[1]=="p"){
                    $(this).val(Math.floor(eval(gsLs[0]) * 100) / 100);
                    if($(".page_pay").length==0){
                        $("form").append("<input type='hidden' class='page_pay' name='page_pay' value='0'>");
                    }
                }else{
                    $(this).val(Math.floor(eval(gsName) * 100) / 100);
                }
            }else{
                eval("condition="+gsList[0]);
                var tjStr=gsList[1];
                var tjList=tjStr.split("|");
                for(var i=0;i<tjList.length;i++){
                    var gjs=tjList[i].split("#");
                    if(gjs.length==3){
                        if(curVal==""){
                            $(this).val(0);
                        }else if(condition>parseFloat(gjs[1]) && condition<parseFloat(gjs[2])){
                            $(this).val(Math.floor(eval(gjs[0]) * 100) / 100);
                        }
                    }else if(tjList[i]=="p"){ //需要支付
                        if($(".page_pay").length==0) {
                            $("form").append("<input type='hidden' class='page_pay' name='page_pay' value='0'>");
                        }
                    }
                }
            }
        });
    }

    //播放录音,如果播放中,点击停止
    _body.on('click','#close_rd',function(){
        layer.close(recorder);
        wx.stopVoice({
            localId:playId
        });
    });

    wx.ready(function () {
        //如果超过一分钟自动停止
        wx.onVoiceRecordEnd({
            complete: function (res) {
                stopRd();
                layer.close(recorder);
            }
        });

        //自动检测停止
        wx.onVoicePlayEnd({
            complete: function (res) {
                layer.close(recorder);
            }
        });

        //位置插件,签到插件
        var lc=$("#local_p");
        if(lc.length>0){
            wx.getLocation({
                type:'gcj02',
                success: function (res) {
                    geocoder = new qq.maps.Geocoder({
                        complete : function(result){
                            if(lc.length>0) lc.val(result.detail.address);
                        }
                    });
                    var latLng = new qq.maps.LatLng(res.latitude, res.longitude);
                    geocoder.getAddress(latLng);
                    $("#lat").val(res.latitude);
                    $("#lnt").val(res.longitude);
                },
                cancel: function (res) {
                    layerMsg("拒绝授权获取位置");
                }
            });
        }
    });

    //播放图标动画
    function playVoice(bg,classes){
        if(classes){
            img = "<?php echo MODULE_URL;?>/static/mobile/css/images/vioce"+bg+".png";
            $("."+classes).css("background",'url('+img+') 0.2rem center no-repeat #89e5d2');
            $("."+classes).css("background-size",'.26rem .35rem');
        }else{
            img = "<?php echo MODULE_URL;?>/static/mobile/css/images/vioce"+bg+".png";
            playBtn.css("background",'url('+img+') 0.2rem center no-repeat #89e5d2');
            playBtn.css("background-size",'.26rem .35rem');
        }

    }

    //初始化录音时长
    function resetVoiceTime(second){
        var sec = 0;
        var mic = 0;
        voiceTime=0;
        clearInterval(timeLen);
        if(second){
            sec=parseInt(second/1000);
            mic = second%100;
        }
        return [sec,mic];
    }

    //删除语音
    _body.on("click",".rm_voice",function(){
        $(this).parent().remove();
        return false;
    });

    //删除图片
    _body.on("click",".rm_img",function(){
        var index = $(this).attr("data-index");
        var box = $(this).parent().parent().parent().find(".weui-uploader__input-box");
        var localList=box.attr('data-local').split(",");
        var serverList = box.find(".weui-uploader__input").val().split(",");
        localList.splice(index,1);
        serverList.splice(index,1);
        box.attr('data-local',localList.join(','));
        box.find(".weui-uploader__input").val(serverList.join(','));
        $(this).parent().remove();
        return false;
    });

    //上传录音
    function uploadVoice(voice_id){
        wx.uploadVoice({
            isShowProgressTips:0,
            localId: voice_id,
            success: function (res) {
                var tmL = resetVoiceTime(new Date().getTime() - startTime);
                var html='<li class="weui-uploader__file ply" data-local="'+voice_id+'" style="border: 1px solid #f08500;"> <div><img style="width:40px;height:40px;display:block;margin:0 auto;margin-top:10px;" src="/addons/gd_zlyqk//static/mobile/images/voice1.png"></div> <div style="line-height:30px;text-align:center;color:#f08500">'+ tmL[0]+"'"+tmL[1]+"''"+'</div> </li>';
                $("."+currVoice.attr("data-select")).val(res.serverId+","+''+tmL[0]+"#"+tmL[1]+'*');
                $("."+currVoice.attr("data-select")).attr("data-local",voice_id);
                currVoice.parent().find(".weui-uploader__files").html(html);
            }
        });
    }

    $(".weui-textarea").keyup(function(){
        if($(this).attr("data-fh")!='undefined' && $(this).attr("data-fh")==0){
            var cont =charTrip($(this).val());
        }else{
            var cont =$(this).val();
        }
        var len = cont.length;
        $(this).parent().find(".weui-textarea-counter").find(".area_num").text(len);
        if($(this).attr("data-fh")!='undefined'){
            var money=parseFloat(len)*parseFloat($(this).attr("data-price"));
            if($(".page_pay").length==0){
                $("form").append("<input type='hidden' class='page_pay' name='page_pay' value='0'>");
            }
            if(len==0){
                $("."+$(this).attr("name")).text("");
            }else{
                $("."+$(this).attr("name")).text("("+money+"元)");
            }
            $(this).attr("data-money",money);
            sumMoney();
        }
    });

    //加载时自动计算一次
    function exeOnce(){
        $(".char_pay").each(function(){
            if($(this).attr("data-fh")!='undefined' && $(this).attr("data-fh")==0){
                var cont =charTrip($(this).val());
            }else{
                var cont =$(this).val();
            }
            var len = cont.length;
            $(this).parent().find(".weui-textarea-counter").find(".area_num").text(len);
            if($(this).attr("data-fh")!='undefined'){
                var money=parseFloat(len)*parseFloat($(this).attr("data-price"));
                if($(".page_pay").length==0){
                    $("form").append("<input type='hidden' class='page_pay' name='page_pay' value='0'>");
                }
                if(len==0){
                    $("."+$(this).attr("name")).text("");
                }else{
                    $("."+$(this).attr("name")).text("("+money+"元)");
                }
                $(this).attr("data-money",money);
            }
        });
    }

    //合计价格
    function sumMoney(){
        if($("#show_m").length==1){
            var fix =parseFloat($("#show_m").attr("data-money"));
            $(".char_pay").each(function(){
                if($(this).attr("data-money")!='undefined'){
                    fix += parseFloat($(this).attr("data-money"));
                }
            });
            $(".page_pay").val(fix);
            $("#sum_m").val( $("#sum_m").attr('data-tp').replace("#",fix));
            $("#show_m").text(fix);
        }
    }

    //图片处理最多 传4张图片
    var serverId = new Array();
    $(".weui-uploader__input-box").click(function(){
        var _this=$(this);
        var imgList="";
        var imgTotal=_this.attr("data-total");
        var imgBox= $(".img_"+_this.attr("data-select"));
        var localStr=_this.attr("data-local");
        var localId =(localStr=="") ? new Array() : _this.attr("data-local").split(",");
        wx.chooseImage({
            count: imgTotal,
            success: function (res) {
                for (var len=0;len<res.localIds.length;len++){
                    if(localId.length<imgTotal){
                        localId.push(res.localIds[len]);
                    }
                }
                $(".have_"+_this.attr("data-select")).html(localId.length);
                //添加图片到预览列表
                imgBox.html("");
                for(var index=0;index<localId.length;index++){
                    imgList +='<li class="weui-uploader__file"><img data-index="'+index+'" class="list_close rm_img" src="<?php echo MODULE_URL;?>/static/weui/images/close3.png"><img class="up_img"  src="'+localId[index]+'" style="width: 79px;height:79px;border: 1px solid #f08500;"><a href="" class="btn-close" data-id="'+index+'"></a></li>';
                }
                _this.attr("data-local",localId.join(","));
                imgBox.html(imgList);
                upLoadImg(localId,_this);
            }
        });
    });

    //图片预览
    $(".weui-uploader__files").on("click",".up_img",function(){
        var localStr=$(this).parent().parent().parent().find(".weui-uploader__input-box").attr("data-local");
        if(localStr==""){
            return false;
        }
        var localId = localStr.split(",");
        wx.previewImage({
            urls: localId
        });
    });

    //上传图片
    function upLoadImg(localId,_this){
        var i = 0 ;
        var length = localId.length;
        $("#showTooltips").text("图片上传中");
        serverId = [];
        function upload() {
            wx.uploadImage({
                isShowProgressTips:0,
                localId: localId[i],
                success: function (res) {
                    i++;
                    serverId.push(res.serverId);
                    if (i < length) {
                        upload();
                    }else{
                        $("#showTooltips").text("确定");
                    }
                    _this.find(".weui-uploader__input").val(JSON.stringify(serverId));
                },
                fail: function (res) {
                    layerMsg(JSON.stringify(res));
                }
            });
        }
        upload();
    }

    //查看地理位置
    $(".view_address").click(function(){
        var name=$("#local_p").val();
        wx.openLocation({
            latitude: Number($("#lat").val()),
            longitude: Number($("#lnt").val()),
            name: '地理位置',
            address: name,
            scale: 14
        });
    });

    var level=0;
    //联动菜单操作
    $(".select_ld").change(function(){
        var parent_id =$(this).val();
        if(parent_id==0){
            return false;
        }
        $(".ldTp").remove();
        removeLevel(0);
        //或联动数据
        $.post("<?php  echo $this->createMobileUrl('getChild')?>&parent_id="+parent_id,{},function(response){
            if(response.code==2){
                layerMsg(response.msg);
            }
            var dataList=response.data;
            if(dataList.length==0){
                var nt =$(".select_child:last").find("option:selected").attr("data-desc");
                if(nt!=""){
                    $(".ld_select:last").after('<div class="weui-cells__tips ldTp">'+nt+'</div>');
                }
                return false;
            }
            level +=1;
            //自动添加需要的子分类
            var select = '<div class="weui-cell weui-cell_select ld_select level_'+level+'" style="padding-left: 15px;"><div class="weui-cell__hd"><label for="" class="weui-label">'+response.name+'</label></div><div class="weui-cell__bd"> <select class="weui-select select_child select_cm" data-level="'+level+'" style="padding-left:0">';
            for(var x in dataList){
                if(dataList[x].id!=undefined) {
                    select += '<option value="' + dataList[x].id + '" data-desc="'+dataList[x].des+'">' + dataList[x].name + '</option>';
                }
            }
            select +='</select> </div> </div>';
            $(".ld_select:last").after(select);
            var nt =$(".select_child:last").find("option:selected").attr("data-desc");
            if(nt!=""){
                $(".ld_select:last").after('<div class="weui-cells__tips ldTp">'+nt+'</div>');
            }
        },"json");
    });

    _body.on('change','.select_child',function(){
        var parent_id =$(this).val();
        $(".ldTp").remove();
        if(parent_id==0){
            return false;
        }
        level =$(this).attr("data-level");
        removeLevel(level);
        var obj=$(this).parent().parent().parent();
        //或联动数据
        $.post("<?php  echo $this->createMobileUrl('getChild')?>&parent_id="+parent_id,{},function(response){
            if(response.code==2){
                layerMsg(response.msg);
            }
            level =1+parseInt(level);
            var dataList=response.data;
            if(dataList.length==0){
                var nt =$(".select_child:last").find("option:selected").attr("data-desc");
                if(nt!=""){
                    $(".ld_select:last").after('<div class="weui-cells__tips ldTp">'+nt+'</div>');
                }
                return false;
            }
            //自动添加需要的子分类
            var select = '<div class="weui-cell weui-cell_select ld_select level_'+level+'" style="padding-left: 15px;"><div class="weui-cell__hd"><label for="" class="weui-label">'+response.name+'</label></div><div class="weui-cell__bd"> <select class="weui-select select_child select_cm" data-level="'+level+'" style="padding-left:0">';
            for(var x in dataList){
                if(dataList[x].id!=undefined){
                    select += '<option value="'+dataList[x].id+'" data-desc="'+dataList[x].des+'">'+dataList[x].name+'</option>';
                }
            }
            select +='</select> </div> </div>';
            $(".ld_select:last").after(select);
            var nt =$(".select_child:last").find("option:selected").attr("data-desc");
            if(nt!=""){
                $(".ld_select:last").after('<div class="weui-cells__tips ldTp">'+nt+'</div>');
            }
        },"json");
    });

    $("document").ready(function(){
        if($('.in_num').length>0){
            $(".in_num").val(1)
            autoCac($(".in_num"));
        }
        if($(".store_box").length>0){
            var priceInfo = $(".store_box").val();
            $(".price_nd").val(parsePrice(priceInfo));
            $(".price_nd").attr("readonly",true);
        }
    });

    $(".store_box").change(function(){
        var priceInfo = $(this).val();
        $(".price_nd").val(parsePrice(priceInfo));
        autoCac($(".price_nd"));
    });

    function parsePrice(str){
        var priceList =str.split("-");
        return priceList[2];
    }

    var pageii;

    //去掉个数字符
    function charTrip(str) {
        return str.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\<|\.|\>|\/|\?|\！|\，|\。|\;|\‘|\”|\：|\？]/g,"");
    }

    //删除下边几个级别的
    function removeLevel(level){
        level =parseInt(level);
        //删除下级别
        for(var i=(level+1);i<(level+10);i++){
            $(".level_"+i).remove();
        }
    }

    //layer 通知函数
    function layerMsg(notice){
        errorMsg(notice);
    }

    var parent_code=0;
    var selectIds="";
    var selectShow="";
    var sBox;
    $(".view_pp").click(function(){
        sBox =$(this);
        $.post("<?php  echo $this->createMobileUrl('ccp')?>",{id:0},function(data){
            if(data==""){
                sBox.parent().parent().find(".weui-input").val(name+'['+id+']');
                return false;
            }
            pageii =layer.open({
                title: [
                    '<img id="left" class="bk" src="/addons/gd_zlyqk/static/mobile/images/bk.png" style="margin-top:15px;height: 25px;"><span class="bk" style="display: inline-block;position: fixed;left:10%;font-size:17px;">返回</span><a id="center">选择分类</a><a href="javascript:" id="right" style="font-size:18px;font-weight:600">已选(0)</a> ',
                    'background-color:#f08500; color:#fff;'
                ]
                ,anim: 'up'
                ,content: data
                ,btn: ['确认', '关闭']
                ,yes: function(index){
                    if($("#right").hasClass("doing")){
                        selectIds="";
                        selectShow="";
                        $(".select_img").each(function(){
                            var objs =$(this).parent().parent();
                            selectIds +=(selectIds=="")?objs.attr("data-id"):","+objs.attr("data-id");
                            selectShow +=(selectShow=="")?objs.attr("data-name")+" "+objs.attr("data-code"):","+objs.attr("data-name")+" "+objs.attr("data-code");
                        });
                        $("#pps").val(selectShow);
                        layer.closeAll()
                        return false;
                    }
                    if(parent_code!=0){
                        if($(".select_img").length==0){
                            return false;
                        }
                        $(".select_img").each(function(){
                            var objs =$(this).parent().parent();
                            selectIds +=(selectIds=="")?objs.attr("data-id"):","+objs.attr("data-id");
                            selectShow +=(selectShow=="")?objs.attr("data-name")+" "+objs.attr("data-code"):","+objs.attr("data-name")+" "+objs.attr("data-code");
                        });
                        $("#pps").val(selectShow);
                        getLen();
                        parent_code=0;
                        layer.closeAll()
                    }
                    if($(".select_img").length==0){
                        return false;
                    }
                    var obj = $(".select_img").parent().parent();
                    $.post("<?php  echo $this->createMobileUrl('ccp')?>",{id:obj.attr("data-code")},function(data){
                        if(data==""){
                            return false;
                        }
                        $(".layui-m-layercont").html(data)
                    });
                }
            });
            getLen();
        });
    });

    function getLen(){
        var len=selectIds.split(",").distinct();
        var val=selectShow.split(",").distinct();
        $("#pps").val(val.join(","));
        if(selectIds==""){
            $("#right").html("已选(0)");
        }else{
            $("#right").html("已选("+len.length+")");
        }

    }

    $("body").on("click",".bk",function(){
        $("#center").text("选择分类")
        $.post("<?php  echo $this->createMobileUrl('ccp')?>",{id:parent_code},function(data){
            $(".layui-m-layercont").html(data)
        });
    });

    $("body").on("click","#right",function(){
        getLen();
        $("#right").addClass("doing");
        $.post("<?php  echo $this->createMobileUrl('selectPb')?>",{id:selectIds},function(data){
            $("#center").text("以选定列表")
            $(".layui-m-layercont").html(data)
        });
    });

    function openDir(li){
        $("#right").removeClass("doing");
        if(parent_code!=0){
            if($("#img_"+li).hasClass("select_img")){
                $("#img_"+li).removeClass("select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_1.png")
            }else{
                $("#img_"+li).addClass("select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_2.png")
            }
        }else{
            var liId=$(".li_"+li).attr("data-code");
            $.post("<?php  echo $this->createMobileUrl('ccp')?>",{id:liId},function(data){
                if(data==""){
                    return false;
                }
                $(".layui-m-layercont").html(data)
            });
            // if($("#img_"+li).hasClass("select_img")){
            //     $("#img_"+li).removeClass("select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_1.png")
            // }else{
            //     $(".select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_1.png");
            //     $(".s_img").removeClass("select_img");
            //     $("#img_"+li).addClass("select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_2.png")
            // }
        }
    }
    function openDirs(li){
        if($("#img_"+li).hasClass("select_img")){
            $("#img_"+li).removeClass("select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_1.png")
        }else{
            $("#img_"+li).addClass("select_img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/s_2.png")
        }
    }

    Array.prototype.distinct = function(){
        var arr = this,
            result = [],
            i,
            j,
            len = arr.length;
        for(i = 0; i < len; i++){
            for(j = i + 1; j < len; j++){
                if(arr[i] === arr[j]){
                    j = ++i;
                }
            }
            result.push(arr[i]);
        }
        return result;
    }

</script>

<script>
    var doing=0;
    //数据提交操作
    if($("#form").length){
        $("#form").Validform({
            btnSubmit:".form_submit",
            postonce:true,
            tiptype:function(msg,o,cssctl){
                if(o.type==3){
                    errorMsg(msg);
                    return false;
                }
            },
            beforeSubmit:function(curform){
                // var needLay=false;
                var hasPhoto=$("#uploaderInput");
                if($(".search_box").length>0){
                    $(".search_box").each(function(){
                        var str="";
                        var lb= $(this).find(".weui-cell__hd").find(".lb").text();
                        var vl= $(this).find(".weui-cell__bd").find(".search_change").val();
                        str +=lb+"="+vl;
                        var cls = $(this).attr("data-class");
                        $("."+cls).each(function(){
                            lb= $(this).find(".weui-cell__hd").find(".lb").text();
                            vl= $(this).find(".weui-cell__bd").find(".lvse").val();
                            str +="#"+lb+"="+vl;
                        });
                        str+="#id="+$('.search_change').attr("data-id");
                        $(this).find(".weui-cell__bd").find(".lvse").val(str);
                    });
                }
                if ($('.js-signature').length) {
                    var dataUrl = $('.js-signature').jqSignature('getDataURL');
                    var dataClass=$('.js-signature').attr("data-class");
                    $("#"+dataClass).val(dataUrl);
                }
                if($(".page_pay").length>0){
                    $(".cac_c").each(function(){
                        if($(".page_pay").length>0){
                            var add = Math.floor($(this).val() * 100) / 100;
                            $(".page_pay").val(add);
                        }
                    });
                }
                // if(hasPhoto.length>0){
                //     needLay=true;
                // }
                if($(".select_result").length>0){
                    var str="";
                    $(".select_cm").each(function(){
                        str +=$(this).val()+",";
                    });
                    $(".select_result").val(str);
                }
                if($(".weui-cells_checkbox").length>0){
                    $(".weui-cells_checkbox").each(function(){
                        var str="";
                        __this=$(this);
                        __this.find(".checkbox_list").each(function(){
                            if($(this).is(":checked")){
                                if(str==""){
                                    str +=$(this).val();
                                }else{
                                    str +=","+$(this).val();
                                }
                            }
                        });
                        __this.find(".checkbox_val").val(str);
                    });
                }

                if($(".boxs").length>0){
                    $(".boxs").each(function(){
                        var box_val=$(this).parent().find(".box_val").val();
                        var pre_val = $(this).parent().parent().find(".pre_val").val();
                        $(this).parent().find(".boxs").val(pre_val+box_val);
                    });
                }
                if(doing==1) {
                    return false;
                }
                doing=1;
                var post=$("form").serialize();
                var url=$("#form").attr("action");
                $.ajax({
                    url:url,
                    type:'post',
                    data:{post:post},
                    dataType:"json",
                    beforeSend:function(){
                        lay = layer.open({type: 2,content: "正在处理"});
                    },
                    success:function(result){
                        setTimeout(function(){
                            layer.close(lay);
                            if(result.code==1){
                                successMsg(result.msg);
                                setTimeout(function(){
                                    <?php  if(!empty($_url)) { ?>
                                    location.href="<?php  echo $_url;?>";
                                    return false;
                                    <?php  } ?>
                                        if($(".zh_url").length==1){
                                            location.href=$(".zh_url").val();
                                        }else if(result.data!=""){
                                            location.href=result.data;
                                        }else{
                                            location.reload();
                                        }
                                    },1100);
                            }else{
                                errorMsg(result.msg);
                            }
                        },600);
                        doing =0;
                    }
                });
                return false;
            }
        });
    }
</script>
