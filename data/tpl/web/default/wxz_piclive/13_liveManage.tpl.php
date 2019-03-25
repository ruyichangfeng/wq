<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('liveManage', array('op' => 'post'))?>"><?php  if(empty($lid)) { ?>添加直播间<?php  } else { ?>编辑直播间<?php  } ?></a></li>
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('liveManage', array('op' => 'display'))?>">管理直播间</a></li>
</ul>
<?php  if($operation == 'post') { ?>
<style type='text/css'>
	.tab-pane {padding:20px 0 20px 0;}
</style>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1" name="theForm">
		<div class="panel panel-default">
			<!--<div class="panel-heading">
				<?php  if(empty($lid)) { ?>添加直播间<?php  } else { ?>编辑直播间<?php  } ?>
			</div>-->
			<div class="panel-body">
				<!--<ul class="nav nav-tabs" id="myTab">
					<li class="active" ><a href="#tab_basic">基本信息</a></li>
				</ul>-->
				<div class="tab-content">
					<div class="tab-pane  active" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('live_basic', TEMPLATE_INCLUDEPATH)) : (include template('live_basic', TEMPLATE_INCLUDEPATH));?></div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<script type="text/javascript">
	$(function () {
		window.optionchanged = false;
		$('#myTab a').click(function (e) {
			e.preventDefault();//阻止a链接的跳转行为
			$(this).tab('show');//显示当前选中的链接及关联的content
		})
	});

	
</script>

<?php  } else if($operation == 'display') { ?>
<div class="main">
	<!--<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="wxz_piclive" />
			<input type="hidden" name="do" value="liveManage" />
			<input type="hidden" name="op" value="display" />
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
				</div>
			</div>

			<div class="form-group">
				<div class="col-xs-12 col-sm-2 col-lg-2" style="margin-left:90px;">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>

			<div class="form-group">
			</div>
		</form>
	</div>
</div>-->
<style>
.label{cursor:pointer;}
</style>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:5%;">编号</th>
					<th style="width:10%;">名称</th>
                    <th style="width:25%;">WAP端链接</th>
					<th style="text-align:right; width:40%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td title=''><?php  echo $item['live_name'];?></td>
                    <td>
                        <a href="<?php  echo $item['live_url'];?>" target="_blank">首页</a>&nbsp;&nbsp;
                        <a href="<?php  echo $item['wapupload_url'];?>" target="_blank">添加图片</a>
                        <!--<a href="<?php  echo $item['ftpupload_url'];?>" target="_blank">FTP图片执行</a>-->
                    </td>
					<td style="text-align:right;">
                        <a href="<?php  echo $this->createWebUrl('liveManage', array('lid' => $item['id'], 'op' => 'post'))?>"class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('topicManage',array('lid'=>$item['id']))?>">图片管理</a>
						<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('video',array('lid'=>$item['id']))?>">短视频</a>
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('comment',array('lid'=>$item['id']))?>">评论列表</a>
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('users',array('lid'=>$item['id']))?>">观众列表</a>
                        <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('indexManage',array('lid'=>$item['id']))?>">聚合首页</a><br/>
                        <!--<a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('ftpupload',array('lid'=>$item['id']))?>">FTP图片执行</a>-->
                        <a href="<?php  echo $this->createWebUrl('liveManage', array('lid' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>&nbsp;&nbsp;
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
	</div>
</div>
<script type="text/javascript">
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});

</script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
