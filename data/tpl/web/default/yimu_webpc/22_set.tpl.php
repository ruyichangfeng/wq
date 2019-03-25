<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
.we7-form .control-label, form .control-label {
    padding-top: 7px;
    padding-left: 0;
    padding-right: 0;
    text-align: left;
    color: #252424;
    font-weight: 400;
    width: 10%;
    padding-left: 30px;
}
</style>
 <script src="https://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<form action="" method="post"  class="form-horizontal form" enctype="multipart/form-data" id="form1">
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公司名称</label>
        <div class="col-sm-8">
            <input type="text" name="title" class="form-control" value="<?php  echo $setting['title'];?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">设置pc首页幻灯片</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_multi_image('slides', $slide, '');?>
            <span class="help-block">建议上传1920*600px的图片</span>
        </div>
    </div>
	
	<div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">网站favicon.ico</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_image('favicon', $setting['favicon'], '');?>
            <span class="help-block">建议上传.ico格式的图片，转换网址：http://www.bitbug.net/</span>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">前台LOGO</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_image('flogo', $setting['flogo'], '');?>
          
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">QQ</label>
        <div class="col-sm-8">
            <input type="text" name="qq" class="form-control" value="<?php  echo $setting['qq'];?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">联系人</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="<?php  echo $setting['name'];?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公司KEYWORD</label>
        <div class="col-sm-8">
            <input type="text" name="keywords" class="form-control" value="<?php  echo $setting['keywords'];?>" />
            <span class="help-block">用户网页搜索引擎优化</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label" style="text-align:left;">公司Description</label>
        <div class="col-sm-9 col-xs-12">
            <textarea style="height:60px;" id='description' name="description" class="form-control" cols="60"><?php  echo $setting['description'];?></textarea>
            <span class="help-block">用户网页搜索引擎优化</span>
        </div>
    </div>
   
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公司地址</label>
        <div class="col-sm-8">
            <input type="text" name="address" class="form-control" value="<?php  echo $setting['address'];?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">公司电话</label>
        <div class="col-sm-8">
            <input type="text" name="tel" class="form-control" value="<?php  echo $setting['tel'];?>" />
        </div>
    </div>
   
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">二维码</label>
        <div class="col-sm-8">
            <?php  echo tpl_form_field_image('code', $setting['code'], '');?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="text-align:left;">版权</label>
        <div class="col-sm-8">
            <input type="text" name="copyright" class="form-control" value="<?php  echo $setting['copyright'];?>" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
            <input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            <input type="hidden" name="acid" value="<?php  echo $_W['acid'];?>" />
        </div>
    </div>
    
</form>
<script type="text/javascript">
require(['jquery', 'util'], function($, u){

     $(function(){
         u.editor($('.richtext')[0]);
         u.editor($('.richtext')[1]);
         u.editor($('.richtext')[2]);
         u.editor($('.richtext')[3]);
         u.editor($('.richtext')[4]);
         u.editor($('.richtext')[5]);
     });

});
 </script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>