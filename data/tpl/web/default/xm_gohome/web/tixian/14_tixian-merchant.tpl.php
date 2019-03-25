<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('fall', array());?>">员工佣金列表</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('ping', array());?>">平台佣金列表</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('txlog', array('foo'=>'index'));?>">提现申请列表</a></li>
</ul>

<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('txlog', array('foo'=>'index'));?>">项目提现申请</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('txlog', array('foo'=>'merchant'));?>">商铺提现申请</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-info">
    	<div class="panel-heading">
            商铺提现列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                        <td width="150">商铺名称</td>
                        <td width="100">申请金额</td>
                        <td width="150">申请时间</td>
                        <td width="250">提现时间段</td>
                        <td width="100">已发金额</td>
                        <td width="100">剩余金额</td>
                        <!--
                        <td>实发金额</td>
                        <td>剩余金额</td>
                        -->
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $this->getMerchantInfo($val['merchant_id'], 'merchant_name')?></p>
                        </td>
                        <td>
                        	<p class="form-control-static"><?php  echo $val['money'];?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['addtime'];?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo substr($val['start'],0,10)?>至<?php  echo substr($val['end'],0,10)?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['famoney'];?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['yumoney'];?></p>
                        </td>
                        
						 <td style="overflow:visible;">
                         	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('txlog',array('foo'=>'tixianmerchant', 'id'=>$val['id']));?>"><i class="fa fa-edit"></i>操作</a
                            ></div>
                            
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
       
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>