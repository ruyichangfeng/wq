<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('fall', array('foo'=>'index'));?>">佣金列表</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('ping', array('foo'=>'index'));?>">平台佣金列表</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('txlog', array());?>">提现日志列表</a></li>
</ul>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('ping', array('foo'=>'index'));?>">服务项目所得佣金</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('ping', array('foo'=>'merchant'));?>">商铺所得佣金</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-info">
    	<div class="panel-heading">
            服务项目所得佣金
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <?php  if($list[0]['id'] == '') { ?>
            <div>暂无数据</div>
            <?php  } else { ?>
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td width="100">服务人员</td>
                        <td width="100">订单类别</td>
						<td width="100">支付方式</td>
                        <td width="100">获取金额</td>
                        <td width="150">时间</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $this->getStaffInfo($val['staff_id'],'staff_name')?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $this->getServeType($val[ serve_type])?></p>
                        </td>
						<td>
							<p class="form-control-static">
							<?php  if($val['type'] == 1) { ?>现金支付<?php  } ?>
							<?php  if($val['type'] == 2) { ?>微信支付<?php  } ?>
							<?php  if($val['type'] == 3) { ?>余额支付<?php  } ?>
							</p>
                        </td>
						<td>
							<p class="form-control-static"><?php  echo $val['getmoney'];?></p>
                        </td>
						
                        <td>
							<p class="form-control-static"><?php  echo $val['addtime'];?></p>
                        </td>
                        
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
            <?php  } ?>
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
       
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>