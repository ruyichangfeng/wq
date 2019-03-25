<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">编辑办事类别</h3>
  </div>
  <div class="panel-body">
	<form method="post">
	<div class="form-group">
		<label class="col-sm-2 control-label tx-r"  for="typename">办事类别名称</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" id="typename" placeholder="请输入类别名称" value="<?php  echo $res['typename'];?>" name="typename">
		</div>
	</div>
	<div class="form-group">
	    <label class="col-sm-2 control-label tx-r" for="typepic">业务流程图标</label>
	     <div class="col-sm-10">
	    	<?php  echo tpl_form_field_image('typepic',$res['typepic']);?>
	    </div>
	  </div>
	<input type="submit" class="btn btn-default" name="submit" value="提交">	
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
	<a href="<?php  echo $this->createWebUrl('shequ',array());?>">
		<input type="button" class="btn btn-default" value="返回">
	</a>
	</form>
  </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>