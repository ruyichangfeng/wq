<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
<div class="main">

		<div class="panel panel-default">
			<div id="collapse1" class="panel-collapse collapse in">
				<form id="add_member" action="<?php  echo $this->createWebUrl('list')?>" method="post" enctype="multipart/form-data" class="form-horizontal ">
					<div class="panel-body">
						<div class="form-horizontal form">
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label">管理员授权</label>
								<div class="col-sm-9 col-xs-12">
									<img src="<?php  echo $imgUrl;?>">
									<div class="help-block"><font style="color: red">直播管理员授权中心</font></div>
								</div>
							</div> 
							
						</div>
					</div>
					
				</form>
			</div>
		</div>
		
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
