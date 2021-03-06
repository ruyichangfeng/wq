<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><a href="javascript:;">技术信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group hidden">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="close" id="status-1" <?php  if($technology['close'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="close" id="status-0" <?php  if($technology['close'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">顶部菜单标题</label>
			<div class="col-sm-8">
				<input type="text" name="title" class="form-control" value="<?php  echo $technology['title'];?>" placeholder="请输入顶部菜单标题" />
				<span class="help-block">顶部菜单标题，不更改默认为“技术”</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面英文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[en_title]" class="form-control" value="<?php  echo $technology['pagetitle']['en_title'];?>" placeholder="请输入页面英文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面中文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[ch_title]" class="form-control" value="<?php  echo $technology['pagetitle']['ch_title'];?>" placeholder="请输入页面中文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">背景图片</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('backgroundimg',$technology['backgroundimg'])?>
				<span class="help-block">页面加载时显示的背景图，建议尺寸：1920px * 1080px</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第一列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_multi_image('column1[thumb]', $technology['column1']['thumb']);?>
				<span class="help-block">第一列小图展示，建议尺寸：30px * 30px</span>
				<input type="text" name="column1[titleone]" class="form-control" value="<?php  echo $technology['column1']['titleone'];?>" placeholder="请输入第一行文字，长度不超过17个">
				<input type="text" name="column1[titletwo]" class="form-control" value="<?php  echo $technology['column1']['titletwo'];?>" placeholder="请输入第二行文字，长度不超过17个">
				<input type="text" name="column1[titlethree]" class="form-control" value="<?php  echo $technology['column1']['titlethree'];?>" placeholder="请输入第三行文字，长度不超过17个">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第二列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_multi_image('column2[thumb]', $technology['column2']['thumb']);?>
				<span class="help-block">第二列小图展示，建议尺寸：30px * 30px</span>
				<input type="text" name="column2[titleone]" class="form-control" value="<?php  echo $technology['column2']['titleone'];?>" placeholder="请输入第一行文字，长度不超过17个">
				<input type="text" name="column2[titletwo]" class="form-control" value="<?php  echo $technology['column2']['titletwo'];?>" placeholder="请输入第二行文字，长度不超过17个">
				<input type="text" name="column2[titlethree]" class="form-control" value="<?php  echo $technology['column2']['titlethree'];?>" placeholder="请输入第三行文字，长度不超过17个">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第三列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_multi_image('column3[thumb]', $technology['column3']['thumb']);?>
				<span class="help-block">第三列小图展示，建议尺寸：30px * 30px</span>
				<input type="text" name="column3[titleone]" class="form-control" value="<?php  echo $technology['column3']['titleone'];?>" placeholder="请输入第一行文字，长度不超过17个">
				<input type="text" name="column3[titletwo]" class="form-control" value="<?php  echo $technology['column3']['titletwo'];?>" placeholder="请输入第二行文字，长度不超过17个">
				<input type="text" name="column3[titlethree]" class="form-control" value="<?php  echo $technology['column3']['titlethree'];?>" placeholder="请输入第三行文字，长度不超过17个">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;"></label>
			<div class="col-sm-8">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input type="submit" name="submit" value="保存" class="btn btn-primary">
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>