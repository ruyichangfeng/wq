<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">
	素材定时群发
</div>
<ul class="we7-page-tab">
	<li <?php  if($_GPC['a'] == 'mass'  && $do == 'list') { ?>class="active"<?php  } ?>>
		<a href="<?php  echo url('platform/mass/')?>" >素材定时群发</a>
	</li>
	<li <?php  if($_GPC['a'] == 'mass' && $do == 'send') { ?>class="active"<?php  } ?>>
		<a href="<?php  echo url('platform/mass/send')?>">群发记录</a>
	</li>
</ul>
<div class="mass-send" id="js-mass-send" ng-controller="MassSend" ng-cloak>
	<table class="table we7-table table-hover vertical-middle">
		<col />
		<tr>
			<th>消息类型</th>
			<th>接收用户组</th>
			<th>预计发送时间</th>
			<th>发送人数</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php  if(is_array($lists)) { foreach($lists as $list) { ?>
		<tr>
			<td>
				<a href="<?php  echo url('platform/material/list', array('type' => $list['msgtype'], 'id' => $list['attach_id']));?>" target="_blank">
					<?php  echo $types[$list['msgtype']];?>
				</a>
			</td>
			<td><?php  echo $list['groupname'];?></td>
			<td><?php  echo date('Y-m-d H:i', $list['sendtime']);?></td>
			<td><?php  if($list['group'] == '-1') { ?>全部粉丝<?php  } else { ?><?php  echo $list['fansnum'];?><?php  } ?></td>
			<td>
				<?php  if(!$list['status']) { ?>
					<span class="label label-success">已发送</span>
				<?php  } else if($list['status'] == 1) { ?>
					<span class="label label-warning">未发送</span>
				<?php  } else if($list['status'] == 2) { ?>
					<span class="label label-danger">发送失败</span>
				<?php  } ?>
			</td>
			<td>
				<?php  if($list['type'] == 1) { ?>
					<?php  if(!$list['cron_id'] && $list['sendtime'] > TIMESTAMP) { ?>
					<a href="<?php  echo url('platform/mass/cron', array('id' => $list['id']));?>" class="btn btn-danger btn-sm">同步到云服务</a>
					<?php  } ?>
					<a href="<?php  echo url('platform/mass/post', array('id' => $list['id']));?>" data-toggle="tooltip" data-placement="bottom">编辑</a>
					<a href="<?php  echo url('platform/mass/del', array('id' => $list['id']));?>" data-toggle="tooltip" data-placement="bottom">删除</a>
				<?php  } ?>
			</td>
		</tr>
		<?php  } } ?>
	</table>
	<div class="text-right">
		<?php  echo $pager;?>
	</div>
</div>
<script>
	angular.module('massApp').value('config', {
		logUrl: "<?php  echo url('cron/manager/log');?>"
	});
	angular.bootstrap($('#js-mass-send'), ['massApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>