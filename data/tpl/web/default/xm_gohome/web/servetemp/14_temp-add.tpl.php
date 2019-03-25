<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('servetemp', array('foo'=>'index'));?>">服务模型管理</a></li>
    <li class="active"><a href="">添加服务模型</a></li>
    <li><a href="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'center'));?>">模型市场</a></li>
</ul>


<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('servetemp', array('foo'=>'addok'));?>" method="post">
        <div class="panel panel-default">
            <div class="panel-heading">
                添加模型基础数据
            </div>
            <div class="panel-body">
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">模型名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="temp_name" id="temp_name" placeholder="" class="form-control">
                        <span class="block-help"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">模型标识</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="temp_token" id="temp_token" placeholder="" value="templat_" class="form-control">
                        <span class="block-help">只能是英文,只能以templat_开头</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用图片上传</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="uploadpic" value="1" checked="checked">启用
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="uploadpic" value="0">不启用
                            </label>
                        </div>
						<span class="help-block">启用后在提交订单时可上传图片</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示位置地图</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="getadr" value="1" checked="checked">显示
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="getadr" value="0">不显示
                            </label>
                        </div>
						<span class="help-block">启用后在提交订单时可显示位置地图</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认显示页面</label>
                    <div class="col-sm-9 col-xs-12">
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="moren" value="0" checked="checked">预约下单页面
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="moren" value="1">项目介绍页面
                            </label>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">背景颜色</label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php  echo tpl_form_field_color('bgcolor');?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">背景图片</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('bgimage','');?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-md-2 col-lg-1">
                        <input name="submit" type="submit" value="保存" class="btn btn-primary btn-block" />
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    </div>
                </div>
            </div>
        </div>
    </form>
    
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>