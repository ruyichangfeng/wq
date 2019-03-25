<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=VY3BZ-WRWWQ-WUP5C-GKZ6R-WNOSV-G3BZR"></script>
<style>
    #container{
        min-width:600px;
        min-height:500px;
    }
</style>
<form  class="layui-form">
    <blockquote class="layui-elem-quote ">
        <div class="layui-inline">
            <div class="layui-input-inline" style="width: 150px;padding-bottom: 3px;">
                <input class="layui-input start" name="start" readonly value="<?php  echo $_GPC['start'];?>" placeholder="起始日期" id="LAY_demorange_s">
            </div>
            <div class="layui-input-inline "  style="width: 150px;padding-bottom: 3px;">
                <input class="layui-input end" name="end" readonly value="<?php  echo $_GPC['end'];?>" placeholder="结束日期" id="LAY_demorange_e">
            </div>
            <div class="layui-input-inline" style="width: 150px;padding-bottom: 3px;">
                <select name="city" id="app" lay-verify="required" style="">
                    <option value="0">所有应用</option>
                    <?php  if(is_array($appList)) { foreach($appList as $ak => $item) { ?>
                    <option value="<?php  echo $item['id'];?>"><?php  echo $item['name'];?></option>
                    <?php  } } ?>
                </select>
            </div>
            <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
        </div>
        <div style="float: right;line-height: 48px;padding-right:30px;">
            <img style="height: 30px;" src="<?php echo MODULE_URL;?>/static/admin/images/en.png">(终止)
            <img style="margin-left:10px;height: 30px;" src="<?php echo MODULE_URL;?>/static/admin/images/fi.png">(完成)
            <img style="margin-left:10px;height: 30px;" src="<?php echo MODULE_URL;?>/static/admin/images/ru.png">(处理中)
        </div>
    </blockquote>
</form>
<div class="layui-form" id="container" style="width: 100%;margin-top:10px;">

</div>
<script>
    var start,end,app;

    layui.use(['jquery','form'], function(){
        var $ = layui.jquery;
        var form = layui.form();
        init();

        form.on('submit(search)', function(data){
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            init();
            return false;
        });

        function init() {
            $.post("<?php  echo $this->createWebUrl('lcDot')?>",{start:start,end:end,app:app},function(response){
                var data = response.data;
                if(data.length==0){
                    var anchor = new qq.maps.Point(6, 6),
                        size = new qq.maps.Size(50, 48),
                        origin = new qq.maps.Point(0, 0);
                    var map = new qq.maps.Map(document.getElementById("container"), {
                        zoom: 13
                    });
                }else{
                    var anchor = new qq.maps.Point(6, 6),
                        size = new qq.maps.Size(50, 48),
                        origin = new qq.maps.Point(0, 0);
                    var icon = new qq.maps.MarkerImage('<?php echo MODULE_URL;?>/static/admin/images/dot.gif', size, origin, anchor);
                    var first = data[0];
                    var center = new qq.maps.LatLng(first.lat,first.lnt);
                    var map = new qq.maps.Map(document.getElementById("container"), {
                        center: center,
                        zoom: 13
                    });
                    var infoWin = new qq.maps.InfoWindow({
                        map: map
                    });
                    var latlngs =new Array();
                    for(var i=0;i<data.length;i++){
                        latlngs.push( new qq.maps.LatLng(data[i].lat,data[i].lnt))
                    }
                    for(var i = 0;i < latlngs.length; i++) {
                        (function(n){
                            if(data[n].tps==1){
                                var img='<?php echo MODULE_URL;?>/static/admin/images/en.png';
                            }else if(data[n].tps==2){
                                var img='<?php echo MODULE_URL;?>/static/admin/images/fi.png';
                            }else{
                                var img='<?php echo MODULE_URL;?>/static/admin/images/ru.png';
                            }
                            var icon = new qq.maps.MarkerImage(img, size, origin, anchor);
                            var marker = new qq.maps.Marker({
                                icon: icon,
                                position: latlngs[n],
                                map: map
                            });
                            qq.maps.event.addListener(marker, 'click', function() {
                                infoWin.open();
                                infoWin.setContent('<div data-id="'+ data[n].s_id+'" data-app="'+data[n].app_id+'" class="lcs" style="text-align:center;white-space:'+
                                    'nowrap;margin:10px;" title="点击查看详情">地址: ' +
                                    data[n].name + '</div>');
                                infoWin.setPosition(latlngs[n]);
                            });
                        })(i);
                    }
                }
            },"json");
        }

        $("body").on("click",".lcs",function(){
            var id = $(this).attr("data-id");
            var app = $(this).attr("data-app");
            var url = "<?php  echo $this->createWebUrl('viewRecorder')?>&id="+id+"&app_id="+app;
            var index = layui.layer.open({
                title : "查看消息",
                type : 2,
                area : ["550px","90%"],
                content : url
            });
        })
    });
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        var start = {
            max: '2099-06-16 23:59:59'
            ,istoday: true
            ,choose: function(datas){
                end.min = datas;
                end.start = datas;
            }
        };

        var end = {
            max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                start.max = datas;
            }
        };

        document.getElementById('LAY_demorange_s').onclick = function(){
            start.elem = this;
            laydate(start);
        };
        document.getElementById('LAY_demorange_e').onclick = function(){
            end.elem = this
            laydate(end);
        };
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>