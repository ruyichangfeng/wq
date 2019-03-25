<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="module-link-page">
	<ol class="breadcrumb we7-breadcrumb">
		<a href=""><i class="wi wi-back-circle"></i> </a>
		<li><a href="<?php  echo url('module/welcome', array('m' => $_GPC['m']));?>">应用详情</a></li>
		<li>关联账号列表</li>
	</ol>

	<div class="user-head-info">
		<img src="<?php  echo $module_info['logo'];?>" class="module-img we7-margin-right-sm" alt="">
		<div class="info">
			<h3 class="title"><?php  echo $module_info['title'];?></h3>
			<div class="type">
				<?php  if(is_array(uni_account_type_sign())) { foreach(uni_account_type_sign() as $type_sign => $type_info) { ?>
					<?php  $type_sign_support = $type_sign . '_support'?>
					<?php  if($module_info[$type_sign_support] == MODULE_SUPPORT_ACCOUNT) { ?><i class="<?php  echo $type_info['icon']?>"></i><?php  } ?>
				<?php  } } ?>
			</div>
		</div>
	</div>

	<div class="module-link-list">
		<?php  if(is_array($account_list)) { foreach($account_list as $sub_account) { ?>
		<div class="module-link-item">
			<a href="<?php  echo url('module/display/switch', array('module_name' => $_GPC['m'], 'uniacid' => $sub_account['uniacid']));?>" class="box">
				<img src="<?php  echo $sub_account['logo'];?>" class="account-img" alt="">
				<div class="info">
					<div class="title"><?php  echo $sub_account['name'];?></div>
					<div class="type">
						<i class="wi wi-<?php  echo $sub_account['type_sign'];?>"></i> <?php  echo $sub_account['type_name'];?>
					</div>
					<div>
						<?php  echo $sub_account['version_id'];?>
					</div>
				</div>	
				<div class="go-in">
					<i class="wi wi-angle-right"></i>
				</div>
			</a>
		</div>
		<?php  } } ?>

	</div>
</div>
	
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>