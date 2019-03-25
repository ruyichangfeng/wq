<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('attr', array('op' => 'display'))?>">自定义字段管理</a></li>
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('attr', array('op' => 'post'))?>"><?php  if($id==0) { ?>添加自定义字段<?php  } else { ?>编辑自定义字段<?php  } ?></a></li>
	
</ul>
<style>
.panel-body {
padding: 10px;
}
</style>
<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
	<input type="hidden" name="parentid" value="<?php  echo $parent['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				添加自定义字段
			</div>
			<?php  if(!empty($parentid)) { ?>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">上级类型</label>
					<div class="col-sm-5">
						<?php  echo $parent['name'];?>
					</div>
				</div>
			</div>
			<?php  } ?>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">排序</label>
					<div class="col-sm-5">
						<input type="text" name="displayorder" class="form-control" value="<?php  echo $category['displayorder'];?>" />
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">自定义字段名称</label>
					<div class="col-sm-5">
						<input type="text" name="catename" class="form-control" value="<?php  echo $category['name'];?>" />
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">自定义字段描述</label>
					<div class="col-sm-5">
						<textarea name="description" id="description" class="span6" cols="70"><?php  echo $category['description'];?></textarea>
					</div>
				</div>
			</div>

			<?php  if(empty($parentid)) { ?>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">选择类型</label>
					<div class="col-sm-5" id="choosebox">
						<!-- <label for="enabled3" class="radio-inline"><input type="radio" name="type" value="1" id="enabled3" <?php  if(!empty($category['type']) && $category['type'] == 1) { ?>checked="true"<?php  } ?> /> 多选</label>
	                    &nbsp;&nbsp;&nbsp; -->
	                    <label for="enabled8" class="radio-inline"><input type="radio" name="type" value="2" id="enabled8"  <?php  if(!empty($category['type']) && $category['type'] == 2) { ?>checked="true"<?php  } ?> /> 填空</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled9" class="radio-inline"><input type="radio" name="type" value="3" id="enabled9"  <?php  if(!empty($category['type']) && $category['type'] == 3) { ?>checked="true"<?php  } ?> /> 下拉菜单</label>
	                    <!-- &nbsp;&nbsp;&nbsp;
	                    <label for="enabled7" class="radio-inline"><input type="radio" name="type" value="4" id="enabled7"  <?php  if(!empty($category['type']) && $category['type'] == 4) { ?>checked="true"<?php  } ?> /> 市区街道</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled12" class="radio-inline"><input type="radio" name="type" value="5" id="enabled12"  <?php  if(!empty($category['type']) && $category['type'] == 5) { ?>checked="true"<?php  } ?> /> 三级联动</label> -->
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled13" class="radio-inline"><input type="radio" name="type" value="6" id="enabled13"  <?php  if(!empty($category['type']) && $category['type'] == 6) { ?>checked="true"<?php  } ?> /> 手机</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled14" class="radio-inline"><input type="radio" name="type" value="7" id="enabled14"  <?php  if(!empty($category['type']) && $category['type'] == 7) { ?>checked="true"<?php  } ?> /> 姓名</label>
	                    <label for="enabled14" class="radio-inline" data-type='yes'><input type="radio" name="type" value="8" id="enabled14"  <?php  if(!empty($category['type']) && $category['type'] == 8) { ?>checked="true"<?php  } ?> /> 图片</label>
					</div>
				</div>
			</div>

			<?php  } ?>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否显示</label>
					<div class="col-sm-5">
						<label for="enabled11" class="radio-inline"><input type="radio" name="enabled" value="1" id="enabled11" <?php  if(!empty($category['enabled']) && $category['enabled'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled10" class="radio-inline"><input type="radio" name="enabled" value="0" id="enabled10"  <?php  if(empty($category['enabled']) || $category['enabled'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
	                    
					</div>
				</div>
			</div>

			<div class="form-group col-sm-12">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				<input type="hidden" name="id" value="<?php  echo $category['id'];?>" />
				<input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" />
			</div>

			

		</div>
	</form>
</div>
<script type="text/javascript">
	require(['jquery', 'util'], function($, u){
		$(function(){
			u.editor($('#description')[0]);
		});
	});
</script>

<?php  } else if($operation == 'display') { ?>

<div class="main">
	<div class="category">
		
			<div class="panel panel-default">
				<div class="panel-heading">
					管理自定义字段
				</div>
				<div class="panel-body table-responsive">
					<form action="" method="post" class="form-horizontal form" onsubmit="return formcheck(this)">
					<table class="table table-hover">

					<thead class="navbar-inner">
						<tr>
							<th style="width:10px;">ID</th>
							<th style="width:80px;">显示顺序</th>
							<th style="width:200px;">字段名称</th>
							<th style="width:200px;">字段类型</th>
							<th style="width:100px;">操作</th>
						</tr>
					</thead>

					<tbody id="main">
						<?php  if(is_array($category)) { foreach($category as $row) { ?>
						<tr>
							<td>
								<p><?php  echo $row['id'];?></p>
							</td>
							<td class="text-left">
								<input type="text" style="width:80px" name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>">
							</td>

							<td class="text-left">
								<div style="height:30px;line-height:30px;"><?php  echo $row['name'];?>&nbsp;&nbsp;
									<?php  if(empty($row['parentid']) && ($row['type'] == 1 || $row['type']==3)) { ?>
									<a href="<?php  echo $this->createWebUrl('attr', array('parentid' => $row['id'], 'op' => 'post'))?>">
										<i class="fa fa-plus"></i> 添加选项</a>
									<?php  } ?>	
								</div>
							</td>

							<td>

							<?php  if(!empty($row['type']) && $row['type'] == 1) { ?><div class="btn btn-info btn-sm">多选</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 2) { ?><div class="btn btn-success btn-sm">填空</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 3) { ?><div class="btn btn-danger btn-sm">下拉菜单</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 4) { ?><div class="btn btn-danger btn-sm">市区街道</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 5) { ?><div class="btn btn-primary btn-sm">三级联动</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 6) { ?><div class="btn btn-default btn-sm">手机</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 7) { ?><div class="btn btn-default btn-sm">姓名</div><?php  } ?>
							<?php  if(!empty($row['type']) && $row['type'] == 8) { ?><div class="btn btn-info btn-sm">图片</div><?php  } ?>
							<?php  if(empty($row['type']) || $row['type'] == 0) { ?><div class="btn btn-default btn-sm">单选</div><?php  } ?>

							<?php  if(!empty($row['enabled']) && $row['enabled'] == 1) { ?><div class="btn btn-default btn-sm">显示</div><?php  } ?>
							<?php  if(empty($row['enabled']) || $row['enabled'] == 0) { ?><div class="btn btn-danger btn-sm">不显示</div><?php  } ?>
							</td>

							<td>
								<a href="<?php  echo $this->createWebUrl('attr', array('op' => 'post', 'id' => $row['id']))?>" title="编辑" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit">编辑</i></a>

								<a href="<?php  echo $this->createWebUrl('attr', array('op' => 'delete','id' => $row['id']))?>" onclick="return confirm('确认删除此分类吗？');return false;" title="删除" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-times">删除</i></a>

							</td>
						</tr>
							<?php  if(is_array($children[$row['id']])) { foreach($children[$row['id']] as $item) { ?>
							<tr>
								<td></td>
								<td class="text-left"><input style="width:80px" type="text" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>"></td>
								<td class="text-left"><div style="padding-left:50px;height:30px;line-height:30px;background:url('./resource/images/bg_repno.gif') no-repeat -245px -545px;"><?php  echo $item['name'];?>&nbsp;&nbsp;</div></td>
								<td></td>
								<td>

								<a href="<?php  echo $this->createWebUrl('attr', array('op' => 'post', 'id' => $item['id'],'parentid'=>$row['id']))?>" title="编辑" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit">编辑</i></a>

								<a href="<?php  echo $this->createWebUrl('attr', array('op' => 'delete','id' => $item['id']))?>" onclick="return confirm('确认删除此分类吗？');return false;" title="删除" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-times">删除</i></a>
								</td>
							</tr>
							<?php  } } ?>
						
					<?php  } } ?>
					<tr>
						<td></td>
						<td colspan="3">
							<input name="submit" type="submit" class="btn btn-primary" value="提交">
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
						</td>
					</tr>
					</tbody>
					</table>
					</form>
				</div>
			</div>
	</div>
</div>
<?php  } ?>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>