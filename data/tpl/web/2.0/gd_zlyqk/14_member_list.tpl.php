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
        <div class="layui-input-inline" style="width: 200px;">
            <select id="label">
                <option value="0">选择组</option>
                <?php  if(is_array($label)) { foreach($label as $index => $lb) { ?>
                <option value="<?php  echo $index;?>" <?php  if($index==$_GPC['label']) { ?>selected<?php  } ?>><?php  echo $lb;?></option>
                <?php  } } ?>
            </select>
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
    </div>
    <?php  if($barMenu['add']) { ?>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-normal newsAdd_btn" data-url="<?php  echo $this->createWebUrl('Add',array('tb'=>'member'))?>">添加</a>
    </div>
    <?php  } ?>
    <?php  if($barMenu['delete']) { ?>
    <div class="layui-inline">
        <a class="layui-btn layui-btn-danger batchDel">删除</a>
    </div>
    <?php  } ?>
</blockquote>
</form>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table"  style="min-width: 1700px;">
        <colgroup>
            <col width="50">
            <col width="80px">
            <col width="100px">
            <col width="100px">
            <col width="100px">
            <col width="100px">
            <!--<col width="50px">-->
            <!--<col width="50px">-->
            <col width="50px">
            <col width="50px">
            <col width="92px">
            <col width="100px">
            <col width="300px">
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>头像</th>
            <th>姓名</th>
            <th>电话</th>
            <th>系统组</th>
            <th>会员组</th>
            <!--<th>积分</th>-->
            <!--<th>余额</th>-->
            <th>微信绑定</th>
            <th>员工</th>
            <th>状态</th>
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
            <?php  if($member['avatar']) { ?>
            <td align="left"><img src="<?php  echo $member['avatar'];?>" style="width: 40px;height:40px;border-radius: 20px;"> </td>
            <?php  } else { ?>
            <td align="left"><img src="<?php echo MODULE_URL;?>/static/mobile/images/avatar.jpeg" style="width: 40px;height:40px;border-radius: 20px;"> </td>
            <?php  } ?>
            <td align="left"><?php  if($member['name']) { ?> <?php  echo $member['name'];?><?php  } else { ?><?php  echo $member['nickname'];?><?php  } ?></td>
            <td align="left"><?php  echo $member['mobile'];?></td>
            <td align="left"><?php  echo $member['group_name'];?></td>
            <td align="left"><?php  echo $member['label'];?></td>
            <!--<td align="left"><?php  echo $member['jf'];?></td>-->
            <!--<td align="left"><?php  echo $member['ye'];?></td>-->
            <?php  if($member['uid']) { ?>
            <td align="left">
                <a class="layui-btn layui-btn-mini">
                    是
                </a>
            </td>
            <?php  } else { ?>
            <td align="left">
                <a class="layui-btn layui-btn-mini">
                    否
                </a>
            </td>
            <?php  } ?>
            <?php  if($member['admin_id']) { ?>
            <td align="left">
                <a class="layui-btn layui-btn-mini">
                    是
                </a>
            </td>
            <?php  } else { ?>
            <td align="left">
                <a class="layui-btn layui-btn-mini">
                   否
                </a>
            </td>
            <?php  } ?>
            <td>
                <input type="checkbox" <?php  if($member['status']==1) { ?>checked<?php  } ?> name="show" disabled lay-skin="switch" lay-text="正常|禁用" lay-filter="isShow">
                <div class="layui-unselect layui-form-switch" lay-skin="_switch">
                    <em>禁用</em>
                    <i></i>
                </div>
            </td>
            <td><?php  echo date("Y-m-d H:i:s",$member['create_time'])?></td>
            <td>
                <!--<a class="layui-btn layui-btn-mini jf" data-id="<?php  echo $member['id'];?>">-->
                    <!--<i class="iconfont icon-edit"></i> 积分调整-->
                <!--</a>-->
                <!--<a class="layui-btn layui-btn-mini ye" data-id="<?php  echo $member['id'];?>">-->
                    <!--<i class="iconfont icon-edit"></i> 余额调整-->
                <!--</a>-->
                <?php  if($barMenu['edit']) { ?>
                <a class="layui-btn layui-btn-mini ext_info" data-id="<?php  echo $member['id'];?>">
                    扩展信息
                </a>
                <a class="layui-btn layui-btn-mini news_edit" data-id="<?php  echo $member['id'];?>">
                    <i class="iconfont icon-edit"></i> 编辑
                </a>
                <?php  } ?>
                <?php  if($barMenu['delete']) { ?>
                <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $member['id'];?>">
                    <i class="layui-icon"></i> 删除
                </a>
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

        var name,mobile,label;
        var setting =new Object();

        var $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            label =$("#label").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'member'))?>"+"&mobile="+mobile+"&name="+name+"&label="+label;
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
            label =$("#label").val();
            if(first!=true){
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'member'))?>"+"&mobile="+mobile+"&name="+name+"&page="+obj.curr+"&label="+label;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        //标记操作
        $(".jf").on("click",function(){
            var url = "<?php  echo $this->createWebUrl('jf')?>";
            var index = layui.layer.open({
                title : false,
                type : 2,
                area : ["400px","300px"],
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回会员列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
                    },500)
                }
            });
        });

        //删除操作
        $(".news_del").on("click",function(){
            var _this = $(this);
            layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
                var id =_this.attr("data-id");
                $.post("<?php  echo $this->createWebUrl('delete')?>&tb=member&id="+id,function(response){
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
            var url = "<?php  echo $this->createWebUrl('Edit',array('tb'=>'member'))?>&id="+id;
            var index = layui.layer.open({
                title : "编辑会员",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回会员列表', '.layui-layer-setwin .layui-layer-close', {tips: 3});
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

        $(".ext_info").click(function(){
            var url = "<?php  echo $this->createWebUrl('extIn')?>&id="+$(this).attr("data-id");
            var index = layui.layer.open({
                title : "扩展信息",
                type : 2,
                area: ['500px',"80%"],
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处关闭', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                }
            });
        });

        $(".newsAdd_btn").click(function(){
            var url = $(this).attr("data-url");
            var index = layui.layer.open({
                title : "添加员工",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回会员列表', '.layui-layer-setwin .layui-layer-close', {
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
                    $.post("<?php  echo $this->createWebUrl('delete')?>&tb=member&id="+id,function(response){
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