<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>

<div class="clearfix">
    <div class="panel panel-default">
            <div class="panel-heading">订单详细信息</div>
            <div class="panel-body">
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">订单模式：<?php  if($item['mode'] == 0) { ?>派单模式<?php  } else { ?>抢单模式<?php  } ?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">用户昵称：<?php  echo $this->getMemberInfo($item['openid'], 'nickname');?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">服务类型：<?php  echo $this->getServeType($item['serve_type']);?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">服务时间：<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'ftime')?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">联系电话：<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'fmobile')?></div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9 col-xs-12">预计价格：<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],'dealprice')?></div>
                </div>
                
                <?php  if(is_array($list)) { foreach($list as $vo) { ?>
	                <div class="form-group">
	                    <div class="col-sm-9 col-xs-12">
                            
                            <?php  if($vo['input_type'] == 'radio' || $vo['input_type'] == 'checkbox' || $vo['input_type'] == 'select') { ?>
                              <?php  if($this->getOrderInfoValue($item['table_name'],$item['other_id'],''.$vo[input_name].'',$item['temp_id']) != '') { ?>
                                <?php  echo $vo['input_laber'];?>：
                              <?php  } ?>
                            <?php  } else { ?>
                              <?php  if($this->getOrderInfo($item['table_name'],$item['other_id'],''.$vo[input_name].'') != '') { ?>
                                <?php  echo $vo['input_laber'];?>：
                              <?php  } ?>
                            <?php  } ?>
                            
	                    	<?php  if($vo['input_type'] == 'radio' || $vo['input_type'] == 'checkbox' || $vo['input_type'] == 'select') { ?>
			                	<?php  echo $this->getOrderInfoValue($item['table_name'],$item['other_id'],''.$vo[input_name].'',$item['temp_id'])?>
			                <?php  } else { ?>
			                	<?php  echo $this->getOrderInfo($item['table_name'],$item['other_id'],''.$vo[input_name].'')?>
			                <?php  } ?>
	                    </div>
	                </div>
			    <?php  } } ?>
			    
			    
			    <?php  if($listpic['0']['pic'] != '') { ?>
			    	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图片</label>
	                    <div class="col-sm-9 col-xs-12">
	                    	<?php  if(is_array($listpic)) { foreach($listpic as $vopic) { ?>
	                    	<a href="<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $vopic['pic'];?>" target="_blank">
	                    	<img src="<?php  echo $_W['attachurl'];?>gohome/pic/<?php  echo $vopic['pic'];?>" width="60px" height="60px;">
	                    	</a>
	                    	<?php  } } ?>
	                    </div>
	                </div>
			    <?php  } ?>

                <?php  if($item['state'] == 1) { ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-xs-12" style="color:red">接单人员：<?php  echo $this->getStaffInfo($item['staff_id'], 'staff_name')?></div>
                    </div>
                    
                <?php  } ?>
                <?php  if($item['state'] == 2) { ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-xs-12" style="color:red">接单人员：<?php  echo $this->getStaffInfo($item['staff_id'], 'staff_name')?></div>
                    </div>
                <?php  } ?>

                <div class="form-group">
                        <div class="col-sm-9 col-xs-12" style="color:red">接单价格：<?php  echo $item_g['suremoney'];?></div>
                </div>
                
            </div>
        </div>    
        
    </div>
</div>
