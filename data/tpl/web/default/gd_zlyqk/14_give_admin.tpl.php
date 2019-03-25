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
</blockquote>
</form>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="25%">
            <col width="25%">
            <col width="25%">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>姓名</th>
            <th>电话</th>
            <th>部门</th>
            <th>选取</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $admin) { ?>
        <tr>
            <td align="left"><?php  echo $admin['name'];?></td>
            <td><?php  echo $admin['mobile'];?></td>
            <td><?php  echo $admin['dp_name'];?></td>
            <td><a class="layui-btn  layui-btn-danger layui-btn-mini pei_admin" data-id="<?php  echo $_GPC['id'];?>" data-admin="<?php  echo $admin['id'];?>">确认</a></td>
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

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            url = "<?php  echo $this->createWebUrl('wGive')?>"+"&mobile="+mobile+"&name="+name;
            location.href=url;
            return false;
        });

        //确认分配
        $(".pei_admin").click(function(){
            var id=$(this).attr("data-id");
            var admin =$(this).attr("data-admin");
            $.post("<?php  echo $this->createWebUrl('doP')?>",{id:id,admin:admin},function(response){
                layer.msg(response.msg,{icon: response.code});
                setTimeout(function(){
                    if(response.code==1){
                        parent.location.reload();
                    }
                },1000);
            },"json");
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
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>