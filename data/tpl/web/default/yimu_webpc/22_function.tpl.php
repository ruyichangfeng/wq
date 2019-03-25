<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('indextab', TEMPLATE_INCLUDEPATH)) : (include template('indextab', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
.panel-default {
    padding: 10px;
    border-radius: 0;
    border:1px dashed #e2e2e2;
}
</style>

<form action="" method="post"  class="form-horizontal form layui-form" enctype="multipart/form-data" id="form1" onsubmit="return onCheck()">
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title" id="title"  class="form-control" value="<?php  echo $item['title'];?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img', $item['img'], '');?>
		          
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能介绍</label>
		        <div class="col-sm-8">
		            <textarea style="height:60px;" id='introduce' name="introduce" class="form-control" cols="60"><?php  echo $item['introduce'];?></textarea>
		        </div>
		    </div>	 
	 </div>
  </div>
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title1" id="title1"  class="form-control" value="<?php  echo $item['title1'];?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img1', $item['img1'], '');?>
		          
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能介绍</label>
		        <div class="col-sm-8">
		            <textarea style="height:60px;" id='introduce1' name="introduce1" class="form-control" cols="60"><?php  echo $item['introduce1'];?></textarea>
		        </div>
		    </div>	 
	 </div>
  </div>
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title2" id="title2"  class="form-control" value="<?php  echo $item['title2'];?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img2', $item['img2'], '');?>
		          
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能介绍</label>
		        <div class="col-sm-8">
		            <textarea style="height:60px;" id='introduce2' name="introduce2" class="form-control" cols="60"><?php  echo $item['introduce2'];?></textarea>
		        </div>
		    </div>	 
	 </div>
  </div>
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title3" id="title3"  class="form-control" value="<?php  echo $item['title3'];?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img3', $item['img3'], '');?>
		          
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能介绍</label>
		        <div class="col-sm-8">
		            <textarea style="height:60px;" id='introduce3' name="introduce3" class="form-control" cols="60"><?php  echo $item['introduce3'];?></textarea>
		        </div>
		    </div>	 
	 </div>
  </div>
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title4" id="title4"  class="form-control" value="<?php  echo $item['title4'];?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img4', $item['img4'], '');?>
		          
		        </div>
		    </div>
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">功能介绍</label>
		        <div class="col-sm-8">
		            <textarea style="height:60px;" id='introduce4' name="introduce4" class="form-control" cols="60"><?php  echo $item['introduce4'];?></textarea>
		        </div>
		    </div>	 
	 </div>
  </div>
  
  <div class="form-group">
		        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
		            <input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
		            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />		            
		        </div>
	</div>
</form>
  
		  
    <script type="text/jscript">
    	function onCheck(){
			if($('#title').val() == ''){
			alert('标题不能为空！');
			return false; 
		}
		}
    </script>





























