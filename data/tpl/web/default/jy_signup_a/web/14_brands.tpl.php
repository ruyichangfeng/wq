<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/nav', TEMPLATE_INCLUDEPATH)) : (include template('web/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('brands', array('op' => 'display'))?>">品牌管理</a></li>
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('brands', array('op' => 'post'))?>"><?php  if($id==0) { ?>添加新品牌<?php  } else { ?>编辑品牌<?php  } ?></a></li>
	
</ul>
<style>
.panel-body {
padding: 10px;
}
</style>
<?php  if($operation == 'post') { ?>
<div class="main">

	<?php  if(!empty($id)) { ?>
	<div class="panel panel-info">
		<div class="panel-heading">该品牌已有门店详细数据  |  总数:<?php  echo count($m_list)?></div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th  style="width:10%;">门店名</th>
						<th style="width:10%;">门店电话</th>
						<th style="width:10%;">门店品牌</th>
						<th style="width:10%;">门店地址</th>
						<th style="width:10%;">所属区域</th>
						<th style="width:10%;">已有活动数量</th>
						<th style="width:10%;">店长管理</th>
						<th style="width:10%;">操作</th>
					</tr>
				</thead>
				<tbody id="main">
					<?php  if(is_array($m_list)) { foreach($m_list as $item) { ?>
					<tr>
					    <td>
							<p><?php  echo $item['mendianname'];?></p>
			            </td>
						<td>
							<p><?php  echo $item['tel'];?></p>
	                	</td>
	                	<td>
							<p><?php  echo $category['title'];?></p>
	                	</td>
						<td>
							<p><?php  echo $item['address'];?></p>
						</td>
						<td>
							<?php  echo $item['province'];?>-<?php  echo $item['city'];?>
						</td>
						<td>
							<p><?php  echo $item['num'];?></p>
						</td>
						<td>
							<span><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'dianzhang','id'=>$item['id']));?>"><div class="btn btn-warning">店长管理</div></a></span>
						</td>
						<td>
							<span><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'edit','id'=>$item['id']));?>"><div class="btn btn-info">编辑</div></a>&nbsp;<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'del','id'=>$item['id']));?>"><div class="btn btn-danger">删除</div></a></span>
						</td>
					</tr>
					<?php  } } ?>
					<tr>
						<td colspan="8">
							<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'edit','brand_id'=>$id))?>"><div class="btn btn-success">添加新门店</div></a>
						</td>
					</tr>
				</tbody>
			</table>			
	    </div>
	</div>

	<div class="panel panel-info">
		<div class="panel-heading">该品牌已有活动详细数据  |  总数:<?php  echo count($g_list)?></div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th  style="width:10%;">活动标题</th>
						<th style="width:15%;">活动地址</th>
						<th style="width:10%;">所属区域</th>
						<th style="width:10%;">所需费用</th>
						<th  style="width:10%;">活动拥有评论</th>
						<th style="width:10%;">适用门店数量</th>
						<th  style="width:10%;">活动状态</th>
						<th style="width:10%;">操作</th>
					</tr>
				</thead>
				<tbody id="main">
					<?php  if(is_array($g_list)) { foreach($g_list as $item) { ?>
						<tr>
							<td>
								<p><?php  echo $item['hdname'];?></p>
				            </td>
							<td style="white-space:normal; word-break:break-all;overflow:hidden">
								<p><?php  echo $item['address'];?></p>
							</td>
							<td>
								<?php  echo $item['province'];?>-<?php  echo $item['city'];?>
							</td>
							<td>
								<p><?php  if($item['price']>0) { ?><?php  echo $item['price'];?> 元<?php  } else { ?>免费<?php  } ?></p>
							</td>
							<td>
								<p><?php  echo $item['pl'];?></p>
							</td>
							<td>
								<p><?php  echo $item['num'];?></p>
				            </td>
							<td>
								<?php  if($item['endtime']<time()) { ?>已结束<?php  } ?>
								<?php  if($item['starttime']>time()) { ?>未开始<?php  } ?>
								<?php  if($item['starttime']<=time() && $item['endtime']>time()) { ?>进行中<?php  } ?>
							</td>
							<td>
								<span>
									<a href="<?php  echo $this->createWebUrl('huodong',array('op'=>'add','id'=>$item['id']));?>"><div class="btn btn-info">编辑</div></a>&nbsp;
									<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('huodong',array('op'=>'del','id'=>$item['id']));?>"><div class="btn btn-danger">删除</div></a>
								</span>
							</td>
						</tr>
						
						<?php  } } ?>
					<tr>
						<td colspan="8">
							<a href="<?php  echo $this->createWebUrl('huodong', array('op' => 'add','brand_id'=>$id))?>"><div class="btn btn-success">添加新活动</div></a>
						</td>
					</tr>
				</tbody>
			</table>			
	    </div>
	</div>
	<?php  } ?>

	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
	<input type="hidden" name="parentid" value="<?php  echo $parent['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php  if(empty($id)) { ?>添加<?php  } else { ?>编辑<?php  } ?>品牌
			</div>

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
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">品牌名称</label>
					<div class="col-sm-5">
						<input type="text" name="catename" class="form-control" value="<?php  echo $category['title'];?>" />
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">品牌logo</label>
					<div class="col-sm-5">
						<?php  echo tpl_form_field_image('thumb', $category['thumb']);?>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">品牌简介</label>
					<div class="col-sm-5">
						<textarea name="content" id="content" class="span6" cols="70"><?php  echo $category['content'];?></textarea>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否显示</label>
					<div class="col-sm-5">
						<label for="enabled1" class="radio-inline"><input type="radio" name="status" value="1" id="enabled1" <?php  if(!empty($category['status']) && $category['status'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled2" class="radio-inline"><input type="radio" name="status" value="0" id="enabled2"  <?php  if(empty($category['status']) || $category['status'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>	           
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
	<script>
	require(['jquery', 'util'], function($, u){
		$(function(){
			u.editor($('#content')[0]);
		});
	});
	</script>
</div>


<?php  } else if($operation == 'display') { ?>

<div class="main">

	<div class="category">
		
			<div class="panel panel-default">
				<div class="panel-heading">
					品牌管理
				</div>
				<div class="panel-body table-responsive">
					<form action="" method="post" class="form-horizontal form" onsubmit="return formcheck(this)">
					<table class="table table-hover">

					<thead class="navbar-inner">
						<tr>
							<th style="width:10px;"></th>
							<th style="width:100px;">显示顺序</th>
							<th style="width:200px;">品牌名称</th>
							<th style="width:80px;">品牌logo</th>
							<th style="width:80px;">品牌拥有活动</th>
							<th style="width:80px;">品牌拥有门店</th>
							<th style="width:100px;">是否显示</th>
							<th style="width:180px;">操作</th>
						</tr>
					</thead>

					<tbody id="main">
						<?php  if(is_array($category)) { foreach($category as $row) { ?>
						<tr>
							<td>
							</td>
							<td class="text-center">
								<input type="text" name="displayorder[<?php  echo $row['id'];?>]" style="width:80px" value="<?php  echo $row['displayorder'];?>">
							</td>

							<td class="text-left">
								<div style="height:30px;line-height:30px;"><?php  echo $row['title'];?>&nbsp;&nbsp;
								</div>
							</td>

							<td class="text-left">
								<img style="width:80px" src="<?php  echo $_W['attachurl'];?><?php  echo $row['thumb'];?>" />
							</td>

							<td class="text-left">
								<?php  echo $row['num'];?>
							</td>

							<td class="text-left">
								<?php  echo $row['m_num'];?>
							</td>

							<td><?php  if(!empty($row['status']) && $row['status'] == 1) { ?><div class="btn btn-success btn-sm">显示</div><?php  } else { ?><div class="btn btn-default btn-sm">不显示</div><?php  } ?>
							</td>

							<td>
								<a href="<?php  echo $this->createWebUrl('brands', array('op' => 'post', 'id' => $row['id']))?>" title="编辑" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit">编辑</i></a>

								<a href="<?php  echo $this->createWebUrl('brands', array('op' => 'delete','id' => $row['id']))?>" onclick="return confirm('确认删除此品牌吗？');return false;" title="删除" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-times">删除</i></a>

							</td>
						</tr>
						
					<?php  } } ?>
					<tr>
						<td></td>
						<td colspan="7">
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