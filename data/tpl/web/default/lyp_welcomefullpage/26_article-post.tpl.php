<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb we7-breadcrumb">
	<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
		<a href="<?php  echo $this->createWebUrl('article')?>"><i class="wi wi-back-circle"></i> </a>
		<li><a href="<?php  echo $this->createWebUrl('article')?>">文章管理</a></li>
	<?php  } else { ?>
		<a href="<?php  echo $this->createWebUrl('article', array('module_type' => 'system_welcome'))?>"><i class="wi wi-back-circle"></i> </a>
		<li><a href="<?php  echo $this->createWebUrl('article', array('module_type' => 'system_welcome'))?>">文章管理</a></li>
	<?php  } ?>
	<li>文章编辑</li>
</ol>
<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
<form action="./index.php?c=site&a=entry&do=article_post&m=<?php  echo $_W['current_module']['name'];?>" method="post" enctype="multipart/form-data">
<?php  } else { ?>
<form action="./index.php?c=site&a=entry&do=article_post&m=<?php  echo $_W['current_module']['name'];?>&module_type=system_welcome" method="post" enctype="multipart/form-data">
<?php  } ?>
	<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
	<div class="we7-form" id="js-wesite-article-post">
		<div class="form-group">
			<label for="" class="control-label col-sm-2">排序</label>
			<div class="form-controls col-sm-8">
				<input type="number" class="form-control" name="displayorder" value="<?php  echo $item['displayorder'];?>">
				<span class="help-block">文章的显示顺序，越大则越靠前 </span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">标题</label>
			<div class="form-controls col-sm-8">
				<input type="text" class="form-control" name="title" value="<?php  echo $item['title'];?>">
				<span class="help-block">文章标题 </span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">文章作者</label>
			<div class="form-controls col-sm-8">
				<input type="text" class="form-control" name="author" value="<?php  echo $item['author'];?>">
				<span class="help-block">文章作者 </span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">缩略图</label>
			<div class="form-controls col-sm-8">
				<div class="input-group">
					<?php  echo tpl_form_field_image('thumb',$item['thumb'])?>
				</div>
				<div class="help-block">封面（大图片建议尺寸：360像素 * 200像素）</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<label class="control-label col-sm-2">文章类别</label>
			<div class="form-controls col-sm-4">
				<select name="category_id">
					<?php  if(is_array($category_list)) { foreach($category_list as $category) { ?>
					<option value="<?php  echo $category['id'];?>" <?php  if($category['id'] == $item['categoryid']) { ?>selected = "selected"<?php  } ?>><?php  echo $category['title'];?></option>
					<?php  } } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">简介</label>
			<div class="form-controls col-sm-8">
				<textarea class="form-control" name="description" rows="5"><?php  echo $item['digest'];?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">内容</label>
			<div class="form-controls col-sm-8">
				<?php  echo tpl_ueditor('content', $item['content']);?> 
			</div>
		</div>
		<div class="form-group hidden">
			<label for="" class="control-label col-sm-2">活动报名</label>
			<div class="form-controls col-sm-8">
				<select name="activityid" class="we7-select">
					<option value="0">不设置</option>
					<?php  if((!empty($activity_list))) { ?>
						<?php  if(is_array($activity_list)) { foreach($activity_list as $activity) { ?>
						<option value="<?php  echo $activity['id'];?>" <?php  if($activity['id'] == $item['activityid']) { ?> selected="selected"<?php  } ?>><?php  echo $activity['title'];?></option>
						<?php  } } ?>
					<?php  } ?>
				</select>
				<span class="help-block">在文章底部添加快捷报名，不设置则不显示</span>
			</div>
		</div>
		<div class="form-group ">
			<label for="" class="control-label col-sm-2">阅读次数</label>
			<div class="form-controls col-sm-8">
				<input class="form-control" type="text" name="click" value="<?php  echo $item['click'];?>">
				<span class="help-block">默认为0。您可以设置一个初始值,阅读次数会在该初始值上增加。</span>
			</div>
		</div>
		<input name="submit" value="发布" class="btn btn-primary btn-submit" type="submit">
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	</div>
</form>
<script>
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>