<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form  class="layui-form">
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <div class="layui-input-inline">
            <input type="text" value="<?php  echo $_GPC['name'];?>" id="name" placeholder="部门搜索" class="layui-input search_input">
        </div>
        <a class="layui-btn" lay-submit lay-filter="search">搜索</a>
    </div>
</blockquote>
</form>
<div class="layui-form news_list">
    <table class="layui-table">
        <colgroup>
            <col width="80">
            <col >
        </colgroup>
        <tbody class="news_content">
        <?php  if(is_array($dpList)) { foreach($dpList as $admin) { ?>
        <tr>
            <td style="text-align: center !important;">
                <input type="checkbox" name="checked" value="<?php  echo $admin['id'];?>" data-name="<?php  echo $admin['name'];?>" <?php  if(isset($nDpList[$admin['id']])) { ?>checked<?php  } ?> lay-skin="primary" lay-filter="choose">
                <div class="layui-unselect layui-form-checkbox" lay-skin="primary">
                    <i class="layui-icon"></i>
                </div>
            </td>
            <td align="left"><?php  echo $admin['name'];?></td>
        </tr>
        <?php  } } ?>
        </tbody>
    </table>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn save" >选取</button>
        </div>
    </div>
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
            url = "<?php  echo $this->createWebUrl('selectDp')?>"+"&name="+name;
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
                url = "<?php  echo $this->createWebUrl('selectDp')?>"+"&name="+name+"&page="+obj.curr;
                window.location.href =url;
            }
        };
        layui.laypage(setting);

        $(".save").click(function(){
            var $checkbox = $('.news_list tbody input[type="checkbox"][name="checked"]:checked');
            if($checkbox.is(":checked")){
                var id=0;
                var str="";
                $checkbox.each(function(){
                    <?php  if($func) { ?>
                    str += '<a href="javascript:" class="adm_ln"><input type="hidden" name="priv['+id+']" value="'+$(this).val()+'">'+$(this).attr('data-name')+'</a>';
                    <?php  } else if($gp) { ?>
                    str += (str=="")? $(this).val():","+$(this).val();
                    <?php  } else { ?>
                    str += '<a href="javascript:" class="adm_ln"><input type="hidden" name="admin['+id+']" value="'+$(this).val()+'">'+$(this).attr('data-name')+'</a>';
                    <?php  } ?>
                    id ++;
                });
                <?php  if($func) { ?>
                    parent.setAdminP(str);
                <?php  } else { ?>
                    parent.setAdmin(str);
                <?php  } ?>
            }else{
                <?php  if($func) { ?>
                    parent.setAdminP("");
                <?php  } else { ?>
                    parent.setAdmin("");
                <?php  } ?>
            }
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>