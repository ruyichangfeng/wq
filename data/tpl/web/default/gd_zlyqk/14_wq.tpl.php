<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item" style="margin-left: 40px;">
        手动在微擎添加登陆账号，该账号只拥有操作智慧应用模块的权限,并绑定为公众号的使用者身份。
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">绑定账号</label>
        <div class="layui-input-block" style="width: 400px;">
            <select name="val">
                <option value="0">选择账号</option>
                <?php  if(is_array($adminList)) { foreach($adminList as $admin) { ?>
                <option value="<?php  echo $admin['uid'];?>" <?php  if($accout['val']==$admin['uid']) { ?>selected<?php  } ?>><?php  echo $admin['username'];?></option>
                <?php  } } ?>
            </select>
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
            $.post("<?php  echo $this->createWebUrl('wqbd')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                       location.reload();
                    },1000);
                }
            },"json");
            return false;
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
