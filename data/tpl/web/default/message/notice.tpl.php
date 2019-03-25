<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="we7-page-tab">
	<li <?php  if($do == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo url('message/notice/display');?>">消息列表</a></li>
	<li <?php  if($do == 'setting') { ?>class="active"<?php  } ?>><a href="<?php  echo url('message/notice/setting');?>">消息设置</a></li>
</ul>
<div id="message-notice"  ng-controller="messageNoticeCtrl" ng-cloak>
<?php  if($do == 'display') { ?>
	<div class="btn-group we7-btn-group we7-padding-bottom">
		<a href="<?php  echo url('message/notice')?>" class="btn btn-default <?php  if(empty($type)) { ?> active <?php  } ?>">全部</a>
		
		<a href="<?php  echo url('message/notice', array('type' => MESSAGE_ACCOUNT_EXPIRE_TYPE))?>" class="btn btn-default <?php  if($type == MESSAGE_ACCOUNT_EXPIRE_TYPE) { ?> active <?php  } ?>">到期消息</a>
		
		
		<?php  if($_W['isfounder']) { ?>
		<a href="<?php  echo url('message/notice', array('type' => MESSAGE_REGISTER_TYPE))?>" class="btn btn-default <?php  if($type == MESSAGE_REGISTER_TYPE) { ?> active <?php  } ?>">注册提醒</a>
		<a href="<?php  echo url('message/notice', array('type' => MESSAGE_WORKORDER_TYPE))?>" class="btn btn-default <?php  if($type == MESSAGE_WORKORDER_TYPE) { ?> active <?php  } ?>">工单提醒</a>
		<?php  } ?>
		
		<?php  if(user_is_founder($_W['uid'], true)) { ?>
		<a href="<?php  echo url('message/notice', array('type' => MESSAGE_SYSTEM_UPGRADE))?>" class="btn btn-default <?php  if($type == MESSAGE_SYSTEM_UPGRADE) { ?> active <?php  } ?>">系统更新</a>
		<a href="<?php  echo url('message/notice', array('type' => MESSAGE_OFFICIAL_DYNAMICS))?>" class="btn btn-default <?php  if($type == MESSAGE_OFFICIAL_DYNAMICS) { ?> active <?php  } ?>">官方动态</a>
		<?php  } ?>
	</div>
	<div class="btn-group we7-btn-group we7-padding-bottom" style="float: right;">
		<a href="javascript:;" ng-click="allRead()" class="btn">已读所有消息</a>
	</div>
	<table class="table we7-table table-hover vertical-middle" >
		<col>
		<col>
		<col>
		<tr>
			<th colspan="{{ type==4 ? 4 : 3}}" class="text-left filter">
				<div class="dropdown dropdown-toggle we7-dropdown">
					<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						全部消息
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li><a href="<?php  echo filter_url('is_read:');?>" class="active">全部消息</a></li>
						<li><a href="<?php  echo filter_url('is_read:' . MESSAGE_READ);?>" class="active">已读消息</a></li>
						<li><a href="<?php  echo filter_url('is_read:' . MESSAGE_NOREAD);?>" class="active">未读消息</a></li>
					</ul>
				</div>
			</th>
		</tr>
		<tr>
			<th>标题内容</th>
			<th class="text-center" ng-if="type==4" >来源</th>
			<th class="text-center">时间</th>
			<th class="text-right">操作</th>
		</tr>
		<tr ng-repeat="list in lists">
			<td class="tip-before unread" ng-if ="list.is_read == 1 || list.is_read == 0">{{list.message}} {{type != 4 && list.source ? '(' + list.source + ')' : ''}}</td>
			<td class="tip-before" ng-if ="list.is_read == 2">{{list.message}} {{type != 4 && list.source ? '(' + list.source + ')' : ''}}</td>
			<td class="text-muted text-center" ng-if="type==4" ng-bind = "list.source"></td>
			<td class="text-muted text-center" ng-bind = "list.create_time"></td>
			<td>
				<div class="link-group">
					
					<a ng-href="{{list.url}}" ng-if="list.type==3">进入工单</a>
					<a ng-href="{{list.url}}" ng-if="list.type==2">查看公众号</a>
					<a ng-href="{{list.url}}" ng-if="list.type==5">查看小程序</a>
					<a ng-href="{{list.url}}" ng-if="list.type==6">查看pc</a>
					<a ng-href="{{list.url}}" ng-if="list.type==4 && list.status==1">查看我的待审核用户</a>
					<a ng-href="{{list.url}}" ng-if="list.type==7">查看我的账号</a>
					<a href="javascript:;" ng-if="list.type==10 || list.type==11" ng-click="getOfficialMsg(list.id, list.url)">查看</a>
				</div>
			</td>
		</tr>
	</table>
</div>
<div class="text-right we7-margin-top">
<?php  echo $pager;?>
<?php  } ?>
<?php  if($do == 'setting') { ?>
	<div class="clearfix"></div>
	<div class="table we7-tables we7-padding-bottom">
		<table class="table we7-table table-hover">
			<col width="80px"/>
			<col width="300px"/>
			<col width="100px"/>
			<tr>
				<th>消息类型</th>
				<th>提醒说明</th>
				<th class="text-right">操作</th>
			</tr>
			<?php  if(is_array($setting)) { foreach($setting as $property => $property_info) { ?>
			<tr>
				<th><?php  echo $property_info['title'];?></th>
				<th><?php  echo $property_info['msg'];?></th>
				<th class="text-right">
					<label>
						<div class="switch <?php  if(empty($property_info['status']) || $property_info['status'] == MESSAGE_ENABLE) { ?> switchOn<?php  } ?>" id="key-<?php  echo $property;?>" ng-click="changeStatus('<?php  echo $property;?>', '<?php  echo $property;?>')"></div>
					</label>
				</th>
			</tr>
				<?php  if(is_array($property_info['types'])) { foreach($property_info['types'] as $type => $type_info) { ?>
				<tr>
					<td class="vertical-middle"><?php  echo $type_info['title'];?></td>
					<td><?php  echo $type_info['msg'];?></td>
					<td class="text-right">
						<label>
							<div class="switch <?php  if(empty($type_info['status']) || $type_info['status'] == MESSAGE_ENABLE) { ?> switchOn<?php  } ?>" id="key-<?php  echo $type;?>" ng-click="changeStatus('<?php  echo $property;?>', <?php  echo $type;?>)"></div>
						</label>
					</td>
				</tr>
				<?php  } } ?>
			<?php  } } ?>
		</table>
	</div>
<?php  } ?>
</div>
<script type="text/javascript">
	angular.module('messageApp').value('config', {
		'type' : '<?php  echo $type?>',
		'lists': <?php echo !empty($lists) ? json_encode($lists) : 'null'?>,
		'is_read' : "<?php  echo $is_read;?>",
		'all_read_url' : "<?php  echo url('message/notice/all_read')?>",
		'mark_read_url' : "<?php  echo url('message/notice/read')?>",
	});
	angular.bootstrap($('#message-notice'), ['messageApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>