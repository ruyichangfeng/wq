<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item">
        <label class="layui-form-label">操作</label>
        <div class="layui-input-block">
            <?php  if(is_array($nodeStatus)) { foreach($nodeStatus as $node) { ?>
            <input type="radio" name="do_status" lay-filter="noss" value="<?php  echo $node['id'];?>" title="<?php  echo $node['name'];?>" <?php  if($lineId==$node['id']) { ?>checked<?php  } ?>>
            <?php  } } ?>
        </div>
    </div>
    <?php  echo $html;?>
    <input type="hidden" name="app_id" value="<?php  echo $_GPC['app'];?>">
    <input type="hidden" name="line_id" value="<?php  echo $_GPC['line_id'];?>">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
        </div>
    </div>
</form>
<script>
    layui.use(['form','jquery'], function(){
        var form = layui.form();
        var $ = layui.jquery;

        form.on('radio(noss)', function(data){
            var url="<?php  echo $this->createWebUrl('wDoing')?>&app=<?php  echo $appId;?>&id=<?php  echo $id;?>&line_id="+data.value;
            location.href=url;
        });

        form.on('submit(addAdmin)', function(data){
            if(!$("input[name='do_status']:checked").val()){
                layer.msg("请选择操作",{icon: 2});
                return false;
            }
            var post=$("form").serialize();
            $.post("<?php  echo $this->createWebUrl('doFm')?>&Ajax=",{data:post},function(response){
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
