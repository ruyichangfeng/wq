<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/yige_blog/resources/style.css"/>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            编辑案例
        </h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="<?php  echo $this->createWebUrl('case', array('op' => 'save'));?>">
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
            <input type="hidden" name="id" value="<?php  echo $data['id'];?>">
            <div class="form-group">
                <label for="name" value="<?php  echo $data['name'];?>" class="col-sm-2 control-label">案例名称</label>
                <div class="col-sm-8">
                    <input id="name" value="<?php  echo $data['name'];?>" type="text" class="form-control" required="required" name="name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">案例预览图</label>
                <div class="col-sm-8">
                    <?php  echo tpl_form_field_image('image', $data['image']);?>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">案例外链</label>
                <div class="col-sm-8">
                    <input id="url" type="text" class="form-control" required="required" name="url" value="<?php  echo $data['url'];?>" >
                </div>
            </div>

            <div class="form-group">
                <label for="sort" class="col-sm-2 control-label">排序级别</label>
                <div class="col-sm-8">
                    <input id="sort" type="number" class="form-control" name="sort" value="<?php echo $data['sort'] ?: 0?>" >
                </div>
                <div class="col-sm-2">
                    数字越大越靠前
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="submit" class="btn btn-default" value="保存">
                </div>
            </div>
        </form>

    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
