<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">基本参数</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'running'));?>">运营设置</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'diy'));?>">个性化设置</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'question'));?>">常见问题</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'shuoming'));?>">服务说明</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('address', array('foo'=>'index'));?>">地区管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('lido', array('foo'=>'index'));?>">商圈管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">商铺类别</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">个人加盟协议</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">服务商加盟协议</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('address', array('foo'=>'addok'));?>" method="post">
        <div class="panel panel-info">
            <div class="panel-heading">
                添加地区
            </div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="adr_name" id="adr_name" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">中心坐标</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_coordinate('location',$getLat);?>
						<span class="help-block">请选择该地区中心坐标</span>
                    </div>
                </div>
                
                <!--<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序参数</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="top" id="top" value="<?php  echo $item['top'];?>" class="form-control">
						<span class="help-block">排序参数：数字越小越靠前。默认为0</span>
                    </div>
                </div>-->
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="1" checked >是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="0" >否
                            </label>
                        </div>
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