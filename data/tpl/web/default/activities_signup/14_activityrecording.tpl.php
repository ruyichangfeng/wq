<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">
			<h3>报名记录</h3>
		</div>
	</div>
	<div class="panel-body table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>活动id</th>
					<th>活动名称</th>
					<th>地点</th>
					<th>活动详情</th>
					<th>照片</th>
					<th>开始时间</th>
					<th>结束时间</th>					
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($res)) { foreach($res as $key => $item) { ?>
					<tr>
						<td><?php  echo $item['id'];?></td>
						<td><?php  echo $item['title'];?></td>
						<td><?php  echo $item['place'];?></td>
						<td><?php  echo html_entity_decode($item['detail']);?></td>
						<td><img style="width: 50px;height: 50px" src="<?php  echo tomedia($item['thumb']);?>" ></td>
						<td><?php  echo $item['start_time'];?></td>
						<td><?php  echo $item['end_time'];?></td>
					</tr>
				<?php  } } ?>
			</tbody>
		</table>
	</div>
</div>

<div><?php  
    global $_GPC;
	$page = $_GPC['page'];
	
	$result = pdo_fetchall("SELECT * FROM " .tablename('activities_recording')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));

	$total = count($result);
	echo $pagination = pagination($total ,$page, 5);
	?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>