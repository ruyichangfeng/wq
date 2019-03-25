<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li class="active"><a href="javascript:;">关于信息</a></li>
</ul>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data" id="form1">
		<div class="form-group hidden">
			<label class="col-sm-2 control-label" style="text-align:left;">是否显示</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="close" id="status-1" <?php  if($about['close'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="close" id="status-0" <?php  if($about['close'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-0">否</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">关于一</label>
			<div class="col-sm-8">
				<input type="text" name="about1[category]" class="form-control" value="<?php  echo $about['about1']['category'];?>" placeholder="请输入分类" />
				<input type="text" name="about1[title]" class="form-control" value="<?php  echo $about['about1']['title'];?>" placeholder="请输入标题" />
				<input type="text" name="about1[content]" class="form-control" value="<?php  echo $about['about1']['content'];?>" placeholder="请输入内容" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">关于二</label>
			<div class="col-sm-8">
				<input type="text" name="about2[category]" class="form-control" value="<?php  echo $about['about2']['category'];?>" placeholder="请输入分类" />
				<input type="text" name="about2[title]" class="form-control" value="<?php  echo $about['about2']['title'];?>" placeholder="请输入标题" />
				<input type="text" name="about2[content]" class="form-control" value="<?php  echo $about['about2']['content'];?>" placeholder="请输入内容" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">关于三</label>
			<div class="col-sm-8">
				<input type="text" name="about3[category]" class="form-control" value="<?php  echo $about['about3']['category'];?>" placeholder="请输入分类" />
				<input type="text" name="about3[title]" class="form-control" value="<?php  echo $about['about3']['title'];?>" placeholder="请输入标题" />
				<input type="text" name="about3[content]" class="form-control" value="<?php  echo $about['about3']['content'];?>" placeholder="请输入内容" />
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