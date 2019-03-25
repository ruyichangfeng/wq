<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
</style>
<form  class="layui-form">
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['name'];?>" id="name" placeholder="姓名" class="layui-input search_input">
        </div>
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['mobile'];?>" id="mobile" placeholder="电话" class="layui-input search_input">
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
    </div>
    <?php  if($barMenu['delete']) { ?>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-danger batchDel">删除</a>
    </div>
    <?php  } ?>
    <div class="layui-inline" style="float: right;margin-right:20px;">
        <a class="layui-btn layui-btn-normal newsAdd_btn" data-url="<?php  echo $this->createWebUrl('list',array('tb'=>'staffcol'))?>">扩展字段</a>
    </div>
</blockquote>
</form>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col width="120px">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="9%">
            <col width=12%">
            <col >
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>姓名</th>
            <th>电话</th>
            <th>微信名</th>
            <th>扩展信息</th>
            <th>是否通过</th>
            <th>注册时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $member) { ?>
        <tr>
            <td style="text-align: center !important;">
                <input type="checkbox" name="checked" value="<?php  echo $member['id'];?>" lay-skin="primary" lay-filter="choose">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon"></i>
                </div>
            </td>
            <td align="left"><?php  echo $member['name'];?></td>
            <td align="left"><?php  echo $member['mobile'];?></td>
            <td align="left"><?php  echo $member['member_name'];?></td>
            <td align="left"><a data-id="<?php  echo $member['id'];?>" class="layui-btn layui-btn-danger layui-btn-mini view_d" href="javascript:">查看</a></td>
            <td><?php  if($member['pass']==1) { ?>通过<?php  } else { ?>未通过<?php  } ?></td>
            <td><?php  echo date("Y-m-d H:i:s",$member['create_time'])?></td>
            <td>
                <?php  if($member['pass']==0) { ?>
                <a class="layui-btn layui-btn-mini news_edit" data-id="<?php  echo $member['id'];?>">
                    <i class="iconfont icon-edit"></i>审核通过
                </a>
                <?php  } ?>
                <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $member['id'];?>">
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

        var name,mobile,label;
        var setting =new Object();

        var $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'staffext'))?>"+"&mobile="+mobile+"&name="+name;
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
            name=$("#name").val();
            mobile=$("#mobile").val();
            if(first!=true){
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'staffext'))?>"+"&mobile="+mobile+"&name="+name+"&page="+obj.curr;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        //删除操作
        $(".news_del").on("click",function(){
            var _this = $(this);
            layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
                var id =_this.attr("data-id");
                $.post("<?php  echo $this->createWebUrl('delete')?>&tb=staffext&id="+id,function(response){
                    layer.msg(response.msg,{icon: response.code});
                    if(response.code==1){
                       _this.parents("tr").remove();
                    }
                },'json');
            });
        });

        $(".news_edit").click(function(){
            var _this = $(this);
            var id =_this.attr("data-id");
            var url = "<?php  echo $this->createWebUrl('edit')?>&tb=staffext&id="+id;
            var index = layui.layer.open({
                title : "申请",
                type : 2,
                content : url,
                area:["600px","500px;"],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回申请列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
        });

        $(".view_d").click(function(){
            var _this = $(this);
            var id =_this.attr("data-id");
            var url = "<?php  echo $this->createWebUrl('viewDtl')?>&id="+id;
            var index = layui.layer.open({
                title : "注册扩展信息",
                type : 2,
                content : url,
                area:["600px","500px;"],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回申请列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
        });

        $(".newsAdd_btn").click(function(){
            var url = $(this).attr('data-url');
            var index = layui.layer.open({
                title : "扩展字段",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回申请列表', '.layui-layer-setwin .layui-layer-close', {
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
                    $.post("<?php  echo $this->createWebUrl('delete')?>&tb=staffext&id="+id,function(response){
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