<?php defined('IN_IA') or exit('Access Denied');?><script type="text/javascript">
	function clicklink(href, title) {
		if(href=='tel:'){
			require(['util'],function(u){
				u.message('请添加一键拨号号码.');
			});
			return;
		}
		if($.isFunction(<?php  echo $callback;?>)){
			<?php  echo $callback;?>(href, title);
		}
	}
	function linkModal(a) {
		$(".link-browser").addClass('hide');
		$(".link-modal > div").addClass('hide');
		$(a).removeClass('hide');
	}
	function retrunLinkBrowser() {
		$(".link-browser").removeClass('hide');
		$(".link-modal > div").addClass('hide');
	}
	require(['util'], function (u) {
		$('.pagination a').click(function() {
			var page = $(this).attr('page');
			<?php  echo $callback;?>('', page);
		});
	});
</script>
<?php  if($do == 'modulelink') { ?>
<style type="text/css">
	.link-browser ul li{width: 120px; }
	.link-module {margin-left: 15px; }
	.list-group .list-group-item a{color:#428bca;}
	.link-browser .page-header, .link-modal .page-header{margin:25px 0 10px;}
	.link-browser .page-header:first-child, .link-modal .page-header:first-of-type{margin-top:0;}
	.link-browser div.btn, .link-modal div.btn{min-width:100px; text-align:center; margin:5px 2px;}
</style>

<div class="link-module">
	<div class="link-browser">
		<form method="post" class="form-horizontal form" enctype="multipart/form-data" >
			<div class="form-group" id="url">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<?php  if(is_array($entries)) { foreach($entries as $key => $item) { ?>
					<div class="page-header">
						<h4><i class="fa fa-folder-open-o"></i> <?php  echo $item['title'];?></h4>
					</div>
						<?php  if(is_array($item['menu'])) { foreach($item['menu'] as $entrie) { ?>
							<div class="btn btn-default" onclick="clicklink('<?php  echo $entrie['url'];?>', '<?php  echo $key;?>_menu_<?php  echo $entrie['do'];?>')" title=""><?php  echo $entrie['title'];?></div>
						<?php  } } ?>
					<?php  } } ?>
			</div>
		</form>
	</div>
</div>
<?php  } else if($do == 'page') { ?>
<div class="tab-pane active" role="tabpanel">
	<table class="table table-hover">
		<thead class="table table-hover">
			<tr>
				<th style="width: 40%;">名称</th>
				<th style="width: 30%;">创建时间</th>
				<th style="width: 30%; text-align: right">
					<div class="input-group input-group-sm">
						<input type="text" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php  if(is_array($result['list'])) { foreach($result['list'] as $list) { ?>
			<tr>
				<td><a href="#"><?php  echo $list['title'];?></a></td>
				<td><a href="#"><?php  echo $list['createtime'];?></a></td>
				<td><button class="btn btn-default select" onclick="clicklink('./index.php?i=<?php  echo $list['uniacid'];?>&c=home&a=page&id=<?php  echo $list['id'];?>')">选取</button></td>
			</tr>
		<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $result['pager'];?>
</div>
<?php  } else if($do == 'news') { ?>
<div class="tab-pane active" role="tabpanel">
	<table class="table table-hover">
		<thead class="table table-hover">
		<tr>
			<th style="width: 40%;">标题</th>
			<th style="width: 30%;"></th>
			<th style="width: 30%; text-align: right">
				<div class="input-group input-group-sm">
					<input type="text" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
						</span>
				</div>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php  if(is_array($result['list'])) { foreach($result['list'] as $list) { ?>
		<tr>
			<td><a href="#"><?php  echo $list['title'];?></a></td>
			<td><a href="#"></a></td>
			<td><button class="btn btn-default select" onclick="clicklink('./index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&id=<?php  echo $list['id'];?>&do=detail&m=news')">选取</button></td>
		</tr>
		<?php  } } ?>
		</tbody>
	</table>
	<?php  echo $result['pager'];?>
</div>
<?php  } else if($do == 'article') { ?>
<div class="tab-pane active" role="tabpanel">
	<ul role="tablist" class="nav nav-pills" style="font-size:14px; margin-top:10px; margin-bottom: 10px">
		<li role="presentation" class="active" id="li_goodslist"><a data-toggle="tab" role="tab" href="javascript:" onclick="$('#articlelist').show();$('#categorylist').hide();$('.active').removeClass();$(this).parent().addClass('active')">文章</a></li>
		<li role="presentation" class="" id="li_category"><a data-toggle="tab" role="tab" href="javascript:" onclick="$('#articlelist').hide();$('#categorylist').show();$('.active').removeClass();$(this).parent().addClass('active')">分类</a></li>
	</ul>
	<div id="articlelist">
		<table class="table table-hover">
			<thead class="table table-hover">
			<tr>
				<th style="width: 40%;">标题</th>
				<th style="width: 30%;">创建时间</th>
				<th style="width: 30%; text-align: right">
					<div class="input-group input-group-sm">
						<input type="text" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
							</span>
					</div>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php  if(is_array($result['list'])) { foreach($result['list'] as $list) { ?>
			<tr>
				<td><a href="#"><?php  echo $list['title'];?></a></td>
				<td><a href="#"></a></td>
				<td><button class="btn btn-default select" onclick="clicklink('./index.php?c=site&a=site&do=detail&id=<?php  echo $list['id'];?>&i=<?php  echo $list['uniacid'];?>')">选取</button></td>
			</tr>
			<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $result['pager'];?>
	</div>
	<div id="categorylist" class="tab-pane" role="tabpanel" style="display: none">
		<table class="table table-hover">
			<thead class="navbar-inner">
			<tr>
				<th style="width:40%;">标题</th>
				<th style="width:30%">创建时间</th>
				<th style="width:30%; text-align:right">
					<div class="input-group input-group-sm">
						<input type="text" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php  if(is_array($category)) { foreach($category as $cate) { ?>
				<tr>
					<td colspan="2"><a href="#"><?php  echo $cate['name'];?></a></td>
					<td class="text-right"><button class="btn btn-default select" onclick="clicklink('./index.php?c=site&a=site&cid=<?php  echo $cate['id'];?>&i=<?php  echo $cate['uniacid'];?>')">选取</button></td>
				</tr>
				<?php  if(is_array($cate['children'])) { foreach($cate['children'] as $child) { ?>
				<tr>
					<td colspan="2" style="padding-left:50px;height:30px;line-height:30px;background-image:url('./resource/images/bg_repno.gif'); background-repeat:no-repeat; background-position: -245px -540px;"><a href="#"><?php  echo $child['name'];?></a></td>
					<td class="text-right">
						<button class="btn btn-default select" onclick="clicklink('./index.php?c=site&a=site&cid=<?php  echo $child['id'];?>&i=<?php  echo $child['uniacid'];?>')">选取</button>
					</td>
				</tr>
				<?php  } } ?>
			<?php  } } ?>
			</tbody>
		</table>
	</div>
</div>
<?php  } else if($do == 'phone') { ?>
<div id="">
	<div class="form-group list-group-item clearfix">
		<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="margin-top:5px;">号码</label>
		<div class="col-sm-6">
			<input type="text" class="form-control" name="telphone" id="telphone" value="" />
		</div>
		<div class="col-sm-4">
			<a href="javascript:;" class="btn btn-primary" onclick="clicklink('tel:' + $('#telphone').val());">确定</a>
		</div>
	</div>
</div>
<?php  } else if($do == 'entry') { ?>
<style type="text/css">
.link-browser ul li{width: 120px; }
.list-group .list-group-item a{color:#428bca;}
.link-browser .page-header, .link-modal .page-header{margin:25px 0 10px;}
.link-browser .page-header:first-child, .link-modal .page-header:first-of-type{margin-top:0;}
.link-browser div.btn, .link-modal div.btn{min-width:100px; text-align:center; margin:5px 2px;}
</style>

<!--二级页面-->
<div class="link-modal">
	<!--一键拨号-->
	<div id="telphone-modal" class="hide">
		<ol class="breadcrumb">
			<li><a href="javascript:;" onclick="retrunLinkBrowser();">选择器首页</a></li>
			<li><a href="javascript:;" onclick="retrunLinkBrowser();">系统默认链接</a></li>
			<li class="active">一键拨号</li>
		</ol>
		<div class="form-group list-group-item clearfix">
			<label class="col-xs-12 col-sm-2 col-md-2 control-label" style="margin-top:5px;">号码</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="telphone" id="telphone" value="" />
			</div>
			<div class="col-sm-4">
				<a href="javascript:;" class="btn btn-primary" onclick="clicklink('tel:' + $('#telphone').val());">确定</a>
			</div>
		</div>
	</div>
	<?php  if(is_array($modulemenus)) { foreach($modulemenus as $moduletype => $modules) { ?>
		<?php  if(is_array($modules)) { foreach($modules as $modulekey => $module) { ?>
			<div id="<?php  echo $module['name'];?>" class="hide">
				<ol class="breadcrumb">
					<li><a href="javascript:;" onclick="retrunLinkBrowser();">选择器首页</a></li>
					<li><a href="javascript:;" onclick="retrunLinkBrowser();"><?php  echo $modtypes[$moduletype]['title'];?></a></li>
					<li class="active"><?php  echo $module['title'];?></li>
				</ol>
				<?php  if(is_array($linktypes)) { foreach($linktypes as $linktypekey => $linktype) { ?>
					<?php  if(!empty($module[$linktypekey])) { ?>
						<div class="page-header">
							<h4><i class="fa fa-folder-open-o"></i> <?php  echo $linktype;?></h4>
						</div>
						<?php  if(is_array($module[$linktypekey])) { foreach($module[$linktypekey] as $m) { ?>
							<div class="btn btn-default" onclick="clicklink('<?php  echo $m['url'];?>', '<?php  echo $m['title'];?>');" title="<?php  echo $m['title'];?>"><?php  echo cutstr($m['title'],6);?></div>
						<?php  } } ?>
					<?php  } ?>
				<?php  } } ?>
			</div>
		<?php  } } ?>
	<?php  } } ?>
</div>

<!--一级页面-->
<div class="link-browser">
	<div class="page-header">
		<h4><i class="fa fa-folder-open-o"></i> 系统默认链接</h4>
	</div>
	<?php  if(is_array($sysmenus)) { foreach($sysmenus as $m) { ?>
		<div class="btn btn-default" onclick="clicklink('<?php  echo $m['url'];?>', '<?php  echo $m['title'];?>');" title="<?php  echo $m['title'];?>"><?php  echo $m['title'];?></div>
	<?php  } } ?>
	<div class="btn btn-default" onclick="linkModal('#telphone-modal')">一键拨号</div>
	<?php  if(!empty($cardmenus)) { ?>
		<div class="page-header">
			<h4><i class="fa fa-folder-open-o"></i> 会员卡功能链接</h4>
		</div>
		<?php  if(is_array($cardmenus)) { foreach($cardmenus as $c) { ?>
		<div class="btn btn-default" onclick="clicklink('<?php  echo $c['url'];?>', '<?php  echo $c['title'];?>');" title="<?php  echo $c['title'];?>"><?php  echo $c['title'];?></div>
		<?php  } } ?>
	<?php  } ?>
	<?php  if(!empty($multimenus)) { ?>
		<div class="page-header">
			<h4><i class="fa fa-folder-open-o"></i> 多微站首页链接</h4>
		</div>
		<?php  if(is_array($multimenus)) { foreach($multimenus as $multi) { ?>
			<div class="btn btn-default" onclick="clicklink('<?php  echo $multi['url'];?>', '<?php  echo $multi['title'];?>');" title="<?php  echo $multi['title'];?>"><?php  echo $multi['title'];?></div>
		<?php  } } ?>
	<?php  } ?>
	<?php  if(is_array($modulemenus)) { foreach($modulemenus as $moduletype => $modules) { ?>
	<div class="page-header">
		<h4><i class="fa fa-folder-open-o"></i> <?php  echo $modtypes[$moduletype]['title'];?></h4>
	</div>
		<?php  if(is_array($modules)) { foreach($modules as $modulekey => $module) { ?>
		<div class="btn btn-default" onclick="linkModal('#<?php  echo $module['name'];?>', '<?php  echo $module['title'];?>')" title="<?php  echo $module['title'];?>"><?php  echo $module['title'];?></div>
		<?php  } } ?>
	<?php  } } ?>
</div>
<?php  } ?>