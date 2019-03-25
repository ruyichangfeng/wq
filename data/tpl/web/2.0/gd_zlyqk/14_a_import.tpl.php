<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<form class="layui-form" >
    <ul style="margin-left:30px;font-size:16px;margin-bottom: 15px;font-weight: 700">
        <li>导入文件格式csv格式</li>
        <li>格式:姓名,电话,密码(非必填),部门</li>
    </ul>
    <a href="<?php  echo $this->createWebUrl('jxt')?>" style="position:fixed;top: 5px;right: 5px;">..</a>
    <div class="layui-form-item" id="shows" >
        <label class="layui-form-label">选择文件</label>
        <div class="layui-input-block" id="imgList">
            <input type="file" lay-type="file" name="file" class="layui-upload-file">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block notice" style="word-break:break-all; width: 300px;">
        </div>
    </div>
</form>
<script>
    var url= "<?php  echo $this->createWebUrl('aimport')?>&ajax=1";
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        var $ = layui.jquery;
        layui.upload({
            elem: '.layui-upload-file',
            url: url,
            method: 'post',
            title: '请选择文件',
            ext:'csv',
            success: function (res) {
                layui.layer.msg(res.msg);
                return false;
            }
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
