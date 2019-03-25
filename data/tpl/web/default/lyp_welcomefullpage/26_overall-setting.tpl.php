<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<?php  if(defined('SYSTEM_WELCOME_MODULE')) { ?>
	<li<?php  if(empty($op)) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('overall_setting', array('module_type' => 'system_welcome'))?>">域名绑定</a></li>
	<li<?php  if($op == 'menu') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('overall_setting', array('op' => 'menu', 'module_type' => 'system_welcome'))?>">顶部菜单</a></li>
	<li<?php  if($op == 'other') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('overall_setting', array('op' => 'other', 'module_type' => 'system_welcome'))?>">其他</a></li>
	<?php  } else { ?>
	<li<?php  if(empty($op)) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('overall_setting')?>">域名绑定</a></li>
	<li<?php  if($op == 'menu') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('overall_setting', array('op' => 'menu'))?>">顶部菜单</a></li>
	<li<?php  if($op == 'other') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('overall_setting', array('op' => 'other'))?>">其他</a></li>	
	<?php  } ?>
</ul>
<?php  if(empty($op)) { ?>
	<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
	<div class="alert alert-info">
		<p><i class="fa fa-exclamation-circle"></i> 绑定服务器应有独立IP，可以进行域名指向；</p>
		<p><i class="fa fa-exclamation-circle"></i> 独立域名须绑定好域名解析,域名解析已指向当前服务器IP或原域名；</p>
		<p><i class="fa fa-exclamation-circle"></i> 注意:加载处理文件或更新设置需修改系统配置config.php文件,用于保存配置及加载域名处理文件；
		<p><i class="fa fa-exclamation-circle"></i> 如要停用模块请先删除配置<span class="color-red">***域名处理文件加载后才能处理域名绑定功能***</span>,停用或删除域名绑定模块,请点"删除配置"。</p>
	</div>
	<div class="clearfix">
		<form action="" method="post"  class="we7-form" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-2 control-label" style="text-align:left;">绑定域名</label>
				<div class="col-sm-8">
					<input type="text" name="bind_domain" class="form-control" value="<?php  echo $domain;?>" placeholder="请输入要绑定的域名" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" style="text-align:left;"></label>
				<div class="col-sm-8">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
					<input type="submit" name="submit" value="保存并更新配置" class="btn btn-primary">
					<input type="submit" name="delete" value="删除配置" class="btn btn-danger">
				</div>
			</div>
		</form>
	</div>
	<?php  } else { ?>
	<div>
		<span class="text-center">系统首页无需配置</span>
	</div>
	<?php  } ?>
<?php  } ?>
<?php  if($op == 'menu') { ?>
<div class="we7-margin-bottom clearfix">
	<div class="pull-right">
		<a href="#" class="btn btn-primary we7-padding-horizontal" data-toggle="modal" data-target="#balck">添加顶部菜单</a>
	</div>
</div>
<div>
	<div class="alert alert-info">
		<p><i class="wi wi-info-sign"></i>顶部菜单最多支持添加两个。</p>
	</div>
	<table class="table we7-table table-hover site-list">
		<col width="120px"/>
		<col width=""/>
		<col width="90px"/>
		<tr>
			<th class="text-left">菜单名称</th>
			<th class="text-left">菜单链接</th>
			<th class="text-left">操作</th>
		</tr>
		<?php  if(!empty($topmenu)) { ?>
			<?php  if(is_array($topmenu)) { foreach($topmenu as $item) { ?>
			<tr ng-repeat="multi in multis">
				<td class="vertical-middle">
					<span><?php  echo $item['name'];?></span>
				</td>
				<td class="vertical-middle">
					<span><?php  echo $item['link'];?></span>
				</td>
				<td class="text-left">
					<div class="link-group text-left">
						<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
						<a href="<?php  echo $this->createWebUrl('overall_setting', array('op' => 'menudelete', 'menuname' => $item['name']))?>">删除</a>
						<?php  } else { ?>
						<a href="<?php  echo $this->createWebUrl('overall_setting', array('op' => 'menudelete', 'module_type' => 'system_welcome', 'menuname' => $item['name']))?>">删除</a>
						<?php  } ?>
					</div>
				</td>
			</tr>
			<?php  } } ?>
		<?php  } else { ?>
			<tr>
				<td colspan="3" class="text-center">暂无数据</td>
			</tr>
		<?php  } ?>
	</table>
	<div class="modal fade" id="balck" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel6">添加顶部菜单</h4>
				</div>
				<form action="" method="post"  class="we7-form" enctype="multipart/form-data">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
					<div class="modal-body we7-padding">
						<div class="form-group">
							<label class="control-label col-sm-2">菜单名：</label>
							<div class="col-sm-8">
								<input type="text" name="menuname" class="form-control" placeholder="请填写菜单名称">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">对应链接：</label>
							<div class="col-sm-8">
								<input type="text" name="menulink" class="form-control" placeholder="请填写链接">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="menusubmit" value="menusubmit">
						<button type="submit" class="btn btn-primary">确定</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php  } ?>
<?php  if($op == 'other') { ?>
<div class="clearfix">
	<form action="" method="post"  class="we7-form" role="form" enctype="multipart/form-data">
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">网站标题</label>
			<div class="col-sm-8">
				<input type="text" name="other[title]" class="form-control" value="<?php  echo $other['title'];?>" placeholder="请输入网站标题" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">keywords</label>
			<div class="col-sm-8">
				<input type="text" name="other[keywords]" class="form-control" value="<?php  echo $other['keywords'];?>" placeholder="请输入网站关键字" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">description</label>
			<div class="col-sm-8">
				<input type="text" name="other[description]" class="form-control" value="<?php  echo $other['description'];?>" placeholder="请输入网站描述" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">favorite icon</label>
			<div class="col-sm-8">
				<?php  echo tpl_form_field_image('other[favicon]',$other['favicon'], '', array('extras' => array('image'=> ' width="32" ')))?>
				<span class="help-block">favorite icon</span>
			</div>
		</div>
		<?php  if(defined('SYSTEM_WELCOME_MODULE')) { ?>
		<div class="form-group form-inline">
			<label class="control-label col-sm-2">登录页面模板</label>
			<div class="col-sm-8">
				<select name="login_template">
					<option value="blue-star" <?php  if($other['login_template'] == 'blue-star') { ?>selected = "selected"<?php  } ?>>蓝色念想</option>
					<option value="starry-sky" <?php  if($other['login_template'] == 'starry-sky') { ?>selected = "selected"<?php  } ?>>璀璨星空</option>
					<option value="classical" <?php  if($other['login_template'] == 'classical') { ?>selected = "selected"<?php  } ?>>经典复古</option>
					<option value="concise" <?php  if($other['login_template'] == 'concise') { ?>selected = "selected"<?php  } ?>>简约大气</option>
					<option value="thunderstorm" <?php  if($other['login_template'] == 'thunderstorm') { ?>selected = "selected"<?php  } ?>>雷电黑科技</option>
				</select>
			</div>
		</div>
		<div class="form-group form-inline">
			<label class="control-label col-sm-2">注册页面模板</label>
			<div class="col-sm-8">
				<select name="register_template">
					<option value="element" <?php  if($other['register_template'] == 'element') { ?>selected = "selected"<?php  } ?>>墨绿元素</option>
					<option value="starry-sky" <?php  if($other['register_template'] == 'starry-sky') { ?>selected = "selected"<?php  } ?>>璀璨星空</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;">是否直接跳转登录页面</label>
			<div class="col-sm-8 form-control-static">
				<input type="radio" name="tologin" id="status-1" <?php  if($other['tologin'] == 1) { ?> checked="checked"<?php  } ?> value="1">
				<label class="radio-inline" for="status-1">是</label>
				<input type="radio" name="tologin" id="status-0" <?php  if($other['tologin'] == 0) { ?> checked="checked"<?php  } ?> value="0">
				<label class="radio-inline" for="status-0">否</label>
				<span class="help-block">开启后，输入域名将直接跳转到登录页面，否则将进入首页</span>
			</div>
		</div>
		<?php  } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" style="text-align:left;"></label>
			<div class="col-sm-8">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
				<input type="submit" name="othersubmit" value="保存" class="btn btn-primary">
			</div>
		</div>
	</form>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>