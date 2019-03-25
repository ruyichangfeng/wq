<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">基本参数</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'running'));?>">运营设置</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'question'));?>">常见问题</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'shuoming'));?>">服务说明</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('address', array('foo'=>'index'));?>">地区管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('lido', array('foo'=>'index'));?>">商圈管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('type', array('foo'=>'list'));?>">商铺类别</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'geren'));?>">个人加盟协议</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'fuwu'));?>">服务商加盟协议</a></li>
</ul>


<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">
        常见问题
        </div>
    </div>

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('base', array('foo'=>'shuomingok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务名称</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="s_name" id="s_name" value="<?php  echo $item['s_name'];?>" placeholder="" class="form-control">
                </div>
            </div>
                
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务说明</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo tpl_ueditor('shuoming', $item['shuoming']);?>
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
    </form>
    
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>