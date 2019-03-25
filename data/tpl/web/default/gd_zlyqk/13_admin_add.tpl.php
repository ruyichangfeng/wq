<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item">
        <input type="hidden" name="id" value="<?php  echo $recorder['id'];?>">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-block">
            <input type="text" name="in[name]" value="<?php  echo $recorder['name'];?>" required="" style="width: 400px;" lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-block">
            <input type="text" name="in[mobile]" required="" value="<?php  echo $recorder['mobile'];?>" style="width: 400px;" lay-verify="phone" placeholder="请输入电话,作为登录帐号" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" name="in[password]" required="" value="<?php  echo $recorder['password'];?>" style="width: 400px;" lay-verify="require" placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">部门</label>
        <div class="layui-input-block" style="width: 400px;">
            <select name="in[department]">
                <option value="0">选择部门</option>
                <?php  if(is_array($departments)) { foreach($departments as $department) { ?>
                <option value="<?php  echo $department['id'];?>" <?php  if($department['id']==$recorder['department']) { ?>selected<?php  } ?>><?php  echo $department['name'];?></option>
                <?php  } } ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item" >
        <label class="layui-form-label">职位</label>
        <div class="layui-input-block">
            <input type="radio" name="in[organize]" title="员工" value="1" <?php  if($recorder['organize']==1 || empty($recorder['organize'])) { ?> checked <?php  } ?>>
            <input type="radio" name="in[organize]" title="管理" value="2" <?php  if($recorder['organize']==2) { ?> checked <?php  } ?>>
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
            $.post("<?php  echo $this->createWebUrl($_GPC['do'],array('tb'=>'admin'))?>&Ajax=",data.field,function(response){
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
