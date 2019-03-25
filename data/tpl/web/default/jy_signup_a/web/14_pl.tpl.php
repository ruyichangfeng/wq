<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/nav', TEMPLATE_INCLUDEPATH)) : (include template('web/nav', TEMPLATE_INCLUDEPATH));?>
<style>
	.supportImg{width:15px;vertical-align:top;margin-left:10px}
	.footer{
		width: 88%;
		height: 60px;
		position: fixed;
		background: #66CCCC;
		border-top: 1px solid #ccc;
		right:0;
		bottom: 0;
		overflow: hidden;
	}
	.footer>div{width: 33%;float: left;line-height: 60px;text-align: center;color: #fff;font-weight: bold}
	#sureBtn{
		background: #FF6600;
		padding: 6px 20px;
		color: #fff;
		border-radius: 3px;
		cursor: pointer;
	}
</style>
<ul class="nav nav-tabs">
    <li<?php  if($op == 'display') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('pl');?>">活动评论管理</a></li>
    <?php  if($op == 'add') { ?><li class="active"><a href="<?php  echo $this->createWebUrl('pl',array('op'=>'add','id'=>$_GPC['id']));?>">活动评论详情</a></li><?php  } ?>
</ul>
<div class="main">
	<?php  if($op =="display") { ?>
		<div class="panel panel-info">
		<div class="panel-heading">筛选</div>

		<div class="panel-body">

			<form action="./index.php" method="get" class="form-horizontal" role="form">

				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
	        	<input type="hidden" name="m" value="jy_signup_a" />
	        	<input type="hidden" name="do" value="pl" />

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">门店</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<select class="form-control" name="mendianid">门店
						<option value="0">请选择门店</option>
						<?php  if(is_array($mendian)) { foreach($mendian as $row) { ?>
							<option value="<?php  echo $row['id'];?>" <?php  if($row['id']==$_GPC['mendianid']) { ?>selected<?php  } ?>><?php  echo $row['mendianname'];?></option>
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

	<?php  if($op == 'display') { ?>
	<div class="panel panel-default">
		<div class="panel-heading">活动详细数据  |  总数:<?php  echo count($list)?></div>
		<div class="panel-body table-responsive">

		    <form action="" method="post" onsubmit="">

			<table class="table table-hover">

				<thead class="navbar-inner">

					<tr>
						<th  style="width:10%;">活动标题</th>
						<th  style="width:10%;">所属品牌</th>
						<th style="width:20%;">活动地址</th>
						<th style="width:10%;">所属区域</th>
						<th  style="width:10%;">活动允许人数</th>
						<th  style="width:10%;">评论次数</th>
						<th style="width:10%;">操作</th>
					</tr>

				</thead>
				<tbody id="main">
					<?php  if(is_array($list)) { foreach($list as $item) { ?>

					<tr>
						<td>
							<p><?php  echo $item['hdname'];?></p>
			            </td>
			            <td>
							<p><?php  echo $item['name'];?></p>
			            </td>
						<td style="white-space:normal; word-break:break-all;overflow:hidden">
							<p><?php  echo $item['address'];?></p>
						</td>
						<td>
							<?php  echo $item['province'];?>-<?php  echo $item['city'];?>
						</td>
						<td>
							<p><?php  echo $item['renshu'];?></p>
						</td>
						<td>
							<p><?php  echo $item['num2'];?></p>
						</td>
						<td>
							<span>
								<a href="<?php  echo $this->createWebUrl('pl',array('op'=>'add','id'=>$item['id']));?>"><div class="btn btn-info">查看活动评论详情</div></a>&nbsp;
							</span>
						</td>
					</tr>
					<?php  } } ?>
				</tbody>
			</table>
			<?php  echo $pager;?>
			</form>
	    </div>

	</div>

	<?php  } ?>

	<?php  if($op == 'add') { ?>
		<div class="panel panel-default">
			<div class="panel-heading">活动评论详细数据  |  总数:<?php  echo count($list)?></div>
			<div class="panel-body table-responsive">

			    <form action="" method="post" onsubmit="">

				<table class="table">

					<thead class="navbar-inner">

						<tr>
							<th  style="width:1%;"></th>
							<th  style="width:10%;">用户头像</th>
							<th  style="width:10%;">用户昵称</th>
							<th style="width:10%;">用户手机</th>
							<th style="width:10%;">评论时间</th>
							<th  style="width:30%;">评论</th>
							<th style="width:10%;">操作</th>
						</tr>

					</thead>
					<tbody id="main">
						<?php  if(is_array($list)) { foreach($list as $item) { ?>

						<tr class="selectedTr">
							<td>
								<input style="display:none" type="checkbox" name="ids[]" value="<?php  echo $item['id'];?>"/>		<!---->
							</td>
							<td>
								<img src="<?php  echo $item['avatar'];?>" style="width:70px" />
				            </td>
				            <td>
								<p><?php  echo $item['nickname'];?></p>
				            </td>
							<td>
								<p><?php  echo $item['mobile'];?></p>
							</td>
							<td>
								<?php  echo date('m-d H:i',$item['createtime'])?>
							</td>
							<td>
								<div style="white-space:normal"><?php  echo $item['description'];?> <?php  if(!empty($item['num'])) { ?> <img class="supportImg" src="../addons/jy_signup_a/images/icon-agree-on.png"/><?php  echo $item['num'];?><?php  } ?></div>

							</td>
							<td>
								<a href="<?php  echo $this->createWebUrl('pl',array('op'=>'del','hdid'=>$_GPC['id'],'id'=>$item['plid']));?>"><div class="btn btn-danger">删除该评论</div></a>&nbsp;
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
				<?php  echo $pager;?>
				</form>
		    </div>
		</div>
	<?php  } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>