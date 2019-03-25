<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
</style>
<form  class="layui-form">
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['name'];?>" style="width: 120px;" id="name" placeholder="姓名" class="layui-input search_input">
        </div>
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['mobile'];?>" id="mobile" style="width: 120px;" placeholder="电话" class="layui-input search_input">
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
    </div>
</blockquote>
</form>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="40">
            <col width="25%">
            <col width="25%">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th width="40"><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose"></th>
            <th>姓名</th>
            <th>电话</th>
            <th>部门</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $admin) { ?>
        <tr>
            <td style="text-align: center !important;">
                <input type="checkbox" name="checked" value="<?php  echo $admin['id'];?>" <?php  if($admin['check']==1) { ?>checked<?php  } ?> data-name="<?php  echo $admin['name'];?>" data-app="<?php  echo $admin['app_id'];?>" lay-skin="primary" lay-filter="choose">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon"></i>
                </div>
            </td>
            <td align="left"><?php  echo $admin['name'];?></td>
            <td><?php  echo $admin['mobile'];?></td>
            <td><?php  echo $admin['dp_name'];?></td>
        </tr>
        <?php  } } ?>
        </tbody>
    </table>
</div>
<div id="page"></div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
    </div>
</div>
<script>
    layui.use(['form','jquery','laypage'], function(){

        var name,mobile;
        var setting =new Object();

        var $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            url = "<?php  echo $this->createWebUrl('wGive')?>"+"&mobile="+mobile+"&name="+name+"&id=<?php  echo $_GPC['id'];?>&flow_id=<?php  echo $_GPC['flow_id'];?>";
            location.href=url;
            return false;
        });

        form.on('submit(addAdmin)', function(data){
            var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]:checked');
            if($checkbox.is(":checked")){
                var id=0;
                var str="";
                $checkbox.each(function(){
                    str += '<a href="javascript:" class="user_ln"><input type="hidden" name="auser['+id+']" value="'+$(this).val()+'">'+$(this).attr('data-name')+'</a>';
                    id ++;
                });
                parent.setUser(str);
            }else{
                parent.setUser("");
            }
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
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'admin'))?>"+"&mobile="+mobile+"&name="+name+"&page="+obj.curr;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

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