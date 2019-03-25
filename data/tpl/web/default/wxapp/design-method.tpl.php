<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div  class="account-list-add">
	<ol class="breadcrumb we7-breadcrumb">
		<a href="<?php  echo url ('account/manage', array('account_type' => ACCOUNT_TYPE_APP_NORMAL))?>"><i class="wi wi-back-circle"></i></a>
		<li><a href="<?php  echo url ('account/manage', array('account_type' => ACCOUNT_TYPE_APP_NORMAL))?>">小程序列表</a></li>
		<li>新建小程序</li>
	</ol>
	<div class="panel we7-panel">
		<?php  if(!$_W['isfounder'] && !empty($account_info['wxapp_limit'])) { ?>
		<div class="alert alert-warning hidden">
			温馨提示：
			<i class="fa fa-info-circle"></i>
			Hi，<span class="text-strong"><?php  echo $_W['username'];?></span>，您所在的会员组： <span class="text-strong"><?php  echo $account_info['group_name'];?></span>，
			账号有效期限：<span class="text-strong"><?php  echo date('Y-m-d', $_W['user']['starttime'])?> ~~ <?php  if(empty($_W['user']['endtime'])) { ?>无限制<?php  } else { ?><?php  echo date('Y-m-d', $_W['user']['endtime'])?><?php  } ?></span>，
			可创建 <span class="text-strong"><?php  echo $account_info['maxwxapp'];?> </span>个小程序，已创建<span class="text-strong"> <?php  echo $account_info['wxapp_num'];?> </span>个，还可创建 <span class="text-strong"><?php  echo $account_info['wxapp_limit'];?> </span>个小程序。
		</div>
		<?php  } ?>
		<div class="wxapp-creat-select we7-padding clearfix">
			<div class="col-sm-6">
				<div class="title">
					<span class="wi wi-small-routine"></span>
					新建单个小程序
				</div>
				<div class="con">
					打包生成小程序，仅针对开发者单个小程序插件.
				</div>
				<div>
					<a href="<?php  echo url('wxapp/post/post', array('design_method' => WXAPP_MODULE, 'uniacid' => $uniacid))?>" class="btn btn-primary">新建小程序</a>
				</div>
			</div>
			
		</div>

	</div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>