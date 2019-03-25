<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .adm_ln{line-height: 40px;margin-right: 10px;}
</style>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.colorpicker.js"></script>
<form class="layui-form" >
    <div class="layui-form-item">
        <input type="hidden" name="id" value="<?php  echo $recorder['id'];?>">
        <label class="layui-form-label">应用</label>
        <div class="layui-input-block">
            <input type="text" name="in[name]" style="width: 300px;" value="<?php  echo $recorder['name'];?>" required="" lay-verify="required" placeholder="请输入应用名" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="number" name="in[sorter]" style="width: 300px;" value="<?php  echo $recorder['sorter'];?>" required=""  placeholder="首页显示顺序,越大越靠前" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-block" style="width:300px;">
            <select name="in[category]" >
                <option value="0" >选择分类</option>
                <?php  if(is_array($categoryList)) { foreach($categoryList as $category) { ?>
                <option value="<?php  echo $category['id'];?>" <?php  if($category['id']==$recorder['category']) { ?>selected<?php  } ?>><?php  echo $category['name'];?></option>
                <?php  } } ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">绑定流程</label>
        <div class="layui-input-block" style="width:300px;">
            <select name="in[flow_id]" >
                <option value="0" >选择绑定流程</option>
                <?php  if(is_array($flowList)) { foreach($flowList as $flow) { ?>
                <option value="<?php  echo $flow['id'];?>" <?php  if($flow['id']==$recorder['flow_id']) { ?>selected<?php  } ?>><?php  echo $flow['name'];?></option>
                <?php  } } ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item" >
        <label class="layui-form-label">应用说明</label>
        <div class="layui-input-block">
            <input type="text" name="in[cover_desc]" style="width: 300px;" id="cp3_text" value="<?php  echo $recorder['cover_desc'];?>" required="" lay-verify="" placeholder="请输应用说明" autocomplete="off" class="layui-input">
        </div>
    </div>
    <!--<div class="layui-form-item role_hd" >-->
    <!--<label class="layui-form-label">级别</label>-->
    <!--<div class="layui-input-block ">-->
        <!--<span class="admin_list">-->
        <?php  if($dpList ) { ?>
            <?php  if(is_array($dpList)) { foreach($dpList as $index => $fl) { ?>
            <!--<a href="javascript:" class="adm_ln"><input type="hidden" name="property[<?php  echo $index;?>]" value="<?php  echo $fl['id'];?>"><?php  echo $fl['name'];?> </a>-->
            <?php  } } ?>
        <?php  } else { ?>
            <!--<a href="javascript:" class="adm_ln">无</a>-->
        <?php  } ?>
        <!--</span>-->
        <!--<a class="layui-btn layui-btn-primary layui-btn-small add_dp " style="margin-left: 20px;">-->
            <!--<i class="layui-icon">&#xe654;</i>-->
        <!--</a>-->
    <!--</div>-->
    <!--</div>-->
    <div class="layui-form-item">
    <label class="layui-form-label">封面图</label>
    <div class="layui-input-block" id="imgList">
        <input type="hidden" id="cov" class="covs" name="in[cover]" value="<?php  echo $recorder['cover'];?>" >
        <input type="file" name="file" class="layui-upload-file">
        <img src="<?php  if(strstr($recorder['cover'],'http')) { ?><?php  echo $recorder['cover'];?><?php  } else { ?>/<?php  echo $recorder['cover'];?><?php  } ?>" id="imgs"  style=" height:35px;margin-left:20px; <?php  if(empty($recorder['cover']) ) { ?> display: none; <?php  } ?>">
        <a href="javascript:" class="rem layui-btn layui-btn-danger layui-btn-mini" style="margin-left:15px;width: 30px;">删除</a>
        <span style="margin-left: 30px;">建议尺寸(375x140)</span>
    </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">应用图标</label>
        <div class="layui-input-block" id="imgList1">
            <input type="hidden" id="cov1" class="covs" name="in[icon]" value="<?php  echo $recorder['icon'];?>" >
            <input type="file" name="file" class="layui-upload-file1">
            <img src="<?php  if(strstr($recorder['icon'],'http')) { ?><?php  echo $recorder['icon'];?><?php  } else { ?>/<?php  echo $recorder['icon'];?><?php  } ?>" id="imgs1"  style=" height:35px;margin-left:20px; <?php  if(empty($recorder['icon']) ) { ?> display: none; <?php  } ?>">
            <a href="javascript:" class="rem layui-btn layui-btn-danger layui-btn-mini " style="margin-left:15px;width: 30px;">删除</a>
            <span style="margin-left: 30px;"><a href="http://www.iconfont.cn/collections/detail?cid=4491" target="_blank">前往下载</a> </span>
        </div>
    </div>
    <div class="layui-form-item" style="display: none">
        <label class="layui-form-label">封面名称</label>
        <div class="layui-input-block">
            <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp2" style="cursor:pointer;float: left;margin-top:12px;margin-right:5px;"/>
            <input type="hidden" name="in[name_color]" id="color_1" value="<?php  echo $recorder['name_color'];?>">
            <input type="text" name="in[cover_name]" style="width: 300px;<?php  if($recorder['name_color']) { ?>color:<?php  echo $recorder['name_color'];?><?php  } ?>" id="cp2_text" value="<?php  echo $recorder['cover_name'];?>" required="" lay-verify="" placeholder="请输入封面名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item" style="display: none">
        <label class="layui-form-label">流程模式</label>
        <div class="layui-input-block">
            <?php  if($recorder['mods']) { ?>
            <?php  if($recorder['mods']==1) { ?>
            <input type="radio" name="in[mods]" title="管理员派单" value="1" <?php  if($recorder['mods']==1) { ?> checked <?php  } ?>>
            <?php  } ?>
            <input type="radio" name="in[mods]" title="员工抢单" value="0" <?php  if($recorder['mods']==0) { ?> checked <?php  } ?>>
            <?php  } else { ?>
            <input type="radio" name="in[mods]" title="抢单" value="0" checked >
            <?php  } ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">应用权限</label>
        <div class="layui-input-block ">
        <span class="admin_list_p">
            <?php  if($prList) { ?>
            <?php  if(is_array($prList)) { foreach($prList as $index => $fl) { ?>
                <a href="javascript:" class="adm_ln"><input type="hidden" name="admin[<?php  echo $index;?>]" value="<?php  echo $fl['id'];?>"><?php  echo $fl['name'];?> </a>
            <?php  } } ?>
            <?php  } else { ?>
                <a href="javascript:" class="adm_ln">无</a>
            <?php  } ?>
        </span>
            <a class="layui-btn layui-btn-primary layui-btn-small add_p">
                <i class="layui-icon">&#xe654;</i>
            </a>
        </div>
    </div>
    <input type="hidden" name="in[status]" value="1">
    <div class="layui-form-item" style="display: none">
        <label class="layui-form-label">默认应用</label>
        <div class="layui-input-block">
            <input type="radio" name="in[is_default]" title="是" value="1" <?php  if($recorder['is_default']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[is_default]" title="否" value="0" <?php  if($recorder['is_default']==0) { ?> checked <?php  } ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">首页显示</label>
        <div class="layui-input-block">
            <input type="radio" name="in[is_show]" title="是" value="1" <?php  if($recorder['is_show']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[is_show]" title="否" value="0" <?php  if($recorder['is_show']==0) { ?> checked <?php  } ?>>
            <span style="display: inline-block;">（必须有应用图标才会显示首页）</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">数据提交</label>
        <div class="layui-input-block">
            <input type="radio" name="in[is_submit]" title="是" value="0" <?php  if($recorder['is_submit']==0) { ?> checked <?php  } ?>>
            <input type="radio" name="in[is_submit]" title="否" value="1" <?php  if($recorder['is_submit']==1) { ?> checked <?php  } ?>>
            <span style="display: inline-block;">（显示提交按钮）</span>
        </div>
    </div>
    <div class="layui-form-item" style="display: none">
        <label class="layui-form-label">员工退回</label>
        <div class="layui-input-block">
            <input type="radio" name="in[back]" title="是" value="1" <?php  if($recorder['back']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[back]" title="否" value="0" <?php  if($recorder['back']==0) { ?> checked <?php  } ?>>
            <font >可退回流程节点</font>
        </div>
    </div>
    <div class="layui-form-item" style="display: none">
        <label class="layui-form-label">客户取消</label>
        <div class="layui-input-block">
            <input type="radio" name="in[cancel]" title="是" value="1" <?php  if($recorder['cancel']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[cancel]" title="否" value="0" <?php  if($recorder['cancel']==0) { ?> checked <?php  } ?>>
            <font >客户可取消流程</font>
        </div>
    </div>
    <div class="layui-form-item" style="display: none">
        <label class="layui-form-label">菜单设置</label>
        <div class="layui-input-block">
            <input type="radio" name="in[menu]" title="全局菜单" value="1" <?php  if($recorder['menu']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[menu]" title="应用菜单" value="0" <?php  if($recorder['menu']==0) { ?> checked <?php  } ?>>
        </div>
    </div>

    <div class="layui-form-item">
    <label class="layui-form-label">通知部门</label>
    <div class="layui-input-block ">
        <span class="admin_list_u">
            <?php  if($adList) { ?>
            <?php  if(is_array($adList)) { foreach($adList as $index => $fl) { ?>
                <a href="javascript:" class="adm_ln"><input type="hidden" name="admin[<?php  echo $index;?>]" value="<?php  echo $fl['id'];?>"><?php  echo $fl['name'];?> </a>
            <?php  } } ?>
            <?php  } else { ?>
                <a href="javascript:" class="adm_ln">无</a>
            <?php  } ?>
        </span>
        <a class="layui-btn layui-btn-primary layui-btn-small add_du">
            <i class="layui-icon">&#xe654;</i>
        </a>
        <font >&nbsp;&nbsp;仅限表单配置，绑定流程，配置不生效</font>
    </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">提交限制</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" name="in[per_num]" style="width: 100px;" value="<?php  echo $recorder['per_num'];?>" required=""  placeholder="时间间隔" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <div class="layui-input-inline" style="width: 120px">
                <select name="in[cond]">
                    <option value="0">无限制</option>
                    <option value="1" <?php  if($recorder['cond']==1) { ?>selected<?php  } ?>>分钟</option>
                    <option value="2" <?php  if($recorder['cond']==2) { ?>selected<?php  } ?>>小时</option>
                    <option value="3" <?php  if($recorder['cond']==3) { ?>selected<?php  } ?>>天</option>
                    <option value="5" <?php  if($recorder['cond']==5) { ?>selected<?php  } ?>>周</option>
                    <option value="4" <?php  if($recorder['cond']==4) { ?>selected<?php  } ?>>月</option>
                    <option value="6" <?php  if($recorder['cond']==6) { ?>selected<?php  } ?>>年</option>
                </select>
            </div>
        </div>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="number" name="in[cond_num]" style="width: 100px;" value="<?php  echo $recorder['cond_num'];?>" required=""  placeholder="可提交次数" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>
    <p style="padding-left: 40px;margin-bottom: 20px;">填写格式: 1 分钟 10次, 10 分钟 5次</p>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addAdmin">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script>
    var fresh="<?php  echo $fresh;?>";
    $("#cp2").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp2_text").css("color",color);
            $("#color_1").val(color);
        }
    });
    $(".rem").click(function(){
        $(this).parent().find("img").hide();
        $(this).parent().find(".covs").val("");
    });
    $("#cp3").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp3_text").css("color",color);
            $("#color_2").val(color);
        }
    });
    $("#cp4").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp4_text").css("color",color);
            $("#color_3").val(color);
        }
    });

    //选取员工
    $(".add_dp").click(function(){
        ly = layui.layer.open({
            type:2,
            title:false,
            content:"<?php  echo $this->createWebUrl('selectProperty')?>&id=<?php  echo $recorder['id'];?>",
            area:["500px","70%"]
        });
    });

    //选取员工
    $(".add_du").click(function(){
        ly = layui.layer.open({
            type:2,
            title:false,
            content:"<?php  echo $this->createWebUrl('selectDp')?>&id=<?php  echo $recorder['id'];?>",
            area:["500px","70%"]
        });
    });

    //选取权限部门
    $(".add_p").click(function(){
        ly = layui.layer.open({
            type:2,
            title:false,
            content:"<?php  echo $this->createWebUrl('selectDp')?>&id=<?php  echo $recorder['id'];?>&func=admin_list_p",
            area:["500px","70%"]
        });
    });

    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        var $ = layui.jquery;

        layui.layer.photos({
            photos: '#imgList'
            ,anim: 5
        });
        layui.layer.photos({
            photos: '#imgList1'
            ,anim: 5
        });

        layui.upload({
            elem: '.layui-upload-file',
            url: "<?php  echo $this->createWebUrl('upload')?>",
            method: 'post',
            ext:'jpg|png|gif',
            success: function (res) {
                layui.layer.msg(res.msg);
                if(res.code==2){
                    return false;
                }
                $("#imgs").show();
                $("#imgs").attr("src","/"+res.url);
                $("#cov").val(res.url);
            }
        });
        layui.upload({
            elem: '.layui-upload-file1',
            url: "<?php  echo $this->createWebUrl('upload')?>",
            method: 'post',
            ext:'jpg|png|gif',
            success: function (res) {
                layui.layer.msg(res.msg);
                if(res.code==2){
                    return false;
                }
                $("#imgs1").show();
                $("#imgs1").attr("src","/"+res.url);
                $("#cov1").val(res.url);
            }
        });
        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl($_GPC['do'],array('tb'=>'app'))?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        if(fresh){
                            parent.parent.location.reload();
                        }else{
                            parent.location.reload();
                        }

                    },1000);
                }
            },"json");
            return false;
        });
    });
    function setProper(str){
        $(".admin_list").html(str);
        layui.layer.close(ly);
    }
    function setAdmin(str){
        $(".admin_list_u").html(str);
        layui.layer.close(ly);
    }
    function setAdminP(str){
        $(".admin_list_p").html(str);
        layui.layer.close(ly);
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
