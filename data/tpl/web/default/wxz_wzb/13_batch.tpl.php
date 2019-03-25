<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>


<!--参与粉丝/中奖名单-->
<div class="main">
<style>
#myTab a{margin:5px !important;}
</style>
<form action="" method="post" class="form-horizontal" role="form" id="form1" >
<div class="panel panel-default">	
            <div class="panel-heading">
                批量修改(由于部分用户直播数据较大，因升级所造成的部分参数修改较为麻烦，特设置批量修改功能)
            </div>
	<div class="panel-body">
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">视频分辨率</label>
			<div class="col-sm-8 col-lg-9 col-xs-12">
				<div class="input-group" style="width:300px;">
					<div class="input-group-addon">分辨率</div>
					<input type="text" class="form-control" name="player_weight" value="<?php  echo $list['player_weight'];?>" >
					<span class="input-group-addon">X</span>
					<input type="text" class="form-control " name="player_height" value="<?php  echo $list['player_height'];?>" >
				</div>
				<span class="help-block">默认：1280*720</span>
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

</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>