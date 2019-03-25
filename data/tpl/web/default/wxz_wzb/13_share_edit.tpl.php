<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>


<!--参与粉丝/中奖名单-->
<div class="main">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>

<style>
#myTab a{margin:5px !important;}
</style>
<form action="" method="post" class="form-horizontal" role="form" id="form1" >
<div class="panel panel-default">
    <div class="panel-heading">
        分享设置
    </div>
    <div class="panel-body">  
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播间分享图标：</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image("share_img", $list['share_img'])?>
				<div class="help-block">最佳尺寸：100*100px</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播间分享标题：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" id="share_title" class="form-control span7" placeholder="" name="share_title" value="<?php  echo $list['share_title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播间分享描述：</label>
			<div class="col-sm-9 col-xs-12">
				<textarea style="height:60px;" name="share_desc" class="form-control span7" cols="60"><?php  echo $list['share_desc'];?></textarea>
				<div class="help-block"></div>
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
</div>
</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>