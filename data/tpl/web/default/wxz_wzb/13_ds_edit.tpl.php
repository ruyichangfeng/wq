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
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 是否开启</label>
							<div class="col-sm-9 col-xs-12">
							   <label class='radio-inline' >
									<input type='radio' name="isshow" value='1' <?php  if($list['isshow']==1) { ?>checked<?php  } ?> />是
								</label>
								<label class='radio-inline' >
									<input type='radio' name="isshow" value='0' <?php  if($list['isshow']==0) { ?>checked<?php  } ?> /> 否
								</label>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">logo</label>
							<div class="col-sm-8 col-lg-9 col-xs-12">
								<?php  echo tpl_form_field_image('logo', $list['logo']);?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">主播</label>
							<div class="col-sm-8 col-lg-9 col-xs-12">
									<input type="text" class="form-control" name="nickname" value="<?php  echo $list['nickname'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">打赏说明</label>
							<div class="col-sm-8 col-lg-9 col-xs-12">
									<input type="text" class="form-control" name="content" value="<?php  echo $list['content'];?>">
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-xs-5 col-sm-2 col-md-2 col-lg-2 control-label">金额一</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="one" value="<?php  echo $setting['one'];?>">
									<div class="input-group-addon">分</div>
								</div>
								<span class="help-block">金额 必填</span>
							</div>
							<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label">金额一描述</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remark1" value="<?php  echo $setting['remark1'];?>">
									<div class="input-group-addon"></div>
								</div>
								<span class="help-block">金额一描述 必填</span>
							</div>
						</div>
	
	<div class="form-group">
							<label class="col-xs-5 col-sm-2 col-md-2 col-lg-2 control-label">金额二</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="two" value="<?php  echo $setting['two'];?>">
									<div class="input-group-addon">分</div>
								</div>
								<span class="help-block">金额 必填</span>
							</div>
							<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label">金额二描述</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remark2" value="<?php  echo $setting['remark2'];?>">
									<div class="input-group-addon"></div>
								</div>
								<span class="help-block">金额二描述 必填</span>
							</div>
						</div>
	
	<div class="form-group">
							<label class="col-xs-5 col-sm-2 col-md-2 col-lg-2 control-label">金额三</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="three" value="<?php  echo $setting['three'];?>">
									<div class="input-group-addon">分</div>
								</div>
								<span class="help-block">金额 必填</span>
							</div>
							<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label">金额三描述</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remark3" value="<?php  echo $setting['remark3'];?>">
									<div class="input-group-addon"></div>
								</div>
								<span class="help-block">金额三描述 必填</span>
							</div>
						</div>
	
	<div class="form-group">
							<label class="col-xs-5 col-sm-2 col-md-2 col-lg-2 control-label">金额四</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="four" value="<?php  echo $setting['four'];?>">
									<div class="input-group-addon">分</div>
								</div>
								<span class="help-block">金额 必填</span>
							</div>
							<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label">金额四描述</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remark4" value="<?php  echo $setting['remark4'];?>">
									<div class="input-group-addon"></div>
								</div>
								<span class="help-block">金额四描述 必填</span>
							</div>
						</div>
	
	<div class="form-group">
							<label class="col-xs-5 col-sm-2 col-md-2 col-lg-2 control-label">金额五</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="five" value="<?php  echo $setting['five'];?>">
									<div class="input-group-addon">分</div>
								</div>
								<span class="help-block">金额 必填</span>
							</div>
							<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label">金额五描述</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remark5" value="<?php  echo $setting['remark5'];?>">
									<div class="input-group-addon"></div>
								</div>
								<span class="help-block">金额五描述 必填</span>
							</div>
						</div>
	
	<div class="form-group">
							<label class="col-xs-5 col-sm-2 col-md-2 col-lg-2 control-label">金额六</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="six" value="<?php  echo $setting['six'];?>">
									<div class="input-group-addon">分</div>
								</div>
								<span class="help-block">金额 必填</span>
							</div>
							<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label">金额六描述</label>
							<div class="col-sm-4 col-lg-4 col-xs-5">
								<div class="input-group">
									
									<input type="text" class="form-control" name="remark6" value="<?php  echo $setting['remark6'];?>">
									<div class="input-group-addon"></div>
								</div>
								<span class="help-block">金额六描述 必填</span>
							</div>
						</div>
	
						</div>
					</div>
    </div>
</div>

	<div class="form-group">
			<div class="col-sm-12">
				<input name="submit" type="submit" value="提交" class="btn btn-success" />
				<input type="hidden" name="rid" value="<?php  echo $rid;?>" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
			</div>
	</div>
</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>