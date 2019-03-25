<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'index'));?>">首页模板</a></li>
    <li><a href="<?php  echo $this->createWebUrl('base', array('foo'=>'diy'));?>">个性化设置</a></li>
    <li class="active"><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'nav'));?>">自定义导航</a></li>
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'edit'));?>">编辑模板</a></li>
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">
        自定义导航
        </div>
    </div>

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'navok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">

    <div class="panel-body">
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">预约=</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="nav1" id="nav1" value="<?php  echo $item['nav1'];?>" placeholder="" class="form-control">
	                <span class="help_block"></span>
	            </div>
	        </div>
        </div>

        <div class="panel-body">
            <div class="form-group">
	            <label class="col-xs-12 col-sm-3 col-md-2 control-label">发现=</label>
	            <div class="col-sm-9 col-xs-12">
	                <input type="text" name="nav2" id="nav2" value="<?php  echo $item['nav2'];?>" placeholder="" class="form-control">
	                <span class="help_block"></span>
	                </div>
	            </div>
            </div>
                
            <div class="panel-body">
            	<div class="form-group">
	                <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单=</label>
	                <div class="col-sm-9 col-xs-12">
	                    <input type="text" name="nav3" id="nav3" value="<?php  echo $item['nav3'];?>" placeholder="" class="form-control">
	                    <span class="help_block"></span>
	                </div>
	            </div>
            </div>
                
            <div class="panel-body">
            	<div class="form-group">
	                <label class="col-xs-12 col-sm-3 col-md-2 control-label">我的=</label>
	                <div class="col-sm-9 col-xs-12">
	                    <input type="text" name="nav4" id="nav4" value="<?php  echo $item['nav4'];?>" placeholder="" class="form-control">
	                    <span class="help_block"></span>
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
    </form>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>