<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('liveType',array('op' =>'display'))?>">直播分类</a></li>
	<li<?php  if(empty($goodsType['id']) && $operation == 'post') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('liveType',array('op' =>'post'))?>">添加分类</a></li>
	<?php  if(!empty($goodsType['id']) && $operation== 'post') { ?> <li class="active"><a href="<?php  echo $this->createWebUrl('liveType',array('op' =>'post','id'=>$liveType['id']))?>">编辑分类</a></li> <?php  } ?>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:100px;">分类名称</th>
                                        <th style="width:100px;">所属直播间</th>
					<th style="width:150px;">描述</th>
					<th style="width:150px;">是否显示</th>
					<th style="width:100px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['name'];?></td>
                                        <td><?php  echo $item['live_name'];?></td>
					<td><?php  echo $item['attr_group'];?></td>
					<td><?php  if($item['enabled']==0) { ?>
					否
					<?php  } else { ?>
					是
					<?php  } ?></td>
					<td style="text-align:left;">
						<a href="<?php  echo $this->createWebUrl('liveType', array('op' => 'post', 'id' => $item['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="修改"><i class="fa fa-pencil"></i></a>
						<a href="<?php  echo $this->createWebUrl('liveType', array('op' => 'delete', 'id' => $item['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>

<script>
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>

<?php  } else if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
		<input type="hidden" name="id" value="<?php  echo $liveType['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				分类设置
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>分类名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id='name' name="name" class="form-control" value="<?php  echo $liveType['name'];?>" />
					</div>
				</div>
                                <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">所属直播间</label>
                                        <div class="col-sm-4 col-xs-12">
                                                <select name="lid" class='form-control'>
                                                        <option value="0">请选择……</option>
                                                        <?php  echo $live_list;?>
                                                </select>
                                        </div>
                                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
					<div class="col-sm-9 col-xs-12">
						<label class='radio-inline'>
						 	<input type='radio' name='enabled' value=1 <?php  if(isset($liveType['enabled']) == false || $liveType['enabled']==1) { ?>checked<?php  } ?> /> 是
						</label>
						<label class='radio-inline'>
							<input type='radio' name='enabled' value=0  <?php  if(isset($liveType['enabled']) && $liveType['enabled']==0) { ?>checked<?php  } ?> /> 否
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">描述</label>
					<div class="col-sm-9 col-xs-12">
						<textarea name="attr_group" class="form-control" cols="70"><?php  echo $liveType['attr_group'];?></textarea>
					</div>
				</div>
		</div>
	</div>
	<div class="form-group col-sm-12">
		<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	</div>
	</form>
</div>

<script language='javascript'>
	function formcheck() {
		if ($("#name").val().length == 0) {
			Tip.focus("name", "请填写分类名称!", "top");
			return false;
		} 
		return true;
	}
</script>

<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>