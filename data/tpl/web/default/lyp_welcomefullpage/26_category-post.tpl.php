<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb we7-breadcrumb">
	<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
	<a href="<?php  echo $this->createWebUrl('category')?>"><i class="wi wi-back-circle"></i> </a>
	<li><a href="<?php  echo $this->createWebUrl('category')?>">分类管理</a></li>
	<?php  } else { ?>
	<a href="<?php  echo $this->createWebUrl('category', array('module_type' => 'system_welcome'))?>"><i class="wi wi-back-circle"></i> </a>
	<li><a href="<?php  echo $this->createWebUrl('category', array('module_type' => 'system_welcome'))?>">分类管理</a></li>
	<?php  } ?>
	<li>
		<?php  if(empty($id)) { ?><span>分类添加</span><?php  } ?>
		<?php  if(!empty($id)) { ?><span>分类编辑</span><?php  } ?>
	</li>
</ol>
<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
<form action="./index.php?c=site&a=entry&do=category_post&m=<?php  echo $_W['current_module']['name'];?>" method="post" class="article-post">
<?php  } else { ?>
<form action="./index.php?c=site&a=entry&do=category_post&m=<?php  echo $_W['current_module']['name'];?>&module_type=system_welcome" method="post" class="article-post">
<?php  } ?>
	<input type="hidden" name="id" value="<?php  echo $id;?>" />
	<div class="we7-form">
		<div class="form-group">
			<label for="" class="control-label col-sm-2">排序</label>
			<div class="form-controls col-sm-8">
				<input type="number" name="displayorder" class="form-control" value="<?php  echo $category_info['displayorder'];?>">
				<span class="help-block">分类的显示顺序，越大则越靠前 </span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">分类名称</label>
			<div class="form-controls col-sm-8">
				<input type="text" name="cname" class="form-control" value="<?php  echo $category_info['title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">分类描述</label>
			<div class="form-controls col-sm-8">
				<textarea name="description" class="form-control" rows="5"><?php  echo $category_info['description'];?></textarea>
			</div>
		</div>
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		<input name="submit" value="发布" class="btn btn-primary btn-submit" type="submit">
	</div>
</form>
<script>

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>