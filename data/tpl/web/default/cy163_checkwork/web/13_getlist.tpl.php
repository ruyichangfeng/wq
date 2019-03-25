<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('checkworklist');?>">打卡列表</a></li>
</ul>

<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="cy163_checkwork" />
			<input type="hidden" name="do" value="checkworklist" />
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间筛选</label>
				<div class="col-xs-12 col-sm-2 col-lg-2">
					<?php  echo tpl_form_field_daterange('ftime', $ftime);?>
				</div>
				
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">所属公司</label>
				<div class="col-xs-12 col-sm-2 col-lg-2">
					<select name="companyname" class="form-control">
					<option value="">--选择公司--</option>
					<?php  if(is_array($companys)) { foreach($companys as $row) { ?>
						<option value="<?php  echo $row;?>" <?php  if($_GPC['companyname'] == $row) { ?>selected="selected"<?php  } ?>><?php  echo $row;?></option>
					<?php  } } ?>
					</select>
				</div>
				
				<div class="pull-right col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php  if($ftime) { ?>
<div class="panel panel-info">
	<div class="panel-heading">导出</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="cy163_checkwork" />
			<input type="hidden" name="do" value="export" />
			<input type="hidden" name="startdate" value="<?php  echo $ftime['start'];?>" />
			<input type="hidden" name="enddate" value="<?php  echo $ftime['end'];?>" />
			<input type="hidden" name="companyname" value="<?php  echo $companyname;?>" />
			<div class="form-group">
				<div class="col-xs-12 col-sm-2 col-lg-2">
					<button class="btn btn-success">导出</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php  } ?>

<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:20%;">姓名</th>
					<th style="width:10%;">电话</th>
					<th>打卡时间</th>
					<th style="width:20%;">打卡ip</th>
					<th style="width:5%;">状态</th>
					<th style="width:10%;">上下班</th>	
				</tr>
			</thead>
			<tbody id="main">
				<?php  if(is_array($checkworkList)) { foreach($checkworkList as $row) { ?>
				<tr>
					<td><?php  echo $row['realname'];?><span class="label label-info" style="margin-left:5px;">[<?php  echo $row['department'];?> - <?php  echo $row['position'];?>]</span></td>
					<td><?php  echo $row['phone'];?></td>
					<td><?php  echo $row['ttime'];?></td>
					<td><?php  echo $row['ip'];?></td>
					<td><?php  if($row['type'] == 1) { ?><?php  if($row['issuccess'] == 0) { ?><span class="label label-danger">迟到</span><?php  } else { ?><span class="label label-success">正常</span><?php  } ?><?php  } ?><?php  if($row['type'] == 2) { ?><?php  if($row['issuccess'] == 0) { ?><span class="label label-danger">早退</span><?php  } else { ?><span class="label label-success">正常</span><?php  } ?><?php  } ?></td>
					<td><?php  if($row['type'] == 1) { ?><span class="label label-success">上班</span><?php  } ?><?php  if($row['type'] == 2) { ?><span class="label label-info">下班</span><?php  } ?></td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>