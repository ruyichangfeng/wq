<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-cut" id="js-account-display">
	<div class="panel-heading">
		<span class="panel-heading-left"><i class="wi wi-wechat" style="font-size: 24px; margin-right: 10px; vertical-align:middle;"></i>请选择您要操作的PC</span>
		<div class="font-default pull-right">
			

			
				<?php  if(!empty($account_info['webapp_limit']) || $_W['isfounder']) { ?>
				<a href="./index.php?c=webapp&a=manage&do=create_display" class="color-default"><i class="fa fa-plus"></i>新增PC</a>
				<?php  } ?>
			

			<?php  if($state == ACCOUNT_MANAGE_NAME_FOUNDER || $state == ACCOUNT_MANAGE_NAME_MANAGER) { ?>
			<a href="<?php  echo url('account/manage', array('account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL))?>" class="color-default"><i class="wi wi-wechatstatistics"></i>PC管理</a>
			<?php  } ?>
		</div>
	</div>
	<div class="panel-body" >
		<?php  if(!$_W['isfounder'] && !empty($account_info['webapp_limit'])) { ?>
		<div class="alert alert-warning hidden">
			温馨提示：
			<i class="fa fa-info-circle"></i>
			Hi，<span class="text-strong"><?php  echo $_W['username'];?></span>，您所在的会员组： <span class="text-strong"><?php  echo $account_info['group_name'];?></span>，<?php  if(!user_is_vice_founder() && !empty($account_info['vice_group_name'])) { ?><span class="text-strong"><?php  echo $account_info['vice_group_name'];?>，</span><?php  } ?>
			账号有效期限：<span class="text-strong"><?php  echo date('Y-m-d', $_W['user']['starttime'])?> ~~ <?php  if(empty($_W['user']['endtime'])) { ?>无限制<?php  } else { ?><?php  echo date('Y-m-d', $_W['user']['endtime'])?><?php  } ?></span>，
			可创建 <span class="text-strong"><?php  echo $account_info['maxwebapp'];?> </span>个PC，已创建<span class="text-strong"> <?php  echo $account_info['webapp_num'];?> </span>个，还可创建 <span class="text-strong"><?php  echo $account_info['webapp_limit'];?> </span>个PC账号。
		</div>
		<?php  } ?>

		<div class="clearfix"></div>

		<div class="cut-list clearfix">
			<?php  if(is_array($list)) { foreach($list as $item) { ?>
			<div class="item">
				<div class="content">
					<img src="<?php  echo $item['logo'];?>" class="icon-account" onerror="this.src='./resource/images/nopic-107.png'"/>
					<div class="name"><?php  echo $item['name'];?></div>
					<div class="type">

					</div>
				</div>
				<div class="mask">
					<a href="<?php  echo $item['switchurl'];?>" class="entry">
						<div>进入PC <i class="wi wi-angle-right"></i></div>
					</a>
					<!--<a href="javascript:;" class="stick" ng-click="stick(detail.uniacid)" title="置顶">-->
						<!--<i class="wi wi-stick-sign"></i>-->
					<!--</a>-->
					<?php  if(!permission_check_account_user('see_user_profile_account_num')) { ?>
					<a href="<?php  echo url('home/welcome/add_welcome', array('uniacid' => $item['uniacid']))?>" onclick="return ajaxopen(this.href);" class="home-show" title="添加到首页常用功能">
						<i class="wi wi-eye"></i>
					</a>
					<?php  } ?>
				</div>
			</div>
			<?php  } } ?>
		</div>
		<?php  if(count($list)==0 ) { ?>
		<ul style="text-align:center;width:100%"><span>暂无数据</span></ul>
		<?php  } ?>
		<div><?php  echo $pager;?></div>
	</div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>