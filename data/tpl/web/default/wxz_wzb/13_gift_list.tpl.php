<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
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
<div class="panel panel-default">
	<div class="panel-heading" style='position:relative;'>
		<span>礼物列表</span>		
		<span style="position:absolute;right:10px;top:3px;">			
			<a href="<?php  echo $this->createWebUrl('gift_edit',array('rid'=>$rid))?>" class="btn btn-default">新增礼物</a>
		</span>
	</div>	

	<div class="panel-body">
		<table  class="table table-striped">
			<thead>
				<tr>
					<th style="width:10%;">排序</th>
					<th style="width:10%;">礼物名称</th>
					<th style="width:20%;">礼物图片</th>
					<th style="width:10%;">价格</th>
					<th style="width:10%;">是否显示</th>
					<th style="width:10%;">日期</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php  if(is_array($gift)) { foreach($gift as $row) { ?>
				<tr>
					<td>
						<?php  echo $row['sort'];?>
					</td>
					<td>
						<?php  echo $row['name'];?>
					</td>
					<td>
						<img src="<?php  echo tomedia($row['pic'])?>" style="width:80px;">
					</td>
					<td>
						<?php  echo $row['amount']/100?>元
					</td>
					<td>
						<?php  if($row['isshow']==1) { ?>
							显示
						<?php  } else { ?>
							不显示
						<?php  } ?>	
					</td>
					<td>
						<?php  echo date('Y-m-d H:i:s',$row['dateline'])?>
					</td>
					<td>
						<a class="btn btn-default" title="编辑" href="<?php  echo $this->createWebUrl('gift_edit',array('id'=>$row['id'],'rid'=>$row['rid']))?>">
							<i class="fa fa-gear"></i>
						</a>
						<a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('gift_del',array('id'=>$row['id']))?>" onclick="return confirm('确认吗？');return false;">
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