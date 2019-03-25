<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
</style>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="25%">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>组ID</th>
            <th>组名称</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $admin) { ?>
        <tr data-id="<?php  echo $admin['url'];?>"  title="点击选择" style="cursor: pointer" data-name="<?php  echo $admin['name'];?>">
            <td align="left"><?php  echo $admin['id'];?></td>
            <td><?php  echo $admin['name'];?></td>
        </tr>
        <?php  } } ?>
        </tbody>
    </table>
</div>
<script>
    layui.use(['form','jquery','laypage'], function(){

        var name,mobile;
        var setting =new Object();

        var $ = layui.jquery;
        var form = layui.form();

        $("tbody tr").click(function(){
            var id = $(this).attr("data-id");
            var name =$(this).attr("data-name");
            parent.setApp(id,name);
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>