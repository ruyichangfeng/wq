<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('cloudprint', array('foo'=>'index'));?>">打印机管理</a></li>
	<li><a href="<?php  echo  $this->createWebUrl('cloudprint', array('foo'=>'add'));?>">添加打印机</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            打印机列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>工人名称</td>
                        <td>printer_sn</td>
                        <td>key</td>
                        <!--<td>ip</td>-->
                        <td>打印联数</td>
                        
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $this->getStaffInfo($val['staff_id'],'staff_name')?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['printer_sn'];?></p>
                        </td>
						<td>
							<p class="form-control-static"><?php  echo $val['key_info'];?></p>
                        </td>
                        <!--
                        <td>
							<p class="form-control-static"><?php  echo $val['ip'];?></p>
                        </td>
                        -->
                        <td>
							<p class="form-control-static"><?php  echo $val['number'];?></p>
                        </td>
                       
                        
					    <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('cloudprint',array('foo'=>'edit','id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('cloudprint', array('foo'=>'delete','id'=>$val['id']))?>" onClick="return confirm('确认删除?');"><i class="fa fa-remove"></i> 删除</a>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        
        <div class="panel-footer">
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('cloudprint',array('foo'=>'add'));?>">新增打印机</a>
        </div>
        
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>