<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $items['id'];?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                模板消息
            </div>
            <div class="panel-body">

                <!--<div style="display:none" class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">系统名称</label>
                    <div class="col-sm-7 col-xs-12">
                        <input type="text" name="aname" class="form-control" value="<?php  echo $items['aname'];?>" />
                    </div>
                </div>
                <div style="display:none"  class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">系统标题</label>
                    <div class="col-sm-7 col-xs-12">
                        <input type="text" name="title" class="form-control" value="<?php  echo $items['title'];?>" />
                    </div>
                </div>-->
                
                
              
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">留言成功微信模板ID</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="template_id" class="form-control"  value="<?php  echo $items['template_id'];?>" />
                       <span style="color: #B9B9B9;">( 行业：IT科技 - IT软件与服务 标题：客服通知提醒  编号：OPENTM204431262 )</span>
                    </div>
                </div>
                
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">管理员openid</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="openid" class="form-control"  value="<?php  echo $items['openid'];?>" />
                    </div>
                </div>
                
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核处理微信模板ID</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="replyid" class="form-control"  value="<?php  echo $items['replyid'];?>" />
                       <span style="color: #B9B9B9;">( 行业：IT科技 - IT软件与服务 标题：反馈处理通知  编号：OPENTM409367327 )</span>
                    </div>
                </div>
                
                  <!--<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">通知用户微信模板ID</label>
                    <div class="col-sm-7 col-xs-12">
                       <input type="text"  name="notice" class="form-control"  value="<?php  echo $items['notice'];?>" />
                       <span>( 行业：客服通知提醒   模板消息编号：ZVMTocyPFTMjXoFH8VijPUBQxA76G1DJXvrh-5tqgLI )</span>
                    </div>
                </div>-->
                
                 
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <input name="submit" type="submit" value="提交" class="btn btn-primary span3"> 
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="id" value="<?php  echo $items['id'];?>" />
                    </div>
                </div>

                </form>
            </div>