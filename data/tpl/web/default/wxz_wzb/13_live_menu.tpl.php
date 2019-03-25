<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading" style="position:relative;">
				<span>直播栏目管理</span>		<span style="position:absolute;right:10px;top:3px;">			<a href="<?php  echo $this->createWebUrl('live_type',array('rid'=>$rid))?>" class="btn btn-default">				新增栏目			</a>		</span>
	</div>
	<div class="panel-body">
		<table  class="table table-striped">
			<thead>
				<tr>
					<th style="width:10%;">排序</th>
					<th style="width:30%;">名称</th>
					<th style="width:20%;">类型</th>
					<th style="width:20%;">状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php  if(is_array($menus)) { foreach($menus as $row) { ?>
				<tr>
					<td>
						<?php  echo $row['sort'];?>
					</td>
					<td>
						<?php  echo $row['name'];?>
					</td>
					<td>
						<?php  echo $row['type'];?>
					</td>
					<td>
						<?php  if($row['isshow']=='1') { ?>显示<?php  } else { ?>隐藏<?php  } ?>
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="编辑" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'id'=>$row['id']))?>">
							<i class="fa fa-gear"></i>
						</a>
						<a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('live_del',array('rid'=>$rid,'id'=>$row['id']))?>" onclick="return confirm('删除将无法恢复，确认吗？');return false;">
							<i class="fa fa-times"></i>
						</a>
					</td>
				</tr>
			<?php  } } ?>
			</tbody>
		</table>
		
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>