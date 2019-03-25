<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
.editable-click, a.editable-click {
    color: #000 !important;
    border-bottom:none !important;
    text-decoration: none;
}
.editable-input.editable-has-buttons {
    width: auto;
    max-width: 100px;
}
.st-sort-ascent:before {
    content: '\25B2';
}
</style>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading" style='position:relative;'>
		<span>消息提醒</span>
		
		<span style="position:absolute;right:10px;top:3px;">
			
			<a href="<?php  echo $this->createWebUrl('notice',array('rid'=>$rid))?>" class="btn btn-default">新增消息提醒</a>
		</span>
	</div>
	
	<div class="panel-footer">

</div>
	
	<div class="panel-body">
		<table  class="table table-striped">
			<thead>
				<tr>
					<th style="width:30%;">通知类型</th>
					<th style="width:30%;">通知时间</th>
					<th style="width:15%;">状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php  if(is_array($banner)) { foreach($banner as $row) { ?>
				<tr>
					<td>
						<?php  if($row['type']==1) { ?>
							全部粉丝
						<?php  } else { ?>
							直播间粉丝
						<?php  } ?>
					</td>
					<td>
					<?php  if($row['timeType']==1) { ?>
							即时
					<?php  } else { ?>
						<?php  echo date('Y-m-d H:i:s',$row['timer'])?>
					<?php  } ?>

					</td>
					<td>
						<?php  echo date('Y-m-d H:i:s',$row['dateline']);?>
					</td>
					<td>
						<a class="btn btn-default" title="查看" href="<?php  echo $this->createWebUrl('noticelog',array('id'=>$row['id'],'rid'=>$row['rid']))?>">
							查看
						</a>
						<?php  if($row['os']==2 && $row['status']==0) { ?><a class="btn btn-default" title="开始推送" href="<?php  echo $this->createWebUrl('wsend',array('id'=>$row['id'],'rid'=>$row['rid']))?>">
							开始推送
						</a><?php  } ?>
						<a class="btn btn-default" title="编辑" href="<?php  echo $this->createWebUrl('notice',array('id'=>$row['id'],'rid'=>$row['rid']))?>">
							<i class="fa fa-gear"></i>
						</a>
						<a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('noticedel',array('id'=>$row['id'],'rid'=>$row['rid']))?>" onclick="return confirm('确认吗？');return false;">
							<i class="fa fa-times"></i>
						</a>
					</td>
				</tr>
			<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>