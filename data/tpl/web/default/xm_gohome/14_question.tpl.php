<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('question', array('foo'=>'index'));?>">常见问题</a></li>
</ul>


<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('question', array('foo'=>'questionok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">
            
            <div class="panel-heading">
                常见问题
            </div>
            <div class="panel-body">
            	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">问题名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="q_name" id="q_name" value="<?php  echo $item['q_name'];?>" placeholder="" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">常见问题</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_ueditor('question', $item['question']);?>
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