<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('tempmessage', array('foo'=>'index'));?>">模板消息列表</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('tempmessage', array('foo'=>'add'));?>">添加模板消息</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('tempmessage', array('foo'=>'default'));?>">默认模板消息</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            模板消息列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>序号</td>
                        <td>模板消息名称</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  $n=0;?>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                    <?php  $n+=1;?>
                	<tr>
                    	<td><?php  echo $n;?></td>
                        <td><?php  echo $val['message_name'];?></td>
                       
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
								<a class="btn btn-default" href="<?php  echo $this->createWebUrl('tempmessage', array('foo'=>'edit', 'id'=>$val['id']))?>"><i class="fa fa-edit"></i>编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('tempmessage', array('foo'=>'delete','id'=>$val['id']))?>" onclick="return confirm('确认删除该模板消息吗?');"><i class="fa fa-remove"></i> 删除</a>
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
        	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('tempmessage', array('foo'=>'add'))?>">添加模板消息</a>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>