<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item" style="margin-top:30px;">
        <input type="hidden" name="app" value="<?php  echo $appId;?>">
        <input type="hidden" name="app_id" value="<?php  echo $recorder['app_id'];?>">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="in[title]" value="<?php  echo $recorder['title'];?>" required="" style="width: 400px;" lay-verify="required" placeholder="输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <input type="text" name="in[desc]" required="" value="<?php  echo $recorder['desc'];?>" style="width: 400px;" lay-verify="required" placeholder="输入简介" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">图标</label>
        <div class="layui-input-block" id="imgList1">
            <input type="hidden" id="cov1" name="in[img]" value="<?php  echo $recorder['img'];?>" >
            <input type="file" name="file" class="layui-upload-file1">
            <img src="/<?php  echo $recorder['img'];?>" id="imgs1"  style=" height:35px;margin-left:20px;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">链接</label>
        <div class="layui-input-block">
            <input type="text" name="in[link]" required="" value="<?php  echo $recorder['link'];?>" style="width: 400px;" lay-verify="require" placeholder="跳转地址" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script>
    layui.use(['form','jquery','upload'], function(){
        var $ = layui.jquery;
        var form = layui.form();
        layui.layer.photos({
            photos: '#imgList1'
            ,anim: 5
        });

        layui.upload({
            elem: '.layui-upload-file1',
            url: "<?php  echo $this->createWebUrl('upload')?>",
            method: 'post',
            ext:'jpg|png|gif',
            success: function (res) {
                layui.layer.msg(res.msg);
                if(res.code==2){
                    return false;
                }
                $("#imgs1").attr("src","/"+res.url);
                $("#cov1").val(res.url);
            }
        });
        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl('shareSet')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        parent.location.reload();
                    },1000);
                }
            },"json");
            return false;
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
