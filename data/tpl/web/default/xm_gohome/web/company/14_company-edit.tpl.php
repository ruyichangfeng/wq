<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'index'));?>">公司管理</a></li>
    <li class="active"><a href="">修改公司</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('company', array('foo'=>'editok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>" >
	<div class="panel panel-default">
            <div class="panel-heading">
                修改公司
            </div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公司名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="company_name" id="company_name" value="<?php  echo $item['company_name'];?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="contact" id="contact" value="<?php  echo $item['contact'];?>" class="form-control">
                        <span class="help-block">公司联系电话</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公司地址</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="address" id="address" value="<?php  echo $item['address'];?>" class="form-control">
                        <span class="help-block">公司地址</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">负责人姓名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="staff_name" id="staff_name" value="<?php  echo $item['staff_name'];?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">负责人性别</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="1" <?php  if($item['sex']==1) { ?> checked <?php  } ?>>男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="2" <?php  if($item['sex']==2) { ?> checked <?php  } ?>>女
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="staff_mobile" id="staff_mobile" value="<?php  echo $item['staff_mobile'];?>" class="form-control">
                        <span class="help-block">用于在手机段验证身份</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">验证密码</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="password" name="pwd" id="pwd" class="form-control">
                        <span class="help-block">用户段验证身份密码,不修改就不需要填写</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公司Logo</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('avatar', $item['avatar']);?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开户银行</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="bank" id="bank" value="<?php  echo $item['bank'];?>" class="form-control">
                        <span class="help-block">在此银行开户的银行卡持有人必须与添加员工姓名一致</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">银行卡号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="bank_num" id="bank_num" value="<?php  echo $item['bank_num'];?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付宝账号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="alipay" id="alipay" value="<?php  echo $item['alipay'];?>" class="form-control">
                    </div>
                </div>
                
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否锁定</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="1" <?php  if($item['stop'] == 1) { ?> checked <?php  } ?>>否
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="0" <?php  if($item['stop'] == 0) { ?> checked <?php  } ?>>是
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
			
			<div class="panel-heading"></div>
            <div class="panel-body">
				<span style="color:red;"> </span>
			</div>
        </div>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>