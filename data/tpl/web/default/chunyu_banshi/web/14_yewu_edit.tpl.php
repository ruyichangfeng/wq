<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php  echo $yewulist['lname'];?></h3>
  </div>
  <div class="panel-body">
        	<form method="post" action="" class="form-horizontal">
    		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lname">业务流程名称</label>
		     <div class="col-sm-10">
		   	 <input type="text" class="form-control" id="lname" placeholder="请填写业务流程名称" name="lname" value="<?php  echo $yewulist['lname'];?>">
		   	 </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lpic">业务流程图标</label>
		     <div class="col-sm-10">
		    	<?php  echo tpl_form_field_image('lpic',$yewulist['lpic']);?>
		    </div>
		  </div>

		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="tid">业务所属分类</label>
			    <div class="col-sm-10">
			    	<select class="form-control" name="tid" id="tid">
				<option value="">请选择所属分类</option>
				<?php  if(is_array($typelist)) { foreach($typelist as $key => $item) { ?>
				<option value="<?php  echo $item['tid'];?>" <?php  if($yewulist['tid']==$item['tid']) { ?>selected<?php  } ?>><?php  echo $item['typename'];?></option>
				<?php  } } ?>
				</select>
			    </div>
		  </div>

		   <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="ljieshao">业务办理介绍</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('ljieshao',$yewulist["ljieshao"]);?>
			</div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="ltiaojian">业务办理条件</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('ltiaojian',$yewulist["ltiaojian"]);?>
			</div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lcailiao">业务办理材料</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('lcailiao',$yewulist["lcailiao"]);?>
			</div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lliucheng">业务办理流程</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('lliucheng',$yewulist["lliucheng"]);?>
			</div>
		  </div>
		
		<div style="text-align: center;">
		<input type="submit" name="submit" class="btn btn-primary" value="提交">&nbsp;&nbsp;
		<a href="<?php  echo $this->createWebUrl('yewu',array());?>">
		<input type="button" class="btn btn-warning" value="返回">
		</a>
		</div>
		<br>
	</form>
  </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>