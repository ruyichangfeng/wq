<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
</style>
<form  class="layui-form">
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['name'];?>" style="width: 100px;" id="name" placeholder="姓名" class="layui-input search_input">
        </div>
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['mobile'];?>" style="width: 100px;" id="mobile" placeholder="电话" class="layui-input search_input">
        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <select id="label">
                <option value="0">选择组</option>
                <?php  if(is_array($label)) { foreach($label as $index => $lb) { ?>
                <option value="<?php  echo $index;?>" <?php  if($index==$_GPC['label']) { ?>selected<?php  } ?>><?php  echo $lb;?></option>
                <?php  } } ?>
            </select>
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
            <col width=25%">
            <col >
        </colgroup>
        <thead>
        <tr>
            <th>姓名</th>
            <th>会员组</th>
            <th>电话</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody class="news_content">
        <?php  if(is_array($dataList)) { foreach($dataList as $member) { ?>
        <tr>
            <td align="left"><?php  echo $member['name'];?></td>
            <td align="left"><?php  echo $member['label'];?></td>
            <td><?php  echo $member['mobile'];?></td>
            <td>
                <?php  if($_GPC['tp']==1) { ?>
                <a class="layui-btn layui-btn-mini news_edit" onclick="pluginGiveMember('<?php  echo $member['id'];?>','<?php  echo $member['name'];?>','<?php  echo $_GPC['id'];?>')" data-id="<?php  echo $member['id'];?>">
                    <i class="iconfont icon-edit"></i> 分配
                </a>
                <?php  } else { ?>
                <a class="layui-btn layui-btn-mini news_edit" onclick="pluginSelectMember('<?php  echo $member['id'];?>','<?php  echo $member['name'];?>','<?php  echo $member['mobile'];?>')" data-id="<?php  echo $member['id'];?>">
                    <i class="iconfont icon-edit"></i> 选择
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
        var tp = "<?php  echo $_GPC['tp'];?>";

        var $ = layui.jquery;
        var form = layui.form();

        form.on('submit(search)', function(data){
            name=$("#name").val();
            mobile=$("#mobile").val();
            label =$("#label").val();
            url = "<?php  echo $this->createWebUrl('list',array('tb'=>'member','mode'=>'select'))?>"+"&mobile="+mobile+"&name="+name+"&label="+label+"&tp="+tp+"&id=<?php  echo $_GPC['id'];?>";
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
                url = "<?php  echo $this->createWebUrl('list',array('tb'=>'member','mode'=>'select'))?>"+"&mobile="+mobile+"&name="+name+"&page="+obj.curr+"&label="+label+"&tp="+tp+"&id=<?php  echo $_GPC['id'];?>";
                window.location.href =url;
            }
        };
        layui.laypage(setting);
    });

    function pluginSelectMember(id,name,mobile){
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.pluginSelectMember(id,name,mobile);
    }

    function pluginGiveMember(id,name,mobile){
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        parent.pluginGiveMember(id,name,mobile);
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>