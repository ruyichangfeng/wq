<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-search we7-padding-bottom clearfix">
	<div class="pull-right">
		<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
		<a href="<?php  echo $this->createWebUrl('category_post')?>" class="btn btn-primary we7-padding-horizontal">+新建分类</a>
		<?php  } else { ?>
		<a href="<?php  echo $this->createWebUrl('category_post', array('module_type' => 'system_welcome'))?>" class="btn btn-primary we7-padding-horizontal">+新建分类</a>
		<?php  } ?>
	</div>
</div>
<form action="./index.php?c=site&a=category&do=delete" class="we7-form" method="post">
<table class="table we7-table table-hover article-list vertical-middle">
	<!-- <col width="80px"> -->
	<col width="100px"/>
	<col width=""/>
	<col width="200px"/>
	<tr>
		<!-- <th></th> -->
		<th class="text-left">排序</th>
		<th class="text-left">分类名称</th>
		<th class="text-right">操作</th>
	</tr>
	<?php  if(is_array($category_list)) { foreach($category_list as $row) { ?>
		<tr>
		<!-- 	<td>
				<input type="checkbox" we7-check-all="1" name="rid[]" id="rid-<?php  echo $row['id'];?>" value="<?php  echo $row['id'];?>">
				<label for="rid-<?php  echo $row['id'];?>">&nbsp;</label>
			</td> -->
			<td class="text-left"><?php  echo $row['displayorder'];?></td>
			<td class="text-left">
				<span><?php  echo $row['title'];?></span>
			</td>
			<td style="position: relative;">
				<div class="link-group">
					<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
					<a href="<?php  echo $this->createWebUrl('article_post', array('cate_id' => $row['id']));?>" >添加文章</a>
					<a href="<?php  echo $this->createWebUrl('category_post', array('id' => $row['id']));?>" >编辑</a>
					<a href="<?php  echo $this->createWebUrl('category_del', array('id' => $row['id']));?>" class="del" onclick="return confirm('确认删除此分类吗？');return false;">删除</a>
					<?php  } else { ?>
					<a href="<?php  echo $this->createWebUrl('article_post', array('cate_id' => $row['id'], 'module_type' => 'system_welcome'));?>" >添加文章</a>
					<a href="<?php  echo $this->createWebUrl('category_post', array('id' => $row['id'], 'module_type' => 'system_welcome'));?>" >编辑</a>
					<a href="<?php  echo $this->createWebUrl('category_del', array('id' => $row['id'], 'module_type' => 'system_welcome'));?>" class="del" onclick="return confirm('确认删除此分类吗？');return false;">删除</a>
					<?php  } ?>
				</div>
			</td>
		</tr>
	<?php  } } ?>
</table>
<div class="clearfix"></div>
<!-- <div class="we7-margin-left">
	<input type="checkbox" we7-check-all="1" name="rid[]" id="select_all" value="1">
	<label for="select_all">&nbsp;</label>
	<input type="submit" class="btn btn-danger" name="submit" value="删除" onclick="if(!confirm('确定删除选中的规则吗？')) return false;"/>
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />	
</div> -->
</form>
<script>
$('#select_all').click(function(){
	$('.article-list :checkbox').prop('checked', $(this).prop('checked'));
});
$('.js-clip').each(function(){
	util.clip(this, $(this).attr('data-url'));
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>