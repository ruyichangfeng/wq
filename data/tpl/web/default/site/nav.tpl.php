<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($do == 'home' || $do == 'profile') { ?>
<?php  if($do == 'home') { ?>
<div class="panel panel-warning">
	<div class="panel-body">
		当前使用的风格为：<?php  echo $style['name'];?>，模板文件为：<?php  echo $template['title'];?>（/app/themes/<?php  echo $template['name'];?>）。<?php  if(!empty($template['sections'])) { ?>此模板提供 <span class="label label-warning"><?php  echo $template['sections'];?></span> 个导航位置，您可以指定导航在特定的位置显示，未指位置的导航将无法显示<?php  } else { ?>此模板未提供导航位置功能<?php  } ?>
	</div>
</div>
<?php  } ?>

<table class="table we7-table table-hover">
	<col width="130px" />
	<col width="150px" />
	<col width="350px" />
	<col width="" />
	<tr>
		<th>标题</th>
		<th>图标</th>
		<th>链接</th>
		<th>操作</th>
	</tr>
	<?php  if(is_array($entries)) { foreach($entries as $menu) { ?>
	<tr ng-repeat="menu in homeMenu">
		<td class="title"><?php  echo $menu['title'];?></td>
		<td><i class="<?php  echo $menu['icon'];?>"></i></td>
		<td><a href="javascript:;" class="url" data-url="<?php  echo $menu['url'];?>"><?php  echo $menu['url'];?></a></td>
		<script>
			$('.url').each(function() {
				util.clip(this, $('.url').data('url'));
			});
			$('.url').click(function() {
				util.clip(this, $(this).data('url'));
			});

		</script>
		<td class="edit">
			<a href="<?php  echo url('site/multi')?>">跳转至“微官网”设置</a>
		</td>
	</tr>
	<?php  } } ?>
</table>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
