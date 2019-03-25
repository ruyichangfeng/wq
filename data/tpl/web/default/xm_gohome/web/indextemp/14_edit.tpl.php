<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'index'));?>">首页模板</a></li>
    <li><a href="<?php  echo $this->createWebUrl('base', array('foo'=>'diy'));?>">个性化设置</a></li>
    <li><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'nav'));?>">自定义导航</a></li>
    <li class="active"><a href="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'edit'));?>">编辑模板</a></li>
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading c-red">
        自定义导航[注意：可以在此编辑当前公众号首页模板，修改前请备份文件,如果修改后页面错乱，重新下载可覆盖修改的模板]
        </div>
    </div>

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('indextemp', array('foo'=>'editok'));?>" method="post">

    <div class="panel-body">
        <div class="form-group">
             <div class="col-sm-12 col-xs-12">
                    <textarea name="conn" id="conn" class="form-control" rows="30"><?php  echo $conn;?></textarea>
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