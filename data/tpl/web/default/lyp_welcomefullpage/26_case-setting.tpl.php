<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><a href="javascript:;">案例信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data">
		<div class="form-group hidden">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="close" id="status-1" <?php  if($case['close'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="close" id="status-0" <?php  if($case['close'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">顶部菜单标题</label>
			<div class="col-sm-8">
				<input type="text" name="title" class="form-control" value="<?php  echo $case['title'];?>" placeholder="请输入顶部菜单标题" />
				<span class="help-block">顶部菜单标题，不更改默认为“案例”</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面英文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[en_title]" class="form-control" value="<?php  echo $case['pagetitle']['en_title'];?>" placeholder="请输入页面英文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">页面中文标题</label>
			<div class="col-sm-8">
				<input type="text" name="pagetitle[ch_title]" class="form-control" value="<?php  echo $case['pagetitle']['ch_title'];?>" placeholder="请输入页面中文标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">背景图片</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('backgroundimg',$case['backgroundimg'])?>
				<span class="help-block">页面加载时显示的背景图，建议尺寸：1920px * 1080px</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">案例一设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('case1[thumb]',$case['case1']['thumb'])?>
				<span class="help-block">建议尺寸：340px * 200px</span>
				<input type="text" name="case1[category]" class="form-control we7-margin-top" value="<?php  echo $case['case1']['category'];?>" placeholder="请输入案例分类" />
				<input type="text" name="case1[title]" class="form-control" value="<?php  echo $case['case1']['title'];?>" placeholder="请输入案例标题" />
				<input type="text" name="case1[description]" class="form-control" value="<?php  echo $case['case1']['description'];?>" placeholder="请输入案例简述" />
				<input type="text" name="case1[link]" class="form-control" value="<?php  echo $case['case1']['link'];?>" placeholder="请输入案例链接" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">案例二设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('case2[thumb]',$case['case2']['thumb'])?>
				<span class="help-block">建议尺寸：340px * 200px</span>
				<input type="text" name="case2[category]" class="form-control we7-margin-top" value="<?php  echo $case['case2']['category'];?>" placeholder="请输入案例分类" />
				<input type="text" name="case2[title]" class="form-control" value="<?php  echo $case['case2']['title'];?>" placeholder="请输入案例标题" />
				<input type="text" name="case2[description]" class="form-control" value="<?php  echo $case['case2']['description'];?>" placeholder="请输入案例简述" />
				<input type="text" name="case2[link]" class="form-control" value="<?php  echo $case['case2']['link'];?>" placeholder="请输入案例链接" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">案例三设置</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('case3[thumb]',$case['case3']['thumb'])?>
				<span class="help-block">建议尺寸：340px * 200px</span>
				<input type="text" name="case3[category]" class="form-control we7-margin-top" value="<?php  echo $case['case3']['category'];?>" placeholder="请输入案例分类" />
				<input type="text" name="case3[title]" class="form-control" value="<?php  echo $case['case3']['title'];?>" placeholder="请输入案例标题" />
				<input type="text" name="case3[description]" class="form-control" value="<?php  echo $case['case3']['description'];?>" placeholder="请输入案例简述" />
				<input type="text" name="case3[link]" class="form-control" value="<?php  echo $case['case3']['link'];?>" placeholder="请输入案例链接" />
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