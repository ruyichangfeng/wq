<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		<?php  if(!empty($banner['id'])) { ?>编辑<?php  } else { ?>新增<?php  } ?>直播banner图片
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal" role="form" id="form1" >
			<input type="hidden" name="id" value="<?php  echo $id;?>"> 
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">是否显示</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<label class="radio-inline">
						<input type="radio" name="isshow" value="1"  <?php  if($banner['isshow'] == '1') { ?>checked="true"<?php  } ?>>显示
					</label>
					<label class="radio-inline">
						<input type="radio" name="isshow" value="0"   <?php  if($banner['isshow'] == '0') { ?>checked="true"<?php  } ?>>否
					</label>
					<span class="help-block">是否显示</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">排序</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="text" value="<?php  echo $banner['sort'];?>" class="form-control" name="sort">
					<span class="help-block">数值大的排在前面</span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">banner</label>
				<div class="col-sm-9 col-xs-12">
					<?php  echo tpl_form_field_image("img", $banner['img'])?>
					<div class="help-block"><font style="color: red">最佳尺寸：640 * 320px</font></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">链接</label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="text" value="<?php  echo $banner['url'];?>" class="form-control" name="url">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
				<div class="col-sm-8 col-lg-9 col-xs-12">
					<input type="submit" name="submit" class="btn btn-success" value="提交">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				</div>
			</div>
			
		</form>
	</div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>