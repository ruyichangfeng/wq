<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'index'));?>">首页模板</a></li>
    <li class="active"><a href="<?php  echo $this->createWebUrl('base', array('foo'=>'diy'));?>">个性化设置</a></li>
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'nav'));?>">自定义导航</a></li>
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'edit'));?>">编辑模板</a></li>
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">
        客户端个性化设置
        </div>
    </div>

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('base', array('foo'=>'diyok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">

    <div class="panel-body">
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">等待价格=</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="diywait" id="diywait" value="<?php  echo $item['diywait'];?>" placeholder="" class="form-control">
	                <span class="help_block">当选定服务人员查看订单详情页面的等待价格按钮</span>
	            </div>
	        </div>
        </div>

        <div class="panel-body">
            <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">付款=</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="diypay" id="diypay" value="<?php  echo $item['diypay'];?>" placeholder="" class="form-control">
	                <span class="help_block">服务人员完工后用户付款点击按钮</span>
	                </div>
	            </div>
            </div>
                
            <div class="panel-body">
            	<div class="form-group">
	                <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单=</label>
	                <div class="col-sm-9 col-xs-12">
	                    <input type="text" name="diygrab" id="diygrab" value="<?php  echo $item['diygrab'];?>" placeholder="" class="form-control">
	                    <span class="help_block">服务人员后台抢单的时候按钮上显示的文字</span>
	                </div>
	            </div>
            </div>
                
            <div class="panel-body">
            	<div class="form-group">
	                <label class="col-xs-12 col-sm-3 col-md-2 control-label">完成订单=</label>
	                <div class="col-sm-9 col-xs-12">
	                    <input type="text" name="diyyes" id="diyyes" value="<?php  echo $item['diyyes'];?>" placeholder="" class="form-control">
	                    <span class="help_block">服务人员后台成功单详细页面的完成订单按钮</span>
	                </div>
	            </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">资料头部背景</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image(catch_bg,$item['catch_bg']);?>
                    <span class="help_block">发现服务人员详细资料头部背景图片</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">商铺服务图标</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_form_field_image(takeout_icon,$item['takeout_icon']);?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">商铺服务自定义名称</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="icon_name" id="icon_name" value="<?php  echo $item['icon_name'];?>" placeholder="" class="form-control">
                    <span class="help_block">自定义外卖服务名称</span>
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
    </form>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>