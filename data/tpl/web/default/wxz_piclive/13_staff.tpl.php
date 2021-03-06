<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<ul class="nav nav-tabs">
    <li  <?php  if($operation == "display") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('staff',array('lid' => $lid))?>">管理员列表</a></li>
    <li  <?php  if($operation == "add") { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('staff',array('op' => 'add'))?>">新增管理员</a></li>
</ul>
<?php  if($operation == 'add') { ?>
<div class="clearfix" ng-controller="ListCtrl" ng-cloak>
	<div class="alert alert-info">
            图片管理员来源该公众号下粉丝信息，选中加入管理员即可
	</div>

	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
                                <input type="hidden" name="c" value="site" />
                                <input type="hidden" name="a" value="entry" />
                                <input type="hidden" name="m" value="wxz_piclive" />
                                <input type="hidden" name="do" value="staff" />
                                <input type="hidden" name="op" value="add" />
				<input type="hidden" name="searchmod" value="{{config.searchMod.value}}" />
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称/openid</label>
					<div class="col-sm-9 col-md-8 col-lg-8 col-xs-12">
						<div class="input-group">
							<div class="input-group-btn">
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">{{config.searchMod.title}} <span class="caret"></span></button>
								<ul role="menu" class="dropdown-menu">
									<li><a href="javascript:;" ng-click="switchSearchMod(1)">精确</a></li>
									<li><a href="javascript:;" ng-click="switchSearchMod(2)">模糊</a></li>
								</ul>
							</div>
							<input type="text" class="form-control" name="nickname" value="<?php  echo $nickname;?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">uid</label>
					<div class="col-sm-9 col-md-8 col-lg-8 col-xs-12">
						<input type="text" class="form-control" name="uid" value="<?php  echo $_GPC['uid'];?>"/>
					</div>
				</div>
				
				<div class="form-group">
					<div class="pull-right col-xs-12 col-sm-3 col-md-2 col-lg-2">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<form action="?<?php  echo $_SERVER['QUERY_STRING'];?>" method="post" id="form1">
	<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover"  style="width:100%;z-index:-10;" cellspacing="0" cellpadding="0">
			<thead class="navbar-inner">
				<tr>
					<th style="width:100px;">编号</th>
					<th style="width:90px;">头像</th>
					<th style="width:150px;">昵称</th>
					<th style="width:180px;">对应用户</th>
					<th style="width:80px;">是否关注</th>
					<th style="min-width:70px;" class="text-right">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $index => $item) { ?>
				<tr>
					<td><?php  echo $item['fanid'];?></td>
					<td><img src="<?php  if(!empty($item['user']['avatar'])) { ?><?php  echo $item['user']['avatar'];?><?php  } else { ?>resource/images/noavatar_middle.gif<?php  } ?>" width="48"></td>
					<td><?php  echo $item['user']['nickname'];?></td>
					<td>
						<?php  if(empty($item['uid'])) { ?>
						<a href="<?php  echo url('mc/member/post', array('uid' => $item['uid'],'openid' => $item['openid'], 'fanid' => $item['fanid']));?>" class="text-danger" title="该用户尚未注册会员，请为其手动注册！">[ 注册为会员 ]</a>
						<?php  } else { ?>
						<a href="<?php  echo url('mc/member/post', array('uid'=>$item['uid']));?>"><span><?php  if($item['user']['niemmo_effective'] == 1) { ?><?php  echo $item['user']['niemmo'];?><?php  } else { ?><?php  echo $item['uid'];?><?php  } ?></span></a>
						<?php  } ?>
					</td>
					<td>
					<?php  if($item['follow'] == '1') { ?>
						<span class="label label-success">已关注 </span> 
					<?php  } else if($item['unfollowtime'] <> '0') { ?>
						<span class="label label-warning" >取消关注 </span>
					<?php  } else { ?>
						<span class="label label-danger">未关注 </span>
					<?php  } ?>
					</td>
					<td class="text-right" style="overflow:visible;">
                                            <?php  if($item['isExit'] > 0) { ?>
                                                已加入管理员
                                            <?php  } else { ?>
						<a href="javascript:;" data-fanid="<?php  echo $item['fanid'];?>" class="btn btn-success btn-sm sms btnStaff">加入管理员</a>
                                            <?php  } ?>    
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
	</div>
	</div>
	<?php  echo $pager;?>
	</form>
</div>
<script type="text/javascript">
	$(function(){
		angular.module('fansApp').value('config', {
			'enabled' : <?php  if($_W['acid'] && $_W['account']['level'] >= ACCOUNT_SUBSCRIPTION_VERIFY) { ?>true<?php  } else { ?>false<?php  } ?>,
			'tags' :  <?php echo !empty($fans_tag) ? json_encode($fans_tag) : 'null'?>,
			'curTagid' : '<?php  echo $tag_selected_id;?>',
			'syncUrl' : "<?php  echo url('mc/fans/initsync', array('acid' => $acid))?>",
			'url' : '<?php  echo url("mc/fans/tag");?>',
			'batchUrl' : "<?php  echo url('mc/fans/tag', array('acid' => $acid))?>",
			'searchMod' : {title : '精确', value : '1'}
		});
		angular.bootstrap(document, ['fansApp']);
                //加入管理员
                $(".btnStaff").click(function(){
                    var fanid = $(this).data("fanid");
                    $.post("<?php  echo url('site/entry/staff', array('op' => 'join','m' => 'wxz_piclive'));?>", {fanid : fanid}, function(data) {
			if(data.status > 0){
                            alert(data.msg);return false;
                        }else{
                            alert("加入成功！");
                            location.href = "<?php  echo url('site/entry/staff', array('op' => 'display','m' => 'wxz_piclive'));?>";
                        }	
                    }, 'json');
                });
	});
</script>

<?php  } else if($operation == 'display') { ?>
<div class="main">
<style>
.label{cursor:pointer;}
</style>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:15%;">粉丝编号</th>
                                        <th style="width:10%;">昵称</th>
					<th style="width:20%;">openid</th>
					<th style="width:10%;">时间</th>
					<th style="text-align:right; width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['fanid'];?></td>
                                        <td><?php  echo $item['nickname'];?></td>
					<td><?php  echo $item['openid'];?></td>
					<td><?php  echo $item['createtime'];?></td>
					<td style="text-align:right;">
						<a href="<?php  echo $this->createWebUrl('staff', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>&nbsp;&nbsp;
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
	</div>
</div>

<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
