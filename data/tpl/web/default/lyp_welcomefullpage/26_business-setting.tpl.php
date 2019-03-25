<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><a href="javascript:;">业务信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group hidden">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="close" id="status-1" <?php  if($business['close'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="close" id="status-0" <?php  if($business['close'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">顶部菜单标题</label>
			<div class="col-sm-8">
				<input type="text" name="title" class="form-control" value="<?php  echo $business['title'];?>" placeholder="请输入顶部菜单标题" />
				<span class="help-block">顶部菜单标题，不更改默认为“业务”</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面英文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[en_title]" class="form-control" value="<?php  echo $business['pagetitle']['en_title'];?>" placeholder="请输入页面英文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面中文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[ch_title]" class="form-control" value="<?php  echo $business['pagetitle']['ch_title'];?>" placeholder="请输入页面中文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">背景图片</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('backgroundimg',$business['backgroundimg'])?>
				<span class="help-block">页面加载时显示的背景图，建议尺寸：1920px * 1080px</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">业务一设置</label>
			<div class="col-sm-8">
				<input type="text" name="business1[title]" class="form-control" value="<?php  echo $business['business1']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="business1[subtitleone]" class="form-control" value="<?php  echo $business['business1']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="business1[subtitletwo]" class="form-control" value="<?php  echo $business['business1']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">业务二设置</label>
			<div class="col-sm-8">
				<input type="text" name="business2[title]" class="form-control" value="<?php  echo $business['business2']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="business2[subtitleone]" class="form-control" value="<?php  echo $business['business2']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="business2[subtitletwo]" class="form-control" value="<?php  echo $business['business2']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">业务三设置</label>
			<div class="col-sm-8">
				<input type="text" name="business3[title]" class="form-control" value="<?php  echo $business['business3']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="business3[subtitleone]" class="form-control" value="<?php  echo $business['business3']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="business3[subtitletwo]" class="form-control" value="<?php  echo $business['business3']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">业务四设置</label>
			<div class="col-sm-8">
				<input type="text" name="business4[title]" class="form-control" value="<?php  echo $business['business4']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="business4[subtitleone]" class="form-control" value="<?php  echo $business['business4']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="business4[subtitletwo]" class="form-control" value="<?php  echo $business['business4']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">业务五设置</label>
			<div class="col-sm-8">
				<input type="text" name="business5[title]" class="form-control" value="<?php  echo $business['business5']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="business5[subtitleone]" class="form-control" value="<?php  echo $business['business5']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="business5[subtitletwo]" class="form-control" value="<?php  echo $business['business5']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
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