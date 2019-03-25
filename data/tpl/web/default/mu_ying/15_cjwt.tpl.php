<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('cjwt', array('op' => 'display'))?>">问题分类</a></li>
    <li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('cjwt', array('op' => 'post'))?>">问题及答案</a></li>
</ul>
<?php  if($op == 'display') { ?>
<form action="" method="post" class="form-horizontal form"  id="form1" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">问题分类管理<span style="color: red;">(建议添加三个分类)</span></h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">问题分类</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="submit" name="submit" value="添加/修改" class="btn btn-primary col-lg-4">
                </div>
            </div>
        </div>
    </div>
</form>
<table class="table we7-table table-hover article-list vertical-middle">
    <tr>
        <td>ID</td>
        <td>分类</td>
        <td class="text-right">操作</td>
    </tr>
    <?php  if(is_array($products)) { foreach($products as $item) { ?>
    <tr>
        <td><?php  echo $item['wt_id'];?></td>
        <td>
            <?php  echo $item['title'];?>
        </td>
        <td class="text-right">
            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('cjwt', array('wt_id' => $item['wt_id'], 'op' =>'display'))?>" >编辑</a>
            <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('cjwt', array('wt_id' => $item['wt_id'], 'op' => 'del'))?>">删除</a>
        </td>
    </tr>
    <?php  } } ?>
</table>
<?php  } ?>
<?php  if($op == "post") { ?>
<div class="pull-right">
    <a href="<?php  echo $this->createWeburl('cjwt', array('op'=>'posts'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">添加问题及答案</a>
</div>
<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td>ID</td>
            <td>问题</td>
            <td>答案</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td><?php  echo $item['id'];?></td>
            <td>
                <?php  echo $item['title'];?>
            </td>
            <td>
                <?php  echo $item['daan'];?>
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWeburl('cjwt', array('id' => $item['id'], 'op' =>'posts'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWeburl('cjwt', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
</form>
<?php  } ?>
<?php  if($op == 'posts') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">问题答案添加</h3>
        </div>
        
        <div class="panel-body">
            <div class="form-group" style="margin-left: 20px;">
                <label for="" class="control-label col-sm-1">选择分类</label>
                <select name="wt_id" class='control-label col-sm-2' style=" width:300px;margin-left: 45px;padding-top: 2px; padding-left: 25px;";>
                        <?php  if(is_array($louceng)) { foreach($louceng as $v) { ?>
                            <option value="<?php  echo $v['wt_id']?>" <?php  if($v['wt_id'] == $item['wt_id']) { ?> selected="selected" <?php  } ?>><?php  echo $v['title']?></option>
                        <?php  } } ?>   
                </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">问题</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">问题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">答案</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="daan" id="daan" value="<?php  echo $item['daan'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">答案</div>
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
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>