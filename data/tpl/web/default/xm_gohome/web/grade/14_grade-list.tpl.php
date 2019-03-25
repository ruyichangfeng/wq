<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('grade', array('foo'=>'index'));?>">保证金管理</a></li>
	<li><a href="<?php  echo  $this->createWebUrl('grade', array('foo'=>'add'));?>">添加保证金</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            保证金列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td width="200">保证金名称</td>
                        <td width="200">保证金额</td>
                        <td width="300">保证金描述</td>
                        <td width="150">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<?php  echo $val['grade_name'];?>
                        </td>
                        <td>
							<?php  echo $val['grade_money'];?>
                        </td>
						<td>
							<?php  echo $val['remark'];?>
                        </td>
                       
                        
					    <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('grade',array('foo'=>'edit', 'id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('grade', array('foo'=>'delete', 'id'=>$val['id']))?>" onClick="return confirm('确认删除?');"><i class="fa fa-remove"></i> 删除</a>
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
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('grade',array('foo'=>'add'));?>">添加保证金</a>
        </div>
        
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>