<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
		<!--模板设置-->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion"
					href="#collapse1">
					回复评论
				</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse in">
				<form id="add_member" action="<?php  echo $this->createWebUrl('reply')?>" method="post" enctype="multipart/form-data" class="form-horizontal ">
					<div class="panel-body">
						<div class="form-horizontal form">
							<input type="hidden" name="item" value="ajax">
							<input type="hidden" name="key" value="setting">
							<input type="hidden" name="rid" class="form-control" value="<?php  echo $rid;?>">
							<input type="hidden" name="id" class="form-control" value="<?php  echo $id;?>">
							<div class="form-group">
								<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="text-input">内容：</label>
								<div class="col-sm-8 col-xs-12 col-md-9">
									<?php  echo $touser['content'];?>

								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称：</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control span7" name="nickname" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">头像：</label>
								<div class="col-sm-9 col-xs-12">
									<?php  echo tpl_form_field_image("headimgurl", $list['headimgurl'])?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">回复内容：</label>
								<div class="col-sm-8 col-xs-12 col-md-9">		
									<input type="text" class="form-control span7" name="content" value="">
								</div>
							</div>
														<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
								<div class="col-sm-9 col-xs-12">
									<button class="btn btn-primary" name="btn-setting" type="submit">提交</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>