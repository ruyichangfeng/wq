<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
    <link href="<?php echo MODULE_URL;?>/static/admin/tbs/styles/smart_wizard_vertical.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/tbs/js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="<?php echo MODULE_URL;?>/static/admin/tbs/js/jquery.smartWizard-2.0.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#wizard').smartWizard({
                transitionEffect:'slide',
                selected:<?php  echo $sep;?>
            });
        });
    </script>
    <style>
        .adm_ln{line-height: 35px;margin-right:30px;}
    </style>
<style type="text/css">
    #topmenu{width:980px;margin:40px auto 0 auto;height:60px;position:relative;}
    #topmenu ul{margin:0;padding:0;}
    #topmenu ul li{float:left;font-size:12px;list-style:none;background:#222;position:relative;text-align:center;text-transform:uppercase;width:70px;margin:0 10px;display:inline;	line-height:30px;}
    #topmenu ul li a{color:#aaa;text-decoration:none;}
    #topmenu ul li a:hover{color:#fff;}
    #topmenu ul li.active a{color:#fff;font-weight:800;}
    .stepContainer{height:550px;}
    .content{height: 550px !important;}
    .swMain .stepContainer div.content{border: 0;background: #FFFFFF}
    .layui-elem-quote{padding: 0;padding-left:20px;}
    .layui-this{color :white !important;}
    .layui-tab-item{margin-top:30px;}
</style>
<form  class="layui-form">
    <blockquote class="layui-elem-quote ">
        <?php  if($_GPC['tp']!='des' ) { ?>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="hidden" id="id" value="<?php  echo $flowInfo['id'];?>">
                <input type="text" value="<?php  echo $flowInfo['name'];?>" id="name" placeholder="流程名称" class="layui-input ">
            </div>
            <a class="layui-btn add_flow" lay-submit lay-filter="search">保存</a>
        </div>
        <?php  } else { ?>
        <div class="layui-inline" style="margin-right:30px;">
            <h3><?php  echo $flowInfo['name'];?></h3>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal add_node" data-id="<?php  echo $flowInfo['id'];?>">节点添加</a>
        </div>
        <?php  } ?>
    </blockquote>
</form>
<div id="wizard" class="swMain" style="margin-top:10px; display:<?php  if($_GPC['tp']!='des') { ?>none<?php  } else { ?>bock<?php  } ?> ">
    <ul style="padding-bottom: 10px;">
        <?php  if(is_array($nodeList)) { foreach($nodeList as $key => $node) { ?>
        <li>
            <a href="#step-<?php  echo $node['sort'];?>" class="node_list" data-key="<?php  echo $key;?>" data-id="<?php  echo $node['id'];?>">
                <span class="stepNumber"><?php  echo $node['sort'];?></span>
                <span class="stepDesc">
                    <?php  echo $node['name'];?><br />
                    <small>
                        <i class="layui-icon node_edit" data-id="<?php  echo $node['id'];?>" data-fid="<?php  echo $node['flow_id'];?>" style="cursor:pointer"></i>
                        <i class="layui-icon node_del" data-id="<?php  echo $node['id'];?>" data-fid="<?php  echo $node['flow_id'];?>" style="margin-left:10px;cursor:pointer"></i>
                    </small>
                </span>
            </a>
        </li>
        <?php  } } ?>
    </ul>

    <?php  if(is_array($nodeList)) { foreach($nodeList as $key => $node) { ?>
    <div id="step-<?php  echo $node['sort'];?>" >
        <?php  if($key==$sep) { ?>
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">谁处理</li>
                <li>处理结果</li>
                <li class="infms">反馈信息</li>
            </ul>
            <div class="layui-tab-content" >
                <div class="layui-tab-item layui-show">
                    <form class="layui-form" action="">
                    <input type="hidden" name="id" value="<?php  echo $nodeId;?>">
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="text-align: left">操作人</label>
                        <div class="layui-input-block">
                            <input type="radio" lay-filter="role" name="role" value="1" <?php  if($nodeInfo['who']==1) { ?> checked <?php  } ?> title="员工" >
                            <input type="radio" lay-filter="role" name="role" value="2" <?php  if($nodeInfo['who']==2) { ?> checked <?php  } ?> title="客户" >
                        </div>
                    </div>
                    <div class="layui-form-item role_hd" <?php  if($nodeInfo['who']==2) { ?> style="display:none" <?php  } ?>>
                        <label class="layui-form-label" style="text-align: left">部门列表</label>
                        <div class="layui-input-block ">
                            <span class="admin_list">
                            <?php  if($nodeInfo['who']==2) { ?>
                            <a href="javascript:" class="adm_ln">无</a>
                            <?php  } else { ?>
                                <?php  if(is_array($dpList)) { foreach($dpList as $index => $fl) { ?>
                                    <a href="javascript:" class="adm_ln"><input type="hidden" name="admin[<?php  echo $index;?>]" value="<?php  echo $fl['id'];?>"><?php  echo $fl['name'];?> </a>
                                <?php  } } ?>
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
                <div class="layui-tab-item">
                    <form class="layui-form" action="">
                        <input type="hidden" name="id" value="<?php  echo $nodeId;?>">
                        <input type="hidden" name="flow" value="<?php  echo $flowInfo['id'];?>">
                        <?php  if(is_array($statusList)) { foreach($statusList as $key => $status) { ?>
                        <?php  if(isset($statusArr[$key])) { ?>
                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <input type="text" name="status[<?php  echo $key;?>]" value="<?php  echo $statusArr[$key]['status'];?>" required="" placeholder="处理状态" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-input-inline">
                                <select name="doe[<?php  echo $key;?>]" >
                                    <option value="2" <?php  if($statusArr[$key]['do']==2) { ?>selected<?php  } ?>>继续</option>
                                    <option value="1" <?php  if($statusArr[$key]['do']==1) { ?>selected<?php  } ?>>完成</option>
                                    <option value="0" <?php  if($statusArr[$key]['do']==0) { ?>selected<?php  } ?>>停止</option>
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="next[<?php  echo $key;?>]">
                                    <option value="0">下一节点</option>
                                    <?php  if(is_array($nodeList)) { foreach($nodeList as $node) { ?>
                                    <option value="<?php  echo $node['id'];?>" <?php  if($statusArr[$key]['next']==$node['id']) { ?>selected<?php  } ?>><?php  echo $node['name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <?php  } else { ?>
                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <input type="text" name="status[<?php  echo $key;?>]" required="" placeholder="处理状态" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-input-inline">
                                <select name="doe[<?php  echo $key;?>]" >
                                    <option value="1">继续</option>
                                    <option value="0">停止</option>
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="next[<?php  echo $key;?>]">
                                    <option value="">下一节点</option>
                                    <?php  if(is_array($nodeList)) { foreach($nodeList as $node) { ?>
                                    <option value="<?php  echo $node['id'];?>"><?php  echo $node['name'];?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <?php  } ?>
                        <?php  } } ?>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit="" lay-filter="status_list">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php  } ?>
    </div>
    <?php  } } ?>
</div>
<script>
    var ly;
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
            $.post("<?php  echo $this->createWebUrl('addRole')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
            },"json");
            return false;
        });

        form.on('submit(status_list)', function(data){
            $.post("<?php  echo $this->createWebUrl('status')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
            },"json");
            return false;
        });

        form.on('submit(form_list)', function(data){
            $.post("<?php  echo $this->createWebUrl('addFrom')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
            },"json");
            return false;
        });

        form.on('submit(msg)', function(data){
            $.post("<?php  echo $this->createWebUrl('addMsg')?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
            },"json");
            return false;
        });

        //选取员工
        $(".add_dp").click(function(){
            ly = layui.layer.open({
                type:2,
                title:false,
                content:"<?php  echo $this->createWebUrl('selectDp')?>&id=<?php  echo $nodeId;?>",
                area:["300px","70%"]
            });
        });

        $(".add_flow").click(function () {
            var post = new Object();
            post.name = $("#name").val();
            if(post.name==""){
                $("#name").focus();
                layer.msg("填写流程名称");
                return false;
            }
            post.id=$("#id").val();
            $.post("<?php  echo $this->createWebUrl('addFlow')?>",post,function(response){
                layer.msg(response.msg);
                setTimeout(function(){
                    if(response.code==1){
                        setTimeout(function(){
                            parent.location.reload();
                        },1000);
                    }
                },1000);
            },"json");
        });

        //添加子节点
        $(".add_node").click(function(){
            var second = layer.open({
                type: 2,
                title:"节点管理",
                content:"<?php  echo $this->createWebUrl('add',array('tb'=>'node'))?>&fid=<?php  echo $flowInfo['id'];?>",
                area: ['60%', '80%']
            });
        });

        //标记操作
        $(".node_edit").on("click",function(){
            var id = $(this).attr("data-id");
            var fid =$(this).attr("data-fid");
            var url = "<?php  echo $this->createWebUrl('edit',array('tb'=>'node'))?>&fid="+fid+"&id="+id;
            var index = layer.open({
                title : "编辑流程",
                type : 2,
                content : url,
                area: ['60%', '80%']
            });
            return false;
        });

        //删除节点
        $(".node_del").click(function(){
            var id =$(this).attr("data-id");
            $.post("<?php  echo $this->createWebUrl('delete')?>&tb=node&id="+id,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        location.reload();
                    },1200);
                }
            },'json');
            layer.msg("删除成功");
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

        //切换菜单节点
        $(".node_list").click(function(){
            var id=$(this).attr("data-id");
            var node = $(this).attr("data-key");
            location.href="<?php  echo $this->createWebUrl('editFlow')?>&id=<?php  echo $flowInfo['id'];?>&node="+id+"&sep="+node+"&tp=des";
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
