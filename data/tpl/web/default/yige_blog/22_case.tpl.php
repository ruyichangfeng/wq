<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/yige_blog/resources/style.css"/>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive panel-body">
            <div style="float: right; margin-bottom: 10px;">
                <a type="button" href="<?php  echo $this->createWebUrl('case', array('op' => 'edit'));?>" class="btn btn-primary">添加案例</a>
            </div>
            <table class="table table-hover" style="min-width: 300px;">
                <thead class="navbar-inner">
                <tr>
                    <th>ID</th>
                    <th>案例名称</th>
                    <th>预览图</th>
                    <th>外链</th>
                    <th>排序级别</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($data)) { foreach($data as $item) { ?>
                <tr>
                    <td style="max-width: 30px"><?php  echo $item['id'];?></td>
                    <td style="min-width: 100px;"><?php  echo $item['name'];?></td>
                    <td><img style="height: 66px;width: 66px;" src="<?php  echo tomedia($item['image'])?>"></td>
                    <td><?php  echo $item['url'];?></td>
                    <td><?php  echo $item['sort'];?></td>
                    <td style="max-width: 100px;">
                        <a class="btn btn-primary btn-sm" href="<?php  echo $this->createWebUrl('case', array('id'=>$item['id'], 'op' => 'edit'));?>">编辑</a>
                        <a class="btn btn-primary btn-sm" href="<?php  echo $this->createWebUrl('case', array('id'=>$item['id'], 'op' => 'delete'));?>" onclick="return confirm('确认删除吗？');return false;" title="删除">删除</a>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
        </div>
        <div style="margin-bottom: 0; float:right; width: 100%; text-align: center"></div>

    </div>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>