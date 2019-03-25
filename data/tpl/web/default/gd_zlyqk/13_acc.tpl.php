<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <input type="hidden" name="group_id" value="<?php  echo $_GPC['id'];?>">
    <div class="layui-form-item">
        <?php  if(is_array($accList)) { foreach($accList as $key => $acc) { ?>
        <div class="layui-input-block" style="margin-left: 20px;">
            <input type="checkbox" class="<?php  echo $key;?>" class-id="<?php  echo $key;?>" lay-filter="top" name="in[<?php  echo $key;?>]" title="<?php  echo $acc['name'];?>"  <?php  if($accLs[$key]) { ?> checked <?php  } ?>>
        </div>
        <?php  if(is_array($acc)) { foreach($acc as $ky => $vl) { ?>
            <?php  if($ky!='name') { ?>
                <div class="layui-input-block" style="margin-left: 50px;">
                    <input type="checkbox" class="<?php  echo $key;?> <?php  echo $ky;?> second" class-id="<?php  echo $ky;?>" lay-filter="second"  name="in[<?php  echo $ky;?>]" title="<?php  echo $vl['name'];?>" <?php  if($accLs[$ky]) { ?> checked <?php  } ?>>
                    <?php  if(is_array($vl)) { foreach($vl as $k => $v) { ?>
                    <?php  if($k!='name') { ?>
                    <input type="checkbox" name="in[<?php  echo $ky;?>-<?php  echo $k;?>]" class="<?php  echo $key;?> <?php  echo $ky;?> <?php  echo $ky;?>-<?php  echo $k;?>" title="<?php  echo $v;?>" lay-skin="primary" <?php  if($accLs[$ky."-".$k]) { ?> checked<?php  } ?>>
                    <?php  } ?>
                    <?php  } } ?>
                </div>
            <?php  } ?>
        <?php  } } ?>
        <?php  } } ?>
        <div class="layui-input-block" style="margin-top: 30px;">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
        </div>
    </div>
</form>
<script>
    layui.use(['form','jquery'], function(){
        var form = layui.form();
        var $ = layui.jquery;
        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl('acc')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        parent.location.reload();
                    },1000);
                }
            },"json");
            return false;
        });
        //监听一级元素
        form.on('checkbox(top)', function(data){
            var classId = $(this).attr("class-id");
            if(data.elem.checked){
                $("."+classId).attr("checked","");
            }else{
                $("."+classId).removeAttr("checked");
            }
            form.render();
        });
        //监听一级元素
        form.on('checkbox(second)', function(data){
            var classId = $(this).attr("class-id");
            if(data.elem.checked){
                $("."+classId).attr("checked","");
            }else{
                $("."+classId).removeAttr("checked");
            }
            form.render();
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
