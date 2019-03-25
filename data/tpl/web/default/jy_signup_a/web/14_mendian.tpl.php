<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/nav', TEMPLATE_INCLUDEPATH)) : (include template('web/nav', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li<?php  if($foo == 'mendian'||$foo =='') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'mendian'));?>">门店管理</a></li>
    <li<?php  if($foo == 'edit') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'edit','id'=>$_GPC['id']));?>">添加门店</a></li>
    <?php  if($foo=='dianzhang'||$foo=='dianyuan'||$foo=='editdy'||$foo=='newdy') { ?><li<?php  if($foo == 'dianzhang') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'dianzhang','id'=>$_GPC['id']));?>">店长管理</a></li><?php  } ?>
	<?php  if($foo=='dianyuan'||$foo=='editdy'||$foo=='newdy') { ?><li<?php  if($foo == 'dianyuan') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'dianyuan','id'=>$_GPC['id']));?>">店员管理</a></li><?php  } ?>
	<?php  if($foo=='editdy') { ?><li<?php  if($foo=='editdy') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'editdy'));?>">店员编辑</a></li><?php  } ?>
	<?php  if($foo=='newdy') { ?><li<?php  if($foo=='newdy') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'newdy'));?>">添加店员</a></li><?php  } ?>
</ul>
<div class="main">
	<?php  if($foo =="mendian") { ?>
		<div class="panel panel-info">
		<div class="panel-heading">筛选</div>

		<div class="panel-body">

			<form action="./index.php" method="get" class="form-horizontal" role="form">

				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
	        	<input type="hidden" name="m" value="jy_signup_a" />
	        	<input type="hidden" name="do" value="mendian" />

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">品牌选择</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<select name="brand_id" class="form-control">
							<option value="0">请选择品牌</option>
							<?php  if(is_array($brands)) { foreach($brands as $row) { ?>
							<option value="<?php  echo $row['id'];?>" <?php  if($row['id']==$_GPC['brand_id']) { ?>selected<?php  } ?>><?php  echo $row['title'];?></option>
							<?php  } } ?>
						</select>
					</div>	               
				</div>

				<div class="form-group">
				 	<div class=" col-xs-12 col-sm-2 col-lg-2">

						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>

					</div>
				</div>
			</form>
		</div>
    	</div>
    <?php  } ?>

	<?php  if($foo == 'mendian') { ?>
	<div class="panel panel-default">
		<div class="panel-heading">门店详细数据  |  总数:<?php  echo $total;?></div>
		<div class="panel-body table-responsive">

		    <form action="" method="post" onsubmit="">

			<table class="table table-hover">

				<thead class="navbar-inner">

					<tr>
						<th  style="width:10%;">门店名</th>
						<th style="width:10%;">门店电话</th>
						<th style="width:10%;">门店地址</th>
						<th style="width:10%;">所属区域</th>
						<th style="width:10%;">已有活动数量</th>
						<th style="width:10%;">操作</th>
					</tr>

				</thead>
				<tbody id="main">
					<?php  if(is_array($list)) { foreach($list as $item) { ?>

					<tr>
					    <td>
							<p><?php  echo $item['mendianname'];?></p>
			            </td>
						<td>
							<p><?php  echo $item['tel'];?></p>
	                	</td>
						<td>
							<p><?php  echo $item['address'];?></p>
						</td>
						<td>
							<?php  echo $item['province'];?>-<?php  echo $item['city'];?>
						</td>
						<td>
							<?php  echo $item['num'];?>
						</td>
						<td>
							<span>
								<a href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'edit','id'=>$item['id']));?>"><div class="btn btn-info">编辑</div></a>&nbsp;
								<a href="<?php  echo $this->createWebUrl('huodong',array('op'=>'add','mendianid'=>$item['id']));?>"><div class="btn btn-success">添加活动</div></a>&nbsp;
								<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('mendian',array('foo'=>'del','id'=>$item['id']));?>"><div class="btn btn-danger">删除</div></a>
							</span>
						</td>
					</tr>
					<?php  } } ?>
					<tr>
						<td colspan="6">
							<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'edit'))?>"><div class="btn btn-success">添加新门店</div></a>
						</td>
					</tr>
				</tbody>
			</table>
			<?php  echo $pager;?>
			</form>
	    </div>

	</div>

	<?php  } ?>

	<?php  if($foo == 'edit') { ?>
		<form action="" method="post" class="form-horizontal form"
		enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
		<div class="panel panel-info">

			<div class="panel-heading">
				编辑门店
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-7 col-xs-12">
						<a href="<?php  echo $this->createWebUrl('huodong', array('mendianid' =>$item['id']))?>"><div class="btn btn-info">查看该门店的活动</div></a>
					</div>
				</div>
				<div class="form-group">
		          <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">门店活动访问地址</label>
		          <div class="col-sm-8 col-xs-12">
		            <a href="<?php  echo $_W['siteroot'] . 'app/' .substr($this->createMobileUrl('mdhd_list', array('id' => $item['id'])),2)?>" target="_blank"><?php  echo $_W['siteroot'] . 'app/' .substr($this->createMobileUrl('mdhd_list', array('id' => $item['id'])),2)?></a>
		          </div>
		        </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-7 col-xs-12">
						<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'dianyuan','id' =>$id))?>"><div class="btn btn-success">管理该门店的店员</div></a>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店所属品牌</label>
					<div class="col-sm-7 col-xs-12">
						<?php  if(empty($id) && empty($_GPC['brand_id'])) { ?>
						<select name="brand_id" class="form-control">
							<option value="0">请选择品牌</option>
							<?php  if(is_array($brands)) { foreach($brands as $row) { ?>
							<option value="<?php  echo $row['id'];?>" <?php  if($row['id']==$item['brand_id']) { ?>selected<?php  } ?>><?php  echo $row['title'];?></option>
							<?php  } } ?>
						</select>
						<span style="color:red">请谨慎选择品牌，选择后无法修改</span>
						<?php  } else { ?>
						<label><?php  echo $item['brand'];?></label>
						<input type="hidden" name="brand_id" value="<?php  echo $brand_id;?>" />
						<?php  } ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店名称</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="mendianname" class="form-control"
							   value="<?php  echo $item['mendianname'];?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店图片</label>
					<div class="col-sm-7 col-xs-12">
						<?php  echo tpl_form_field_image('thumb', $item['thumb']);?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店电话</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="tel" class="form-control"
							   value="<?php  echo $item['tel'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店邮箱</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="mail" class="form-control"
							   value="<?php  echo $item['mail'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">详细地址</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="address" class="form-control"
							   value="<?php  echo $item['address'];?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">区域选择</label>
					<div class="col-sm-7 col-xs-12">
						<?php  echo tpl_form_field_district('reside', array('province' => $item['province'], 'city' => $item['city'], 'district' => $item['dist'] ));?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">导航地址</label>
					<div class="col-sm-7 col-xs-12">
						<?php  $location=array('lng'=>$item['lng'],'lat'=>$item['lat'])?>

						<?php  echo tpl_form_field_coordinate('location',$location);?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店备注</label>
					<div class="col-sm-7 col-xs-12">
						<textarea class="form-control" name="description" id="description" rows="5"><?php  echo $item['description'];?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<input name="submit" type="submit" value="提交" class="btn btn-primary span3">
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>
			</div>
		</div>
		<script>
			require(['jquery', 'util'], function($, u){
				$(function(){
					u.editor($('#description')[0]);
				});
			});
		</script>
	</form>
	<?php  } ?>

	<?php  if($foo == 'dianzhang') { ?>
	<form action="" method="post" class="form-horizontal form"
		enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php  echo $id;?>" />
	<div class="panel panel-info">
		<div class="panel-heading">
			门店信息
		</div>
		<div class="panel-body">

			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">店员管理</label>
				<div class="col-sm-7 col-xs-12">
					<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'dianyuan','id' =>$id))?>"><div class="btn btn-info">管理该门店的店员</div></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店名</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['mendianname'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店电话</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['tel'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店传真</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['fax'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店邮箱</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['mail'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店网址</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['website'];?></label>
				</div>
			</div>
		</div>
	</div>

	<?php  if(!empty($dz_list)) { ?>
	<div class="panel panel-info">
		<div class="panel-heading">已有店长详细数据  |  总数:<?php  echo $total;?></div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th style="width:5%;" class="row-first">选择</td>
						<th style="width:10%;">用户名</th>
						<th style="width:10%;">手机</th>
						<th style="width:45%;">用户备注</th>
						<th style="width:15%;">注册时间</th>
						<th style="width:15%;">操作</th>
					</tr>
				</thead>
				<tbody id="main">
					<?php  if(is_array($dz_list)) { foreach($dz_list as $row) { ?>
					<tr>
					    <td><input type="checkbox" name="select[]" value="<?php  echo $row['id'];?>" /></td>
					    <td><?php  echo $row['username'];?></td>
						<td><?php  echo $row['mobile'];?></td>
						<td><?php  echo $row['description'];?></td>
						<td><?php  echo date('n月j日 G:i:s', $row['createtime']);?></td>
						<td>
							<a href="<?php  echo $this->CreateWebUrl('mendian',array('foo'=>'remove','id'=>$id,'dyid'=>$row['id']))?>"><div class="btn btn-warning">解除店长</div></a>
							<a href="<?php  echo $this->CreateWebUrl('mendian',array('foo'=>'editdy','id'=>$id,'dyid'=>$row['id']))?>"><div class="btn btn-info">编辑</div></a>&nbsp;
							<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->CreateWebUrl('mendian',array('foo'=>'deletedy','id'=>$row['id']))?>"><div class="btn btn-danger">删除</div></a>

						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
	    </div>
	</div>
	<?php  } ?>

	<div class="panel panel-info">
		<div class="panel-heading">
			设置新店长
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户名</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="username" class="form-control" value="<?php  echo $item['username'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="mobile" class="form-control" value="<?php  echo $item['mobile'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">密码</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="password" class="form-control" value="<?php  echo $item['password'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮箱</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="mail" class="form-control" value="<?php  echo $item['mail'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="QQ" class="form-control" value="<?php  echo $item['QQ'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">微信</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="wechat" class="form-control" value="<?php  echo $item['wechat'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户备注</label>
				<div class="col-sm-7 col-xs-12">
					<textarea style="height:200px;" class="form-control" name="description" id="description"><?php  echo $item['description'];?></textarea>
				</div>
			</div>
			<?php  if(!$cunzai) { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-7 col-xs-12">
					<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'dianyuan','id' =>$id))?>"><div class="btn btn-success">在该店已有店员中选择新店长</div></a>
				</div>
			</div>
			<?php  } ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<input name="submit" type="submit" value="提交" class="btn btn-primary span3">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>

		</div>
	</div>
	</form>
	<?php  } ?>

	<?php  if($foo == 'editdy') { ?>
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
	<div class="panel panel-info">
		<div class="panel-heading">
			店员管理
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-7 col-xs-12">
					<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'dianyuan','id' =>$mendianid))?>"><div class="btn btn-info">查看该门店的店员</div></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店名</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['mendianname'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店电话</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['tel'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店传真</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['fax'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店邮箱</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['mail'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店网址</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['website'];?></label>
				</div>
			</div>
			<?php  if(!empty($item['nickname'])) { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户微信昵称</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $item['nickname'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户微信昵称</label>
				<div class="col-sm-7 col-xs-12">
					<img style="width:100px" src="<?php  echo $item['avatar'];?>"/>
				</div>
			</div>
			<?php  } else { ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">立马绑定微信</label>
				<div class="col-sm-7 col-xs-12">
					<div id="code"></div>
				</div>
			</div>
			<?php  } ?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户名</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="username" class="form-control" value="<?php  echo $item['username'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="mobile" class="form-control" value="<?php  echo $item['mobile'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮箱</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="mail" class="form-control" value="<?php  echo $item['mail'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="QQ" class="form-control" value="<?php  echo $item['QQ'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">微信</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="wechat" class="form-control" value="<?php  echo $item['wechat'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">密码</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="password" class="form-control" value="<?php  echo $item['password'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
				<div class="col-sm-7 col-xs-12">
					<?php  if($item['status']==2) { ?>
						<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'updated','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">审核为店员</div></a>
					<?php  } else { ?>
						<?php  if($item['type']==0) { ?>
							<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'update','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">升级店长</div></a>
						<?php  } ?>
						<?php  if($item['type']==1) { ?>
							<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'remove','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">解除店长</div></a>
						<?php  } ?>
					<?php  } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">备注</label>
				<div class="col-sm-7 col-xs-12">
					<textarea style="height:200px;" class="form-control" name="description" cols="70" id="description"><?php  echo $item['description'];?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<input name="submit" type="submit" value="提交" class="btn btn-primary span3">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>

		</div>
	</div>
	</form>
	<script type="text/javascript" src="../addons/jy_signup_a/js/jquery.js"></script>
	<script type="text/javascript" src="../addons/jy_signup_a/js/jquery.qrcode.js"></script>
	<script>
	    jQuery(function(){
	        jQuery('#code').qrcode("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('dybind',array('id'=>$item['id'])),2)?>");
	    })
	</script>
	<?php  } ?>

	<?php  if($foo == 'newdy') { ?>

	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
	<div class="panel panel-info">
		<div class="panel-heading">
			店员管理
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-7 col-xs-12">
					<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'dianyuan','id' =>$mendianid))?>"><div class="btn btn-info">查看该门店的店员</div></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店名</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['mendianname'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店电话</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['tel'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店传真</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['fax'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店邮箱</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['mail'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">门店网址</label>
				<div class="col-sm-7 col-xs-12">
					<label for=""><?php  echo $mendian['website'];?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">用户名</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="username" class="form-control" value="<?php  echo $item['username'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">手机</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="mobile" class="form-control" value="<?php  echo $item['mobile'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">邮箱</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="mail" class="form-control" value="<?php  echo $item['mail'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="QQ" class="form-control" value="<?php  echo $item['QQ'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">微信</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="wechat" class="form-control" value="<?php  echo $item['wechat'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">密码</label>
				<div class="col-sm-7 col-xs-12">
					<input type="text" name="password" class="form-control" value="<?php  echo $item['password'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
				<div class="col-sm-7 col-xs-12">
					<label for="">新用户默认为店员，若要升级为店长，请添加完成后再设置该店员为店长</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">备注</label>
				<div class="col-sm-7 col-xs-12">
					<textarea style="height:200px;" class="form-control" name="description" cols="70" id="description"><?php  echo $item['description'];?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<input name="submit" type="submit" value="提交" class="btn btn-primary span3"> 
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</div>
			</div>
		</div>
	</div>
	</form>
	<?php  } ?>


	<?php  if($foo == 'dianyuan') { ?>

		<?php  if(empty($list)) { ?>
		<div class="panel panel-danger">
			<div class="panel-heading">该门店仍未有任何店员，请先添加店员！</div>
		</div>
		<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'newdy','id'=>$shopid))?>"><div class="btn btn-success">添加新店员</div></a>

		<?php  } else { ?>
		<style type="text/css">
		.erweimaDiv{
			position: fixed;
			right: 0;
			top: 0;
			padding-top: 15%;
			width: 89%;
			height: 100%;
			background-color: rgba(0,0,0,0.5);
			text-align: center;
			vertical-align: middle;
			display: none;
		}
		.erweimaDiv>img{
			width: 30%;
		}
		</style>
		<div class="panel panel-info">
			<div class="panel-heading">门店店员</div>
			<div class="panel-body table-responsive">
				<form action="" method="post" onsubmit="">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th class="span1">编号</th>
							<th  class="span2">用户名</th>
							<th class="span2">手机号</th>
							<th class="span2">微信昵称</th>
							<th class="span2">微信头像</th>
							<th class="span2">微信</th>
							<th class="span2">类型</th>
							<th class="span2">店长设定</th>
							<th class="span2">操作</th>
						</tr>
					</thead>
					<tbody id="main">
						<?php  if(is_array($list)) { foreach($list as $item) { ?>
						<tr>
						    <td>
							<p><?php  echo $item['id'];?></p>
						</td>
						<td>
							<p><?php  echo $item['username'];?></p>
			            </td>
						<td>
							<p><?php  echo $item['mobile'];?></p>
	                	</td>
	                	<td>
							<p><?php  echo $item['nickname'];?></p>
	                	</td>
						<td>
							<p><img style="width:70px" src="<?php  echo $_W['attach_url'];?><?php  echo $item['avatar'];?>"></p>
						</td>
						<td>
							<p><?php  echo $item['wechat'];?></p>
						</td>
						<td>
							<?php  if($item['type']==1) { ?>
								<p style="color:red">店长</p>
							<?php  } ?>
							<?php  if($item['type']==0) { ?>
								<p>店员</p>
							<?php  } ?>

						</td>
						<td>
							<?php  if($item['status']==2) { ?>
								<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'updated','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">审核为店员</div></a>
							<?php  } else { ?>
								<?php  if($item['type']==0) { ?>
									<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'update','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">升级店长</div></a>
								<?php  } ?>
								<?php  if($item['type']==1) { ?>
									<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'remove','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">解除店长</div></a>
								<?php  } ?>
							<?php  } ?>

						</td>
						<td>
							<span>
								<?php  if(empty($item['uid'])) { ?><div class="btn btn-warning" onclick="qrcode(<?php  echo $item['id'];?>)">绑定</div><?php  } else { ?><a href="<?php  echo $this->createWebUrl('unbind', array('id'=>$item['id'],'mendianid'=>$_GPC['id']))?>"><div class="btn btn-danger">解绑</div></a><?php  } ?>&nbsp;<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'editdy','id'=>$item['mendianid'],'dyid' => $item['id']))?>"><div class="btn btn-info">编辑</div></a>&nbsp;<a onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'deletedy','id' => $item['id']))?>"><div class="btn btn-danger">删除</div></a>
							</span>
						</td>
						</tr>
						<?php  } } ?>
						<tr>
							<td></td>
							<td colspan="8">
								<a href="<?php  echo $this->createWebUrl('mendian', array('foo' => 'newdy','id'=>$shopid))?>"><div class="btn btn-success">添加新店员</div></a>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>

		<div id="code" class="erweimaDiv"></div>

		<script type="text/javascript" src="../addons/jy_signup_a/js/jquery.js"></script>
		<script type="text/javascript" src="../addons/jy_signup_a/js/jquery.qrcode.js"></script>

		<script>
			function qrcode(dyid)
			{
				jQuery(function(){
			        jQuery('#code').qrcode("<?php  echo $_W['siteroot'].'app/'.substr($this->createMobileUrl('dybind'),2).'&id='?>"+dyid);
			    })
			    $(".erweimaDiv").fadeIn(500);
			}
		   $(".erweimaDiv").bind("click",function(){
		   		$(this).fadeOut(500).html("");
		   })
		</script>

		<?php  } ?>
	<?php  } ?>

</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>