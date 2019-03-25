<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .adm_ln{line-height: 40px;margin-right: 10px;}
</style>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.js"></script>
<form class="layui-form" >
    <div class="layui-form-item">
        <input type="hidden" name="id" value="<?php  echo $recorder['id'];?>">
        <label class="layui-form-label">广告名</label>
        <div class="layui-input-block">
            <input type="text" name="in[name]" style="width: 300px;" value="<?php  echo $recorder['name'];?>" required="" lay-verify="required" placeholder="请输入广告名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="number" name="in[sorter]" style="width: 300px;" value="<?php  echo $recorder['sorter'];?>" required=""  placeholder="越大越靠前" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">连接地址</label>
        <div class="layui-input-block">
            <input type="text" name="in[url]" style="width: 300px;" value="<?php  echo $recorder['url'];?>" required=""  placeholder="广告跳转地址" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
    <label class="layui-form-label">广告图</label>
    <div class="layui-input-block" id="imgList">
        <input type="hidden" id="cov" class="covs" name="in[cover]" value="<?php  echo $recorder['cover'];?>" >
        <input type="file" name="file" class="layui-upload-file">
        <img src="<?php  if(strstr($recorder['cover'],'http')) { ?><?php  echo $recorder['cover'];?><?php  } else { ?>/<?php  echo $recorder['cover'];?><?php  } ?>" id="imgs"  style=" height:35px;margin-left:20px; <?php  if(empty($recorder['cover']) ) { ?> display: none; <?php  } ?>">
        <a href="javascript:" class="rem layui-btn layui-btn-danger layui-btn-mini" style="margin-left:15px;width: 30px;">删除</a>
        <span style="margin-left: 30px;">建议尺寸(414 x 180)</span>
    </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="radio" name="in[status]" title="正常" value="1" <?php  if($recorder['status']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[status]" title="禁用" value="0" <?php  if($recorder['status']==0) { ?> checked <?php  } ?>>
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
    var fresh="<?php  echo $fresh;?>";
    $(".rem").click(function(){
        $(this).parent().find("img").hide();
        $(this).parent().find(".covs").val("");
    });
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        var $ = layui.jquery;

        layui.layer.photos({
            photos: '#imgList'
            ,anim: 5
        });

        layui.upload({
            elem: '.layui-upload-file',
            url: "<?php  echo $this->createWebUrl('upload')?>",
            method: 'post',
            ext:'jpg|png|gif',
            success: function (res) {
                layui.layer.msg(res.msg);
                if(res.code==2){
                    return false;
                }
                $("#imgs").show();
                $("#imgs").attr("src","/"+res.url);
                $("#cov").val(res.url);
            }
        });
        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl($_GPC['do'],array('tb'=>'ad'))?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        if(fresh){
                            parent.parent.location.reload();
                        }else{
                            parent.location.reload();
                        }

                    },1000);
                }
            },"json");
            return false;
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
