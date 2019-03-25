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
    <li<?php  if($op == 'display') { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('hexiao');?>">核销管理</a></li>
    <?php  if($op == 'add') { ?><li class="active"><a href="<?php  echo $this->createWebUrl('hexiao',array('op'=>'add','id'=>$_GPC['id']));?>">核销成功人员</a></li><?php  } ?>
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
	        	<input type="hidden" name="do" value="hexiao" />

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
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
						<th style="width:10%;">活动地址</th>
						<th style="width:10%;">所属区域</th>
						<th  style="width:10%;">活动允许人数</th>
						<th  style="width:10%;">成功核销人数</th>
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
						<td>
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
								<a href="<?php  echo $this->createWebUrl('hexiao',array('op'=>'add','id'=>$item['id']));?>"><div class="btn btn-info">查看核销成功人员</div></a>&nbsp;
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
			<div class="panel-heading">活动报名人员详细数据  |  总数:<?php  echo count($list)?></div>
			<div class="panel-body table-responsive">

			    <form action="" method="post" onsubmit="">

				<table class="table">

					<thead class="navbar-inner">

						<tr>
							<th  style="width:1%;"></th>
							<th  style="width:10%;">用户头像</th>
							<th  style="width:10%;">用户昵称</th>
							<th style="width:10%;">用户手机</th>
							<th style="width:8%;">用户类别</th>
							<th  style="width:20%;">报名信息</th>
							<th style="width:10%;">报名时间</th>
							<th  style="width:30%;">评论</th>
							<th style="width:10%;">核销状态</th>
							<th style="width:10%;">核销人员</th>
							<th style="width:10%;">核销门店</th>
						</tr>

					</thead>
					<tbody id="main">
						<?php  if(is_array($list)) { foreach($list as $item) { ?>

						<tr class="selectedTr" <?php  if(!empty($cs) && in_array($item['id'],$cs)) { ?>style="background:#FFCCCC"<?php  } ?>>
							<td>
								<input style="display:none" type="checkbox" name="ids[]" value="<?php  echo $item['id'];?>" <?php  if(!empty($done_arr) && in_array($item['id'],$done_arr)) { ?>checked<?php  } ?>/>		<!---->
							</td>
							<td><?php  if($item['type']==2) { ?><img style="width:70px" src="<?php  echo tomedia($item['thumb'])?>"><?php  } else { ?><img style="width:70px" src="<?php  echo $_W['attach_url'];?><?php  echo $item['avatar'];?>"><?php  } ?></td>
				            <td>
								<p><?php  echo $item['nicheng'];?></p>
				            </td>
							<td>
								<p><?php  echo $item['mobile'];?></p>
							</td>
							<td><?php  if($item['type']==0) { ?>账户<?php  } ?><?php  if($item['type']==1) { ?>微信<?php  } ?><?php  if($item['type']==2) { ?>虚拟<?php  } ?></td>
							<td style="white-space:normal">
								<?php  if(!empty($item['zl'])) { ?>
									<?php  $i=1;?>
									<?php  if(is_array($item['zl'])) { foreach($item['zl'] as $row) { ?>
									<div style="white-space:normal"><?php  echo $i;?>、<?php  echo $row['name'];?> : <?php  echo $row['zhi'];?></div>
									<?php  $i++?>
									<?php  } } ?>
								<?php  } else { ?>
									<div style="color:orange">未填写资料</div>
								<?php  } ?>
							</td>
							<td>
								<?php  echo date('m-d H:i',$item['createtime'])?>
							</td>
							<td>
							<?php  if(!empty($item['pl'])) { ?>
								<?php  $i=1;?>
								<?php  if(is_array($item['pl'])) { foreach($item['pl'] as $row) { ?>
								<div style="white-space:normal"><?php  echo $i;?>、<?php  echo $row['description'];?> <?php  if(!empty($row['num'])) { ?> <img class="supportImg" src="../addons/jy_signup_a/images/icon-agree-on.png"/><?php  echo $row['num'];?><?php  } ?></div>
								<?php  $i++?>
								<?php  } } ?>
							<?php  } else { ?>
								<div style="color:orange">未发表评论</div>
							<?php  } ?>
							</td>
							<td>
								<?php  if(in_array($item['id'],$cs)) { ?>已核销<?php  } else { ?>未核销<?php  } ?>
							</td>
							<td>
								<p><?php  echo $item['hx'];?></p>
							</td>
							<td>
								<p><?php  echo $item['mendianname'];?></p>
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

<script>
require(['jquery', 'util'], function($, u){
	$(function(){
		u.editor($('#description')[0]);
	});
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>