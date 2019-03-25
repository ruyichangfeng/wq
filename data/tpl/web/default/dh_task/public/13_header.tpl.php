<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header-base', TEMPLATE_INCLUDEPATH)) : (include template('public/header-base', TEMPLATE_INCLUDEPATH));?>
<style>
	.nav.nav-tabs{border-color:#20a0ff;}
	.nav-tabs>li>a:hover{border-color:#eee #eee #20a0ff #eee;}
	.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{background-color:#20a0ff; border-color:#20a0ff;}
	.nav-tabs>li>a {border-radius: 0 0 0 0;}
	.nav{background-color: white;}
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
		color: #FFF;
		background-color: #20a0ff;
		border-color: #20a0ff;}
	.list-group .list-group-item.active {
		background-color: #20a0ff;
		border-color: #20a0ff;
	}
	.navbar-inverse {
		background-color: #fff;
		border-color: #20a0ff
	}
	.block {
		display: block;
	}

	.clear {
		display: block;
		overflow: hidden;
	}
	.navbar-nav > li > a {
		padding-top: 10px;
		padding-bottom: 10px;
		line-height: 40px
	}
	.navbar-inverse .navbar-nav>li>a:hover, .navbar-inverse .navbar-nav>li>a:focus{
		color: #777;
		background-color: #eee;
	}
	.big-menu .panel .panel-heading .panel-title,.big-menu .panel .list-group-item{overflow:hidden; white-space:normal; text-overflow:clip;}
	.panel>.list-group .list-group-item{padding-left: 34px;}

	.btn-primary {
		color: #fff;
		background-color: #0066cd;
		border-color: #0066cd;
	}

	.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active,
	.open > .dropdown-toggle.btn-primary {
		color: #fff;
		background-color: #0066cd;
		border-color: #0066cd;
	}


	.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:hover, .navbar-inverse
	.navbar-nav>.active>a:focus{
		color: #f60;
		background-color: #e7e7e7;
		border-bottom: 2px solid transparent;
		border-color: #f60;

		/*height: 32px;*/
		/*line-height: 32px;*/
		/*margin: 18px 0 23px 0;*/
		/*display: block;*/
		/*font-size: 16px;*/
		/*color: #333;*/
		/*box-sizing: border-box;*/
		/*position: relative;*/
		/*border-radius: 5px;*/
		/*text-align: center*/
	}
</style>
<div class="navbar navbar-inverse navbar-static-top" role="navigation" style="position:static;border-top: 4px solid #20a0ff;background-color: #fff;border-bottom: 0px solid #d9dadc;">
	<div class="col-xs-12 col-sm-3 col-lg-2">
		<div style="height: 60px;background: transparent url(<?php  echo $_W['siteroot'];?>addons/dh_task/template/images/logo.png) center no-repeat;background-color:white;background-size: 100% auto;"></div>
	</div>
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li><a href="index.php?c=home&a=welcome&do=platform&"><i class="fa fa-reply-all"></i>返回系统</a></li>
			<li><a href="<?php  echo $this->createWebUrl('fans', array('op' => 'display'))?>"><i class="fa fa-user"></i>用户管理</a></li>
			<li><a href="<?php  echo $this->createWebUrl('task', array('op' => 'display'))?>"><i class="fa fa-th"></i>任务管理</a></li>
			<li><a href="<?php  echo $this->createWebUrl('settings', array('op' => 'display'))?>"><i class="fa fa-cog"></i>系统设置</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="display:block; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "><i class="fa fa-group"></i><?php  echo $_W['account']['name'];?> <b class="caret"></b></a>
				<?php  if($_W['role'] != 'operator') { ?>
				<ul class="dropdown-menu">
					<li><a href="<?php  echo url('account/post', array('uniacid' => $_W['uniacid']));?>" target="_blank"><i class="fa fa-weixin fa-fw"></i> 编辑当前账号资料</a></li>
					<li><a href="<?php  echo url('account/display');?>" target="_blank"><i class="fa fa-cogs fa-fw"></i> 管理其它公众号</a></li>
					<li><a href="<?php  echo url('utility/emulator');?>" target="_blank"><i class="fa fa-mobile fa-fw"></i> 模拟测试</a></li>
				</ul>
				<?php  } ?>
			</li>
			<li class="dropdown">
				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="display:block; max-width:185px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "><i class="fa fa-user"></i><?php  echo $_W['user']['username'];?> (<?php  if($_W['role'] == 'founder') { ?>系统管理员<?php  } else if($_W['role'] == 'manager') { ?>公众号管理员<?php  } else { ?>公众号操作员<?php  } ?>) <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php  if($_W['role'] != 'operator') { ?>
					<li><a href="<?php  echo url('user/profile/profile');?>" target="_blank"><i class="fa fa-weixin fa-fw"></i> 我的账号</a></li>
					<li class="divider"></li>
					<li><a href="<?php  echo url('system/welcome');?>" target="_blank"><i class="fa fa-sitemap fa-fw"></i> 系统选项</a></li>
					<li><a href="<?php  echo url('system/welcome');?>" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> 自动更新</a></li>
					<li><a href="<?php  echo url('system/updatecache');?>" target="_blank"><i class="fa fa-refresh fa-fw"></i> 更新缓存</a></li>
					<li class="divider"></li>
					<?php  } ?>
					<li><a href="<?php  echo url('user/logout');?>"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>

<div class="container-fluid">
	<?php  if(defined('IN_MESSAGE')) { ?>
	<div class="jumbotron clearfix alert alert-<?php  echo $label;?>">
		<div class="row">
			<div class="col-xs-12 col-sm-3 col-lg-2">
				<i class="fa fa-5x fa-<?php  if($label=='success') { ?>check-circle<?php  } ?><?php  if($label=='danger') { ?>times-circle<?php  } ?><?php  if($label=='info') { ?>info-circle<?php  } ?><?php  if($label=='warning') { ?>exclamation-triangle<?php  } ?>"></i>
			</div>
			<div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
				<?php  if(is_array($msg)) { ?>
				<h2>MYSQL 错误：</h2>
				<p><?php  echo cutstr($msg['sql'], 300, 1);?></p>
				<p><b><?php  echo $msg['error']['0'];?> <?php  echo $msg['error']['1'];?>：</b><?php  echo $msg['error']['2'];?></p>
				<?php  } else { ?>
				<h2><?php  echo $caption;?></h2>
				<p><?php  echo $msg;?></p>
				<?php  } ?>
				<?php  if($redirect) { ?>
				<p><a href="<?php  echo $redirect;?>">如果你的浏览器没有自动跳转，请点击此链接</a></p>
				<script type="text/javascript">
					setTimeout(function () {
						location.href = "<?php  echo $redirect;?>";
					}, 3000);
				</script>
				<?php  } else { ?>
				<p>[<a href="javascript:history.go(-1);">点击这里返回上一页</a>] &nbsp; [<a href="./?refresh">首页</a>]</p>
				<?php  } ?>
			</div>
			<?php  } else { ?>
			<div class="row">
				<?php $frames = empty($frames) ? $GLOBALS['frames'] : $frames; _calc_current_frames($frames);?>
				<?php  if(!empty($frames)) { ?>
				<div class="col-xs-12 col-sm-3 col-lg-2 big-menu">
					<?php  if($cur_store) { ?>
					<div class="panel panel-default" style="padding-bottom: 10px;padding-top: 5px;">
						<span style="width:13.3333337%; height:160px;display: table-cell; line-height:160px; vertical-align:middle;text-align: center;padding-top: 5px;">
							<img style="display: inline-block;width: 160px;height: 160px;
box-sizing: border-box;margin-top:10px;padding: 10px;border: 1px solid #f2f2f2;box-sizing: border-box;max-width: 100%;" alt="image" src="<?php  echo tomedia($cur_store['logo'])?>" onerror="this.src='../addons/dh_task/template/images/logo.png';"/>
						</span>
						<a href="#" >
							<span style="text-align:center;margin-top: 8px;" class="block m-t-xs"><strong class="font-bold"><?php  echo $cur_store['title'];?></strong></span>
							<span style="text-align:center;" class="text-muted text-xs block"><strong class="font-bold"><?php  echo $_W['user']['username'];?></strong>(<?php  if($_W['role'] == 'founder') { ?>系统管理员<?php  } else if($_W['role'] == 'manager') { ?>公众号管理员<?php  } else { ?>门店管理员<?php  } ?>)</span>
						</a>
					</div>
					<?php  } ?>
					<?php  if(is_array($frames)) { foreach($frames as $k => $frame) { ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"><?php  echo $frame['title'];?></h4>
							<a class="panel-collapse collapsed" data-toggle="collapse" href="#frame-<?php  echo $k;?>">
								<i class="fa fa-chevron-circle-down"></i>
							</a>
						</div>
						<ul class="list-group collapse in" id="frame-<?php  echo $k;?>">
							<?php  if(is_array($frame['items'])) { foreach($frame['items'] as $link) { ?>
							<?php  if(!empty($link['append'])) { ?>
							<li class="list-group-item<?php  echo $link['active'];?>" onclick="window.location.href = '<?php  echo $link['url'];?>';" style="cursor:pointer;" kw="<?php  echo $link['title'];?>">
								<?php  echo $link['title'];?>
								<a class="pull-right" href="<?php  echo $link['append']['url'];?>"><?php  echo $link['append']['title'];?></a>
							</li>
							<?php  } else { ?>
							<a class="list-group-item<?php  echo $link['active'];?>" href="<?php  echo $link['url'];?>" kw="<?php  echo $link['title'];?>" style="padding-left: 40px;"><?php  echo $link['title'];?></a>
							<?php  } ?>
							<?php  } } ?>
						</ul>
					</div>
					<?php  } } ?>
					<script type="text/javascript">
						require(['bootstrap'], function(){
							$('#search-menu input').keyup(function() {
								var a = $(this).val();
								$('.big-menu .list-group-item, .big-menu .panel-heading').hide();
								$('.big-menu .list-group-item').each(function() {
									$(this).css('border-left', '0');
									if(a.length > 0 && $(this).attr('kw').indexOf(a) >= 0) {
										$(this).parents(".panel").find('.panel-heading').show();
										$(this).show().css('border-left', '3px #428bca double');
									}
								});
								if(a.length == 0) {
									$('.big-menu .list-group-item, .big-menu .panel-heading').show();
								}
							});
						});
					</script>
				</div>
				<div class="col-xs-12 col-sm-9 col-lg-10">
					<style>.topNav{border-bottom-color: rgb(0, 0, 0);border-bottom-width: 0.1em;border-bottom-style: inset;}</style>
					<?php  if(CRUMBS_NAV == 1) { ?>
					<?php  global $module_types;global $module;global $ptr_title;?>
					<?php $frames = empty($frames) ? $GLOBALS['frames'] : $frames; _calc_current_frames($frames);?>
					<script language='javascript'>
						$(function(){
							$(".breadcrumb").remove();
						})
					</script>

					<ol class="breadcrumb" style="padding:5px 0;">
						<li><a href="<?php  echo url('home/welcome/ext');?>"><i class="fa fa-cogs"></i> &nbsp; 扩展功能</a></li>
						<li><a href="<?php  echo url('home/welcome/ext', array('m' => $module['name']));?>"><?php  echo $module_types[$module['type']]['title'];?>模块 - <?php  echo $module['title'];?></a></li>
						<li class="active"><?php  echo $ptr_title;?></li>
					</ol>
					<?php  } else if(CRUMBS_NAV == 2) { ?>
					<?php  global $module_types;global $module;global $ptr_title; global $site_urls; $m = $_GPC['m'];?>
					<ul class="nav nav-tabs">
						<li><a href="<?php  echo url('platform/reply', array('m' => $m));?>">管理<?php  echo $module['title'];?></a></li>
						<li><a href="<?php  echo url('platform/reply/post', array('m' => $m));?>"><i class="fa fa-plus"></i> 添加<?php  echo $module['title'];?></a></li>
						<?php  if(!empty($site_urls)) { ?>
						<?php  if(is_array($site_urls)) { foreach($site_urls as $site_url) { ?>
						<li <?php  if($_GPC['do'] == $site_url['do']) { ?> class="active"<?php  } ?>><a href="<?php  echo $site_url['url'];?>"> <?php  echo $site_url['title'];?></a></li>
						<?php  } } ?>
						<?php  } ?>
					</ul>
					<?php  } ?>
					<?php  } else { ?>
					<div>
						<?php  } ?>
						<?php  } ?>
