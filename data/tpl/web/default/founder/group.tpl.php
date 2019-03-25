<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">用户权限组管理</div>
<ul class="we7-page-tab">
	<li <?php  if($action == 'display') { ?> class="active"<?php  } ?>><a href="<?php  echo url('founder/display');?>">副创始人管理</a></li>
	<li <?php  if($action == 'group') { ?> class="active"<?php  } ?>><a href="<?php  echo url('founder/foundergroup');?>">副创始人权限组</a></li>
</ul>
<div class="clearfix we7-margin-bottom">
	<form action="" method="get">
		<div class="input-group pull-left col-sm-4">
			<input type="hidden" name="c" value="founder">
			<input type="hidden" name="a" value="group">
			<input type="text" name="name" id="" value="<?php  echo $_GPC['name'];?>" class="form-control" placeholder="搜索副创始人权限组"/>
			<span class="input-group-btn"><button class="btn btn-default"><i class="fa fa-search"></i></button></span>
		</div>
	</form>
	<div class="pull-right">
		<a href="<?php  echo url('founder/group/post')?>" class="btn btn-primary">+添加副创始人组</a>
	</div>
</div>
<table class="table we7-table table-hover" id="js-vice-group-display" ng-controller="ViceGroupDisplay" ng-cloak>
	<col width="120px"/>
	<col width="100px"/>
	<col width="120px"/>
	<col width="120px"/>
	<col width="100px"/>
	<col/>
	<tr>
		<th class="text-left">创始人组</th>
		<th>有限期</th>
		<th>可创建公众号</th>
		<th>可创建小程序</th>
		<th>应用权限套餐</th>
		<th>可用应用</th>
		<th>可用小程序应用</th>
		<th class="text-right">操作</th>
	</tr>
	<tr ng-repeat="list in lists">
		<td class="text-left" ng-bind="list.name"></td>
		<td><span ng-if="list.timelimit != 0" ng-bind="list.timelimit+'天'"></span><span ng-if="list.timelimit == 0">永久有效</span></td>
		<td><span ng-if="list.maxaccount == 0">无权限</span><span ng-if="list.maxaccount != 0" ng-bind="list.maxaccount"></span></td>
		<td><span ng-if="list.maxwxapp == 0">无权限</span><span ng-if="list.maxwxapp != 0" ng-bind="list.maxwxapp"></span></td>
		<td>
			<span ng-if="list.module_nums == -1">全部</span>
			<span ng-if="list.package != 'N;'" class="color-default" ng-bind="list.packages"></span>
			<span ng-if="list.package == 'N;'">无</span>
		</td>
		<td>
			<span ng-if="list.module_nums == -1">全部</span>
			<span ng-if="list.module_nums != -1" ng-bind="list.module_nums"></span>
		</td>
		<td>
			<span ng-if="list.wxapp_nums == -1">全部</span>
			<span ng-if="list.wxapp_nums != -1" ng-bind="list.wxapp_nums"></span>
		</td>
		<td>
			<div class="link-group">
				<a href="javascript:;" ng-click="editGroup(list.id)">编辑</a>
				<a href="javascript:;" ng-click="delGroup(list.id)" class="del">删除</a>
			</div>
		</td>
	</tr>
</table>
<script>
	angular.module('userGroup').value('config', {
		lists: <?php echo !empty($lists) ? json_encode($lists) : 'null'?>,
		links: {
			groupPost: "<?php  echo url('founder/group/post')?>",
			groupDel: "<?php  echo url('founder/group/del')?>",
		}
	});
	angular.bootstrap($('#js-vice-group-display'), ['userGroup']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>