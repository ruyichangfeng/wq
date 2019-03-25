<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'index'));?>">系统更新</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'ma'));?>">更新码更新</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'reset'));?>">重置系统</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'xiu'));?>">字段修复</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'power'));?>">分权管理</a></li>
</ul>

<div class="clearfix">
	<div class="tx-c" style="font-size:16px;"><?php  echo $msg;?></div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>