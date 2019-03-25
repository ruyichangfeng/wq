<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('adv', array('foo'=>'index'));?>">幻灯片管理</a></li>
    <li class="active"><a href="#">添加幻灯片</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('adv', array('foo'=>'addok'));?>" method="post">
        <div class="panel panel-default">
            <div class="panel-heading">
                添加幻灯片
            </div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="adv_name" id="adv_name" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">链接地址</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="link" id="link" class="form-control">
						<span class="help-block">链接地址必须以http://开头</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示位置</label>
                    <div class="col-sm-9 col-xs-12">
                        <select name="show_adr" id="show_adr" class="form-control  input-s-lg">
                            <option value="">选择显示位置</option>
                            <option value="shouye" selected>首页</option>
                            <option value="takeout">外卖</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯图片</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('pic',$item['pic']);?>
                        <span class="help-block">推荐尺寸：729*325</span>  
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序参数</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="top" id="top" value="<?php  echo $item['top'];?>" class="form-control">
						<span class="help-block">排序参数：数字越小越靠前。默认为0</span>
                    </div>
                </div>
                
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