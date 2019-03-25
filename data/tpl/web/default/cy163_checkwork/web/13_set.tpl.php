<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
	<?php  if($setting) { ?>
	<form action="<?php  echo $this->createWebUrl('set',array('op'=>'update'));?>" method="post" class="form-horizontal form">
		<div class="panel panel-default">
			<div class="panel-heading">基本设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">站点名称</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="name" class="form-control" value="<?php  echo $setting['name'];?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">打卡ip池</label>
					<div class="col-sm-7 col-xs-12">
						<textarea class="form-control" name="ipaddress"><?php  echo $setting['ipaddress'];?></textarea>
						<span style="color:#900;">多个请用|隔开，例如：180.169.11.122|180.169.11.123，为空则不限制</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">早上打卡时间</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="starthour" class="form-control" value="<?php  echo $setting['starthour'];?>" />
						<span style="color:#900;">例如：09:00:00代表早上9点为上班打卡截止时间，小于10点的时间必须以例如09保证格式</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上下班打卡分界时间</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="middlehour" class="form-control" value="<?php  echo $setting['middlehour'];?>" />
						<span style="color:#900;">例如：13:00:00代表下午1点为打卡上下班打卡分界时间</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">晚上打卡时间</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="endhour" class="form-control" value="<?php  echo $setting['endhour'];?>" />
						<span style="color:#900;">例如：18:00:00代表下午6点为下班打卡开始时间</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上班打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="sbtext" class="form-control" value="<?php  echo $setting['sbtext'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上班已经打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="hassbtext" class="form-control" value="<?php  echo $setting['hassbtext'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">下班打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="xbtext" class="form-control" value="<?php  echo $setting['xbtext'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">下班已经打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="hasxbtext" class="form-control" value="<?php  echo $setting['hasxbtext'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启审核打卡</label>
					<div class="col-sm-7 col-xs-12">
						<label for="enabled1" class="radio-inline"><input type="radio" name="isshenhe" value="1" id="enabled1" <?php  if($setting['isshenhe'] == 1) { ?>checked="checked"<?php  } ?> /> 是</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled2" class="radio-inline"><input type="radio" name="isshenhe" value="0" id="enabled2" <?php  if($setting['isshenhe'] == 0) { ?>checked="checked"<?php  } ?> /> 否</label>
						<br>
	                   	<span style="color:#900;">开启后员工必须审核完才能打卡</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">公司名称池</label>
					<div class="col-sm-7 col-xs-12">
						<textarea class="form-control" name="companys"><?php  echo $setting['companys'];?></textarea>
						<span style="color:#900;">多个请用|隔开</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<input type="hidden" name="id" value="<?php  echo $setting['id'];?>" />
						<input name="submit" type="submit" value="修改" class="btn btn-primary span3"> 
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php  } else { ?>
	<form action="<?php  echo $this->createWebUrl('set',array('op'=>'add'));?>" method="post" class="form-horizontal form">
		<div class="panel panel-default">
			<div class="panel-heading">基本设置</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">站点名称</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="name" class="form-control" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">打卡ip池</label>
					<div class="col-sm-7 col-xs-12">
						<textarea class="form-control" name="ipaddress"></textarea>
						<span style="color:#900;">多个请用|隔开，例如：180.169.11.122|180.169.11.123</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">早上打卡时间</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="starthour" class="form-control" />
						<span style="color:#900;">例如：09:00:00代表早上9点为上班打卡截止时间，小于10点的时间必须以例如09保证格式</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上下班打卡分界时间</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="middlehour" class="form-control" />
						<span style="color:#900;">例如：13:00:00代表下午1点为打卡上下班打卡分界时间</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">晚上打卡时间</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="endhour" class="form-control" />
						<span style="color:#900;">例如：18:00:00代表下午6点为下班打卡开始时间</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上班打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="sbtext" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">上班已经打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="hassbtext" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">下班打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="xbtext" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">下班已经打卡按钮文字</label>
					<div class="col-sm-7 col-xs-12">
						<input type="text" name="hasxbtext" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启审核打卡</label>
					<div class="col-sm-7 col-xs-12">
						<label for="enabled1" class="radio-inline"><input type="radio" name="isshenhe" value="1" id="enabled1" /> 是</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled2" class="radio-inline"><input type="radio" name="isshenhe" value="0" id="enabled2" /> 否</label>
						<br>
	                   	<span style="color:#900;">开启后员工必须审核完才能打卡</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">公司名称池</label>
					<div class="col-sm-7 col-xs-12">
						<textarea class="form-control" name="companys"></textarea>
						<span style="color:#900;">多个请用|隔开</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
					<div class="col-sm-9 col-xs-12">
						<input name="submit" type="submit" value="提交" class="btn btn-primary span3"> 
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php  } ?>
</div>