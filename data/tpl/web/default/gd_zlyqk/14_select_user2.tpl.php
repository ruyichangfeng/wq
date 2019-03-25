<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .adm_ln{line-height: 35px;margin-right:30px;}
</style>
<div id="wizard" class="swMain">
    <div id="step-<?php  echo $node['sort'];?>" >
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <div class="layui-tab-content" >
                <div class="layui-tab-item layui-show">
                    <form class="layui-form" action="">
                    <input type="hidden" name="id" value="<?php  echo $nodeId;?>">
                    <input type="hidden" name="flow_id" value="<?php  echo $flowId;?>">
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="text-align: left">操作人</label>
                        <div class="layui-input-block">
                            <input type="radio" lay-filter="role" name="role" value="1"  <?php  if($nodeInfo['who']==1) { ?> checked <?php  } ?> title="员工" >
                            <input type="radio" lay-filter="role" name="role" value="2" <?php  if($nodeInfo['who']==2) { ?> checked <?php  } ?> title="客户" >
                            <input type="radio" lay-filter="role" name="role" value="3" <?php  if($nodeInfo['who']==3) { ?> checked <?php  } ?> title="上次处理员工" >
                        </div>
                    </div>
                    <div class="layui-form-item role_hd" <?php  if($nodeInfo['who']==2) { ?> style="display:none" <?php  } ?>>
                        <label class="layui-form-label" style="text-align: left">部门列表</label>
                        <div class="layui-input-block ">
                            <span class="admin_list">
                            <?php  if($nodeInfo['who']==2) { ?>
                            <a href="javascript:" class="adm_ln">无</a>
                            <?php  } else { ?>
                                <?php  if($dpSelect) { ?>
                                <?php  if(is_array($dpSelect)) { foreach($dpSelect as $index => $fl) { ?>
                                    <a href="javascript:" class="adm_ln"><input type="hidden" name="admin[]" value="<?php  echo $fl;?>"><?php  echo $dpList[$fl];?> </a>
                                <?php  } } ?>
                                <?php  } else { ?>
                                    <a href="javascript:" class="adm_ln">无</a>
                                <?php  } ?>
                            <?php  } ?>
                            </span>
                            <a class="layui-btn layui-btn-primary layui-btn-small add_dp">
                                <i class="layui-icon">&#xe654;</i>
                            </a>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="add_role">保存</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo MODULE_URL;?>/static/mobile/js/jquery.min.js"></script>
<script>
    var ly;
    var node_id="<?php  echo $nodeId;?>";
    layui.use(['form','layer','element'], function(){
        var form = layui.form();
        var layer = layui.layer;
        var $ = layui.jquery;

        //角色选择项目
        form.on('radio(role)', function(data){
           if(data.value==1){
                $(".role_hd").css("display","block");
           }else{
               $(".role_hd").css("display","none");
               $(".admin_list").html("<a href='javascript:' class='adm_ln'>无</a>");
           }
        });

        form.on('submit(add_role)', function(data){
            $.post("<?php  echo $this->createWebUrl('addPreRole')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    var role=$("input[name='role']:checked").val();
                    parent.addWho(node_id,response.data,role);
                    setTimeout(function(){
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    },1000);
                }
            },"json");
            return false;
        });

        //选取员工
        $(".add_dp").click(function(){
            ly =layui.layer.open({
                type: 2,
                area: ["90%","90%"],
                shade: 0.8,
                shadeClose: true,
                content: '<?php  echo $this->createWebUrl("selectDp2")?>&id=<?php  echo $nodeId;?>&flow_id=<?php  echo $flowId;?>'
            });
        });

        $(".infms").click(function(){
            var id="<?php  echo $nodeId;?>";
            var index = layui.layer.open({
                title : "反馈信息",
                type : 2,
                content : "<?php  echo $this->createWebUrl('desFm')?>&id="+id,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回流程设计', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
            return false;
        });

        $("body").on("click",".adm_ln",function(){
            $(this).remove();
        });
    });

    function setAdmin(str){
        $(".admin_list").html(str);
        layui.layer.close(ly);
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
