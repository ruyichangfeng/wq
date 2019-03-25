<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('tabs', TEMPLATE_INCLUDEPATH)) : (include template('tabs', TEMPLATE_INCLUDEPATH));?>

<form action="" method="post"  class="form-horizontal form layui-form" enctype="multipart/form-data" id="form1" onsubmit="return onCheck()">
	 <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">案例名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" id="name"  class="form-control" value="<?php  echo $setting['name'];?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">案例图片</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_image('img', $setting['img'], '');?>
          
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">案例二维码</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_image('code', $setting['code'], '');?>
          
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
            <input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            <input type="hidden" name="acid" value="<?php  echo $_W['acid'];?>" />
        </div>
    </div>
    <script type="text/jscript">
    	function onCheck(){
			if($('#name').val() == ''){
			alert('案例名不能为空！');
			return false; 
		}
		}
    </script>
</form>