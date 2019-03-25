<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo $this->createWebUrl('fall', array());?>">佣金列表</a></li>
    <li><a href="<?php  echo $this->createWebUrl('ping', array());?>">平台佣金列表</a></li>
    <li><a href="<?php  echo $this->createWebUrl('txlog', array('foo'=>'index'));?>">提现申请列表</a></li>
    <li class="active"><a href="<?php  echo $this->createWebUrl('txlog', array('foo'=>'bank'));?>">银行管理</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            银行列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>银行名称</td>
                        <td>银行标识</td>
                        <td>排序参数</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $val['bank_name'];?></p>
                        </td>
                        <td>
                        	<p class="form-control-static"><?php  echo $val['pic'];?></p>
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['top'];?></p>
                        </td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('txlog',array('foo'=>'bankadd','id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('txlog', array('foo'=>'delete','id'=>$val['id']))?>" onClick="return confirm('确认删除该银行?');"><i class="fa fa-remove"></i> 删除</a>
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
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('txlog',array('foo'=>'bankadd'));?>">新增银行</a>
        </div>
        
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>