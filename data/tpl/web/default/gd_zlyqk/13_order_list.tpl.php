<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .panel_word{width:100%;margin-bottom: 5px;margin-top:5px;color: white;}
    .panel{min-width: 14.2% !important;}
</style>
<form  class="layui-form">
<blockquote class="layui-elem-quote" style="padding-top:2px;padding-bottom: 2px;">
    <div class="layui-inline">
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <select  id="app" lay-verify="required" style="">
                <option value="0">所有应用</option>
                <?php  if(is_array($apps)) { foreach($apps as $ak => $item) { ?>
                <option value="<?php  echo $item['id'];?>" <?php  if($item['id']==$_GPC['app_id']) { ?>selected<?php  } ?>><?php  echo $item['name'];?></option>
                <?php  } } ?>
            </select>
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <input type="text" value="<?php  echo $_GPC['order_sn'];?>" id="order_sn" placeholder="单号搜索" class="layui-input search_input">
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <select name="status" id="status" lay-verify="required">
                <option value="-1">支付状态</option>
                <option value="0" <?php  if(0==$_GPC['status']) { ?>selected<?php  } ?>>未支付</option>
                <option value="1" <?php  if(1==$_GPC['status']) { ?>selected<?php  } ?>>已支付</option>
            </select>
        </div>
        <div class="layui-input-inline" style="width: 100px;padding-bottom: 3px;">
            <input class="layui-input start" name="start" value="<?php  echo $_GPC['start'];?>" placeholder="起始日期" id="LAY_demorange_s">
        </div>
        <div class="layui-input-inline "  style="width: 100px;padding-bottom: 3px;">
            <input class="layui-input end" name="end" value="<?php  echo $_GPC['end'];?>" placeholder="结束日期" id="LAY_demorange_e">
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
        <a class="layui-btn pool_excel" >导出</a>
        <a class="layui-btn layui-btn-danger batchDel" style="margin-left: 3px;">删除</a>
    </div>
</blockquote>
</form>
<div class="layui-form news_list" style="width: 100%;overflow: scroll">
    <table class="layui-table"  style="min-width: 1700px;" >
    <colgroup>
        <col width="50">
        <col width="100">
        <col width="100">
        <col width="80">
        <col width="80">
        <col width="120">
        <col width="100">
        <col width="100">
        <col width="130">
        <col width="100">
        <col width="100">
        <col width="100">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
        <th>单号</th>
        <th>应用</th>
        <th>用户</th>
        <th>金额</th>
        <th>状态</th>
        <th>下单时间</th>
        <th>支付时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody class="news_content">
    <?php  if(is_array($dataList)) { foreach($dataList as $recorder) { ?>
    <tr>
        <td>
            <input type="checkbox" name="checked" value="<?php  echo $recorder['id'];?>" lay-skin="primary" lay-filter="choose">
            <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                <i class="layui-icon"></i>
            </div>
        </td>
        <td><?php  echo $recorder['order_sn'];?></td>
        <td><?php  echo $recorder['app_name'];?></td>
        <td><?php  echo $recorder['member_name'];?></td>
        <td><?php  echo $recorder['money'];?></td>
        <td><?php  if($recorder['pay_status']==0) { ?>未支付<?php  } else { ?>已支付<?php  } ?></td>
        <td><?php  echo date("Y-m-d H:i:s",$recorder['create_time'])?></td>
        <td><?php  if($recorder['pay_time']>0) { ?><?php  echo date("Y-m-d H:i:s",$recorder['pay_time'])?><?php  } ?></td>
        <td>
            <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="<?php  echo $recorder['id'];?>" data-app="<?php  echo $recorder['app_id'];?>">删除</a>
        </td>
    </tr>
    <?php  } } ?>
    </tbody>
    </table>
</div>
<div id="page"></div>
<script>
    var _this;
    var url;
    var $;
    var lay;
    var gd_sn,status,start,end,app;
    layui.use(['form','jquery','laypage'], function(){
        var setting =new Object();
        $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            gd_sn=$("#order_sn").val();
            status =$("#status").val();
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'order'))?>"+"&status="+status+"&start="+start+"&end="+end+"&order_sn="+gd_sn+"&app_id="+app;
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
            gd_sn=$("#order_sn").val();
            status =$("#status").val();
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            if(first!=true){
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'order'))?>"+"&status="+status+"&start="+start+"&end="+end+"&order_sn="+gd_sn+"&app_id="+app+"&page="+obj.curr;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        //综合倒出
        $(".pool_excel").click(function(){
            gd_sn=$("#order_sn").val();
            status =$("#status").val();
            start=$(".start").val();
            end =$(".end").val();
            app =$("#app").val();
            url = "<?php  echo $this->createWebUrl('orderExcel')?>"+"&status="+status+"&start="+start+"&end="+end+"&order_sn="+gd_sn+"&app_id="+app;
            appDown(url,1,"");
        });


        //删除操作
        $(".news_del").on("click",function(){
            var _this = $(this);
            layer.confirm('确定删除此信息？',{icon:3, title:'提示信息'},function(index){
                var id =_this.attr("data-id");
                $.post("<?php  echo $this->createWebUrl('delete')?>&tb=order&id="+id,function(response){
                    layer.msg(response.msg,{icon: response.code});
                    if(response.code==1){
                       _this.parents("tr").remove();
                    }
                },'json');
            });
        });

        //标记操作
        $(".do_mark").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            _this=$(this);
            $.post("<?php  echo $this->createWebUrl('wMark')?>",{app:app,id:id},function(response){
                layer.msg(response.msg,{icon: response.code});
                setTimeout(function(){
                    if(response.code==1){
                        location.reload();
                    }
                },1000);
            },"json");
        });

        //分配
        $(".do_give").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            var url="<?php  echo $this->createWebUrl('wGive')?>&app="+app+"&id="+id;
            var index = layui.layer.open({
                title : "分配人员",
                type : 2,
                area : ["530px","85%"],
                content : url
            });
        });

        //处理
        $(".doing").click(function(){
            var app=$(this).attr("data-app");
            var id =$(this).attr("data-id");
            var url="<?php  echo $this->createWebUrl('wDoing')?>&app="+app+"&id="+id;
            var index = layui.layer.open({
                title : "处理流程",
                type : 2,
                area : ["600px","98%"],
                content : url
            });
        });

        //详情操作
        $(".news_edit").on("click",function(){
            var id = $(this).attr("data-id");
            var app = $(this).attr("data-app");
            var url = "<?php  echo $this->createWebUrl('viewRecorder')?>&id="+id+"&app_id="+app;
            var index = layui.layer.open({
                title : "查看消息",
                type : 2,
                area : ["750px","98%"],
                content : url
            });
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
                    $.post("<?php  echo $this->createWebUrl('delete')?>&tb=order&id="+id,function(response){
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

        //下载文件
        function appDown(url,page,table){
            $.post(url,{page:page,table:table},function(response){
                if(response.code==0){
                    setTimeout(function(){
                        lay =layer.msg("正在处第："+page+"页",{
                            time: 20000
                        });
                        appDown(url,response.page,response.table);
                    },1000);
                }else{
                    setTimeout(function() {
                        layer.close(lay);
                        location.href="<?php  echo $this->createWebUrl('fDown')?>&file="+response.csv+"&table="+response.table;
                    },1000);

                }
            },'json');
        }

        layui.use('laydate', function(){
            var laydate = layui.laydate;

            var start = {
                max: '2099-06-16 23:59:59'
                ,istoday: true
                ,choose: function(datas){
                    end.min = datas;
                    end.start = datas;
                }
            };

            var end = {
                max: '2099-06-16 23:59:59'
                ,istoday: false
                ,choose: function(datas){
                    start.max = datas;
                }
            };

            document.getElementById('LAY_demorange_s').onclick = function(){
                start.elem = this;
                laydate(start);
            };
            document.getElementById('LAY_demorange_e').onclick = function(){
                end.elem = this
                laydate(end);
            };
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

    function click(act){
        parent.click(act);
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>