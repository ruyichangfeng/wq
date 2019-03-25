<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>


<!--参与粉丝/中奖名单-->
<div class="main">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>

<style>
#myTab a{margin:5px !important;}
</style>
<form action="" method="post" class="form-horizontal" role="form" id="form1" >
<input type="hidden" name="id" value="<?php  echo $list['id'];?>"> 
<div class="panel panel-default">	
	<div class="panel-body">
			<div class="panel panel-default">
						  <div class="panel-body">

						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">AccessId</label>
							<div class="col-sm-8 col-lg-9 col-xs-12">
									<input type="text" class="form-control" name="accessid" value="<?php  echo $list['accessid'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">AccessKey</label>
							<div class="col-sm-8 col-lg-9 col-xs-12">
									<input type="text" class="form-control" name="accesskey" value="<?php  echo $list['accesskey'];?>">
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">TisId</label>
							<div class="col-sm-8 col-lg-9 col-xs-12">
									<input type="text" class="form-control" name="tisid" value="<?php  echo $list['tisid'];?>">
							</div>
						</div>
	
						</div>
					</div>
    </div>
</div>

	<div class="form-group">
			<div class="col-sm-12">
				<input name="submit" type="submit" value="提交" class="btn btn-success" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
			</div>
	</div>
</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>