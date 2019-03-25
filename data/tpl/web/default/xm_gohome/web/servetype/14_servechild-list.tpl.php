<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('servetype', array('foo'=>'index'));?>">服务项目管理</a></li>
    <li class="active"><a href="#">服务子类列表</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            服务子类列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>序号</td>
                        <td>类别名称</td>
                        <td>父类名称</td>
                        <td>描述</td>
                        <td>模板名称</td>
                        <td width="300">品台佣金方式</td>
                        <td width="350">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  $n=0;?>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                    <?php  $n+=1;?>
                	<tr>
                    	<td><?php  echo $n;?></td>
                        <td><?php  echo $val['type_name'];?></td>
						<td><?php  echo $this->getServeType($val['parent_id']);?></td>
                        <td><?php  echo substr($val['remark'],0,60)?></td>
                        <td><?php  echo $this->getTempName($val['temp_id']);?></td>
                        <td>
                        <?php  if($val['gettype'] == 1) { ?>
                        按百分比[<?php  echo $val['bili_bai'];?>%]——><?php  echo $val['start'];?>元-<?php  echo $val['end'];?>元
                        <?php  } else { ?>
                        按每单[<?php  echo $val['bili_money'];?>元]——><?php  if($val['times']==1) { ?>在选定人员时结算<?php  } else { ?>在付款时结算<?php  } ?>
                        <?php  } ?>
                        </td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
								<a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype',array('foo'=>'edit', 'id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype', array('foo'=>'deletechild', 'id'=>$val['id'],'parent_id'=>$val['parent_id']))?>" onclick="return confirm('确认删除该服务子类别?');"><i class="fa fa-remove"></i> 删除</a>
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
        	<!--
            <a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetypeadd', array())?>">新增服务类别</a>
            -->
        </div>
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>