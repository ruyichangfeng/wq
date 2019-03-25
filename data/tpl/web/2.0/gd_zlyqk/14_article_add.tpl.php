<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <div class="layui-form-item">
        <input type="hidden" name="id" value="<?php  echo $recorder['id'];?>">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="in[title]" value="<?php  echo $recorder['title'];?>" required="" style="width: 400px;" lay-verify="required" placeholder="通知标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">来源</label>
        <div class="layui-input-block">
            <input type="text" name="in[public]" value="<?php  echo $recorder['public'];?>" required="" style="width: 400px;" lay-verify="required" placeholder="信息来源/作者" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">谁可看</label>
        <div class="layui-input-block">
            <input type="radio" name="in[is_admin]" title="所有人" value="0" <?php  if($recorder['is_admin']==0) { ?>checked<?php  } ?> >
            <input type="radio" name="in[is_admin]" title="客户" value="1" <?php  if($recorder['is_admin']==1) { ?>checked<?php  } ?>>
            <input type="radio" name="in[is_admin]" title="员工" value="2" <?php  if($recorder['is_admin']==2) { ?>checked<?php  } ?>>
        </div>
    </div>
    <input type="hidden" name="in[admin_group]" required="" value="0" style="width: 400px;" lay-verify=""  autocomplete="off" class="layui-input">
    <div class="layui-form-item" style="width: 510px;">
        <label class="layui-form-label">过期时间</label>
        <div class="layui-input-block">
            <input class="layui-input start" name="in[gone_time]" <?php  if($recorder['gone_time']) { ?> value="<?php  echo date("Y-m-d",$recorder['gone_time'])?>"<?php  } ?> placeholder="过期时间" id="LAY_demorange_s">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">封面图</label>
        <div class="layui-input-block" id="imgList1">
            <input type="hidden" id="cov1" name="in[icon]" value="<?php  echo $recorder['icon'];?>" >
            <input type="file" name="file" class="layui-upload-file1">
            <img src="/<?php  echo $recorder['icon'];?>" id="imgs1"  style=" height:35px;margin-left:20px;">
            <span style="margin-left: 30px;"><a href="http://www.iconfont.cn/collections/detail?cid=4491" target="_blank">前往下载</a> </span>
        </div>
    </div>
    <div class="layui-form-item layui-form-text" style="width: 510px;">
        <label class="layui-form-label">通知简介</label>
        <div class="layui-input-block">
            <textarea name="in[desc]" placeholder="请输入内容" class="layui-textarea"><?php  echo $recorder['desc'];?></textarea>
        </div>
    </div>
    <div class="layui-form-item layui-form-text" style="width: 1200px">
        <label class="layui-form-label">通知内容</label>
        <div class="layui-input-block">
            <textarea id="demo" name="in[content]" style="display: none;"><?php  echo $recorder['content'];?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">首页显示</label>
        <div class="layui-input-block">
            <input type="radio" name="in[is_default]" title="是" value="1" <?php  if($recorder['is_default']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[is_default]" title="否" value="0" <?php  if($recorder['is_default']==0) { ?> checked <?php  } ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <input type="radio" name="in[status]" title="显示" value="1" <?php  if($recorder['status']==1) { ?> checked <?php  } ?>>
            <input type="radio" name="in[status]" title="隐藏" value="0" <?php  if($recorder['status']==0) { ?> checked <?php  } ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn lay-submit" lay-submit="" lay-filter="addAdmin">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script>
    var edit;
    var layedit;
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        var $ = layui.jquery;
        $(".lay-submit").click(function(){
            layedit.sync(edit);
        });
        form.on('submit(addAdmin)', function(data){
            $.post("<?php  echo $this->createWebUrl($_GPC['do'],array('tb'=>'article'))?>&Ajax=",data.field,function(response){
                layer.msg(response.msg,{icon: response.code});
                if(response.code==1){
                    setTimeout(function(){
                        parent.location.reload();
                    },1000);
                }
            },"json");
            return false;
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
                $("#imgs1").attr("src","/"+res.url);
                $("#cov1").val(res.url);
            }
        });
    });
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
        document.getElementById('LAY_demorange_s').onclick = function(){
            start.elem = this;
            laydate(start);
        };
    });
    layui.use('layedit', function(){
        layedit = layui.layedit;
        layedit.set({
            uploadImage: {
                url: "<?php  echo $this->createWebUrl('upload')?>&from=edit"
                ,type: 'post'
                , ext:'jpg|png|gif'
            }
        });

        edit = layedit.build('demo');
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
