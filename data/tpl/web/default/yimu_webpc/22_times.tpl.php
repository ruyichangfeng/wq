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
		        <label class="col-sm-2 control-label" style="text-align:left;">合作伙伴数量</label>
		        <div class="col-sm-8">
		            <input type="text" name="partner" id="partner"  class="form-control" value="<?php  echo $item['partner'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">覆盖行业数量</label>
		        <div class="col-sm-8">
		            <input type="text" name="industry" id="industry"  class="form-control" value="<?php  echo $item['industry'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">页面访问数量</label>
		        <div class="col-sm-8">
		            <input type="text" name="access" id="access"  class="form-control" value="<?php  echo $item['access'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">产品月交数量</label>
		        <div class="col-sm-8">
		            <input type="text" name="product" id="product"  class="form-control" value="<?php  echo $item['product'];?>" />
		        </div>
		    </div>
		    
		    <div class="form-group">
		        <label class="col-sm-2 control-label" style="text-align:left;">商家信赖数量</label>
		        <div class="col-sm-8">
		            <input type="text" name="business" id="business"  class="form-control" value="<?php  echo $item['business'];?>" />
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





























