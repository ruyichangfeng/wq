<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="clearfix">
	<form action="" method="post" class="we7-form">
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">默认入口</label>
			<div class="col-sm-10 col-lg-9 col-xs-12">
				<?php  if(!empty($menu_entries)) { ?>
					<select class="we7-select" name="default_entry_id">
						<option value="0" <?php  if($default_entry_id == 0) { ?> selected="selected"<?php  } ?>>系统默认</option>
						<?php  if(is_array($menu_entries)) { foreach($menu_entries as $entry) { ?>
						<option value="<?php  echo $entry['eid'];?>" <?php  if($entry['eid'] == $default_entry_id) { ?> selected="selected"<?php  } ?>><?php  echo $entry['title'];?></option>
						<?php  } } ?>
					</select>
				<?php  } else { ?>
					<span class="color-gray">暂无入口</span>
				<?php  } ?>
				<span class="help-block">注意：即使公众平台显示为“未认证”, 但只要【公众号设置】/【账号详情】下【认证情况】显示资质审核通过, 即可认定为认证号.</span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
				<input type="submit" class="btn btn-primary span3" name="submit" value="保存" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>