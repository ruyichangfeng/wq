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
		        <label class="col-sm-2 control-label" style="text-align:left;">案例标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title" id="title"  class="form-control" value="<?php  echo $item['title'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例类目</label>
		        <div class="col-sm-8">
		            <input type="text" name="category" id="category"  class="form-control" value="<?php  echo $item['category'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img', $item['img'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('code', $item['code'], '');?>
		          
		        </div>
		    </div>	    
	 </div>
  </div>
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title1" id="title1"  class="form-control" value="<?php  echo $item['title1'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例类目</label>
		        <div class="col-sm-8">
		            <input type="text" name="category1" id="category1"  class="form-control" value="<?php  echo $item['category1'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img1', $item['img1'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例二维码</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('code1', $item['code1'], '');?>
		          
		        </div>
		    </div>
	 </div>
  </div>
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title2" id="title2"  class="form-control" value="<?php  echo $item['title2'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例类目</label>
		        <div class="col-sm-8">
		            <input type="text" name="category2" id="category2"  class="form-control" value="<?php  echo $item['category2'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img2', $item['img2'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例二维码</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('code2', $item['code2'], '');?>
		          
		        </div>
		    </div>
	 </div>
  </div>
  
  
  <div class='panel panel-default'>
      <div class='panel-body'>
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title3" id="title3"  class="form-control" value="<?php  echo $item['title3'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例类目</label>
		        <div class="col-sm-8">
		            <input type="text" name="category3" id="category3"  class="form-control" value="<?php  echo $item['category3'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例图片</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img3', $item['img3'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">案例二维码</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('code3', $item['code3'], '');?>
		          
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





























