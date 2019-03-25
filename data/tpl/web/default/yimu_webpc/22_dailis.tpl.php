<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
.panel-default {
    padding: 10px;
    border-radius: 0;
    border:1px dashed #e2e2e2;
}
</style>

<form action="" method="post"  class="form-horizontal form layui-form" enctype="multipart/form-data" id="form1">
  <div class='panel panel-default'>
      <div class='panel-body'>
      	
			 <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">大标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="title" id="title"  class="form-control" value="<?php  echo $item['title'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">小标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="xtitle" id="xtitle"  class="form-control" value="<?php  echo $item['xtitle'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">顶部大图</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('img', $item['img'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-xs-12 col-sm-3 col-md-2 control-label" style="text-align:left;">市场分析</label>
		        <div class="col-sm-9 col-xs-12">
		            <textarea style="height:60px;" id='analysis' name="analysis" class="form-control" cols="60"><?php  echo $item['analysis'];?></textarea>
		            
		            
		        </div>
    		</div>
    		
    		
    		<div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">市场分析背景</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('analysisimg', $item['analysisimg'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">小程序优势背景</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_image('wximg', $item['wximg'], '');?>
		          
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">用户基数标题</label>
		        <div class="col-sm-8">
		            <input type="text" name="base" id="base"  class="form-control" value="<?php  echo $item['base'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">用户基数logo</label>
		        <div class="col-sm-8">
		            <?php  echo tpl_form_field_multi_image('baseimg', $base, '');?>
		            <span class="help-block">建议使用1200px*400px</span>
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




























