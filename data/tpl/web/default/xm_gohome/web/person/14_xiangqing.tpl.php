<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>

<div class="clearfix">
    <div class="panel panel-default">
            <div class="panel-heading">工人详细信息</div>
            <div class="panel-body">
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">工人ID：<?php  echo $item['id'];?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">工人OpenID：<?php  echo $item['openid'];?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">工人姓名：<?php  echo $item['staff_name'];?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">手机号码：<?php  echo $item['staff_mobile'];?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">工人性别：<?php  if($item['sex'] == 1) { ?>男<?php  } else { ?>女<?php  } ?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">工人年龄：<?php  echo $item['age'];?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">工人工龄：<?php  echo $item['year'];?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">身份证号：<?php  echo $item['card'];?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">服务项目：<?php  echo $this->getStaffPro($item['id']);?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">开户银行：<?php  echo $item['bank'];?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">银行卡号：<?php  echo $item['bank_num'];?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">常住地址：<?php  echo $item['permanent'];?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">账户余额：<?php  echo $item['money'];?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">有无商铺：<?php  if($item['merchant_state'] == 1) { ?> 有 <?php  } else { ?> 无 <?php  } ?></div>
                </div>
                
                
            </div>
        </div>    
        
    </div>
</div>
