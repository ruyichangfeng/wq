<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">基本参数</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'running'));?>">运营设置</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'diy'));?>">个性化设置</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'question'));?>">常见问题</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'shuoming'));?>">服务说明</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('address', array('foo'=>'index'));?>">地区管理</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('lido', array('foo'=>'index'));?>">商圈管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('type', array('foo'=>'index'));?>">商铺类别</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'geren'));?>">个人加盟协议</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'fuwu'));?>">服务商加盟协议</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-info">
    	<div class="panel-heading">
                商圈列表
        </div>
        <?php  if($list[0]['id'] != '') { ?>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>商圈名称</td>
                        <td>描述</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $val['lido_name'];?></p>
                        </td>
                        <td>
                        	<p class="form-control-static"><?php  echo $val['remark'];?></p>
                        </td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('lido',array('foo'=>'add', 'id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('lido', array('foo'=>'dellido', 'id'=>$val['id']))?>" onClick="return confirm('确认删除吗?');"><i class="fa fa-remove"></i> 删除</a>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
        </div>
        <?php  } ?>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        
        <div class="panel-footer">
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('lido',array('foo'=>'add'));?>">新增商圈</a>
        </div>
        
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>