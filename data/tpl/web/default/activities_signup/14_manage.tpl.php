<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="panel panel-default">
  <div class="panel-heading">编辑活动</div>
  <div class="panel-body">
   	<form class="form-horizontal" action="" method="post">
	  <div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">活动名称</label>
	    <div class="col-sm-10">
	      <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="请输入活动标题" value="<?php  echo $activity['title'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inputPassword3" class="col-sm-2 control-label">活动图片</label>
	    <div class="col-sm-10">
	      <?php  echo tpl_form_field_image('thumb',$activity['thumb']);?>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inputPassword3" class="col-sm-2 control-label">活动时间</label>
	    <div class="col-sm-10">
	      <?php  echo tpl_form_field_daterange('activityTime',array('start'=>$activity['start_time'],'end'=>$activity['end_time']));?>
	    </div>
	  </div>
	   <div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">活动地点</label>
	    <div class="col-sm-10">
	      <input type="text" name="place" class="form-control" placeholder="请输入活动地点" value="<?php  echo $activity['place'];?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inputPassword3" class="col-sm-2 control-label">活动介绍</label>
	    <div class="col-sm-10">
	      <input type="text" name="detail" id="detail" value="<?php  echo $activity['detail'];?>" />
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<input type="submit" class="btn btn-primary" name="submit" value="提交">
		    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />  
	    </div>
	  </div>
	</form>
  </div>
</div>
<script>
	require(['jquery','util'], function($, util){
		$(function(){
			var editor = util.editor($('#detail')[0]);  
		});
	});
</script>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
