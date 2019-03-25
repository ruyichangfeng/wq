<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('userlist', array('foo'=>'index'));?>">用户管理</a></li>
    <li><a href="<?php  echo $this->createWebUrl('blacklist', array('foo'=>'index'));?>">黑名单管理</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('userlist', array('foo'=>'editok'));?>" method="post">
    <input type="hidden" name="id" id="id" value="<?php  echo $item['id'];?>" >
        <div class="panel panel-default">
            <div class="panel-heading">
                修改用户
            </div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">openid</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="openid" id="openid" value="<?php  echo $item['openid'];?>" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户昵称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="nickname" id="nickname" value="<?php  echo $item['nickname'];?>" class="form-control" readonly>
						
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">真实姓名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="realname" id="realname" value="<?php  echo $item['realname'];?>" class="form-control">
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="mobile" id="mobile" value="<?php  echo $item['mobile'];?>" class="form-control">
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">头衔名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control">
                        
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