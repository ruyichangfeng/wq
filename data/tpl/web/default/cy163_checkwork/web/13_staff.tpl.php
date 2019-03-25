<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<?php  if($type == 2) { ?>
<div class="main">
	<?php  if($type == 2) { ?>
	<form action="<?php  echo $this->createWebUrl('staff',array('op'=>'update'));?>" method="post" class="form-horizontal form">
		<div class="panel panel-default">
			<div class="panel-heading">修改员工信息</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">真实姓名</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="realname" class="form-control" value="<?php  echo $staffinfo['realname'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">联系方式</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="phone" class="form-control" value="<?php  echo $staffinfo['phone'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">所属公司</label>
					<div class="col-sm-7 col-xs-12">
						<select name="companyname" class="form-control">
							<?php  if(is_array($companys)) { foreach($companys as $row) { ?>
								<option value="<?php  echo $row;?>" <?php  if($staffinfo['companyname'] == $row) { ?>selected="selected"<?php  } ?>><?php  echo $row;?></option>
							<?php  } } ?>
						</select>		
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">所属部门</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="department" class="form-control" value="<?php  echo $staffinfo['department'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">职位</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="position" class="form-control" value="<?php  echo $staffinfo['position'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
					<div class="col-sm-7 col-xs-12">
						<label for="enabled3" class="radio-inline"><input type="radio" name="status" id="enabled3" value="1" <?php  if($staffinfo['status'] == 1) { ?>checked="true"<?php  } ?>> 已审核</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled4" class="radio-inline"><input type="radio" name="status" id="enabled4" value="0" <?php  if($staffinfo['status'] == 0) { ?>checked="true"<?php  } ?>> 未审核</label>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<input type="hidden" name="id" value="<?php  echo $staffinfo['id'];?>" />
						<input name="submit" type="submit" value="修改" class="btn btn-primary span3"> 
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php  } ?>
</div>
<?php  } else { ?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('staff');?>">员工管理</a></li>
</ul>

<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="cy163_checkwork" />
			<input type="hidden" name="do" value="staff" />
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">所属公司</label>
				<div class="col-sm-9 col-md-8 col-lg-8 col-xs-12">
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

<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:5%;" class="row-first">选择</td>
					<th>头像</th>
					<th style="width:10%;">姓名</th>
					<th style="width:20%;">联系方式</th>
					<th style="width:20%;">部门职位</th>
					<th style="width:10%;">状态</th>	
					<th style="width:15%;">操作</th>
				</tr>
			</thead>
			<form action="<?php  echo $this->createWebUrl('shenhe');?>" method="post">
			<tbody id="main">
				<?php  if(is_array($staffList)) { foreach($staffList as $row) { ?>
				<tr>
					<td><input type="checkbox" class="checkbox" name="id[]" value="<?php  echo $row['id'];?>" <?php  if($row['status'] == -1) { ?>disabled<?php  } ?> /></td>
					<td><img <?php  if($row['avtar'] == '') { ?>src="<?php  echo $_W['siteroot'];?>/addons/cy163_checkwork/static/defaultthumb.jpg"<?php  } else { ?>src="<?php  echo $row['avtar'];?>"<?php  } ?> style="width:50px;height:50px;border-radius:50px;" /></td>
					<td><?php  echo $row['realname'];?></td>
					<td><?php  echo $row['phone'];?></td>
					<td><?php  echo $row['department'];?> - <?php  echo $row['position'];?></td>
					<td><?php  if($row['status'] == 1) { ?><span class="label label-success">已审核</span><?php  } ?><?php  if($row['status'] == 0) { ?><span class="label label-warning">未审核</span><?php  } ?><?php  if($row['status'] == -1) { ?><span class="label label-danger">已解除</span><?php  } ?></td>				
					<td style="white-space:normal;word-break:break-all">
						<?php  if($row['status'] != -1) { ?>
						<a href="<?php  echo $this->CreateWebUrl('staff',array('id'=>$row['id'],'type'=>2))?>"><div class="btn btn-info">修改</div></a>
						<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->CreateWebUrl('staff',array('op'=>'del','id'=>$row['id']))?>"><div class="btn btn-danger">解除关系</div></a>
						<a onclick="return confirm('同时也会删除员工打卡记录，真的要删除吗？'); return false;" href="<?php  echo $this->CreateWebUrl('staff',array('op'=>'del2','id'=>$row['id']))?>"><div class="btn btn-danger">删除</div></a>
						<?php  } else { ?>
						<button type="button" class="btn btn-default" disabled="disabled">无可用操作</button>
						<?php  } ?>
					</td>
				</tr>
				<?php  } } ?>
				<tr>
					<td></td>
					<td colspan="6">
						<button class="btn btn-success" onclick="selall()" type="button">全选</button>
						<button type="submit" class="btn btn-primary" onClick="return confirm('你真的要审核吗？') ? true : false;">批量审核</button>
					</td>
				</tr>
			</tbody>
			</form>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } ?>
<script type="text/javascript">
function selall(){
	$("input.checkbox").attr("checked","checked");
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>