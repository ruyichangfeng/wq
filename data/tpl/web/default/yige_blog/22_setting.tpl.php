<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">


    <div class="form-group">
        <label class="col-sm-2 control-label">顶部banner图 1920x600</label>
        <div class="col-sm-8">
            <?php echo tpl_form_field_image('banner', $setting['banner'] ?: '../addons/yige_blog/resources/banner.jpg');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">站点名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" required value="<?php echo $setting['name'] ?: '站点名称'?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">站点简介</label>
        <div class="col-sm-8">
            <input type="text" name="description" class="form-control" required value="<?php echo $setting['description'] ?: '这里是站点简介，这里是站点简单介绍'?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">底部简介</label>
        <div class="col-sm-8">
            <input type="text" name="description_bottom" class="form-control" required value="<?php echo $setting['description_bottom'] ?: '底部简介，这里是底部简介'?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">底部版权信息</label>
        <div class="col-sm-8">
            <input type="text" name="copyright" class="form-control" required value="<?php echo $setting['copyright'] ?: 'Copyright © 优站精选 | 京ICP备11008151号'?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
            <input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </div>
</form>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>