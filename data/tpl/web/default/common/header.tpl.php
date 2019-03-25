<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<div data-skin="default" class="skin-default <?php  if($_GPC['main-lg']) { ?> main-lg-body <?php  } ?>">
<div class="head mixMenu-head">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container <?php  if(!empty($frames['section']['platform_module_menu']['plugin_menu'])) { ?>plugin-head<?php  } ?>">
			<div class="navbar-header">
					<a class="navbar-brand" href="<?php  echo url('home/welcome/system', array('page' => 'home'));?>">
					<img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo to_global_media($_W['setting']['copyright']['blogo'])?><?php  } else { ?>./resource/images/logo/logo.png<?php  } ?>" class="pull-left" width="110px" height="35px">
					<span class="version hidden"><?php echo IMS_VERSION;?></span>
				</a>
			</div>
			<?php  if(!empty($_W['uid'])) { ?>
			<div class="collapse navbar-collapse">
				<style>
					.nav > li:hover .dropdown-menu {display: block;}
				</style>
				<?php  global $top_nav?>
				<?php  $nav_top_fold=array()?>
				<?php  $platform_url=url('account/display')?>
				<?php  $nav_top_fold[] = array('name' => 'all', 'title'=>'全部类型', 'type' => 'all', 'url' => $platform_url)?>
				<?php  if(is_array($top_nav)) { foreach($top_nav as $nav) { ?>
					<?php  if(in_array($nav['name'], array(ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN, XZAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) { ?>
						<?php  $nav_top_fold[]=$nav?>
					<?php  } else if(in_array($nav['name'], array('store', 'help', 'workorder', 'custom_help'))) { ?>
						<?php  $nav_top_tiled_other[] = $nav?>
					<?php  } else if($nav['name'] =='message') { ?>
						<?php  $nav_top_message = $nav?>
					<?php  } else { ?>
						<?php  $nav_top_tiled_system[] = $nav?>
					<?php  } ?>
				<?php  } } ?>
				<ul class="nav navbar-nav  navbar-left">
					<?php  if(is_array($nav_top_tiled_system)) { foreach($nav_top_tiled_system as $nav) { ?>
					<li <?php  if(FRAME == $nav['name'] && !defined('IN_MODULE')) { ?> class="active" <?php  } ?>>
					<a href="<?php  echo $nav['url'];?>" <?php  if(!empty($nav['blank'])) { ?>target="_blank"<?php  } ?>><?php  echo $nav['title'];?></a>
					</li>
					<?php  } } ?>
				</ul>

				<ul class="nav navbar-nav navbar-right ">
					<?php  if(is_array($nav_top_tiled_other)) { foreach($nav_top_tiled_other as $other) { ?>
					<?php  if($other['is_display']) { ?>
					<?php  if($other['name'] == 'workorder' && !permission_check_account_user('see_workorder')) { ?><?php  continue;?><?php  } ?>
					<li>
						<a href="<?php  echo $other['url'];?>" ><i class="<?php  echo $other['icon'];?> color-gray" data-toggle="tooltip"  data-placement="bottom"></i><?php  echo $other['title'];?></a>
					</li>
					<?php  } ?>
					<?php  } } ?>

					<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-notice', TEMPLATE_INCLUDEPATH)) : (include template('common/header-notice', TEMPLATE_INCLUDEPATH));?>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="wi wi-user color-gray"></i><?php  echo $_W['user']['username'];?> <span class="caret"></span></a>
						<ul class="dropdown-menu color-gray" role="menu">
							<li>
								<a href="<?php  echo url('user/profile');?>" target="_blank"><i class="wi wi-money color-gray"></i> 我的账号</a>
							</li>
							<li class="divider"></li>

							<?php  if(permission_check_account_user('see_system_upgrade')) { ?>
							<li><a href="<?php  echo url('cloud/upgrade');?>" target="_blank"><i class="wi wi-update color-gray"></i> 自动更新</a></li>
							<?php  } ?>
							<?php  if(permission_check_account_user('see_system_updatecache')) { ?>
							<li><a href="<?php  echo url('system/updatecache');?>" target="_blank"><i class="wi wi-cache color-gray"></i> 更新缓存</a></li>
							<li class="divider"></li>
							<?php  } ?>
							<li>
								<a href="<?php  echo url('user/logout');?>"><i class="fa fa-sign-out color-gray"></i> 退出系统</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<?php  } else { ?>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><a href="<?php  echo url('user/register');?>">注册</a></li>
					<li class="dropdown"><a href="<?php  echo url('user/login');?>">登录</a></li>
				</ul>
			</div>
			<?php  } ?>
		</div>
	</nav>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-renew-account', TEMPLATE_INCLUDEPATH)) : (include template('common/header-renew-account', TEMPLATE_INCLUDEPATH));?>
<div class="main">
	<?php  if(!defined('IN_MESSAGE')) { ?>
	<div class="container">
		<a href="javascript:;" class="js-big-main button-to-big color-gray" title="加宽"><?php  if($_GPC['main-lg']) { ?>正常<?php  } else { ?>宽屏<?php  } ?></a>
		<?php  if($frames['dimension'] == 3 && defined('FRAME') && in_array(FRAME, array('account', 'system', 'wxapp', 'site', 'store', 'webapp', 'phoneapp', 'xzapp')) && !in_array($_GPC['a'], array('news-show', 'notice-show'))) { ?>
		<div class="panel panel-content main-panel-content <?php  if(!empty($frames['section']['platform_module_menu']['plugin_menu'])) { ?>panel-content-plugin<?php  } ?>">
			<div class="content-head panel-heading main-panel-heading">
				<?php  if(($_GPC['c'] != 'cloud' && !empty($_GPC['m']) && !in_array($_GPC['m'], array('keyword', 'special', 'welcome', 'default', 'userapi', 'service', 'apply'))) || defined('IN_MODULE')) { ?>
					<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-module', TEMPLATE_INCLUDEPATH)) : (include template('common/header-module', TEMPLATE_INCLUDEPATH));?>
				<?php  } else { ?>
					<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-' . FRAME, TEMPLATE_INCLUDEPATH)) : (include template('common/header-' . FRAME, TEMPLATE_INCLUDEPATH));?>
				<?php  } ?>
			</div>

			<div class="panel-body clearfix main-panel-body <?php  if(!empty($_W['setting']['copyright']['leftmenufixed'])) { ?>menu-fixed<?php  } ?>">
				<div class="left-menu">
					<?php  if(empty($frames['section']['platform_module_menu']['plugin_menu'])) { ?>
					<div class="left-menu-content">
						<?php  if(is_array($frames['section'])) { foreach($frames['section'] as $frame_section_id => $frame_section) { ?>

						
						
						<?php  if(FRAME == 'store' && !($_W['isfounder']) && !empty($frame_section['founder'])) { ?>
						<?php  continue;?>
						<?php  } ?>
						

						<?php  if(!isset($frame_section['is_display']) || !empty($frame_section['is_display'])) { ?>
						<div class="panel panel-menu">
							<?php  if($frame_section['title']) { ?>
							<div class="panel-heading">
								<span class="no-collapse" data-toggle="collapse" data-target="#frame-<?php  echo $frame_section_id;?>" onclick="util.cookie.set('menu_fold_tag:<?php  echo $frame_section_id;?>', util.cookie.get('menu_fold_tag:<?php  echo $frame_section_id;?>') == 1 ? 0 : 1)"><?php  echo $frame_section['title'];?><i class="wi wi-down-sign-s pull-right setting"></i></span>
							</div>
							<?php  } ?>

							<ul class="list-group collapse <?php  if($_GPC['menu_fold_tag:'.$frame_section_id] == 0) { ?>in<?php  } ?>" id="frame-<?php  echo $frame_section_id;?>">
								<?php  if(is_array($frame_section['menu'])) { foreach($frame_section['menu'] as $menu_id => $menu) { ?>
									<?php  if(!empty($menu['is_display'])) { ?>
										<?php  if($menu_id == 'platform_module_plugin_more' || $menu_id == 'platform_module_more') { ?>
											<li class="list-group-item list-group-more">
												<a href="<?php  echo $menu['url']?>"><span class="label label-more">更多应用</span></a>
											</li>
										<?php  } else { ?>
											<?php  if($menu['active']) { ?><?php  $active_sub_permission = $menu['sub_permission']?><?php  } ?>
											<?php  if((in_array($_W['role'], array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER)) && $menu_id == 'front_download' || $menu_id != 'front_download') && !($menu_id == 'platform_menu' && $_W['account']['level'] == ACCOUNT_SUBSCRIPTION) || $_W['account']['type'] == ACCOUNT_TYPE_XZAPP_NORMAL) { ?>
											<li class="list-group-item <?php  if($menu['active']) { ?>active<?php  } ?>">
												<a href="<?php  echo $menu['url'];?>" class="text-over" <?php  if($frame_section_id == 'platform_module') { ?>target="_blank"<?php  } ?>>
													<?php  if($frame_section_id == 'platform_module' || $frame_section_id == 'platform_module_plugin') { ?>
														<img src="<?php  echo $menu['icon'];?>"/>
													<?php  } else { ?>
														<i class="<?php  echo $menu['icon'];?>"></i>
													<?php  } ?>
												<?php  echo $menu['title'];?>
												<?php  if(!empty($menu['need_upload']) && $action != 'front-download') { ?><i class="wi wi-info-sign color-red" style="font-size:14px;position:relative;bottom:4px"></i><?php  } ?>
												</a>
											</li>
											<?php  } ?>
										<?php  } ?>
									<?php  } ?>
								<?php  } } ?>
							</ul>
						</div>
						<?php  } ?>
						<?php  } } ?>
					</div>
					<?php  } else { ?>
						<div class="plugin-menu clearfix">
							<div class="plugin-menu-main pull-left">
								<ul class="list-group">
									<li class="list-group-item<?php  if($_W['current_module']['name'] == $frames['section']['platform_module_menu']['plugin_menu']['main_module']) { ?> active<?php  } ?>">
										<a href="<?php  echo url('home/welcome/ext', array('m' => $frames['section']['platform_module_menu']['plugin_menu']['main_module'], 'version_id' => intval($_GPC['version_id'])))?>">
											<i class="wi wi-main-apply"></i>
											<div>主应用</div>
										</a>
									</li>
									<li class="list-group-item">
										<div>插件</div>
									</li>
									<?php  if(is_array($frames['section']['platform_module_menu']['plugin_menu']['menu'])) { foreach($frames['section']['platform_module_menu']['plugin_menu']['menu'] as $plugin_name => $plugin) { ?>
									<li class="list-group-item<?php  if($_W['current_module']['name'] == $plugin_name) { ?> active<?php  } ?>">
										<a href="<?php  echo url('home/welcome/ext', array('m' => $plugin_name, 'version_id' => intval($_GPC['version_id'])))?>">
											<img src="<?php  echo $plugin['icon'];?>" alt="" class="img-icon" />
											<div><?php  echo $plugin['title'];?></div>
										</a>
									</li>
									<?php  } } ?>
								</ul>
								<?php  unset($plugin_name);?>
								<?php  unset($plugin);?>
							</div>
							<div class="plugin-menu-sub pull-left">
								<?php  if(is_array($frames['section'])) { foreach($frames['section'] as $frame_section_id => $frame_section) { ?>
								<?php  if(!isset($frame_section['is_display']) || !empty($frame_section['is_display'])) { ?>
									<div class="panel panel-menu">
										<?php  if($frame_section['title']) { ?>
										<div class="panel-heading">
											<span class="no-collapse"><?php  echo $frame_section['title'];?><i class="wi wi-appsetting pull-right setting"></i></span>
										</div>
										<?php  } ?>
										<ul class="list-group panel-collapse">
											<?php  if(is_array($frame_section['menu'])) { foreach($frame_section['menu'] as $menu_id => $menu) { ?>
											<?php  if(!empty($menu['is_display'])) { ?>
											<?php  if($menu_id == 'platform_module_more') { ?>
											<li class="list-group-item list-group-more">
												<a href="<?php  echo url('module/manage-account');?>"><span class="label label-more">更多应用</span></a>
											</li>
											<?php  } else { ?>
											<li class="list-group-item <?php  if($menu['active']) { ?>active<?php  } ?>">
												<a href="<?php  echo $menu['url'];?>" class="text-over" <?php  if($frame_section_id == 'platform_module') { ?>target="_blank"<?php  } ?>>
												<?php  if($menu['icon']) { ?>
													<?php  if($frame_section_id == 'platform_module') { ?>
													<img src="<?php  echo $menu['icon'];?>"/>
													<?php  } else { ?>
													<i class="<?php  echo $menu['icon'];?>"></i>
													<?php  } ?>
												<?php  } ?>
												<?php  echo $menu['title'];?>
												</a>
											</li>
											<?php  } ?>
											<?php  } ?>
											<?php  } } ?>
										</ul>
									</div>
								<?php  } ?>
								<?php  } } ?>

								<div class="panel panel-menu">
									<div class="panel-heading">
										<span class="no-collapse">
											常用插件
											<i class="wi wi-appsetting pull-right setting"></i>
										</span>
									</div>

									<ul class="list-group panel-collapse">
										<?php  if(is_array($frames['section']['platform_module_menu']['plugin_menu']['menu'])) { foreach($frames['section']['platform_module_menu']['plugin_menu']['menu'] as $plugin_name => $plugin) { ?>
										<li class="list-group-item <?php  if($menu['active']) { ?>active<?php  } ?>">
											<a href="<?php  echo url('home/welcome/ext', array('m' => $plugin_name, 'version_id' => intval($_GPC['version_id'])))?>" class="text-over">
											<img src="<?php  echo $plugin['icon'];?>"/><span><?php  echo $plugin['title'];?></span>
											</a>
										</li>
										<?php  } } ?>
										<li class="list-group-item list-group-more">
											<a href="<?php  echo url('module/plugin', array('m' => $frames['section']['platform_module_menu']['plugin_menu']['main_module'], 'version_id' => intval($_GPC['version_id']), 'uniacid' => $_W['uniacid']))?>"><span class="label label-more">更多插件</span></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					<?php  } ?>
				</div>
				<div class="right-content">
					<div class="we7-page-title"><?php  if(empty($_W['page']['title']) && $frames['title'] != '首页') { ?><?php  echo $frames['title'];?><?php  } else { ?><?php  echo $_W['page']['title'];?><?php  } ?></div>
		<?php  } ?>

		<?php  if($frames['dimension'] == 2) { ?>
		<div class="panel panel-content main-panel-content">
			<div class="panel-body clearfix main-panel-body <?php  if(!empty($_W['setting']['copyright']['leftmenufixed'])) { ?>menu-fixed<?php  } ?>">
				<div class="right-content">
					<?php  if(!empty($_W['page']['title']) && $frames['title'] != '首页' && !empty($frames['title']) && !defined('IN_MODULE')) { ?>
					<div class="we7-page-title"><?php  echo $_W['page']['title'];?></div>
					<?php  } ?>
					<!-- start用户管理菜单和消息管理菜单特殊,走自己的we7-page-tab,故加此if判断;平台/应用/我的账户无we7-page-table -->
					<?php  if(!in_array(FRAME, array('user_manage', 'message', 'platform', 'module', 'myself'))) { ?>
					<ul class="we7-page-tab">
						<?php  $have_right_content_menu = 0;?>
						<?php  if(is_array($frames['section'][FRAME]['menu'])) { foreach($frames['section'][FRAME]['menu'] as $menu_id => $menu) { ?>
						<?php  if(in_array(FRAME, array('account_manage', 'permission'))) { ?>
						<?php  if(permission_check_account_user('see_' . $menu['permission_name'])) { ?>
						<li class="<?php  if($menu['active']) { ?>active<?php  } ?>"><a href="<?php  echo $menu['url'];?>"><?php  echo $menu['title'];?></a></li>
						<?php  } ?>
						<?php  } else { ?>
						<li class="<?php  if($menu['active']) { ?>active<?php  } ?>">
							<a href="<?php  echo $menu['url'];?>">
								<?php  echo $menu['title'];?>
								<!-- start应用管理中未安装应用数量 -->
								<?php  if(FRAME == 'module_manage' && $menu_id == 'module_manage_not_installed') { ?><span class="color-red"> (<?php  echo $module_uninstall_total;?>) </span><?php  } ?>
								<!-- end应用管理中未安装应用数量 -->
							</a>
						</li>
						<?php  } ?>
						<?php  if($menu['active']) { ?><?php  $have_right_content_menu = 1;?><?php  } ?>
						<?php  } } ?>
					</ul>
					<script>
						$(function(){
							<?php  if(empty($have_right_content_menu)) { ?>
							$('.we7-page-tab, .we7-page-title').addClass('hidden');
							<?php  } ?>
							});
					</script>
					<?php  } ?>
					<!-- end用户管理菜单和消息管理菜单特殊,走自己的we7-page-tab;平台/应用/我的账户无we7-page-table -->
		<?php  } ?>
	<?php  } ?>