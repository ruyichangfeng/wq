<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<div class="pull-right">
    <a href="<?php  echo $this->createWeburl('tsfw', array('op'=>'post'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">添加特色服务内容</a>
</div>
<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td style="width: 100px;">ID</td>
            <td>标题</td>
            <td>图片</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td>
                <?php  echo $item['id'];?>
            </td>
            <td>
                <?php  echo $item['title'];?>
            </td>
            <td style="width: 150px">
                <img src="<?php  echo tomedia($item['img']);?>" width="100px" alt="">
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWeburl('tsfw', array('id' => $item['id'], 'op' =>'post'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWeburl('tsfw', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
</form>
<?php  } ?>
<?php  if($op == 'post') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">特色服务管理</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-1">标题</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">缩略图</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传缩略图</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">服务详情</label>
                <div class="form-controls col-sm-8" style="margin-left: 75px;">
                    <?php  echo tpl_ueditor('text', $item['text']);?>
                    <div class="help-block">请输入服务详情</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
</div>
</div> 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
