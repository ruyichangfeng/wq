<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'index'));?>">公司管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'look', 'id'=>$id));?>">公司员工</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'staffadd', 'id'=>$id));?>">添加员工</a></li>
    
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('company', array('foo'=>'addstaffok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $id;?>"  />

	<div class="panel panel-default">
            <div class="panel-heading">
                添加公司服务人员 
            </div>
            <div class="panel-body">
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="staff_name" id="staff_name" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="mobile" id="mobile" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">性别</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="1" >男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="2" checked>女
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">年龄</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="age" id="age" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">工龄</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="year" id="year" class="form-control">
                    </div>
                    <span class="help-block"></span>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">头像</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('avatar',$item['avatar']);?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">身份证号码</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="card" id="card" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开户银行</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="bank" id="bank" class="form-control">
                        <span class="help-block">在此银行开户的银行卡持有人必须与添加员工姓名一致</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">银行卡号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="bank_num" id="bank_num" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付宝账号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="alipay" id="alipay" class="form-control">
                    </div>
                </div>
				
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">常驻地址</label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php  echo tpl_form_field_coordinate('location');?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务类型</label>
                    <div class="col-sm-9 col-xs-12">
                    	<table class="table">
							<?php  if(is_array($list)) { foreach($list as $vo) { ?>
                            <thead>
                            	<tr class="info">
                                	<th colspan="6">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="servetype[]" value="<?php  echo $vo['id'];?>" <?php  if($vo['child_num'] != 0) { ?> disabled <?php  } ?>><?php  echo $vo['type_name'];?></label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
							
                            <tbody class="system_platform">
                            	<tr>
                                <?php  $n=0;?>
                                <?php  if(is_array($this->getCheckbox($vo['id']))) { foreach($this->getCheckbox($vo['id']) as $val) { ?>
                                <?php  $n+=1;?>
                                    <td width="10px;">
                                    </td>
                                    <td>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="servetype[]" value="<?php  echo $val['id'];?>"><?php  echo $val['type_name'];?></label>
                                        </div>
                                    </td>
                                    <?php  if($n%6==0) echo '</tr><tr>';?>
                                <?php  } } ?>
                                </tr>
                            </tbody>
                            <?php  } } ?>
						</table>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否锁定</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="1" checked="checked">否
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="0">是
                            </label>
                        </div>
						<span class="help-block">锁定以后该员工将不能接单及收到消息</span>
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