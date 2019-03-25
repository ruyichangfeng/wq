<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><a href="javascript:;">营销信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group hidden">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="close" id="status-1" <?php  if($marketing['close'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="close" id="status-0" <?php  if($marketing['close'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">顶部菜单标题</label>
			<div class="col-sm-8">
				<input type="text" name="title" class="form-control" value="<?php  echo $marketing['title'];?>" placeholder="请输入顶部菜单标题" />
				<span class="help-block">顶部菜单标题，不更改默认为“营销”</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面英文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[en_title]" class="form-control" value="<?php  echo $marketing['pagetitle']['en_title'];?>" placeholder="请输入页面英文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面中文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[ch_title]" class="form-control" value="<?php  echo $marketing['pagetitle']['ch_title'];?>" placeholder="请输入页面中文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">背景图片</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('backgroundimg',$marketing['backgroundimg'])?>
				<span class="help-block">页面加载时显示的背景图，建议尺寸：1920px * 1080px</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第一列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('column1[thumb]',$marketing['column1']['thumb'])?>
				<span class="help-block">第一列图标，建议尺寸：70px * 70px</span>
				<input type="text" name="column1[titleone]" class="form-control" value="<?php  echo $marketing['column1']['titleone'];?>" placeholder="请输入大标题" />
				<input type="text" name="column1[titletwo]" class="form-control" value="<?php  echo $marketing['column1']['titletwo'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="column1[titlethree]" class="form-control" value="<?php  echo $marketing['column1']['titlethree'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第二列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('column2[thumb]',$marketing['column2']['thumb'])?>
				<span class="help-block">第二列图标，建议尺寸：70px * 70px</span>
				<input type="text" name="column2[titleone]" class="form-control" value="<?php  echo $marketing['column2']['titleone'];?>" placeholder="请输入大标题" />
				<input type="text" name="column2[titletwo]" class="form-control" value="<?php  echo $marketing['column2']['titletwo'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="column2[titlethree]" class="form-control" value="<?php  echo $marketing['column2']['titlethree'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第三列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('column3[thumb]',$marketing['column3']['thumb'])?>
				<span class="help-block">第三列图标，建议尺寸：70px * 70px</span>
				<input type="text" name="column3[titleone]" class="form-control" value="<?php  echo $marketing['column3']['titleone'];?>" placeholder="请输入大标题" />
				<input type="text" name="column3[titletwo]" class="form-control" value="<?php  echo $marketing['column3']['titletwo'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="column3[titlethree]" class="form-control" value="<?php  echo $marketing['column3']['titlethree'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第四列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('column4[thumb]',$marketing['column4']['thumb'])?>
				<span class="help-block">第四列图标，建议尺寸：70px * 70px</span>
				<input type="text" name="column4[titleone]" class="form-control" value="<?php  echo $marketing['column4']['titleone'];?>" placeholder="请输入大标题" />
				<input type="text" name="column4[titletwo]" class="form-control" value="<?php  echo $marketing['column4']['titletwo'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="column4[titlethree]" class="form-control" value="<?php  echo $marketing['column4']['titlethree'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第五列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('column5[thumb]',$marketing['column5']['thumb'])?>
				<span class="help-block">第五列图标，建议尺寸：70px * 70px</span>
				<input type="text" name="column5[titleone]" class="form-control" value="<?php  echo $marketing['column5']['titleone'];?>" placeholder="请输入大标题" />
				<input type="text" name="column5[titletwo]" class="form-control" value="<?php  echo $marketing['column5']['titletwo'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="column5[titlethree]" class="form-control" value="<?php  echo $marketing['column5']['titlethree'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">第六列设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('column6[thumb]',$marketing['column6']['thumb'])?>
				<span class="help-block">第六列图标，建议尺寸：70px * 70px</span>
				<input type="text" name="column6[titleone]" class="form-control" value="<?php  echo $marketing['column6']['titleone'];?>" placeholder="请输入大标题" />
				<input type="text" name="column6[titletwo]" class="form-control" value="<?php  echo $marketing['column6']['titletwo'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="column6[titlethree]" class="form-control" value="<?php  echo $marketing['column6']['titlethree'];?>" placeholder="请输入小标题第二行" />
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