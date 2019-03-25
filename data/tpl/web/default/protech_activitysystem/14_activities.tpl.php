<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div>
  <div class="pull-right">
    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('create-activity');?>">创建活动</a>
  </div>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <td>#</td>
      <td>活动标题</td>
      <td>海报</td>
      <td>活动介绍</td>
      <td>创建时间</td>
      <td>操作</td>
    </tr>
  </thead>
  <tbody>
    <?php  if(is_array($activities)) { foreach($activities as $index => $item) { ?>
      <tr>
        <td><?php  echo $item['id'];?></td>
        <td><a href="/attachment/<?php  echo $item['avatar'];?>" target="_blank"><img style="height:20px;" src="/attachment/<?php  echo $item['avatar'];?>"></a></td>
        <td><?php  echo $item['title'];?></td>
        <td><?php  echo $item['description'];?></td>
        <td><?php  echo $item['created_at'];?></td>
        <td>
          <a href="/app/<?php  echo $this->createMobileUrl('index', ['id' => $item['id']])?>" target="_blank">活动报名链接</a>
          &nbsp;&nbsp;
          <a href="<?php  echo $this->createWebUrl('activity-forms', ['id' => $item['id']])?>" target="_blank">活动报名情况</a>
        </td>
      </tr>
    <?php  } } ?>
  </tbody>
</table>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
