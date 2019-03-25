<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('account/account-header', TEMPLATE_INCLUDEPATH)) : (include template('account/account-header', TEMPLATE_INCLUDEPATH));?>
<div id="js-account-manage-modules-tpl" ng-controller="AccountMangeModulesTpl" ng-cloak>
	<div class="alert alert-info">
		<p><i class="fa fa-exclamation-circle"></i> 无主管理员时，创始人为默认主管理员，<?php  echo $account->typeName?>拥有所有权限</p>
	</div>

	<?php  if(!in_array($owner['uid'], $founders)) { ?>
	<table class="table we7-table table-hover" >
		<col />
		<col />
		<col />
		<col />
		<col />
		<col width="120px"/>
		<tr>
			<th colspan="5" class="text-left">
				<span class="we7-padding-right">会员权限组： {{owner.group.name}}</span>
				<span></span>
			</th>
			
			
				<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_FOUNDER && !in_array($owner['uid'], $founders)) { ?>
				<th class="text-right"><a href="<?php  echo url('user/edit/edit_modules_tpl',array('uid'=>$owner['uid']))?>" class="color-default">修改</a></th>
				<?php  } else { ?>
				<th class="text-right"><a href="" class="color-default"></a></th>
				<?php  } ?>
			

		</tr>
		<tbody ng-repeat="module_tpl in modules_tpl | filter:{'type':'default'}">
			<tr>
				<td colspan="5" class="text-left we7-padding-right" ng-init="module_tpl.show = true">
					<span>{{module_tpl.name}}</span>
				</td>
				<td>
					<div class="link-group">
						<a href="javascript:;" class="color-default" ng-show="module_tpl.show" ng-click="module_tpl.show = false">收起</a>
						<a href="javascript:;" class="color-default" ng-show="!module_tpl.show" ng-click="module_tpl.show = true">展开</a>
						<!--<a href="javascript:;" class="color-default">删除</a>-->
					</div>
				</td><!--默认展开-->
			</tr>
			<tr ng-show="module_tpl.show">
				<td colspan="5">
					<div class="col-sm-1 color-gray text-left we7-padding-none"><?php  echo $account->typeName?>应用</div>
					<div class="col-sm-11">
						<div class="col-sm-3 text-left we7-margin-bottom" 
						<?php  if($account->typeSign == ACCOUNT_TYPE_SIGN) { ?> ng-repeat="module in module_tpl.modules" 
						<?php  } else if($account->typeSign == WXAPP_TYPE_SIGN) { ?> ng-repeat="module in module_tpl.wxapp"
						<?php  } else if($account->typeSign == WEBAPP_TYPE_SIGN) { ?> ng-repeat="module in module_tpl.webapp"
						<?php  } else if($account->typeSign == PHONEAPP_TYPE_SIGN) { ?> ng-repeat="module in module_tpl.phoneapp"
						<?php  } else if($account->typeSign == XZAPP_TYPE_SIGN) { ?> ng-repeat="module in module_tpl.xzapp"
						<?php  } else if($account->typeSign == ALIAPP_TYPE_SIGN) { ?> ng-repeat="module in module_tpl.aliapp"
						<?php  } ?> >
							<div ng-if="module.name != 'all'" class="text-over text-left">
								<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
								{{ module.title }}
							</div>
							<label class="label label-info" ng-if="module.name == 'all'">所有模块</label>
						</div>
					</div>
				</td>
				<td class="we7-padding-right color-default"></td>
			</tr>
			<?php  if($account->typeSign == ACCOUNT_TYPE_SIGN) { ?>
			<tr ng-show="module_tpl.show">
				<td colspan="5">
					<div class="col-sm-1 color-gray text-left we7-padding-none">模板</div>
					<div class="col-sm-11">
						<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="tpl in module_tpl.templates">
							<a href="javascript:;" class="label label-info" ng-bind="tpl.title"></a>
						</div>
					</div>
				</td>
				<td class="we7-padding-right color-default"></td>
			</tr>
			<?php  } ?>
		</tbody>
	</table>
	<table class="table we7-table table-hover">
		<tr>
			<th colspan="5" class="text-left">
				<span class="we7-padding-right">应用权限组</span>
				<span></span>
			</th>
			
			
				<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_FOUNDER && !in_array($owner['uid'], $founders)) { ?>
				<th class="text-right"><a class="color-default" data-toggle="modal" data-target="#change-group">修改</a></th>
				<?php  } ?>
			
		</tr>
		<tbody ng-repeat="module_tpl in modules_tpl | filter:{'type':'extend'}">
			<tr>
				<td colspan="5" class="text-left we7-padding-right" ng-init="module_tpl.show = true">
					<span>{{module_tpl.name}}</span>
				</td>
				<td>
					<div class="link-group">
						<a href="javascript:;" class="color-default" ng-show="module_tpl.show" ng-click="module_tpl.show = false">收起</a>
						<a href="javascript:;" class="color-default" ng-show="!module_tpl.show" ng-click="module_tpl.show = true">展开</a>
					</div>
				</td><!--默认展开-->
			</tr>
			<tr ng-show="module_tpl.show">
				<td colspan="5">
					<div class="col-sm-1 color-gray text-left we7-padding-none"><?php  echo $account->typeName?>应用</div>
					<div class="col-sm-11">
						<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in module_tpl.modules">
							<div ng-if="module.name != 'all'" class="text-over text-left">
								<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
								{{ module.title }}
							</div>
							<label class="label label-info" ng-if="module.name == 'all'">所有模块</label>
						</div>
					</div>
				</td>
				<td class="we7-padding-right color-default"></td>
			</tr>
			<?php  if($account->typeSign == ACCOUNT_TYPE_SIGN) { ?>
			<tr ng-show="module_tpl.show">
				<td colspan="5">
					<div class="col-sm-1 color-gray text-left we7-padding-none">模板</div>
					<div class="col-sm-11">
						<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="tpl in module_tpl.templates">
							<a href="javascript:;" class="label label-info" ng-bind="tpl.title"></a>
						</div>
					</div>
				</td>
				<td class="we7-padding-right color-default"></td>
			</tr>
			<?php  } ?>
		</tbody>
	</table>
	<table class="table we7-table table-hover account-package-extra">
		<tr>
			<th colspan="5" class="text-left">
				<span class="we7-padding-right">附加权限</span>
				<span></span>
			</th>
			
			
				<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_FOUNDER && !in_array($owner['uid'], $founders)) { ?>
				<th class="text-right"><a class="color-default" data-toggle="modal" data-target="#jurisdiction-add">修改</a></th>
				<?php  } ?>
			
		</tr>
		<?php  if(!in_array($owner['uid'], $founders)) { ?>
		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none"><?php  echo $account->typeName?>应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.modules" ng-if="extend.modules">
						<div ng-if="module.name != 'all'" class="text-over text-left">
							<img ng-src="{{ module.logo }}" alt="" style="width:50px;height:50px;">
							{{ module.title }}
						</div>
						<label class="label label-info" ng-if="module.name == 'all'">所有模块</label>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
		<?php  if($account->typeSign == ACCOUNT_TYPE_SIGN) { ?>
		<tr>
			<td colspan="6">
				<div class="col-sm-1 color-gray text-left we7-padding-none">模板</div>
				<div class="col-sm-11 js-extra-templates">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.templates" ng-if="extend.templates">
						<a href="javascript:;" class="label label-info" ng-bind="module.title"></a>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.templates">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
		<?php  } ?>
		<?php  } ?>
	</table>
	<?php  } ?>

	

	<div  class="uploader-modal modal fade module" id="jurisdiction-add">
		<div class="modal-dialog modal-lg">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel2">选择</h4>
				</div>
				<div class="modal-body material-content clearfix">
					<div class="material-nav">
						<a href="javascript:;" ng-click="tabChange(0)"  ng-class="{true:'active',false:''}[jurindex==0]" >应用</a>
						<?php  if($account->typeSign == ACCOUNT_TYPE_SIGN) { ?><a href="javascript:;" ng-click="tabChange(1)" ng-class="{true:'active',false:''}[jurindex==1]">模板</a><?php  } ?>
					</div>
					<div class="material-body" ng-show="jurindex==0" id="content-modules">
						<div class="row">
							<?php  if(is_array($modules)) { foreach($modules as $module_name => $module) { ?>
							<?php  if(empty($module['issystem']) && $module[$account->typeSign . '_support'] == 2) { ?>
							<div class="col-sm-2">
								<div class="item <?php  if(is_array($current_module_names) && in_array($module_name, $current_module_names)) { ?>active<?php  } ?>"
								     data-title="<?php  echo $module['title'];?>"
								     data-name="<?php  echo $module['name'];?>"
								     ng-click="itemclick()"
								     onclick="$(this).toggleClass('active')">
									<img ng-src="<?php  echo $module['logo'];?>" alt="" class="icon"/>
									<div class="name"><?php  echo $module['title'];?></div>
									<div class="mask">
										<span class="wi wi-right"></span>
									</div>
								</div>
							</div>
							<?php  } ?>
							<?php  } } ?>
						</div>
					</div>
					<?php  if($account->typeSign == ACCOUNT_TYPE_SIGN) { ?>
					<div class="material-body" ng-show="jurindex==1" id="content-templates">
						<div class="row">
							<?php  if(is_array($templates)) { foreach($templates as $temp) { ?>
							<div class="col-sm-2">
								<div  ng-click="itemclick()" class="item <?php  if(is_array($extend['templates']) && in_array($temp, $extend['templates'])) { ?>active<?php  } ?>" data-title="<?php  echo $temp['title'];?>" data-name="<?php  echo $temp['name'];?>" data-id="<?php  echo $temp['id'];?>" onclick="$(this).toggleClass('active')">
									<i class="wi wi-home" style="color: #ddd;font-size: 48px;position:relative; top:-15px; margin: 0;"></i>
									<div class="name"><?php  echo $temp['title'];?></div>
									<div class="mask">
										<span class="wi wi-right"></span>
									</div>
								</div>
							</div>
							<?php  } } ?>
						</div>
					</div>
					<?php  } ?>
				</div>
				<div class="material-pager text-right clearfix">
					<div class="pull-left we7-form">
						<input type="checkbox" id="selected-all" ng-model="allmodule" ng-change="allmodulechange(allmodule)">
						<label for="selected-all">全选</label>
					</div>
					<ul class="pagination">

					</ul>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="addExtend()">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="change-group">
		<div class="modal-dialog we7-modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</div>
				<div class="modal-body">
					<div class="tab-content we7-form">
						<table class="table we7-table table-hover">
							<tr>
								<th class="text-left bg-light-gray">应用权限组（各权限组均包含系统模块和微站默认模板）</th>
								<th class="text-right bg-light-gray">操作</th>
							</tr>
							<?php  if(permission_check_account_user('see_account_manage_module_tpl_all_permission')) { ?>
							<tr>
								<td class="text-left">
									<input id="check-0" type="checkbox" name="package[]" autocomplete="off" value="-1" <?php  if(is_array($owner['group']['package']) && in_array('-1', $owner['group']['package'])) { ?>checked disabled<?php  } ?><?php  if(is_array($extendpackage) && !empty($extendpackage['-1'])) { ?>checked <?php  } ?> />
									<label for="check-0" class="we7-padding-left we7-margin-horizontal-none">所有服务</label>
								</td>
								<td class="text-left">
									<div class="link-group">
										<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#extend0" ng-click="changeText($event)">展开</a>
									</div>
								</td>
							</tr>
							<tr class="collapse bg-light-gray" aria-expanded="true" id="extend0">
								<td colspan="2">
									<div class="col-sm-2 color-gray text-left we7-padding-none">应用权限</div>
									<div class="col-sm-10">
										<div class="col-sm-3 text-left">
											<span class="label label-danger">系统所有模块</span>
										</div>
									</div>
									<div class="col-sm-2 color-gray text-left we7-padding-none">模板权限</div>
									<div class="col-sm-10">
										<div class="col-sm-3 text-left">
											<span class="label label-danger">系统所有模板</span>
										</div>
									</div>
								</td>
							</tr>
							<?php  } ?>
							<?php  if(is_array($uni_groups)) { foreach($uni_groups as $package) { ?>
								<?php  if(!(is_array($owner['group']['package']) && in_array($package['id'], $owner['group']['package']))) { ?>
								<tr>
									<td class="text-left">
										<input id="check-<?php  echo $package['id'];?>" type="checkbox" name="package[]" autocomplete="off" <?php  if(is_array($owner['group']['package']) && in_array($package['id'], $owner['group']['package'])) { ?>checked disabled<?php  } ?> <?php  if(is_array($extendpackage) && !empty($extendpackage[$package['id']])) { ?>checked <?php  } ?> value="<?php  echo $package['id'];?>" />
										<label for="check-<?php  echo $package['id'];?>" class="we7-padding-left we7-margin-horizontal-none"><?php  echo $package['name'];?></label>
									</td>
									<td>
										<div class="link-group">
											<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#extend<?php  echo $package['id'];?>" ng-click="changeText($event)">展开</a>
										</div>
									</td>
								</tr>
								<tr class="collapse bg-light-gray" aria-expanded="true" id="extend<?php  echo $package['id'];?>">
									<td colspan="2">
										<div>
											<div class="col-sm-2 color-gray text-left we7-padding-none">应用权限</div>
											<div class="col-sm-10">
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info">系统模块</a>
												</div>
												<?php  if(is_array($package['modules'])) { foreach($package['modules'] as $module) { ?>
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info"><?php  echo $module['title'];?></a>
												</div>
												<?php  } } ?>
											</div>
										</div>
										<div>
											<div class="col-sm-2 color-gray text-left we7-padding-none">模板权限</div>
											<div class="col-sm-10">
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info">微站默认模板</a>
												</div>
												<?php  if(is_array($package['templates'])) { foreach($package['templates'] as $template) { ?>
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info"><?php  echo $template['title'];?></a>
												</div>
												<?php  } } ?>
											</div>
										</div>
									</td>
								</tr>
								<?php  } ?>
							<?php  } } ?>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="changeGroup()">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

</div>
<script>
	angular.module('accountApp').value('config', {
		owner: <?php echo !empty($owner) ? json_encode($owner) : 'null'?>,
		
		modules_tpl: <?php echo !empty($modules_tpl) ? json_encode($modules_tpl) : 'null'?>,
		extend: <?php echo !empty($extend) ? json_encode($extend) : 'null'?>,
		links: {
			postModulesTpl: "<?php  echo url('account/post/modules_tpl', array('acid' => $acid, 'uniacid' => $uniacid))?>",
		},
	});
	angular.bootstrap($('#js-account-manage-modules-tpl'), ['accountApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>