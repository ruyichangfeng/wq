<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<div class="skin-2" data-skin="2">
	<?php  if($_GPC['c'] == 'home' && in_array($_GPC['do'], array('system_home', 'system'))) { ?>
	<div class="skin-2__left js-home-menu">
	<?php  } else { ?>
	<div class="skin-2__left <?php  if(!$_GPC['jsMenuLock']) { ?>skin-2__left--small<?php  } ?>">
	<?php  } ?>
		<!-- logo -->
		<a class="skin-2__logo" href="<?php  echo url('home/welcome/system', array('page' => 'home'));?>">
			<img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo to_global_media($_W['setting']['copyright']['blogo'])?><?php  } else { ?>./resource/images/logo/logo.png<?php  } ?>" class="logo" width="100%">
		</a>
		<!-- end logo-->
		<!-- 一级菜单 -->
		<ul class="main-nav">
			<?php  global $top_nav?>
			<?php  $top_nav_shortcut = array()?>
			<?php  $nav_top_fold=array()?>
			<?php  $platform_url=url('account/display')?>
			<?php  $nav_top_fold[] = array('name' => 'all', 'title'=>'全部类型', 'type' => 'all', 'url' => $platform_url)?>
			<?php  if(is_array($top_nav)) { foreach($top_nav as $nav) { ?>
				<?php  if(in_array($nav['name'], array(ACCOUNT_TYPE_SIGN, WXAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN, XZAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) { ?>
					<?php  $nav_top_fold[]=$nav?>
				<?php  } else if(in_array($nav['name'], array('store', 'help', 'workorder', 'custom_help'))) { ?>
					<?php  $nav_top_tiled_other[] = $nav?>
					<?php  if(in_array($nav['name'], array('workorder'))) { ?>
						<?php  $top_nav_shortcut[] = $nav?>
					<?php  } ?>
				<?php  } else if($nav['name'] =='message') { ?>
					<?php  $nav_top_message = $nav?>
					<?php  $top_nav_shortcut[] = $nav?>
				<?php  } else { ?>
					<?php  $nav_top_tiled_system[] = $nav?>
					<?php  if(!in_array($nav['name'], array('system', 'site', 'appmarket'))) { ?>
						<?php  $top_nav_shortcut[] = $nav?>
					<?php  } ?>
				<?php  } ?>
			<?php  } } ?>

			<?php  if(is_array($nav_top_tiled_system)) { foreach($nav_top_tiled_system as $nav) { ?>
				<!-- start应用入口和平台入口特殊处理active-->
				<?php  if((FRAME == 'account' && $nav['name'] == 'platform') && !defined('IN_MODULE')) { ?><?php  $nav['name'] = FRAME?><?php  } ?>
				<?php  if(defined('IN_MODULE') && $nav['name'] == 'module') { ?><?php  $nav['name'] = 'account'?><?php  } ?>
				<!-- end应用入口和平台入口特殊处理active-->
				<li <?php  if(FRAME == $nav['name']) { ?> class="active" <?php  } ?>>
					<a href="<?php  if(empty($nav['url'])) { ?><?php  echo url('home/welcome/' . $nav['name']);?><?php  } else { ?><?php  echo $nav['url'];?><?php  } ?>" <?php  if(!empty($nav['blank'])) { ?>target="_blank"<?php  } ?>><i class="<?php  echo $nav['icon'];?>"></i><?php  echo $nav['title'];?></a>
				</li>
			<?php  } } ?>
		</ul>
		<!-- end一级菜单 -->
		<a href="javascript:;" class="js-lock-menu skin-2__lock <?php  if($_GPC['jsMenuLock']) { ?>lock<?php  } ?>">
			<div class="unlock" data-toggle="tooltip" data-placement="right" data-container="body" title="菜单锁定">
				<i class="wi wi-appjurisdiction"　></i> 
			</div>
			<div class="locked" data-toggle="tooltip" data-placement="top" data-container="body" title="点击解锁">
				菜单已锁定
			</div>
		</a>
	</div>
	<div class="skin-2__right">
		<div class="skin-2__header">
			<div class="shortcut pull-left dropdown ">
				<div class="shortcut-header" data-target="#" data-toggle="dropdown" ><i class="wi wi-menu-setting"></i>菜单</div>
				<ul class="shortcut-list ">
					<li class="shortcut-item">
						<?php  if(is_array($top_nav_shortcut)) { foreach($top_nav_shortcut as $nav) { ?>
						<div class="parent">
							<a href="<?php  if(empty($nav['url'])) { ?><?php  echo url('home/welcome/' . $nav['name']);?><?php  } else { ?><?php  echo $nav['url'];?><?php  } ?>" <?php  if(!empty($nav['blank'])) { ?>target="_blank"<?php  } ?>>
								<i class="<?php  echo $nav['icon'];?> icon"></i><?php  echo $nav['title'];?>
							</a>
						</div>
						<?php  } } ?>
					</li>
					<?php  $shortcut_menu = system_shortcut_menu()?>
					<?php  if(is_array($shortcut_menu)) { foreach($shortcut_menu as $menu) { ?>
					<?php  if(!empty($menu['section'])) { ?>
					<li class="shortcut-item">
						<div class="parent">
							<a href="<?php  echo $menu['url'];?>">
								<i class="<?php  echo $menu['icon'];?> icon"></i><?php  echo $menu['title'];?>
							</a>
						</div>
						<div class="child">
							<?php  if(is_array($menu['section'])) { foreach($menu['section'] as $section) { ?>
								<?php  if(!isset($section['is_display']) || !empty($section['is_display'])) { ?>
									<?php  if(is_array($section['menu'])) { foreach($section['menu'] as $nav) { ?>
										<?php  if(!empty($nav['is_display'])) { ?>
										<div class="item text-over">
											<a href="<?php  echo $nav['url'];?>">
												<i class="<?php  echo $nav['icon'];?> icon"></i><?php  echo $nav['title'];?>
											</a>
										</div>
										<?php  } ?>
									<?php  } } ?>
								<?php  } ?>
							<?php  } } ?>
						</div>
					</li>
					<?php  } ?>
					<?php  } } ?>
				</ul>
				<div class=""></div>
			</div>
			<?php  if(!empty($_W['uid'])) { ?>
			<ul class="user-info">
				<?php  if(is_array($nav_top_tiled_other)) { foreach($nav_top_tiled_other as $other) { ?>
				<?php  if($other['is_display']) { ?>
				<?php  if($other['name'] == 'workorder' && !permission_check_account_user('see_workorder')) { ?><?php  continue;?><?php  } ?>
				<li>
					<a href="<?php  echo $other['url'];?>" ><i class="<?php  echo $other['icon'];?> color-gray" ></i><?php  echo $other['title'];?></a>
				</li>
				<?php  } ?>
				<?php  } } ?>

				<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-notice', TEMPLATE_INCLUDEPATH)) : (include template('common/header-notice', TEMPLATE_INCLUDEPATH));?>
				
				<!-- 用户信息 -->
				<li class="dropdown user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="wi wi-user"></i><?php  echo $_W['user']['username'];?><span class="caret"></span></a>
					<ul class="dropdown-menu color-gray dropdown-menu-right" role="menu">
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
				<!-- end用户信息 -->
			</ul>
			<?php  } else { ?>
			<ul class="user-info">
				<li class="dropdown"><a href="<?php  echo url('user/register');?>">注册</a></li>
				<li class="dropdown"><a href="<?php  echo url('user/login');?>">登录</a></li>
			</ul>
			<?php  } ?>
		</div>
		<div class="skin-2__content main">
			<?php  if(!defined('IN_MESSAGE')) { ?>
				<?php  if($frames['dimension'] == 3 && in_array(FRAME, array('account', 'system', 'advertisement', 'wxapp', 'site', 'webapp', 'phoneapp', 'xzapp')) && !in_array($_GPC['a'], array('news-show', 'notice-show'))) { ?>
				<div class="skin-2__sub">
					<div class="sub-top">
						<!-- 模块信息 -->
						<?php  if(!empty($_GPC['m']) && !in_array($_GPC['m'], array('keyword', 'special', 'welcome', 'default', 'userapi', 'service', 'apply')) || defined('IN_MODULE')) { ?>
						<div class="apply-fixed-top">
							<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-module', TEMPLATE_INCLUDEPATH)) : (include template('common/header-module', TEMPLATE_INCLUDEPATH));?>
						</div>
						<!-- 模块信息 -->
						<?php  } else { ?>
						<div class="left-menu-top-panel">
							<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-' . FRAME, TEMPLATE_INCLUDEPATH)) : (include template('common/header-' . FRAME, TEMPLATE_INCLUDEPATH));?>
						</div>
						<?php  } ?>
					</div>
					
					<!-- 二级菜单-->
					<div class="js-menu" id="js-menu-<?php echo FRAME;?><?php  echo $_W['account']['uniacid'];?>">
					<?php  if(is_array($frames['section'])) { foreach($frames['section'] as $frame_section_id => $frame_section) { ?>
						
						<?php  if(!isset($frame_section['is_display']) || !empty($frame_section['is_display'])) { ?>
						<div class="panel panel-menu">
							<?php  if($frame_section['title']) { ?>
							<div class="panel-heading">
								<span class="<?php  if($_GPC['menu_fold_tag:'.$frame_section_id] == 1) { ?>collapsed<?php  } ?>" data-toggle="collapse" data-target="#frame-<?php  echo $frame_section_id;?>" onclick="util.cookie.set('menu_fold_tag:<?php  echo $frame_section_id;?>', util.cookie.get('menu_fold_tag:<?php  echo $frame_section_id;?>') == 1 ? 0 : 1)">
									<span class="nav-title"><?php  echo $frame_section['title'];?><i class="wi wi-angle-down pull-right setting"></i></span>
								</span>
							</div>
							<?php  } ?>
							<ul class="list-group collapse <?php  if($_GPC['menu_fold_tag:'.$frame_section_id] == 0) { ?>in<?php  } ?>" id="frame-<?php  echo $frame_section_id;?>" >
								<?php  if(is_array($frame_section['menu'])) { foreach($frame_section['menu'] as $menu_id => $menu) { ?>
									<?php  if(!empty($menu['is_display'])) { ?>
										<?php  if($menu_id == 'platform_module_plugin_more' || $menu_id == 'platform_module_more') { ?>
										<li class="list-group-item">
											<a href="<?php  echo $menu['url']?>" class="text-over">
												<span class="nav-icon" ><span class="icon-more"><i class="wi wi-plus"></i></span></span>
												<span class="nav-title"><?php  echo $menu['title'];?></span>
											</a>
										</li>
										<?php  } else { ?>
										<?php  if($menu['active']) { ?><?php  $active_sub_permission = $menu['sub_permission'];?><?php  } ?>
										<li class="list-group-item list-group-item-plugin <?php  if($menu['active']) { ?>active<?php  } ?>">
											<?php  if($frame_section_id == 'platform_module_plugin' && !empty($_GPC['m']) && $_GPC['m'] != $menu['main_module']) { ?>
											<a class="back" href="<?php  echo url('module/welcome', array('m' => $menu['main_module'], 'uniacid' => $_W['uniacid']))?>" >
												<i class="wi wi-angle-left"></i>
											</a>
											<?php  } ?>
											<a href="<?php  echo $menu['url'];?>" class="text-over" <?php  if($frame_section_id == 'platform_module') { ?>target="_blank"<?php  } ?>>
												<span class="nav-icon" >
													<?php  if($frame_section_id == 'platform_module' || $frame_section_id == 'platform_module_plugin') { ?>
													<img src="<?php  echo $menu['icon'];?>"/>
													<?php  } else { ?>
													<i class="<?php  echo $menu['icon'];?>"></i>
													<?php  } ?>
												</span>
												<span class="nav-title"><?php  echo $menu['title'];?></span>
											</a>
										</li>
										<?php  } ?>
									<?php  } ?>
								<?php  } } ?>
							</ul>
						</div>
						<?php  } ?>
					<?php  } } ?>
					</div>
					<!-- end二级菜单-->
				</div>
				<?php  } ?>
				<div class="skin-2__container container">
						<div class="content">
						<?php  if(!empty($_W['page']['title']) && $frames['title'] != '首页' && !empty($frames['title']) && !defined('IN_MODULE')) { ?>
							<div class="we7-page-title"><?php  echo $_W['page']['title'];?></div>
						<?php  } ?>
						<?php  if($frames['dimension'] == 2) { ?>
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
