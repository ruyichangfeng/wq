<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('task_category', array())?>">导航管理</a></li>
    <li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('task_nav', array('op' => 'post'))?>">添加导航</a></li>
</ul>
<?php  if($operation == 'display') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" >
        <div class="panel panel-default">
            <div class="table-responsive panel-body">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:10%;">id</th>
                        <th style="width:30%;">导航名称</th>
                        <th style="width:20%;">排序</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($catelist)) { foreach($catelist as $item) { ?>
                    <tr>
                        <td><?php  echo $item['id'];?></td>
						<td><?php  echo $item['title'];?></td>
                        <td><?php  echo $item['sorting'];?></td>
                        <td>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('task_nav', array('id' => $item['id'], 'op' => 'post'))?>"><i class="fa fa-search"></i>修改</a>
                            <a class="btn btn-default btn-sm" onclick="return confirm('您确定要删除该分类吗？');return false;" href="<?php  echo $this->createWebUrl('task_nav', array('id' => $item['id'], 'status' => $item['status'], 'op' => 'delete', 'storeid' => $storeid))?>"
 title="删除"><i class="fa fa-trash"></i>删除</a>
                        </td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <?php  echo $pager;?>
</div>
<?php  } else if($operation == 'post') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-warning" href="<?php  echo $this->createWebUrl('task_nav', array('op' => 'display', 'storeid' => $storeid))?>">返回导航列表
            </a>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="invitative">
        <div class="panel panel-default">
            <div class="panel-heading">
                导航信息
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" value="<?php  echo $item['title'];?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">导航排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="sorting" value="<?php  echo $item['sorting'];?>"  class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-3"/>
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
