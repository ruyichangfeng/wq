<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" style="width:560px;margin-top: 50px;float: left">
    <input type="hidden" name="member_id" id="member_id"  <?php  if($memberInfo['id']) { ?> value="<?php  echo $memberInfo['id'];?>" <?php  } else { ?> value="0" <?php  } ?>>
    <div class="layui-form-item">
        <label class="layui-form-label">选择应用</label>
        <div class="layui-input-block">
            <input type="hidden" id="app_i" name="app_id" value="0">
            <input type="text" id="app" name="app_name" required=""  style="width: 295px;float: left;margin-right:5px;"  placeholder="选择应用" autocomplete="off" class="layui-input">
            <button  class="layui-btn layui-btn-danger select_app" style="width:100px;float: left" >选择</button>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">创建人</label>
        <div class="layui-input-block">
            <input type="text" id="name" name="name" required="" style="width: 145px;float: left;margin-right:5px;" lay-verify="required"  <?php  if($memberInfo['name']) { ?> value="<?php  echo $memberInfo['name'];?>" <?php  } ?> placeholder="姓名" autocomplete="off" class="layui-input">
            <input type="text" id="mobile" name="mobile" style="width: 145px;float: left;margin-right:5px;" required="" <?php  if($memberInfo['mobile']) { ?> value="<?php  echo $memberInfo['mobile'];?>" <?php  } ?> style="width: 400px" lay-verify="phone" placeholder="电话" autocomplete="off" class="layui-input">
            <button  class="layui-btn layui-btn-danger save" style="width:100px;float: left" >选择</button>
        </div>
    </div>
    <div class="add_fmo">
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    var $;
    var form;
    layui.use(['form','jquery'], function(){
        form = layui.form();
        $ = layui.jquery;

        $(".save").click(function(){
            var url = "<?php  echo $this->createWebUrl('list',array('tb'=>'member','mode'=>'select'))?>";
            var index = layui.layer.open({
                title : "选择会员",
                type : 2,
                area :["600px","90%"],
                content : url
            });
            return false;
        });

        $(".select_app").click(function(){
            var url = "<?php  echo $this->createWebUrl('list',array('tb'=>'app','mode'=>'select'))?>";
            var index = layui.layer.open({
                title : "选择应用",
                type : 2,
                area :["600px","90%"],
                content : url
            });
            return false;
        });

        form.on('submit(addAdmin)', function(data){
            var post=$("form").serialize();
            $.post("<?php  echo $this->createWebUrl('addPl')?>&Ajax=",{post:post},function(response){
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

    function pluginSelectMember(id,name,mobile){
        $("#member_id").val(id);
        $("#name").val(name);
        $("#mobile").val(mobile);
    }

    function pluginSelectApp(id,name){
        $("#app").val(name);
        $("#app_i").val(id);
        //获取需要填写的表单
        $.post("<?php  echo $this->createWebUrl('getFmo')?>",{app_id:id},function(response){
            if(response !=""){
                $(".add_fmo").html(response);
                form.render();
            }
        });
    }

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
