<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<ul class="nav nav-tabs">
    <li <?php  if($operation == 'fieldset_post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('field', array('op' => 'fieldset_post'))?>">添加表单</a></li>
    <li <?php  if($operation == 'fieldset_display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('field', array('op' => 'fieldset_display'))?>">表单管理</a></li>
</ul>
<?php  if($operation == 'fieldset_post') { ?>
<div class="main">
    <form action="<?php  echo $this->createWebUrl('field', array('op' => 'fieldset_post'))?>" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $info['id'];?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                内容编辑
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">表单名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="<?php  echo $info['name'];?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-3" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<?php  } else if($operation == 'fieldset_display') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-primary" href="javascript:location.reload()"><i class="fa fa-refresh"></i>刷新</a>
        </div>
    </div>
    <div class="panel panel-default">
        <form action="" method="fieldset_post" class="form-horizontal form" >
            <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
            <div class="table-responsive panel-body">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:80px;">id</th>
                        <th>标题</th>
                        <th style="width:200px;text-align:right;">操作</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><div class="type-parent"><?php  echo $row['id'];?>&nbsp;&nbsp;</div></td>
                        <td><div class="type-parent"><?php  echo $row['name'];?>&nbsp;&nbsp;</div></td>
                        <td style="text-align:right;">
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('field', array('op' => 'field_display', 'fieldset_id' => $row['id']))?>" title="字段管理">字段管理</a>&nbsp;&nbsp;
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('field', array('op' => 'fieldset_post', 'id' => $row['id']))?>" title="编辑">改</a>&nbsp;&nbsp;
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('field', array('op' => 'fieldset_delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除吗？');return false;" title="删除">删</a>
                        </td>
                    </tr>
                    <?php  } } ?>
                    <tr>
                        <td colspan="3">
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <?php  echo $pager;?>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>