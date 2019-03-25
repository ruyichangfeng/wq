<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .layui-input{border:0 !important;}
</style>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.js"></script>
<form class="layui-form" >
    <?php  if(is_array($cols)) { foreach($cols as $key => $col) { ?>
    <div class="layui-form-item">
        <label class="layui-form-label"><?php  echo $col;?></label>
        <div class="layui-input-block">
            <input type="text" disabled style="width: 300px;" value="<?php  if(isset($extInfo[$key])){ echo $extInfo[$key]; }?>" required=""  placeholder="未填写" autocomplete="off" class="layui-input">
        </div>
    </div>
    <?php  } } ?>
</form>
<script>
    layui.use(['form','jquery','upload'], function(){
        var form = layui.form();
        var $ = layui.jquery;
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>
