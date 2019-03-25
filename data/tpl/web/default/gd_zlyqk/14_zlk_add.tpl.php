<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item">
        <input type="hidden" name="id" value="<?php  echo $recorder['id'];?>">
        <label class="layui-form-label">资料名</label>
        <div class="layui-input-block">
            <input type="text" name="in[name]" value="<?php  echo $recorder['name'];?>" required="" style="width: 400px;" lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block">
            <textarea name="in[desc]" placeholder="请输入内容" class="layui-textarea" style="width: 400px;"><?php  echo $recorder['desc'];?></textarea>
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
    layui.use(['form','jquery'], function(){
        var form = layui.form();
        var $ = layui.jquery;
        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl($_GPC['do'],array('tb'=>'zlk'))?>&Ajax=",data.field,function(response){
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