<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class="active"><a href="?<?php  echo $_SERVER['QUERY_STRING'];?>"><?php  echo $entry['title'];?></a></li>
</ul>
<style type="text/css">
	.help-block em{display:inline-block;width:10em;font-weight:bold;font-style:normal;}
</style>

<script>
	$(function() {
		require(['jquery.qrcode'], function(){
			url = $('input[name="url_show"]').val();
			$('.js-qrcode-show').show();
			$('.qrcode-block').html('').qrcode({
				render: 'canvas',
				width: 150,
				height: 150,
				text: url
			});
		})
	})
</script>
<style>
	.bs-callout-danger{
		border-left-color: #ce4844;
	}
	.bs-callout-danger h4 {
		color: #ce4844
	}
	.bs-callout{
		padding: 20px;
		padding-bottom: 5px;
		margin-bottom: 20px;
		border: 1px solid #eee;
		border-left-width: 5px;
		border-radius: 3px;
		background-color: white;
	}
	.bs-callout h4 {
		margin-top: 0;
		margin-bottom: 5px
	}

</style>
<div class="clearfix" ng-controller="replyForm">
	<div class="bs-callout bs-callout-danger" id="callout-glyphicons-empty-only">
		<h4><?php  echo $entry['title'];?>设置</h4>
		<p>如果你有oAuth权限也可以直接设置自定义菜单到指定链接位置.</p>
	</div>
	<form id="reply-form" class="form-horizontal form" action="?<?php  echo $_SERVER['QUERY_STRING'];?>" method="post" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				直接链接 <span class="text-muted">直接进入的URL</span>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接URL</label>
					<div class="col-sm-9 col-xs-12 ">
						<input type="text" class="form-control" readonly="readonly" name="url_show" value="<?php  echo $entry['url_show'];?>" />
						<span class="help-block">
							<strong>直接指向到入口的URL。您可以在自定义菜单（有oAuth权限）或是其它位置直接使用。</strong>
						</span>
					</div>

				</div>
				<div class="form-group js-qrcode-show">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码</label>
					<div class="col-sm-9 col-xs-12 ">
						<div class="qrcode-block" style="margin-top:20px"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				功能封面 <span class="text-muted"><?php  echo $entry['title'];?></span>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面名称</label>
					<div class="col-sm-6 col-xs-12">
						<input type="text" class="form-control" readonly="readonly" value="<?php  echo $entry['title'];?>" />
					</div>
					<div class="col-sm-3">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">触发关键字</label>
					<div class="col-sm-6 col-xs-12">
						<input type="text" class="form-control" placeholder="请输入触发关键字" name="keywords" value="<?php  echo $reply['keywords'][0]['content'];?>"/>
					</div>
					<div class="col-sm-3">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面参数</label>
					<div class="col-sm-9">
						<div class="panel panel-default reply-container" style="padding-top:2em;">
							<div ng-hide="entry.saved">
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control" placeholder="标题" name="title" value="<?php  echo $cover['title'];?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">封面</label>
									<div class="col-sm-9 col-xs-12">
										<?php  echo tpl_form_field_image('thumb', $cover['src'], '', array('width' => 400));?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">描述</label>
									<div class="col-sm-9 col-xs-12">
										<textarea class="form-control" placeholder="添加图文消息的简短描述" name="description" ><?php  echo $cover['description'];?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接URL</label>
									<div class="col-sm-9 col-xs-12">
										<p class="form-control-static" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php  echo $entry['url_show'];?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input name="submit" type="submit" value="保存" class="btn btn-primary" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>