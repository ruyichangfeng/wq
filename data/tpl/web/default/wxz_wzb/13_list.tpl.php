<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion"
					href="#collapse1">
					添加图文直播内容
				</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse in">
				<form id="add_member" action="<?php  echo $this->createWebUrl('list')?>" method="post" enctype="multipart/form-data" class="form-horizontal ">
					<div class="panel-body">
						<div class="form-horizontal form">
							<input type="hidden" name="item" value="ajax">
							<input type="hidden" name="key" value="setting">

							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接调用链接</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" id="link" class="form-control" placeholder="" name="link" disabled="disabled" value="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&eid=<?php  echo $id['eid'];?>">
								</div>
							</div> 
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">活动列表标题：</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" class="form-control span7" name="title" value="<?php  echo $setting['title'];?>">
									<div class="help-block">活动封面标题</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">风格</label>
								<div class="col-sm-8 col-lg-9 col-xs-12">
									<label class="radio-inline">
										<input type="radio" name="style" value="1"  <?php  if($setting['style'] == '1') { ?>checked="true"<?php  } ?>>风格一
									</label>
									<label class="radio-inline">
										<input type="radio" name="style" value="2"   <?php  if($setting['style'] == '2') { ?>checked="true"<?php  } ?>>风格二
									</label>
									
								</div>
							</div>
							
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							分享设置
						</div>
						<div class="panel-body">  
							
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">列表页分享图标：</label>
								<div class="col-sm-9 col-xs-12">
									<?php  echo tpl_form_field_image("list_share_img", $setting['list_share_img'])?>
									<div class="help-block">最佳尺寸：200*200px</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">列表页分享标题：</label>
								<div class="col-sm-9 col-xs-12">
									<input type="text" id="share_title" class="form-control span7" placeholder="" name="list_share_title" value="<?php  echo $setting['list_share_title'];?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">列表页分享描述：</label>
								<div class="col-sm-9 col-xs-12">
									<textarea style="height:60px;" name="list_share_desc" class="form-control span7" cols="60"><?php  echo $setting['list_share_desc'];?></textarea>
									<div class="help-block"></div>
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
		
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>