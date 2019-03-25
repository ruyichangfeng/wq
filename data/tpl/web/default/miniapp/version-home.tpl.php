<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">首页</div>
<div class="welcome-container" id="js-wxapp-home-welcome" ng-controller="WxappWelcomeCtrl" ng-cloak>
	<div class="panel we7-panel wxapp-procedure">
		<div class="panel-body">
			<div class="procedure-top">
				<a href="http://bbs.we7.cc/forum.php?mod=viewthread&tid=24104&fromuid=56310 " class="btn btn-primary pull-right hidden">马上了解</a>
				<span class="title-lg"><?php  echo ACCOUNT_TYPE_NAME?></span>
				<span class="title-md">使用流程和开发简述</span>
			</div>
			<div class="procedure-diagram">
				<div class="procedure">
					<div>
						<div class="icon"><span class="wi wi-shopping-cart"></span></div>
						<div>购买<?php  echo ACCOUNT_TYPE_NAME?>应用</div>
						<div class="arrow"><span class="wi wi-step-arrows"></span></div>
					</div>
					<div>
						<div class="icon"><span class="wi wi-small-routine"></span></div>
						<div>新建<?php  echo ACCOUNT_TYPE_NAME?></div>
						<?php  if(TYPE_SIGN == WXAPP_TYPE_SIGN) { ?><div><a href="<?php  echo url('wxapp/post/design_method')?>" class="color-default" target="_blank">去新建></a></div><?php  } ?>
						<?php  if(TYPE_SIGN == ALIAPP_TYPE_SIGN) { ?><div><a href="<?php  echo url('miniapp/post')?>" class="color-default" target="_blank">去新建></a></div><?php  } ?>
						<div class="arrow"><span class="wi wi-step-arrows"></span></div>
					</div>
					<div>
						<div class="icon"><span class="wi wi-scan"></span></div>
						<div>打包下载</div>
						<div><a href="<?php  echo url('wxapp/front-download', array('version_id'=>$version_id))?>" class="color-default">去下载></a></div>
						<div class="arrow"><span class="wi wi-step-arrows"></span></div>
					</div>
					<div>
						<div class="icon"><span class="wi wi-publish"></span></div>
						<div>上传版本</div>
						<div class="arrow"><span class="wi wi-step-arrows"></span></div>
					</div>
					<div>
						<div class="icon"><span class="wi wi-setting-wxapp"></span></div>
						<div><?php  echo ACCOUNT_TYPE_NAME?>设置</div>
						<div class="arrow"><span class="wi wi-step-arrows"></span></div>
					</div>
					<div>
						<div class="icon"><span class="wi wi-wechat"></span></div>
						<div>到<?php  echo ACCOUNT_TYPE_NAME?>提交审核</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel we7-panel">
		<div class="panel-heading">
			公告
			<a href="./index.php?c=article&a=notice-show" target="_blank" class="pull-right color-default">更多</a>
		</div>
		<ul class="list-group">
			<li class="list-group-item" ng-repeat="notice in notices" ng-if="notices">
				<a ng-href="{{notice.url}}" class="text-over" target="_blank" ng-bind="notice.title" ng-style="{'color':notice.style.color, 'font-weight':notice.style.bold ? 'bold' : 'normal'}"></a>
				<span class="time pull-right color-gray" ng-bind="notice.createtime"></span>
			</li>
			<li class="list-group-item text-center" ng-if="!notices">
				<span>暂无数据</span>
			</li>
		</ul>
	</div>
	
		<div class="panel we7-panel apply-list">
			<div class="panel-heading">
				<a href="http://s.we7.cc" target="_blank" class="pull-right color-default">查看更多应用</a>
				微擎推荐
			</div>
			<div class="panel-body text-center" ng-class="{'we7-margin-vertical': !last_modules}">
				<span href="javascript:;" ng-if="!last_modules && loaderror == 0">数据加载中...</span>
				<span href="javascript:;" ng-if="!last_modules && loaderror == 1">数据加载失败，<a href="javascript:;" class="btn-link" ng-click="get_last_modules()">点击重试</a></span>
				<a ng-href="{{module.url}}" target="_blank" ng-if="last_modules && module.wxapp && module.logo && $index+1 < 8" class="apply-item" ng-repeat="module in last_modules">
					<img ng-src="{{module.logo}}">
					<span class="text-over" ng-bind="module.title"></span>
				</a>
			</div>
		</div>
	
</div>
<script>
	angular.module('wxApp').value('config', {
		notices: <?php echo !empty($notices) ? json_encode($notices) : 'null'?>,
	});
	angular.bootstrap($('#js-wxapp-home-welcome'), ['wxApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>