<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="module-link-account" id="js-module-link-account" ng-controller="userModuleLinkAccountCtrl">
    <div class="alert " >
		<p><i class="wi wi-info"></i> 主账号仅可设置一个，关联的账号组，数据已主账号的为准。</p>
		<p><i class="wi wi-info"></i> 关联账号可设置多个，但从任意一个账号进入，数据都与主账号数据保持一致。 </p>
	</div>
	<div class="panel we7-panel">
		<div class="panel-heading">
			主账号
		</div>
		<div class="panel-body">
			<div class="platform-list">
				<div class="platform-item">
					<div class="icon">
						<i class="wi wi-{{ account_info.type_sign }}"></i>
					</div>
					<div class="logo">
						<img ng-src="{{ account_info.logo }}" alt="">
					</div>
					<div class="info">
						<div class="title" ng-bind="account_info.name"></div>
						<div class="type" ng-if="account.type == 1 || account.type == 3">类型：
							<span class="success" ng-if="account_info.isconnect == 1"><i class="wi wi-right-circle"></i>已接入</span>
							<span class="danger" ng-if="account_info.isconnect != 1"><i class="wi wi-error-cricle"></i>已接入</span>
						</div>

					</div>
					<div class="link-group">
						<a href="./index.php?c=account&a=display&do=switch&uniacid={{ account_info.uniacid }}&type={{ account_info.type}}">进入</a>
						<a href="./index.php?c=account&a=post&uniacid={{ account_info.uniacid }}&acid={{ account_info.acid }}&type={{ account_info.type}}">管理设置</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel we7-panel">
		<div class="panel-heading">
			关联账号
		</div>
		<div class="panel-body">
			<div class="platform-list">
				<div class="platform-item" ng-repeat="account in passive_link_accounts">
					<div class="icon">
						<i class="wi wi-{{ account.type_sign }}"></i>
					</div>
					<div class="logo">
						<img ng-src="{{ account.logo }}" alt="">
					</div>
					<div class="info">
						<div class="title" ng-bind="account.name"></div>
						<div class="type" ng-if="account.type == 1 || account.type == 3">类型：
							<span class="success" ng-if="account.isconnect == 1"><i class="wi wi-right-circle"></i>已接入</span>
							<span class="danger" ng-if="account.isconnect != 1"><i class="wi wi-error-cricle"></i>已接入</span>
						</div>
					</div>
					<div class="link-group">
						<div class="link-group">
							<a href="./index.php?c=account&a=display&do=switch&uniacid={{ account.uniacid }}&type={{ account.type}}">进入</a>
							<a href="./index.php?c=account&a=post&uniacid={{ account.uniacid }}&acid={{ account.acid }}&type={{ account.type}}">管理设置</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	angular.module('moduleApp').value('config', {
		'passive_link_accounts': <?php echo !empty($passive_link_accounts) ? json_encode($passive_link_accounts) : 'null'?>,
		'account_info': <?php echo !empty($account_info) ? json_encode($account_info) : 'null'?>,
	});
	angular.bootstrap($('#js-module-link-account'), ['moduleApp']);
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>