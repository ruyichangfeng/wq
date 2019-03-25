<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
</style>
<form  class="layui-form">
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['name'];?>" id="name" placeholder="应用名搜索" class="layui-input search_input">
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
    </div>
    <?php  if($barMenu['add']) { ?>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-normal newsAdd_btn" data-url="<?php  echo $this->createWebUrl('Add',array('tb'=>'app','fresh'=>$_GPC['fresh']))?>">添加</a>
    </div>
    <?php  } ?>
    <?php  if($barMenu['delete']) { ?>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-danger batchDel">删除</a>
    </div>
    <?php  } ?>
</blockquote>
</form>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="50">
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="6%">
            <col width="5%">
            <col width="5%">
            <col width="10%">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>名称</th>
            <th>流程</th>
            <th>分类</th>
            <th>排序</th>
            <th>状态</th>
            <th>首页显示</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $key => $app) { ?>
        <tr>
            <td style="text-align: center !important;">
                <input type="checkbox" name="checked" value="<?php  echo $app['id'];?>" lay-skin="primary" lay-filter="choose">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon"></i>
                </div>
            </td>
            <td align="left"><?php  echo $app['name'];?></td>
            <td align="left"><?php  echo $app['flow_name'];?></td>
            <td align="left"><?php  if($app['category']) { ?><?php  echo $app['category'];?><?php  } else { ?>未设置<?php  } ?></td>
            <td align="left"><?php  echo $app['sorter'];?></td>
            <td>
                <input type="checkbox" <?php  if($app['status']==1) { ?>checked<?php  } ?> name="show" disabled lay-skin="switch" lay-text="正常|禁用" lay-filter="isShow">
                <div class="layui-unselect layui-form-switch" lay-skin="_switch">
                    <em>禁用</em>
                    <i></i>
                </div>
            </td>
            <td>
                <?php  if($app['is_show']==0) { ?>
                <i class="layui-icon">ဆ</i>
                <?php  } else { ?>
                <i class="layui-icon"></i>
                <?php  } ?>
            </td>
            <td><?php  echo date("Y-m-d",$app['create_time'])?></td>
            <td>
                <a class="layui-btn .layui-btn-blue  layui-btn-mini rukou" data-id="<?php  echo $app['id'];?>" data-url="<?php  echo $app['url_index'];?>" href="javascript:">
                    <i class="layui-icon">&#xe60c;</i> 入口
                </a>
                <?php  if($barMenu['desi']) { ?>
                <a class="layui-btn layui-btn-mini add_form" data-id="<?php  echo $app['id'];?>" data-do="<?php  if($app['table']) { ?>edit<?php  } else { ?>add<?php  } ?>">
                    <i class="iconfont icon-edit"></i> 设计表单
                </a>
                <?php  } ?>
                <?php  if($barMenu['edit']) { ?>
                <a class="layui-btn layui-btn-mini news_edit" data-id="<?php  echo $app['id'];?>">
                    <i class="iconfont icon-edit"></i> 编辑
                </a>
                <a class="layui-btn layui-btn-danger layui-btn-mini share_act" data-url="<?php  echo $this->createWebUrl('shareSet')?>&app=<?php  echo $app['id'];?>">
                    <i class="layui-icon"></i>分享设置
                </a>
                <a class="layui-btn layui-btn-danger layui-btn-mini them" data-url="<?php  echo $this->createWebUrl('them')?>&app=<?php  echo $app['id'];?>">
                    定义主题
                </a>
                <?php  } ?>
                <?php  if($barMenu['delete']) { ?>
                <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $app['id'];?>">
                    <i class="layui-icon"></i> 删除
                </a>
                <?php  } ?>
                <?php  if($barMenu['recorder']) { ?>
                <!--<a class="layui-btn layui-btn-danger layui-btn-mini recorder_list" data-url="<?php  echo $this->createWebUrl('listRecorder')?>&app=<?php  echo $app['id'];?>">-->
                    <!--<i class="layui-icon"></i>数据记录-->
                <!--</a>-->
                <?php  } ?>
                <?php  if($barMenu['share']) { ?>
                <!--<a class="layui-btn layui-btn-mini share" data-id="<?php  echo $app['id'];?>" data-do="<?php  if($app['table']) { ?>edit<?php  } else { ?>add<?php  } ?>">-->
                    <!--<i class="iconfont icon-edit"></i> 上传市场-->
                <!--</a>-->
                <?php  } ?>
            </td>
        </tr>
        <?php  } } ?>
        </tbody>
    </table>
</div>
<div id="page"></div>
<script>
    layui.use(['form','jquery','laypage'], function(){

        var name,mobile;
        var setting =new Object();

        var $ = layui.jquery;
        var form = layui.form();

        $(".share_act").click(function(){
            var url =$(this).attr("data-url");
            var title="分享";
            var index = layui.layer.open({
                title : false,
                area:["600px","500px"],
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回应用列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
        });

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'app'))?>"+"&mobile="+mobile+"&name="+name;
            location.href=url;
            return false;
        });

        //主题
        $(".them").on("click",function(){
            var url=$(this).attr("data-url");
            var index = layui.layer.open({
                title : "主题",
                area:["800px","700px"],
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回应用列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
        });

        //二维码
        $(".rukou").on("click",function(){
            var id=$(this).attr("data-id");
            var url=$(this).attr("data-url");
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                area: ['370px', '360px'],
                shadeClose: true,
                content: '<img style="width: 300px;display: block;margin: 0 auto" src="<?php  echo $this->createWebUrl('appQr')?>&app_id='+id+'"><h4 style="text-align: center;width: 100%">'+url+'</h4>'
            });
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
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'app'))?>"+"&mobile="+mobile+"&name="+name+"&page="+obj.curr;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        //删除操作
        $(".news_del").on("click",function(){
            var _this = $(this);
            layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
                var id =_this.attr("data-id");
                $.post("<?php  echo $this->createWebUrl('delete')?>&tb=app&id="+id,function(response){
                    layer.msg(response.msg,{icon: response.code});
                    if(response.code==1){
                       _this.parents("tr").remove();
                    }
                },'json');
            });
        });

        $(".add_form").click(function(){
            var id =$(this).attr("data-id");
            var does =$(this).attr('data-do');
            var url;

            if(does=='add'){
                var title="设计表单";
                url = "<?php  echo $this->createWebUrl('addForm')?>&de=add&id="+id;
            }else{
                var title="编辑表单";
                url = "<?php  echo $this->createWebUrl('editForm')?>&de=edit&id="+id;
            }
            // var index = layui.layer.open({
            //     title : title,
            //     type : 2,
            //     content : url,
            //     area:['950px', '98%'],
            //     success : function(layero, index){
            //         setTimeout(function(){
            //             layui.layer.tips('点击此处返回应用列表', '.layui-layer-setwin .layui-layer-close', {
            //                 tips: 3
            //             });
            //         },500)
            //     }
            // });
            window.open(url);
        });

        //分享到市场
        $(".share").click(function(){
            var id =$(this).attr("data-id");
            var does =$(this).attr('data-do');
            var title="分享";
            var url = "<?php  echo $this->createWebUrl('share')?>&type=app&id="+id;
            var index = layui.layer.open({
                title : false,
                area:["600px","500px"],
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回应用列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
        });

        //标记操作
        $(".news_edit").on("click",function(){
            var id = $(this).attr("data-id");
            var url = "<?php  echo $this->createWebUrl('Edit',array('tb'=>'app'))?>&id="+id;
            var index = layui.layer.open({
                title : "编辑应用",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回应用列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
                    },500)
                }
            });
            layui.layer.full(index);
        });

        //二维码
        $(".news_qr").on("click",function(){
            var id=$(this).attr("data-id");
            layer.open({
                type: 2,
                title: false,
                area: ['370px', '370px'],
                shade: 0.8,
                closeBtn: 0,
                shadeClose: true,
                content: '<?php  echo $this->createWebUrl("qr")?>&id='+id
            });
        });

        $(".newsAdd_btn").click(function(){
            var url = $(this).attr("data-url");
            var index = layui.layer.open({
                title : "添加应用",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回应用列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
            layui.layer.full(index);
        });

        $(".recorder_list").click(function(){
            var url = $(this).attr("data-url");
            var index = layui.layer.open({
                title : "数据记录",
                type : 2,
                content : url
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
                    $.post("<?php  echo $this->createWebUrl('delete')?>&tb=app&id="+id,function(response){
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