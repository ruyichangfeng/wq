<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
</style>
<form  class="layui-form">
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['sn'];?>" id="sn" placeholder="序列号" class="layui-input search_input">
        </div>
        <div class="layui-input-inline" style="width: 150px;">
            <select name="in[label]" id="label">
                <option value="0">选择标签</option>
                <?php  if(is_array($labels)) { foreach($labels as $label) { ?>
                <option value="<?php  echo $label['id'];?>" <?php  if($_GPC['label']==$label['id']) { ?> selected <?php  } ?>><?php  echo $label['name'];?></option>
                <?php  } } ?>
            </select>
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <select name="in[status]" id="status">
                <option value="-1" <?php  if($_GPC['status']==-1) { ?> selected <?php  } ?>>选择状态</option>
                <option value="0" <?php  if($_GPC['status']==0) { ?> selected <?php  } ?>>待发放</option>
                <option value="1" <?php  if($_GPC['status']==1) { ?> selected <?php  } ?>>已发放</option>
            </select>
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
    </div>
    <!--<div class="layui-inline">-->
        <!--<a class="layui-btn layui-btn-normal newsAdd_btn" data-url="<?php  echo $this->createWebUrl('Add',array('tb'=>'code'))?>">创建</a>-->
    <!--</div>-->
    <div class="layui-inline">
        <a class="layui-btn layui-btn-normal import" data-url="<?php  echo $this->createWebUrl('import')?>">导入</a>
    </div>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-danger batchDel">删除</a>
    </div>
    <div class="layui-inline" style="float: right">
        <a class="layui-btn label_set" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'code_label'))?>">标签管理</a>
    </div>
</blockquote>
</form>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col width="10%">
            <col width="10%">
            <col width="5%">
            <col width="11%">
            <col width="11%">
            <col width="15%">
            <col >
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>序列码</th>
            <th>标签</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>接收人</th>
            <th>发放时间</th>
            <th style="text-align: left">操作</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $admin) { ?>
        <tr>
            <td style="text-align: center !important;">
                <input type="checkbox" name="checked" value="<?php  echo $admin['id'];?>" lay-skin="primary" lay-filter="choose">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon"></i>
                </div>
            </td>
            <td align="left"><?php  echo $admin['sn'];?></td>
            <td align="left"><?php  echo $admin['label'];?></td>
            <td>
                <?php  if($admin['status']==1) { ?>已发放<?php  } else { ?>未发放<?php  } ?>
            </td>
            <td><?php  echo date("Y-m-d",$admin['create_time'])?></td>
            <td align="left"><?php  echo $admin['member_name'];?></td>
            <td><?php  if($admin['use_time']>0) { ?> <?php  echo date("Y-m-d H:i:s",$admin['use_time'])?> <?php  } ?></td>
            <td style="text-align: left">
                <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $admin['id'];?>">
                    <i class="layui-icon"></i> 删除
                </a>
            </td>
        </tr>
        <?php  } } ?>
        </tbody>
    </table>
</div>
<div id="page"></div>
<script>
    layui.use(['form','jquery','laypage'], function(){

        var sn,label,status;
        var setting =new Object();

        var $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            sn=$("#sn").val();
            label=$("#label").val();
            status=$("#status").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'code'))?>"+"&sn="+sn+"&label="+label+"&status="+status;
            location.href=url;
            return false;
        });

        //分页
        setting.cont="page";
        setting.pages="<?php  echo $totalPage;?>";
        setting.curr="<?php  echo $page;?>";
        setting.skip=true;
        setting.hash="page";
        setting.jump=function(obj, first){
            sn=$("#sn").val();
            label=$("#label").val();
            status=$("#status").val();
            if(first!=true){
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'code'))?>"+"&sn="+sn+"&label="+label+"&status="+status+"&page="+obj.curr;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        //删除操作
        $(".news_del").on("click",function(){
            var _this = $(this);
            layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
                var id =_this.attr("data-id");
                $.post("<?php  echo $this->createWebUrl('delete')?>&tb=code&id="+id,function(response){
                    layer.msg(response.msg,{icon: response.code});
                    if(response.code==1){
                       _this.parents("tr").remove();
                    }
                },'json');
            });
        });

        //标记操作
        $(".news_edit").on("click",function(){
            var id = $(this).attr("data-id");
            var url = "<?php  echo $this->createWebUrl('Edit',array('tb'=>'code'))?>&id="+id;
            var index = layui.layer.open({
                title : "编辑资料",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回员工列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
                    },500)
                }
            });
            layui.layer.full(index);
        });

        $(".newsAdd_btn").click(function(){
            var url = $(this).attr("data-url");
            var index = layui.layer.open({
                title : "添加资料",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回员工列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
        });

        $(".label_set").click(function(){
            var url = $(this).attr("data-url");
            var index = layui.layer.open({
                title : "标签管理",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
        });

        $(".import").click(function(){
            var url = $(this).attr("data-url");
            var index = layui.layer.open({
                title : "导入",
                type : 2,
                area : ['450px','300px'],
                content : url,
            });
        });

        $(".tb_des").click(function(){
            var id = $(this).attr("data-id");
            var url = "<?php  echo $this->createWebUrl('destb')?>&id="+id;
            var index = layui.layer.open({
                title : "设计表",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回资料库', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
        });

        //批量删除
        $(".batchDel").click(function(){
            var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]:checked');
            if($checkbox.is(":checked")){
                layer.confirm('确定删除选中的信息？',{icon:3, title:'提示信息'},function(index){
                    var id="";
                    $checkbox.each(function(){
                        id += (id=="") ? $(this).val() :","+$(this).val();
                    });
                    $.post("<?php  echo $this->createWebUrl('delete')?>&tb=code&id="+id,function(response){
                        layer.msg(response.msg,{icon: response.code});
                        if(response.code==1){
                            setTimeout(function(){
                                location.reload();
                            },1200);
                        }
                    },'json');
                    layer.msg("删除成功");
                })
            }else{
                layer.msg("请选择需要删除的文章");
            }
        });

        //全选
        form.on('checkbox(allChoose)', function(data){
            var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>