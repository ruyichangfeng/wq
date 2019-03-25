<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $items['id'];?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                基本设置
            </div>
            <div class="panel-body">
           
 
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">回复内容</label>
                    <div class="col-sm-7 col-xs-12">
                       <textarea type="text"  name="content" class="form-control"><?php  echo $items['content']?></textarea>
                    </div>
                </div>
          
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