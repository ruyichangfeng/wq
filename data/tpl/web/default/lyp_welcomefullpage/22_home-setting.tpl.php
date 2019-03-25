<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><a href="javascript:;">首页信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示登录按钮</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="loginclose" id="status-1" <?php  if($home['loginclose'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="loginclose" id="status-0" <?php  if($home['loginclose'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group hidden">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="close" id="status-1" <?php  if($home['close'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="close" id="status-0" <?php  if($home['close'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">LOGO</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('logo',$home['logo'])?>
				<span class="help-block">左上角LOGO及加载时的LOGO，建议尺寸：220px * 50px</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">轮播一设置</label>
			<div class="col-sm-8">
				<input type="text" name="slide1[title]" class="form-control" value="<?php  echo $home['slide1']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="slide1[subtitleone]" class="form-control" value="<?php  echo $home['slide1']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="slide1[subtitletwo]" class="form-control" value="<?php  echo $home['slide1']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">轮播二设置</label>
			<div class="col-sm-8">
				<input type="text" name="slide2[title]" class="form-control" value="<?php  echo $home['slide2']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="slide2[subtitleone]" class="form-control" value="<?php  echo $home['slide2']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="slide2[subtitletwo]" class="form-control" value="<?php  echo $home['slide2']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">轮播三设置</label>
			<div class="col-sm-8">
				<input type="text" name="slide3[title]" class="form-control" value="<?php  echo $home['slide3']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="slide3[subtitleone]" class="form-control" value="<?php  echo $home['slide3']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="slide3[subtitletwo]" class="form-control" value="<?php  echo $home['slide3']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">轮播四设置</label>
			<div class="col-sm-8">
				<input type="text" name="slide4[title]" class="form-control" value="<?php  echo $home['slide4']['title'];?>" placeholder="请输入大标题" />
				<input type="text" name="slide4[subtitleone]" class="form-control" value="<?php  echo $home['slide4']['subtitleone'];?>" placeholder="请输入小标题第一行" />
				<input type="text" name="slide4[subtitletwo]" class="form-control" value="<?php  echo $home['slide4']['subtitletwo'];?>" placeholder="请输入小标题第二行" />
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